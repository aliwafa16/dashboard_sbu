<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    private $table = 't_user';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_role');
        $this->load->model('mo_director');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'User',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data user'
        ];
        $this->admin_template->view('user/vw_user', $data);
    }

    public function load()
    {
        $this->db->select('t_user.*, t_role.role');
        $this->db->from($this->table);
        $this->db->join('t_role', 't_user.role_id=t_role.id_role');
        $this->db->order_by('t_user.id_user', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'User',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data user'
        ];
        $data['role'] = $this->mo_role->getAll();
        $data['director'] = $this->mo_director->getAll();

        $this->admin_template->view('user/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];
        $password = $this->input->post('password');
        $re_password = $this->input->post('re_password');


        if ($password != $re_password) {
            $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Password tidak sama', 'url' => 'user'];
        } else {
            $data_submit = [
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'role_id' => $this->input->post('role_id'),
                'director_id' => $this->input->post('director_id'),
                'password' => sha1(md5($password)),
                'is_active' => ($this->input->post('is_active')) ? 1 : 0
            ];

            $this->db->trans_start();
            $this->db->insert($this->table, $data_submit);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $response = [
                    'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'user'
                ];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'user'];
            }
        }

        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'role_id' => $this->input->post('role_id'),
            'director_id' => $this->input->post('director_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'user'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'user'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'User',
            'sidebar' => 'master-data',
            'heading' => 'Edit data user'
        ];
        $data['role'] = $this->mo_role->getAll();
        $data['director'] = $this->mo_director->getAll();

        $this->db->where('uuid', $uuid);
        $data['user'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('user/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'user'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'user'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'user'];
            }
        }
        echo json_encode($response);
    }

    public function changePassword()
    {
        $response = [];
        $password = $this->input->post('password');
        $re_password = $this->input->post('re_password');
        $uuid = $this->input->post('uuid');


        if ($password != $re_password) {
            $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Password tidak sama', 'url' => 'user'];
        } else {
            $data_submit = [
                'password' => sha1(md5($password)),
            ];

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->update($this->table, $data_submit);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $response = [
                    'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'user'
                ];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'user'];
            }
        }

        echo json_encode($response);
    }
}
