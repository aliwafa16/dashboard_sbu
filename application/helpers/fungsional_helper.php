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
        $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

        return $result;
    }
}
