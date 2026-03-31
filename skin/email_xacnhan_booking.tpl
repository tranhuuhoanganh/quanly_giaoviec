<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #0056b3;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #0056b3;
        }
        .info-section p {
            margin: 5px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông Báo Booking Được Chấp Nhận</h1>
        <p>Kính gửi <b>{ho_ten}</b>,</p>
        <p>Chúng tôi xin thông báo rằng booking của bạn đã được chấp nhận trên sàn giao dịch vận tải <a href="http://ketnoivanchuyen.vn">http://ketnoivanchuyen.vn</a> thông tin chi tiết như sau:</p>
        
        <div class="info-section">
            <p>Số booking: {so_booking}</p>
            <p>Số hiệu container: {so_hieu}</p>
            <p>Ngày giờ đóng/trả hàng: {thoi_gian_dat} {ngay_dat}</p>
            <p>Giá cước: {gia_dat} vnđ</p>
        </div>

        <div class="info-section">
            <h2>Thông tin liên hệ:</h2>
            <p>Người liên hệ: {nguoi_lienhe}</p>
            <p>Công ty: {cong_ty}</p>
            <p>Số điện thoại: {dien_thoai}</p>
        </div>
        <p>Vui lòng truy cập <a href="http://ketnoivanchuyen.vn">http://ketnoivanchuyen.vn</a> để kiểm tra thông tin chi tiết và chấp nhận đơn đặt hàng của bạn.</p>
        <p>Trân trọng,<br><b>Đội ngũ hỗ trợ khách hàng ketnoivanchuyen.vn</b>
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>© Copyright {nam} KNVC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
