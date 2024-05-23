<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'sidebar' => 'dashboard'
        ];
        $this->admin_template->view('dashboard/vw_dashboard', $data);
    }
}
