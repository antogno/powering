<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AF_Api_Controller extends AF_Controller
{
  protected const MODEL = '';
  protected const UPLOAD_URL = '';

  public function index()
  {
    $this->output
      ->set_content_type('application/json')
      ->set_status_header(200)
      ->set_output(
        json_encode([
          'success' => true,
          'data' => $this->{static::MODEL}->getRows()
        ], JSON_FORCE_OBJECT)
      );
  }

  public function upload()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    $success = false;
    $message = 'Il caricamento non è andato a buon fine.';

    if ($this->form_validation->run() === false) {
      $message = strip_tags(str_replace(["\r", "\n"], '', validation_errors())) ?: $message;
    } elseif (empty(static::UPLOAD_URL)) {
      $message = 'Nessun URL impostato per il caricamento.';
    } elseif (!is_callable('curl_init')) {
      $message = 'L\'estensione CURL non è installata o abilitata nell\'installazione PHP corrente.';
    } else {
      $params = [
        'email' => $this->input->post('email'),
        'data' => $this->{static::MODEL}->getRows()
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, static::UPLOAD_URL);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

      $output = curl_exec($ch);

      if ($output !== false) {
        json_decode($output);
        $message = 'La risposta ottenuta non è in formato JSON. Impossibile stabilire se il caricamento è stato effettuato con successo.';
        if (json_last_error() === JSON_ERROR_NONE) {
          $json = json_decode($output, true);

          // Se la chiamata è stata effettuata e ritorna un codice di stato HTTP di tipo 2xx, vuol dire che ha avuto successo
          $success = strpos(curl_getinfo($ch, CURLINFO_HTTP_CODE), '2') === 0 ? true : false;

          $message = $success ? 'OK.' : 'Errore.';
          if (isset($json['message'])) {
            $message = $json['message'];
          }
        }
      }

      curl_close($ch);
    }

    $this->output
      ->set_content_type('application/json')
      ->set_status_header($success ? 200 : 500)
      ->set_output(
        json_encode([
          'success' => $success,
          'message' => $message
        ], JSON_FORCE_OBJECT)
      );
  }
}
