<?php if (!defined('BASEPATH')) exit('No direct script access allowed');




class Admin_template


{
    protected $ci_;

    function __construct()
    {
        $this->ci_ = &get_instance();
    }

    function view($content, $data = null)
    {
        $data['header'] = $this->ci_->load->view('template_admin/header', $data, TRUE);
        $data['sidebar'] = $this->ci_->load->view('template_admin/sidebar', $data, TRUE);
        $data['navbar'] = $this->ci_->load->view('template_admin/navbar', $data, TRUE);
        $data['content'] = $this->ci_->load->view($content, $data, TRUE);
        $data['footer'] = $this->ci_->load->view('template_admin/footer', $data, TRUE);
        $this->ci_->load->view('template_admin/app', $data);
    }
}
