<?php
// Bật ghi lỗi để kiểm tra
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bao gồm thư viện PHPExcel
require './PHPExcel/PHPExcel.php';
require './PHPExcel/PHPExcel/IOFactory.php';

// Tạo đối tượng PHPExcel
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->setActiveSheetIndex(0);

// Định nghĩa tiêu đề
$headers = [
    'email', 'so_booking', 'file_booking', 'loai_hinh', 'phan_loai', 'diachi_donghang', 
    'diachi_trahang', 'ten_tinh', 'ten_huyen', 'ten_xa', 'ten_xa_donghang', 
    'ten_huyen_donghang', 'ten_tinh_donghang', 'ten_hangtau', 'ten_loai_container', 
    'ten_cang', 'mat_hang', 'mat_hang_khac', 'so_luong', 'trong_luong', 'gia', 
    'ghi_chu', 'ket_hop', 'han_tra_rong', 'so_hieu', 'ngay', 'thoi_gian'
];

// Đặt tiêu đề vào hàng đầu tiên
$columnIndex = 0;
foreach ($headers as $header) {
    $sheet->setCellValueByColumnAndRow($columnIndex, 1, $header);
    $columnIndex++;
}

// Đặt đường dẫn file lưu vào thư mục uploads
$uploadDir = __DIR__ . '/uploads/excel'; // Absolute path to the uploads directory
$filePath = $uploadDir . 'booking_data.xlsx'; // Đặt tên file là booking_data.xlsx
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filePath);

// Kiểm tra xem file có được tạo thành công không
if (file_exists($filePath)) {
    echo "File created successfully!";
} else {
    echo "Failed to create the file.";
}

// Đặt tiêu đề HTTP để tải xuống file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="booking_data.xlsx"');
header('Cache-Control: max-age=0');

// Đọc file và gửi nội dung tới trình duyệt
readfile($filePath);

// Xóa file tạm sau khi tải xong
// unlink($filePath); // Không cần xóa khi đã lưu vào thư mục uploads
exit;
