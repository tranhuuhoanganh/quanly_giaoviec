<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo Booking Mới</title>
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
        <h1>Thông Báo Booking {loai_hinh} Mới</h1>
        <p>Kính gửi <b>{ho_ten}</b>,</p>
        <p>Chúng tôi xin thông báo rằng một booking mới vừa được tạo trên sàn giao dịch vận tải <a href="https://ketnoivanchuyen.vn">https://ketnoivanchuyen.vn</a> thông tin chi tiết như sau:</p>
        
        <div class="info-section">
            <h2>Thông Tin Booking:</h2>
            <p>Hãng tàu: {ten_hangtau}</p>
            <p>Loại hàng hóa: {mat_hang}</p>
            <p>Số lượng: {so_luong} container</p>
            <p>Trọng lượng: {trong_luong} tấn/container</p>
        </div>

        <div class="info-section">
            <h2>Giá cước:</h2>
            <p>Đơn giá: {gia} VND/container</p>
        </div>
        {info_dong_tra}

        <p>Hãy truy cập website <a href="https://ketnoivanchuyen.vn">https://ketnoivanchuyen.vn</a> để xem thông tin chi tiết...</p>
        <p>Trân trọng,<br><b>Đội ngũ hỗ trợ khách hàng ketnoivanchuyen.vn</b>
</p>
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>© Copyright {nam} KẾT NỐI VẬN CHUYỂN. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
