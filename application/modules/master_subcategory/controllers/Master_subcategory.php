<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;;


class Master_subcategory extends MY_Controller
{
    private $table = 't_subcategory_monitoring';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_category_monitoring');
        is_login();
    }
    public function index()
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Daftar data sub kategori monitoring'
        ];
        $this->admin_template->view('master_subcategory/vw_subcategory', $data);
    }

    public function load()
    {
        $this->db->select('t_subcategory_monitoring.*, t_category_monitoring.name_category_monitoring');
        $this->db->from($this->table);
        $this->db->join('t_category_monitoring', 't_subcategory_monitoring.category_monitoring_id=t_category_monitoring.id_category_monitoring');
        $this->db->order_by('t_subcategory_monitoring.id_subcategory_monitoring', 'DESC');
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Tambah data sub kategori monitoring'
        ];
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->admin_template->view('master_subcategory/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];

        $data_submit = [
            'name_subcategory_monitoring' => $this->input->post('name_subcategory_monitoring'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_subcategory'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'master_subcategory'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $data_submit = [
            'name_subcategory_monitoring' => $this->input->post('name_subcategory_monitoring'),
            'description' => $this->input->post('description'),
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'is_active' => ($this->input->post('is_active')) ? 1 : 0
        ];
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'master_subcategory'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'master_subcategory'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Sub Kategori Monitoring',
            'sidebar' => 'master-item',
            'heading' => 'Edit data sub kategori monitoring'
        ];
        $data['category_monitoring'] = $this->mo_category_monitoring->getAll();

        $this->db->where('uuid', $uuid);
        $data['subcategory'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('master_subcategory/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'master_subcategory'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'master_subcategory'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'master_subcategory'];
            }
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
                    'name_subcategory_monitoring' => $sheet_data[$i]['1'],
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
