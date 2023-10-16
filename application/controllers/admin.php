<?php
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('berita_model', 'berita');
    }

    public function index()
    {
        $data['tittle'] = 'Berita';
        $data['start'] = $this->uri->segment(3);
        $data['konten'] = $this->berita->getBerita();

        $this->load->view('temp_admin/header', $data);
        $this->load->view('temp_admin/sidebar', $data);
        $this->load->view('admin/berita/index', $data);
        $this->load->view('temp_admin/footer');
    }

    public function import_excel()
    {
        if (isset($_FILES['upload_file'])) {
            $upload_file = $_FILES['upload_file']['name'];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);

            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $tmp_name = $_FILES['upload_file']['tmp_name'];

            $spreadsheet = $reader->load($tmp_name);
            $sheetdata = $spreadsheet->getActiveSheet()->toArray();

            $sheetcount = count($sheetdata);
            if ($sheetcount > 1) {
                for ($i = 1; $i < $sheetcount; $i++) {
                    $judul = $sheetdata[$i][1];
                    $isi = $sheetdata[$i][2];

                    $this->berita->import(array(
                        'judul' => $judul,
                        'isi' => $isi
                    ));
                }
                redirect('admin');
            }
        }
    }

    public function export_excel()
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="hasil_export.xlsx"');
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Isi');

        $berita = $this->berita->getBerita();

        $row = 2;
        $no = 1;

        foreach ($berita as $brt) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $brt->judul);
            $sheet->setCellValue('C' . $row, $brt->isi);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
