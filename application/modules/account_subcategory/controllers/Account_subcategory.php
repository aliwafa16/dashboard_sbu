<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;;


class Account_subcategory extends MY_Controller
{
    private $table = 't_account_subcategory';
    private $wheres_listsbu;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_category_monitoring');
        $this->load->model('mo_subcategory_monitoring');
        $this->load->model('mo_sbu');
        is_login();
        $this->wheres_listsbu = wheres_listsbu();
    }
    public function index()
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data sub kategori monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $this->admin_template->view('account_subcategory/vw_account_subcategory', $data);
    }

    public function load()
    {
        $this->db->select('t_account_subcategory.*, t_category_monitoring.name_category_monitoring, t_sbu.name_sbu, t_product_sbu.name_product');
        $this->db->from($this->table);
        $this->db->join('t_category_monitoring', 't_account_subcategory.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->join('t_sbu', 't_account_subcategory.sbu_id=t_sbu.id_sbu');
        $this->db->join('t_product_sbu', 't_account_subcategory.product_id=t_product_sbu.id_product', 'LEFT');
        $this->db->where_in('t_account_subcategory.sbu_id', $this->wheres_listsbu);
        $this->db->order_by('t_account_subcategory.id_account_subcategory', 'DESC');
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data sub kategori monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->admin_template->view('account_subcategory/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'name_subcategory' => $this->input->post('name_subcategory'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'sbu_id' => $this->input->post('sbu_id'),
            'product_id' => $this->input->post('product_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'account_subcategory'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'account_subcategory'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'name_subcategory' => $this->input->post('name_subcategory'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'sbu_id' => $this->input->post('sbu_id'),
            'product_id' => $this->input->post('product_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'account_subcategory'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'account_subcategory'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Edit data sub kategori monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->db->where('uuid', $uuid);
        $data['subcategory'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('account_subcategory/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'account_subcategory'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'account_subcategory'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'account_subcategory'];
            }
        }
        echo json_encode($response);
    }

    public function copy()
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Copy data sub kategori monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $this->admin_template->view('account_subcategory/vw_copy', $data);
    }

    public function submitCopy()
    {
        $sumber_data = $this->input->post('sumber_data');
        $tujuan_data = $this->input->post('tujuan_data');

        $array_data = [];
        $subcategory = $this->db->get_where('t_account_subcategory', ['sbu_id' => $sumber_data])->result_array();
        if ($sumber_data == 0) {
            $subcategory = $this->mo_subcategory_monitoring->getAll();
        }

        foreach ($subcategory as $key => $value) {
            $data = [
                'category_monitoring_id' => $value['category_monitoring_id'],
                'name_subcategory' => ($value['name_subcategory']) ? $value['name_subcategory'] : $value['name_subcategory_monitoring'],
                'sbu_id' => $tujuan_data,
                'description' => $value['description'],
                'is_active' => $value['is_active'],
            ];

            $array_data[] = $data;
        }

        $this->db->trans_start();
        $this->db->insert_batch($this->table, $array_data);
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $response = ['status' => true, 'code' => 200, 'message' => 'Berhasil copy data', 'data' => '', 'url' => 'account_subcategory'];
        } else {
            $response = ['status' => false, 'code' => 400, 'message' => 'Gagal copy file', 'data' => '', 'url' => 'account_subcategory'];
        }

        echo json_encode($response);
    }

    public function unduhTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "KATEGORI ID");
        $sheet->setCellValue('B1', "NAMA SUB KATEGORI");
        $sheet->setCellValue('C1', "DESKRIPSI");
        $sheet->setCellValue('D1', "STATUS");
        $sheet->setTitle("File template");

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setCellValue('A1', "ID");
        $sheet2->setCellValue('B1', "Kategori");
        $sheet2->setTitle("Data Kategori");

        // Get data kategori
        $dataCategory = $this->mo_category_monitoring->getAll();
        $row = 2;
        foreach ($dataCategory as $key => $value) {
            $sheet2->setCellValue('A' . $row, $value['id_category_monitoring']);
            $sheet2->setCellValue('B' . $row, $value['name_category_monitoring']);
            $row++;
        }


        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setCellValue('A1', "ID");
        $sheet3->setCellValue('B1', "Status");
        $sheet3->setCellValue('A2', 1);
        $sheet3->setCellValue('B2', 'Aktif');
        $sheet3->setCellValue('A3', 2);
        $sheet3->setCellValue('B3', 'Tidak aktif');
        $sheet3->setTitle("Data Status");


        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_upload.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function import()
    {
        $response = [];
        $this->load->helper('file');

        $sbu_id = $this->input->post('sbu_id');

        /* Allowed MIME(s) File */
        $file_mimes = array(
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/excel',
            'application/vnd.msexcel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        if (isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {

            $array_file = explode('.', $_FILES['file_excel']['name']);
            $extension  = end($array_file);

            $reader = new XlsxReader;


            $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
            $sheet_data  = $spreadsheet->getActiveSheet(0)->toArray();
            // var_dump($sheet_data);
            $jmlDataExcel = count($sheet_data) - 1;
            $array_data  = [];

            for ($i = 1; $i < count($sheet_data); $i++) {
                $data = array(
                    'sbu_id' => $sbu_id,
                    'category_monitoring_id' => $sheet_data[$i]['0'],
                    'name_subcategory' => $sheet_data[$i]['1'],
                    'description'        => $sheet_data[$i]['2'],
                    'is_active' => $sheet_data[$i]['3']
                );
                $array_data[] = $data;
            }

            $this->db->trans_start();
            $this->db->insert_batch($this->table, $array_data);
            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $response = ['status' => true, 'code' => 200, 'message' => 'Berhasil upload ' . $jmlDataExcel . ' data', 'data' => ''];
            } else {
                $response = ['status' => false, 'code' => 400, 'message' => 'Gagal import file', 'data' => ''];
            }
        } else {
            $response = ['status' => false, 'code' => 400, 'message' => 'Format file tidak sesuai', 'data' => ''];
        }

        echo json_encode($response);
    }
}
