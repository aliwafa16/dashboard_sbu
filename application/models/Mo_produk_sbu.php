<?php
class Mo_produk_sbu extends CI_Model
{
    public $table = 't_product_sbu';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getById($uuid)
    {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }
}
