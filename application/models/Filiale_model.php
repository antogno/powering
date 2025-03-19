<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Filiale_model extends AF_Model
{
  protected const TABLE = 'filiale';

  public function getRowsForSelect()
  {
    $rows = $this->getRows();

    $primary_key = $this->getPrimaryKey();

    $options = [];
    foreach ($rows as $row) {
      $id = $row[$primary_key];

      $options[] = [
        'value' => $id,
        'label' => implode(', ', $this->get($id))
      ];
    }

    return $options;
  }

  public function getImplodedList()
  {
    $rows = $this->getRows();

    $primary_key = $this->getPrimaryKey();

    return implode(',', array_column($rows, $primary_key));
  }

  protected function setColumnsInformation(&$fields)
  {
    parent::setColumnsInformation($fields);

    foreach ($fields as &$field) {
      switch ($field->name) {
        case 'cap':
          $field->description = strtoupper($field->description);
          break;
        case 'citta':
          $field->description = substr_replace($field->description, 'à', -1);
          break;
      }
    }
  }
}
