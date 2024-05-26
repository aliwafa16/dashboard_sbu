<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_status extends MY_Controller
{
    private $table = 't_master_status';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_role');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Status Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Daftar data status monitoring'
        ];
        $this->admin_template->view('master_status/vw_master_status', $data);
    }

    public function load()
    {
        $this->db->select('t_master_status.*');
        $this->db->from($this->table);
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Status Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Tambah data status monitoring'
        ];
        $this->admin_template->view('master_status/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'status' => $this->input->post('status'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_status'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'master_status'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'status' => $this->input->post('status'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_status'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'master_status'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Status Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Edit data status monitoring'
        ];
        $this->db->where('uuid', $uuid);
        $data['master_status'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('master_status/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'master_status'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'master_status'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'master_status'];
            }
        }
        echo json_encode($response);
    }
}
