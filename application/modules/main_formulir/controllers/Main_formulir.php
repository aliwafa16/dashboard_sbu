<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;;


class Main_formulir extends MY_Controller
{
    private $table = 't_account_item';
    private $wheres_listsbu;
    private $wheres_formSbuSpecification;
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('mo_category_monitoring');
        // $this->load->model('mo_subcategory_monitoring');
        // $this->load->model('mo_account_subcategory');
        // $this->load->model('mo_item_monitoring');
        $this->load->model('mo_sbu');
        $this->load->model('mo_account_monitoring');
        is_login();
        $this->wheres_listsbu = wheres_listsbu();
        $this->wheres_formSbuSpecification = subcategory_formSbuSpecification();
    }
    public function index()
    {
        $data = [
            'title' => 'Account formulir',
            'sidebar' => 'main_formulir',
            'heading' => 'ITEM MONITORING 3R'
        ];

        // get start date & end date;
        $date = getStartAndEndDate(date('m'), date('Y'));

        $data['master_status'] = $this->db->get('t_master_status')->result_array();
        $data['master_pic'] = $this->db->get('t_master_pic')->result_array();
        $data['satuan_target'] = $this->db->get('t_ukuran_satuan')->result_array();

        $this->db->where('id_category_monitoring !=', 1);
        $data['category_monitoring'] = $this->db->get('t_category_monitoring')->result_array();


        $this->db->where_in('sbu_id', $this->wheres_listsbu);
        $this->db->where('category_monitoring_id !=', 1);
        $this->db->where('product_id', NULL);
        $data['subcategory_monitoring'] = $this->db->get('t_account_subcategory')->result_array();
        $data['sbu'] = $this->mo_sbu->getListSbu($this->wheres_listsbu);
        $this->admin_template->view('main_formulir/vw_main_formulir', $data);
    }

    public function fnEdit()
    {
        $uuid = $this->input->post('uuid');
        $data = $this->mo_account_monitoring->getFormSBUSpecificationByUUID($uuid);
        echo json_encode($data);
    }

    public function submit_edit()
    {
        $uuid = $this->input->post('uuid');
        $target_rate = $this->input->post('target_rate');
        $actual = $this->input->post('actual');

        $percentage = ($actual / $target_rate) * 100;
        $data_submit = [
            'sbu_id' => $this->input->post('sbu_id'),
            'name_tools' => $this->input->post('name_tools'),
            'status' => $this->input->post('status'),
            'assigned_to' => $this->input->post('assigned_to'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'target_unit' => $this->input->post('target_unit'),
            'target_rate' => $this->input->post('target_rate'),
            'actual' => $this->input->post('actual'),
            'notes' => $this->input->post('notes'),
            'percentage' => $percentage,
            'link_dokumen' => $this->input->post('link_dokumen'),
        ];

        $this->db->trans_start();
        $this->db->where('uuid', $uuid);
        $this->db->update('t_monitoring_sbu', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'main_formulir'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil edit data', 'url' => 'main_formulir'];
        }
        echo json_encode($response);
    }

    public function submit_add()
    {
        $uuid = $this->input->post('uuid');
        $target_rate = $this->input->post('target_rate');
        $actual = $this->input->post('actual') ?? 0;

        $percentage = 0;
        if ($actual != 0) {
            $percentage = ($actual / $target_rate) * 100;
        }

        $date = getStartAndEndDate($this->input->post('periode'), date('Y'));


        $data_submit = [
            'category_monitoring_id' => $this->input->post('category_monitoring_id'),
            'subcategory_monitoring_id' => $this->input->post('subcategory_monitoring_id'),
            'quarter' => 1,
            'start_quarter' => $date['start_date'],
            'end_quarter' => $date['end_date'],
            'sbu_id' => $this->input->post('sbu_id'),
            'name_tools' => $this->input->post('name_tools'),
            'status' => $this->input->post('status'),
            'assigned_to' => $this->input->post('assigned_to'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'target_unit' => $this->input->post('target_unit'),
            'target_rate' => $this->input->post('target_rate'),
            'actual' => $this->input->post('actual'),
            'notes' => $this->input->post('notes'),
            'percentage' => $percentage,
            'link_dokumen' => $this->input->post('link_dokumen'),
        ];


        $this->db->trans_start();
        $this->db->insert('t_monitoring_sbu', $data_submit);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal tambah data', 'url' => 'main_formulir'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil tambah data', 'url' => 'main_formulir'];
        }
        echo json_encode($response);
    }

    public function submit_hapus()
    {
        $response = [];
        $uuid = $this->input->post('uuid');
        if (!$uuid) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Data tidak ditemukan', 'url' => 'main_formulir'
            ];
        } else {

            $this->db->trans_start();
            $this->db->where('uuid', $uuid);
            $this->db->delete('t_monitoring_sbu');
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal hapus data', 'url' => 'main_formulir'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil hapus data', 'url' => 'main_formulir'];
            }
        }
        echo json_encode($response);
    }

    public function getSubcategoryAccount()
    {
        $id_sbu = $this->input->post('sbu_id');
        $category_monitoring_id = $this->input->post('category_id');
        $periode_id = $this->input->post('periode_id');
        $periode = getStartAndEndDate($periode_id, date('Y'));
        $data = $this->db->where('category_monitoring_id', $category_monitoring_id)
            ->where('sbu_id', $id_sbu)
            ->where('product_id IS NULL', null, false)
            ->get('t_account_subcategory')
            ->result_array();
        echo json_encode($data);
    }

    public function create_dashboard()
    {
        $data = $this->input->post();
        $results = $this->mo_account_monitoring->addFormMonitoring($data);
        if (!$results) {
            $response = [
                'code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal edit data', 'url' => 'main_formulir'
            ];
        } else {
            $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil membuat dashboard', 'url' => 'main_formulir'];
        }
        echo json_encode($response);
    }

    public function load_form()
    {
        $periode_id = $this->input->post('periode_id');
        $quarter_periode = getStartAndEndDate($periode_id, date('Y'));
        $data['formSbu'] =  $this->mo_account_monitoring->getFormMonitoring($this->wheres_listsbu, $quarter_periode);


        $this->db->select('t_account_subcategory.*');
        $this->db->from('t_account_subcategory');
        $this->db->join('t_monitoring_sbu', 't_account_subcategory.id_account_subcategory=t_monitoring_sbu.subcategory_monitoring_id');
        $this->db->where('t_account_subcategory.category_monitoring_id !=', 1);
        $this->db->where_in('t_account_subcategory.sbu_id', $this->wheres_listsbu);
        $this->db->where('t_monitoring_sbu.start_quarter >=', $quarter_periode['start_date']);
        $this->db->where('t_monitoring_sbu.end_quarter <=', $quarter_periode['end_date']);
        $data['subcategory_monitoring'] = $this->db->get()->result_array();


        $subcategory = [];
        foreach ($data['subcategory_monitoring'] as $element) {
            $subcategory[$element['id_account_subcategory']][] = $element;
        }



        // echo $this->db->last_query();
        $subcategory = array_values($this->removeDuplicates($subcategory));
        // var_dump($subcategory);
        // die;

        $result = array();
        foreach ($data['formSbu'] as $element) {
            $result[$element['subcategory_monitoring_id']][] = $element;
        }

        // var_dump($result[58]);
        // die;



        $finals = [];
        foreach ($subcategory as $key => $value) {
            $subcategory = $value[0];
            // var_dump($value[0]);
            $subcategory['category_name'] = $result[$subcategory['id_account_subcategory']][0]['name_category_monitoring'];
            $subcategory['subcategory_name'] = $result[$subcategory['id_account_subcategory']][0]['name_subcategory'];
            $subcategory['list_monitoring'] = $result[$subcategory['id_account_subcategory']];
            $finals[] = $subcategory;
        }
        // die;

        $data['forms'] = $finals;
        $response = $this->load->view('main_formulir/vw_formulir', $data, TRUE);
        echo json_encode($response);
    }

    public function submit_copy()
    {
        $response = [];
        $periode_sumber = getStartAndEndDate($this->input->post('sumber_periode'), date('Y'));
        $periode_tujuan = getStartAndEndDate($this->input->post('tujuan_periode'), date('Y'));
        $sbu_id = $this->input->post('sbu_id');
        $tipe = $this->input->post('tipe');


        // // get_periode_sumber
        $this->db->where('start_quarter >=', $periode_sumber['start_date']);
        $this->db->where('end_quarter >=', $periode_sumber['end_date']);
        $this->db->where('quarter', 1);
        $this->db->where('sbu_id', $sbu_id);
        $this->db->where('category_monitoring_id !=', 1);
        $sumberMonitoring = $this->db->get('t_monitoring_sbu')->result_array();


        // ambil data sumber monitoring

        $data_account_monitoring = [];
        if (count($sumberMonitoring) > 0) {
            foreach ($sumberMonitoring as $key => $value) {
                $row = [];
                $row['sbu_id'] = $sbu_id;
                $row['category_monitoring_id'] = $value['category_monitoring_id'];
                $row['subcategory_monitoring_id'] = $value['subcategory_monitoring_id'];
                $row['name_tools'] = $value['name_tools'];
                $row['quarter'] = 1;
                $row['start_quarter'] = $periode_tujuan['start_date'];
                $row['end_quarter'] = $periode_tujuan['end_date'];
                if ($tipe == 1) {
                    $row['status'] = 1;
                    $row['target_rate'] = 1;
                    $row['assigned_to'] = 5;
                    $row['target_unit'] = 13;
                    $row['target_rate'] = 1;
                    $row['actual'] = 0;
                    $row['percentage'] = 0;
                } else if ($tipe == 2) {
                    $row['status'] =  $value['status'];
                    $row['target_rate'] =  $value['target_rate'];
                    $row['assigned_to'] = $value['assigned_to'];
                    $row['target_unit'] = $value['target_unit'];
                    $row['target_rate'] = $value['target_rate'];
                    $row['actual'] = $value['actual'];
                    $row['percentage'] = $value['percentage'];
                }
                $data_account_monitoring[] = $row;
            }
            $this->db->trans_start();
            $this->db->insert_batch('t_monitoring_sbu', $data_account_monitoring);
            $this->db->trans_complete();

            if ($this->db->trans_status() == FALSE) {
                $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Gagal copy data', 'url' => 'main_formulir'];
            } else {
                $response = ['code' => 200, 'status' => true, 'data' => null, 'message' => 'Berhasil copy data', 'url' => 'main_formulir'];
            }
        } else {
            $response = ['code' => 403, 'status' => false, 'data' => null, 'message' => 'Sumber data tidak tersedia', 'url' => 'main_formulir'];
        }
        echo json_encode($response);
    }

    function removeDuplicates($data)
    {
        foreach ($data as $key => &$items) {
            $uniqueItems = [];
            foreach ($items as $item) {
                $uniqueItems[implode('-', array_values($item))] = $item;
            }
            $items = array_values($uniqueItems);
        }
        return $data;
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
        $sheet->setCellValue('C1', "NAMA formulir");
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
