<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_sbu extends MY_Controller
{
    private $table = 't_sbu';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_director');
        $this->load->model('mo_sbu');
        $this->load->model('mo_target_sbu');
        $this->load->model('mo_produk_sbu');
        $this->load->model('mo_account_monitoring');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Master Strategic Business Unit',
            'sidebar' => 'master-sbu',
            'heading' => 'Daftar data SBU'
        ];
        $this->admin_template->view('master_sbu/vw_master_sbu', $data);
    }

    public function load()
    {
        $this->db->select('t_sbu.*, t_director.name as name_director');
        $this->db->from($this->table);
        $this->db->join('t_director', 't_sbu.director_id=t_director.id_director', 'LEFT');
        $this->db->order_by('t_sbu.id_sbu', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Master Strategic Business Unit',
            'sidebar' => 'master-sbu',
            'heading' => 'Tambah data SBU'
        ];
        $data['director'] = $this->mo_director->getAll();

        $this->admin_template->view('master_sbu/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'name_sbu' => $this->input->post('name_sbu'),
            'description' => $this->input->post('description'),
            'director_id' => $this->input->post('director_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];


        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $last_sbu_id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_sbu'
            ];
        } else {
            // Proses buat form Brand/SBU  Spesification
            $statusInsertForm =  $this->mo_account_monitoring->addFormSBUSpecification($last_sbu_id);
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'master_sbu'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'name_sbu' => $this->input->post('name_sbu'),
            'description' => $this->input->post('description'),
            'director_id' => $this->input->post('director_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'master_sbu'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'master_sbu'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Master Strategic Business Unit',
            'sidebar' => 'master-sbu',
            'heading' => 'Edit data SBU'
        ];

        $data['director'] = $this->mo_director->getAll();
        $this->db->where('uuid', $uuid);
        $data['sbu'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('master_sbu/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'master_sbu'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'master_sbu'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'master_sbu'];
            }
        }
        echo json_encode($response);
    }

    public function setting($uuid)
    {
        $data = [
            'title' => 'Master Strategic Business Unit',
            'sidebar' => 'master-sbu',
            'heading' => 'Setting data SBU'
        ];
        $this->db->where('uuid', $uuid);
        $data['sbu'] = $this->mo_sbu->getById($uuid);
        $data['director'] = $this->db->get_where('t_director', ['is_active' => 1, 'id_director' => $data['sbu']['director_id']])->row_array();
        $data['target'] = $this->db->get_where('t_target_sbu', ['is_active' => 1, 'sbu_id' => $data['sbu']['id_sbu']])->row_array();
        $this->admin_template->view('master_sbu/vw_detail', $data);
    }

    public function addTarget()
    {
        $response = [];

        $nominal = str_replace(',', '', $this->input->post('target'));

        $uuid = $this->input->post('uuid');
        $sbu = $this->mo_sbu->getById($uuid);
        $data_submit = [
            'target' => $nominal,
            'name_target' => $this->input->post('name_target'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'sbu_id' => $sbu['id_sbu'],
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert('t_target_sbu', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_sbu/setting/' . $uuid
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'master_sbu/setting/' . $uuid];
        }


        echo json_encode($response);
    }

    public function loadTarget($uuid)
    {
        $sbu = $this->mo_sbu->getById($uuid);


        $this->db->select('t_target_sbu.*');
        $this->db->from('t_target_sbu');
        $this->db->where('t_target_sbu.sbu_id', $sbu['id_sbu']);
        $this->db->order_by('t_target_sbu.id_target_sbu', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function getTarget($uuid)
    {
        $data = $this->mo_target_sbu->getById($uuid);
        echo json_encode($data);
    }

    public function hapusTarget()
    {
        $uuid = $this->input->post('uuid');
        $sbu_id = $this->input->post('sbu_id');

        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'master_sbu'
            ];
        } else {


            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete('t_target_sbu');
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'master_sbu/setting/' . $sbu_id];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'master_sbu/setting/' . $sbu_id];
            }
        }
        echo json_encode($response);
    }

    public function editTarget()
    {
        $response = [];

        $nominal = str_replace(',', '', $this->input->post('target'));

        $uuid = $this->input->post('uuid');
        $sbu = $this->db->get_where('t_sbu', ['id_sbu' => $this->input->post('sbu_id')])->row_array();
        $data_submit = [
            'target' => $nominal,
            'name_target' => $this->input->post('name_target'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'sbu_id' => $this->input->post('sbu_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('t_target_sbu', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'master_sbu/setting/' . $sbu['uuid']
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'master_sbu/setting/' . $sbu['uuid']];
        }


        echo json_encode($response);
    }

    public function addProduk()
    {
        $response = [];

        $nominal = str_replace(',', '', $this->input->post('target'));

        $uuid = $this->input->post('uuid');
        $sbu = $this->mo_sbu->getById($uuid);
        $data_submit = [
            'name_product' => $this->input->post('produk'),
            'description' => $this->input->post('description'),
            'sbu_id' => $sbu['id_sbu'],
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];





        $this->db->trans_start();
        $this->db->insert('t_product_sbu', $data_submit);
        $last_product_id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_sbu/setting/' . $uuid
            ];
        } else {
            // Proses buat form Brand/SBU  Spesification
            $statusInsertForm =  $this->mo_account_monitoring->addFormSBUProduct($last_product_id, $sbu['id_sbu']);

            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'master_sbu/setting/' . $uuid];
        }


        echo json_encode($response);
    }

    public function loadProduk($uuid)
    {
        $sbu = $this->mo_sbu->getById($uuid);


        $this->db->select('t_product_sbu.*');
        $this->db->from('t_product_sbu');
        $this->db->where('t_product_sbu.sbu_id', $sbu['id_sbu']);
        $this->db->order_by('t_product_sbu.id_product', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function getProduk($uuid)
    {
        $data = $this->mo_produk_sbu->getById($uuid);
        echo json_encode($data);
    }

    public function hapusProduk()
    {
        $uuid = $this->input->post('uuid');
        $sbu_id = $this->input->post('sbu_id');

        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'master_sbu'
            ];
        } else {


            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete('t_product_sbu');
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'master_sbu/setting/' . $sbu_id];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'master_sbu/setting/' . $sbu_id];
            }
        }
        echo json_encode($response);
    }

    public function editProduk()
    {
        $response = [];

        $nominal = str_replace(',', '', $this->input->post('target'));

        $uuid = $this->input->post('uuid');
        $sbu = $this->db->get_where('t_sbu', ['id_sbu' => $this->input->post('sbu_id')])->row_array();
        $data_submit = [
            'name_product' => $this->input->post('produk'),
            'description' => $this->input->post('description'),
            'sbu_id' => $sbu['id_sbu'],
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('t_product_sbu', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'master_sbu/setting/' . $sbu['uuid']
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'master_sbu/setting/' . $sbu['uuid']];
        }


        echo json_encode($response);
    }
}
