<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filiale extends AF_Controller
{
  protected const TITLE = 'Filiali';
  protected const MODEL = 'Filiale_model';
  protected const UPLOAD_URL = 'https://edoo.poweringsrl.it/exercises/Filiale/upload.json';

  protected $delete_text = 'Sei sicuro di voler eliminare questa filiale? Anche tutti gli automezzi ad essa collegati verrano eliminati.';

  public function __construct()
  {
    parent::__construct();

    $this->rules = [
      [
        'field' => 'indirizzo',
        'label' => 'Indirizzo',
        'rules' => 'required|max_length[50]'
      ],
      [
        'field' => 'citta',
        'label' => 'Città',
        'rules' => 'required|max_length[50]'
      ],
      [
        'field' => 'cap',
        'label' => 'CAP',
        'rules' => 'required|integer|exact_length[5]'
      ]
    ];
  }

  public function new()
  {
    $this->form_validation->set_rules($this->rules);

    if ($this->form_validation->run() === true) {
      $this->{self::MODEL}->insert([
        'indirizzo' => $this->input->post('indirizzo'),
        'citta' => $this->input->post('citta'),
        'cap' => $this->input->post('cap')
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
          'indirizzo' => $this->input->post('indirizzo'),
          'citta' => $this->input->post('citta'),
          'cap' => $this->input->post('cap')
        ],
        $id
      );

      redirect('/' . $this->router->fetch_class() . '?view=' . $id);
    }

    parent::new();
  }
}
