<?php
// Nạp thư viện PHPExcel
require_once 'PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Email')
    ->setCellValue('B1', 'Số Booking')
    ->setCellValue('C1', 'File Booking')
    ->setCellValue('D1', 'Loại Hình')
    ->setCellValue('E1', 'Phân Loại')
    ->setCellValue('F1', 'Địa Chỉ Đóng Hàng')
    ->setCellValue('G1', 'Địa Chỉ Trả Hàng')
    ->setCellValue('H1', 'Tên Tỉnh')
    ->setCellValue('I1', 'Tên Huyện')
    ->setCellValue('J1', 'Tên Xã')
    ->setCellValue('K1', 'Tên Xã Đóng Hàng')
    ->setCellValue('L1', 'Tên Huyện Đóng Hàng')
    ->setCellValue('M1', 'Tên Tỉnh Đóng Hàng')
    ->setCellValue('N1', 'Tên Hãng Tàu')
    ->setCellValue('O1', 'Tên Loại Container')
    ->setCellValue('P1', 'Tên Cảng')
    ->setCellValue('Q1', 'Mặt Hàng')
    ->setCellValue('R1', 'Mặt Hàng Khác')
    ->setCellValue('S1', 'Số Lượng')
    ->setCellValue('T1', 'Trọng Lượng')
    ->setCellValue('U1', 'Giá')
    ->setCellValue('V1', 'Ghi Chú')
    ->setCellValue('W1', 'Kết Hợp')
    ->setCellValue('X1', 'Hạn Trả Rỗng')
    ->setCellValue('Y1', 'Số Hiệu')
    ->setCellValue('Z1', 'Ngày')
    ->setCellValue('AA1', 'Thời Gian');

// Đường dẫn lưu file
$path = 'uploads/excel/data.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($path);

// Tải file xuống
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data.xlsx"');
header('Cache-Control: max-age=0');
readfile($path);
exit;
?>
