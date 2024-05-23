<?php
class Mo_role extends CI_Model
{
    private $table = 't_role';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }
}
