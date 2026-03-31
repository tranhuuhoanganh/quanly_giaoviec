<?php
include '../includes/tlca_world.php';
include_once "../class.phpmailer.php";
require_once '../PHPExcel/PHPExcel.php';
require_once '../PHPExcel/PHPExcel/IOFactory.php';
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_cpanel');
$class_viettel = $tlca_do->load('class_viettel');
$class_ninja_van = $tlca_do->load('class_ninja_van');
$skin = $tlca_do->load('class_skin_cpanel');
$class_giaoviec = $tlca_do->load('class_giaoviec');
$class_member = $tlca_do->load('class_member');
$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
$user_id=$user_info['user_id'];
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if ($action == "dangnhap") {
	$username = addslashes(strip_tags($_REQUEST['username']));
	$password = addslashes($_REQUEST['password']);
	$remember = strip_tags(addslashes($_REQUEST['remember']));
	$ketqua = $class_e_member->login($conn, $username, $password, $remember);
	if ($ketqua == 200) {
		$ok = 1;
		$thongbao = "Đăng nhập thành công";
	} else if ($ketqua == 0) {
		$ok = 0;
		$thongbao = "Vui lòng nhập username";
	} else if ($ketqua == 1) {
		$ok = 0;
		$thongbao = "Tài khoản không tồn tại";
	} else if ($ketqua == 2) {
		$ok = 0;
		$thongbao = "Mật khẩu không chính xác";
	} else {
		$ok = 0;
		$thongbao = "Gặp lỗi khi xử lý";
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'load_box_pop_thirth') {
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'add_yeucau_lienhe') {
		$thanh_vien=intval($_REQUEST['thanh_vien']);
		$bien = array(
			'thanh_vien'=>$thanh_vien
		);
		$html = $skin->skin_replace('skin_members/box_action/pop_add_yeucau_hotro', $bien);
	}
	$info = array(
		'html' => $html,
	);
	echo json_encode($info);
}else if($action=='active_user'){
	$user_id=intval($_REQUEST['user_id']);
	mysqli_query($conn,"UPDATE user_info SET active='1' WHERE user_id='$user_id'");
	$info = array(
		'ok' => 1,
		'thongbao' => 'Kích hoạt thành viên thành công',
	);
	echo json_encode($info);
}else if($action=='update_note_baohanh'){
	$id=intval($_REQUEST['id']);
	$noidung=addslashes($_REQUEST['noidung']);
	mysqli_query($conn,"UPDATE kichhoat_baohanh SET note='$noidung' WHERE id='$id'");

}else if($action=='update_note_hotro'){
	$id=intval($_REQUEST['id']);
	$noidung=addslashes($_REQUEST['noidung']);
	mysqli_query($conn,"UPDATE pop_hotro SET note='$noidung' WHERE id='$id'");

}else if($action=='load_list_yeucau'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$list_yeucau=$class_index->list_yeucau($conn,$user_info['user_id'],$user_info['bo_phan'],$r_tt['thanh_vien']);
	if($user_info['bo_phan']=='all'){
		$thongtin=mysqli_query($conn,"SELECT * FROM notification_admin WHERE FIND_IN_SET($user_id,doc)<1");
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM notification_admin WHERE bo_phan='{$user_info['bo_phan']}' AND FIND_IN_SET($user_id,doc)<1");
	}
	$total=mysqli_num_rows($thongtin);
	if($total>9){
		$total='9+';
	}else{
		$total=$total;
	}
	$thongtin_naptien=mysqli_query($conn,"SELECT * FROM naptien WHERE status='3'");
	$total_naptien=mysqli_num_rows($thongtin_naptien);
	if($total_naptien>9){
		$total_naptien='9+';
	}else{
		$total_naptien=$total_naptien;
	}
	$thongtin_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE status='0' OR status='2' OR status='3'");
	$total_booking_wait=0;
	$total_booking_confirm=0;
	$total_booking_false=0;
	while($r_bk=mysqli_fetch_assoc($thongtin_booking)){
		if($r_bk['status']==0){
			$total_booking_wait++;
		}else if($r_bk['status']==2){
			$total_booking_confirm++;
		}else if($r_bk['status']==3){
			$total_booking_false++;
		}
	}
	if($total_booking_wait>9){
		$total_booking_wait='9+';
	}else{
		$total_booking_wait=$total_booking_wait;
	}
	if($total_booking_confirm>9){
		$total_booking_confirm='9+';
	}else{
		$total_booking_confirm=$total_booking_confirm;
	}
	if($total_booking_false>9){
		$total_booking_false='9+';
	}else{
		$total_booking_false=$total_booking_false;
	}
	if($user_info['bo_phan']=='all'){
		$thongke_chat=mysqli_query($conn,"SELECT count(*) AS total FROM chat WHERE active='1' AND tieu_de='' GROUP BY thanh_vien");
	}else{
		$thongke_chat=mysqli_query($conn,"SELECT count(*) AS total FROM chat WHERE bo_phan='{$user_info['bo_phan']}' AND active='1' AND tieu_de='' GROUP BY thanh_vien");
	}
	$r_chat=mysqli_fetch_assoc($thongke_chat);
	$total_chat=intval($r_chat['total']);
	if($total_chat>9){
		$total_chat='9+';
	}
	$info=array(
		'ok'=>1,
		'total'=>$total,
		'total_booking_wait'=>$total_booking_wait,
		'total_booking_confirm'=>$total_booking_confirm,
		'total_booking_false'=>$total_booking_false,
		'total_naptien'=>$total_naptien,
		'total_chat'=>$total_chat,
		'list'=>$list_yeucau
	);
	echo json_encode($info);
}else if ($action =='add_yeucau_traodoi'){
	$hientai=time();
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$thanh_vien=intval($_REQUEST['thanh_vien']);
	$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$thanh_vien'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if(strlen($noi_dung)<2){
		$ok=0;
		$thongbao='Chưa nhập nội dung lưu ý';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE thanh_vien='$thanh_vien' AND active='1'");
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			$ok=0;
			$thongbao='Thất bại! Thành viên này đang yêu cầu hỗ trợ';
		}else{
			$ok=1;
			$thongbao='Thành công! Liên hệ đã được gửi đi';
			$phien_traodoi=$class_index->creat_random($conn,'phien_traodoi');
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien_traodoi','{$user_info['bo_phan']}','$noi_dung','$thanh_vien','$thanh_vien','{$user_info['user_id']}','','0','1','$hientai')");
			$thay=array(
				'ho_ten'=>$r_tt['name'],
				'mobile'=>$r_tt['mobile'],
				'tieu_de'=>$noi_dung,
				'date_post'=>'Vừa xong',
				'phien'=>$phien_traodoi,
				'thanh_vien'=>$thanh_vien,
				'active'=>'active'
			);
			$list=$skin->skin_replace('skin_cpanel/box_action/li_yeucau', $thay);
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'thanh_vien'=>$thanh_vien,
		'ho_ten'=>$r_tt['name'],
		'phien'=>$phien_traodoi,
		'list'=>$list,
		'phien_traodoi'=>$phien_traodoi,
	);
	echo json_encode($info);
}else if($action=='load_chat_sms'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$sms_id=intval($_REQUEST['sms_id']);
	$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id' ORDER BY id DESC LIMIT 1");
	$r_c=mysqli_fetch_assoc($thongtin_cuoi);
	$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_c['thanh_vien']}'");
	$r_user=mysqli_fetch_assoc($thongtin_thanhvien);
	$tach_chat=json_decode($class_index->list_chat($conn,$user_info['user_id'],$user_info['name'],$user_info['avatar'],$r_user['name'],$r_user['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
	$list_yeucau=$class_index->list_yeucau($conn,$user_info['user_id'],$user_info['bo_phan'],$thanh_vien);
	$ho_ten=$r_tt['name'];
	$note=$r_tt['tieu_de'];
	$info=array(
		'ok'=>1,
		'list_chat'=>$tach_chat['list'],
		'list'=>$list_yeucau,
		'load_chat'=>$tach_chat['load'],
		'ho_ten'=>$ho_ten,
		'note'=>$note,
		'phien'=>$phien,
		'thanh_vien'=>$thanh_vien,
		'user_id'=>$user_info['user_id'],
	);
	echo json_encode($info);
}else if($action=='load_khach_traodoi'){
	$thanh_vien=intval($_REQUEST['thanh_vien']);
	$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.active='1' AND chat.noi_dung='' AND chat.thanh_vien='$thanh_vien' ORDER BY chat.id DESC LIMIT 1");
	$total=mysqli_num_rows($thongtin);
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['thanh_vien']}'");
	$r_user=mysqli_fetch_assoc($thongtin_thanhvien);
	$phien=$r_tt['phien'];
	$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
	$r_c=mysqli_fetch_assoc($thongtin_cuoi);
	$sms_id=$r_c['id'] + 1;
	$tach_chat=json_decode($class_index->list_chat($conn,$user_info['user_id'],$user_info['name'],$user_info['avatar'],$r_user['name'],$r_user['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
	$list_yeucau=$class_index->list_yeucau($conn,$user_info['user_id'],$user_info['bo_phan'],$thanh_vien);
	$ho_ten=$r_tt['name'];
	$note=$r_tt['tieu_de'];
	$info=array(
		'ok'=>1,
		'list_chat'=>$tach_chat['list'],
		'list'=>$list_yeucau,
		'ho_ten'=>$ho_ten,
		'note'=>$note,
		'phien'=>$phien,
		'thanh_vien'=>$thanh_vien,
		'user_id'=>$user_info['user_id'],
	);
	echo json_encode($info);
}else if($action=='add_sms_traodoi'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$sms_id=intval($_REQUEST['sms_id']);
	if(strlen($noi_dung)==''){
		$ok=0;
		$thongbao='Chưa nhập nội dung';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['active']!=1){
			$ok=0;
			$thongbao='Thất bại! Phiên yêu cầu đã đóng';
		}else{
			$hientai=time();
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','{$r_tt['thanh_vien']}','{$r_tt['thanh_vien']}','{$user_info['user_id']}','$noi_dung','0','1','$hientai')");
			$ok=1;
			$thongbao='Gửi thành công';
			$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='{$user_info['user_id']}' ORDER BY chat.id DESC LIMIT 1");
			$r_m=mysqli_fetch_assoc($thongtin_moi);
			$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
			$r_c=mysqli_fetch_assoc($thongtin_cuoi);
			$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
			if($r_c['thanh_vien']==$r_c['user_out']){
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
			}else if($r_c['user_out']!=$user_info['user_id']){
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
			}else{
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left', $r_m);
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'user_out'=>$user_info['user_id'],
		'list_out'=>$list_out,
		'phien'=>$phien,
		'bo_phan'=>$r_tt['bo_phan'],
		'thanh_vien'=>$r_tt['thanh_vien']
	);
	echo json_encode($info);
}else if($action=='add_sticker_traodoi'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$src=addslashes(strip_tags($_REQUEST['src']));
	$sms_id=intval($_REQUEST['sms_id']);
	if(strlen($src)==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập nội dung';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['active']!=1){
			$ok=0;
			$thongbao='Thất bại! Phiên yêu cầu đã đóng';
		}else{
			$noi_dung='<img src="'.$src.'">';
			$hientai=time();
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','{$r_tt['thanh_vien']}','{$r_tt['thanh_vien']}','{$user_info['user_id']}','$noi_dung','0','1','$hientai')");
			$ok=1;
			$thongbao='Gửi thành công';
			$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='{$user_info['user_id']}' ORDER BY chat.id DESC LIMIT 1");
			$r_m=mysqli_fetch_assoc($thongtin_moi);
			$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
			$r_c=mysqli_fetch_assoc($thongtin_cuoi);
			$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
			if($r_c['thanh_vien']==$r_c['user_out']){
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
			}else if($r_c['user_out']!=$user_info['user_id']){
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
			}else{
				$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right', $r_m);
				$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left', $r_m);
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'user_out'=>$user_info['user_id'],
		'list_out'=>$list_out,
		'phien'=>$phien,
		'bo_phan'=>$r_tt['bo_phan'],
		'thanh_vien'=>$r_tt['thanh_vien']
	);
	echo json_encode($info);
}else if($action=='upload_dinhkem'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$sms_id=intval($_REQUEST['sms_id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['active']!=1){
		$ok=0;
		$thongbao='Thất bại! Phiên yêu cầu đã đóng';
	}else{
		$hientai=time();
		$total = count($_FILES['file']['name']);
		$k = 0;
		for ($i = 0; $i < $total; $i++) {
			$filename = $_FILES['file']['name'][$i];
			$duoi = $check->duoi_file($_FILES['file']['name'][$i]);
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp','pdf')) == true) {
				$folder_name = '/uploads/dinh-kem/'.date('d-m-Y').'/';

				if (!file_exists('..' . $folder_name)) {
					mkdir('..' . $folder_name, 0777);
				} else {
				}
				$minh_hoa = $folder_name . '' . $check->blank(str_replace('.' . $duoi, '', $filename)) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
				$pt = '/' . substr($minh_hoa, 1);
				if(in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true){
					$noi_dung='<a href="'.$pt.'" target="_blank"><img src="'.$pt.'"></a>';
				}else{
					$noi_dung='<a href="'.$pt.'" target="_blank"><i class="icon icon-file-pdf"></i> '.$filename.'</a>';
				}
				mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','{$r_tt['thanh_vien']}','{$r_tt['thanh_vien']}','{$user_info['user_id']}','$noi_dung','0','1','$hientai')");
				$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='{$user_info['user_id']}' ORDER BY chat.id DESC LIMIT 1");
				$r_m=mysqli_fetch_assoc($thongtin_moi);
				$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
				$r_c=mysqli_fetch_assoc($thongtin_cuoi);
				$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
				if($r_c['thanh_vien']==$r_c['user_out']){
					$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
					$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
				}else if($r_c['user_out']!=$user_info['user_id']){
					$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $r_m);
					$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $r_m);
				}else{
					$list=$skin->skin_replace('skin_cpanel/box_action/li_chat_right', $r_m);
					$list_out=$skin->skin_replace('skin_cpanel/box_action/li_chat_left', $r_m);
				}
				$k++;
			}
		}
		if($k==0){
			$ok=0;
			$thongbao='Định dạng không được hỗ trợ';
		}else{
			$ok=1;
			$thongbao='Gửi thành công';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'user_out'=>$user_info['user_id'],
		'list_out'=>$list_out,
		'phien'=>$phien,
		'bo_phan'=>$r_tt['bo_phan'],
		'thanh_vien'=>$r_tt['thanh_vien']
	);
	echo json_encode($info);
}else if($action=='dong_yeucau'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['bo_phan']==$user_info['bo_phan'] OR $user_info['emin_group']==1){
		mysqli_query($conn,"UPDATE chat SET active='0',doc='1' WHERE phien='$phien'");
		$ok=1;
		$thongbao='Đóng yêu cầu thành công';
	}else{
		$ok=0;
		$thongbao='Hành động không được hoàn thành';
	}
	$info=array(
		'ok'=>$ok,
		'phien'=>$phien,
		'bo_phan'=>$r_tt['bo_phan'],
		'thanh_vien'=>$r_tt['thanh_vien'],
		'user_out'=>$user_info['user_id'],
		'thongbao'=>$thongbao,
	);
	echo json_encode($info);
}else if ($action == 'goiy_khach'){
	$ten_khach=addslashes(strip_tags($_REQUEST['ten_khach']));
	$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE (name LIKE '%$ten_khach%' OR mobile LIKE '%$ten_khach%' OR username LIKE '%$ten_khach%') ORDER BY name ASC LIMIT 25");
	$total=mysqli_num_rows($thongtin);
	if($total>0){
		$ok=1;
		while($r_tt=mysqli_fetch_assoc($thongtin)){
			$list.='<div class="li_goi_y" thanhvien="'.$r_tt['user_id'].'"><div class="name">'.$r_tt['name'].'</div><div class="dien_thoai">ĐT: '.$r_tt['mobile'].'</div><div class="dien_thoai">Email: '.$r_tt['email'].'</div></div>';
		}
	}else{
		$ok=0;
		$list='';
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
	);
	echo json_encode($info);
}else if($action=='goiy_tinh'){
	$text=addslashes(strip_tags($_REQUEST['text']));
	$thongtin=mysqli_query($conn,"SELECT * FROM tinh_moi WHERE tieu_de LIKE '%$text%' ORDER BY tieu_de ASC LIMIT 10");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$list='';
	}else{
		$ok=1;
		while($r_tt=mysqli_fetch_assoc($thongtin)){
			$list.='<div class="li_goiy" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
	);
	echo json_encode($info);
}else if($action=='timkiem_thanhvien'){
	$key=addslashes($_REQUEST['key']);
	$page=1;
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_thanhvien($conn,$key,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm thành viên thành công';
		$list=$tach_list['list'];
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$hang_tau=intval($_REQUEST['hang_tau']);
	$hang_tau_id=intval($_REQUEST['hang_tau_id']);
	$loai_container=intval($_REQUEST['loai_container']);
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$dia_diem=addslashes(strip_tags($_REQUEST['dia_diem']));
	$dia_diem_id=intval($_REQUEST['dia_diem_id']);
	$page=1;
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking($conn,$user_id,$loai_hinh,$hang_tau_id,$loai_container,$from,$to,$dia_diem_id,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		if($loai_hinh=='hangnhap'){
			$list='<tr>
                        <th class="sticky-row" width="50"></th>
                        <th class="sticky-row" width="100">Mã booking</th>
                        <th class="sticky-row" width="150">Hãng tàu</th>
                        <th class="sticky-row" width="100">Loại container</th>
                        <th class="sticky-row" width="100">Số lượng</th>
                        <th class="sticky-row" width="120">Mặt hàng</th>
                        <th class="sticky-row">Địa điểm trả hàng</th>
                        <th class="sticky-row" width="150">Thời gian trả hàng</th>
                        <th class="sticky-row" width="150">Cước vận chuyển</th>
                        <th class="sticky-row sticky-column" width="120">Hành động</th>
	              </tr>'.$tach_list['list'];
		}else{
			$list='<tr>
	                    <th class="sticky-row" width="50"></th>
	                    <th class="sticky-row" width="100">Mã booking</th>
	                    <th class="sticky-row" width="150">Hãng tàu</th>
	                    <th class="sticky-row" width="100">Loại container</th>
	                    <th class="sticky-row" width="100">Số lượng</th>
	                    <th class="sticky-row" width="120">Mặt hàng</th>
	                    <th class="sticky-row">Địa điểm đóng hàng</th>
	                    <th class="sticky-row" width="150">Thời gian đóng hàng</th>
	                    <th class="sticky-row" width="150">Cước vận chuyển</th>
	                    <th class="sticky-row sticky-column" width="120">Hành động</th>
	              </tr>'.$tach_list['list'];
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='load_timkiem_booking_dashboard'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$hang_tau=intval($_REQUEST['hang_tau']);
	$hang_tau_id=intval($_REQUEST['hang_tau_id']);
	$loai_container=intval($_REQUEST['loai_container']);
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$dia_diem=addslashes(strip_tags($_REQUEST['dia_diem']));
	$dia_diem_id=intval($_REQUEST['dia_diem_id']);
	$limit=25;
	$page=intval($_REQUEST['page']);
	$page++;
	$tach_list=json_decode($class_index->timkiem_booking($conn,$user_id,$loai_hinh,$hang_tau_id,$loai_container,$from,$to,$dia_diem_id,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
		if($tach_list['total']<$limit){
			$tiep=0;
		}else{
			$tiep=1;
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_user'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$hang_tau=intval($_REQUEST['hang_tau']);
	$hang_tau_id=intval($_REQUEST['hang_tau_id']);
	$loai_container=intval($_REQUEST['loai_container']);
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$dia_diem=addslashes(strip_tags($_REQUEST['dia_diem']));
	$dia_diem_id=intval($_REQUEST['dia_diem_id']);
	$page=1;
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_user($conn,$loai_hinh,$hang_tau_id,$loai_container,$from,$to,$dia_diem_id,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		if($loai_hinh=='hangnhap'){
			$list='<tr>
                        <th class="sticky-row" width="50"></th>
                        <th class="sticky-row" width="100">Mã booking</th>
                        <th class="sticky-row" width="150">Hãng tàu</th>
                        <th class="sticky-row" width="100">Loại container</th>
                        <th class="sticky-row" width="100">Số lượng</th>
                        <th class="sticky-row" width="120">Mặt hàng</th>
                        <th class="sticky-row">Địa điểm trả hàng</th>
                        <th class="sticky-row" width="150">Thời gian trả hàng</th>
                        <th class="sticky-row" width="150">Cước vận chuyển</th>
                        <th class="sticky-row sticky-column" width="120">Hành động</th>
	              </tr>'.$tach_list['list'];
		}else{
			$list='<tr>
	                    <th class="sticky-row" width="50"></th>
	                    <th class="sticky-row" width="100">Mã booking</th>
	                    <th class="sticky-row" width="150">Hãng tàu</th>
	                    <th class="sticky-row" width="100">Loại container</th>
	                    <th class="sticky-row" width="100">Số lượng</th>
	                    <th class="sticky-row" width="120">Mặt hàng</th>
	                    <th class="sticky-row">Địa điểm đóng hàng</th>
	                    <th class="sticky-row" width="150">Thời gian đóng hàng</th>
	                    <th class="sticky-row" width="150">Cước vận chuyển</th>
	                    <th class="sticky-row sticky-column" width="120">Hành động</th>
	              </tr>'.$tach_list['list'];
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_new'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$cong_ty=addslashes(strip_tags($_REQUEST['cong_ty']));
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}else{
		$page++;
	}
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_new($conn,$cong_ty,$loai_hinh,$from,$to,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
	}
	if($tach_list['total']<$limit){
		$tiep=0;
		$page=1;
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_wait'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$cong_ty=addslashes(strip_tags($_REQUEST['cong_ty']));
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}else{
		$page++;
	}
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_wait($conn,$cong_ty,$loai_hinh,$from,$to,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
	}
	if($tach_list['total']<$limit){
		$tiep=0;
		$page=1;
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_confirm'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$cong_ty=addslashes(strip_tags($_REQUEST['cong_ty']));
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}else{
		$page++;
	}
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_confirm($conn,$cong_ty,$loai_hinh,$from,$to,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
	}
	if($tach_list['total']<$limit){
		$tiep=0;
		$page=1;
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_success'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$cong_ty=addslashes(strip_tags($_REQUEST['cong_ty']));
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}else{
		$page++;
	}
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_success($conn,$cong_ty,$loai_hinh,$from,$to,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
	}
	if($tach_list['total']<$limit){
		$tiep=0;
		$page=1;
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='timkiem_booking_false'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$cong_ty=addslashes(strip_tags($_REQUEST['cong_ty']));
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}else{
		$page++;
	}
	$limit=25;
	$tach_list=json_decode($class_index->timkiem_booking_false($conn,$cong_ty,$loai_hinh,$from,$to,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
	}
	if($tach_list['total']<$limit){
		$tiep=0;
		$page=1;
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='load_timkiem_booking_user'){
	$loai_hinh=addslashes(strip_tags($_REQUEST['loai_hinh']));
	$hang_tau=intval($_REQUEST['hang_tau']);
	$hang_tau_id=intval($_REQUEST['hang_tau_id']);
	$loai_container=intval($_REQUEST['loai_container']);
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	$dia_diem=addslashes(strip_tags($_REQUEST['dia_diem']));
	$dia_diem_id=intval($_REQUEST['dia_diem_id']);
	$limit=25;
	$page=intval($_REQUEST['page']);
	$page++;
	$tach_list=json_decode($class_index->timkiem_booking_user($conn,$loai_hinh,$hang_tau_id,$loai_container,$from,$to,$dia_diem_id,$page,$limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list=$tach_list['list'];
		if($tach_list['total']<$limit){
			$tiep=0;
		}else{
			$tiep=1;
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'tiep'=>$tiep,
		'page'=>$page,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);	
}else if($action=='load_more_container'){
	$id=intval($_REQUEST['id_container']);
	$thongtin=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$thongbao='Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container  WHERE ma_booking='{$r_tt['ma_booking']}' AND status='0' AND id!='$id' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai' ORDER BY date_time ASC");
		$total_container=mysqli_num_rows($thongtin_container);
		if($total_container==0){
			$ok=0;
			$thongbao='Không có thêm dữ liệu';
		}else{
			while($r_cont=mysqli_fetch_assoc($thongtin_container)){
				$r_cont['gia']=number_format($r_booking['gia']);
				if($r_booking['mat_hang']=='khac'){
					$r_cont['mat_hang']=$r_booking['mat_hang_khac'];
				}else{
					$r_cont['mat_hang']=$r_booking['mat_hang'];
				}
				$r_cont['id_more']=$id;
				$r_cont['hang_tau']=$r_booking['ten_hangtau'];
				$r_cont['loai_container']=$r_booking['ten_loai_container'];
				$r_cont['so_luong']=1;
				$r_cont['more']='';
				$r_cont['ten_xa']=$r_booking['ten_xa'];
				$r_cont['ten_huyen']=$r_booking['ten_huyen'];
				$r_cont['ten_tinh']=$r_booking['ten_tinh'];
				$r_cont['ten_xa_donghang']=$r_booking['ten_xa_donghang'];
				$r_cont['ten_huyen_donghang']=$r_booking['ten_huyen_donghang'];
				$r_cont['ten_tinh_donghang']=$r_booking['ten_tinh_donghang'];
				$r_cont['ten_cang']=$r_booking['ten_cang'];
				$r_cont['diachi_donghang']=$r_booking['diachi_donghang'];
				$r_cont['diachi_trahang']=$r_booking['diachi_trahang'];
				$r_cont['so_booking']=$r_booking['so_booking'];
				if($r_cont['loai_hinh']=='hangnhap'){
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hangnhap_more', $r_cont);
				}else if($r_cont['loai_hinh']=='hang_noidia'){
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia_more', $r_cont);
				}else{
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hangxuat_more', $r_cont);
				}
			}
			$ok=1;
			$thongbao='Load dữ liệu thành công';
		}

	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list
	);
	echo json_encode($info);
}else if($action=='load_more_user_container'){
	$id=intval($_REQUEST['id_container']);
	$thongtin=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$thongbao='Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container  WHERE ma_booking='{$r_tt['ma_booking']}' AND status='0' AND id!='$id' AND ngay='{$r_tt['ngay']}' ORDER BY date_time DESC");
		$total_container=mysqli_num_rows($thongtin_container);
		if($total_container==0){
			$ok=0;
			$thongbao='Không có thêm dữ liệu';
		}else{
			while($r_cont=mysqli_fetch_assoc($thongtin_container)){
				$r_cont['gia']=number_format($r_booking['gia']);
				if($r_booking['mat_hang']=='khac'){
					$r_cont['mat_hang']=$r_booking['mat_hang_khac'];
				}else{
					$r_cont['mat_hang']=$r_booking['mat_hang'];
				}
				$r_cont['id_more']=$id;
				$r_cont['hang_tau']=$r_booking['ten_hangtau'];
				$r_cont['loai_container']=$r_booking['ten_loai_container'];
				$r_cont['so_luong']=1;
				$r_cont['more']='';
				$r_cont['ten_xa']=$r_booking['ten_xa'];
				$r_cont['ten_huyen']=$r_booking['ten_huyen'];
				$r_cont['ten_tinh']=$r_booking['ten_tinh'];
				$r_cont['ten_xa_donghang']=$r_booking['ten_xa_donghang'];
				$r_cont['ten_huyen_donghang']=$r_booking['ten_huyen_donghang'];
				$r_cont['ten_tinh_donghang']=$r_booking['ten_tinh_donghang'];
				$r_cont['ten_cang']=$r_booking['ten_cang'];
				$r_cont['diachi_donghang']=$r_booking['diachi_donghang'];
				$r_cont['diachi_trahang']=$r_booking['diachi_trahang'];
				$r_cont['so_booking']=$r_booking['so_booking'];
				if($r_cont['loai_hinh']=='hangnhap'){
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hangnhap_more', $r_cont);
				}else if($r_cont['loai_hinh']=='hang_noidia'){
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia_more', $r_cont);
				}else{
					$list.=$skin->skin_replace('skin_cpanel/box_action/tr_hangxuat_more', $r_cont);
				}
			}
			$ok=1;
			$thongbao='Load dữ liệu thành công';
		}

	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list
	);
	echo json_encode($info);
}else if($action=='upload_dinhkem'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$sms_id=intval($_REQUEST['sms_id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['active']!=1){
		$ok=0;
		$thongbao='Thất bại! Phiên yêu cầu đã đóng';
	}else{
		$hientai=time();
		$total = count($_FILES['file']['name']);
		$k = 0;
		for ($i = 0; $i < $total; $i++) {
			$filename = $_FILES['file']['name'][$i];
			$duoi = $check->duoi_file($_FILES['file']['name'][$i]);
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp','pdf')) == true) {
				$folder_name = '/uploads/dinh-kem/'.date('d-m-Y').'/';

				if (!file_exists('..' . $folder_name)) {
					mkdir('..' . $folder_name, 0777);
				} else {
				}
				$minh_hoa = $folder_name . '' . $check->blank(str_replace('.' . $duoi, '', $filename)) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
				$pt = '/' . substr($minh_hoa, 1);
				if(in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true){
					$noi_dung='<a href="'.$pt.'" target="_blank"><img src="'.$pt.'"></a>';
				}else{
					$noi_dung='<a href="'.$pt.'" target="_blank"><i class="icon icon-file-pdf"></i> '.$filename.'</a>';
				}
				mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','{$r_tt['thanh_vien']}','{$r_tt['thanh_vien']}','{$user_info['id']}','$noi_dung','0','1','$hientai')");
				$thongtin_moi=mysqli_query($conn,"SELECT chat.*,emin_info.name,emin_info.avatar FROM chat LEFT JOIN emin_info ON emin_info.id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='{$user_info['id']}' ORDER BY chat.id DESC LIMIT 1");
				$r_m=mysqli_fetch_assoc($thongtin_moi);
				$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
				$r_c=mysqli_fetch_assoc($thongtin_cuoi);
				$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
				if($r_c['thanh_vien']==$r_c['user_out']){
					$list=$skin->skin_replace('skin_dropship/box_action/li_chat_right_avatar', $r_m);
					$list_out=$skin->skin_replace('skin_dropship/box_action/li_chat_left_avatar', $r_m);
				}else if($r_c['user_out']!=$user_info['id']){
					$list=$skin->skin_replace('skin_dropship/box_action/li_chat_right_avatar', $r_m);
					$list_out=$skin->skin_replace('skin_dropship/box_action/li_chat_left_avatar', $r_m);
				}else{
					$list=$skin->skin_replace('skin_dropship/box_action/li_chat_right', $r_m);
					$list_out=$skin->skin_replace('skin_dropship/box_action/li_chat_left', $r_m);
				}
				$k++;
			}
		}
		if($k==0){
			$ok=0;
			$thongbao='Định dạng không được hỗ trợ';
		}else{
			$ok=1;
			$thongbao='Gửi thành công';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'user_out'=>$user_info['id'],
		'list_out'=>$list_out,
		'phien'=>$phien,
		'bo_phan'=>$r_tt['bo_phan'],
		'thanh_vien'=>$r_tt['thanh_vien']
	);
	echo json_encode($info);
}else if($action=='get_total_cart'){
	$thongtin_nap=mysqli_query($conn,"SELECT count(*) AS total FROM naptien WHERE status='0'");
	$r_np=mysqli_fetch_assoc($thongtin_nap);
	$total_nap=$r_np['total'];
	if($total_nap>9){
		$total_nap='9+';
	}
	echo json_encode(array('total_nap'=>$total_nap));

}else if($action=='load_notification'){
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}
	$loai=addslashes($_REQUEST['loai']);
	$limit=10;
	$tach_list=json_decode($class_index->list_notification($conn,$user_id,$user_info['bo_phan'],$loai,$page,$limit),true);
	if($tach_list['total']<$limit){
		$tiep=0;
	}else{
		$tiep=1;
	}
	$list=$tach_list['list'];
	if($tach_list['total']==0){
		if($page==1){
			$list='<div class="empty">Không có dữ liệu nào</div>';
		}else{
			$list='<div class="li_empty">Không còn dữ liệu nào</div>';
		}
		$page=1;
	}else{
		$page++;
	}
	$info=array(
		'ok'=>1,
		'page'=>$page,
		'tiep'=>$tiep,
		'list'=>$list,
	);
	echo json_encode($info);	
}else if($action=='load_doanhso_chitieu'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$thongke=json_decode($class_index->thongke_doanhso_chitieu($conn,$user_id,$user_info['nhom'],$begin_time,$end_time),true);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'doanhso_chi'=>number_format($thongke['doanhso_chi']).' đ',
		'doanhso_hoan'=>number_format($thongke['doanhso_hoan']).' đ',
		'giaodich_chi'=>'với '.number_format($thongke['giaodich_chi']).' giao dịch',
		'giaodich_hoan'=>'với '.number_format($thongke['giaodich_hoan']).' giao dịch',
	);
	echo json_encode($bien);
}else if($action=='load_doanhso_naptien'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$thongke=json_decode($class_index->thongke_doanhso_naptien($conn,$user_id,$user_info['nhom'],$begin_time,$end_time),true);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'doanhthu_hoanthanh'=>number_format($thongke['doanhthu_hoanthanh']).' đ',
		'doanhthu_huy'=>number_format($thongke['doanhthu_huy']).' đ',
		'doanhthu_cho_xacnhan'=>number_format($thongke['doanhthu_cho_xacnhan']).' đ',
		'doanhthu_cho'=>number_format($thongke['doanhthu_cho']).' đ',
		'giaodich_hoanthanh'=>'với '.number_format($thongke['giaodich_hoanthanh']).' giao dịch',
		'giaodich_huy'=>'với '.number_format($thongke['giaodich_huy']).' giao dịch',
		'giaodich_cho_xacnhan'=>'với '.number_format($thongke['giaodich_cho_xacnhan']).' giao dịch',
		'giaodich_cho'=>'với '.number_format($thongke['giaodich_cho']).' giao dịch',
	);
	echo json_encode($bien);
}else if($action=='load_doanhso_chitieu_cskh'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$id=intval($_REQUEST['id']);
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$thongke=json_decode($class_index->thongke_doanhso_chitieu($conn,$id,$begin_time,$end_time),true);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'doanhso_chi'=>number_format($thongke['doanhso_chi']).' đ',
		'doanhso_hoan'=>number_format($thongke['doanhso_hoan']).' đ',
		'giaodich_chi'=>'với '.number_format($thongke['giaodich_chi']).' giao dịch',
		'giaodich_hoan'=>'với '.number_format($thongke['giaodich_hoan']).' giao dịch',
	);
	echo json_encode($bien);
}else if($action=='load_doanhso_naptien_cskh'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$id=intval($_REQUEST['id']);
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$thongke=json_decode($class_index->thongke_doanhso_naptien($conn,$id,$begin_time,$end_time),true);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'doanhthu_hoanthanh'=>number_format($thongke['doanhthu_hoanthanh']).' đ',
		'doanhthu_huy'=>number_format($thongke['doanhthu_huy']).' đ',
		'doanhthu_cho_xacnhan'=>number_format($thongke['doanhthu_cho_xacnhan']).' đ',
		'doanhthu_cho'=>number_format($thongke['doanhthu_cho']).' đ',
		'giaodich_hoanthanh'=>'với '.number_format($thongke['giaodich_hoanthanh']).' giao dịch',
		'giaodich_huy'=>'với '.number_format($thongke['giaodich_huy']).' giao dịch',
		'giaodich_cho_xacnhan'=>'với '.number_format($thongke['giaodich_cho_xacnhan']).' giao dịch',
		'giaodich_cho'=>'với '.number_format($thongke['giaodich_cho']).' giao dịch',
	);
	echo json_encode($bien);
}else if($action=='load_doanhso_booking'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$thongke=json_decode($class_index->thongke_booking($conn,$user_id,$user_info['nhom'],$begin_time,$end_time),true);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
		$bien=array(
			'ok'=>$ok,
			'thongbao'=>$thongbao,
			'doanhso_cho_xacnhan'=>number_format($thongke['doanhso_cho_xacnhan']).' đ',
			'doanhso_hoanthanh'=>number_format($thongke['doanhso_hoanthanh']).' đ',
			'doanhso_xacnhan'=>number_format($thongke['doanhso_xacnhan']).' đ',
			'doanhso_tuchoi'=>number_format($thongke['doanhso_tuchoi']).' đ',
			'doanhso_cho'=>number_format($thongke['doanhso_cho']).' đ',
			'doanhso_tao'=>number_format($thongke['doanhso_tao']).' đ',
			'booking_cho_xacnhan'=>'Với '.number_format($thongke['booking_cho_xacnhan']).' booking',
			'booking_hoanthanh'=>'Với '.number_format($thongke['booking_hoanthanh']).' booking',
			'booking_xacnhan'=>'Với '.number_format($thongke['booking_xacnhan']).' booking',
			'booking_tuchoi'=>'Với '.number_format($thongke['booking_tuchoi']).' booking',
			'booking_cho'=>'Với '.number_format($thongke['booking_cho']).' booking',
			'booking_tao'=>'Với '.number_format($thongke['booking_tao']).' container',
		);
	}
	echo json_encode($bien);
}else if ($action == "add_naptien") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$username=addslashes(strip_tags($_REQUEST['username']));
		$sotien=preg_replace('/[^0-9-]/', '', $_REQUEST['sotien']);
		$loai=intval($_REQUEST['loai']);
		$noidung=addslashes(strip_tags($_REQUEST['noidung']));
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE username='$username'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Thất bại! Thành viên không tồn tại';
		}else{
			$truoc=$r_tt['user_money'] + $r_tt['user_money2'];
			$sau=$truoc + $sotien;
			if($loai==1){
				$moi=$r_tt['user_money'] + $sotien;
				mysqli_query($conn,"UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
			}else{
				$moi=$r_tt['user_money2'] + $sotien;
				mysqli_query($conn,"UPDATE user_info SET user_money2='$moi' WHERE user_id='{$r_tt['user_id']}'");
			}
			mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','$sotien','$truoc','$sau','$noidung',".time().")");
			$ok=1;
			$thongbao='Thêm giao dịch thành công';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_naptien") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$status=intval($_REQUEST['status']);
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM naptien WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$hientai=time();
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Thất bại! Giao dịch không tồn tại';
		}else{
			if($r_tt['status']==0 OR $r_tt['status']==3){
				if($status==2){
					//mysqli_query($conn, "UPDATE naptien SET status='$status',update_post='$hientai' WHERE id='$id'");
					mysqli_query($conn, "DELETE FROM  naptien WHERE id='$id'");
				}else{
					mysqli_query($conn, "UPDATE naptien SET status='$status',update_post='$hientai' WHERE id='$id'");
				}
				$thongbao = 'Lưu thay đổi thành công';
				$ok = 1;
				if($status==1){
					$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
					$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
					$moi=$r_tt['sotien'] + $r_tv['user_money'];
					$truoc=$r_tv['user_money'] + $r_tv['user_money2'];
					$sau=$truoc + $r_tt['sotien'];
					$noidung = 'Hoàn thành giao dịch nạp tiền "naptien '.$r_tv['username'].' '.$r_tt['id'].'"';
					mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['sotien']}','$truoc','$sau','$noidung',".time().")");
					mysqli_query($conn,"UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
					$noidung_noti='Giao dịch nạp tiền của bạn đã được xác nhận hoàn thành';
					mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_id']}','$noidung_noti','','0','0','$hientai')");
				}
			}else{
				if($r_tt['status']==1){
					$ok=0;
					$thongbao='Thất bại! Giao dịch này đã hoàn thành';
				}else if($r_tt['status']==2){
					$ok=0;
					$thongbao='Thất bại! Giao dịch này đã hủy';
				}

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'user_id'=>$r_tt['user_id'],
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_ruttien") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('ruttien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$status=intval($_REQUEST['status']);
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM rut_tien WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Thất bại! Giao dịch không tồn tại';
		}else{
			if($r_tt['status']==0){
				mysqli_query($conn, "UPDATE rut_tien SET status='$status'WHERE id='$id'");
				$thongbao = 'Lưu thay đổi thành công';
				$ok = 1;
			}else{
				if($r_tt['status']==1){
					$ok=0;
					$thongbao='Thất bại! Giao dịch này đã hoàn thành';
				}else if($r_tt['status']==2){
					$ok=0;
					$thongbao='Thất bại! Giao dịch này đã hủy';
				}

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

}else if($action=='load_thongke_drop'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$list=$class_index->thongke_drop($conn,$begin_time,$end_time);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
		$list='
                <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Họ và tên</th>
                    <th style="text-align: center;width: 100px;">Tổng đơn</th>
                    <th style="text-align: center;">Doanh số</th>
                    <th style="text-align: center;width: 150px;">Hành động</th>
                </tr>
                '.$list;
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
	);
	echo json_encode($bien);
}else if($action=='load_thongke_ctv'){
	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$ok=0;	
	}else{
		$end=addslashes(strip_tags($_REQUEST['time_end']));
		$tach_end=explode('/', $end);
		$date_end=$tach_end[0];
		$month_end=$tach_end[1];
		$year_end=$tach_end[2];
		$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
		$begin=addslashes(strip_tags($_REQUEST['time_begin']));
		$tach_begin=explode('/', $begin);
		$date_begin=$tach_begin[0];
		$month_begin=$tach_begin[1];
		$year_begin=$tach_begin[2];
		$begin_time=mktime(0,0,0,$month_begin,$date_begin,$year_begin);
		$list=$class_index->thongke_ctv($conn,$begin_time,$end_time);
		$ok=1;
		$thongbao='Lấy dữ liệu thành công';
		$list='<tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Họ và tên</th>
                    <th style="text-align: center;width: 100px;">Tổng đơn</th>
                    <th style="text-align: center;">Doanh số</th>
                    <th style="text-align: center;width: 150px;">Hành động</th>
                </tr>
                '.$list;
	}
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
	);
	echo json_encode($bien);
}else if ($action == "add_slide") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('slide', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			mysqli_query($conn, "INSERT INTO slide(shop,tieu_de,minh_hoa,link,target,thu_tu)VALUES('0','$tieu_de','$minh_hoa','$link','$target','$thu_tu')");
			$ok = 1;
			$thongbao = 'Thêm slide thành công!';
		} else {
			$thongbao = 'Thất bại! Bạn chưa chọn hình ảnh';
			$ok = 0;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_slide") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('slide', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM slide WHERE id='$id' AND shop='0'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Thất bại! Slide không tồn tại';
		}else{
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
				$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				@unlink('..' . $r_tt['minh_hoa']);
				mysqli_query($conn, "UPDATE slide SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',link='$link',target='$target',thu_tu='$thu_tu' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Sửa slide thành công!';
			} else {
				mysqli_query($conn, "UPDATE slide SET tieu_de='$tieu_de',link='$link',target='$target',thu_tu='$thu_tu' WHERE id='$id'");
				$thongbao = 'Sửa slide thành công';
				$ok = 1;
			}

		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "add_banner") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('banner', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$vi_tri=addslashes(strip_tags($_REQUEST['vi_tri']));
		$thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
		$bg_banner=addslashes(strip_tags($_REQUEST['bg_banner']));
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			@unlink('..' . $index_setting[$name]);
			mysqli_query($conn, "INSERT INTO banner(tieu_de,minh_hoa,bg_banner,link,target,thu_tu,vi_tri)VALUES('$tieu_de','$minh_hoa','$bg_banner','$link','$target','$thu_tu','$vi_tri')");
			$ok = 1;
			$thongbao = 'Thêm banner thành công!';
		} else {
			$thongbao = 'Thất bại! Bạn chưa chọn hình ảnh';
			$ok = 0;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_banner") {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if(in_array('banner', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
		$link=addslashes(strip_tags($_REQUEST['link']));
		$target=addslashes(strip_tags($_REQUEST['target']));
		$thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
		$vi_tri=addslashes(strip_tags($_REQUEST['vi_tri']));
		$bg_banner=addslashes(strip_tags($_REQUEST['bg_banner']));
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM banner WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Thất bại! Banner không tồn tại';
		}else{
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
				$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				@unlink('..' . $r_tt['minh_hoa']);
				mysqli_query($conn, "UPDATE banner SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',bg_banner='$bg_banner',link='$link',target='$target',vi_tri='$vi_tri',thu_tu='$thu_tu' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Sửa banner thành công!';
			} else {
				mysqli_query($conn, "UPDATE banner SET tieu_de='$tieu_de',link='$link',bg_banner='$bg_banner',target='$target',vi_tri='$vi_tri',thu_tu='$thu_tu' WHERE id='$id'");
				$thongbao = 'Sửa banner thành công';
				$ok = 1;
			}

		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'edit_cskh') {
	if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$ho_ten=addslashes($_REQUEST['ho_ten']);
	$dien_thoai=addslashes($_REQUEST['dien_thoai']);
	$id=intval($_REQUEST['id']);
	$cskh=intval($_REQUEST['cskh']);
	$hientai=time();
	if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else {
		$ok=1;
		$thongbao='Lưu thay đổi thành công';
		$thongtin_cskh=mysqli_query($conn,"SELECT * FROM cskh WHERE user_id='$id'");
		$total_cskh=mysqli_num_rows($thongtin_cskh);
		if($total_cskh==0){
			mysqli_query($conn,"INSERT INTO cskh (user_id,ho_ten,dien_thoai,date_post)VALUES('$id','$ho_ten','$dien_thoai','$hientai')");
		}else{
			mysqli_query($conn,"UPDATE cskh SET ho_ten='$ho_ten',dien_thoai='$dien_thoai' WHERE user_id='$id'");
		}
		mysqli_query($conn,"UPDATE user_info SET aff='$cskh' WHERE user_id='$id'");
		$noidung_log=$user_info['name'].': Cập nhật CSKH cho thành viên : User_id: '.$id.' - Họ tên CSKH: '.$ho_ten.' - Điện thoại CSKH: '.$dien_thoai;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_tinh') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên Tỉnh/TP';
	} else {
		$ok=1;
		$thongbao='Thêm Tỉnh/TP thành công';
		mysqli_query($conn,"INSERT INTO tinh_moi (tieu_de,thu_tu)VALUES('$tieu_de','$thu_tu')");
		$noidung_log=$user_info['name'].': Thêm tỉnh '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$list=' <tr>
	            <th class="sticky-row">STT</th>
	            <th class="sticky-row" width="200">Tỉnh/TP</th>
	            <th class="sticky-row sticky-column" width="300">Hành động</th>
	          </tr>'.$class_index->list_tinh($conn,1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);
} else if ($action == 'edit_tinh') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên Tỉnh/TP';
	} else {
		$thongtin=mysqli_query($conn,"SELECT * FROM tinh_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Thất bại! Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$thongbao='Chỉnh sửa Tỉnh/TP thành công';
			mysqli_query($conn,"UPDATE tinh_moi SET tieu_de='$tieu_de',thu_tu='$thu_tu' WHERE id='$id'");
			$noidung_log=$user_info['name'].': Chỉnh sửa tỉnh '.$tieu_de;
			mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		}
	}
	$list=' <tr>
	            <th class="sticky-row">STT</th>
	            <th class="sticky-row" width="200">Tỉnh/TP</th>
	            <th class="sticky-row sticky-column" width="300">Hành động</th>
	          </tr>'.$class_index->list_tinh($conn,1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);
} else if ($action == 'add_huyen') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$tinh=intval($_REQUEST['tinh']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên quận/huyện';
	} else {
		$ok=1;
		$thongbao='Thêm quận/huyện thành công';
		mysqli_query($conn,"INSERT INTO huyen_moi(tinh,tieu_de,thu_tu)VALUES('$tinh','$tieu_de','$thu_tu')");
		$noidung_log=$user_info['name'].': Thêm huyện '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$list=' <tr>
	        	<th class="sticky-row" width="80">STT</th>
	            <th class="sticky-row">Quận/Huyện</th>
	            <th class="sticky-row sticky-column" width="360">Hành động</th>
	        </tr>'.$class_index->list_huyen($conn,$tinh,1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);
} else if ($action == 'edit_huyen') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên quận/huyện';
	} else {
		$thongtin=mysqli_query($conn,"SELECT * FROM huyen_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Thất bại! Dữ liệu không tồn tại';
		}else{
			$r_tt=mysqli_fetch_assoc($thongtin);
			$ok=1;
			$thongbao='Chỉnh sửa quận/huyện thành công';
			mysqli_query($conn,"UPDATE huyen_moi SET tieu_de='$tieu_de',thu_tu='$thu_tu' WHERE id='$id'");
			$noidung_log=$user_info['name'].': Chỉnh sửa huyện '.$tieu_de;
			mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		}
	}
	$list=' <tr>
	        	<th class="sticky-row" width="80">STT</th>
	            <th class="sticky-row">Quận/Huyện</th>
	            <th class="sticky-row sticky-column" width="360">Hành động</th>
	        </tr>'.$class_index->list_huyen($conn,$r_tt['tinh'],1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);
} else if ($action == 'add_xa') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên xã/phường';
	} else {
		$ok=1;
		$thongbao='Thêm xã/phường thành công';
		mysqli_query($conn,"INSERT INTO xa_moi(tinh,huyen,tieu_de,thu_tu)VALUES('$tinh','$huyen','$tieu_de','$thu_tu')");
		$noidung_log=$user_info['name'].': Thêm xã '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$list=' <tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row">Xã/phường/thị trấn</th>
                <th class="sticky-row sticky-column" width="200">Hành động</th>
            </tr>'.$class_index->list_xa($conn,$huyen,1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list,
	);
	echo json_encode($info);
} else if ($action == 'edit_xa') {
	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng tên xã/phường';
	} else {
		$thongtin=mysqli_query($conn,"SELECT * FROM xa_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Thất bại! Dữ liệu không tồn tại';
		}else{
			$r_tt=mysqli_fetch_assoc($thongtin);
			$ok=1;
			$thongbao='Chỉnh sửa xã/phường thành công';
			mysqli_query($conn,"UPDATE xa_moi SET tieu_de='$tieu_de',thu_tu='$thu_tu' WHERE id='$id'");
			$noidung_log=$user_info['name'].': Chỉnh sửa xã '.$tieu_de;
			mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		}
	}
	$list=' <tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row">Xã/phường/thị trấn</th>
                <th class="sticky-row sticky-column" width="200">Hành động</th>
            </tr>'.$class_index->list_xa($conn,$r_tt['huyen'],1,100);
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list,
	);
	echo json_encode($info);
} else if ($action == 'add_goi_giahan') {
	if(in_array('giahan', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$so_tien=preg_replace('/[^0-9]/', '', $_REQUEST['so_tien']);
	$so_tien=intval($so_tien);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$status=intval($_REQUEST['status']);
	$thoi_gian=intval($_REQUEST['thoi_gian']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên gói';
	} else if ($so_tien=='') {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập phí gia hạn';
	} else if ($thoi_gian=='') {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số ngày gia hạn';
	} else {
		$ok=1;
		$thongbao='Thêm gói gia hạn thành công';
		mysqli_query($conn,"INSERT INTO goi_giahan (tieu_de,thoi_gian,gia,thu_tu,active)VALUES('$tieu_de','$thoi_gian','$so_tien','$thu_tu','$status')");
		$noidung_log=$user_info['name'].': Thêm gói gia hạn : Tên gói: '.$tieu_de.' - Phí: '.$so_tien.' - Số ngày: '.$thoi_gian;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_goi_giahan') {
	if(in_array('giahan', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$so_tien=preg_replace('/[^0-9]/', '', $_REQUEST['so_tien']);
	$so_tien=intval($so_tien);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$status=intval($_REQUEST['status']);
	$thoi_gian=intval($_REQUEST['thoi_gian']);
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên gói';
	} else if ($so_tien=='') {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập phí gia hạn';
	} else if ($thoi_gian=='') {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số ngày gia hạn';
	} else {
		$ok=1;
		$thongbao='Lưu thay đổi thành công';
		mysqli_query($conn,"UPDATE goi_giahan SET tieu_de='$tieu_de',thoi_gian='$thoi_gian',gia='$so_tien',thu_tu='$thu_tu',active='$status' WHERE id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa gói gia hạn : Tên gói: '.$tieu_de.' - Phí: '.$so_tien.' - Số ngày: '.$thoi_gian;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_danhmuc') {
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên danh mục';
	} else {
		$ok=1;
		$thongbao='Thêm danh mục thành công';
		mysqli_query($conn,"INSERT INTO danhmuc_baiviet (tieu_de,main,date_post)VALUES('$tieu_de','0','$hientai')");
		$noidung_log=$user_info['name'].': Thêm danh mục bài viết: '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_danhmuc') {
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên danh mục';
	} else {
		$ok=1;
		$thongbao='Lưu thay đổi thành công';
		mysqli_query($conn,"UPDATE danhmuc_baiviet SET tieu_de='$tieu_de' WHERE id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa danh mục : '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_baiviet') {
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$danhmuc = addslashes($_REQUEST['danhmuc']);
	$noidung = addslashes($_REQUEST['noidung']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		$thongbao = 'Thêm bài viết thành công';
		$ok = 1;
		$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
		mysqli_query($conn, "INSERT INTO bai_viet(user_id,tieu_de,minh_hoa,noi_dung,cat,view,date_post)VALUES('$user_id','$tieu_de','$minh_hoa','$noidung','$danhmuc','0'," . time() . ")");
		$noidung_log=$user_info['name'].': Thêm bài viết : '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	} else {
		$thongbao = 'Vui lòng chọn ảnh minh họa';
		$ok = 0;
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_baiviet') {
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$noidung = addslashes($_REQUEST['noidung']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$danhmuc = addslashes($_REQUEST['danhmuc']);
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		$thongbao = 'Sửa bài viết thành công';
		$ok = 1;
		mysqli_query($conn, "UPDATE bai_viet SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',cat='$danhmuc',noi_dung='$noidung' WHERE id='$id'");
		@unlink('..' . $r_tt['minh_hoa']);
	} else {
		mysqli_query($conn, "UPDATE bai_viet SET tieu_de='$tieu_de',noi_dung='$noidung',cat='$danhmuc' WHERE id='$id'");
		$thongbao = 'Sửa bài viết thành công';
		$ok = 0;
	}
	$noidung_log=$user_info['name'].': Chỉnh sửa bài viết : '.$tieu_de;
	mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_thanhvien') {
	if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$cong_ty=addslashes($_REQUEST['cong_ty']);
	$maso_thue=addslashes($_REQUEST['maso_thue']);
	$ho_ten=addslashes($_REQUEST['ho_ten']);
	$dien_thoai=addslashes($_REQUEST['dien_thoai']);
	$email=addslashes($_REQUEST['email']);
	$nhom=intval($_REQUEST['nhom']);
	$id=intval($_REQUEST['id']);
	if (strlen($cong_ty) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên công ty';
	} else if (strlen($maso_thue) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập mã số thuế';
	} else if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if ($check->check_email($email)==false) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ email';
	} else {
		$ok=1;
		$thongbao='Lưu thay đổi thành công';
		mysqli_query($conn,"UPDATE user_info SET cong_ty='$cong_ty',maso_thue='$maso_thue',name='$ho_ten',mobile='$dien_thoai',nhom='$nhom' WHERE user_id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa thành viên: User_id: '.$id.' - Họ tên: '.$ho_ten.' - Điện thoại: '.$dien_thoai;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_thanhvien') {
	if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$cong_ty=addslashes($_REQUEST['cong_ty']);
	$maso_thue=addslashes($_REQUEST['maso_thue']);
	$ho_ten=addslashes($_REQUEST['ho_ten']);
	$dien_thoai=addslashes($_REQUEST['dien_thoai']);
	$email=addslashes($_REQUEST['email']);
	$nhom=intval($_REQUEST['nhom']);
	$password=addslashes($_REQUEST['password']);
	$re_password=addslashes($_REQUEST['re_password']);
	if (strlen($cong_ty) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên công ty';
	} else if (strlen($maso_thue) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập mã số thuế';
	} else if (strlen($ho_ten) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập họ và tên';
	} else if (strlen($dien_thoai) < 8) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập số điện thoại';
	} else if ($check->check_email($email)==false) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ email';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Mật khẩu quá ngắn';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Thất bại! Nhập lại mật khẩu không khớp';
	} else {
		$thongtin_mobile = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE mobile='$dien_thoai'");
		$r_mobile = mysqli_fetch_assoc($thongtin_mobile);
		if ($r_mobile['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Số điện thoại đã đăng ký';
		} else {
			$thongtin=mysqli_query($conn,"SELECT *,count(*) total FROM user_info WHERE email='$email'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']>0){
				$ok = 0;
				$thongbao = 'Thất bại! Địa chỉ email đã đăng ký';
			}else{
				$ok = 1;
				$thongbao = 'Thêm thành viên thành công';
				$pass = md5($password);
				$hientai = time();
				$ip_address = $_SERVER['REMOTE_ADDR'];
				mysqli_query($conn, "INSERT INTO user_info(username,password,email,name,avatar,user_money,user_money2,rate,num_rate,mobile,ngaysinh,dia_chi,cong_ty,maso_thue,code_active,active,nhom,emin_group,bo_phan,aff,created,ip_address,logined,end_online)VALUES('$dien_thoai','$pass','$email','$ho_ten','','0','0','0','0','$dien_thoai','','','$cong_ty','$maso_thue','','1','$nhom','','','','$hientai','$ip_address','$hientai','')");
				$noidung_log=$user_info['name'].': Thêm thành viên : Họ và tên: '.$ho_ten.' - Điện thoại: '.$dien_thoai.' - Email: '.$email;
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$limit=100;
				$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info");
				$r_tk=mysqli_fetch_assoc($thongke);
				$total_page=ceil($r_tk['total']/$limit);
				$list=$class_index->list_thanhvien($conn,'all',$r_tk['total'],1,$limit);
				$list='<tr>
		                <th class="sticky-row" width="80">STT</th>
		                <th class="sticky-row" width="150">Họ và tên</th>
		                <th class="sticky-row" width="120">Điện thoại</th>
		                <th class="sticky-row" width="200">Email</th>
		                <th class="sticky-row">Công ty</th>
		                <th class="sticky-row" width="150">Mã số thuế</th>
		                <th class="sticky-row" width="100">Số dư</th>
		                <th class="sticky-row sticky-column" width="180">Hành động</th>
		              </tr>'.$list;
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_cang') {
	if(in_array('cang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$dia_chi=addslashes($_REQUEST['dia_chi']);
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên cảng';
	} else if (strlen($dia_chi) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ';
	} else {
		$ok = 1;
		$thongbao = 'Thêm cảng thành công';
		$hientai = time();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		mysqli_query($conn, "INSERT INTO list_cang(tieu_de,thu_tu,dia_chi,date_post)VALUES('$tieu_de','$thu_tu','$dia_chi','$hientai')");
		$noidung_log=$user_info['name'].': Thêm cảng : Tên cảng: '.$tieu_de.' - Địa chỉ: '.$dia_chi;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_cang");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_cang($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="250">Tên cảng</th>
                <th class="sticky-row">Địa chỉ</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_cang') {
	if(in_array('cang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$thu_tu=intval($_REQUEST['thu_tu']);
	$dia_chi=addslashes($_REQUEST['dia_chi']);
	$id=intval($_REQUEST['id']);
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên cảng';
	} else if (strlen($dia_chi) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập địa chỉ';
	} else {
		$ok = 1;
		$thongbao = 'Lưu thay đổi thành công';
		$hientai = time();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		mysqli_query($conn, "UPDATE list_cang SET tieu_de='$tieu_de',dia_chi='$dia_chi',thu_tu='$thu_tu' WHERE id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa cảng : Tên cảng: '.$tieu_de.' - Địa chỉ: '.$dia_chi;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_cang");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_cang($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="250">Tên cảng</th>
                <th class="sticky-row">Địa chỉ</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_phi_kethop') {
	if(in_array('hang_tau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$phi=preg_replace('/[^0-9]/', '', $_REQUEST['phi']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$thongtin_hangtau=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='$hang_tau'");
	if (strlen($phi) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập phí kết hợp';
	} else {
		$thongtin_hangtau=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='$hang_tau'");
		$total_hangtau=mysqli_num_rows($thongtin_hangtau);
		if($total_hangtau==0){
			$ok=0;
			$thongbao='Thất bại! Hãng tàu không tồn tại';
		}else{
			$ok = 1;
			$thongbao = 'Thêm phí kết hợp thành công';
			$hientai = time();
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$r_ht=mysqli_fetch_assoc($thongtin_hangtau);
			$thongtin_kethop=mysqli_query($conn, "SELECT * FROM phi_kethop WHERE hang_tau='{$r_tt['viet_tat']}' ");
			$total_kethop=mysqli_num_rows($thongtin_kethop);
			if($total_kethop>0){
				$ok=0;
				$thongbao='Thất bại! Hãng tàu này đã có phí kết hợp';
			}else{
				mysqli_query($conn, "INSERT INTO phi_kethop(hang_tau,phi)VALUES('{$r_ht['viet_tat']}','$phi')");
				$noidung_log=$user_info['name'].': Thêm phí kết hợp : Hãng tàu: '.$r_ht['viet_tat'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$limit=100;
				$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM phi_kethop");
				$r_tk=mysqli_fetch_assoc($thongke);
				$total_page=ceil($r_tk['total']/$limit);
				$list=$class_index->list_phi_kethop($conn,$r_tk['total'],1,$limit);
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_phi_kethop') {
	if(in_array('hang_tau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$phi=preg_replace('/[^0-9]/', '', $_REQUEST['phi']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$id=intval($_REQUEST['id']);
	$thongtin_hangtau=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='$hang_tau'");
	$r_ht=mysqli_fetch_assoc($thongtin_hangtau);
	if (strlen($phi) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập phí kết hợp';
	}else {
		$ok = 1;
		$thongbao = 'Lưu thay đổi thành công';
		$hientai = time();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		mysqli_query($conn, "UPDATE phi_kethop SET hang_tau='{$r_ht['viet_tat']}',phi='$phi' WHERE id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa phí kết hợp : '.$r_ht['viet_tat'];
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM phi_kethop");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_phi_kethop($conn,$r_tk['total'],1,$limit);
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_container') {
	if(in_array('container', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên loại container';
	} else {
		$ok = 1;
		$thongbao = 'Thêm loại container thành công';
		$hientai = time();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		mysqli_query($conn, "INSERT INTO loai_container(tieu_de,hang_tau,date_post)VALUES('$tieu_de','$hang_tau','$hientai')");
		$noidung_log=$user_info['name'].': Thêm loại container : Tên loại container: '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM loai_container");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_container($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row">Loại container</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_container') {
	if(in_array('cang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de=addslashes($_REQUEST['tieu_de']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$id=intval($_REQUEST['id']);
	if (strlen($tieu_de) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập tên loại container';
	}else {
		$ok = 1;
		$thongbao = 'Lưu thay đổi thành công';
		$hientai = time();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		mysqli_query($conn, "UPDATE loai_container SET tieu_de='$tieu_de',hang_tau='$hang_tau' WHERE id='$id'");
		$noidung_log=$user_info['name'].': Chỉnh sửa loại container : Tên loại container: '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM loai_container");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_container($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row">Loại container</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == "add_hangtau") {
	if(in_array('hangtau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();	
	}
	$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
	$viet_tat=addslashes(strip_tags($_REQUEST['viet_tat']));
	$link=addslashes(strip_tags($_REQUEST['link']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if(strlen($tieu_de)<3){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập tên hãng';
	}else if(strlen($viet_tat)<2){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập tên viết tắt';
	}else{
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$hientai=time();
			mysqli_query($conn, "INSERT INTO list_hangtau(tieu_de,viet_tat,link,logo,date_post)VALUES('$tieu_de','$viet_tat','$link','$minh_hoa','$hientai')");
			$ok = 1;
			$thongbao = 'Thêm hãng tàu thành công!';
		} else {
			mysqli_query($conn, "INSERT INTO list_hangtau(tieu_de,viet_tat,link,logo,date_post)VALUES('$tieu_de','$viet_tat','$link','$minh_hoa','$hientai')");
			$ok = 1;
			$thongbao = 'Thêm hãng tàu thành công!';
		}
		$noidung_log=$user_info['name'].': Thêm hãng tàu: Viết tắt: '.$viet_tat.' - Tên đầy đủ: '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_hangtau");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_hangtau($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="150">Logo</th>
                <th class="sticky-row">Viết tắt</th>
                <th class="sticky-row">Tên đầy đủ</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_hangtau") {
	if(in_array('hangtau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();	
	}
	$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
	$viet_tat=addslashes(strip_tags($_REQUEST['viet_tat']));
	$link=addslashes(strip_tags($_REQUEST['link']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$id=intval($_REQUEST['id']);
	if(strlen($tieu_de)<3){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập tên hãng';
	}else if(strlen($viet_tat)<2){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập tên viết tắt';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
			$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			unlink('..'.$r_tt['logo']);
			$hientai=time();
			mysqli_query($conn, "UPDATE list_hangtau SET tieu_de='$tieu_de',viet_tat='$viet_tat',link='$link',logo='$minh_hoa' WHERE id='$id'");
			$ok = 1;
			$thongbao = 'Lưu thay đổi thành công!';
		} else {
			mysqli_query($conn, "UPDATE list_hangtau SET tieu_de='$tieu_de',viet_tat='$viet_tat',link='$link' WHERE id='$id'");
			$ok = 1;
			$thongbao = 'Lưu thay đổi thành công!';
		}
		$noidung_log=$user_info['name'].': Chỉnh sửa hãng tàu : Tên viết tắt: '.$viet_tat.' - Tên đầy đủ: '.$tieu_de;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$limit=100;
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_hangtau");
		$r_tk=mysqli_fetch_assoc($thongke);
		$total_page=ceil($r_tk['total']/$limit);
		$list=$class_index->list_hangtau($conn,$r_tk['total'],1,$limit);
		$list='<tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="150">Logo</th>
                <th class="sticky-row">Viết tắt</th>
                <th class="sticky-row">Tên đầy đủ</th>
                <th class="sticky-row sticky-column" width="180">Hành động</th>
              </tr>'.$list;
	}
	$info = array(
		'ok' => $ok,
		'list'=>$list,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='add_phongban'){
	if(in_array('phongban', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$phan_cap = intval($_REQUEST['phan_cap']);
	$cap_nhan_su = trim(addslashes(strip_tags($_REQUEST['cap_nhan_su'])));
	
	$ok = 0;
	$thongbao = '';
	
	if(strlen($cap_nhan_su) < 3){
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập cấp nhân sự (tối thiểu 3 ký tự)';
	}else{
		if($phan_cap <= 0 || empty($phan_cap)){
			$parent_id = 0;
		}else{
			$parent_id = $phan_cap;
		}
		$admin_cty = $user_info['admin_cty'];
		$sql = "INSERT INTO phong_ban(parent_id,tieu_de,admin_cty) VALUES('$parent_id','$cap_nhan_su','$admin_cty')";
		$result = mysqli_query($conn, $sql);
		
		if($result){
			$ok = 1;
			$thongbao = 'Thêm phòng ban thành công';
		}else{
			$ok = 0;
			$thongbao = 'Thất bại! Không thể thêm phòng ban. Lỗi: ' . mysqli_error($conn);
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='box_pop_edit_phongban'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM phong_ban WHERE id='$id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$thongbao='Dữ liệu không tồn tại';
	}else{
		$ok=1;
		$r_tt=mysqli_fetch_assoc($thongtin);
		$parent_id=$r_tt['parent_id'];
		$admin_cty = $r_tt['admin_cty'];
		$r_tt['list_phan_cap_edit']=$class_giaoviec->list_option_edit_phan_cap($conn, $parent_id, $admin_cty);
		$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_edit_phongban', $r_tt);
	}
	$info=array(
		'ok'=>$ok,
		'html'=>$html,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_phongban'){
	$id=intval($_REQUEST['id']);
	$phan_cap=intval($_REQUEST['phan_cap']);
	$cap_nhan_su=trim(addslashes(strip_tags($_REQUEST['cap_nhan_su'])));
	if(strlen($cap_nhan_su) < 3){
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập cấp nhân sự (tối thiểu 3 ký tự)';
	}else{
		mysqli_query($conn, "UPDATE phong_ban SET tieu_de='$cap_nhan_su', parent_id='$phan_cap' WHERE id='$id'");
		$ok = 1;
		$thongbao = 'Lưu thay đổi thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

}else if($action=='box_pop_delete_phongban'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['phongban_id'] = $id;
		$r_tt['tieu_de'] = $r_tt['tieu_de'];
		
		// Kiểm tra xem có phòng ban con hay không
		$r_tt['has_children_warning'] = '';
		$check_children = mysqli_query($conn, "SELECT id FROM phong_ban WHERE parent_id='$id' LIMIT 1");
		if(mysqli_num_rows($check_children) > 0){
			$r_tt['has_children_warning'] = '<p class="message_warning_danger">
				<i class="fa fa-exclamation-triangle"></i>
				<strong>Cảnh báo:</strong> Phòng ban này đang chứa các phòng ban khác.<br>Nếu bạn xóa phòng ban này, toàn bộ các phòng ban bên trong cũng sẽ bị xóa theo.
			</p>';
		}
		
		$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_delete_phongban', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='delete_phongban'){
	$id = intval($_REQUEST['id']);
	$class_giaoviec->delete_phongban($conn, $id);
	$ok = 1;
	$thongbao = 'Xóa phòng ban thành công';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if ($action=='box_pop_add_user') {
	$id_phongban = intval($_REQUEST['id_phongban']);
	$r_tt['id_phongban'] = $id_phongban;
	$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_add_user', $r_tt);
	$info = array(
        'html' => $html
    );
    echo json_encode($info);
}else if($action=='add_nhansu'){
	$id_phongban = intval($_REQUEST['id_phongban']);
	$username = addslashes(strip_tags($_REQUEST['username']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$name_nhanvien = addslashes(strip_tags($_REQUEST['name_nhanvien']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$mobile = addslashes(strip_tags($_REQUEST['mobile']));
	$address = addslashes(strip_tags($_REQUEST['address']));
	$so_hopdong = $_FILES['so_hopdong'];
	$time_hopdong = addslashes(strip_tags($_REQUEST['time_hopdong']));
	$so_cccd = addslashes(strip_tags($_REQUEST['so_cccd']));
	$ngay_cap_cccd = addslashes(strip_tags($_REQUEST['ngay_cap_cccd']));
	$file_data = $_FILES['avatar'];
	$loai_hopdong = addslashes(strip_tags($_REQUEST['loai_hopdong']));
	$admin_cty = $user_info['admin_cty'];

	if(strlen($username) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập tên đăng nhập (tối thiểu 3 ký tự)';
	}else if(strlen($password) < 6){
		$ok = 0; $thongbao = 'Vui lòng nhập mật khẩu (tối thiểu 6 ký tự)';
	}else if(strlen($name_nhanvien) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập họ tên nhân viên';
	}else if(strlen($email) < 5){
		$ok = 0; $thongbao = 'Vui lòng nhập email hợp lệ';
	}else if(strlen($mobile) < 8){
		$ok = 0; $thongbao = 'Vui lòng nhập số điện thoại hợp lệ';
	}else if(strlen($address) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập địa chỉ';
	}else if(empty($so_hopdong['name'])){
		$ok = 0; $thongbao = 'Vui lòng chọn file hợp đồng';
	}else if(empty($time_hopdong)){
		$ok = 0; $thongbao = 'Vui lòng chọn thời hạn hợp đồng';
	}else if(strlen($so_cccd) < 12){
		$ok = 0; $thongbao = 'Vui lòng nhập số CCCD hợp lệ';
	}else if(empty($ngay_cap_cccd)){
		$ok = 0; $thongbao = 'Vui lòng chọn ngày cấp CCCD';
	}else if(empty($loai_hopdong)){
		$ok = 0; $thongbao = 'Vui lòng chọn loại hợp đồng';
	}else{
		
		$check_username = mysqli_query($conn, "SELECT user_id FROM user_info WHERE username='$username' AND admin_cty='$admin_cty' LIMIT 1");
		if(mysqli_num_rows($check_username) > 0){
			$ok = 0; 
			$thongbao = 'Tên đăng nhập đã tồn tại trong hệ thống';
		}
		if(!isset($ok) && !empty($email)){
			$check_email = mysqli_query($conn, "SELECT user_id FROM user_info WHERE email='$email' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($check_email) > 0){
				$ok = 0; 
				$thongbao = 'Email đã được sử dụng bởi nhân viên khác';
			}
		}
		// Kiểm tra số điện thoại đã tồn tại
		if(!isset($ok) && !empty($mobile)){
			$check_mobile = mysqli_query($conn, "SELECT user_id FROM user_info WHERE mobile='$mobile' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($check_mobile) > 0){
				$ok = 0; 
				$thongbao = 'Số điện thoại đã được sử dụng bởi nhân viên khác';
			}
		}
		
		// Nếu không có lỗi thì tiến hành thêm mới
		if(!isset($ok)){
			$avatar = "";
			if(!empty($file_data['name'])){
				$ext = pathinfo($file_data['name'], PATHINFO_EXTENSION);
				$avatar = time()."_".rand(1000,9999).".".$ext;
				move_uploaded_file($file_data['tmp_name'], __DIR__."/../uploads/giaoviec/avatar/".$avatar);
			}

			$hopdong_file = "";
			if(!empty($so_hopdong['name'])){
				$ext2 = pathinfo($so_hopdong['name'], PATHINFO_EXTENSION);
				$hopdong_file = time()."_HD_".rand(1000,9999).".".$ext2;
				move_uploaded_file($so_hopdong['tmp_name'], __DIR__."/../uploads/giaoviec/hop_dong/".$hopdong_file);	
			}
			
			$pass = md5($password);
			$hientai = time();
			
			mysqli_query($conn, "INSERT INTO user_info(admin_cty,username,password,email,name,avatar,mobile,dia_chi,so_hopdong,time_hopdong,so_cccd,ngay_cap_cccd,loai_hopdong,active,nhom,emin_group,phong_ban,date_post,update_post) VALUES ('$admin_cty','$username','$pass','$email','$name_nhanvien','$avatar','$mobile','$address','$hopdong_file','$time_hopdong','$so_cccd','$ngay_cap_cccd','$loai_hopdong','1','0','0','$id_phongban','$hientai','$hientai')");

			$ok = 1;
			$thongbao = "Thêm nhân sự thành công";
		}
	}

	echo json_encode(array(
		"ok" => $ok,
		"thongbao" => $thongbao
	));

}else if($action=='box_pop_list_user'){
	$id_phongban = intval($_REQUEST['id_phongban']);
	$r_tt['id_phongban'] = $id_phongban;
	$admin_cty = $user_info['admin_cty'];
	$list_user = $class_giaoviec->list_user($conn, $id_phongban, $admin_cty, 1, 10);
	if(empty($list_user) || trim($list_user) == ''){
		$r_tt['list_user'] = '<tr><td colspan="7" class="box_pop_list_user_empty"><div class="box_pop_list_user_empty_content"><i class="fa fa-users"></i><p>Không có nhân sự trong phòng ban</p></div></td></tr>';
	}else{
		$r_tt['list_user'] = $list_user;
	}
	$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_list_user', $r_tt);
	$info = array(
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_view_user'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['time_hopdong'] = date('d/m/Y', strtotime($r_tt['time_hopdong']));
		$r_tt['ngay_cap_cccd'] = date('d/m/Y', strtotime($r_tt['ngay_cap_cccd']));
		// Format loai hop dong
		$loai_hopdong_map = array(
			'thuctap' => 'Thực tập',
			'parttime' => 'Part-time',
			'thuviec' => 'Thử việc',
			'chinhthuc' => 'Chính thức'
		);
		$r_tt['loai_hopdong_text'] = isset($loai_hopdong_map[$r_tt['loai_hopdong']]) ? $loai_hopdong_map[$r_tt['loai_hopdong']] : ($r_tt['loai_hopdong'] ? $r_tt['loai_hopdong'] : '-');
		
		// Format so hop dong file
		if(!empty($r_tt['so_hopdong'])){
			$filename = basename($r_tt['so_hopdong']);
			$r_tt['so_hopdong_file'] = '<span class="file-name">' . htmlspecialchars($filename) . '</span> <a href="' . $r_tt['so_hopdong'] . '" download="' . $filename . '" class="file-link"><i class="fa fa-download"></i> Tải file</a>';
		}else{
			$r_tt['so_hopdong_file'] = 'Không có file hợp đồng';
		}
		
		// Format avatar
		$avatar_dir = __DIR__ . "/../uploads/giaoviec/avatar/";
		$avatar_found = false;

		if (!empty($r_tt['avatar'])) {
			$avatar_path = $avatar_dir . basename($r_tt['avatar']);

			if (file_exists($avatar_path)) {
				$avatar_url = '/uploads/giaoviec/avatar/' . basename($r_tt['avatar']);
				$r_tt['avatar_image'] = '<img src="'.$avatar_url.'" alt="Avatar" style="width:200px;height:200px;object-fit:cover;border-radius:50%;">';
				$r_tt['avatar_style'] = 'display:none;';
				$avatar_found = true;
			}
		}

		
		// Nếu không tìm thấy, hiển thị placeholder
		if(!$avatar_found){
			$r_tt['avatar_image'] = '';
			$r_tt['avatar_style'] = '';
		}
		
		// Format empty values
		$fields = array('username', 'name', 'email', 'mobile', 'address', 'time_hopdong', 'so_cccd', 'ngay_cap_cccd');
		foreach($fields as $field){
			if(empty($r_tt[$field])){
				$r_tt[$field] = 'Dữ liệu không tồn tại';
			}
		}
		
		$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_view_user', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'html' => $html,
		'thongbao' => isset($thongbao) ? $thongbao : ''
	);
	echo json_encode($info);
}else if($action=='box_pop_edit_user'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		// Format loai hop dong - checked cho radio buttons
		$loai_hopdong = isset($r_tt['loai_hopdong']) ? $r_tt['loai_hopdong'] : '';
		$r_tt['loai_hopdong_thuctap'] = ($loai_hopdong == 'thuctap') ? 'checked' : '';
		$r_tt['loai_hopdong_parttime'] = ($loai_hopdong == 'parttime') ? 'checked' : '';
		$r_tt['loai_hopdong_thuviec'] = ($loai_hopdong == 'thuviec') ? 'checked' : '';
		$r_tt['loai_hopdong_chinhthuc'] = ($loai_hopdong == 'chinhthuc') ? 'checked' : '';
		
		// Format so hop dong file
		if(!empty($r_tt['so_hopdong'])){
			$filename = basename($r_tt['so_hopdong']);
			$r_tt['so_hopdong_file'] = '<span class="file-name">' . htmlspecialchars($filename) . '</span> <a href="' . $r_tt['so_hopdong'] . '" download="' . $filename . '" class="file-link"></a>';
		}else{
			$r_tt['so_hopdong_file'] = '<span style="color: #9ca3af;">Không có file hợp đồng</span>';
		}
		
		// Format avatar
		$avatar_dir = __DIR__ . "/../uploads/giaoviec/avatar/";
		$avatar_found = false;

		if (!empty($r_tt['avatar'])) {
			$avatar_path = $avatar_dir . basename($r_tt['avatar']);

			if (file_exists($avatar_path)) {
				$avatar_url = '/uploads/giaoviec/avatar/' . basename($r_tt['avatar']);
				$r_tt['avatar_image'] = '<img src="'.$avatar_url.'" alt="Avatar" style="width:200px;height:200px;object-fit:cover;border-radius:50%;">';
				$r_tt['avatar_icon_style'] = 'display:none;';
				$avatar_found = true;
			}
		}
		
		// Nếu không tìm thấy avatar
		if(!$avatar_found){
			$r_tt['avatar_image'] = '';
			$r_tt['avatar_icon_style'] = '';
		}
		
		// Format empty values - để trống thay vì hiển thị "Dữ liệu không tồn tại"
		$fields = array('username', 'name', 'email', 'mobile', 'dia_chi', 'time_hopdong', 'so_cccd', 'ngay_cap_cccd');
		foreach($fields as $field){
			if(empty($r_tt[$field])){
				$r_tt[$field] = '';
			}
		}
		
		$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_edit_user', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'html' => $html,
		'thongbao' => isset($thongbao) ? $thongbao : ''
	);
	echo json_encode($info);
}else if($action=='edit_nhansu'){
	$user_id = intval($_REQUEST['user_id']);
	$username = addslashes(strip_tags($_REQUEST['username']));
	$password = addslashes(strip_tags($_REQUEST['password']));
	$name_nhanvien = addslashes(strip_tags($_REQUEST['name'])); // name từ form input
	$email = addslashes(strip_tags($_REQUEST['email']));
	$mobile = addslashes(strip_tags($_REQUEST['mobile']));
	$address = addslashes(strip_tags($_REQUEST['address']));
	$so_hopdong = $_FILES['so_hopdong'];
	$time_hopdong = addslashes(strip_tags($_REQUEST['time_hopdong']));
	$so_cccd = addslashes(strip_tags($_REQUEST['so_cccd']));
	$ngay_cap_cccd = addslashes(strip_tags($_REQUEST['ngay_cap_cccd']));
	$file_data = $_FILES['avatar'];
	$loai_hopdong = addslashes(strip_tags($_REQUEST['loai_hopdong']));

	if(strlen($username) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập tên đăng nhập (tối thiểu 3 ký tự)';
	}else if(strlen($name_nhanvien) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập họ tên nhân viên';
	}else if(strlen($email) < 5){
		$ok = 0; $thongbao = 'Vui lòng nhập email hợp lệ';
	}else if(strlen($mobile) < 8){
		$ok = 0; $thongbao = 'Vui lòng nhập số điện thoại hợp lệ';
	}else if(strlen($address) < 3){
		$ok = 0; $thongbao = 'Vui lòng nhập địa chỉ';
	}else if(empty($time_hopdong)){
		$ok = 0; $thongbao = 'Vui lòng chọn thời hạn hợp đồng';
	}else if(strlen($so_cccd) < 12){
		$ok = 0; $thongbao = 'Vui lòng nhập số CCCD hợp lệ';
	}else if(empty($ngay_cap_cccd)){
		$ok = 0; $thongbao = 'Vui lòng chọn ngày cấp CCCD';
	}else if(empty($loai_hopdong)){
		$ok = 0; $thongbao = 'Vui lòng chọn loại hợp đồng';
	}else{
		// Lấy thông tin user hiện tại
		$thongtin_user = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
		$r_user = mysqli_fetch_assoc($thongtin_user);
		
		// Xử lý avatar
		$avatar = $r_user['avatar']; // Giữ nguyên avatar cũ nếu không upload mới
		if(!empty($file_data['name'])){
			// Xóa avatar cũ nếu có
			if(!empty($r_user['avatar'])){
				$old_avatar_path = __DIR__ . "/../uploads/giaoviec/avatar/" . basename($r_user['avatar']);
				if(file_exists($old_avatar_path)){
					@unlink($old_avatar_path);
				}
			}
			$ext = pathinfo($file_data['name'], PATHINFO_EXTENSION);
			$avatar = time()."_".rand(1000,9999).".".$ext;
			move_uploaded_file($file_data['tmp_name'], __DIR__."/../uploads/giaoviec/avatar/".$avatar);
		}

		// Xử lý file hợp đồng
		$hopdong_file = $r_user['so_hopdong']; // Giữ nguyên file cũ nếu không upload mới
		if(!empty($so_hopdong['name'])){
			// Xóa file hợp đồng cũ nếu có
			if(!empty($r_user['so_hopdong'])){
				$old_hopdong_path = __DIR__ . "/../uploads/giaoviec/hop_dong/" . basename($r_user['so_hopdong']);
				if(file_exists($old_hopdong_path)){
					@unlink($old_hopdong_path);
				}
			}
			$ext2 = pathinfo($so_hopdong['name'], PATHINFO_EXTENSION);
			$hopdong_file = time()."_HD_".rand(1000,9999).".".$ext2;
			move_uploaded_file($so_hopdong['tmp_name'], __DIR__."/../uploads/giaoviec/hop_dong/".$hopdong_file);	
		}
		
		// Cập nhật mật khẩu nếu có
		$update_password = '';
		if(!empty($password) && strlen($password) >= 6){
			$pass = md5($password);
			$update_password = ",password='$pass'";
		}
		
		$hientai = time();
		
		mysqli_query($conn, "UPDATE user_info SET username='$username'$update_password,email='$email',name='$name_nhanvien',avatar='$avatar',mobile='$mobile',dia_chi='$address',so_hopdong='$hopdong_file',time_hopdong='$time_hopdong',so_cccd='$so_cccd',ngay_cap_cccd='$ngay_cap_cccd',loai_hopdong='$loai_hopdong',update_post='$hientai' WHERE user_id='$user_id'");

		$ok = 1;
		$thongbao = "Cập nhật nhân sự thành công";
	}

	echo json_encode(array(
		"ok" => $ok,
		"thongbao" => $thongbao
	));
}else if($action=='box_pop_chuyen_user'){
	$user_id = intval($_REQUEST['user_id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$admin_cty = $r_tt['admin_cty'];
		$phong_ban_hien_tai = $r_tt['phong_ban'];
		$thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE admin_cty='$admin_cty' AND id ='$phong_ban_hien_tai'");
		$r_phongban = mysqli_fetch_assoc($thongtin_phongban);
		$r_tt['phong_ban_hien_tai'] = $r_phongban['tieu_de'];
		$r_tt['list_phongban'] = $class_giaoviec->list_option_edit_phan_cap($conn, $phong_ban_hien_tai, $admin_cty);
		$html = $skin->skin_replace('skin_cpanel/box_action/box_pop_chuyen_user', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='chuyen_user'){
	$user_id = intval($_REQUEST['user_id']);
	$phong_ban_moi = intval($_REQUEST['phong_ban_moi']);
	mysqli_query($conn, "UPDATE user_info SET phong_ban='$phong_ban_moi' WHERE user_id='$user_id'");
	$ok = 1;
	$thongbao = 'Chuyển phòng ban thành công';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);

}else if($action=='dung_hoat_dong_user'){
	$user_id = intval($_REQUEST['user_id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		mysqli_query($conn, "UPDATE user_info SET active='0' WHERE user_id='$user_id'");
		$thongbao = 'Dừng hoạt động nhân sự thành công';
		$phongban = $r_tt['phong_ban'];
	}	
		$info = array(
			'ok' => $ok,
			'thongbao' => $thongbao,
			'phongban' => $phongban
		);
		echo json_encode($info);
}else if($action=='kich_hoat_user'){
	$user_id = intval($_REQUEST['user_id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		mysqli_query($conn, "UPDATE user_info SET active='1' WHERE user_id='$user_id'");
		$thongbao = 'Kích hoạt nhân sự thành công';
		$phongban = $r_tt['phong_ban'];
	}	
		$info = array(
			'ok' => $ok,
			'thongbao' => $thongbao,
			'phongban' => $phongban
		);
		echo json_encode($info);
}else if($action=='add_video'){
	if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$link_video = strip_tags(addslashes($_REQUEST['link_video']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		$thongbao = 'Thêm video thành công';
		$ok = 1;
		mysqli_query($conn, "INSERT INTO video(tieu_de,minh_hoa,link_video,view,date_post)VALUES('$tieu_de','$minh_hoa','$link_video','0',".time().")");
	} else {
		$param_video = parse_url($link_video);
		parse_str($param_video['query'], $video_query);
		$id_video=addslashes($video_query['v']);
		$minh_hoa='https://i.ytimg.com/vi/'.$id_video.'/sddefault.jpg';
		mysqli_query($conn, "INSERT INTO video(tieu_de,minh_hoa,link_video,view,date_post)VALUES('$tieu_de','$minh_hoa','$link_video','0',".time().")");
		$thongbao = 'Thêm video thành công';
		$ok = 1;
	}
	$noidung_log=$user_info['name'].': Thêm video : Tiêu đề: '.$tieu_de.' - Link video: '.$link_video;
	mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if ($action == 'edit_video') {
	if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$link_video = strip_tags(addslashes($_REQUEST['link_video']));
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		$thongbao = 'Sửa video thành công';
		$ok = 1;
		mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',link_video='$link_video' WHERE id='$id'");
		@unlink('..' . $r_tt['minh_hoa']);
	} else {
		$param_video = parse_url($link_video);
		parse_str($param_video['query'], $video_query);
		$id_video=addslashes($video_query['v']);
		$minh_hoa='https://i.ytimg.com/vi/'.$id_video.'/sddefault.jpg';
		if($link_video!=$r_tt['link_video']){
			mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',link_video='$link_video' WHERE id='$id'");
		}else{
			mysqli_query($conn, "UPDATE video SET tieu_de='$tieu_de',link_video='$link_video' WHERE id='$id'");
		}
		$thongbao = 'Sửa video thành công';
		$ok = 1;
	}
	$noidung_log=$user_info['name'].': Chỉnh sửa video: Tiêu đề: '.$tieu_de.' - Link video: '.$link_video;
	mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='edit_profile'){
	$cong_ty = strip_tags(addslashes($_REQUEST['cong_ty']));
	$maso_thue = strip_tags(addslashes($_REQUEST['maso_thue']));
	$name = strip_tags(addslashes($_REQUEST['name']));
	$email = strip_tags(addslashes($_REQUEST['email']));
	$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if (strlen($name) < 2) {
			$thongbao = "Vui lòng nhập họ và tên";
			$ok = 0;
		}else if (strlen($mobile) < 8) {
			$thongbao = "Vui lòng nhập số điện thoại";
			$ok = 0;
		}else if (strlen($email) < 5) {
			$thongbao = "Vui lòng nhập địa chỉ email";
			$ok = 0;
		}else {
			$thongtin_mobile=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$mobile' AND user_id!='$user_id'");
			$total_mobile=mysqli_num_rows($thongtin_mobile);
			if($total_mobile>0){
				$ok=0;
				$thongbao='Thất bại! Số điện thoại đã có trên hệ thống';
			}else{
				$thongtin_email=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email' AND user_id!='$user_id'");
				$total_email=mysqli_num_rows($thongtin_email);
				if($total_email>0){
					$ok=0;
					$thongbao='Thất bại! Địa chỉ email đã có trên hệ thống';
				}else{
					$duoi = $check->duoi_file($_FILES['file']['name']);
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
						$minh_hoa = '/uploads/avatar/' . $check->blank($name) . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
						@unlink('..' . $user_info['avatar']);
						mysqli_query($conn, "UPDATE user_info SET name='$name',avatar='$minh_hoa',mobile='$mobile',email='$email' WHERE user_id='$user_id'");
					} else {
						mysqli_query($conn, "UPDATE user_info SET name='$name',mobile='$mobile',email='$email' WHERE user_id='$user_id'");
					}
					$ok = 1;
					$thongbao = 'Sửa thông tin thành công!';
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == "edit_setting") {
	if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$value = addslashes($_REQUEST['value']);
	mysqli_query($conn, "UPDATE index_setting SET value='$value' WHERE name='$name'");
	$noidung_log=$user_info['name'].': Chỉnh sửa cài đặt: Mục: '.$name.' - Giá trị: '.$value;
	mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
	$ok = 1;
	$thongbao = 'Sửa cài đặt thành công!';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_setting_img") {
	if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
		exit();
	}
	$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
		$minh_hoa = '/uploads/minh-hoa/' . $check->blank($name) . '-' . time() . '.' . $duoi;
		move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
		@unlink('..' . $index_setting[$name]);
		mysqli_query($conn, "UPDATE index_setting SET value='$minh_hoa' WHERE name='$name'");
		$noidung_log=$user_info['name'].': Chỉnh sửa cài đặt : Mục: '.$name.' - Giá trị: '.$minh_hoa;
		mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
		$ok = 1;
		$thongbao = 'Sửa cài đặt thành công!';
	} else {
		$thongbao = 'Thất bại! Bạn chưa chọn ảnh mới';
		$ok = 0;
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "change_password") {
	$old_pass = addslashes($_REQUEST['old_pass']);
	$pass = md5($old_pass);
	$new_pass = addslashes($_REQUEST['new_pass']);
	$confirm = addslashes($_REQUEST['confirm']);
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if (strlen($new_pass) < 6) {
			$thongbao = "Mật khẩu mới phải dài từ 6 ký tự";
			$ok = 0;
		} else if ($new_pass != $confirm) {
			$thongbao = "Nhập lại mật khẩu mới không khớp";
			$ok = 0;
		} else {
			$user_id = $_COOKIE['emin_id'];
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['password'] != $pass) {
				$ok = 0;
				$thongbao = "Mật khẩu hiện tại không đúng";
			} else {
				$password = md5($new_pass);
				mysqli_query($conn, "UPDATE user_info SET password='$password' WHERE user_id='$user_id'");
				$noidung_log=$user_info['name'].': Đổi mật khẩu của mình';
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$ok = 1;
				$thongbao = 'Đổi mật khẩu thành công';

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action == 'list_booking_traphi') {
    $thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE ket_hop = '1' AND user_id='$user_id' ORDER BY id DESC");
    $total = mysqli_num_rows($thongtin);

    if ($total == 0) {
        $ok = 0;
        $thongbao = 'Không có booking ';
        $list = [];
    } else {
        $ok = 1;
        $thongbao = 'Danh sách booking trả phí';
        $list = [];

        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            // Lấy thông tin từ list_container dựa vào ma_booking
            $container_info = mysqli_query($conn, "SELECT * FROM list_container WHERE ma_booking = '{$r_tt['ma_booking']}'");

            $containers = [];
            while ($r_container = mysqli_fetch_assoc($container_info)) {
                $containers[] = $r_container;
            }

            // Thêm thông tin booking và danh sách container vào mảng
            $r_tt['containers'] = $containers;
            $list[] = $r_tt;
        }
    }

    $info = array(
        'ok' => $ok,
        'thongbao' => $thongbao,
        'list' => $list,
        'user_id' => $user_id
    );

    echo json_encode($info);
}else if($action=='load_tk_notification'){
	if($user_info['bo_phan']=='all'){
		$thongtin=mysqli_query($conn,"SELECT * FROM notification_admin WHERE FIND_IN_SET($user_id,doc)<1");
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM notification_admin WHERE bo_phan='{$user_info['bo_phan']}' AND FIND_IN_SET($user_id,doc)<1");
	}
	$total=mysqli_num_rows($thongtin);
	if($total>9){
		$total='9+';
	}else{
		$total=$total;
	}
	$thongtin_naptien=mysqli_query($conn,"SELECT * FROM naptien WHERE status='3'");
	$total_naptien=mysqli_num_rows($thongtin_naptien);
	if($total_naptien>9){
		$total_naptien='9+';
	}else{
		$total_naptien=$total_naptien;
	}
	$thongtin_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE status='0' OR status='2' OR status='3'");
	$total_booking_wait=0;
	$total_booking_confirm=0;
	$total_booking_false=0;
	while($r_bk=mysqli_fetch_assoc($thongtin_booking)){
		if($r_bk['status']==0){
			$total_booking_wait++;
		}else if($r_bk['status']==2){
			$total_booking_confirm++;
		}else if($r_bk['status']==3){
			$total_booking_false++;
		}
	}
	if($total_booking_wait>9){
		$total_booking_wait='9+';
	}else{
		$total_booking_wait=$total_booking_wait;
	}
	if($total_booking_confirm>9){
		$total_booking_confirm='9+';
	}else{
		$total_booking_confirm=$total_booking_confirm;
	}
	if($total_booking_false>9){
		$total_booking_false='9+';
	}else{
		$total_booking_false=$total_booking_false;
	}
	if($user_info['bo_phan']=='all'){
		$thongke_chat=mysqli_query($conn,"SELECT * FROM chat WHERE active='1' GROUP BY thanh_vien");
	}else{
		$thongke_chat=mysqli_query($conn,"SELECT * FROM chat WHERE bo_phan='{$user_info['bo_phan']}' AND active='1' GROUP BY thanh_vien");
	}
	$total_chat=mysqli_num_rows($thongke_chat);
	if($total_chat>9){
		$total_chat='9+';
	}
	$info=array(
		'ok'=>1,
		'total'=>$total,
		'total_booking_wait'=>$total_booking_wait,
		'total_booking_confirm'=>$total_booking_confirm,
		'total_booking_false'=>$total_booking_false,
		'total_chat'=>$total_chat,
		'total_naptien'=>$total_naptien,
	);
	echo json_encode($info);
}else if($action=='del_photo'){
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$anh=addslashes($_REQUEST['anh']);
		$tach_anh=explode('/uploads/', $anh);
		@unlink('../uploads/'.$tach_anh[1]);
		$ok=1;
		$thongbao='Xóa ảnh thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'del') {
	$loai = addslashes($_REQUEST['loai']);
	$id = preg_replace('/[^0-9a-z-]/', '', $_REQUEST['id']);
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if($loai == 'thanhvien') {
			if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thành viên này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa thành viên thành công';
				@unlink('..' . $r_tt['avatar']);
				mysqli_query($conn, "DELETE FROM user_info WHERE user_id='$id'");
				$noidung_log=$user_info['name'].': Xóa thành viên : Họ và tên: '.$r_tt['name'].' - Điện thoại: '.$r_tt['mobile'].' - Email: '.$r_tt['email'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='slide') {
			if(in_array('slide', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM slide WHERE id='$id' AND shop='0'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Slide không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa slide thành công';
				mysqli_query($conn, "DELETE FROM slide WHERE id='$id'");
				@unlink('..' . $r_tt['minh_hoa']);
			}
		}else if($loai=='banner') {
			if(in_array('banner', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM banner WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Banner không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa banner thành công';
				mysqli_query($conn, "DELETE FROM banner WHERE id='$id'");
				@unlink('..' . $r_tt['minh_hoa']);
			}
		}else if($loai=='video') {
			if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM video WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Video không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa video thành công';
				mysqli_query($conn, "DELETE FROM video WHERE id='$id'");
				@unlink('..' . $r_tt['minh_hoa']);
				$noidung_log=$user_info['name'].': Xóa video: '.$r_tt['tieu_de'].' - Link video: '.$r_tt['link_video'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='baiviet') {
			if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM bai_viet WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Bài viết không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa bài viết thành công';
				mysqli_query($conn, "DELETE FROM bai_viet WHERE id='$id'");
				@unlink('..' . $r_tt['minh_hoa']);
				$noidung_log=$user_info['name'].': Xóa bài viết: '.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='quantri'){
			if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Quản trị không tồn tại';
			}else{
				if($r_tt['emin_group']==1){
					$ok=0;
					$thongbao='Thất bại! Đây là tài khoản quản trị cấp cao';
				}else{
					$ok=1;
					$thongbao='Xóa quản trị viên thành công';
					mysqli_query($conn,"DELETE FROM user_info WHERE user_id='$id'");
					$noidung_log=$user_info['name'].': Xóa quản trị viên : Họ và tên: '.$r_tt['name'].' - Điện thoại: '.$r_tt['mobile'].' - Email: '.$r_tt['email'];
					mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				}
			}
		}else if($loai=='lienhe'){
			if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM lien_he WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Liên hệ không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa liên hệ thành công';
				mysqli_query($conn,"DELETE FROM lien_he WHERE id='$id'");
				$noidung_log=$user_info['name'].': Xóa liên hệ : Họ và tên: '.$r_tt['ho_ten'].' - Email: '.$r_tt['email'].' - Điện thoại: '.$r_tt['dien_thoai'].' - Nội dung: '.$r_tt['noi_dung'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='container'){
			if(in_array('container', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM loai_container WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa container thành công';
				mysqli_query($conn,"DELETE FROM loai_container WHERE id='$id'");
				$noidung_log=$user_info['name'].': Xóa loại container : '.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='hangtau'){
			if(in_array('hangtau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_hangtau WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa hãng tàu thành công';
				mysqli_query($conn,"DELETE FROM list_hangtau WHERE id='$id'");
				$noidung_log=$user_info['name'].': Xóa hãng tàu :'.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='cang'){
			if(in_array('cang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_cang WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa cảng thành công';
				mysqli_query($conn,"DELETE FROM list_cang WHERE id='$id'");
				$noidung_log=$user_info['name'].': Xóa cảng :'.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
			}
		}else if($loai=='xa'){
			if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM xa_moi WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa xã/phường thành công';
				mysqli_query($conn,"DELETE FROM xa_moi WHERE id='$id'");
				$noidung_log=$user_info['name'].': Xóa xã :'.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$list='  <tr>
                            <th class="sticky-row" width="80">STT</th>
                            <th class="sticky-row">Xã/phường/thị trấn</th>
                            <th class="sticky-row sticky-column" width="200">Hành động</th>
                        </tr>'.$class_index->list_xa($conn,$r_tt['huyen'],1,100);
			}
		}else if($loai=='huyen'){
			if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM huyen_moi WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa quận/huyện thành công';
				mysqli_query($conn,"DELETE FROM huyen_moi WHERE id='$id'");
				mysqli_query($conn,"DELETE FROM xa_moi WHERE huyen='$id'");
				$noidung_log=$user_info['name'].': Xóa quận/huyện :'.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$list=' <tr>
			                <th class="sticky-row" width="80">STT</th>
			                <th class="sticky-row">Quận/Huyện</th>
			                <th class="sticky-row sticky-column" width="360">Hành động</th>
			              </tr>'.$class_index->list_huyen($conn,$r_tt['tinh'],1,100);
			}
		}else if($loai=='tinh'){
			if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM tinh_moi WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dư liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa Tỉnh/TP thành công';
				mysqli_query($conn,"DELETE FROM tinh_moi WHERE id='$id'");
				mysqli_query($conn,"DELETE FROM huyen_moi WHERE tinh='$id'");
				mysqli_query($conn,"DELETE FROM xa_moi WHERE tinh='$id'");
				$noidung_log=$user_info['name'].': Xóa Tỉnh/TP :'.$r_tt['tieu_de'];
				mysqli_query($conn,"INSERT INTO knvc_log(user_id,noi_dung,date_post)VALUES('$user_id','$noidung_log',".time().")");
				$list='<tr>
		                <th class="sticky-row">STT</th>
		                <th class="sticky-row" width="200">Tỉnh/TP</th>
		                <th class="sticky-row sticky-column" width="300">Hành động</th>
		              </tr>'.$class_index->list_tinh($conn,1,100);
			}
		}else if($loai=='thongbao'){
			if(in_array('thongbao', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM thongbao WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Thông báo không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa thông báo thành công';
				mysqli_query($conn,"DELETE FROM thongbao WHERE id='$id'");
				@unlink('..'.$r_tt['minh_hoa']);
				@unlink('..'.$r_tt['img_pop']);
			}
		}else if($loai=='phi_kethop'){
			if(in_array('hang_tau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
				echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
				exit();	
			}
			$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM phi_kethop WHERE id='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']==0){
				$ok=0;
				$thongbao='Dữ liệu không tồn tại';
			}else{
				$ok=1;
				$thongbao='Xóa dữ liệu thành công';
				mysqli_query($conn,"DELETE FROM phi_kethop WHERE id='$id'");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);

} else if ($action == 'upload_tinymce') {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
		$minh_hoa = '';
	} else {
		$filename = $_FILES['file']['name'];
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
			$minh_hoa = '/uploads/hinh-anh/' . $check->blank(str_replace('.'.$duoi,'', $filename)) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$thongbao = 'Upload ảnh thành công';
			$ok = 1;
			$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
		} else {
			$thongbao = 'Vui lòng chọn ảnh minh họa';
			$ok = 0;
			$minh_hoa = '';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'minh_hoa' => $minh_hoa,
	);
	echo json_encode($info);

}else if ($action == 'upload_photo') {
	if (!isset($_COOKIE['user_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
		$list = '';
	} else {
		$total=count($_FILES['file']['name']);
		$k=0;
		for ($i=0; $i < $total ; $i++) { 
			$filename = $_FILES['file']['name'][$i];
			$duoi = $check->duoi_file($_FILES['file']['name'][$i]);
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp','mp4','wmv','mov')) == true) {
				$folder_name = '/uploads/hinh-anh/'.date('d-m-Y',time()).'/';

				if (!file_exists('..'.$folder_name)) {
				    mkdir('..'.$folder_name, 0777);
				} else {
				}
				$minh_hoa = $folder_name.''. $check->blank(str_replace('.'.$duoi,'', $filename)) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
				//$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
				//$list.=$index_setting['link_domain'] . '' . substr($minh_hoa,1)."\n";
				if(in_array($duoi, array('mp4','wmv','mov'))==true){
					$pt['src']='/'.substr($minh_hoa,1);
					$pt['minh_hoa']='/images/video.png';
					$list.=$skin->skin_replace('skin_members/box_action/li_photo_video',$pt);
				}else{
					$pt['src']='/'.substr($minh_hoa,1);
					$list.=$skin->skin_replace('skin_members/box_action/li_photo',$pt);
				}
				$k++;
			}
		}
		if($k>0){
			$ok=1;
			$thongbao='Upload ảnh thành công!';
		}else{
			$thongbao='Không có ảnh nào được upload'.$total;
			$ok=0;
		}
	}
	echo json_encode(array('ok'=>$ok,'thongbao'=>$thongbao,'list'=>$list));
} else if ($action == 'goi_y') {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$cat = strip_tags(addslashes($_REQUEST['cat']));
	$cat = 'cat' . $cat;
	$thongtin = mysqli_query($conn, "SELECT id,tieu_de FROM sanpham WHERE MATCH(tieu_de) AGAINST('$tieu_de') AND MATCH(category) AGAINST('$cat') ORDER BY gia ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<li value="' . $r_tt['id'] . '"><span>' . $r_tt['tieu_de'] . '</span></li>';
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'check_blank') {
	$link = $check->blank($_REQUEST['link']);
	$loai=addslashes($_REQUEST['loai']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link' AND loai='$loai'");
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
	$link = $_REQUEST['link'];
	$loai=addslashes($_REQUEST['loai']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link' AND loai='$loai'");
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





}
else if($action=="add_quantri"){
	$username=strip_tags(addslashes($_REQUEST['username']));
	$password=strip_tags(addslashes($_REQUEST['password']));
	$re_password=strip_tags(addslashes($_REQUEST['re_password']));
	$ho_ten=strip_tags(addslashes($_REQUEST['ho_ten']));
	$dien_thoai=preg_replace('/[^0-9]/', '', $_REQUEST['dien_thoai']);
	$email=strip_tags(addslashes($_REQUEST['email']));
	$group=strip_tags(addslashes($_REQUEST['group']));
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();
		}
		if(strlen($username)<4){
			$thongbao="Thất bại! Hãy nhập tài khoản dài từ 4 ký tự";
			$ok=0;
		}else if(strlen($password)<6){
			$thongbao="Thất bại! Hãy nhập mật khẩu dài từ 6 ký tự";
			$ok=0;
		}else if($password!=$re_password){
			$thongbao="Thất bại! Xác nhận mật khẩu không khớp";
			$ok=0;
		}else if(strlen($ho_ten)<6){
			$thongbao="Thất bại! Hãy nhập họ và tên";
			$ok=0;
		}else if(strlen($dien_thoai)<6){
			$thongbao="Thất bại! Hãy nhập số điện thoại";
			$ok=0;
		}else if($check->check_email($email)==false){
			$thongbao="Thất bại! Hãy nhập địa chỉ email";
			$ok=0;
		}else if(strlen($group)<3){
			$thongbao="Thất bại! Chưa chọn khu vực quản trị";
			$ok=0;
		}else{
			$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE username='$username'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']>0){
				$thongbao='Thất bại! Tài khoản đã tồn tại';
				$ok=0;
			}else{
				$thongtin_dienthoai=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$dien_thoai'");
				$total_mobile=mysqli_num_rows($thongtin_dienthoai);
				if($total_mobile>0){
					$thongbao='Thất bại! Số điện thoại đã có trên hệ thống';
					$ok=0;
				}else{
					$thongtin_email=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
					$total_email=mysqli_num_rows($thongtin_email);
					if($total_email>0){
						$thongbao='Thất bại! Địa chỉ email đã có trên hệ thống';
						$ok=0;
					}else{
						$pass=md5($password);
						$ip_address = $_SERVER['REMOTE_ADDR'];
						mysqli_query($conn, "INSERT INTO user_info(username,password,email,name,avatar,user_money,user_money2,rate,num_rate,mobile,ngaysinh,dia_chi,cong_ty,maso_thue,code_active,active,nhom,emin_group,bo_phan,aff,created,ip_address,logined,end_online)VALUES('$username','$pass','$email','$ho_ten','','0','0','0','0','$dien_thoai','','','','','','1','1','$group','','','$hientai','$ip_address','$hientai','')");
						$ok=1;
						$thongbao='Thêm quản trị viên thành công!';
					}
				}
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="edit_quantri"){
	$username=strip_tags(addslashes($_REQUEST['username']));
	$password=strip_tags(addslashes($_REQUEST['password']));
	$re_password=strip_tags(addslashes($_REQUEST['re_password']));
	$ho_ten=strip_tags(addslashes($_REQUEST['ho_ten']));
	$dien_thoai=preg_replace('/[^0-9]/', '', $_REQUEST['dien_thoai']);
	$email=strip_tags(addslashes($_REQUEST['email']));
	$group=strip_tags(addslashes($_REQUEST['group']));
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();
		}
		if(strlen($username)<4){
			$thongbao="Thất bại! Hãy nhập tài khoản dài từ 4 ký tự";
			$ok=0;
		}else if(strlen($password)<6 AND $password!=''){
			$thongbao="Thất bại! Hãy nhập mật khẩu dài từ 6 ký tự";
			$ok=0;
		}else if($password!=$re_password AND $password!=''){
			$thongbao="Thất bại! Xác nhận mật khẩu không khớp";
			$ok=0;
		}else if(strlen($ho_ten)<6){
			$thongbao="Thất bại! Hãy nhập họ và tên";
			$ok=0;
		}else if(strlen($dien_thoai)<6){
			$thongbao="Thất bại! Hãy nhập số điện thoại";
			$ok=0;
		}else if($check->check_email($email)==false){
			$thongbao="Thất bại! Hãy nhập địa chỉ email";
			$ok=0;
		}else if(strlen($group)<3){
			$thongbao="Thất bại! Chưa chọn khu vực quản trị";
			$ok=0;
		}else{
			$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE username='$username' AND user_id!='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']>0){
				$thongbao='Thất bại! Tài khoản đã tồn tại';
				$ok=0;
			}else{
				$thongtin_dienthoai=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$dien_thoai' AND user_id!='$id'");
				$total_mobile=mysqli_num_rows($thongtin_dienthoai);
				if($total_mobile>0){
					$thongbao='Thất bại! Số điện thoại đã có trên hệ thống';
					$ok=0;
				}else{
					$thongtin_email=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email' AND user_id!='$id'");
					$total_email=mysqli_num_rows($thongtin_email);
					if($total_email>0){
						$thongbao='Thất bại! Địa chỉ email đã có trên hệ thống';
						$ok=0;
					}else{
						if($password!=''){
							$pass=md5($password);
							mysqli_query($conn,"UPDATE user_info SET username='$username',password='$pass',email='$email',name='$ho_ten',mobile='$dien_thoai',emin_group='$group' WHERE user_id='$id'");
						}else{
							mysqli_query($conn,"UPDATE user_info SET username='$username',email='$email',name='$ho_ten',mobile='$dien_thoai',emin_group='$group' WHERE user_id='$id'");
						}
						
						$ok=1;
						$thongbao='Lưu thay đổi thành công!';
					}
				}
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="add_cskh"){
	$username=strip_tags(addslashes($_REQUEST['username']));
	$password=strip_tags(addslashes($_REQUEST['password']));
	$re_password=strip_tags(addslashes($_REQUEST['re_password']));
	$ho_ten=strip_tags(addslashes($_REQUEST['ho_ten']));
	$dien_thoai=preg_replace('/[^0-9]/', '', $_REQUEST['dien_thoai']);
	$email=strip_tags(addslashes($_REQUEST['email']));
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();
		}
		if(strlen($username)<4){
			$thongbao="Thất bại! Hãy nhập tài khoản dài từ 4 ký tự";
			$ok=0;
		}else if(strlen($password)<6){
			$thongbao="Thất bại! Hãy nhập mật khẩu dài từ 6 ký tự";
			$ok=0;
		}else if($password!=$re_password){
			$thongbao="Thất bại! Xác nhận mật khẩu không khớp";
			$ok=0;
		}else if(strlen($ho_ten)<6){
			$thongbao="Thất bại! Hãy nhập họ và tên";
			$ok=0;
		}else if(strlen($dien_thoai)<6){
			$thongbao="Thất bại! Hãy nhập số điện thoại";
			$ok=0;
		}else if($check->check_email($email)==false){
			$thongbao="Thất bại! Hãy nhập địa chỉ email";
			$ok=0;
		}else{
			$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE username='$username'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']>0){
				$thongbao='Thất bại! Tài khoản đã tồn tại';
				$ok=0;
			}else{
				$thongtin_dienthoai=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$dien_thoai'");
				$total_mobile=mysqli_num_rows($thongtin_dienthoai);
				if($total_mobile>0){
					$thongbao='Thất bại! Số điện thoại đã có trên hệ thống';
					$ok=0;
				}else{
					$thongtin_email=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
					$total_email=mysqli_num_rows($thongtin_email);
					if($total_email>0){
						$thongbao='Thất bại! Địa chỉ email đã có trên hệ thống';
						$ok=0;
					}else{
						$pass=md5($password);
						$ip_address = $_SERVER['REMOTE_ADDR'];
						mysqli_query($conn, "INSERT INTO user_info(username,password,email,name,avatar,user_money,user_money2,rate,num_rate,mobile,ngaysinh,dia_chi,cong_ty,maso_thue,code_active,active,nhom,emin_group,bo_phan,aff,created,ip_address,logined,end_online)VALUES('$username','$pass','$email','$ho_ten','','0','0','0','0','$dien_thoai','','','','','','1','2','','','','$hientai','$ip_address','$hientai','')");
						$ok=1;
						$thongbao='Thêm chăm sóc khác hàng thành công!';
					}
				}
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=="edit_cskh"){
	$username=strip_tags(addslashes($_REQUEST['username']));
	$password=strip_tags(addslashes($_REQUEST['password']));
	$re_password=strip_tags(addslashes($_REQUEST['re_password']));
	$ho_ten=strip_tags(addslashes($_REQUEST['ho_ten']));
	$dien_thoai=preg_replace('/[^0-9]/', '', $_REQUEST['dien_thoai']);
	$email=strip_tags(addslashes($_REQUEST['email']));
	$id=intval($_REQUEST['id']);
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}else{
		if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();
		}
		if(strlen($username)<4){
			$thongbao="Thất bại! Hãy nhập tài khoản dài từ 4 ký tự";
			$ok=0;
		}else if(strlen($password)<6 AND $password!=''){
			$thongbao="Thất bại! Hãy nhập mật khẩu dài từ 6 ký tự";
			$ok=0;
		}else if($password!=$re_password AND $password!=''){
			$thongbao="Thất bại! Xác nhận mật khẩu không khớp";
			$ok=0;
		}else if(strlen($ho_ten)<6){
			$thongbao="Thất bại! Hãy nhập họ và tên";
			$ok=0;
		}else if(strlen($dien_thoai)<6){
			$thongbao="Thất bại! Hãy nhập số điện thoại";
			$ok=0;
		}else if($check->check_email($email)==false){
			$thongbao="Thất bại! Hãy nhập địa chỉ email";
			$ok=0;
		}else{
			$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE username='$username' AND user_id!='$id'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($r_tt['total']>0){
				$thongbao='Thất bại! Tài khoản đã tồn tại';
				$ok=0;
			}else{
				$thongtin_dienthoai=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$dien_thoai' AND user_id!='$id'");
				$total_mobile=mysqli_num_rows($thongtin_dienthoai);
				if($total_mobile>0){
					$thongbao='Thất bại! Số điện thoại đã có trên hệ thống';
					$ok=0;
				}else{
					$thongtin_email=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email' AND user_id!='$id'");
					$total_email=mysqli_num_rows($thongtin_email);
					if($total_email>0){
						$thongbao='Thất bại! Địa chỉ email đã có trên hệ thống';
						$ok=0;
					}else{
						if($password!=''){
							$pass=md5($password);
							mysqli_query($conn,"UPDATE user_info SET username='$username',password='$pass',email='$email',name='$ho_ten',mobile='$dien_thoai' WHERE user_id='$id'");
						}else{
							mysqli_query($conn,"UPDATE user_info SET username='$username',email='$email',name='$ho_ten',mobile='$dien_thoai' WHERE user_id='$id'");
						}
						
						$ok=1;
						$thongbao='Lưu thay đổi thành công!';
					}
				}
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='show_edit'){
	$loai=addslashes($_REQUEST['loai']);
	if($loai=='thanhvien'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_thanhvien', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='cskh'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$thongtin_cskh=mysqli_query($conn,"SELECT * FROM cskh WHERE user_id='$id'");
			$total_cskh=mysqli_num_rows($thongtin_cskh);
			if($total_cskh==0){
				$thongtin_nhanvien=mysqli_query($conn,"SELECT * FROM user_info WHERE nhom='2' ORDER BY name ASC");
				while($r_nv=mysqli_fetch_assoc($thongtin_nhanvien)){
					$list_option.='<option value="'.$r_nv['user_id'].'" name="'.$r_nv['name'].'" mobile="'.$r_nv['mobile'].'">'.$r_nv['name'].' - '.$r_nv['mobile'].'</option>';
				}
				$bien=array(
					'user_id'=>$id,
					'ho_ten'=>'',
					'dien_thoai'=>'',
					'list_cskh'=>$list_option
				);
				$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_cskh', $bien);
			}else{
				$r_cs=mysqli_fetch_assoc($thongtin_cskh);
				$thongtin_nhanvien=mysqli_query($conn,"SELECT * FROM user_info WHERE nhom='2' ORDER BY name ASC");
				while($r_nv=mysqli_fetch_assoc($thongtin_nhanvien)){
					if($r_tt['aff']==$r_nv['user_id']){
						$list_option.='<option value="'.$r_nv['user_id'].'" name="'.$r_nv['name'].'" mobile="'.$r_nv['mobile'].'" selected>'.$r_nv['name'].' - '.$r_nv['mobile'].'</option>';
					}else{
						$list_option.='<option value="'.$r_nv['user_id'].'" name="'.$r_nv['name'].'" mobile="'.$r_nv['mobile'].'">'.$r_nv['name'].' - '.$r_nv['mobile'].'</option>';
					}
				}
				$r_cs['list_cskh']=$list_option;
				$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_cskh', $r_cs);
			}
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='cang'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_cang WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_cang', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='tinh'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM tinh_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_tinh', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='huyen'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM huyen_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_huyen', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='xa'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM xa_moi WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_xa', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='hangtau'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_hangtau', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='container'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM loai_container WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$r_tt['option_hangtau']=$class_index->list_option_hangtau($conn, $r_tt['hang_tau']);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_container', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='phi_kethop'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM phi_kethop WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$r_tt['phi']=number_format($r_tt['phi']);
			$r_tt['option_hangtau']=$class_index->list_option_hangtau_vt($conn, $r_tt['hang_tau']);
			$html = $skin->skin_replace('skin_cpanel/box_action/show_edit_phi_kethop', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}
}else if($action=='show_add'){
	$loai=addslashes($_REQUEST['loai']);
	if($loai=='thanhvien'){
		$id=intval($_REQUEST['id']);
		$ok=1;
		$html = $skin->skin_normal('skin_cpanel/box_action/show_add_thanhvien');
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='huyen'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM tinh_moi WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$ok=1;
		$html = $skin->skin_replace('skin_cpanel/box_action/show_add_huyen',$r_tt);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='xa'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi LEFT JOIN tinh_moi ON huyen_moi.tinh=tinh_moi.id WHERE huyen_moi.id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$ok=1;
		$html = $skin->skin_replace('skin_cpanel/box_action/show_add_xa',$r_tt);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='cang'){
		$id=intval($_REQUEST['id']);
		$ok=1;
		$html = $skin->skin_normal('skin_cpanel/box_action/show_add_cang');
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='hangtau'){
		$id=intval($_REQUEST['id']);
		$ok=1;
		$html = $skin->skin_normal('skin_cpanel/box_action/show_add_hangtau');
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='tinh'){
		$id=intval($_REQUEST['id']);
		$ok=1;
		$html = $skin->skin_normal('skin_cpanel/box_action/show_add_tinh');
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='container'){
		$id=intval($_REQUEST['id']);
		$ok=1;
		$bien=array(
			'option_hangtau'=>$class_index->list_option_hangtau($conn, $id)
		);
		$html = $skin->skin_replace('skin_cpanel/box_action/show_add_container',$bien);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='phi_kethop'){
		$ok=1;
		$bien=array(
			'option_hangtau'=>$class_index->list_option_hangtau($conn, '')
		);
		$html = $skin->skin_replace('skin_cpanel/box_action/show_add_phi_kethop',$bien);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}
}else if($action=='load_list_thongke_congviec'){

	$page = intval($_REQUEST['page']);
	$limit = 10;
	$admin_cty = $user_info['admin_cty'];

	$thongke = mysqli_query($conn, "
		SELECT COUNT(*) AS total FROM giaoviec_tructiep as gv WHERE gv.admin_cty = '{$admin_cty}'
	");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_thongke_congviec = json_decode($class_giaoviec->list_thongke_congviec($conn, $admin_cty, $page, $limit),true);
	$r_tt['list_thongke_congviec'] = $list_thongke_congviec['list'];
	$r_tt['start'] = $list_thongke_congviec['start'];
	$r_tt['end'] = $list_thongke_congviec['end'];
	$r_tt['phantrang'] = $class_giaoviec->phantrang($page,$total_page,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thongke_congviec',$r_tt);
	$info = array(
		'ok' => 1,	
		'list' => $list_thongke_congviec['list'],
	);
	echo json_encode($info);
}else if($action=='box_pop_view_giaoviec_tructiep'){

	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty' AND phantram_hoanthanh='100'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop xem chi tiết công việc đã hoàn thành';
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		// Lấy thông tin người giao
		$thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_giao']}'");
		$r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
		$r_tt['ten_nguoi_giao'] = !empty($r_nguoi_giao['name']) ? $r_nguoi_giao['name'] : 'Không xác định';
		$thongtin_phongban_giao = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_giao['phong_ban']}'");
		$r_phongban_giao = mysqli_fetch_assoc($thongtin_phongban_giao);
		$r_tt['ten_phongban_giao'] = !empty($r_phongban_giao['tieu_de']) ? $r_phongban_giao['tieu_de'] : '';
		
		// Lấy thông tin người nhận
		if(!empty($r_tt['id_nguoi_nhan'])){
			$thongtin_nguoi_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}'");
			$r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
			$r_tt['ten_nguoi_nhan'] = !empty($r_nguoi_nhan['name']) ? $r_nguoi_nhan['name'] : 'Không xác định';
			$thongtin_phongban_nhan = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_nhan['phong_ban']}'");
			$r_phongban_nhan = mysqli_fetch_assoc($thongtin_phongban_nhan);
			$r_tt['ten_phongban_nhan'] = !empty($r_phongban_nhan['tieu_de']) ? $r_phongban_nhan['tieu_de'] : '';
		} else {
			$r_tt['ten_nguoi_nhan'] = 'Chưa xác định';
			$r_tt['ten_phongban_nhan'] = '';
		}
		
		// Lấy thông tin người giám sát
		if(!empty($r_tt['id_nguoi_giamsat'])){
			$thongtin_nguoi_giamsat = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_giamsat']}'");
			$r_nguoi_giamsat = mysqli_fetch_assoc($thongtin_nguoi_giamsat);
			$r_tt['ten_nguoi_giamsat'] = !empty($r_nguoi_giamsat['name']) ? $r_nguoi_giamsat['name'] : 'Không xác định';
			$thongtin_phongban_giamsat = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_giamsat['phong_ban']}'");
			$r_phongban_giamsat = mysqli_fetch_assoc($thongtin_phongban_giamsat);
			$r_tt['ten_phongban_giamsat'] = !empty($r_phongban_giamsat['tieu_de']) ? $r_phongban_giamsat['tieu_de'] : '';
		} else {
			$r_tt['ten_nguoi_giamsat'] = 'Chưa xác định';
			$r_tt['ten_phongban_giamsat'] = '';
		}
		
		// Format các trường
		$r_tt['ten_congviec'] = !empty($r_tt['ten_congviec']) ? htmlspecialchars($r_tt['ten_congviec']) : '-';
		$r_tt['mo_ta_congviec'] = !empty($r_tt['mo_ta_congviec']) ? nl2br(htmlspecialchars($r_tt['mo_ta_congviec'])) : '-';
		
		// Format mức độ ưu tiên (giống box_pop_view_giaoviec_tructiep)
		$r_tt['mucdo_uutien_raw'] = $r_tt['mucdo_uutien'];
		if($r_tt['mucdo_uutien'] == 'thap'){
			$r_tt['mucdo_uutien_text'] = 'Thấp';
		}else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
			$r_tt['mucdo_uutien_text'] = 'Bình thường';
		}else if($r_tt['mucdo_uutien'] == 'cao'){
			$r_tt['mucdo_uutien_text'] = 'Cao';
		}else if($r_tt['mucdo_uutien'] == 'rat_cao'){
			$r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
		} else {
			$r_tt['mucdo_uutien_text'] = 'Không xác định';
		}
		
		// Xử lý ngay_batdau - có thể là timestamp hoặc chuỗi date (giống box_pop_view_giaoviec_tructiep)
		if(!empty($r_tt['date_post'])){
			if(is_numeric($r_tt['date_post'])){
				$r_tt['ngay_bat_dau'] = date('d/m/Y H:i', intval($r_tt['date_post']));
			} else {
				$timestamp = strtotime($r_tt['date_post']);
				$r_tt['ngay_bat_dau'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
			}
		} else {
			$r_tt['ngay_bat_dau'] = '-';
		}
		
		// Xử lý han_hoanthanh - có thể là timestamp hoặc chuỗi date (giống box_pop_view_giaoviec_tructiep)
		if(!empty($r_tt['han_hoanthanh'])){
			if(is_numeric($r_tt['han_hoanthanh'])){
				$r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
			} else {
				$timestamp = strtotime($r_tt['han_hoanthanh']);
				$r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
			}
		} else {
			$r_tt['han_hoan_thanh'] = '-';
		}
		
		// Format ngày hoàn thành
		if(!empty($r_tt['update_post'])){
			if(is_numeric($r_tt['update_post'])){
				$r_tt['ngay_hoanthanh'] = date('d/m/Y H:i', intval($r_tt['update_post']));
			} else {
				$timestamp = strtotime($r_tt['update_post']);
				$r_tt['ngay_hoanthanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
			}
		} else {
			$r_tt['ngay_hoanthanh'] = '-';
		}
		
		// Format phần trăm hoàn thành
		$r_tt['phantram_hoanthanh'] = !empty($r_tt['phantram_hoanthanh']) ? intval($r_tt['phantram_hoanthanh']) : 100;
		
		// Format trạng thái (luôn là "Hoàn thành" vì đã lọc phantram_hoanthanh='100')
		$r_tt['trang_thai_raw'] = 6;
		$r_tt['trang_thai_text'] = '<span class="status_badge status_completed">Hoàn thành</span>';
		
		// Xử lý file đính kèm (giống box_pop_view_giaoviec_tructiep)
		$file_section = '';
		if(!empty($r_tt['file_congviec'])){
			$files = array();
			
			// Thử decode JSON trước
			$decoded = json_decode($r_tt['file_congviec'], true);
			if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
				// Là JSON array
				$files = $decoded;
			}else{
				// Không phải JSON, xử lý như chuỗi comma-separated
				// Loại bỏ dấu ngoặc vuông, ngoặc kép và khoảng trắng
				$cleaned = trim($r_tt['file_congviec'], '[]"\'');
				$files = explode(',', $cleaned);
			}
			
			$file_list = '';
			foreach($files as $file){
				// Loại bỏ khoảng trắng, dấu ngoặc kép, dấu ngoặc đơn
				$file = trim($file, ' "\'[]');
				if(!empty($file)){
					$file_name = basename($file);
					$file_url = '/uploads/giaoviec/file_congviec_tructiep/'.$file;
					$file_list .= '<div class="file_item">
						<div class="file_item_left">
							<i class="fa fa-file"></i>
							<span class="file_name">'.htmlspecialchars($file_name).'</span>
						</div>
						<a href="'.$file_url.'" download>
							<i class="fa fa-download"></i> Tải về
						</a>
					</div>';
				}
			}
			if(!empty($file_list)){
				$file_section = '<div class="box_pop_view_lichsu_giaoviec_section">
					<h6 class="box_pop_view_lichsu_giaoviec_section_title">File đính kèm</h6>
					<div class="file_list">'.$file_list.'</div>
				</div>';
			}
		}
		$r_tt['file_section'] = $file_section;
		
		// Không có footer_action cho lịch sử (công việc đã hoàn thành)
		$r_tt['footer_action'] = '';
		$r_tt['trang_thai_text'] = '<span class="status_badge status_completed">Hoàn thành</span>';
		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_giaoviec_tructiep', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_filter_du_an'){
	$ok=1;
	$r_tt = array();
	$r_tt['title'] = 'dự án';
	$r_tt['submit_filter'] = 'submit_filter_du_an';
	$r_tt['list_nguoi_tao'] = $class_giaoviec->list_option_nguoi_tao($conn, $user_info['admin_cty']);
	$html = $skin->skin_replace('skin_cpanel/box_action/box_filter',$r_tt);
	$info=array(
		'ok'=>$ok,
		'html'=>$html,
		'thongbao'=>'Box pop filter dự án'
	);
	echo json_encode($info);
}else if($action=='box_pop_filter_giaoviec'){
	$ok=1;
	$r_tt = array();	
	$r_tt['title'] = 'công việc';
	$r_tt['submit_filter'] = 'submit_filter_giaoviec';
	$r_tt['list_nguoi_tao'] = $class_giaoviec->list_option_nguoi_tao($conn, $user_info['admin_cty']);
	$html = $skin->skin_replace('skin_cpanel/box_action/box_filter',$r_tt);
	$info=array(
		'ok'=>$ok,
		'html'=>$html,
		'thongbao'=>'Box pop filter giao việc'
	);
	echo json_encode($info);
}else if($action=='box_pop_view_lichsu_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty' ");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop xem chi tiết lịch sử dự án';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		// Escape HTML cho các giá trị text
		$r_tt['ten_du_an'] = !empty($r_tt['ten_du_an']) ? htmlspecialchars($r_tt['ten_du_an']) : '';
		$r_tt['mo_ta'] = !empty($r_tt['mo_ta']) ? htmlspecialchars($r_tt['mo_ta']) : '';
		$r_tt['ghi_chu'] = !empty($r_tt['ghi_chu']) ? htmlspecialchars($r_tt['ghi_chu']) : '';
		
		// Format ngày tạo
		$r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y H:i', $r_tt['date_post']) : '-';
		
		// Format ngày hoàn thành (sử dụng update_post nếu có, nếu không thì dùng date_post)
		if(!empty($r_tt['update_post'])){
			if(is_numeric($r_tt['update_post'])){
				$r_tt['ngay_hoanthanh'] = date('d/m/Y H:i', intval($r_tt['update_post']));
			} else {
				$timestamp = strtotime($r_tt['update_post']);
				$r_tt['ngay_hoanthanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
			}
		} else if(!empty($r_tt['date_post'])){
			if(is_numeric($r_tt['date_post'])){
				$r_tt['ngay_hoanthanh'] = date('d/m/Y H:i', intval($r_tt['date_post']));
			} else {
				$timestamp = strtotime($r_tt['date_post']);
				$r_tt['ngay_hoanthanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '-';
			}
		} else {
			$r_tt['ngay_hoanthanh'] = '-';
		}
		
		// Format mức độ ưu tiên
		$mucdo_uutien_original = $r_tt['mucdo_uutien'];
		if($r_tt['mucdo_uutien'] == 'thap'){
			$r_tt['mucdo_uutien_text'] = 'Thấp';
		}else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
			$r_tt['mucdo_uutien_text'] = 'Bình thường';
		}else if($r_tt['mucdo_uutien'] == 'cao'){
			$r_tt['mucdo_uutien_text'] = 'Cao';
		}else if($r_tt['mucdo_uutien'] == 'rat_cao'){
			$r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
		} else {
			$r_tt['mucdo_uutien_text'] = htmlspecialchars($r_tt['mucdo_uutien']);
		}
		$r_tt['mucdo_uutien'] = $mucdo_uutien_original;
		
		// Format trạng thái
		if($r_tt['trang_thai'] == 6){
			$r_tt['trang_thai_text'] = 'Hoàn thành';
			$r_tt['trang_thai_class'] = 'status_6';
		} else if($r_tt['trang_thai'] == 3){
			$r_tt['trang_thai_text'] = 'Miss Deadline';
			$r_tt['trang_thai_class'] = 'status_3';
		} else {
			$r_tt['trang_thai_text'] = 'Không xác định';
			$r_tt['trang_thai_class'] = 'status_default';
		}
		
		// Lấy thông tin người tạo dự án
		$thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty'");
		if(mysqli_num_rows($thongtin_nguoi_tao) > 0){
			$r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
			$r_tt['ten_nguoi_tao'] = !empty($r_nguoi_tao['name']) ? htmlspecialchars($r_nguoi_tao['name']) : 'Không xác định';
			$r_tt['phong_ban_nguoi_tao'] = !empty($r_nguoi_tao['phong_ban']) ? $r_nguoi_tao['phong_ban'] : 0;
			
			// Lấy tên phòng ban
			if($r_tt['phong_ban_nguoi_tao'] > 0){
				$thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_tt['phong_ban_nguoi_tao']}' AND admin_cty='$admin_cty'");
				if(mysqli_num_rows($thongtin_phongban) > 0){
					$r_phongban = mysqli_fetch_assoc($thongtin_phongban);
					$r_tt['ten_phongban_nguoi_tao'] = !empty($r_phongban['tieu_de']) ? htmlspecialchars($r_phongban['tieu_de']) : '';
				} else {
					$r_tt['ten_phongban_nguoi_tao'] = '';
				}
			} else {
				$r_tt['ten_phongban_nguoi_tao'] = '';
			}
		} else {
			$r_tt['ten_nguoi_tao'] = 'Không xác định';
			$r_tt['ten_phongban_nguoi_tao'] = '';
		}
		
		// Lấy danh sách công việc trong dự án và các thành viên
		$list_congviec = '';
		$congviec_data = array();
		
		// Lấy tất cả công việc và lưu vào mảng
		$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id' AND admin_cty='$admin_cty' ORDER BY id ASC");
		while ($r_cv = mysqli_fetch_assoc($thongtin_congviec)) {
			// Lấy thông tin người nhận việc
			$thongtin_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_cv['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
			$ten_nhan = 'Không xác định';
			$phong_ban_nhan = '';
			if(mysqli_num_rows($thongtin_nhan) > 0){
				$r_nhan = mysqli_fetch_assoc($thongtin_nhan);
				$ten_nhan = !empty($r_nhan['name']) ? htmlspecialchars($r_nhan['name']) : 'Không xác định';
				if(!empty($r_nhan['phong_ban'])){
					$thongtin_pb = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nhan['phong_ban']}' AND admin_cty='$admin_cty'");
					if(mysqli_num_rows($thongtin_pb) > 0){
						$r_pb = mysqli_fetch_assoc($thongtin_pb);
						$phong_ban_nhan = !empty($r_pb['tieu_de']) ? htmlspecialchars($r_pb['tieu_de']) : '';
					}
				}
			}
			
			// Lấy thông tin người giao việc
			$thongtin_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_cv['id_nguoi_giao']}' AND admin_cty='$admin_cty'");
			$ten_giao = 'Không xác định';
			if(mysqli_num_rows($thongtin_giao) > 0){
				$r_giao = mysqli_fetch_assoc($thongtin_giao);
				$ten_giao = !empty($r_giao['name']) ? htmlspecialchars($r_giao['name']) : 'Không xác định';
			}
			
			// Format ngày giao việc
			$ngay_giao = !empty($r_cv['date_post']) ? date('d/m/Y', $r_cv['date_post']) : '-';
			
			// Format deadline
			$deadline = !empty($r_cv['han_hoanthanh']) ? date('d/m/Y', strtotime($r_cv['han_hoanthanh'])) : '-';
			
			// Kiểm tra miss deadline
			$is_miss_deadline = false;
			if (!empty($r_cv['han_hoanthanh']) && $r_cv['trang_thai'] == 3) {
				$is_miss_deadline = true;
			}
			
			// Xác định role (quản lý nếu là node gốc)
			$role = ($r_cv['parent_id'] == 0) ? 'Quản lý' : '';
			
			// Lưu thông tin công việc
			$congviec_data[$r_cv['id']] = array(
				'id' => $r_cv['id'],
				'parent_id' => intval($r_cv['parent_id']),
				'ten_congviec' => htmlspecialchars($r_cv['ten_congviec']),
				'ten_nguoi_nhan' => $ten_nhan,
				'ten_nguoi_giao' => $ten_giao,
				'phong_ban_nhan' => $phong_ban_nhan,
				'ngay_giao' => $ngay_giao,
				'deadline' => $deadline,
				'is_miss_deadline' => $is_miss_deadline,
				'trang_thai' => $r_cv['trang_thai'],
				'role' => $role
			);
		}
		
		$r_tt['list_thanh_vien'] = $class_member->list_han_nhanviec($conn, $admin_cty, $id);
		
		// Xây dựng sơ đồ phân công dạng JSON cho OrgChart.js
		if (!empty($congviec_data)) {
			$org_chart_data = $class_member->build_org_chart_json($congviec_data, 0);
			
			// Nếu có nhiều hơn 1 node có parent_id = 0, tạo root node ảo để chứa tất cả
			if(count($org_chart_data) > 1){
				$root_node = array(
					'id' => 'root_0',
					'name' => $r_tt['ten_du_an'],
					'title' => $r_tt['ten_du_an'],
					'department' => '',
					'role' => 'Dự án',
					'isRoot' => true,
					'children' => $org_chart_data
				);
				$org_chart_data = array($root_node);
			} else if(count($org_chart_data) == 1) {
				// Nếu chỉ có 1 node, đánh dấu nó là root
				$org_chart_data[0]['isRoot'] = true;
			}
			
			$r_tt['so_do_phan_cong_json'] = json_encode($org_chart_data);
			$r_tt['so_do_phan_cong'] = '<div id="orgchart-container"></div>';
		} else {
			$r_tt['so_do_phan_cong_json'] = '[]';
			$r_tt['so_do_phan_cong'] = '<div class="org_chart_empty">Chưa có công việc nào trong dự án</div>';
		}
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_lichsu_du_an', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_view_lichsu_congviec_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
		$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
		
			$ok = 1;
			$thongbao = 'Box pop xem chi tiết công việc dự án';
			$r_tt['id'] = $id;
			
		// Format tên công việc
		$r_tt['ten_congviec'] = !empty($r_tt['ten_congviec']) ? htmlspecialchars($r_tt['ten_congviec']) : '-';
		
		// Format mô tả công việc
		$r_tt['mo_ta_congviec'] = !empty($r_tt['mo_ta_congviec']) ? htmlspecialchars($r_tt['mo_ta_congviec']) : '-';
		
		// Format ghi chú
		$r_tt['ghi_chu'] = !empty($r_tt['ghi_chu']) ? htmlspecialchars($r_tt['ghi_chu']) : '-';
		
		// Format mức độ ưu tiên
		$r_tt['mucdo_uutien_raw'] = !empty($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
		if($r_tt['mucdo_uutien'] == 'thap'){
			$r_tt['mucdo_uutien_text'] = 'Thấp';
		}else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
			$r_tt['mucdo_uutien_text'] = 'Bình thường';
		}else if($r_tt['mucdo_uutien'] == 'cao'){
			$r_tt['mucdo_uutien_text'] = 'Cao';
		}else if($r_tt['mucdo_uutien'] == 'rat_cao'){
			$r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
		} else {
			$r_tt['mucdo_uutien_text'] = 'Không xác định';
		}
		
		// Format phần trăm hoàn thành
		$r_tt['phantram_hoanthanh'] = !empty($r_tt['phantram_hoanthanh']) ? intval($r_tt['phantram_hoanthanh']) : 0;
		
		// Format trạng thái
		$trang_thai = !empty($r_tt['trang_thai']) ? intval($r_tt['trang_thai']) : 0;
		$r_tt['trang_thai_class'] = 'status_' . $trang_thai;
		switch ($r_tt['trang_thai']) {
			case 0:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
				break;
			case 1:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang thực hiện</span>';
				break;
			case 2:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_2">Chờ phê duyệt</span>';
				break;
			case 3:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_3">Miss Deadline</span>';
				break;
			case 4:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_4">Từ chối</span>';
				break;
			case 5:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_5">Xin gia hạn</span>';
				break;
			case 6:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_6">Hoàn thành</span>';
				break;
			default:
				$r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
				break;
		}
		
		$r_tt['list_giaopho'] = $class_member->list_giaoviec_giaopho($conn, $admin_cty, $id, $user_info['user_id']);
		
		// Lấy thông tin người giao việc
		$r_tt['ten_nguoi_giao'] = 'Không xác định';
		$r_tt['ten_phongban_giao'] = '';
		if(!empty($r_tt['id_nguoi_giao'])){
			$thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_giao']}' AND admin_cty='$admin_cty'");
			if(mysqli_num_rows($thongtin_nguoi_giao) > 0){
				$r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
				$r_tt['ten_nguoi_giao'] = !empty($r_nguoi_giao['name']) ? htmlspecialchars($r_nguoi_giao['name']) : 'Không xác định';
				if(!empty($r_nguoi_giao['phong_ban'])){
					$thongtin_phongban_giao = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_giao['phong_ban']}' AND admin_cty='$admin_cty'");
					if(mysqli_num_rows($thongtin_phongban_giao) > 0){
						$r_phongban_giao = mysqli_fetch_assoc($thongtin_phongban_giao);
						$r_tt['ten_phongban_giao'] = !empty($r_phongban_giao['tieu_de']) ? htmlspecialchars($r_phongban_giao['tieu_de']) : '';
					}
				}
			}
		}
		
		// Lấy thông tin người nhận việc
		$r_tt['ten_nguoi_nhan'] = 'Không xác định';
		$r_tt['ten_phongban_nhan'] = '';
		if(!empty($r_tt['id_nguoi_nhan'])){
			$thongtin_nguoi_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
			if(mysqli_num_rows($thongtin_nguoi_nhan) > 0){
				$r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
				$r_tt['ten_nguoi_nhan'] = !empty($r_nguoi_nhan['name']) ? htmlspecialchars($r_nguoi_nhan['name']) : 'Không xác định';
				if(!empty($r_nguoi_nhan['phong_ban'])){
					$thongtin_phongban_nhan = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_nhan['phong_ban']}' AND admin_cty='$admin_cty'");
					if(mysqli_num_rows($thongtin_phongban_nhan) > 0){
						$r_phongban_nhan = mysqli_fetch_assoc($thongtin_phongban_nhan);
						$r_tt['ten_phongban_nhan'] = !empty($r_phongban_nhan['tieu_de']) ? htmlspecialchars($r_phongban_nhan['tieu_de']) : '';
					}
				}
			}
		}
		
		// Format thời gian nhận việc
		if(!empty($r_tt['thoigian_nhanviec'])){
			$thoigian_nhanviec = intval($r_tt['thoigian_nhanviec']);
			if($thoigian_nhanviec > 0){
				if($thoigian_nhanviec < 60){
					$r_tt['thoigian_nhanviec_text'] = $thoigian_nhanviec . ' phút';
				} else {
					$gio = floor($thoigian_nhanviec / 60);
					$phut = $thoigian_nhanviec % 60;
					if($phut > 0){
						$r_tt['thoigian_nhanviec_text'] = $gio . ' giờ ' . $phut . ' phút';
					} else {
						$r_tt['thoigian_nhanviec_text'] = $gio . ' giờ';
					}
				}
			} else {
				$r_tt['thoigian_nhanviec_text'] = '-';
			}
		} else {
			$r_tt['thoigian_nhanviec_text'] = '-';
		}
		
		// Format hạn hoàn thành
		if (!empty($r_tt['han_hoanthanh'])) {
			$timestamp = strtotime($r_tt['han_hoanthanh']);
			$r_tt['han_hoanthanh_text'] = $timestamp
				? date('d/m/Y H:i', $timestamp)
				: '-';
		} else {
			$r_tt['han_hoanthanh_text'] = '-';
		}
		
		// Format ngày tạo
		$r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y H:i', $r_tt['date_post']) : '-';
		
		// Format ngày cập nhật
		$r_tt['ngay_cap_nhat'] = !empty($r_tt['update_post']) ? date('d/m/Y H:i', $r_tt['update_post']) : '-';
		
		// Lấy thông tin dự án
		$r_tt['ten_du_an'] = '-';
		if(!empty($r_tt['id_du_an'])){
			$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
			if(mysqli_num_rows($thongtin_du_an) > 0){
				$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
				$r_tt['ten_du_an'] = !empty($r_du_an['ten_du_an']) ? htmlspecialchars($r_du_an['ten_du_an']) : '-';
			}
		}
		
		// Xử lý file đính kèm
		$file_section = '';
		if(!empty($r_tt['file_congviec'])){
			$files = array();
			
			// Thử decode JSON trước
			$decoded = json_decode($r_tt['file_congviec'], true);
			if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
				// Là JSON array
				$files = $decoded;
			}else{
				// Không phải JSON, xử lý như chuỗi comma-separated
				$cleaned = trim($r_tt['file_congviec'], '[]"\'');
				$files = explode(',', $cleaned);
			}
			
			$file_list = '';
			foreach($files as $file){
				$file = trim($file, ' "\'[]');
				if(!empty($file)){
					$file_name = basename($file);
					$file_url = '/uploads/giaoviec/file_congviec_du_an/'.$file;
					$file_list .= '<div class="file_item">
						<div class="file_item_left">
							<i class="fa fa-file"></i>
							<span class="file_name">'.htmlspecialchars($file_name).'</span>
						</div>
						<a href="'.$file_url.'" download>
							<i class="fa fa-download"></i> Tải về
						</a>
					</div>';
				}
			}
			if(!empty($file_list)){
				$file_section = '<div class="box_pop_view_congviec_du_an_section">
					<div class="section_header">
						<h6 class="section_title">File đính kèm</h6>
					</div>
					<div class="section_fields">
						<div class="field field_full">
							<div class="file_list">'.$file_list.'</div>
						</div>
					</div>
				</div>';
			}
		}	
		$r_tt['file_section'] = $file_section;
		
		// Không set button_giaopho và footer_action cho readonly version
		$r_tt['button_giaopho'] = '';
		$r_tt['footer_action'] = '';

		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_lichsu_congviec_du_an', $r_tt);
		

	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_lichsu_giahan_congviec_du_an'){
	
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop lịch sử gia hạn';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		$r_tt['list_lichsu_giahan'] = $class_member->list_lichsu_giahan_congviec_du_an($conn,$user_info['user_id'], $admin_cty, $id);
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_lichsu_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_lichsu_baocao_congviec_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop lịch sử báo cáo';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$r_tt['list_lichsu_baocao'] = $class_member->list_lichsu_baocao_congviec_du_an($conn, $admin_cty, $id, $user_info['user_id']);
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_lichsu_baocao', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='load_list_giaoviec'){

	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_tao_tu = addslashes($_REQUEST['search_ngay_tao_tu']);
	$search_ngay_tao_den = addslashes($_REQUEST['search_ngay_tao_den']);
	$search_ngay_hoanthanh_tu = addslashes($_REQUEST['search_ngay_hoanthanh_tu']);
	$search_ngay_hoanthanh_den = addslashes($_REQUEST['search_ngay_hoanthanh_den']);
	$search_nguoi_tao = addslashes($_REQUEST['search_nguoi_tao']);
	$search_nguoi_nhan = addslashes($_REQUEST['search_nguoi_nhan']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];

	$list = $class_giaoviec->list_search_giaoviec($conn, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_tao_tu, $search_ngay_tao_den, $search_ngay_hoanthanh_tu, $search_ngay_hoanthanh_den, $search_nguoi_tao, $search_nguoi_nhan, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='load_list_du_an'){
	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_tao_tu = addslashes($_REQUEST['search_ngay_tao_tu']);
	$search_ngay_tao_den = addslashes($_REQUEST['search_ngay_tao_den']);
	$search_ngay_hoanthanh_tu = addslashes($_REQUEST['search_ngay_hoanthanh_tu']);
	$search_ngay_hoanthanh_den = addslashes($_REQUEST['search_ngay_hoanthanh_den']);
	$search_nguoi_tao = addslashes($_REQUEST['search_nguoi_tao']);
	$search_nguoi_nhan = addslashes($_REQUEST['search_nguoi_nhan']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];

	$list = $class_giaoviec->list_search_du_an($conn, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_tao_tu, $search_ngay_tao_den, $search_ngay_hoanthanh_tu, $search_ngay_hoanthanh_den, $search_nguoi_tao, $search_nguoi_nhan, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='box_pop_export_du_an'){
	$ok=1;
	$r_tt = array();
	$r_tt['title'] = 'dự án';
	$r_tt['submit_export'] = 'submit_export_du_an';
	$r_tt['list_nguoi_tao'] = $class_giaoviec->list_option_nguoi_tao($conn, $user_info['admin_cty']);
	$html = $skin->skin_replace('skin_cpanel/box_action/box_export',$r_tt);
	$info=array(
		'ok'=>$ok,
		'html'=>$html,
		'thongbao'=>'Box pop export dự án'
	);
	echo json_encode($info);
}else if($action=='box_pop_export_giaoviec'){
	$ok=1;
	$r_tt = array();	
	$r_tt['title'] = 'công việc';
	$r_tt['submit_export'] = 'submit_export_giaoviec';
	$r_tt['list_nguoi_tao'] = $class_giaoviec->list_option_nguoi_tao($conn, $user_info['admin_cty']);
	$html = $skin->skin_replace('skin_cpanel/box_action/box_export',$r_tt);
	$info=array(
		'ok'=>$ok,
		'html'=>$html,
		'thongbao'=>'Box pop export giao việc'
	);
	echo json_encode($info);

}else if (isset($_POST['action']) && $_POST['action'] == 'submit_export_giaoviec') {

    ob_start();

    $nguoi_dung = intval($_POST['nguoi_dung']);
    $admin_cty = $user_info['admin_cty'];

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();

	$sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    $thongtin_tao = mysqli_query($conn,"SELECT COUNT(*) as tong_tao 
        FROM giaoviec_tructiep 
        WHERE id_nguoi_giao = '$nguoi_dung' 
        AND admin_cty = '$admin_cty'");
    $tt_tao = mysqli_fetch_assoc($thongtin_tao);

    $sql_tk = "SELECT 
        COUNT(*) as tong,
        COALESCE(SUM(CASE WHEN trang_thai = '6' THEN 1 ELSE 0 END),0) as hoan_thanh,
        COALESCE(SUM(CASE WHEN trang_thai = '1' THEN 1 ELSE 0 END),0) as dang_lam,
        COALESCE(SUM(CASE WHEN miss_deadline = '1' THEN 1 ELSE 0 END),0) as qua_han,
        COALESCE(SUM(CASE WHEN trang_thai = '4' THEN 1 ELSE 0 END),0) as tuchoi,
        COALESCE(SUM(CASE WHEN trang_thai = '5' THEN 1 ELSE 0 END),0) as xin_giahan,
        COALESCE(SUM(CASE WHEN trang_thai = '0' THEN 1 ELSE 0 END),0) as cho_xuly,
        COALESCE(SUM(CASE WHEN trang_thai = '2' THEN 1 ELSE 0 END),0) as cho_duyet
    FROM giaoviec_tructiep
    WHERE id_nguoi_nhan = '$nguoi_dung' 
    AND admin_cty = '$admin_cty'";

    $result_tk = mysqli_query($conn, $sql_tk);
    $tt_nhan = mysqli_fetch_assoc($result_tk);

    $nguoi_dung_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$nguoi_dung'");
    $nguoi_dung_info = mysqli_fetch_assoc($nguoi_dung_info);

    $ten_nguoi_dung = $nguoi_dung_info['name'] ?? '';
    $phong_ban_id = $nguoi_dung_info['phong_ban'] ?? '';

    $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id = '$phong_ban_id'");
    $phong_ban = mysqli_fetch_assoc($thongtin_phongban);

    $ten_phong_ban = $phong_ban['tieu_de'] ?? '';

    $sheet->setCellValue('A1', 'THỐNG KÊ TỔNG QUAN');
    $sheet->mergeCells('A1:D1');

    $sheet->getStyle('A1:D1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'D9E1F2']]
    ]);

    $sheet->setCellValue('A3', 'Người nhận');
    $sheet->setCellValue('B3', $ten_nguoi_dung);

    $sheet->setCellValue('A4', 'Phòng ban');
    $sheet->setCellValue('B4', $ten_phong_ban);

    $sheet->setCellValue('A5', 'Tổng đã tạo');
    $sheet->setCellValue('B5', $tt_tao['tong_tao']);

    $sheet->setCellValue('A6', 'Tổng đã nhận');
    $sheet->setCellValue('B6', $tt_nhan['tong']);

    
	$tyle_ht = ($tt_nhan['tong'] > 0) ? round($tt_nhan['hoan_thanh'] / $tt_nhan['tong'] * 100, 2) : 0;
	$tyle_qh = ($tt_nhan['tong'] > 0) ? round($tt_nhan['qua_han'] / $tt_nhan['tong'] * 100, 2) : 0;
	$tyle_dung_han = ($tt_nhan['tong'] > 0) ? round(($tt_nhan['hoan_thanh'] - $tt_nhan['qua_han']) / $tt_nhan['tong'] * 100, 2) : 0;

    $sheet->setCellValue('A7', 'Tỷ lệ hoàn thành');
    $sheet->setCellValue('B7', $tyle_ht . '%');

	$sheet->setCellValue('A8', 'Tỷ lệ đúng hạn');
    $sheet->setCellValue('B8', $tyle_dung_han . '%');

    $sheet->setCellValue('A9', 'Tỷ lệ quá hạn');
    $sheet->setCellValue('B9', $tyle_qh . '%');


    $sheet->setCellValue('C3', 'Đã hoàn thành');
    $sheet->setCellValue('D3', $tt_nhan['hoan_thanh']);

    $sheet->setCellValue('C4', 'Đang làm');
    $sheet->setCellValue('D4', $tt_nhan['dang_lam']);

    $sheet->setCellValue('C5', 'Quá hạn');
    $sheet->setCellValue('D5', $tt_nhan['qua_han']);

    $sheet->setCellValue('C6', 'Từ chối');
    $sheet->setCellValue('D6', $tt_nhan['tuchoi']);

    $sheet->setCellValue('C7', 'Xin gia hạn');
    $sheet->setCellValue('D7', $tt_nhan['xin_giahan']);

    $sheet->setCellValue('C8', 'Chờ xử lý');
    $sheet->setCellValue('D8', $tt_nhan['cho_xuly']);

    $sheet->setCellValue('C9', 'Chờ duyệt');
    $sheet->setCellValue('D9', $tt_nhan['cho_duyet']);
	$sheet->getStyle('A3:A9')->getFont()->setBold(true);
	$sheet->getStyle('C3:C9')->getFont()->setBold(true);
	$sheet->getStyle('B3:B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D3:D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:D9')->applyFromArray([
        'borders' => [
            'outline' => ['style' => PHPExcel_Style_Border::BORDER_MEDIUM],
            'inside' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ]);

    $sheet->setCellValue('A12', 'THỐNG KÊ CÔNG VIỆC');
    $sheet->mergeCells('A12:K12');

	$sheet->getStyle('A12:K12')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'D9E1F2']]
    ]);

    $startRow = 14;

    $headers = ['STT','Người giao', 'Người nhận','Người giám sát','Tên công việc', 'Mô tả', 'Mức độ ưu tiên', 'Ngày tạo', 'Hạn hoàn thành', 'Trạng thái', 'Miss Deadline'];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . $startRow, $header);
        $col++;
    }

	$sheet->getStyle("A{$startRow}:K{$startRow}")->applyFromArray([
        'font' => ['bold' => true,'color' => ['rgb' => 'FFFFFF']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => '5B9BD5']]
    ]);
  
    $sql = "SELECT * FROM giaoviec_tructiep 
            WHERE id_nguoi_nhan = '$nguoi_dung' 
            AND admin_cty = '$admin_cty' 
            ORDER BY id DESC";

    $result = mysqli_query($conn, $sql);

    $rowIndex = $startRow + 1;

    while ($row = mysqli_fetch_assoc($result)) {
		$i++;
		$nguoi_giao_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '{$row['id_nguoi_giao']}'");
		$nguoi_giao_info = mysqli_fetch_assoc($nguoi_giao_info);
		$ten_nguoi_giao = $nguoi_giao_info['name'] ?? '';
		$nguoi_nhan_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '{$row['id_nguoi_nhan']}'");
		$nguoi_nhan_info = mysqli_fetch_assoc($nguoi_nhan_info);
		$ten_nguoi_nhan = $nguoi_nhan_info['name'] ?? '';
		$nguoi_giamsat_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '{$row['id_nguoi_giamsat']}'");
		$nguoi_giamsat_info = mysqli_fetch_assoc($nguoi_giamsat_info);
		$ten_nguoi_giamsat = $nguoi_giamsat_info['name'] ?? '';
		if($row['mucdo_uutien'] == 'thap'){
			$mucdo_uutien_text = 'Thấp';
		}else if($row['mucdo_uutien'] == 'binh_thuong'){
			$mucdo_uutien_text = 'Bình thường';
		}else if($row['mucdo_uutien'] == 'cao'){
			$mucdo_uutien_text = 'Cao';
		}else if($row['mucdo_uutien'] == 'rat_cao'){
			$mucdo_uutien_text = 'Khẩn cấp';
		} else {
			$mucdo_uutien_text = $row['mucdo_uutien'];
		}
		switch ($row['trang_thai']) {
			case 0:
				$trang_thai_text = 'Chờ xử lý';
				break;
			case 1:
				$trang_thai_text = 'Đang triển khai';
				break;
			case 2:
				$trang_thai_text = 'Chờ phê duyệt';
				break;
			case 4:
				$trang_thai_text = 'Từ chối';
				break;
			case 5:
				$trang_thai_text = 'Xin gia hạn';
				break;
			case 6:
				$trang_thai_text = 'Đã hoàn thành';
				break;
			default:
				$trang_thai_text = 'Không xác định';
				break;
		}
		$ngay_tao = date('d/m/Y',($row['date_post']));
		$han_hoanthanh = date('d/m/Y H:i', strtotime($row['han_hoanthanh']));
		$miss_deadline = $row['miss_deadline'] == 1 ? 'Có' : 'Không';
		$sheet->setCellValue('A' . $rowIndex, $i);
		$sheet->setCellValue('B' . $rowIndex, $ten_nguoi_giao);
        $sheet->setCellValue('C' . $rowIndex, $ten_nguoi_nhan);
		$sheet->setCellValue('D' . $rowIndex, $ten_nguoi_giamsat);
		$sheet->setCellValue('E' . $rowIndex, $row['ten_congviec']);
		$sheet->setCellValue('F' . $rowIndex, $row['mo_ta_congviec']);
		$sheet->setCellValue('G' . $rowIndex, $mucdo_uutien_text);
		$sheet->setCellValue('H' . $rowIndex, $ngay_tao);
		$sheet->setCellValue('I' . $rowIndex, $han_hoanthanh);
		$sheet->setCellValue('J' . $rowIndex, $trang_thai_text);
		$sheet->setCellValue('K' . $rowIndex, $miss_deadline);
        $rowIndex++;
    }

    $lastRow = $rowIndex - 1;

    // zebra
    for ($r = $startRow + 1; $r <= $lastRow; $r++) {
        if ($r % 2 == 0) {
            $sheet->getStyle("A{$r}:K{$r}")->applyFromArray([
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'F2F6FC']
                ]
            ]);
        }
    }

    // border
    $sheet->getStyle("A{$startRow}:K{$lastRow}")->applyFromArray([
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ]);

    foreach(range('A','K') as $c){
        $sheet->getColumnDimension($c)->setAutoSize(true);
    }

    $sheet->freezePane('A15');

    $fileName = 'export_giaoviec_' . date('Ymd_His') . '.xlsx';
    $filePath = '../uploads/excel/' . $fileName;

    if (!is_dir('../uploads/excel/')) {
        mkdir('../uploads/excel/', 0777, true);
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($filePath);

    $output = trim(ob_get_clean());

    if (!empty($output)) {
        echo json_encode([
            "error" => "Có lỗi hệ thống",
            "debug" => $output
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "filePath" => $filePath
    ]);

    mysqli_close($conn);
}else if (isset($_POST['action']) && $_POST['action'] == 'submit_export_du_an') {

    ob_start();

    $nguoi_dung = intval($_POST['nguoi_dung']);
    $admin_cty = $user_info['admin_cty'];

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $sheet = $objPHPExcel->getActiveSheet();

	$sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

	

    $thongtin_congviec_tao = mysqli_query($conn,"SELECT COUNT(*) as tong_tao 
        FROM congviec_du_an 
        WHERE id_nguoi_giao = '$nguoi_dung' 
        AND admin_cty = '$admin_cty'");
    $tt_congviec_tao = mysqli_fetch_assoc($thongtin_congviec_tao);

    $sql_tk = "SELECT 
        COUNT(*) as tong,
        COALESCE(SUM(CASE WHEN trang_thai = '6' THEN 1 ELSE 0 END),0) as hoan_thanh,
        COALESCE(SUM(CASE WHEN trang_thai = '1' THEN 1 ELSE 0 END),0) as dang_lam,
        COALESCE(SUM(CASE WHEN miss_deadline = '1' THEN 1 ELSE 0 END),0) as qua_han,
        COALESCE(SUM(CASE WHEN trang_thai = '4' THEN 1 ELSE 0 END),0) as tuchoi,
        COALESCE(SUM(CASE WHEN trang_thai = '5' THEN 1 ELSE 0 END),0) as xin_giahan,
        COALESCE(SUM(CASE WHEN trang_thai = '0' THEN 1 ELSE 0 END),0) as cho_xuly,
        COALESCE(SUM(CASE WHEN trang_thai = '2' THEN 1 ELSE 0 END),0) as cho_duyet
    FROM congviec_du_an
    WHERE id_nguoi_nhan = '$nguoi_dung' 
    AND admin_cty = '$admin_cty'";

    $result_congviec_nhan = mysqli_query($conn, $sql_tk);
    $tt_congviec_nhan = mysqli_fetch_assoc($result_congviec_nhan); 

    $nguoi_dung_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$nguoi_dung'");
    $nguoi_dung_info = mysqli_fetch_assoc($nguoi_dung_info);

    $ten_nguoi_dung = $nguoi_dung_info['name'] ?? '';
    $phong_ban_id = $nguoi_dung_info['phong_ban'] ?? '';

    $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id = '$phong_ban_id'");
    $phong_ban = mysqli_fetch_assoc($thongtin_phongban);

    $ten_phong_ban = $phong_ban['tieu_de'] ?? '';
	$tyle_ht_congviec = ($tt_congviec_nhan['tong'] > 0) ? round($tt_congviec_nhan['hoan_thanh'] / $tt_congviec_nhan['tong'] * 100, 2) : 0;
	$tyle_qh_congviec = ($tt_congviec_nhan['tong'] > 0) ? max(0, round($tt_congviec_nhan['qua_han'] / $tt_congviec_nhan['tong'] * 100, 2)) : 0;
	$tyle_dung_han_congviec = ($tt_congviec_nhan['tong'] > 0) ? max(0, round(($tt_congviec_nhan['hoan_thanh'] - $tt_congviec_nhan['qua_han']) / $tt_congviec_nhan['tong'] * 100, 2)) : 0;

	$thongtin_du_an_tao = mysqli_query($conn,"SELECT COUNT(*) as tong_tao 
        FROM du_an 
        WHERE user_id = '$nguoi_dung' 
        AND admin_cty = '$admin_cty'");
    $tt_du_an_tao = mysqli_fetch_assoc($thongtin_du_an_tao);

	$thongtin_du_an_tk = mysqli_query($conn, "SELECT 
        COUNT(*) as tong,
        COALESCE(SUM(CASE WHEN trang_thai = '6' THEN 1 ELSE 0 END),0) as hoan_thanh,
        COALESCE(SUM(CASE WHEN trang_thai = '1' THEN 1 ELSE 0 END),0) as dang_lam,
        COALESCE(SUM(CASE WHEN miss_deadline = '1' THEN 1 ELSE 0 END),0) as qua_han,
        COALESCE(SUM(CASE WHEN trang_thai = '4' THEN 1 ELSE 0 END),0) as tuchoi,
        COALESCE(SUM(CASE WHEN trang_thai = '5' THEN 1 ELSE 0 END),0) as xin_giahan,
        COALESCE(SUM(CASE WHEN trang_thai = '0' THEN 1 ELSE 0 END),0) as cho_xuly,
        COALESCE(SUM(CASE WHEN trang_thai = '2' THEN 1 ELSE 0 END),0) as cho_duyet
    FROM du_an
    WHERE user_id = '$nguoi_dung' 
    AND admin_cty = '$admin_cty'");
    $tt_du_an_tk = mysqli_fetch_assoc($thongtin_du_an_tk);

	$tyle_ht_du_an = ($tt_du_an_tk['tong'] > 0) ? round($tt_du_an_tk['hoan_thanh'] / $tt_du_an_tk['tong'] * 100, 2) : 0;

    $tyle_qh_du_an = ($tt_du_an_tk['tong'] > 0) ? max(0, round($tt_du_an_tk['qua_han'] / $tt_du_an_tk['tong'] * 100, 2)) : 0;
    $tyle_dung_han_du_an = ($tt_du_an_tk['tong'] > 0) ? max(0, round(($tt_du_an_tk['hoan_thanh'] - $tt_du_an_tk['qua_han']) / $tt_du_an_tk['tong'] * 100, 2)) : 0;

	$sheet->setCellValue('A1', 'THỐNG KÊ TỔNG QUAN');
	$sheet->mergeCells('A1:F1');

	$sheet->getStyle('A1:D1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'D9E1F2']]
    ]);


	$sheet->setCellValue('A3', 'Tổng quan');
	$sheet->mergeCells('A3:B3');

	$sheet->setCellValue('C3', 'Dự án');
	$sheet->mergeCells('C3:D3');

	$sheet->setCellValue('E3', 'Công việc dự án');
	$sheet->mergeCells('E3:F3');

	$sheet->setCellValue('A4', 'Người nhận');
	$sheet->setCellValue('B4', $ten_nguoi_dung);

	$sheet->setCellValue('A5', 'Phòng ban');
	$sheet->setCellValue('B5', $ten_phong_ban);

	$sheet->setCellValue('C4', 'Dự án đã tạo');
	$sheet->setCellValue('D4', $tt_du_an_tao['tong_tao']);

	$sheet->setCellValue('C5', 'Tỷ lệ hoàn thành');
	$sheet->setCellValue('D5', $tyle_ht_du_an . '%');

	$sheet->setCellValue('C6', 'Tỷ lệ đúng hạn');
	$sheet->setCellValue('D6', $tyle_dung_han_du_an . '%');

	$sheet->setCellValue('C7', 'Tỷ lệ quá hạn');
	$sheet->setCellValue('D7', $tyle_qh_du_an . '%');

	$sheet->setCellValue('C8', 'Hoàn thành');
	$sheet->setCellValue('D8', $tt_congviec_nhan['hoan_thanh']);

	$sheet->setCellValue('C9', 'Đang làm');
	$sheet->setCellValue('D9', $tt_congviec_nhan['dang_lam']);

	$sheet->setCellValue('C10', 'Quá hạn');
	$sheet->setCellValue('D10', $tt_congviec_nhan['qua_han']);

	$sheet->setCellValue('C11', 'Từ chối');
	$sheet->setCellValue('D11', $tt_congviec_nhan['tuchoi']);

	$sheet->setCellValue('C12', 'Gia hạn');
	$sheet->setCellValue('D12', $tt_congviec_nhan['xin_giahan']);

	$sheet->setCellValue('E4', 'Dự án đã tạo');
	$sheet->setCellValue('F4', $tt_congviec_tao['tong_tao']);

	$sheet->setCellValue('E5', 'Tỷ lệ hoàn thành');
	$sheet->setCellValue('F5', $tyle_ht_congviec . '%');

	$sheet->setCellValue('E6', 'Tỷ lệ đúng hạn');
	$sheet->setCellValue('F6', $tyle_dung_han_congviec . '%');

	$sheet->setCellValue('E7', 'Tỷ lệ quá hạn');
	$sheet->setCellValue('F7', $tyle_qh_congviec . '%');

	$sheet->setCellValue('E8', 'Hoàn thành');
	$sheet->setCellValue('F8', $tt_congviec_nhan['hoan_thanh']);

	$sheet->setCellValue('E9', 'Đang làm');
	$sheet->setCellValue('F9', $tt_congviec_nhan['dang_lam']);

	$sheet->setCellValue('E10', 'Quá hạn');
	$sheet->setCellValue('F10', $tt_congviec_nhan['qua_han']);

	$sheet->setCellValue('E11', 'Từ chối');
	$sheet->setCellValue('F11', $tt_congviec_nhan['tuchoi']);

	$sheet->setCellValue('E12', 'Gia hạn');
	$sheet->setCellValue('F12', $tt_congviec_nhan['xin_giahan']);

	$sheet->getStyle('A3:F3')->getFont()->setBold(true);

	$sheet->getStyle('A4:A12')->getFont()->setBold(true);
	$sheet->getStyle('C4:C12')->getFont()->setBold(true);
	$sheet->getStyle('E4:E12')->getFont()->setBold(true);

	$sheet->getStyle('B4:B12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('D4:D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('F4:F12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$sheet->getStyle('A3:F12')->applyFromArray([
		'borders' => [
			'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
		]
	]);

	// autosize
	foreach(range('A','F') as $col){
		$sheet->getColumnDimension($col)->setAutoSize(true);
	}

    $sheet->setCellValue('A16', 'THỐNG KÊ DỰ ÁN');
    $sheet->mergeCells('A16:H16');

	$sheet->getStyle('A16:H16')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'D9E1F2']]
    ]);

    $startRow = 18;

    $headers = ['STT','Tên dự án', 'Mô tả','Ghi chú', 'Mức độ ưu tiên', 'Ngày tạo', 'Trạng thái', 'Miss Deadline'];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . $startRow, $header);
        $col++;
    }

	$sheet->getStyle("A{$startRow}:H{$startRow}")->applyFromArray([
        'font' => ['bold' => true,'color' => ['rgb' => 'FFFFFF']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => '5B9BD5']]
    ]);
  
    $sql = "SELECT *
            FROM du_an 
            WHERE user_id = '$nguoi_dung' 
            AND admin_cty = '$admin_cty' 
            ORDER BY id DESC";

    $result = mysqli_query($conn, $sql);

    $rowIndex = $startRow + 1;
	$i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
		$i++;
		if($row['mucdo_uutien'] == 'thap'){
			$mucdo_uutien_text = 'Thấp';
		}else if($row['mucdo_uutien'] == 'binh_thuong'){
			$mucdo_uutien_text = 'Bình thường';
		}else if($row['mucdo_uutien'] == 'cao'){
			$mucdo_uutien_text = 'Cao';
		}else if($row['mucdo_uutien'] == 'rat_cao'){
			$mucdo_uutien_text = 'Khẩn cấp';
		} else {
			$mucdo_uutien_text = $row['mucdo_uutien'];
		}
		switch ($row['trang_thai']) {
			case 0:
				$trang_thai_text = 'Chờ xử lý';
				break;
			case 1:
				$trang_thai_text = 'Đang triển khai';
				break;
			case 2:
				$trang_thai_text = 'Chờ phê duyệt';
				break;
			case 4:
				$trang_thai_text = 'Từ chối';
				break;
			case 5:
				$trang_thai_text = 'Xin gia hạn';
				break;
			case 6:
				$trang_thai_text = 'Đã hoàn thành';
				break;
			default:
				$trang_thai_text = 'Không xác định';
				break;
		}
		$ngay_tao = date('d/m/Y',($row['date_post']));
		$miss_deadline = $row['miss_deadline'] == 1 ? 'Có' : 'Không';
		$sheet->setCellValue('A' . $rowIndex, $i);
		$sheet->setCellValue('B' . $rowIndex, $row['ten_du_an']);
        $sheet->setCellValue('C' . $rowIndex, $row['mo_ta']);
		$sheet->setCellValue('D' . $rowIndex, $row['ghi_chu']);
		$sheet->setCellValue('E' . $rowIndex, $mucdo_uutien_text);
		$sheet->setCellValue('F' . $rowIndex, $ngay_tao);
		$sheet->setCellValue('G' . $rowIndex, $trang_thai_text);
		$sheet->setCellValue('H' . $rowIndex, $miss_deadline);
        $rowIndex++;
    }
	$lastRowDuAn = $rowIndex - 1;

	// border
	$sheet->getStyle("A{$startRow}:H{$lastRowDuAn}")->applyFromArray([
		'borders' => [
			'allborders' => [
				'style' => PHPExcel_Style_Border::BORDER_THIN
			]
		]
	]);
	
	// zebra (nếu muốn đồng bộ với bảng dưới)
	for ($r = $startRow + 1; $r <= $lastRowDuAn; $r++) {
		if ($r % 2 == 0) {
			$sheet->getStyle("A{$r}:H{$r}")->applyFromArray([
				'fill' => [
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => ['rgb' => 'F2F6FC']
				]
			]);
		}
	}
	$row_congviec_duan = $rowIndex +1;
	$sheet->setCellValue('A' . $row_congviec_duan, 'THỐNG KÊ CÔNG VIỆC DỰ ÁN');
    $sheet->mergeCells('A' . $row_congviec_duan . ':K' . $row_congviec_duan);

	$sheet->getStyle('A' . $row_congviec_duan . ':K' . $row_congviec_duan)->applyFromArray([
        'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F4E78']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => 'D9E1F2']]
    ]);

    $startRow = $row_congviec_duan + 2;

    $headers = ['STT','Người giao', 'Người nhận','Dự án','Tên công việc', 'Mô tả', 'Mức độ ưu tiên', 'Ngày tạo', 'Hạn hoàn thành', 'Trạng thái', 'Miss Deadline'];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . $startRow, $header);
        $col++;
    }

	$sheet->getStyle("A{$startRow}:K{$startRow}")->applyFromArray([
        'font' => ['bold' => true,'color' => ['rgb' => 'FFFFFF']],
        'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
        'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => ['rgb' => '5B9BD5']]
    ]);
  
    $sql = "SELECT congviec_du_an.*, du_an.ten_du_an 
            FROM congviec_du_an 
			JOIN  du_an ON congviec_du_an.id_du_an = du_an.id	
            WHERE id_nguoi_nhan = '$nguoi_dung' 
            AND congviec_du_an.admin_cty = '$admin_cty' 
            ORDER BY congviec_du_an.id DESC";

    $result = mysqli_query($conn, $sql);

    $rowIndex = $startRow + 1;
	$i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
		$i++;
		$nguoi_giao_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '{$row['id_nguoi_giao']}'");
		$nguoi_giao_info = mysqli_fetch_assoc($nguoi_giao_info);
		$ten_nguoi_giao = $nguoi_giao_info['name'] ?? '';
		$nguoi_nhan_info = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '{$row['id_nguoi_nhan']}'");
		$nguoi_nhan_info = mysqli_fetch_assoc($nguoi_nhan_info);
		$ten_nguoi_nhan = $nguoi_nhan_info['name'] ?? '';
		if($row['mucdo_uutien'] == 'thap'){
			$mucdo_uutien_text = 'Thấp';
		}else if($row['mucdo_uutien'] == 'binh_thuong'){
			$mucdo_uutien_text = 'Bình thường';
		}else if($row['mucdo_uutien'] == 'cao'){
			$mucdo_uutien_text = 'Cao';
		}else if($row['mucdo_uutien'] == 'rat_cao'){
			$mucdo_uutien_text = 'Khẩn cấp';
		} else {
			$mucdo_uutien_text = $row['mucdo_uutien'];
		}
		switch ($row['trang_thai']) {
			case 0:
				$trang_thai_text = 'Chờ xử lý';
				break;
			case 1:
				$trang_thai_text = 'Đang triển khai';
				break;
			case 2:
				$trang_thai_text = 'Chờ phê duyệt';
				break;
			case 4:
				$trang_thai_text = 'Từ chối';
				break;
			case 5:
				$trang_thai_text = 'Xin gia hạn';
				break;
			case 6:
				$trang_thai_text = 'Đã hoàn thành';
				break;
			default:
				$trang_thai_text = 'Không xác định';
				break;
		}
		$ngay_tao = date('d/m/Y',($row['date_post']));
		$han_hoanthanh = date('d/m/Y H:i', strtotime($row['han_hoanthanh']));
		$miss_deadline = $row['miss_deadline'] == 1 ? 'Có' : 'Không';
		$sheet->setCellValue('A' . $rowIndex, $i);
		$sheet->setCellValue('B' . $rowIndex, $ten_nguoi_giao);
        $sheet->setCellValue('C' . $rowIndex, $ten_nguoi_nhan);
		$sheet->setCellValue('D' . $rowIndex, $row['ten_du_an']);
		$sheet->setCellValue('E' . $rowIndex, $row['ten_congviec']);
		$sheet->setCellValue('F' . $rowIndex, $row['mo_ta_congviec']);
		$sheet->setCellValue('G' . $rowIndex, $mucdo_uutien_text);
		$sheet->setCellValue('H' . $rowIndex, $ngay_tao);
		$sheet->setCellValue('I' . $rowIndex, $han_hoanthanh);
		$sheet->setCellValue('J' . $rowIndex, $trang_thai_text);
		$sheet->setCellValue('K' . $rowIndex, $miss_deadline);
        $rowIndex++;
    }

    $lastRow = $rowIndex - 1;
	
    // zebra
    for ($r = $startRow + 1; $r <= $lastRow; $r++) {
        if ($r % 2 == 0) {
            $sheet->getStyle("A{$r}:K{$r}")->applyFromArray([
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'F2F6FC']
                ]
            ]);
        }
    }

    // border
    $sheet->getStyle("A{$startRow}:K{$lastRow}")->applyFromArray([
        'borders' => [
            'allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
        ]
    ]);

    foreach(range('A','K') as $c){
        $sheet->getColumnDimension($c)->setAutoSize(true);
    }

    $sheet->freezePane('A15');

    $fileName = 'export_du_an_' . date('Ymd_His') . '.xlsx';
    $filePath = '../uploads/excel/' . $fileName;

    if (!is_dir('../uploads/excel/')) {
        mkdir('../uploads/excel/', 0777, true);
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save($filePath);

    $output = trim(ob_get_clean());

    if (!empty($output)) {
        echo json_encode([
            "error" => "Có lỗi hệ thống",
            "debug" => $output
        ]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "filePath" => $filePath
    ]);

    mysqli_close($conn);
}else if($action=='load_list_user'){
	$phongban = intval($_REQUEST['phongban']);
	$admin_cty = $user_info['admin_cty'];
	$list_user = $class_giaoviec->list_user($conn, $phongban, $admin_cty, 1, 10);
	$list = '
			<thead>
              <tr>
                <th>STT</th>
                <th>NHÂN VIÊN</th>
                <th>SỐ ĐIỆN THOẠI</th>
                <th>EMAIL</th>
                <th>HẠN HỢP ĐỒNG</th>
                <th>HÀNH ĐỘNG</th>
              </tr>
            </thead>
            <tbody>
              '.$list_user.'
            </tbody>
	';
	$info=array(
		'list'=>$list,
		'ok'=>1
	);
	echo json_encode($info);
} else {
	echo "Không có hành động nào được xử lý";
}

?>