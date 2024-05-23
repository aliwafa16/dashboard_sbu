<?php
class Mo_director extends CI_Model
{
    public $table = 't_director';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }
}
