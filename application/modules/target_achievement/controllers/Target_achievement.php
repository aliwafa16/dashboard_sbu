<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;


class Target_achievement extends MY_Controller
{
    private $table = 't_quarter';
    private $list_sbu;
    private $wheres_listsbu;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mo_target_sbu');
        $this->load->model('mo_sbu');
        $this->load->model('mo_target_achievement');

        is_login();
        $this->list_sbu = session_listsbu();
        $this->wheres_listsbu = wheres_listsbu();
    }
    public function index()
    {
        $data = [
            'title' => 'Target Quarter SBU',
            'sidebar' => 'master-data',
            'heading' => 'Daftar data target per quarter'
        ];
        $data['quarter'] = $this->mo_target_achievement->getAll();
        $this->admin_template->view('target_achievement/vw_target_achievement', $data);
    }

    public function load()
    {
        $this->db->select('t_quarter.*,t_target_sbu.name_target, t_sbu.name_sbu');
        $this->db->from($this->table);
        $this->db->join('t_target_sbu', 't_quarter.sbu_target_id=t_target_sbu.id_target_sbu');
        $this->db->join('t_sbu', 't_quarter.sbu_id=t_sbu.id_sbu');
        $this->db->where_in('t_quarter.sbu_id', $this->wheres_listsbu);
        $this->db->order_by('t_quarter.id_quarter', 'DESC');
        // if (!$this->is_admin) $this->db->where
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function add()
    {
        $data = [
            'title' => 'Target Quarter SBU',
            'sidebar' => 'master-data',
            'heading' => 'Tambah data target per quarter'
        ];
        $data['target_sbu'] = $this->mo_target_sbu->getTargetBySBU($this->wheres_listsbu);
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);

        $this->admin_template->view('target_achievement/vw_add', $data);
    }

    public function submitAdd()
    {
        $response = [];
        $nominal = str_replace(',', '', $this->input->post('target'));
        $data_submit = [
            'sbu_target_id' => $this->input->post('sbu_target_id'),
            'sbu_id' => $this->input->post('sbu_id'),
            'name_quarter' => $this->input->post('name_quarter'),
            'target' => $nominal,
            'achievement' => $this->input->post('achievement'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
        ];

        $this->db->trans_start();
        $this->db->insert($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'target_achievement'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'target_achievement'];
        }


        echo json_encode($response);
    }

    public function submitEdit()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        $nominal = str_replace(',', '', $this->input->post('target'));
        $data_submit = [
            'sbu_target_id' => $this->input->post('sbu_target_id'),
            'sbu_id' => $this->input->post('sbu_id'),
            'name_quarter' => $this->input->post('name_quarter'),
            'target' => $nominal,
            'achievement' => $this->input->post('achievement'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
        ];
        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update($this->table, $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'target_achievement'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'target_achievement'];
        }
        echo json_encode($response);
    }

    public function edit($uuid)
    {
        $data = [
            'title' => 'Target Quarter SBU',
            'sidebar' => 'master-data',
            'heading' => 'Edit data target per quarter'
        ];

        $data['target_sbu'] = $this->mo_target_sbu->getTargetBySBU($this->wheres_listsbu);
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);

        $this->db->where('uuid', $uuid);
        $data['target_quarter'] = $this->db->get($this->table)->row_array();
        $this->admin_template->view('target_achievement/vw_edit', $data);
    }

    public function hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'target_achievement'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete($this->table);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'target_achievement'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'target_achievement'];
            }
        }
        echo json_encode($response);
    }

    public function getRemainingTarget()
    {
        $sbu_target_id = $this->input->post('id');
        $this->db->select_sum('target');
        $this->db->from('t_quarter');
        $this->db->where('sbu_target_id', $sbu_target_id);
        $achievement = $this->db->get()->row_array();

        $target = $this->db->select('target')->where('id_target_sbu', $sbu_target_id)->get('t_target_sbu')->row_array();

        $data = $target['target'] - $achievement['target'];
        echo json_encode($data);
    }

    public function addAchievement()
    {
        $nominal = str_replace(',', '', $this->input->post('nominal'));
        $data_submit = [
            'quarter_id' => $this->input->post('quarter_id'),
            'nominal' => $nominal,
            'date' => date('Y-m-d H:i:s'),
            'is_active' => 1,
            'status' => 'Tambah baru',
            'insert_by' => $this->session->userdata('data_director')['id_director']
        ];

        $this->db->trans_start();
        $this->db->insert('t_history_target', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'target_achievement'
            ];
        } else {

            $dataQuarter = $this->db->get_where($this->table, ['id_quarter' => $this->input->post('quarter_id')])->row_array();

            $new_achievement = $dataQuarter['achievement'] + $nominal;
            $this->db->set('achievement', $new_achievement);
            $this->db->where('id_quarter', $this->input->post('quarter_id'));
            $this->db->update($this->table);
            if ($this->db->trans_status() === FALSE) {
                $response = [
                    'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'target_achievement'
                ];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'target_achievement'];
            }
        }
        echo json_encode($response);
    }

    public function history_achievement($uuid)
    {
        $data = [
            'title' => 'Target Quarter SBU',
            'sidebar' => 'master-data',
            'heading' => 'History pencapaian'
        ];

        $data['quarter'] = $this->mo_target_achievement->getById($uuid);
        $data['history'] = $this->db->get_where('t_history_target', ['quarter_id' => $data['quarter']['id_quarter']])->result_array();
        $this->admin_template->view('target_achievement/vw_history', $data);
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
