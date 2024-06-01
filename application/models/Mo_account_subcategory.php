<?php
class Mo_account_subcategory extends CI_Model
{
    public $table = 't_account_subcategory';
    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getById($uuid)
    {
        return $this->db->get_where($this->table, ['uuid' => $uuid])->row_array();
    }

    public function getBySbuID($id)
    {
        return $this->db->get_where($this->table, ['sbu_id' => $id])->result_array();
    }

    public function getItemSBUSpecification($id_category_monitoring, $id_account_subcategory, $sbu_id)
    {
        return $this->db->get_where($this->table, ['category_monitoring_id' => $id_category_monitoring, 'id_account_subcategory' => $id_account_subcategory, 'sbu_id' => $sbu_id])->result_array();
    }
}
