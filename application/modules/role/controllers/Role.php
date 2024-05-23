<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends MY_Controller
{
    private $table = 't_role';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_role');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Role',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data role'
        ];
        $this->admin_template->view('role/vw_role', $data);
    }

    public function load()
    {
        $this->db->select('t_role.*');
        $this->db->from($this->table);
        $this->db->order_by('id_role', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Role',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data role'
        ];
        $this->admin_template->view('role/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'role' => $this->input->post('role'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'role'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'role'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'role' => $this->input->post('role'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'role'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'role'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Role',
            'sidebar' => 'master-data',
            'heading' => 'Edit data role'
        ];
        $this->db->where('uuid', $uuid);
        $data['role'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('role/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'role'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'role'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'role'];
            }
        }
        echo json_encode($response);
    }
}
