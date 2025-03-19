<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AF_Model extends CI_Model
{
  protected const TABLE = '';

  public function insert($data)
  {
    $this->db->set($data);
    $this->db->insert(static::TABLE);
  }

  public function update($data, $primary_key)
  {
    $this->db->where($this->getPrimaryKey(), $primary_key);
    $this->db->set($data);
    $this->db->update(static::TABLE);
  }

  public function delete($primary_key)
  {
    $this->db->where($this->getPrimaryKey(), $primary_key);
    $this->db->delete(static::TABLE);
  }

  public function get($primary_key)
  {
    $this->db->where($this->getPrimaryKey(), $primary_key);

    $query = $this->db->get(static::TABLE);

    if ($query->num_rows() !== 1) {
      return false;
    }

    return $query->row_array();
  }

  public function getColumns()
  {
    $fields = $this->db->field_data(static::TABLE);

    $this->setColumnsInformation($fields);

    return $fields;
  }

  public function getRows()
  {
    $query = $this->db->get(static::TABLE);

    return $query->result_array();
  }

  protected function getPrimaryKey()
  {
    $fields = $this->db->field_data(static::TABLE);

    foreach ($fields as $field) {
      if ($field->primary_key) {
        return $field->name;
      }
    }

    return '';
  }

  protected function setColumnsInformation(&$fields)
  {
    foreach ($fields as &$field) {
      $field->description = ucfirst(trim(str_replace('_', ' ', $field->name)));

      $field->input_type = 'text';
      if ($field->type === 'int') {
        $field->input_type = 'number';
      }

      $field->options = [];
      $field->option_if_empty = [];
    }
  }
}
