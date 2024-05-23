<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('opn')) {
    function opn($value = '')
    {
        print "<pre>";
        print_r($value);
        print "</pre>";
    }
}


if (!function_exists('is_login')) {
    function is_login($value = '')
    {
        $ci = &get_instance();
        $is_login = $ci->session->userdata('is_login');
        if (!$is_login) {
            redirect('auth');
        }
    }
}
