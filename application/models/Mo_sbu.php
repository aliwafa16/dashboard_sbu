<?php
class Mo_sbu extends CI_Model
{
    public $table = 't_sbu';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getById($uuid)
    {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }

    public function getListSbu($array)
    {
        $this->db->where_in('t_sbu.id_sbu', $array);
        return $this->db->get($this->table)->result_array();
    }
}
