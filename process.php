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
if ($action == 'get_popup') {
	if (isset($_COOKIE['user_id'])) {
		$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
		$user_id = $tach_token['user_id'];
		$gioihan = time() - 15 * 24 * 3600;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE FIND_IN_SET($user_id,poped)<1 AND pop='1' AND date_post>'$gioihan' AND (FIND_IN_SET($user_id,nhan)>0 OR nhan='') AND shop='0' ORDER BY id ASC LIMIT 1");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			$ok = 0;
		} else {
			$ok = 1;
			$r_tt = mysqli_fetch_assoc($thongtin);
			$tach_doc = explode(',', $r_tt['poped']);
			if (in_array($user_id, $tach_doc) == true) {
			} else {
				if ($r_tt['poped'] == '') {
					mysqli_query($conn, "UPDATE thongbao_shop SET poped='$user_id' WHERE id='{$r_tt['id']}'");
				} else {
					$doc = $r_tt['poped'] . ',' . $user_id;
					mysqli_query($conn, "UPDATE thongbao_shop SET poped='$doc' WHERE id='{$r_tt['id']}'");
				}
			}
			$content = '<a href="/thongbao-chitiet?id=' . $r_tt['id'] . '"><img src="' . $r_tt['img_pop'] . '" alt="' . $r_tt['tieu_de'] . '"></a>';
			//$content='';
		}
	} else {
		$user_id = 0;
		$ok = 0;
		$content = '';
	}
	$info = array(
		'ok' => $ok,
		'content' => $content,
	);
	echo json_encode($info);
} else if ($action == 'check_login') {
	if (isset($_COOKIE['user_id'])) {
		$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
		$user_id = $user_info['user_id'];
		if ($user_info['nhom'] == 0) {
			$ok = 1;
			$thongbao = 'Hệ thống đang chuyển hướng';
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Tài khoản của bạn không thể tạo booking';
		}
	} else {
		$ok = 0;
		$thongbao = 'Thất bại! Bạn chưa đăng nhập';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'get_opt') {
	include('includes/sms_class.php');
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$thongtin_dienthoai = mysqli_query($conn, "SELECT * FROM user_info WHERE mobile='$dien_thoai' AND shop='0' AND active='1'");
	$total_dienthoai = mysqli_num_rows($thongtin_dienthoai);
	if ($total_dienthoai > 0) {
		$ok = 0;
		$thongbao = 'Thất bại! Số điện thoại đã tồn tại';
	} else {
		$thongtin = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' ORDER BY id DESC LIMIT 1");
		$total = mysqli_num_rows($thongtin);
		$code_otp = $check->random_number(6);
		$hientai = time();
		if ($total < 1) {
			$thongtin_ip = mysqli_query($conn, "SELECT * FROM code_otp WHERE ip_address='$ip_address'");
			$total_ip = mysqli_num_rows($thongtin_ip);
			if ($total_ip < 2) {
				try {
					//if($dien_thoai=='0559695525'){
					$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp, "19|1");
					//}else{
					//$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: ".$code_otp,"20|1");
					//}
					$ok = 1;
					$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
					mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
				} catch (Exception $e) {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
			}
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ((time() - $r_tt['date_post']) > 60) {
				try {
					//if($dien_thoai=='0559695525'){
					$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp, "19|1");
					//}else{
					//	$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: ".$code_otp,"20|1");
					//}
					mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
					$ok = 1;
					$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
				} catch (Exception $e) {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'code' => $code
	);
	echo json_encode($info);
} else if ($action == 'get_opt_password') {
	include('includes/sms_class.php');
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$thongtin_dienthoai = mysqli_query($conn, "SELECT * FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
	$total_dienthoai = mysqli_num_rows($thongtin_dienthoai);
	if ($total_dienthoai == 0) {
		$ok = 0;
		$thongbao = 'Thất bại! Số điện thoại không tồn tại';
	} else {
		$thongtin = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' ORDER BY id DESC");
		$total = mysqli_num_rows($thongtin);
		$code_otp = $check->random_number(6);
		$hientai = time();
		if ($total < 1) {
			$thongtin_ip = mysqli_query($conn, "SELECT * FROM code_otp WHERE ip_address='$ip_address'");
			$total_ip = mysqli_num_rows($thongtin_ip);
			if ($total_ip < 2) {
				try {
					//if($dien_thoai=='0559695525'){
					$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp, "19|1");
					//}else{
					//	$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: ".$code_otp,"20|1");
					//}
					$ok = 1;
					$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
					mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
				} catch (Exception $e) {
					$ok = 0;
					$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
				}
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
			}
		} else {
			if ($total >= 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Bạn đã yêu cầu mã quá nhiều lần!<br>Hãy liên hệ hotline để được hỗ trợ';
			} else {
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ((time() - $r_tt['date_post']) > 60) {
					try {
						//if($dien_thoai=='0559695525'){
						$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: " . $code_otp, "19|1");
						//}else{
						//	$msg = sendSingleMessage($dien_thoai, "Ma xac nhan cua ban la: ".$code_otp,"20|1");
						//}
						mysqli_query($conn, "INSERT INTO code_otp(dien_thoai,otp,ip_address,date_post)VALUES('$dien_thoai','$code_otp','$ip_address','$hientai')");
						$ok = 1;
						$thongbao = 'Mã xác nhận đã được gửi tới số điện thoại của bạn';
					} catch (Exception $e) {
						$ok = 0;
						$thongbao = 'Thất bại! Gặp lỗi gửi mã xác nhận';
					}
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Vui lòng thử lại sau 1 phút';
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'code' => $code
	);
	echo json_encode($info);
} else if ($action == 'load_more_container') {
	$id = intval($_REQUEST['id_container']);
	$thongtin = mysqli_query($conn, "SELECT * FROM list_container WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	$hientai = time();
	if ($total == 0) {
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	} else {
		$r_tt = mysqli_fetch_assoc($thongtin);
		$thongtin_booking = mysqli_query($conn, "SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
		$r_booking = mysqli_fetch_assoc($thongtin_booking);
		$thongtin_container = mysqli_query($conn, "SELECT * FROM list_container  WHERE ma_booking='{$r_tt['ma_booking']}' AND id!='$id'  AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai' ORDER BY date_time ASC");
		$total_container = mysqli_num_rows($thongtin_container);
		if ($total_container == 0) {
			$ok = 0;
			$thongbao = 'Không có thêm dữ liệu';
		} else {
			while ($r_cont = mysqli_fetch_assoc($thongtin_container)) {
				if (isset($_COOKIE['user_id'])) {
					$r_cont['gia'] = number_format($r_booking['gia']);
				} else {
					$r_cont['gia'] = 'Đăng nhập tài khoản để xem được giá';
				}

				if ($r_booking['mat_hang'] == 'khac') {
					$r_cont['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_cont['mat_hang'] = $r_booking['mat_hang'];
				}
				$r_cont['id_more'] = $id;
				$r_cont['ten_hangtau'] = $r_booking['ten_hangtau'];
				$r_cont['ten_loai_container'] = $r_booking['ten_loai_container'];
				$r_cont['han_tra_rong'] = $r_booking['han_tra_rong'];
				$r_cont['ten_xa'] = $r_booking['ten_xa'];
				$r_cont['ten_huyen'] = $r_booking['ten_huyen'];
				$r_cont['ten_tinh'] = $r_booking['ten_tinh'];
				$r_cont['ten_xa_donghang'] = $r_booking['ten_xa_donghang'];
				$r_cont['ten_huyen_donghang'] = $r_booking['ten_huyen_donghang'];
				$r_cont['ten_tinh_donghang'] = $r_booking['ten_tinh_donghang'];
				$r_cont['ten_cang'] = $r_booking['ten_cang'];
				$r_cont['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_cont['diachi_trahang'] = $r_booking['diachi_trahang'];
				if ($r_cont['loai_hinh'] == 'hangnhap') {
					$list .= $skin->skin_replace('skin/box_li/tr_more_hangnhap', $r_cont);
				} else if ($r_cont['loai_hinh'] == 'hang_noidia') {
					$list .= $skin->skin_replace('skin/box_li/tr_more_hang_noidia', $r_cont);
				} else {
					$list .= $skin->skin_replace('skin/box_li/tr_more_hangxuat', $r_cont);
				}
			}
			$ok = 1;
			$thongbao = 'Load dữ liệu thành công';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list' => $list
	);
	echo json_encode($info);

} else if ($action == 'goiy_tinh') {
	$text = addslashes(strip_tags($_REQUEST['text']));
	$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi WHERE tieu_de LIKE '%$text%' ORDER BY tieu_de ASC LIMIT 10");
	$total = mysqli_num_rows($thongtin);
	if ($total == 0) {
		$ok = 0;
		$list = '';
	} else {
		$ok = 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .= '<div class="li_goiy li_goiy_tinh" value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'goiy_hangtau') {
	$text = addslashes(strip_tags($_REQUEST['text']));
	$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau WHERE tieu_de LIKE '%$text%' OR viet_tat LIKE '%$text%' ORDER BY tieu_de ASC LIMIT 10");
	$total = mysqli_num_rows($thongtin);
	if ($total == 0) {
		$ok = 0;
		$list = '';
	} else {
		$ok = 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .= '<div class="li_goiy li_goiy_hangtau" value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '(' . $r_tt['viet_tat'] . ')</div>';
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'timkiem_booking') {
	$loai_hinh = addslashes(strip_tags($_REQUEST['loai_hinh']));
	$hang_tau = intval($_REQUEST['hang_tau']);
	$loai_container = intval($_REQUEST['loai_container']);
	$from = addslashes($_REQUEST['from']);
	$to = addslashes($_REQUEST['to']);
	$dia_diem = addslashes(strip_tags($_REQUEST['dia_diem']));
	$dia_diem_id = intval($_REQUEST['dia_diem_id']);
	$tach_list = json_decode($class_index->timkiem_booking($conn, $loai_hinh, $hang_tau, $loai_container, $from, $to, $dia_diem_id), true);
	if ($tach_list['total'] == 0) {
		$ok = 0;
		$thongbao = 'Không có kết quả phù hợp';
		$list = '';
	} else {
		$ok = 1;
		$thongbao = 'Tìm booking thành công';
		if ($loai_hinh == 'hangnhap') {
			$list = ' <tr>
                        <th width="120">Hãng tàu</th>
                        <th width="120">Loại container</th>
                        <th width="80">Số lượng</th>
                        <th width="120">Mặt hàng</th>
                        <th>Địa điểm trả hàng</th>
                        <th width="150">Thời gian trả hàng</th>
                        <th width="150">Cước vận chuyển</th>
                        <th width="130">Hành động</th>
                    </tr>' . $tach_list['list'];
		} else if ($loai_hinh == 'hang_noidia') {
			$list = ' <tr>
                        <th width="120">Loại container</th>
                        <th width="80">Số lượng</th>
                        <th width="120">Mặt hàng</th>
                        <th>Địa điểm đóng hàng</th>
                        <th width="150">Thời gian đóng hàng</th>
                        <th>Địa điểm trả hàng</th>
                        <th width="150">Cước vận chuyển</th>
                        <th width="130">Hành động</th>
                    </tr>' . $tach_list['list'];
		} else {
			$list = ' <tr>
                        <th width="120">Hãng tàu</th>
                        <th width="120">Loại container</th>
                        <th width="80">Số lượng</th>
                        <th width="120">Mặt hàng</th>
                        <th>Địa điểm đóng hàng</th>
                        <th width="150">Thời gian trả hàng</th>
                        <th width="150">Cước vận chuyển</th>
                        <th width="130">Hành động</th>
                    </tr>' . $tach_list['list'];
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'total' => $tach_list['total'],
		'thongbao' => $thongbao
	);
	echo json_encode($info);
} else if ($action == 'register') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_passpord = addslashes(strip_tags($_REQUEST['re_password']));
	
	
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ email';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_passpord) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai'");
		$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
		if ($r_mobile['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại đã đăng ký';
		} else {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) total FROM user_info WHERE email='$email'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Địa chỉ email đã đăng ký';
			} else {
				$ok = 1;
				$thongbao = 'Đăng ký tài khoản thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				$code_active = $check->random_string(10);
				
				mysqli_query($conn, "INSERT INTO user_info(admin_cty,username,password,email,name,avatar,mobile,dia_chi,so_hopdong,time_hopdong,so_cccd,ngay_cap_cccd,loai_hopdong,active,nhom,emin_group,phong_ban,date_post,update_post) VALUES('','$dien_thoai','$pass','$email','$ho_ten','','$dien_thoai','','','','','','','1','1','1','','$hientai','$hientai')");
				$new_user_id = mysqli_insert_id($conn);

				mysqli_query($conn, "INSERT INTO admin_cty(admin_id, date_post)VALUES('$new_user_id', '$hientai')");
				$id_admin_cty = mysqli_insert_id($conn);

				mysqli_query($conn, "UPDATE user_info SET admin_cty = '$id_admin_cty'WHERE user_id = '$new_user_id'");

			}
		}
	}
	echo json_encode(array('ok' => $ok, 'email' => $email, 'thongbao' => $thongbao));
} else if ($action == 'dangky_nhantin') {
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$noi_dung = addslashes(strip_tags($_REQUEST['noi_dung']));
	$hientai = time();
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ email';
	} else {
		$thongtin = mysqli_query($conn, "SELECT * FROM lien_he WHERE dien_thoai='$dien_thoai' OR email='$email' ORDER BY id DESC LIMIT 1");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			$ok = 1;
			$thongbao = 'Đăng ký nhân tự vấn thành công';
			mysqli_query($conn, "INSERT INTO lien_he(ho_ten,email,dien_thoai,noi_dung,status,date_post)VALUES('$ho_ten','$email','$dien_thoai','$noi_dung','0','$hientai')");
			
			$link_active = $index_setting['link_domain'] . 'confirm_account.php?email=' . $email . '&token=' . $code_active;
			$email_replace = array(
				'ho_ten' => $ho_ten,
				'email' => $email,
				'dien_thoai' => $dien_thoai,
				'noi_dung' => $noi_dung,
				'link_xacnhan' => $link_active
			);
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
			$mailer->AddAddress('hoanganhngoc2912@gmail.com'); //thêm mail của admin	
			$mailer->Subject = 'Xác nhận tài khoản hỗ trợ';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = $skin->skin_replace('skin/email_hotro_khachhang', $email_replace);
			$mailer->Send();
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin);
			$gioihan = time() - $r_tt['date_post'];
			if ($gioihan > 300) {
				$ok = 1;
				$thongbao = 'Đăng ký nhân tự vấn thành công';
				mysqli_query($conn, "INSERT INTO lien_he(ho_ten,email,dien_thoai,noi_dung,status,date_post)VALUES('$ho_ten','$email','$dien_thoai','$noi_dung','0','$hientai')");
			} else {
				$ok = 0;
				$thongbao = 'Thất bại! Bạn thực hiện quá nhanh';
			}

			
		}
	}
	echo json_encode(array('ok' => $ok, 'thongbao' => $thongbao));
} else if ($action == 'change_profile') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	$ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$ngay_sinh = addslashes(strip_tags($_REQUEST['ngay_sinh']));
	$dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if (strlen($ho_ten) < 4) {
		$ok = 0;
		$thongbao = 'Họ và tên quá ngắn';
	} else if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Thất bại! Địa chỉ email không đúng';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($ngay_sinh) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập ngày sinh';
	} else if (strlen($dia_chi) < 5) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ';
	} else {
		if ($email != $user_info['email']) {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' AND shop='0'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Email đã tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Lưu thay đổi thành công!';
				mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',mobile='$dien_thoai',ngaysinh='$ngay_sinh',dia_chi='$dia_chi' WHERE user_id='$user_id'");
			}
		} else {
			$ok = 1;
			$thongbao = 'Lưu thay đổi thành công!';
			mysqli_query($conn, "UPDATE user_info SET name='$ho_ten',email='$email',mobile='$dien_thoai',ngaysinh='$ngay_sinh',dia_chi='$dia_chi' WHERE user_id='$user_id'");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'change_avatar') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
		$minh_hoa = '/uploads/avatar/' . $check->blank($user_info['name']) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
		@unlink('.' . $user_info['avatar']);
		$thongbao = 'Thay hình đại diện thành công';
		$ok = 1;
		mysqli_query($conn, "UPDATE user_info SET avatar='$minh_hoa' WHERE user_id='$user_id'");
	} else {
		$thongbao = 'Vui lòng chọn ảnh đại diện';
		$ok = 0;
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'change_password') {
	if (!isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập...'));
		exit();
	}
	$password = addslashes(strip_tags($_REQUEST['password']));
	$pass_old = md5($password);
	$new_password = addslashes(strip_tags($_REQUEST['new_password']));
	$confirm_password = addslashes(strip_tags($_REQUEST['confirm_password']));
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($pass_old != $user_info['password']) {
		$ok = 0;
		$thongbao = 'Mật khẩu hiện tại không đúng';
	} else if (strlen($new_password) < 6) {
		$ok = 0;
		$thongbao = 'Mật khẩu mới phải dài từ 6 ký tự';
	} else if ($new_password != $confirm_password) {
		$ok = 0;
		$thongbao = 'Nhập lại mật khẩu mới không đúng';
	} else {
		$thongbao = 'Thành công! Đã cập nhật mật khẩu mới';
		$ok = 1;
		$pass_new = md5($new_password);
		mysqli_query($conn, "UPDATE user_info SET password='$pass_new' WHERE user_id='$user_id'");
		setcookie("user_id", $_COOKIE['user_id'], time() - 3600);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'forgot_password') {
	if (isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Bạn đã đăng nhập...'));
		exit();
	}
	$password = addslashes(strip_tags($_REQUEST['password']));
	$re_passpord = addslashes(strip_tags($_REQUEST['re_password']));
	$dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
	$ma_xacnhan = addslashes(strip_tags($_REQUEST['ma_xacnhan']));
	if (strlen($dien_thoai) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_passpord) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin_otp = mysqli_query($conn, "SELECT * FROM code_otp WHERE dien_thoai='$dien_thoai' AND otp='$ma_xacnhan'");
		$total_otp = mysqli_num_rows($thongtin_otp);
		if ($total_otp == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Mã xác nhận không đúng';
		} else {
			$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai' AND shop='0'");
			$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
			if ($r_mobile['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Số điện thoại không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Đổi mật khẩu tài khoản thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				mysqli_query($conn, "UPDATE user_info SET password='$pass' WHERE mobile='$dien_thoai' AND shop='0'");
				mysqli_query($conn, "DELETE FROM code_otp WHERE dien_thoai='$dien_thoai'");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'quen_matkhau') {
	if (isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Bạn đã đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	if ($check->check_email($email) == false and strlen($email) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập email hoặc số điện thoại';
	} else {
		$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email' OR mobile='$email'");
		$r_tt = mysqli_fetch_assoc($thongtin_email);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Tài khoản không tồn tại';
		} else {
			$code_active = $check->random_string(10);
			$passnew = $check->random_number(8);
			$link_active = $index_setting['link_domain'] . 'confirm_password.php?email=' . $r_tt['email'] . '&token=' . $code_active;
			$email_replace = array(
				'ho_ten' => $r_tt['name'],
				'nam' => date('Y'),
				'link_xacnhan' => $link_active
			);
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
			$mailer->AddAddress($r_tt['email'], $r_tt['name']); //thêm mail của admin
			$mailer->Subject = 'Yêu cầu lấy lại mật khẩu';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = $skin->skin_replace('skin/email_forgot_password', $email_replace);
			if ($mailer->Send() == true) {
				mysqli_query($conn, "INSERT INTO forgot_password (email,password,code_active,date_post)VALUES('{$r_tt['email']}','$passnew','$code_active'," . time() . ")");
				$ok = 1;
				$thongbao = 'Yêu cầu lấy lại mật khẩu thành công';
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
				$mailer->AddAddress('xahoigiaitri@gmail.com', 'Hỗ trợ sóc đỏ'); //thêm mail của admin
				$mailer->Subject = 'Yêu cầu lấy lại mật khẩu';
				$mailer->IsHTML(true); //Bật HTML không thích thì false
				$mailer->Body = $skin->skin_replace('skin/email_forgot_password', $email_replace);
				$mailer->Send();
			} else {
				$ok = 0;
				$thongbao = 'Gặp lỗi trong quá trình gửi mail';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'email' => $r_tt['email'],
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'save_password') {
	$token = addslashes($_REQUEST['token']);
	$email = addslashes(strip_tags($_REQUEST['email']));
	$password = addslashes($_REQUEST['password']);
	$re_password = addslashes($_REQUEST['re_password']);
	if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu phải dài từ 6 ký tự';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin = mysqli_query($conn, "SELECT * FROM forgot_password WHERE email='$email' AND code_active='$token'");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Link xác nhận đã được sử dụng';
		} else {
			$ok = 1;
			$thongbao = 'Thành công! Mật khẩu mới đã được lưu';
			$thongtin_email = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE email='$email'");
			$r_tt = mysqli_fetch_assoc($thongtin_email);
			$passnew = md5($password);
			mysqli_query($conn, "UPDATE user_info SET password='$passnew' WHERE email='$email'");
			mysqli_query($conn, "DELETE FROM forgot_password WHERE email='$email'");
			function token_login($user_id, $password)
			{
				$pass_1 = substr($password, 0, 8);
				$pass_2 = substr($password, 8, 8);
				$pass_3 = substr($password, 16, 8);
				$pass_4 = substr($password, 24, 8);
				$string = $pass_1 . '-' . $pass_3 . '-' . $pass_2 . '' . $user_id . '-' . $pass_2 . '-' . $pass_4;
				$token_login = base64_encode($string);
				return $token_login;
			}
			setcookie("user_id", token_login($r_tt['user_id'], $passnew), time() + 2593000, '/');
			$email_replace = array(
				'ho_ten' => $r_tt['name'],
				'nam' => date('Y')
			);
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
			$mailer->AddAddress($r_tt['email'], $r_tt['name']); //thêm mail của admin
			$mailer->Subject = 'Thiết lập mật khẩu mới thành công';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = $skin->skin_replace('skin/email_new_password', $email_replace);
			$mailer->Send();
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'timkiem') {
	$key = addslashes(strip_tags($_REQUEST['key_search']));
	$key = strtolower($key);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM dangky_email WHERE ma_don='$key' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$ok = 0;
		$thongbao = 'Không tìm thấy kết quả phù hợp';
	} else {
		$ok = 1;
		$thongbao = 'Đã tìm thấy! Hệ thống đang chuyển hướng';
		$link = '/tracuu-detail.html?hoso=' . $key;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);


}
else if ($action == 'goi_y') {
	$key = addslashes(strip_tags($_REQUEST['key']));
	$thongtin = mysqli_query($conn, "SELECT * FROM truyen WHERE tieu_de LIKE '%$key%' AND chap!='' ORDER BY tieu_de ASC LIMIT 10");
	$total = mysqli_num_rows($thongtin);
	if ($total == 0) {
		$list = '<center>Không có kết quả phù hợp</center>';
	} else {
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .= $skin->skin_replace('skin/box_li/li_timkiem', $r_tt);
		}
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'lienhe') {
	$name = addslashes(strip_tags($_REQUEST['ho_ten']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$subject = addslashes(strip_tags($_REQUEST['tieu_de']));
	$message = addslashes(strip_tags($_REQUEST['noi_dung']));
	if ($name == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên của bạn';
	} else if ($email == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập địa chỉ email';
	} else if ($subject == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập chủ đề';
	} else if ($message == '') {
		$ok = 0;
		$thongbao = 'Vui lòng nhập nội dung';
	} elseif (time() - $_SESSION['contact'] < 15) {
		$ok = 0;
		$thongbao = 'Bạn thực hiện quá nhanh';
	} else {
		$ok = 1;
		mysqli_query($conn, "INSERT INTO contact (name,email,subject,message,date_post)VALUES('$name','$email','$subject','$message'," . time() . ")");
		$_SESSION['contact'] = time();
		$thongbao = 'Cảm ơn bạn! Việc liên hệ đã thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'check_blank') {
	$link = $check->blank($_REQUEST['link']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else if ($action == 'check_link') {
	$link = $check->blank($_REQUEST['link']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else {
	echo "Không có hành động nào được xử lý";
}
