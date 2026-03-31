<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }
        .content {
            padding: 20px 0;
            text-align: center;
        }
        .content p {
            margin: 0 0 20px;
            font-size: 16px;
            color: #666666;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            padding-top: 20px;
            border-top: 1px solid #dddddd;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Xác nhận đăng ký tài khoản</h1>
        </div>
        <div class="content">
            <p>Xin chào <b>{ho_ten}</b>,</p>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại <b>Kết nối vận chuyển</b>. Vui lòng nhấn vào nút bên dưới để xác nhận email của bạn và hoàn tất quá trình đăng ký.</p>
            <a href="{link_xacnhan}" class="button" style="color: #fff;">Xác nhận tài khoản</a>
            <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
        </div>
        <div class="footer">
            <p>Đây là email tự động, vui lòng không trả lời email này.</p>
            <p>© Copyright {nam} KNVC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
