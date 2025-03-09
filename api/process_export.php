<?php
session_start();
require '../vendor/autoload.php';
require 'db_connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Fungsi untuk styling
function styleHeader($sheet, $range) {
    $sheet->getStyle($range)->getFont()->setBold(true);
    $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
}

function addBorders($sheet, $range) {
    $sheet->getStyle($range)->getBorders()->getAllBorders()
        ->setBorderStyle(Border::BORDER_THIN);
}

// Validasi input
$tanggal_awal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
$tanggal_akhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);
$role = mysqli_real_escape_string($conn, $_POST['role'] ?? '');

$spreadsheet = new Spreadsheet();

// Ambil daftar instansi
$sql_instansi = "SELECT DISTINCT instansi FROM users";
if ($role) {
    $sql_instansi .= " WHERE role = '$role'";
}
$instansi_result = $conn->query($sql_instansi);

$sheetIndex = 0;

while($instansi_row = $instansi_result->fetch_assoc()) {
    if($sheetIndex > 0) {
        $spreadsheet->createSheet();
    }
    $sheet = $spreadsheet->setActiveSheetIndex($sheetIndex);
    $instansi = $instansi_row['instansi'];
    $sheet->setTitle($instansi);

    // Set lebar kolom
    $sheet->getColumnDimension('A')->setWidth(50);
    $sheet->getColumnDimension('B')->setWidth(40);

    // Judul
    $sheet->setCellValue('A1', 'LAPORAN REKAPITULASI KATEGORI (' . strtoupper($role) . ')');
    $sheet->mergeCells('A1:B1');
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    // Nama Instansi
    $sheet->setCellValue('A3', strtoupper($instansi));
    $sheet->mergeCells('A3:B3');
    $sheet->getStyle('A3')->getFont()->setBold(true);
    $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    addBorders($sheet, 'A3:B3');

    if($role !== 'Bank Sampah') {
    // Pembatasan Timbulan Sampah
    $sheet->setCellValue('A5', 'Pembatasan Timbulan Sampah');
    $sheet->mergeCells('A5:B5');
    $sheet->getStyle('A5')->getFont()->setBold(true);
    $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    addBorders($sheet, 'A5:B5');

    // Query Pembatasan
    $sql_pembatasan = "SELECT 
        SUM(sampah_sebelum) as total_sebelum,
        SUM(sampah_sesudah) as total_sesudah
        FROM pembatasan p
        JOIN users u ON p.username = u.username
        WHERE u.instansi = '$instansi'
        AND p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $pembatasan_result = $conn->query($sql_pembatasan);
    $pembatasan_data = $pembatasan_result->fetch_assoc();

    // Isi data pembatasan
    $sheet->setCellValue('A6', 'Jumlah Timbulan Sampah Sebelum Ada Pembatasan');
    $sheet->setCellValue('B6', number_format($pembatasan_data['total_sebelum'] ?? 0, 2) . ' Kg');
    $sheet->setCellValue('A7', 'Jumlah Timbulan Sampah Sesudah Ada Pembatasan');
    $sheet->setCellValue('B7', number_format($pembatasan_data['total_sesudah'] ?? 0, 2) . ' Kg');
    addBorders($sheet, 'A6:B7');

    // Pemanfaatan Kembali
    $sheet->setCellValue('A9', 'Pemanfaatan Kembali');
    $sheet->mergeCells('A9:B9');
    $sheet->getStyle('A9')->getFont()->setBold(true);
    $sheet->getStyle('A9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    addBorders($sheet, 'A9:B9');

    // Header Anorganik & Organik
    $sheet->setCellValue('A10', 'Anorganik');
    $sheet->setCellValue('B10', 'Organik');
    styleHeader($sheet, 'A10:B10');
    addBorders($sheet, 'A10:B10');

    // Query Pemanfaatan
    $sql_pemanfaatan = "SELECT 
        SUM(botol_kaca) as total_botol,
        SUM(kemasan_plastik) as total_plastik,
        SUM(kaleng_alumunium) as total_kaleng,
        SUM(kemasan_kaleng_cat) as total_cat,
        SUM(ban_bekas) as total_ban,
        SUM(sisa_makanan) as total_makanan
        FROM pemanfaatan p
        JOIN users u ON p.username = u.username
        WHERE u.instansi = '$instansi'
        AND p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $pemanfaatan_result = $conn->query($sql_pemanfaatan);
    $pemanfaatan_data = $pemanfaatan_result->fetch_assoc();

    // Isi data pemanfaatan
    $sheet->setCellValue('A11', 'Botol Kaca (' . number_format($pemanfaatan_data['total_botol'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A12', 'Kemasan Plastik (' . number_format($pemanfaatan_data['total_plastik'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A13', 'Kaleng Alumunium (' . number_format($pemanfaatan_data['total_kaleng'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A14', 'Kemasan Kaleng Cat (' . number_format($pemanfaatan_data['total_cat'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A15', 'Ban Bekas (' . number_format($pemanfaatan_data['total_ban'] ?? 0, 2) . ' Kg)');
    
    $sheet->setCellValue('B11', 'Sisa Makanan (' . number_format($pemanfaatan_data['total_makanan'] ?? 0, 2) . ' Kg)');
    addBorders($sheet, 'A11:B15');

    // Pendauran Ulang
    $sheet->setCellValue('A17', 'Pendauran Ulang');
    $sheet->mergeCells('A17:B17');
    $sheet->getStyle('A17')->getFont()->setBold(true);
    $sheet->getStyle('A17')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    addBorders($sheet, 'A17:B17');

    // Header Anorganik & Organik untuk Daur Ulang
    $sheet->setCellValue('A18', 'Anorganik');
    $sheet->setCellValue('B18', 'Organik');
    styleHeader($sheet, 'A18:B18');
    addBorders($sheet, 'A18:B18');

    // Query Daur Ulang
    $sql_daur_ulang = "SELECT 
        SUM(kertas) as total_kertas,
        SUM(karton) as total_karton,
        SUM(botol_plastik) as total_botol_plastik,
        SUM(besi) as total_besi,
        SUM(aluminium) as total_aluminium,
        SUM(lainnya_anorganik) as total_lainnya_anorganik,
        SUM(pengomposan) as total_pengomposan,
        SUM(eco_enzim) as total_eco_enzim,
        SUM(lainnya_organik) as total_lainnya_organik
        FROM daur_ulang d
        JOIN users u ON d.username = u.username
        WHERE u.instansi = '$instansi'
        AND d.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $daur_ulang_result = $conn->query($sql_daur_ulang);
    $daur_ulang_data = $daur_ulang_result->fetch_assoc();

    // Isi data daur ulang
    $sheet->setCellValue('A19', 'Kertas (' . number_format($daur_ulang_data['total_kertas'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A20', 'Karton (' . number_format($daur_ulang_data['total_karton'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A21', 'Botol Plastik (' . number_format($daur_ulang_data['total_botol_plastik'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A22', 'Besi (' . number_format($daur_ulang_data['total_besi'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A23', 'Aluminium (' . number_format($daur_ulang_data['total_aluminium'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A24', 'Lainnya Anorganik (' . number_format($daur_ulang_data['total_lainnya_anorganik'] ?? 0, 2) . ' Kg)');

    $sheet->setCellValue('B19', 'Pengomposan (' . number_format($daur_ulang_data['total_pengomposan'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('B20', 'Eco Enzim (' . number_format($daur_ulang_data['total_eco_enzim'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('B21', 'Lainnya Organik (' . number_format($daur_ulang_data['total_lainnya_organik'] ?? 0, 2) . ' Kg)');
    addBorders($sheet, 'A19:B24');

    } else {

    // Bank Sampah
    $sheet->setCellValue('A5', 'Bank Sampah');
    $sheet->mergeCells('A5:B5');
    $sheet->getStyle('A5')->getFont()->setBold(true);
    $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    addBorders($sheet, 'A5:B5');

    // Header Anorganik & Organik untuk Bank Sampah
    $sheet->setCellValue('A6', 'Anorganik');
    $sheet->setCellValue('B6', 'Organik');
    styleHeader($sheet, 'A6:B6');
    addBorders($sheet, 'A6:B6');

    // Query Bank Sampah
    $sql_bank_sampah = "SELECT 
        SUM(kertas) as total_kertas,
        SUM(karton) as total_karton,
        SUM(botol_pet) as total_botol_pet,
        SUM(aluminium) as total_aluminium,
        SUM(plastik) as total_plastik,
        SUM(besi) as total_besi,
        SUM(botol_kaca) as total_botol_kaca,
        SUM(minyak_jelantah) as total_minyak_jelantah,
        SUM(lainnya_anorganik) as total_lainnya_anorganik,
        SUM(pengomposan) as total_pengomposan,
        SUM(eco_enzim) as total_eco_enzim,
        SUM(maggot) as total_maggot
        FROM bank_sampah d
        JOIN users u ON d.username = u.username
        WHERE u.instansi = '$instansi'
        AND d.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $bank_sampah_result = $conn->query($sql_bank_sampah);
    $bank_sampah_data = $bank_sampah_result->fetch_assoc();

    // Isi data bank sampah
    $sheet->setCellValue('A7', 'Kertas (' . number_format($bank_sampah_data['total_kertas'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A8', 'Karton (' . number_format($bank_sampah_data['total_karton'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A9', 'Botol PET (' . number_format($bank_sampah_data['total_botol_pet'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A10', 'Aluminium (' . number_format($bank_sampah_data['total_aluminium'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A11', 'Plastik (' . number_format($bank_sampah_data['total_plastik'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A12', 'Besi (' . number_format($bank_sampah_data['total_besi'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A13', 'Botol Kaca (' . number_format($bank_sampah_data['total_botol_kaca'] ?? 0, 0) . ' Pcs)');
    $sheet->setCellValue('A14', 'Minyak Jelantah (' . number_format($bank_sampah_data['total_minyak_jelantah'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('A15', 'Lainnya Anorganik (' . number_format($bank_sampah_data['total_lainnya_anorganik'] ?? 0, 2) . ' Kg)');

    $sheet->setCellValue('B7', 'Pengomposan (' . number_format($bank_sampah_data['total_pengomposan'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('B8', 'Eco Enzim (' . number_format($bank_sampah_data['total_eco_enzim'] ?? 0, 2) . ' Kg)');
    $sheet->setCellValue('B9', 'Maggot (' . number_format($bank_sampah_data['total_maggot'] ?? 0, 2) . ' Kg)');
    addBorders($sheet, 'A7:B15');

    }

    // Set font dan ukuran untuk seluruh sheet
    $sheet->getStyle('A1:B24')->getFont()->setName('Calibri');
    $sheet->getStyle('A1:B24')->getFont()->setSize(11);

    $sheetIndex++;
}

// Header download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Rekapitulasi_' . $role . '_' . date('Y-m-d') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;