<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Director extends MY_Controller
{
    private $table = 't_director';
    public function __construct()
    {
        parent::__construct();
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Director',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data director'
        ];
        $this->admin_template->view('director/vw_director', $data);
    }

    public function load()
    {
        $this->db->select('t_director.*');
        $this->db->from($this->table);
        $this->db->order_by('t_director.id_director', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Director',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data director'
        ];

        $this->admin_template->view('director/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'email' => $this->input->post('email'),
            'name' => $this->input->post('name'),
            'no_hp' => $this->input->post('no_hp'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'director'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'director'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'email' => $this->input->post('email'),
            'name' => $this->input->post('name'),
            'no_hp' => $this->input->post('no_hp'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'director'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'director'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Director',
            'sidebar' => 'master-data',
            'heading' => 'Edit data director'
        ];


        $this->db->where('uuid', $uuid);
        $data['director'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('director/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'director'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'director'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'director'];
            }
        }
        echo json_encode($response);
    }
}
