<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if($action=='booking'){
	$batdau=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$ketthuc=mktime(23,59,59,date('m'),date('d'),date('Y'));
	$thongtin_gui=mysqli_query($conn,"SELECT * FROM gui_email WHERE status='0' AND loai='booking' AND date_post<='$ketthuc' AND date_post>='$batdau' ORDER BY id ASC LIMIT 1");
	$total_gui=mysqli_num_rows($thongtin_gui);
	if($total_gui==0){
		echo "Không còn dữ liệu để xử lý";
	}else{
		$r_g=mysqli_fetch_assoc($thongtin_gui);
		$thongtin=mysqli_query($conn,"SELECT *,count(*) total FROM booking WHERE id='{$r_g['booking']}'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok = 0;
			$thongbao = 'Thất bại! Booking không tồn tại';
		}else{
			if($r_g['user_id']==''){
				$ok = 0;
				$thongbao = 'Thất bại! Không có người nhận';
			}else{
				if(strpos($r_g['user_id'], ',')!==false){
					$tach_u=explode(',', $r_g['user_id']);
					$u=$tach_u[0];
					array_shift($tach_u);
					$tach_u_gui=implode(',', $tach_u);
					if($r_g['da_gui']==''){
						mysqli_query($conn,"UPDATE gui_email SET user_id='$tach_u_gui',da_gui='$u' WHERE id='{$r_g['id']}'");
					}else{
						$up=$r_g['da_gui'].','.$u;
						mysqli_query($conn,"UPDATE gui_email SET user_id='$tach_u_gui',da_gui='$up' WHERE id='{$r_g['id']}'");
					}
				}else{
					$u=$r_g['user_id'];
					mysqli_query($conn,"UPDATE gui_email SET user_id='',da_gui='$u',status='1' WHERE id='{$r_g['id']}'");
				}
				$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$u'");
				$r_user=mysqli_fetch_assoc($thongtin_user);
				$ok = 1;
				$thongbao = 'Gửi thông báo booking mới thành công';
				$tach_container=json_decode($r_tt['list_container'],true);
				$stt=0;
				foreach ($tach_container as $key => $value) {
					$stt++;
					$list_container.='<li>Container '.$stt.': '.$value['thoi_gian'].' '.$value['ngay_trahang'].'</li>';
				}
				$loai_hinh=$r_tt['loai_hinh'];
				if($r_tt['mat_hang']=='khac'){
					$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
				}
				if($r_tt['loai_hinh']=='hangxuat'){
					$info_dong_tra='        
				        <div class="info-section">
				            <h2>Ngày Giờ Đóng Hàng:</h2>
				            <ul>
				            	'.$list_container.'
				            </ul>
				        </div>
				        <div class="info-section">
				            <h2>Địa Điểm Đóng Hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['diachi_donghang'].'/'.$r_tt['ten_xa'].'/'.$r_tt['ten_huyen'].'/'.$r_tt['ten_tinh'].'</p>
				        </div>
				        <div class="info-section">
				            <h2>Địa Điểm trả hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['ten_cang'].'</p>
				        </div>';
				    $r_tt['loai_hinh']='Hàng xuất';
				}else if($r_tt['loai_hinh']=='hangnhap'){
					$info_dong_tra='
						<div class="info-section">
				            <h2>Địa Điểm đóng hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['ten_cang'].'</p>
				        </div>
				        <div class="info-section">
				            <h2>Ngày Giờ trả hàng:</h2>
				            <ul>
				            	'.$list_container.'
				            </ul>
				        </div>
				        <div class="info-section">
				            <h2>Địa Điểm trả hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['diachi_trahang'].'/'.$r_tt['ten_xa'].'/'.$r_tt['ten_huyen'].'/'.$r_tt['ten_tinh'].'</p>
				        </div>';
				    $r_tt['loai_hinh']='Hàng nhập';
				}else if($r_tt['loai_hinh']=='hang_noidia'){
					$info_dong_tra='
						<div class="info-section">
				            <h2>Địa Điểm đóng hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['diachi_donghang'].'/'.$r_tt['ten_xa_donghang'].'/'.$r_tt['ten_huyen_donghang'].'/'.$r_tt['ten_tinh_donghang'].'</p>
				        </div>
				        <div class="info-section">
				            <h2>Ngày Giờ trả hàng:</h2>
				            <ul>
				            	'.$list_container.'
				            </ul>
				        </div>
				        <div class="info-section">
				            <h2>Địa Điểm trả hàng:</h2>
				            <p>Địa chỉ: '.$r_tt['diachi_trahang'].'/'.$r_tt['ten_xa'].'/'.$r_tt['ten_huyen'].'/'.$r_tt['ten_tinh'].'</p>
				        </div>';
				    $r_tt['loai_hinh']='Hàng nội địa';
				}
				$r_tt['info_dong_tra']=$info_dong_tra;
				$r_tt['ho_ten']=$r_user['name'];
				$r_tt['nam']=date('Y');
				$r_tt['gia']=number_format($r_tt['gia']);
				$mailer = new PHPMailer(); // khởi tạo đối tượng
				$mailer->IsSMTP(); // gọi class smtp để đăng nhập
				$mailer->CharSet = "utf-8"; // bảng mã unicode
				$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
				$mailer->SMTPSecure = "ssl"; // Giao thức SSL
				$mailer->Host = $index_setting['email_server']; // SMTP của GMAIL
				$mailer->Port = $index_setting['email_server_port']; // cổng SMTP
				$mailer->Username = $index_setting['email']; // GMAIL username
				$mailer->Password = $index_setting['email_password']; // GMAIL password
				$mailer->FromName = $index_setting['email_name']; // tên người gửi
				$mailer->From = $index_setting['email']; // mail người gửi
				$mailer->AddAddress($r_user['email'], $r_user['name']); //thêm mail của admin
				$mailer->Subject = 'Có một booking '.$r_tt['loai_hinh'].' mới dành cho bạn';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				if($loai_hinh=='hangnhap'){
					$mailer->Body =$skin->skin_replace('skin/email_booking_nhap_moi', $r_tt);
				}else if($loai_hinh=='hangxuat'){
					$mailer->Body =$skin->skin_replace('skin/email_booking_xuat_moi', $r_tt);
				}else if($loai_hinh=='hang_noidia'){
					$mailer->Body =$skin->skin_replace('skin/email_booking_noidia_moi', $r_tt);
				}
				$mailer->Send();
			}
		}
	}
}else if($action=='dat_booking'){
	$batdau=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$ketthuc=mktime(23,59,59,date('m'),date('d'),date('Y'));
	$thongtin_gui=mysqli_query($conn,"SELECT * FROM gui_email WHERE status='0' AND loai='dat_booking' AND date_post<='$ketthuc' AND date_post>='$batdau' ORDER BY id ASC LIMIT 1");
	$total_gui=mysqli_num_rows($thongtin_gui);
	if($total_gui==0){
		echo "Không còn dữ liệu để xử lý";
	}else{
		$r_g=mysqli_fetch_assoc($thongtin_gui);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='{$r_g['booking']}'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok = 0;
			$thongbao = 'Thất bại! Booking không tồn tại';
		}else{
			$thongtin_booking=mysqli_query($conn,"SELECT bk.*,lc.so_hieu,lc.ngay,lc.thoi_gian FROM list_container lc LEFT JOIN booking bk ON lc.ma_booking=bk.ma_booking WHERE lc.id='{$r_g['booking']}'");
			$r_bk=mysqli_fetch_assoc($thongtin_booking);
			if($r_g['user_id']==''){
				$ok = 0;
				$thongbao = 'Thất bại! Không có người nhận';
			}else{
				$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_g['user_id']}'");
				$r_user=mysqli_fetch_assoc($thongtin_user);
				$r_bk['ho_ten']=$r_user['name'];
				$r_bk['nam']=date('Y');
				$r_bk['gia']=number_format($r_bk['gia']);
				$r_bk['gia_dat']=number_format($r_tt['gia']);
				$r_bk['ngay_dat']=$r_tt['ngay'];
				$r_bk['thoi_gian_dat']=$r_tt['thoi_gian'];
				$noidung=$skin->skin_replace('skin/email_dat_booking', $r_bk);
				mysqli_query($conn,"UPDATE gui_email SET user_id='',da_gui='{$r_g['user_id']}',status='1' WHERE id='{$r_g['id']}'");
				$mailer = new PHPMailer(); // khởi tạo đối tượng
				$mailer->IsSMTP(); // gọi class smtp để đăng nhập
				$mailer->CharSet = "utf-8"; // bảng mã unicode
				$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
				$mailer->SMTPSecure = "ssl"; // Giao thức SSL
				$mailer->Host = $index_setting['email_server']; // SMTP của GMAIL
				$mailer->Port = $index_setting['email_server_port']; // cổng SMTP
				$mailer->Username = $index_setting['email']; // GMAIL username
				$mailer->Password = $index_setting['email_password']; // GMAIL password
				$mailer->FromName = $index_setting['email_name']; // tên người gửi
				$mailer->From = $index_setting['email']; // mail người gửi
				$mailer->AddAddress($r_user['email'], $r_user['name']); //thêm mail của admin
				$mailer->Subject = 'Booking của bạn vừa được đặt';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				$mailer->Body =$noidung;
				$mailer->Send();
			}
		}
	}
}else if($action=='xacnhan_booking'){
	$batdau=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$ketthuc=mktime(23,59,59,date('m'),date('d'),date('Y'));
	$thongtin_gui=mysqli_query($conn,"SELECT * FROM gui_email WHERE status='0' AND loai='xacnhan_booking' AND date_post<='$ketthuc' AND date_post>='$batdau' ORDER BY id ASC LIMIT 1");
	$total_gui=mysqli_num_rows($thongtin_gui);
	if($total_gui==0){
		echo "Không còn dữ liệu để xử lý";
	}else{
		$r_g=mysqli_fetch_assoc($thongtin_gui);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='{$r_g['booking']}'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok = 0;
			$thongbao = 'Thất bại! Booking không tồn tại';
		}else{
			$thongtin_booking=mysqli_query($conn,"SELECT bk.*,lc.so_hieu,lc.ngay,lc.thoi_gian FROM list_container lc LEFT JOIN booking bk ON lc.ma_booking=bk.ma_booking WHERE lc.id='{$r_g['booking']}'");
			$r_bk=mysqli_fetch_assoc($thongtin_booking);
			if($r_g['user_id']==''){
				$ok = 0;
				$thongbao = 'Thất bại! Không có người nhận';
			}else{
				$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_g['user_id']}'");
				$r_user=mysqli_fetch_assoc($thongtin_user);
				$thongtin_dang=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
				$r_dang=mysqli_fetch_assoc($thongtin_dang);
				$r_bk['ho_ten']=$r_user['name'];
				$r_bk['nam']=date('Y');
				$r_bk['gia']=number_format($r_bk['gia']);
				$r_bk['gia_dat']=number_format($r_tt['gia']);
				$r_bk['ngay_dat']=$r_tt['ngay'];
				$r_bk['thoi_gian_dat']=$r_tt['thoi_gian'];
				$r_bk['nguoi_lienhe']=$r_dang['name'];
				$r_bk['cong_ty']=$r_dang['cong_ty'];
				$r_bk['dien_thoai']=$r_dang['mobile'];
				$noidung=$skin->skin_replace('skin/email_xacnhan_booking', $r_bk);
				mysqli_query($conn,"UPDATE gui_email SET user_id='',da_gui='{$r_g['user_id']}',status='1' WHERE id='{$r_g['id']}'");
				$mailer = new PHPMailer(); // khởi tạo đối tượng
				$mailer->IsSMTP(); // gọi class smtp để đăng nhập
				$mailer->CharSet = "utf-8"; // bảng mã unicode
				$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
				$mailer->SMTPSecure = "ssl"; // Giao thức SSL
				$mailer->Host = $index_setting['email_server']; // SMTP của GMAIL
				$mailer->Port = $index_setting['email_server_port']; // cổng SMTP
				$mailer->Username = $index_setting['email']; // GMAIL username
				$mailer->Password = $index_setting['email_password']; // GMAIL password
				$mailer->FromName = $index_setting['email_name']; // tên người gửi
				$mailer->From = $index_setting['email']; // mail người gửi
				$mailer->AddAddress($r_user['email'], $r_user['name']); //thêm mail của admin
				$mailer->Subject = 'Booking của bạn vừa được chấp nhận';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				$mailer->Body =$noidung;
				$mailer->Send();
			}
		}
	}
}
?>