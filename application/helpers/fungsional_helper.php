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

if (!function_exists('session_listsbu')) {
    function session_listsbu($value = '')
    {
        $ci = &get_instance();
        $director_id = $ci->session->userdata('data_director')['id_director'];
        return $ci->db->get_where('t_sbu', ['director_id' => $director_id])->result_array();
    }
}

if (!function_exists('wheres_listsbu')) {
    function wheres_listsbu($value = '')
    {
        $ci = &get_instance();
        $director_id = $ci->session->userdata('data_director')['id_director'];
        $data = $ci->db->get_where('t_sbu', ['director_id' => $director_id])->result_array();
        $results = [];
        foreach ($data as $key => $value) {
            $results[] = $value['id_sbu'];
        }
        return $results;
    }
}

if (!function_exists('subcategory_formSbuSpecification')) {
    function subcategory_formSbuSpecification($value = '')
    {
        $results = [];
        $ci = &get_instance();
        $director_id = $ci->session->userdata('data_director')['id_director'];
        $data = $ci->db->get_where('t_sbu', ['director_id' => $director_id])->result_array();
        $b = [];
        foreach ($data as $key => $value) {
            $b[] = $value['id_sbu'];
        }

        $ci->db->where_in('t_account_subcategory.sbu_id', $b);
        $ci->db->where('t_account_subcategory.product_id', NULL);
        $ci->db->where('t_account_subcategory.category_monitoring_id', 1);
        $a = $ci->db->get('t_account_subcategory')->result_array();

        foreach ($a as $key => $value) {
            $results[] = $value['id_account_subcategory'];
        }
        return $results;
    }
}


if (!function_exists('subcategory_formSbuSProduct')) {
    function subcategory_formSbuSProduct($value = '')
    {
        $results = [];
        $ci = &get_instance();
        $director_id = $ci->session->userdata('data_director')['id_director'];
        $data = $ci->db->get_where('t_sbu', ['director_id' => $director_id])->result_array();
        $b = [];
        foreach ($data as $key => $value) {
            $b[] = $value['id_sbu'];
        }

        $ci->db->where_in('t_account_subcategory.sbu_id', $b);
        $ci->db->where('t_account_subcategory.product_id !=', NULL);
        $ci->db->where('t_account_subcategory.category_monitoring_id', 1);
        $a = $ci->db->get('t_account_subcategory')->result_array();

        foreach ($a as $key => $value) {
            $results[] = $value['id_account_subcategory'];
        }
        return $results;
    }
}

if (!function_exists('tgl_format_indo')) {
    function tgl_format_indo($date)
    {
        date_default_timezone_set('Asia/Jakarta');
        // array hari dan bulan
        $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        // pemisahan tahun, bulan, hari, dan waktu
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        $waktu = substr($date, 11, 5);
        $hari = date("w", strtotime($date));
        $result = $tgl . " " . $Bulan[(int) $bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}
