<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Automezzo_model extends AF_Model
{
  protected const TABLE = 'automezzo';

  protected function setColumnsInformation(&$fields)
  {
    $this->load->model('Filiale_model');

    parent::setColumnsInformation($fields);

    foreach ($fields as &$field) {
      switch ($field->name) {
        case 'codice_filiale':
          $field->input_type = 'select';
          $field->description = 'Filiale';
          $field->options = $this->Filiale_model->getRowsForSelect();
          $field->option_if_empty = [
            'value' => '',
            'label' => 'Non ci sono filiali'
          ];
          break;
      }
    }
  }
}
