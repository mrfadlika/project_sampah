<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require '../vendor/autoload.php';
require 'db_connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

function styleHeader($sheet, $range)
{
    $sheet->getStyle($range)->getFont()->setBold(true);
    $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}

function addBorders($sheet, $range)
{
    $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
}

//validasi inputan
$tanggal_awal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
$tanggal_akhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);
$role = mysqli_real_escape_string($conn, $_POST['role'] ?? '');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle($role);

$sheet->getColumnDimension('A')->setWidth(50);
$sheet->getColumnDimension('B')->setWidth(40);

// --------------HEADER--------------

$sheet->setCellValue('A1', 'LAPORAN REKAPITULASI KATEGORI (' . strtoupper($role) . ')');
$sheet->mergeCells('A1:B1');
$sheet->getStyle('A1')->getFont()->setBold(true);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('A3', 'DATA REKAPITULASI ' . strtoupper($role));
$sheet->mergeCells('A3:B3');
$sheet->getStyle('A3')->getFont()->setBold(true);
$sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue('A4', $tanggal_awal . ' s/d ' . $tanggal_akhir);
$sheet->mergeCells('A4:B4');
$sheet->getStyle('A4')->getFont()->setBold(false);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
addBorders($sheet, 'A3:B4');

//--------------BODY--------------

if ($role !== 'Bank Sampah') {
    // Pembatasan Timbulan Sampah
    $sql_pembatasan = "SELECT
    SUM(sampah_sebelum) AS total_sampah_sebelum,
    SUM(sampah_sesudah) AS total_sampah_sesudah
    FROM pembatasan p
    join users u on p.username = u.username
    WHERE u.role='$role' AND p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $result_pembatasan = $conn->query($sql_pembatasan);
    $pembatasan_data = $result_pembatasan->fetch_assoc();

    $sheet->setCellValue('A6', 'PEMBATASAN TIMBULAN SAMPAH');
    $sheet->mergeCells('A6:B6');
    $sheet->getStyle('A6')->getFont()->setBold(true);
    $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A7', 'Jumlah Timbulan Sampah Sebelum Ada Pembatasan');
    $sheet->setCellValue('B7', number_format($pembatasan_data['total_sampah_sebelum'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A8', 'Jumlah Timbulan Sampah Setelah Ada Pembatasan');
    $sheet->setCellValue('B8', number_format($pembatasan_data['total_sampah_sesudah'] ?? 0, 2) . ' Kg');
    addBorders($sheet, 'A6:B8');

    //Pemanfaatan Kembali
    $sql_pemanfaatan = "SELECT
    SUM(botol_kaca) AS total_botol_kaca,
    SUM(kemasan_plastik) AS total_kemasan_plastik,
    SUM(kaleng_alumunium) AS total_kaleng_alumunium,
    SUM(kemasan_kaleng_cat) AS total_kemasan_kaleng_cat,
    SUM(ban_bekas) AS total_ban_bekas,
    SUM(sisa_makanan) AS total_sisa_makanan
    FROM pemanfaatan p
    join users u on p.username = u.username
    WHERE u.role='$role' AND p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $result_pemanfaatan = $conn->query($sql_pemanfaatan);
    $pemanfaatan_data = $result_pemanfaatan->fetch_assoc();

    $sheet->setCellValue('A10', 'PEMANFAATAN KEMBALI');
    $sheet->mergeCells('A10:B10');
    $sheet->getStyle('A10')->getFont()->setBold(true);
    $sheet->getStyle('A10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A11', 'Anorganik');
    $sheet->mergeCells('A11:B11');
    $sheet->getStyle('A11')->getFont()->setBold(true);
    $sheet->getStyle('A11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A12', 'Jumlah Botol Kaca');
    $sheet->setCellValue('B12', number_format($pemanfaatan_data['total_botol_kaca'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A13', 'Jumlah Kemasan Plastik');
    $sheet->setCellValue('B13', number_format($pemanfaatan_data['total_kemasan_plastik'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A14', 'Jumlah Kaleng Alumunium');
    $sheet->setCellValue('B14', number_format($pemanfaatan_data['total_kaleng_alumunium'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A15', 'Jumlah Kemasan Kaleng Cat');
    $sheet->setCellValue('B15', number_format($pemanfaatan_data['total_kemasan_kaleng_cat'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A16', 'Jumlah Ban Bekas');
    $sheet->setCellValue('B16', number_format($pemanfaatan_data['total_ban_bekas'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A17', 'Organik');
    $sheet->mergeCells('A17:B17');
    $sheet->getStyle('A17')->getFont()->setBold(true);
    $sheet->getStyle('A17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A18', 'Jumlah Sisa Makanan');
    $sheet->setCellValue('B18', number_format($pemanfaatan_data['total_sisa_makanan'] ?? 0, 2) . ' Kg');
    addBorders($sheet, 'A10:B18');


    //Daur Ulang
    $sql_daur_ulang = "SELECT
    SUM(kertas) AS total_kertas,
    SUM(karton) AS total_karton,
    SUM(botol_plastik) AS total_botol_plastik,
    SUM(besi) AS total_besi,
    SUM(aluminium) AS total_aluminium,
    SUM(lainnya_anorganik) AS total_lainnya_anorganik,
    SUM(pengomposan) AS total_pengomposan,
    SUM(eco_enzim) AS total_eco_enzim,
    SUM(lainnya_organik) AS total_lainnya_organik
    FROM daur_ulang d
    join users u on d.username = u.username
    WHERE u.role='$role' AND d.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $result_daur_ulang = $conn->query($sql_daur_ulang);
    $daur_ulang_data = $result_daur_ulang->fetch_assoc();

    $sheet->setCellValue('A20', 'DAUR ULANG');
    $sheet->mergeCells('A20:B20');
    $sheet->getStyle('A20')->getFont()->setBold(true);
    $sheet->getStyle('A20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A21', 'Anorganik');
    $sheet->mergeCells('A21:B21');
    $sheet->getStyle('A21')->getFont()->setBold(true);
    $sheet->getStyle('A21')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A22', 'Jumlah Kertas');
    $sheet->setCellValue('B22', number_format($daur_ulang_data['total_kertas'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A23', 'Jumlah Karton');
    $sheet->setCellValue('B23', number_format($daur_ulang_data['total_karton'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A24', 'Jumlah Botol Plastik');
    $sheet->setCellValue('B24', number_format($daur_ulang_data['total_botol_plastik'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A25', 'Jumlah Besi');
    $sheet->setCellValue('B25', number_format($daur_ulang_data['total_besi'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A26', 'Jumlah Aluminium');
    $sheet->setCellValue('B26', number_format($daur_ulang_data['total_aluminium'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A27', 'Jumlah Lainnya');
    $sheet->setCellValue('B27', number_format($daur_ulang_data['total_lainnya_anorganik'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A28', 'Organik');
    $sheet->mergeCells('A28:B28');
    $sheet->getStyle('A28')->getFont()->setBold(true);
    $sheet->getStyle('A28')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A29', 'Jumlah Pengomposan');
    $sheet->setCellValue('B29', number_format($daur_ulang_data['total_pengomposan'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A30', 'Jumlah Eco Enzim');
    $sheet->setCellValue('B30', number_format($daur_ulang_data['total_eco_enzim'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A31', 'Jumlah Lainnya');
    $sheet->setCellValue('B31', number_format($daur_ulang_data['total_lainnya_organik'] ?? 0, 2) . ' Kg');
    addBorders($sheet, 'A20:B31');
} else {
    //Bank Sampah
    $sql_bank_sampah = "SELECT 
    SUM(b.kertas) AS total_kertas,
    SUM(b.karton) AS total_karton,
    SUM(b.botol_pet) AS total_botol_pet,
    SUM(b.aluminium) AS total_aluminium,
    SUM(b.plastik) AS total_plastik,
    SUM(b.besi) AS total_besi,
    SUM(b.botol_kaca) AS total_botol_kaca,
    SUM(b.minyak_jelantah) AS total_minyak_jelantah,
    SUM(b.lainnya_anorganik) AS total_lainnya_anorganik,
    SUM(b.pengomposan) AS total_pengomposan,
    SUM(b.eco_enzim) AS total_eco_enzim,
    SUM(b.maggot) AS total_maggot
    FROM bank_sampah b
    INNER JOIN users u ON b.username = u.username
    WHERE u.role = '$role'
    AND b.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";

    $result_bank_sampah = $conn->query($sql_bank_sampah);
    $bank_sampah_data = $result_bank_sampah->fetch_assoc();

    $sheet->setCellValue('A6', 'BANK SAMPAH');
    $sheet->mergeCells('A6:B6');
    $sheet->getStyle('A6')->getFont()->setBold(true);
    $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A7', 'Anorganik');
    $sheet->mergeCells('A7:B7');
    $sheet->getStyle('A7')->getFont()->setBold(true);
    $sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A8', 'Jumlah Kertas');
    $sheet->setCellValue('B8', number_format($bank_sampah_data['total_kertas'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A9', 'Jumlah Karton');
    $sheet->setCellValue('B9', number_format($bank_sampah_data['total_karton'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A10', 'Jumlah Botol Pet');
    $sheet->setCellValue('B10', number_format($bank_sampah_data['total_botol_pet'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A11', 'Jumlah Besi');
    $sheet->setCellValue('B11', number_format($bank_sampah_data['total_besi'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A12', 'Jumlah Aluminium');
    $sheet->setCellValue('B12', number_format($bank_sampah_data['total_aluminium'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A13', 'Jumlah Plastik');
    $sheet->setCellValue('B13', number_format($bank_sampah_data['total_plastik'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A14', 'Jumlah Botol Kaca');
    $sheet->setCellValue('B14', number_format($bank_sampah_data['total_botol_kaca'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A15', 'Jumlah Minyak Jelantah');
    $sheet->setCellValue('B15', number_format($bank_sampah_data['total_minyak_jelantah'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A16', 'Jumlah Lainnya');
    $sheet->setCellValue('B16', number_format($bank_sampah_data['total_lainnya_anorganik'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A17', 'Organik');
    $sheet->mergeCells('A17:B17');
    $sheet->getStyle('A17')->getFont()->setBold(true);
    $sheet->getStyle('A17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue('A18', 'Jumlah Pengomposan');
    $sheet->setCellValue('B18', number_format($bank_sampah_data['total_pengomposan'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A19', 'Jumlah Eco Enzim');
    $sheet->setCellValue('B19', number_format($bank_sampah_data['total_eco_enzim'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A20', 'Jumlah Maggot');
    $sheet->setCellValue('B20', number_format($bank_sampah_data['total_maggot'] ?? 0, 2) . ' Kg');
    addBorders($sheet, 'A6:B20');
}
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Rekapitulasi_' . $role . '_' . date('Y-m-d') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;