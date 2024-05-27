<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;;


class Account_item extends MY_Controller
{
    private $table = 't_account_item';
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
            'title' => 'Item Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data item monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $this->admin_template->view('account_item/vw_account_item', $data);
    }

    public function load()
    {
        $this->db->select('t_account_item.*, t_category_monitoring.name_category_monitoring, t_sbu.name_sbu, t_product_sbu.name_product, t_account_subcategory.name_subcategory');
        $this->db->from($this->table);
        $this->db->join('t_category_monitoring', 't_account_item.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->join('t_account_subcategory', 't_account_item.subcategory_account_id=t_account_subcategory.id_account_subcategory');
        $this->db->join('t_sbu', 't_account_item.sbu_id=t_sbu.id_sbu');
        $this->db->join('t_product_sbu', 't_account_item.product_id=t_product_sbu.id_product', 'LEFT');
        $this->db->where_in('t_account_item.sbu_id', $this->wheres_listsbu);
        $this->db->order_by('t_account_item.id_account_item', 'DESC');
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Item Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data item monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->admin_template->view('account_item/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'item_monitoring' => $this->input->post('item_monitoring'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'subcategory_account_id' => $this->input->post('subcategory_account_id'),
            'sbu_id' => $this->input->post('sbu_id'),
            'product_id' => $this->input->post('product_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'account_item'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'account_item'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'item_monitoring' => $this->input->post('item_monitoring'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'subcategory_account_id' => $this->input->post('subcategory_account_id'),
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
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'account_item'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'account_item'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Item Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Edit data item monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->db->where('uuid', $uuid);
        $data['item_account'] = $this->db->get($this->table)->row_array();

        $data['subcategory_monitoring'] = $this->db->get_where('t_account_subcategory', ['sbu_id' => $data['item_account']['sbu_id']])->result_array();
        $this->admin_template->view('account_item/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'account_item'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'account_item'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'account_item'];
            }
        }
        echo json_encode($response);
    }

    public function copy()
    {
        $data = [
            'title' => 'Item Monitoring',
            'sidebar' => 'master-data',
            'heading' => 'Copy data item monitoring'
        ];
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $this->admin_template->view('account_item/vw_copy', $data);
    }

    public function submitCopy()
    {
        $sumber_data = $this->input->post('sumber_data');
        $tujuan_data = $this->input->post('tujuan_data');

        $array_data = [];
        $subcategory = $this->db->get_where('t_account_item', ['sbu_id' => $sumber_data])->result_array();
        if ($sumber_data == 0) {
            $subcategory = $this->db->get('t_item_monitoring')->result_array();
        }

        foreach ($subcategory as $key => $value) {
            $data = [
                'category_monitoring_id' => $value['category_monitoring_id'],
                'subcategory_account_id' => ($value['subcategory_account_id']) ? $value['subcategory_account_id'] : $value['subcategory_monitoring_id'],
                'item_monitoring' => $value['item_monitoring'],
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
            $response = ['status' => true, 'code' => 200, 'message' => 'Berhasil copy data', 'data' => '', 'url' => 'account_item'];
        } else {
            $response = ['status' => false, 'code' => 400, 'message' => 'Gagal copy file', 'data' => '', 'url' => 'account_item'];
        }

        echo json_encode($response);
    }

    public function getSubCategoryByCategory()
    {
        $id_category = $this->input->post('id');
        $id_sbu = $this->input->post('sbu_id');
        $data = $this->db->get_where('t_account_subcategory', ['category_monitoring_id' => $id_category, 'sbu_id' => $id_sbu])->result_array();
        echo json_encode($data);
    }

    public function unduhTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "KATEGORI ID");
        $sheet->setCellValue('B1', "SUB KATEGORI ID");
        $sheet->setCellValue('C1', "NAMA ITEM MONITORING");
        $sheet->setCellValue('D1', "DESKRIPSI");
        $sheet->setCellValue('E1', "STATUS");
        $sheet->setTitle("File template");

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setCellValue('A1', "Kategori ID");
        $sheet2->setCellValue('B1', 'ID');
        $sheet2->setCellValue('C1', "Sub Kategori");
        $sheet2->setTitle("Data Sub Kategori");

        // Get data kategori
        $this->db->where_in('t_account_subcategory.sbu_id', $this->wheres_listsbu);
        $dataCategory = $this->db->get('t_account_subcategory')->result_array();
        $row = 2;
        foreach ($dataCategory as $key => $value) {
            $sheet2->setCellValue('A' . $row, $value['category_monitoring_id']);
            $sheet2->setCellValue('B' . $row, $value['id_account_subcategory']);

            $sheet2->setCellValue('C' . $row, $value['name_subcategory']);
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
                    'subcategory_account_id' => $sheet_data[$i]['1'],
                    'item_monitoring' => $sheet_data[$i]['2'],
                    'description'        => $sheet_data[$i]['3'],
                    'is_active' => $sheet_data[$i]['4']
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
