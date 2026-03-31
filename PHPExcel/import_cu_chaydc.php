<?php
// Hiển thị lỗi để giúp chẩn đoán vấn đề
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PhpSpreadsheet library
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'ketnoi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối cơ sở dữ liệu thành công.<br>";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Hàm nhập dữ liệu từ file Excel vào MySQL
function importExcelToDatabase($filePath, $pdo) {
    try {
        $spreadsheet = IOFactory::load($filePath);
    } catch (Exception $e) {
        die("Error loading Excel file: " . $e->getMessage());
    }

    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    foreach ($rows as $index => $row) {
        if ($index === 0) continue; // Bỏ qua dòng tiêu đề
        if (empty(array_filter($row))) continue; // Bỏ qua dòng trống

        // Truy xuất user_id từ user_info dựa vào email
        $email = !empty($row[0]) ? $row[0] : NULL;
        $userStmt = $pdo->prepare("SELECT user_id FROM user_info WHERE email = ?");
        $userStmt->execute([$email]);
        $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $userRow ? $userRow['user_id'] : NULL;

        if (!$user_id) {
            echo "User với email '$email' không tồn tại. Bỏ qua dòng này.<br>";
            continue;
        }

        // Các biến khác từ file Excel
        $ma_booking = !empty($row[1]) ? $row[1] : NULL;
        $so_booking = !empty($row[2]) ? $row[2] : NULL;
        $file_booking = !empty($row[3]) ? $row[3] : NULL;
        $loai_hinh = !empty($row[4]) ? $row[4] : NULL;
        $phan_loai = !empty($row[5]) ? $row[5] : NULL;
        $hang_tau = !empty($row[6]) ? $row[6] : NULL;
        $loai_container = !empty($row[7]) ? $row[7] : NULL;
        $diachi_donghang = !empty($row[8]) ? $row[8] : NULL;
        $diachi_trahang = !empty($row[9]) ? $row[9] : NULL;
        $tinh = !empty($row[10]) ? $row[10] : NULL;
        $huyen = !empty($row[11]) ? $row[11] : NULL;
        $xa = !empty($row[12]) ? $row[12] : NULL;
        $ten_tinh = !empty(trim($row[13])) ? trim($row[13]) : NULL;
        $ten_huyen = !empty(trim($row[14])) ? trim($row[14]) : NULL;
        $ten_xa = !empty(trim($row[15])) ? trim($row[15]) : NULL;
        $xa_donghang = !empty($row[16]) ? $row[16] : NULL;
        $huyen_donghang = !empty($row[17]) ? $row[17] : NULL;
        $tinh_donghang = !empty($row[18]) ? $row[18] : NULL;
        $ten_xa_donghang = !empty($row[19]) ? $row[19] : NULL;
        $ten_huyen_donghang = !empty($row[20]) ? $row[20] : NULL;
        $ten_tinh_donghang = !empty($row[21]) ? $row[21] : NULL;
        $ten_hangtau = !empty($row[22]) ? $row[22] : NULL;
        $ten_loai_container = !empty($row[23]) ? $row[23] : NULL;
        $ten_cang = !empty($row[24]) ? $row[24] : NULL;
        $mat_hang = !empty($row[25]) ? $row[25] : NULL;
        $mat_hang_khac = !empty($row[26]) ? $row[26] : NULL;
        $so_luong = !empty($row[27]) ? $row[27] : NULL;
        $trong_luong = !empty($row[28]) ? $row[28] : NULL;
        $gia = !empty($row[29]) ? $row[29] : NULL;
        $ghi_chu = !empty($row[30]) ? $row[30] : NULL;
        $status = !empty($row[31]) && is_numeric($row[31]) ? (int)$row[31] : 0;
        $ket_hop = !empty($row[32]) ? $row[32] : NULL;
        $phi_kethop = !empty($row[33]) ? $row[33] : NULL;
        $date_post = !empty($row[34]) ? $row[34] : NULL;
        $han_tra_rong = !empty($row[35]) ? $row[35] : NULL;

        // Truy xuất ID từ các bảng liên kết, sử dụng LOWER và LIKE để tăng tính linh hoạt
        $hang_tau = getIdFromDb($pdo, 'list_hangtau', 'viet_tat', $ten_hangtau);
        $loai_container = getIdFromDb($pdo, 'loai_container', 'tieu_de', $ten_loai_container);
        $tinh = getIdFromDb($pdo, 'tinh_moi', 'tieu_de', $ten_tinh);
        $huyen = getIdFromDb($pdo, 'huyen_moi', 'tieu_de', $ten_huyen);
        $xa = getIdFromDb($pdo, 'xa_moi', 'tieu_de', $ten_xa);
        $tinh_donghang = getIdFromDb($pdo, 'tinh_moi', 'tieu_de', $ten_tinh_donghang);
        $huyen_donghang = getIdFromDb($pdo, 'huyen_moi', 'tieu_de', $ten_huyen_donghang);
        $xa_donghang = getIdFromDb($pdo, 'xa_moi', 'tieu_de', $ten_xa_donghang);

        // Dữ liệu JSON cho list_container
        $list_container_data = [
            'so_hieu' => !empty($row[36]) ? $row[36] : NULL,
            'ngay' => !empty($row[37]) ? $row[37] : NULL,
            'thoi_gian' => !empty($row[38]) ? $row[38] : NULL
        ];
        $list_container_json = json_encode($list_container_data);

        // Thực hiện truy vấn chèn dữ liệu vào bảng booking
        $insertStmt = $pdo->prepare("INSERT INTO booking (
            user_id, ma_booking, so_booking, file_booking, loai_hinh, phan_loai, hang_tau,
            loai_container, diachi_donghang, diachi_trahang, tinh, huyen, xa,
            ten_tinh, ten_huyen, ten_xa, xa_donghang, huyen_donghang, tinh_donghang,
            ten_xa_donghang, ten_huyen_donghang, ten_tinh_donghang, ten_hangtau, ten_loai_container, ten_cang,
            mat_hang, mat_hang_khac, so_luong, trong_luong, gia, ghi_chu, list_container,
            status, ket_hop, phi_kethop, date_post, han_tra_rong
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $insertStmt->execute([
            $user_id, $ma_booking, $so_booking, $file_booking, $loai_hinh, $phan_loai, $hang_tau,
            $loai_container, $diachi_donghang, $diachi_trahang, $tinh, $huyen, $xa,
            $ten_tinh, $ten_huyen, $ten_xa, $xa_donghang, $huyen_donghang, $tinh_donghang,
            $ten_xa_donghang, $ten_huyen_donghang, $ten_tinh_donghang, $ten_hangtau, $ten_loai_container, $ten_cang,
            $mat_hang, $mat_hang_khac, $so_luong, $trong_luong, $gia, $ghi_chu, $list_container_json,
            $status, $ket_hop, $phi_kethop, $date_post, $han_tra_rong
        ]);
    }

    echo "Dữ liệu đã được chèn vào cơ sở dữ liệu thành công.<br>";
}

function getIdFromDb($pdo, $table, $column, $value) {
    if (!$value) return NULL;
    $stmt = $pdo->prepare("SELECT id FROM $table WHERE LOWER($column) LIKE LOWER(?)");
    $stmt->execute(['%' . $value . '%']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['id'] : NULL;
}

// Khởi động session để lưu trữ thông báo thành công
session_start();

// Kiểm tra và gọi hàm nhập liệu
if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $filePath = $_FILES['file']['tmp_name'];
    if (importExcelToDatabase($filePath, $pdo)) {
        $_SESSION['success_message'] = "Dữ liệu đã được nhập thành công.";
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra trong quá trình nhập dữ liệu.";
    }
    header("Location: /members/add-booking");
    exit();
} else {
    echo "Lỗi khi tải lên file: " . $_FILES['file']['error'];
}
?>
