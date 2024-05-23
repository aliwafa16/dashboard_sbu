<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];
        $this->load->view('vw_auth', $data);
    }


    public function login()
    {
        $response = [];
        $password = $this->input->post('password');
        $email = $this->input->post('email');

        $cekUser = $this->db->get_where('t_user', ['email' => $this->input->post('email')])->row_array();

        if ($cekUser) {

            $hash_password = sha1(md5($password));
            if ($hash_password == $cekUser['password']) {
                $data_session = [
                    'uuid' => $cekUser['uuid'],
                    'email' => $cekUser['email'],
                    'username' => $cekUser['username'],
                    'role_id' => $cekUser['role_id'],
                    'is_login' => true,
                    'data_director' => [],
                    'is_admin' => true,
                ];

                if (!empty($cekUser['director_id'])) {
                    $data_session['data_director'] = $this->db->get_where('t_director', ['id_director' => $cekUser['director_id']])->row_array();
                }

                if ($cekUser['role_id'] > 1) {
                    $data_session['is_admin'] = false;
                }

                $this->session->set_userdata($data_session);
                $response = ['code' => 200, 'status' => true, 'data' => $cekUser, 'message' => 'Berhasil login'];
            } else {
                $response = ['code' => 404, 'status' => false, 'data' => null, 'message' => 'user tidak ditemukan'];
            }
        } else {
            $response = ['code' => 404, 'status' => false, 'data' => null, 'message' => 'user tidak ditemukan'];
        }

        echo json_encode($response);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
