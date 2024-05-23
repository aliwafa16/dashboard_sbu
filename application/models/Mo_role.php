<?php
class Mo_role extends CI_Model
{
    private $table = 't_role';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }
    public function getById($uuid)
    {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }
}
