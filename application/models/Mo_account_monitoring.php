<?php
class Mo_account_monitoring extends CI_Model
{

    public function getFormSBUSpecificationByUUID($uuid)
    {
        return $this->db->get_where('t_monitoring_sbu', ['uuid' => $uuid])->row_array();
    }
    public function getFormSBUSpecification($array_sbu_id, $wheres_formSbuSpecification)
    {
        $this->db->select('t_monitoring_sbu.*, t_category_monitoring.name_category_monitoring, t_account_subcategory.name_subcategory, t_master_status.status as status_name, t_master_status.color, t_master_pic.pic as pic_name, t_ukuran_satuan.ukuran_satuan');
        $this->db->from('t_monitoring_sbu');
        $this->db->join('t_category_monitoring', 't_monitoring_sbu.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->join('t_account_subcategory', 't_monitoring_sbu.subcategory_monitoring_id=t_account_subcategory.id_account_subcategory');
        $this->db->join('t_master_status', 't_monitoring_sbu.status=t_master_status.id_master_status');
        $this->db->join('t_master_pic', 't_monitoring_sbu.assigned_to=t_master_pic.id_master_pic');
        $this->db->join('t_ukuran_satuan', 't_monitoring_sbu.target_unit=t_ukuran_satuan.id_ukuran_satuan');
        // $this->db->join('t_sbu', 't_monitoring_sbu.sbu_id=t_sbu.id_sbu');
        $this->db->where_in('t_monitoring_sbu.sbu_id', $array_sbu_id);
        $this->db->where('t_monitoring_sbu.category_monitoring_id', 1);
        $this->db->where_in('t_monitoring_sbu.subcategory_monitoring_id', $wheres_formSbuSpecification);
        // $this->db->where_in('t_account_subcategory.sbu_id', $array_sbu_id);
        $this->db->where('t_monitoring_sbu.quater_id', NULL);
        return $this->db->get()->result_array();
    }
    public function addFormSBUSpecification($sbu_id)
    {
        $statusInsert = "";
        // copy subcategory
        $this->db->where('category_monitoring_id', 1);
        $this->db->where('id_subcategory_monitoring', 1);
        $master_subcategory = $this->db->get('t_subcategory_monitoring')->row_array();


        // Insert t_account_subcategory
        $data_account_subcategory = [
            'sbu_id' => $sbu_id,
            'category_monitoring_id' => $master_subcategory['category_monitoring_id'],
            'name_subcategory' => $master_subcategory['name_subcategory_monitoring'],
            'description' => $master_subcategory['description'],
            'is_active' => $master_subcategory['is_active']
        ];


        $this->db->insert('t_account_subcategory', $data_account_subcategory);
        $id_account_subcategory = $this->db->insert_id();


        // Proses input item monitoring;
        $this->db->where('category_monitoring_id', 1);
        $this->db->where('subcategory_monitoring_id', 1);
        $master_item_monitoring = $this->db->get('t_item_monitoring')->result_array();

        $data_account_monitoring = [];
        foreach ($master_item_monitoring as $key => $value) {
            $row = [];
            $row['sbu_id'] = $sbu_id;
            $row['category_monitoring_id'] = $value['category_monitoring_id'];
            $row['subcategory_monitoring_id'] = $id_account_subcategory;
            $row['name_tools'] = $value['item_monitoring'];
            $row['status'] = 1;
            $row['target_rate'] = 1;
            $row['assigned_to'] = 5;
            $row['target_unit'] = 13;
            $row['target_rate'] = 1;
            $row['actual'] = 0;
            $row['percentage'] = 0;
            $data_account_monitoring[] = $row;
        }

        $this->db->trans_start();
        $this->db->insert_batch('t_monitoring_sbu', $data_account_monitoring);
        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $statusInsert = false;
        } else {
            $statusInsert = true;
        }


        return $statusInsert;
    }

    public function addFormSBUProduct($product_id, $sbu_id)
    {
        // get product
        $master_product = $this->db->get_where('t_product_sbu', ['id_product' => $product_id])->row_array();

        // copy subcategory
        $this->db->where('category_monitoring_id', 1);
        $this->db->where('id_subcategory_monitoring', 2);
        $master_subcategory = $this->db->get('t_subcategory_monitoring')->row_array();

        // Mengganti "Name of Variant" dengan nilai variabel nama produk
        $subcategory_name = str_replace("(Name of Variant)", $master_product['name_product'], $master_subcategory['name_subcategory_monitoring']);


        // Insert t_account_subcategory
        $data_account_subcategory = [
            'sbu_id' => $sbu_id,
            'category_monitoring_id' => $master_subcategory['category_monitoring_id'],
            'name_subcategory' => $subcategory_name,
            'description' => $master_subcategory['description'],
            'is_active' => $master_subcategory['is_active'],
            'product_id' => $product_id
        ];

        $this->db->insert('t_account_subcategory', $data_account_subcategory);
        $id_account_subcategory = $this->db->insert_id();


        // Proses input item monitoring;
        $this->db->where('category_monitoring_id', 1);
        $this->db->where('subcategory_monitoring_id', 2);
        $master_item_monitoring = $this->db->get('t_item_monitoring')->result_array();

        $data_account_monitoring = [];
        foreach ($master_item_monitoring as $key => $value) {
            $row = [];
            $row['sbu_id'] = $sbu_id;
            $row['category_monitoring_id'] = $value['category_monitoring_id'];
            $row['subcategory_monitoring_id'] = $id_account_subcategory;
            $row['name_tools'] = $value['item_monitoring'];
            $row['status'] = 1;
            $row['target_rate'] = 1;
            $row['assigned_to'] = 5;
            $row['target_unit'] = 13;
            $row['target_rate'] = 1;
            $row['actual'] = 0;
            $row['percentage'] = 0;
            $data_account_monitoring[] = $row;
        }

        $this->db->trans_start();
        $this->db->insert_batch('t_monitoring_sbu', $data_account_monitoring);
        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $statusInsert = false;
        } else {
            $statusInsert = true;
        }


        return $statusInsert;
    }
    public function getFormSBUProduct($array_sbu_id, $wheres_formSbuProduct)
    {
        $this->db->select('t_monitoring_sbu.*, t_category_monitoring.name_category_monitoring, t_account_subcategory.name_subcategory, t_master_status.status as status_name, t_master_status.color, t_master_pic.pic as pic_name, t_ukuran_satuan.ukuran_satuan');
        $this->db->from('t_monitoring_sbu');
        $this->db->join('t_category_monitoring', 't_monitoring_sbu.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->join('t_account_subcategory', 't_monitoring_sbu.subcategory_monitoring_id=t_account_subcategory.id_account_subcategory');
        $this->db->join('t_master_status', 't_monitoring_sbu.status=t_master_status.id_master_status');
        $this->db->join('t_master_pic', 't_monitoring_sbu.assigned_to=t_master_pic.id_master_pic');
        $this->db->join('t_ukuran_satuan', 't_monitoring_sbu.target_unit=t_ukuran_satuan.id_ukuran_satuan');
        $this->db->join('t_product_sbu', 't_account_subcategory.product_id=t_product_sbu.id_product');
        // $this->db->join('t_sbu', 't_monitoring_sbu.sbu_id=t_sbu.id_sbu');
        $this->db->where_in('t_monitoring_sbu.sbu_id', $array_sbu_id);
        $this->db->where('t_monitoring_sbu.category_monitoring_id', 1);
        // $this->db->where_in('t_account_subcategory.sbu_id', $array_sbu_id);
        $this->db->where('t_monitoring_sbu.quater_id', NULL);
        return $this->db->get()->result_array();
    }
}
