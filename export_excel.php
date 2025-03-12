<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil data dari API
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://private-anon-93435963dd-visagium.apiary-mock.com/Attendance',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if (!is_array($data) || !isset($data['attendaces'])) {
    die("Data tidak tersedia");
}

$attendances = $data['attendaces'];

// Filter data berdasarkan tanggal jika ada
if (isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
    $tanggalDipilih = date("Y-m-d", strtotime($_GET['tanggal']));
    $attendances = array_filter($attendances, function($attendance) use ($tanggalDipilih) {
        return strpos($attendance['clock_in_time'], $tanggalDipilih) === 0;
    });
}

// Buat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header kolom
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'NIP');
$sheet->setCellValue('C1', 'Nama Pegawai');
$sheet->setCellValue('D1', 'Tanggal');
$sheet->setCellValue('E1', 'Jam Masuk');
$sheet->setCellValue('F1', 'Jam Keluar');

// Style header
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
];
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Isi data
$row = 2;
$no = 1;
foreach ($attendances as $attendance) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, sprintf("%.0f", $attendance['employe_id']));
    $sheet->setCellValue('C' . $row, $attendance['name']);
    $sheet->setCellValue('D' . $row, date("d-m-Y", strtotime($attendance['clock_in_time'])));
    $sheet->setCellValue('E' . $row, date("H:i:s", strtotime($attendance['clock_in_time'])));
    $sheet->setCellValue('F' . $row, $attendance['clock_out_time'] ? date("H:i:s", strtotime($attendance['clock_out_time'])) : "Belum Absen");
    
    // Style untuk data
    $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray([
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ]);
    
    $row++;
}

// Auto size kolom
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Set nama file
$filename = "Rekap_Absensi_" . date("Y-m-d") . ".xlsx";

// Set header untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Export ke Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;