<?php
class Mo_target_sbu extends CI_Model
{
    public $table = 't_target_sbu';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getById($uuid)
    {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }
}
