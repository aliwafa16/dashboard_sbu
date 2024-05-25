<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;;


class Item_monitoring extends MY_Controller
{
    private $table = 't_item_monitoring';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_category_monitoring');
        $this->load->model('mo_subcategory_monitoring');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Item monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Daftar data item monitoring'
        ];
        $this->admin_template->view('item_monitoring/vw_item_monitoring', $data);
    }

    public function load()
    {
        $this->db->select('t_item_monitoring.*, t_category_monitoring.name_category_monitoring, t_subcategory_monitoring.name_subcategory_monitoring');
        $this->db->from($this->table);
        $this->db->join('t_subcategory_monitoring', 't_subcategory_monitoring.id_subcategory_monitoring=t_item_monitoring.subcategory_monitoring_id');
        $this->db->join('t_category_monitoring', 't_category_monitoring.id_category_monitoring=t_subcategory_monitoring.category_monitoring_id');
        $this->db->order_by('t_category_monitoring.sort', 'ASC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Item monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Tambah data item monitoring'
        ];
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();
        $data['subcategory_monitoring'] = $this->mo_subcategory_monitoring->getAll();
        $this->admin_template->view('item_monitoring/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'item_monitoring' => $this->input->post('item_monitoring'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'subcategory_monitoring_id' => $this->input->post('subcategory_monitoring_id'),
            'description' => $this->input->post('description'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'item_monitoring'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'item_monitoring'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'item_monitoring' => $this->input->post('item_monitoring'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'subcategory_monitoring_id' => $this->input->post('subcategory_monitoring_id'),
            'description' => $this->input->post('description'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'item_monitoring'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'item_monitoring'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Item monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Edit data item monitoring'
        ];
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();
        $data['subcategory_monitoring'] = $this->mo_subcategory_monitoring->getAll();

        $this->db->where('uuid', $uuid);
        $data['item_monitoring'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('item_monitoring/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'item_monitoring'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'item_monitoring'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'item_monitoring'];
            }
        }
        echo json_encode($response);
    }

    public function getSubCategoryByCategory()
    {
        $id_category = $this->input->post('id');
        $data = $this->db->get_where('t_subcategory_monitoring', ['category_monitoring_id' => $id_category])->result_array();
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
        $dataCategory = $this->mo_subcategory_monitoring->getAll();
        $row = 2;
        foreach ($dataCategory as $key => $value) {
            $sheet2->setCellValue('A' . $row, $value['category_monitoring_id']);
            $sheet2->setCellValue('B' . $row, $value['id_subcategory_monitoring']);

            $sheet2->setCellValue('C' . $row, $value['name_subcategory_monitoring']);
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
                    'category_monitoring_id' => $sheet_data[$i]['0'],
                    'subcategory_monitoring_id' => $sheet_data[$i]['1'],
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
