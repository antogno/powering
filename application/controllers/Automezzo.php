<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Automezzo extends AF_Controller
{
  protected const TITLE = 'Automezzi';
  protected const MODEL = 'Automezzo_model';
  protected const UPLOAD_URL = 'https://edoo.poweringsrl.it/exercises/Automezzo/upload.json';

  protected $delete_text = 'Sei sicuro di voler eliminare questo automezzo?';

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Filiale_model');

    $this->rules = [
      [
        'field' => 'codice_filiale',
        'label' => 'Filiale',
        'rules' => 'required|numeric|in_list[' . $this->Filiale_model->getImplodedList() . ']'
      ],
      [
        'field' => 'targa',
        'label' => 'Targa',
        'rules' => 'required|regex_match[/[a-zA-Z]{2}[0-9]{3,4}[a-zA-Z]{2}/]|exact_length[7]'
      ],
      [
        'field' => 'marca',
        'label' => 'Marca',
        'rules' => 'required|max_length[50]'
      ],
      [
        'field' => 'modello',
        'label' => 'Modello',
        'rules' => 'required|max_length[50]'
      ]
    ];
  }

  public function new()
  {
    $this->form_validation->set_rules($this->rules);

    if ($this->form_validation->run() === true) {
      $this->{self::MODEL}->insert([
        'codice_filiale' => $this->input->post('codice_filiale'),
        'targa' => strtoupper($this->input->post('targa')),
        'marca' => $this->input->post('marca'),
        'modello' => $this->input->post('modello')
      ]);

      redirect('/' . $this->router->fetch_class());
    }

    parent::new();
  }

  public function edit()
  {
    $this->form_validation->set_rules($this->rules);

    $id = $this->input->get('id') ?? $this->input->post('id');

    if (
      !$id
      || $this->{self::MODEL}->get($id) === false
    ) {
      redirect('/' . $this->router->fetch_class());
    }

    if (
      $id
      && $this->form_validation->run() === true
    ) {
      $this->{self::MODEL}->update(
        [
          'codice_filiale' => $this->input->post('codice_filiale'),
          'targa' => strtoupper($this->input->post('targa')),
          'marca' => $this->input->post('marca'),
          'modello' => $this->input->post('modello')
        ],
        $id
      );

      redirect('/' . $this->router->fetch_class() . '?view=' . $id);
    }

    parent::new();
  }
}
