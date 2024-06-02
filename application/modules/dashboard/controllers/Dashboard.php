<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    private $wheres_listsbu;
    private $wheres_formSbuSpecification;
    private $wheres_formSbuProduct;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_sbu');
        $this->load->model('mo_account_monitoring');
        // $this->wheres_listsbu = wheres_listsbu();
        // $this->wheres_formSbuSpecification = subcategory_formSbuSpecification();
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'sidebar' => 'dashboard'
        ];

        // SBU terdaftar
        $data['sbu_terdaftar'] = $this->db->count_all('t_sbu');
        $this->admin_template->view('dashboard/vw_dashboard', $data);
    }

    public function load_last_activity()
    {
        $date = date('Y-m-d');
        $start_time = $date . ' 00:00:00';
        $end_time = $date . ' 23:59:59';



        $this->db->select('t_monitoring_sbu.*, t_category_monitoring.name_category_monitoring, t_account_subcategory.name_subcategory, t_master_status.status as status_name, t_master_status.color, t_master_pic.pic as pic_name, t_ukuran_satuan.ukuran_satuan, t_sbu.name_sbu');
        $this->db->from('t_monitoring_sbu');
        $this->db->join('t_category_monitoring', 't_monitoring_sbu.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->join('t_account_subcategory', 't_monitoring_sbu.subcategory_monitoring_id=t_account_subcategory.id_account_subcategory');
        $this->db->join('t_master_status', 't_monitoring_sbu.status=t_master_status.id_master_status');
        $this->db->join('t_master_pic', 't_monitoring_sbu.assigned_to=t_master_pic.id_master_pic');
        $this->db->join('t_ukuran_satuan', 't_monitoring_sbu.target_unit=t_ukuran_satuan.id_ukuran_satuan');
        $this->db->join('t_sbu', 't_monitoring_sbu.sbu_id=t_sbu.id_sbu');
        // $this->db->where_in('t_account_subcategory.sbu_id', $array_sbu_id);
        // Membuat query dengan rentang waktu
        $this->db->where('t_monitoring_sbu.updated_on >=', $start_time);
        $this->db->where('t_monitoring_sbu.updated_on <=', $end_time);
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function detail($uuid)
    {

        $data = [
            'title' => 'Master Strategic Business Unit',
            'sidebar' => 'master-sbu',
            'heading' => 'Detail data SBU'
        ];
        $this->db->where('uuid', $uuid);
        $data['sbu'] = $this->mo_sbu->getById($uuid);
        $data['director'] = $this->db->get_where('t_director', ['is_active' => 1, 'id_director' => $data['sbu']['director_id']])->row_array();
        $data['target'] = $this->db->get_where('t_target_sbu', ['is_active' => 1, 'sbu_id' => $data['sbu']['id_sbu']])->row_array();


        // SBU Specification
        $this->wheres_listsbu = array(0 => $data['sbu']['id_sbu']);

        $this->db->where_in('t_account_subcategory.sbu_id', $this->wheres_listsbu);
        $this->db->where('t_account_subcategory.product_id', NULL);
        $this->db->where('t_account_subcategory.category_monitoring_id', 1);
        $a = $this->db->get('t_account_subcategory')->result_array();

        foreach ($a as $key => $value) {
            $this->wheres_formSbuSpecification[] = $value['id_account_subcategory'];
        }


        $data['formSbu'] = $this->mo_account_monitoring->getFormSBUSpecification($this->wheres_listsbu, $this->wheres_formSbuSpecification);
        $result = array();
        foreach ($data['formSbu'] as $element) {
            $result[$element['sbu_id']][] = $element;
        }
        $finals = [];
        $masterSbu = $this->db->get_where('t_sbu', ['uuid' => $uuid])->result_array();
        foreach ($masterSbu as $key => $value) {
            $value['category_name'] = $result[$value['id_sbu']][0]['name_category_monitoring'];
            $value['subcategory_name'] = $result[$value['id_sbu']][0]['name_subcategory'];
            $value['list_monitoring'] = $result[$value['id_sbu']];
            $finals[] = $value;
        }
        $data['forms'] = $finals;



        // Product
        $this->db->select('t_product_sbu.*, t_account_subcategory.id_account_subcategory');
        $this->db->from('t_product_sbu');
        $this->db->join('t_account_subcategory', 't_product_sbu.id_product=t_account_subcategory.product_id');
        $this->db->where_in('t_product_sbu.sbu_id', $this->wheres_listsbu);
        $data['product'] = $this->db->get()->result_array();

        $this->db->where_in('t_account_subcategory.sbu_id', $this->wheres_listsbu);
        $this->db->where('t_account_subcategory.product_id !=', NULL);
        $this->db->where('t_account_subcategory.category_monitoring_id', 1);
        $b = $this->db->get('t_account_subcategory')->result_array();

        foreach ($a as $key => $value) {
            $this->wheres_formSbuProduct[] = $value['id_account_subcategory'];
        }

        $data['formProduk'] = $this->mo_account_monitoring->getFormSBUProduct($this->wheres_listsbu, $this->wheres_formSbuProduct);
        $result = array();
        foreach ($data['formProduk'] as $element) {
            $result[$element['subcategory_monitoring_id']][] = $element;
        }

        $finals_produk = [];
        foreach ($data['product'] as $key => $value) {
            // var_dump($value);
            $value['category_name'] = $result[$value['id_account_subcategory']][0]['name_category_monitoring'];
            $value['subcategory_name'] = $result[$value['id_account_subcategory']][0]['name_subcategory'];
            $value['list_monitoring'] = $result[$value['id_account_subcategory']];
            $finals_produk[] = $value;
        }
        $data['formProduk'] = $finals_produk;
        $this->admin_template->view('dashboard/vw_details', $data);
    }
}
