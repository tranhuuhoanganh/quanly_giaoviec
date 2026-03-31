<?php
include '../includes/tlca_world.php';
include_once "../class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_thanhvien');
$class_viettel = $tlca_do->load('class_viettel');
$class_ninja_van = $tlca_do->load('class_ninja_van');
$skin = $tlca_do->load('class_skin_cpanel');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if(isset($_COOKIE['user_id'])){
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	$user_id=$user_info['user_id'];
	$thongtin_kichhoat=mysqli_query($conn,"SELECT * FROM kich_hoat WHERE user_id='$user_id'");
	$total_kichhoat=mysqli_num_rows($thongtin_kichhoat);
	if($total_kichhoat==0){
		$sudung_expired=($user_info['created'] + $index_setting['ngay_dungthu']*3600*24) - time();
	}else{
		$r_sudung=mysqli_fetch_assoc($thongtin_kichhoat);
		$sudung_expired=$r_sudung['date_end'] - time();
	}
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

}else if ($action == 'load_box_pop_thirth') {
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
}else if($action=='load_booking_goiy'){
	$page=intval($_REQUEST['page']);
	$limit=100;
	$tach_list=json_decode($class_index->list_hang_goiy($conn,$user_id, $page, $limit),true);
	if($tach_list['total']==0){
		$ok=0;
		$thongbao='Không có kết quả phù hợp';
		$list='';
	}else{
		$ok=1;
		$thongbao='Tìm booking thành công';
		$list='<tr>
                <th class="sticky-row" width="50">STT</th>
                <th class="sticky-row" width="150">Hãng tàu</th>
                <th class="sticky-row" width="120">Loại container</th>
                <th class="sticky-row" width="120">Mặt hàng</th>
                <th class="sticky-row">Địa điểm đóng hàng</th>
                <th class="sticky-row">Địa điểm trả hàng</th>
                <th class="sticky-row" width="150">Thời gian trả hàng</th>
                <th class="sticky-row" width="150">Cước vận chuyển</th>
                <th class="sticky-row sticky-column" width="120">Hành động</th>
              </tr>'.$tach_list['list'];
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
		'total'=>$tach_list['total'],
		'thongbao'=>$thongbao
	);
	echo json_encode($info);

}else if($action=='load_list_yeucau'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$list_yeucau=$class_index->list_yeucau($conn,$user_info['id'],$user_info['bo_phan'],$r_tt['thanh_vien']);
	$info=array(
		'ok'=>1,
		'list'=>$list_yeucau,
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
		$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container  WHERE ma_booking='{$r_tt['ma_booking']}' AND id!='$id' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai' ORDER BY date_time ASC");
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
				$r_cont['ten_cang']=$r_booking['ten_cang'];
				$r_cont['diachi_donghang']=$r_booking['diachi_donghang'];
				$r_cont['diachi_trahang']=$r_booking['diachi_trahang'];
				$r_cont['so_booking']=$r_booking['so_booking'];
				if($r_cont['loai_hinh']=='hangnhap'){
					$list.=$skin->skin_replace('skin_members/box_action/tr_hangnhap_more', $r_cont);
				}else{
					$list.=$skin->skin_replace('skin_members/box_action/tr_hangxuat_more', $r_cont);
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
}else if($action=='get_huyen'){
	$tinh=intval($_REQUEST['tinh']);
	$list='<option value="">Chọn quận/huyện</option>'.$class_index->list_option_huyen($conn, $tinh, '');
	$info=array(
		'ok'=>1,
		'list'=>$list
	);
	echo json_encode($info);
}else if($action=='get_xa'){
	$huyen=intval($_REQUEST['huyen']);
	$list='<option value="">Chọn xã/thị trấn</option>'.$class_index->list_option_xa($conn, $huyen, '');
	$info=array(
		'ok'=>1,
		'list'=>$list
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
			$list.='<div class="li_goiy goiy_tinh" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
	);
	echo json_encode($info);
}else if($action=='goiy_hangtau'){
	$text=addslashes(strip_tags($_REQUEST['text']));
	$thongtin=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE tieu_de LIKE '%$text%' OR viet_tat LIKE '%$text%' ORDER BY tieu_de ASC LIMIT 10");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$list='';
	}else{
		$ok=1;
		while($r_tt=mysqli_fetch_assoc($thongtin)){
			$list.='<div class="li_goiy goiy_hangtau" viet_tat="'.$r_tt['viet_tat'].'" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'('.$r_tt['viet_tat'].')</div>';
		}
	}
	$info=array(
		'ok'=>$ok,
		'list'=>$list,
	);
	echo json_encode($info);
}else if($action=='load_tk_notification'){
	$thongtin=mysqli_query($conn,"SELECT * FROM notification WHERE user_nhan='$user_id' AND FIND_IN_SET($user_id,doc)<1");
	$total=mysqli_num_rows($thongtin);
	if($total>9){
		$total='9+';
	}else{
		$total=$total;
	}
	$thongtin_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE user_id='$user_id' AND (status='0' OR status='2' OR status='3')");
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
	$thongtin_dat_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE user_dat='$user_id' AND (status='0' OR status='2' OR status='3')");
	$total_dat_booking_wait=0;
	$total_dat_booking_confirm=0;
	$total_dat_booking_false=0;
	while($r_dat_bk=mysqli_fetch_assoc($thongtin_dat_booking)){
		if($r_dat_bk['status']==0){
			$total_dat_booking_wait++;
		}else if($r_dat_bk['status']==2){
			$total_dat_booking_confirm++;
		}else if($r_dat_bk['status']==3){
			$total_dat_booking_false++;
		}
	}
	if($total_dat_booking_wait>9){
		$total_dat_booking_wait='9+';
	}else{
		$total_dat_booking_wait=$total_dat_booking_wait;
	}
	if($total_dat_booking_confirm>9){
		$total_dat_booking_confirm='9+';
	}else{
		$total_dat_booking_confirm=$total_dat_booking_confirm;
	}
	if($total_dat_booking_false>9){
		$total_dat_booking_false='9+';
	}else{
		$total_dat_booking_false=$total_dat_booking_false;
	}
	$info=array(
		'ok'=>1,
		'total'=>$total,
		'total_booking_wait'=>$total_booking_wait,
		'total_booking_confirm'=>$total_booking_confirm,
		'total_booking_false'=>$total_booking_false,
		'total_dat_booking_false'=>$total_dat_booking_false,
		'total_dat_booking_confirm'=>$total_dat_booking_confirm,
		'total_dat_booking_wait'=>$total_dat_booking_wait,
	);
	echo json_encode($info);
}else if($action=='load_notification'){
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}
	$loai=addslashes($_REQUEST['loai']);
	$limit=10;
	$tach_list=json_decode($class_index->list_notification($conn,$user_id,$loai,$page,$limit),true);
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
}else if($action=='load_show_box'){
	$id=intval($_REQUEST['id_booking']);
	$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id' AND user_dat='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_booking['mat_hang']=='khac'){
			$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
		}
		$r_booking['gia_booking']=number_format($r_booking['gia']);
		$r_booking['phi_booking']=number_format($r_tt['phi_booking']);
		$r_booking['gia']=number_format($r_tt['gia']);
		$r_booking['thoi_gian']=$r_tt['thoi_gian'];
		$r_booking['ngay']=$r_tt['ngay'];
		$r_booking['status']='Đã chấp nhận';
		$r_booking['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
		$r_booking['id_booking']=$id;
		if($user_id==$r_tt['user_dat']){
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_dat']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
		}
		$r_booking['cong_ty']=$r_tv['cong_ty'];
		$r_booking['name']=$r_tv['name'];
		$r_booking['mobile']=$r_tv['mobile'];
		$r_booking['user_id']=$r_tv['user_id'];
		if($r_booking['loai_hinh']=='hangnhap'){
			$r_booking['diachi_donghang']=$r_booking['ten_cang'];
			$box=$skin->skin_replace('skin_members/box_action/box_pop_hangnhap', $r_booking);
		}else{
			$r_booking['diachi_trahang']=$r_booking['ten_cang'];
			$box=$skin->skin_replace('skin_members/box_action/box_pop_hangxuat', $r_booking);
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'box'=>$box,
	);
	echo json_encode($info);
}else if($action=='xacnhan_booking'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb LEFT JOIN list_container lc ON lb.id_container=lc.id WHERE lb.id='$id' AND lb.user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_tt['status']==0){
			$phi_booking=$index_setting['phi_booking'];
			$dau=$user_info['user_money'] + $user_info['user_money2'];
			if($dau<$phi_booking){
				$ok=0;
				$thongbao='Thất bại! Số dư tài khoản không đủ '.number_format($phi_booking).' đ';
			}else{
				$ok=1;
				$thongbao='Xác nhận booking thành công';
				if($user_info['user_money']>=$phi_booking){
					$cuoi=$dau - $phi_booking;
					$conlai=$user_info['user_money'] - $phi_booking;
					mysqli_query($conn,"UPDATE user_info SET user_money='$conlai' WHERE user_id='$user_id'");
					$noidung='Trừ phí xác nhận booking '.number_format($phi_booking);
					mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$phi_booking','$dau','$cuoi','$noidung','$hientai')");
				}else{
					$conlai=$user_info['user_money2'] - ($phi_booking - $user_info['user_money']);
					$cuoi=$dau - $phi_booking;
					mysqli_query($conn,"UPDATE user_info SET user_money='0',user_money2='$conlai' WHERE user_id='$user_id'");
					$noidung='Trừ phí xác nhận booking '.number_format($phi_booking);
					mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$phi_booking','$dau','$cuoi','$noidung','$hientai')");
				}
				$noidung_noti='Đơn đặt booking #'.strtoupper($r_booking['so_booking']).', số hiệu container #'.strtoupper($r_tt['so_hieu']).' của bạn đã được chấp nhận';
				mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_dat']}','$noidung_noti','','$id','0','$hientai')");
				mysqli_query($conn,"UPDATE list_booking SET status='2',update_post='$hientai' WHERE id='$id'");
				mysqli_query($conn,"UPDATE list_container SET status='2' WHERE id='{$r_tt['id_container']}'");
				$thongtin_booking_conlai=mysqli_query($conn,"SELECT * FROM list_booking WHERE id_container='{$r_tt['id_container']}' AND status='0'");
				while($r_bc=mysqli_fetch_assoc($thongtin_booking_conlai)){
					$noidung_noti='Đơn đặt booking #'.$r_booking['so_booking'].', số hiệu container #'.$r_tt['so_hieu'].' của bạn không được chấp nhận';
					mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_bc['user_dat']}','$noidung_noti','','{$r_bc['id']}','0','$hientai')");
					mysqli_query($conn,"UPDATE list_booking SET status='3',update_post='$hientai' WHERE id='{$r_bc['id']}'");
					$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_bc['user_dat']}'");
					$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
					$conlai_dau=$r_tv['user_money'] + $r_tv['user_money2'];
					$conlai_cuoi=$conlai_dau + $r_bc['phi_booking'];
					$conlai_moi=$r_tv['user_money'] + $r_bc['phi_booking'];
					mysqli_query($conn,"UPDATE user_info SET user_money='$conlai_moi' WHERE user_id='{$r_bc['user_dat']}'");
					$noidung='Hoàn lại phí booking '.number_format($r_bc['phi_booking']);
					mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_bc['user_dat']}','{$r_bc['phi_booking']}','$conlai_dau','$conlai_cuoi','$noidung','$hientai')");

				}
				if($r_booking['mat_hang']=='khac'){
					$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
				}
				$r_booking['gia_booking']=number_format($r_booking['gia']);
				$r_booking['phi_booking']=number_format($r_tt['phi_booking']);
				$r_booking['gia']=number_format($r_tt['gia']);
				$r_booking['thoi_gian']=$r_tt['thoi_gian'];
				$r_booking['ngay']=$r_tt['ngay'];
				$r_booking['status']='Đã chấp nhận';
				$r_booking['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
				$r_booking['id_booking']=$id;
				if($user_id==$r_tt['user_dat']){
					$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
					$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
				}else{
					$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_dat']}'");
					$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
				}
				$r_booking['cong_ty']=$r_tv['cong_ty'];
				$r_booking['name']=$r_tv['name'];
				$r_booking['mobile']=$r_tv['mobile'];
				$r_booking['user_id']=$r_tv['user_id'];
				if($r_booking['loai_hinh']=='hangnhap'){
					$r_booking['diachi_donghang']=$r_booking['ten_cang'];
					$box=$skin->skin_replace('skin_members/box_action/box_pop_hangnhap', $r_booking);
				}else{
					$r_booking['diachi_trahang']=$r_booking['ten_cang'];
					$box=$skin->skin_replace('skin_members/box_action/box_pop_hangxuat', $r_booking);
				}
				
			}
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể cập nhật trạng thái booking này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'box'=>$box,
		'id_booking'=>$id,
		'user_id'=>$r_tt['user_dat']
	);
	echo json_encode($info);
}else if($action=='hoanthanh_booking'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb LEFT JOIN list_container lc ON lb.id_container=lc.id WHERE lb.id='$id' AND lb.user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_tt['status']==2){
			$ok=1;
			$thongbao='Xác nhận hoàn thành booking thành công';
			$noidung_noti='Đơn đặt booking #'.strtoupper($r_booking['so_booking']).', số hiệu container #'.strtoupper($r_tt['so_hieu']).' của bạn đã được xác nhận hoàn thành';
			mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_dat']}','$noidung_noti','','$id','0','$hientai')");
			mysqli_query($conn,"UPDATE list_booking SET status='1',update_post='$hientai' WHERE id='$id'");
			mysqli_query($conn,"UPDATE list_container SET status='1' WHERE id='{$r_tt['id_container']}'");
			$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container WHERE id='{$r_tt['id_container']}'");
			$r_cont=mysqli_fetch_assoc($thongtin_container);
			$thongtin_hoanthanh=mysqli_query($conn,"SELECT * FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND (status='0' OR status='2')");
			$total_hoanthanh=mysqli_num_rows($thongtin_hoanthanh);
			if($total==0){
				mysqli_query($conn,"UPDATE booking SET status='1' WHERE ma_booking='{$r_cont['ma_booking']}'");
			}
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể cập nhật trạng thái booking này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'user_id'=>$r_tt['user_dat']
	);
	echo json_encode($info);
}else if($action=='tuchoi_booking'){
	$id=intval($_REQUEST['id']);
	//$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id' AND user_id='$user_id'");
	$thongtin=mysqli_query($conn,"SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb LEFT JOIN list_container lc ON lb.id_container=lc.id WHERE lb.id='$id' AND lb.user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_tt['status']==0){
			$ok=1;
			$thongbao='Từ chối booking thành công';
			$noidung_noti='Đơn đặt booking #'.strtoupper($r_booking['so_booking']).', số hiệu #'.strtoupper($r_tt['so_hieu']).' của bạn đã bị từ chối';
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_dat']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
			$dau=$r_tv['user_money'];
			$cuoi=$r_tv['user_money'] + $r_tt['phi_booking'];
			mysqli_query($conn,"UPDATE user_info SET user_money='$cuoi' WHERE user_id='{$r_tv['user_id']}'");
			$noidung='Hoàn phí booking '.number_format($r_tt['phi_booking']);
			mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tv['user_id']}','{$r_tt['phi_booking']}','$dau','$cuoi','$noidung','$hientai')");
			mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_dat']}','$noidung_noti','','$id','0','$hientai')");
			mysqli_query($conn,"UPDATE list_booking SET status='3',update_post='$hientai' WHERE id='$id'");
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể cập nhật trạng thái booking này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'user_id'=>$r_tt['user_dat']
	);
	echo json_encode($info);
}else if($action=='huy_booking'){
	$id=intval($_REQUEST['id']);
	//$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id' AND user_dat='$user_id'");
	$thongtin=mysqli_query($conn,"SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb LEFT JOIN list_container lc ON lb.id_container=lc.id WHERE lb.id='$id' AND lb.user_dat='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_tt['status']==0){
			$ok=1;
			$thongbao='Hủy booking thành công';
			$noidung_noti='Đơn đặt booking #'.strtoupper($r_booking['so_booking']).', số hiệu #'.strtoupper($r_tt['so_hieu']).' của bạn đã bị hủy';
			$dau=$user_info['user_money'];
			$cuoi=$user_info['user_money'] + $r_tt['phi_booking'];
			mysqli_query($conn,"UPDATE user_info SET user_money='$cuoi' WHERE user_id='$user_id'");
			$noidung='Hoàn phí booking '.number_format($r_tt['phi_booking']);
			mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','{$r_tt['phi_booking']}','$dau','$cuoi','$noidung','$hientai')");
			mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_id']}','$noidung_noti','','$id','0','$hientai')");
			mysqli_query($conn,"UPDATE list_booking SET status='4',update_post='$hientai' WHERE id='$id'");
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể hủy booking này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'user_id'=>$r_tt['user_dat']
	);
	echo json_encode($info);
}else if($action=='huy_naptien'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM naptien WHERE id='$id' AND user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['status']==0){
			$ok=1;
			$thongbao='Hủy giao dịch nạp tiền thành công';
			//mysqli_query($conn,"UPDATE naptien SET status='2',update_post='$hientai' WHERE id='$id'");
			mysqli_query($conn,"DELETE FROM naptien WHERE id='$id'");
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể hủy giao dịch này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'user_id'=>$user_id
	);
	echo json_encode($info);
}else if($action=='del_list_booking'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM booking WHERE id='$id' AND user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['status']==0){
			$ok=1;
			$thongbao='Xóa booking thành công';
			//mysqli_query($conn,"UPDATE naptien SET status='2',update_post='$hientai' WHERE id='$id'");
			mysqli_query($conn,"DELETE FROM booking WHERE id='$id'");
			mysqli_query($conn,"DELETE FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}'");
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể xóa booking dịch này';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'user_id'=>$user_id
	);
	echo json_encode($info);
}else if($action=='export_naptien'){
	$status=addslashes($_REQUEST['status']);
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	if(strpos($from, '/')!==false){
		$tach_from=explode('/', $from);
		$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
	}else{
		$time_from='';
	}
	if(strpos($to, '/')!==false){
		$tach_to=explode('/', $to);
		$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
	}else{
		$time_to='';
	}
	$dir = '../uploads/excel';

	$current_time = time();

	// Số giây trong một giờ
	$one_hour_ago = $current_time - 3600;

	// Lấy danh sách các tệp trong thư mục
	$files = scandir($dir);

	// Lặp qua danh sách các tệp
	foreach($files as $file) {
	    // Kiểm tra nếu là tệp và không phải là thư mục
	    if(is_file($dir.'/'.$file)) {
	        // Lấy thời gian tạo của tệp
	        $file_creation_time = filectime($dir.'/'.$file);
	        
	        // So sánh thời gian tạo với thời gian hiện tại trừ đi một giờ
	        if($file_creation_time < $one_hour_ago) {
	            // Xóa tệp nếu thỏa mãn điều kiện
	            unlink($dir.'/'.$file);
	        }
	    }
	}
	require_once '../PHPExcel/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'STT')
		->setCellValue('B1', 'Thời gian')
		->setCellValue('C1', 'Số tiền')
		->setCellValue('D1', 'Nội dung')
		->setCellValue('E1', 'Trạng thái');
	if($time_to!=''){
		$where_to="AND naptien.date_post<='$time_to'";
	}else{
		$where_to="";
	}
	if($time_from!=''){
		$where_from="AND naptien.date_post>='$time_from'";
	}else{
		$where_from="";
	}
	if($status=='all'){
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username FROM naptien INNER JOIN user_info ON naptien.user_id=user_info.user_id WHERE naptien.user_id='$user_id' $where_from $where_to ORDER BY naptien.id DESC");
	}else{
		$thongtin = mysqli_query($conn, "SELECT nt.*,u.username FROM naptien nt INNER JOIN user_info u ON nt.user_id=u.user_id WHERE nt.user_id='$user_id' AND nt.status='$status' $where_from $where_to ORDER BY nt.id DESC");
	}
	$i = 1;
	$k=0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$i++;
		$k++;
		$noi_dung='naptien '.$r_tt['username'].' '.$r_tt['id'];
		if($r_tt['status']==1){
			$trang_thai='Hoàn thành';
		}else if($r_tt['status']==2){
			$trang_thai='Đã hủy';
		}else if($r_tt['status']==3){
			$trang_thai='Chờ xác nhận';			
		}else{
			$trang_thai='Chờ xử lý';			
		}
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $k)
			->setCellValue('B' . $i, date('H:i:s d/m/Y',$r_tt['date_post']))
			->setCellValue('C' . $i, $r_tt['sotien'])
			->setCellValue('D' . $i, $noi_dung)
			->setCellValue('E' . $i, $trang_thai);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
	//ghi du lieu vao file,định dạng file excel 2007
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$full_path = '/uploads/excel/lichsu-naptien-'.time().'.xlsx';//duong dan file
	$objWriter->save('..'.$full_path);
	$info=array(
		'link'=>$full_path,
		'ok'=>1
	);
	echo json_encode($info);

}else if($action=='export_booking'){
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	if(strpos($from, '/')!==false){
		$tach_from=explode('/', $from);
		$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
	}else{
		$time_from='';
	}
	if(strpos($to, '/')!==false){
		$tach_to=explode('/', $to);
		$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
	}else{
		$time_to='';
	}
	$dir = '../uploads/excel';

	$current_time = time();

	// Số giây trong một giờ
	$one_hour_ago = $current_time - 3600;

	// Lấy danh sách các tệp trong thư mục
	$files = scandir($dir);

	// Lặp qua danh sách các tệp
	foreach($files as $file) {
	    // Kiểm tra nếu là tệp và không phải là thư mục
	    if(is_file($dir.'/'.$file)) {
	        // Lấy thời gian tạo của tệp
	        $file_creation_time = filectime($dir.'/'.$file);
	        
	        // So sánh thời gian tạo với thời gian hiện tại trừ đi một giờ
	        if($file_creation_time < $one_hour_ago) {
	            // Xóa tệp nếu thỏa mãn điều kiện
	            unlink($dir.'/'.$file);
	        }
	    }
	}
	require_once '../PHPExcel/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'STT')
		->setCellValue('B1', 'Số Booking')
		->setCellValue('C1', 'Hãng tàu')
		->setCellValue('D1', 'Số hiệu container')
		->setCellValue('E1', 'Loại hình')
		->setCellValue('F1', 'Mặt hàng')
		->setCellValue('G1', 'Địa điểm đóng/trả hàng')
		->setCellValue('H1', 'Thời gian đóng/trả hàng')
		->setCellValue('I1', 'Cước vận chuyển')
		->setCellValue('J1', 'Phí booking')
		->setCellValue('K1', 'Trạng thái');
	if($time_to!=''){
		$where_to="AND lb.date_post<='$time_to'";
	}else{
		$where_to="";
	}
	if($time_from!=''){
		$where_from="AND lb.date_post>='$time_from'";
	}else{
		$where_from="";
	}
	$thongtin = mysqli_query($conn, "SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb INNER JOIN list_container lc ON lb.id_container=lc.id WHERE lb.user_id='$user_id' AND lb.status='1' $where_from $where_to ORDER BY lb.id DESC");

	$i = 1;
	$k=0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {

		$i++;
		$k++;
		$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_booking['loai_hinh']=='hangnhap'){
			$loai_hinh='Hàng nhập';
			$dia_diem=$r_booking['diachi_trahang'].','.$r_booking['ten_xa'].','.$r_booking['ten_huyen'].','.$r_booking['ten_tinh'];
		}else{
			$loai_hinh='Hàng xuất';
			$dia_diem=$r_booking['diachi_donghang'].','.$r_booking['ten_xa'].','.$r_booking['ten_huyen'].','.$r_booking['ten_tinh'];
		}
		if($r_booking['mat_hang']=='khac'){
			$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
		}else{
			$r_tt['mat_hang']=$r_booking['mat_hang'];
		}
		$thoi_gian=$r_tt['thoi_gian'].' '.$r_tt['ngay'];
		$trang_thai='Hoàn thành';
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $k)
			->setCellValue('B' . $i, $r_booking['so_booking'])
			->setCellValue('C' . $i, $r_booking['ten_hangtau'])
			->setCellValue('D' . $i, $r_tt['so_hieu'])
			->setCellValue('E' . $i, $loai_hinh)
			->setCellValue('F' . $i, $r_tt['mat_hang'])
			->setCellValue('G' . $i, $dia_diem)
			->setCellValue('H' . $i, $thoi_gian)
			->setCellValue('I' . $i, $r_tt['gia'])
			->setCellValue('J' . $i, $r_tt['phi_booking'])
			->setCellValue('K' . $i, $trang_thai);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("40");
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
	//ghi du lieu vao file,định dạng file excel 2007
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$full_path = '/uploads/excel/lichsu-booking-'.time().'.xlsx';//duong dan file
	$objWriter->save('..'.$full_path);
	$info=array(
		'link'=>$full_path,
		'ok'=>1
	);
	echo json_encode($info);

}else if($action=='export_dat_booking'){
	$from=addslashes($_REQUEST['from']);
	$to=addslashes($_REQUEST['to']);
	if(strpos($from, '/')!==false){
		$tach_from=explode('/', $from);
		$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
	}else{
		$time_from='';
	}
	if(strpos($to, '/')!==false){
		$tach_to=explode('/', $to);
		$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
	}else{
		$time_to='';
	}
	$dir = '../uploads/excel';

	$current_time = time();

	// Số giây trong một giờ
	$one_hour_ago = $current_time - 3600;

	// Lấy danh sách các tệp trong thư mục
	$files = scandir($dir);

	// Lặp qua danh sách các tệp
	foreach($files as $file) {
	    // Kiểm tra nếu là tệp và không phải là thư mục
	    if(is_file($dir.'/'.$file)) {
	        // Lấy thời gian tạo của tệp
	        $file_creation_time = filectime($dir.'/'.$file);
	        
	        // So sánh thời gian tạo với thời gian hiện tại trừ đi một giờ
	        if($file_creation_time < $one_hour_ago) {
	            // Xóa tệp nếu thỏa mãn điều kiện
	            unlink($dir.'/'.$file);
	        }
	    }
	}
	require_once '../PHPExcel/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'STT')
		->setCellValue('B1', 'Số Booking')
		->setCellValue('C1', 'Hãng tàu')
		->setCellValue('D1', 'Số hiệu container')
		->setCellValue('E1', 'Loại hình')
		->setCellValue('F1', 'Mặt hàng')
		->setCellValue('G1', 'Địa điểm đóng/trả hàng')
		->setCellValue('H1', 'Thời gian đóng/trả hàng')
		->setCellValue('I1', 'Cước vận chuyển')
		->setCellValue('J1', 'Phí booking')
		->setCellValue('K1', 'Trạng thái');
	if($time_to!=''){
		$where_to="AND lb.date_post<='$time_to'";
	}else{
		$where_to="";
	}
	if($time_from!=''){
		$where_from="AND lb.date_post>='$time_from'";
	}else{
		$where_from="";
	}
	$thongtin = mysqli_query($conn, "SELECT lb.*,lc.ma_booking,lc.so_hieu FROM list_booking lb INNER JOIN list_container lc ON lb.id_container=lc.id WHERE lb.user_dat='$user_id' AND lb.status='1' $where_from $where_to ORDER BY lb.id DESC");

	$i = 1;
	$k=0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {

		$i++;
		$k++;
		$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_booking['loai_hinh']=='hangnhap'){
			$loai_hinh='Hàng nhập';
			$dia_diem=$r_booking['diachi_trahang'].','.$r_booking['ten_xa'].','.$r_booking['ten_huyen'].','.$r_booking['ten_tinh'];
		}else{
			$loai_hinh='Hàng xuất';
			$dia_diem=$r_booking['diachi_donghang'].','.$r_booking['ten_xa'].','.$r_booking['ten_huyen'].','.$r_booking['ten_tinh'];
		}
		if($r_booking['mat_hang']=='khac'){
			$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
		}else{
			$r_tt['mat_hang']=$r_booking['mat_hang'];
		}
		$thoi_gian=$r_tt['thoi_gian'].' '.$r_tt['ngay'];
		$trang_thai='Hoàn thành';
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $i, $k)
			->setCellValue('B' . $i, $r_booking['so_booking'])
			->setCellValue('C' . $i, $r_booking['ten_hangtau'])
			->setCellValue('D' . $i, $r_tt['so_hieu'])
			->setCellValue('E' . $i, $loai_hinh)
			->setCellValue('F' . $i, $r_tt['mat_hang'])
			->setCellValue('G' . $i, $dia_diem)
			->setCellValue('H' . $i, $thoi_gian)
			->setCellValue('I' . $i, $r_tt['gia'])
			->setCellValue('J' . $i, $r_tt['phi_booking'])
			->setCellValue('K' . $i, $trang_thai);
	}
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("40");
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
	//ghi du lieu vao file,định dạng file excel 2007
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$full_path = '/uploads/excel/lichsu-dat-booking-'.time().'.xlsx';//duong dan file
	$objWriter->save('..'.$full_path);
	$info=array(
		'link'=>$full_path,
		'ok'=>1
	);
	echo json_encode($info);

}else if($action=='add_hangxuat'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}/*else if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==false){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn file booking';
	}*/else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$ma_booking=$class_index->creat_random($conn,'ma_booking');
		$hientai=time();
		if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
			$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
		}else{
			$file_booking='';
		}
		mysqli_query($conn,"INSERT INTO booking(user_id,ma_booking,so_booking,file_booking,loai_hinh,hang_tau,loai_container,diachi_donghang,diachi_trahang,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,ten_hangtau,ten_loai_container,ten_cang,mat_hang,mat_hang_khac,so_luong,trong_luong,gia,ghi_chu,list_container,status,date_post)VALUES('$user_id','$ma_booking','$so_booking','$file_booking','hangxuat','$hang_tau','$loai_container','$diachi_donghang','$diachi_trahang','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$ten_hangtau','$ten_loai_container','$ten_cang','$mat_hang','$mat_hang_khac','$so_luong','$trong_luong','$gia','$ghi_chu','$list_container','0','$hientai')");
		$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
		foreach ($tach_list_container as $key => $value) {
			$ngay_trahang=addslashes($value['ngay_trahang']);
			$so_hieu=addslashes($value['so_hieu']);
			$thoi_gian=addslashes($value['thoi_gian']);
			$tach_ngay_trahang=explode('/', $ngay_trahang);
			$tach_thoigian=explode(':', $thoi_gian);
			$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
			mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangxuat','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
		}
		$ok=1;
		$thongbao='Thêm booking mới thành công';
		$thongtin_moi=mysqli_query($conn,"SELECT lc.*,b.loai_hinh,b.hang_tau,b.loai_container,b.tinh,b.huyen,b.xa FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.ma_booking='$ma_booking' ORDER BY lc.date_time ASC LIMIT 1");
		$r_moi=mysqli_fetch_assoc($thongtin_moi);
		$html=$skin->skin_replace('skin_members/box_action/add_hangnhap_step2',$r_moi);
		$tach_list=json_decode($class_index->list_hang_goiy($conn,$r_moi['id'],$r_moi['loai_hinh'],$r_moi['hang_tau'],$r_moi['loai_container'],$r_moi['tinh'],$r_moi['huyen'],$r_moi['xa'], $r_moi['date_time']),true);
		$total_goiy=$tach_list['total'];
		if($total_goiy==0){
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm trả hàng</th>
                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr><tr><td colspan="8">Chưa có booking phù hợp</td></tr>';
		}else{
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm trả hàng</th>
                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr>'.$tach_list['list'];
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list_hang_goiy'=>$list_hang_goiy,
		'total'=>$total_goiy,
		'html'=>$html
	);
	echo json_encode($info);
}else if($action=='add_hangnhap'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$list_hang_goiy='';
	$total_goiy=0;
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}/*else if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==false){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn file booking';
	}*/else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$ma_booking=$class_index->creat_random($conn,'ma_booking');
		$hientai=time();
		if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
			$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
		}else{
			$file_booking='';
		}
		mysqli_query($conn,"INSERT INTO booking(user_id,ma_booking,so_booking,file_booking,loai_hinh,hang_tau,loai_container,diachi_donghang,diachi_trahang,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,ten_cang,ten_hangtau,ten_loai_container,mat_hang,mat_hang_khac,so_luong,trong_luong,gia,ghi_chu,list_container,status,date_post)VALUES('$user_id','$ma_booking','$so_booking','$file_booking','hangnhap','$hang_tau','$loai_container','$diachi_donghang','$diachi_trahang','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$ten_cang','$ten_hangtau','$ten_loai_container','$mat_hang','$mat_hang_khac','$so_luong','$trong_luong','$gia','$ghi_chu','$list_container','0','$hientai')");
		$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
		foreach ($tach_list_container as $key => $value) {
			$ngay_trahang=addslashes($value['ngay_trahang']);
			$so_hieu=addslashes($value['so_hieu']);
			$thoi_gian=addslashes($value['thoi_gian']);
			$tach_ngay_trahang=explode('/', $ngay_trahang);
			$tach_thoigian=explode(':', $thoi_gian);
			$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
			mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangnhap','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
		}
		$ok=1;
		$thongbao='Thêm booking mới thành công';
		$thongtin_moi=mysqli_query($conn,"SELECT lc.*,b.loai_hinh,b.hang_tau,b.loai_container,b.tinh,b.huyen,b.xa FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.ma_booking='$ma_booking' ORDER BY lc.date_time ASC LIMIT 1");
		$r_moi=mysqli_fetch_assoc($thongtin_moi);
		$html=$skin->skin_replace('skin_members/box_action/add_hangnhap_step2',$r_moi);
		$tach_list=json_decode($class_index->list_hang_goiy($conn,$r_moi['id'],$r_moi['loai_hinh'],$r_moi['hang_tau'],$r_moi['loai_container'],$r_moi['tinh'],$r_moi['huyen'],$r_moi['xa'], $r_moi['date_time']),true);
		$total_goiy=$tach_list['total'];
		if($total_goiy==0){
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm đóng hàng</th>
                                <th class="sticky-row" width="150">Thời gian đóng hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr><tr><td colspan="8">Chưa có booking phù hợp</td></tr>';
		}else{
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
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
		'thongbao'=>$thongbao,
		'list_hang_goiy'=>$list_hang_goiy,
		'total'=>$total_goiy,
		'html'=>$html
	);
	echo json_encode($info);
}else if($action=='edit_hangxuat'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$id=intval($_REQUEST['id']);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM booking WHERE id='$id' AND user_id='$user_id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Thất bại! Bạn không có quyền sửa';
		}else{
			$hientai=time();
			$r_tt=mysqli_fetch_assoc($thongtin);
			if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
				$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
				@unlink('..'.$r_tt['file_booking']);
			}else{
				$file_booking=$r_tt['file_booking'];
			}
			mysqli_query($conn,"UPDATE booking SET file_booking='$file_booking',hang_tau='$hang_tau',loai_container='$loai_container',diachi_donghang='$diachi_donghang',diachi_trahang='$diachi_trahang',tinh='$tinh',huyen='$huyen',xa='$xa',ten_tinh='$ten_tinh',ten_huyen='$ten_huyen',ten_xa='$ten_xa',ten_cang='$ten_cang',ten_hangtau='$ten_hangtau',ten_loai_container='$ten_loai_container',mat_hang='$mat_hang',mat_hang_khac='$mat_hang_khac',so_luong='$so_luong',trong_luong='$trong_luong',gia='$gia',ghi_chu='$ghi_chu',list_container='$list_container' WHERE id='$id' AND user_id='$user_id'");
			$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
			foreach ($tach_list_container as $key => $value) {
				$id_container=$value['id'];
				$ngay_trahang=addslashes($value['ngay_trahang']);
				$so_hieu=addslashes($value['so_hieu']);
				$thoi_gian=addslashes($value['thoi_gian']);
				$tach_ngay_trahang=explode('/', $ngay_trahang);
				$tach_thoigian=explode(':', $thoi_gian);
				$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
				if($id_container>0){
					$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id_container' AND user_id='$user_id'");
					$total_container=mysqli_num_rows($thongtin_container);
					if($total_container==0){

					}else{
						$r_cont=mysqli_fetch_assoc($thongtin_container);
						if($r_cont['status']==0){
							mysqli_query($conn,"UPDATE list_container SET so_hieu='$so_hieu',ngay='$ngay_trahang',thoi_gian='$thoi_gian',date_time='$datetime' WHERE id='$id_container'");
						}else{

						}
					}
				}else{
					mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangxuat','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
				}
			}
			$ok=1;
			$thongbao='Lưu thay đổi thành công';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_hangnhap'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$id=intval($_REQUEST['id']);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM booking WHERE id='$id' AND user_id='$user_id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Thất bại! Bạn không có quyền sửa';
		}else{
			$hientai=time();
			$r_tt=mysqli_fetch_assoc($thongtin);
			if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
				$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
				@unlink('..'.$r_tt['file_booking']);
			}else{
				$file_booking=$r_tt['file_booking'];
			}
			mysqli_query($conn,"UPDATE booking SET file_booking='$file_booking',hang_tau='$hang_tau',loai_container='$loai_container',diachi_donghang='$diachi_donghang',diachi_trahang='$diachi_trahang',tinh='$tinh',huyen='$huyen',xa='$xa',ten_tinh='$ten_tinh',ten_huyen='$ten_huyen',ten_xa='$ten_xa',ten_cang='$ten_cang',ten_hangtau='$ten_hangtau',ten_loai_container='$ten_loai_container',mat_hang='$mat_hang',mat_hang_khac='$mat_hang_khac',so_luong='$so_luong',trong_luong='$trong_luong',gia='$gia',ghi_chu='$ghi_chu',list_container='$list_container' WHERE id='$id'");
			$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
			foreach ($tach_list_container as $key => $value) {
				$id_container=intval($value['id']);
				$ngay_trahang=addslashes($value['ngay_trahang']);
				$so_hieu=addslashes($value['so_hieu']);
				$thoi_gian=addslashes($value['thoi_gian']);
				$tach_ngay_trahang=explode('/', $ngay_trahang);
				$tach_thoigian=explode(':', $thoi_gian);
				$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
				if($id_container>0){
					$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id_container' AND user_id='$user_id'");
					$total_container=mysqli_num_rows($thongtin_container);
					if($total_container==0){

					}else{
						$r_cont=mysqli_fetch_assoc($thongtin_container);
						if($r_cont['status']==0){
							mysqli_query($conn,"UPDATE list_container SET so_hieu='$so_hieu',ngay='$ngay_trahang',thoi_gian='$thoi_gian',date_time='$datetime' WHERE id='$id_container'");
						}else{

						}
					}
				}else{
					mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangnhap','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
				}
			}
			$ok=1;
			$thongbao='Lưu thay đổi thành công';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='copy_hangxuat'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}/*else if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==false){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn file booking';
	}*/else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$ma_booking=$class_index->creat_random($conn,'ma_booking');
		$hientai=time();
		if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
			$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
		}else{
			$file_booking='';
		}
		mysqli_query($conn,"INSERT INTO booking(user_id,ma_booking,so_booking,file_booking,loai_hinh,hang_tau,loai_container,diachi_donghang,diachi_trahang,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,ten_cang,ten_hangtau,ten_loai_container,mat_hang,mat_hang_khac,so_luong,trong_luong,gia,ghi_chu,list_container,status,date_post)VALUES('$user_id','$ma_booking','$so_booking','$file_booking','hangxuat','$hang_tau','$loai_container','$diachi_donghang','$diachi_trahang','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$ten_cang','$ten_hangtau','$ten_loai_container','$mat_hang','$mat_hang_khac','$so_luong','$trong_luong','$gia','$ghi_chu','$list_container','0','$hientai')");
		$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
		foreach ($tach_list_container as $key => $value) {
			$ngay_trahang=addslashes($value['ngay_trahang']);
			$so_hieu=addslashes($value['so_hieu']);
			$thoi_gian=addslashes($value['thoi_gian']);
			$tach_ngay_trahang=explode('/', $ngay_trahang);
			$tach_thoigian=explode(':', $thoi_gian);
			$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
			mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangxuat','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
		}
		$ok=1;
		$thongbao='Copy booking thành công';
		$thongtin_moi=mysqli_query($conn,"SELECT lc.*,b.loai_hinh,b.hang_tau,b.loai_container,b.tinh,b.huyen,b.xa FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.ma_booking='$ma_booking' ORDER BY lc.date_time ASC LIMIT 1");
		$r_moi=mysqli_fetch_assoc($thongtin_moi);
		$html=$skin->skin_replace('skin_members/box_action/add_hangnhap_step2',$r_moi);
		$tach_list=json_decode($class_index->list_hang_goiy($conn,$r_moi['id'],$r_moi['loai_hinh'],$r_moi['hang_tau'],$r_moi['loai_container'],$r_moi['tinh'],$r_moi['huyen'],$r_moi['xa'], $r_moi['date_time']),true);
		$total_goiy=$tach_list['total'];
		if($total_goiy==0){
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm trả hàng</th>
                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr><tr><td colspan="8">Chưa có booking phù hợp</td></tr>';
		}else{
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm trả hàng</th>
                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr>'.$tach_list['list'];
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list_hang_goiy'=>$list_hang_goiy,
		'total'=>$total_goiy,
		'html'=>$html
	);
	echo json_encode($info);
}else if($action=='copy_hangnhap'){
	$so_booking=addslashes($_REQUEST['so_booking']);
	$hang_tau=intval($_REQUEST['hang_tau']);
	$loai_container=intval($_REQUEST['loai_container']);
	$diachi_donghang=addslashes($_REQUEST['diachi_donghang']);
	$diachi_trahang=addslashes($_REQUEST['diachi_trahang']);
	$tinh=intval($_REQUEST['tinh']);
	$huyen=intval($_REQUEST['huyen']);
	$xa=intval($_REQUEST['xa']);
	$mat_hang=addslashes($_REQUEST['mat_hang']);
	$mat_hang_khac=addslashes($_REQUEST['mat_hang_khac']);
	$so_luong=intval($_REQUEST['so_luong']);
	$trong_luong=addslashes($_REQUEST['trong_luong']);
	$gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$list_container=addslashes($_REQUEST['list_container']);
	$ghi_chu=addslashes($_REQUEST['ghi_chu']);
	$ten_hangtau=addslashes(strip_tags($_REQUEST['ten_hangtau']));
	$ten_loai_container=addslashes(strip_tags($_REQUEST['ten_loai_container']));
	$ten_cang=addslashes(strip_tags($_REQUEST['ten_cang']));
	$ten_tinh=addslashes(strip_tags($_REQUEST['ten_tinh']));
	$ten_huyen=addslashes(strip_tags($_REQUEST['ten_huyen']));
	$ten_xa=addslashes(strip_tags($_REQUEST['ten_xa']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($so_booking==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số booking';
	}/*else if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==false){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn file booking';
	}*/else if($hang_tau==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn hãng tàu';
	}else if($loai_container==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn loại container';
	}else if($diachi_donghang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn địa chỉ đóng hàng';
	}else if($tinh==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn tỉnh/tp';
	}else if($huyen==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn quận/huyện';
	}else if($xa==0){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn xã/thị trấn';
	}else if($diachi_trahang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập địa chỉ trả hàng';
	}else if($mat_hang==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn mặt hàng';
	}else if($mat_hang=='khac' AND $mat_hang_khac==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập mặt hàng khác';
	}else if($so_luong<1){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập số lượng container';
	}else if($gia==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập chi phí vận chuyển';
	}else if($list_container==''){
		$ok=0;
		$thongbao='Thất bại! Chưa nhập danh sách container';
	}else{
		$ma_booking=$class_index->creat_random($conn,'ma_booking');
		$hientai=time();
		if(in_array($duoi, array('pdf','doc','docx','xls','xlsx','ppt','pptx','png','jpg','jpeg','webp','gif'))==true){
			$file_booking = '/uploads/booking/' . $check->blank($so_booking) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $file_booking);
		}else{
			$file_booking='';
		}
		mysqli_query($conn,"INSERT INTO booking(user_id,ma_booking,so_booking,file_booking,loai_hinh,hang_tau,loai_container,diachi_donghang,diachi_trahang,tinh,huyen,xa,ten_tinh,ten_huyen,ten_xa,ten_cang,ten_hangtau,ten_loai_container,mat_hang,mat_hang_khac,so_luong,trong_luong,gia,ghi_chu,list_container,status,date_post)VALUES('$user_id','$ma_booking','$so_booking','$file_booking','hangnhap','$hang_tau','$loai_container','$diachi_donghang','$diachi_trahang','$tinh','$huyen','$xa','$ten_tinh','$ten_huyen','$ten_xa','$ten_cang','$ten_hangtau','$ten_loai_container','$mat_hang','$mat_hang_khac','$so_luong','$trong_luong','$gia','$ghi_chu','$list_container','0','$hientai')");
		$tach_list_container=json_decode(str_replace('\\', '', $list_container),true);
		foreach ($tach_list_container as $key => $value) {
			$ngay_trahang=addslashes($value['ngay_trahang']);
			$so_hieu=addslashes($value['so_hieu']);
			$thoi_gian=addslashes($value['thoi_gian']);
			$tach_ngay_trahang=explode('/', $ngay_trahang);
			$tach_thoigian=explode(':', $thoi_gian);
			$datetime=mktime($tach_thoigian[0],$tach_thoigian[1],0,$tach_ngay_trahang[1],$tach_ngay_trahang[0],$tach_ngay_trahang[2]);
			mysqli_query($conn,"INSERT INTO list_container(user_id,ma_booking,loai_hinh,so_hieu,ngay,thoi_gian,date_time,status,date_post)VALUES('$user_id','$ma_booking','hangnhap','$so_hieu','$ngay_trahang','$thoi_gian','$datetime','0','$hientai')");
		}
		$ok=1;
		$thongbao='Copy booking thành công';
		$thongtin_moi=mysqli_query($conn,"SELECT lc.*,b.loai_hinh,b.hang_tau,b.loai_container,b.tinh,b.huyen,b.xa FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.ma_booking='$ma_booking' ORDER BY lc.date_time ASC LIMIT 1");
		$r_moi=mysqli_fetch_assoc($thongtin_moi);
		$html=$skin->skin_replace('skin_members/box_action/add_hangnhap_step2',$r_moi);
		$tach_list=json_decode($class_index->list_hang_goiy($conn,$r_moi['id'],$r_moi['loai_hinh'],$r_moi['hang_tau'],$r_moi['loai_container'],$r_moi['tinh'],$r_moi['huyen'],$r_moi['xa'], $r_moi['date_time']),true);
		$total_goiy=$tach_list['total'];
		if($total_goiy==0){
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
                                <th class="sticky-row" width="120">Mặt hàng</th>
                                <th class="sticky-row">Địa điểm đóng hàng</th>
                                <th class="sticky-row" width="150">Thời gian đóng hàng</th>
                                <th class="sticky-row" width="150">Cước vận chuyển</th>
                                <th class="sticky-row sticky-column" width="120">Hành động</th>
                            </tr><tr><td colspan="8">Chưa có booking phù hợp</td></tr>';
		}else{
			$list_hang_goiy='<tr>
                                <th class="sticky-row" width="50">STT</th>
                                <th class="sticky-row" width="150">Hãng tàu</th>
                                <th class="sticky-row" width="120">Loại container</th>
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
		'thongbao'=>$thongbao,
		'list_hang_goiy'=>$list_hang_goiy,
		'total'=>$total_goiy,
		'html'=>$html
	);
	echo json_encode($info);
}else if($action=='edit_container'){
	$id=intval($_REQUEST['id']);
	$so_hieu=addslashes($_REQUEST['so_hieu']);
	$ngay=addslashes($_REQUEST['ngay']);
	$thoi_gian=addslashes($_REQUEST['thoi_gian']);
	$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container WHERE user_id='$user_id' AND id='$id'");
	$total=mysqli_num_rows($thongtin_container);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin_container);
		if($r_tt['status']==0){
			if($r_tt['loai_hinh']=='hangnhap'){
				if($so_hieu==''){
					$ok=0;
					$thongbao='Thất bại! Chưa nhập số hiệu container';
				}else if($ngay==''){
					$ok=0;
					$thongbao='Thất bại! Chưa nhập ngày trả hàng';
				}else if($thoi_gian==''){
					$ok=0;
					$thongbao='Thất bại! Chưa nhập thời gian trả hàng';
				}else{
					mysqli_query($conn,"UPDATE list_container SET so_hieu='$so_hieu',ngay='$ngay',thoi_gian='$thoi_gian' WHERE id='$id'");
					$ok=1;
					$thongbao='Cập nhật thông tin thành công';
				}
			}else{
				if($ngay==''){
					$ok=0;
					$thongbao='Thất bại! Chưa nhập ngày trả hàng';
				}else if($thoi_gian==''){
					$ok=0;
					$thongbao='Thất bại! Chưa nhập thời gian trả hàng';
				}else{
					mysqli_query($conn,"UPDATE list_container SET so_hieu='$so_hieu',ngay='$ngay',thoi_gian='$thoi_gian' WHERE id='$id'");
					$ok=1;
					$thongbao='Cập nhật thông tin thành công';
				}

			}
		}else{
			$ok=0;
			$thongbao='Thất bại! Không thể sửa container này';
		}
	}
	$info=array(
		'ok'=>$ok,
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
	$tach_list=json_decode($class_index->timkiem_booking($conn,$user_id,$loai_hinh,$hang_tau_id,$loai_container,$from,$to,$dia_diem_id),true);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($tach_list['total']==0){
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
}else if($action=='load_list_yeucau'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$list_yeucau=$class_index->list_yeucau($conn,$user_id,$phien);
	$note=$r_tt['tieu_de'];
	$info=array(
		'ok'=>1,
		'list'=>$list_yeucau,
	);
	echo json_encode($info);
}else if ($action =='add_yeucau_traodoi'){
	$hientai=time();
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$quy_trinh=addslashes(strip_tags($_REQUEST['quy_trinh']));
	$thanh_vien=$user_id;
	$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$thanh_vien'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($quy_trinh==''){
		$ok=0;
		$thongbao='Thất bại! Chưa chọn bộ phận hỗ trợ';
	}else if(strlen($noi_dung)<2){
		$ok=0;
		$thongbao='Chưa nhập nội dung lưu ý';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE thanh_vien='$thanh_vien' AND active='1'");
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			$ok=0;
			$thongbao='Thất bại! Bạn có yêu cầu đang được xử lý';
		}else{
			$ok=1;
			$thongbao='Thành công! Yêu cầu hỗ trợ đã được gửi';
			$phien_traodoi=$class_index->creat_random($conn,'phien_traodoi');
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien_traodoi','$quy_trinh','$noi_dung','$thanh_vien','0','$user_id','','0','1','$hientai')");
			$noidung_noti=$r_tt['name'].' Vừa yêu cầu hỗ trợ';
			mysqli_query($conn,"INSERT INTO notification_admin(user_id,bo_phan,noi_dung,doc,booking,date_post)VALUES('$user_id','chat','$noidung_noti','','0','$hientai')");
			$thay=array(
				'ho_ten'=>$r_tt['name'],
				'mobile'=>$r_tt['mobile'],
				'tieu_de'=>$noi_dung,
				'phien'=>$phien_traodoi,
				'date_post'=>'Vừa xong',
				'thanh_vien'=>$thanh_vien,
				'active'=>'active'
			);
			$list=$skin->skin_replace('skin_members/box_action/li_yeucau', $thay);
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'thanh_vien'=>$thanh_vien,
		'ho_ten'=>$r_tt['name'],
		'phien'=>$phien_traodoi,
		'list'=>$list,
		'bo_phan'=>$quy_trinh,
		'phien_traodoi'=>$phien_traodoi,
	);
	echo json_encode($info);
}else if($action=='load_chat_sms'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$sms_id=intval($_REQUEST['sms_id']);
	$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id' ORDER BY id DESC LIMIT 1");
	$r_c=mysqli_fetch_assoc($thongtin_cuoi);
	$tach_chat=json_decode($class_index->list_chat($conn,$user_id,$user_info['name'],$user_info['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
	$list_yeucau=$class_index->list_yeucau($conn,$user_id,$phien);
	$note=$r_tt['tieu_de'];
	$info=array(
		'ok'=>1,
		'list_chat'=>$tach_chat['list'],
		'list'=>$list_yeucau,
		'note'=>$note,
		'phien'=>$phien,
		'active'=>$r_tt['active'],
		'thanh_vien'=>$user_id,
		'load_chat'=>$tach_chat['load'],
		'user_id'=>$user_id,
	);
	echo json_encode($info);
}else if($action=='load_khach_traodoi'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.noi_dung='' AND chat.phien='$phien' ORDER BY chat.id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['thanh_vien']!=$user_id){
		$ok=0;
		$thongbao='Bạn không có quyền xem phiên yêu cầu này';
		$info=array(
			'ok'=>$ok,
			'thongbao'=>$thongbao
		);
	}else{
		$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
		$r_c=mysqli_fetch_assoc($thongtin_cuoi);
		$sms_id=$r_c['id'] + 1;
		$tach_chat=json_decode($class_index->list_chat($conn,$user_id,$user_info['name'],$user_info['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
		$list_yeucau=$class_index->list_yeucau($conn,$user_id,$phien);
		$note=$r_tt['tieu_de'];
		$info=array(
			'ok'=>1,
			'list_chat'=>$tach_chat['list'],
			'list'=>$list_yeucau,
			'note'=>$note,
			'phien'=>$phien,
			'active'=>$r_tt['active'],
			'load_chat'=>$tach_chat['load'],
			'thanh_vien'=>$user_id,
			'user_id'=>$user_id,
		);
	}
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
		if($r_tt['thanh_vien']!=$user_id){
			$ok=0;
			$thongbao='Thất bại! Phiên yêu cầu không phải của bạn';
		}else if($r_tt['active']==0){
			$ok=0;
			$thongbao='Phiên yêu cầu hỗ trợ đã đóng';
		}else{
			$hientai=time();
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','$user_id','{$r_tt['user_in']}','$user_id','$noi_dung','0','1','$hientai')");
			$ok=1;
			$thongbao='Gửi thành công';
			$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='$user_id' ORDER BY chat.id DESC LIMIT 1");
			$r_m=mysqli_fetch_assoc($thongtin_moi);
			$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
			$r_c=mysqli_fetch_assoc($thongtin_cuoi);
			$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
			if($r_c['user_out']==$user_id){
				$list_out=$skin->skin_replace('skin_members/box_action/li_chat_left', $r_m);
				$list=$skin->skin_replace('skin_members/box_action/li_chat_right', $r_m);
			}else{
				$list=$skin->skin_replace('skin_members/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_members/box_action/li_chat_left_avatar', $r_m);
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'bo_phan'=>$r_tt['bo_phan'],
		'user_out'=>$user_id,
		'list_out'=>$list_out
	);
	echo json_encode($info);
}else if($action=='add_sticker_traodoi'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$src=addslashes(strip_tags($_REQUEST['src']));
	$sms_id=intval($_REQUEST['sms_id']);
	if(strlen($src)==''){
		$ok=0;
		$thongbao='Thất bại!Chưa nhập nội dung';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['thanh_vien']!=$user_id){
			$ok=0;
			$thongbao='Thất bại! Phiên yêu cầu không phải của bạn';
		}else if($r_tt['active']==0){
			$ok=0;
			$thongbao='Phiên yêu cầu hỗ trợ đã đóng';
		}else{
			$hientai=time();
			$noi_dung='<img src="'.$src.'">';
			mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','$user_id','{$r_tt['user_in']}','$user_id','$noi_dung','0','1','$hientai')");
			$ok=1;
			$thongbao='Gửi thành công';
			$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='$user_id' ORDER BY chat.id DESC LIMIT 1");
			$r_m=mysqli_fetch_assoc($thongtin_moi);
			$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
			$r_c=mysqli_fetch_assoc($thongtin_cuoi);
			$r_m['noi_dung']=$check->smile($r_m['noi_dung']);
			if($r_c['user_out']==$user_id){
				$list_out=$skin->skin_replace('skin_members/box_action/li_chat_left', $r_m);
				$list=$skin->skin_replace('skin_members/box_action/li_chat_right', $r_m);
			}else{
				$list=$skin->skin_replace('skin_members/box_action/li_chat_right_avatar', $r_m);
				$list_out=$skin->skin_replace('skin_members/box_action/li_chat_left_avatar', $r_m);
			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'list'=>$list,
		'user_out'=>$user_id,
		'list_out'=>$list_out,
		'bo_phan'=>$r_tt['bo_phan']
	);
	echo json_encode($info);
}else if($action=='upload_dinhkem'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
	$sms_id=intval($_REQUEST['sms_id']);

	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['thanh_vien']!=$user_id){
		$ok=0;
		$thongbao='Thất bại! Phiên yêu cầu không phải của bạn';
	}else if($r_tt['active']==0){
		$ok=0;
		$thongbao='Phiên yêu cầu hỗ trợ đã đóng';
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
				mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien','{$r_tt['bo_phan']}','','$user_id','{$r_tt['user_in']}','$user_id','$noi_dung','0','1','$hientai')");
				$thongtin_moi=mysqli_query($conn,"SELECT chat.*,user_info.name,user_info.avatar FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.user_out='$user_id' ORDER BY chat.id DESC LIMIT 1");
				$r_m=mysqli_fetch_assoc($thongtin_moi);
				$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' AND id='$sms_id'");
				$r_c=mysqli_fetch_assoc($thongtin_cuoi);
				if($r_c['user_out']==$user_id){
					$list_out.=$skin->skin_replace('skin_members/box_action/li_chat_left', $r_m);
					$list.=$skin->skin_replace('skin_members/box_action/li_chat_right', $r_m);
				}else{
					$list.=$skin->skin_replace('skin_members/box_action/li_chat_right_avatar', $r_m);
					$list_out.=$skin->skin_replace('skin_members/box_action/li_chat_left_avatar', $r_m);
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
		'user_out'=>$user_id,
		'list_out'=>$list_out,
		'bo_phan'=>$r_tt['bo_phan']
	);
	echo json_encode($info);
}else if($action=='dong_yeucau'){
	$phien=addslashes(strip_tags($_REQUEST['phien']));
	$thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id ASC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['thanh_vien']==$user_id){
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
		'user_out'=>$user_id,
		'thongbao'=>$thongbao,
	);
	echo json_encode($info);
}else if($action == 'show_box_chat2') {
	$limit = 15;
	$id = preg_replace('/[^0-9]/', '', $_REQUEST['id']);
	$thongtin_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id' AND (user_id='$user_id' OR user_dat='$user_id')");
	$total_booking=mysqli_num_rows($thongtin_booking);
	if($total_booking==0){
	$ok=0;
	$thongbao='Thất bại! Bạn không có quyền chat ở booking này';
	}else{
	$r_book=mysqli_fetch_assoc($thongtin_booking);
	$ok=1;
	$thongbao='Load dữ liệu thành công';
	$user_out = preg_replace('/[^0-9]/', '', $_REQUEST['user_out']);
	$thongtin_user = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin_user);
	$thongtin_sms = mysqli_query($conn, "SELECT * FROM sms WHERE (user_out='$id' AND user_in='$user_id' AND FIND_IN_SET($user_id,active)>0) OR (user_out='$user_id' AND user_in='$id' AND FIND_IN_SET($user_id,active)>0)  ORDER BY id DESC LIMIT 15");
	$total_sms = mysqli_num_rows($thongtin_sms);
	if ($total_sms == 0) {
	$list_x = '';
	} else {
	$i = 0;
	$list = array();
	while ($r_sms = mysqli_fetch_assoc($thongtin_sms)) {
	$list[$i] = $r_sms;
	$i++;
	}
	krsort($list);
	$k = 0;
	foreach ($list as $key => $value) {
	if ($value['user_out'] == $id) {
	$value['avatar'] = $r_tt['avatar'];
	if ($k == 0) {
		if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
			$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first_smile', $value);
		} else {
			$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first', $value);
		}
	} else {
		if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
			$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_smile', $value);
		} else {
			$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in', $value);
		}
	}
	$k++;
	} else {
	if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
		$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out_smile', $value);
	} else {
		$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out', $value);
	}
	$k = 0;
	}
	}
	}
	$r_tt['list'] = $list_x;
	if (time() - $r_tt['end_online'] <= 30) {
	$r_tt['class_status'] = 'online';
	} else {
	$r_tt['class_status'] = 'offline';
	}
	$box = $skin->skin_replace('skin_members/box_action/box_chat', $r_tt);
	mysqli_query($conn, "UPDATE user_info SET end_online='$hientai' WHERE user_id='$user_id'");
	}
	$info=array(
	'ok'=>$ok,
	'thongbao'=>$thongbao,
	'html'=>$box
	);
	echo json_encode($info);
}else if($action == 'show_box_chat') {
	$limit = 15;
	$id = preg_replace('/[^0-9]/', '', $_REQUEST['id']);
	$hientai=time();
	$ok=1;
	$thongbao='Load dữ liệu thành công';
	$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin_user);
	$thongtin_sms = mysqli_query($conn, "SELECT * FROM sms WHERE user_out='$user_id' OR user_in='$user_id' ORDER BY id DESC LIMIT 15");
	$total_sms = mysqli_num_rows($thongtin_sms);
	if ($total_sms == 0) {
		$list_x = '';
	} else {
		$i = 0;
		$list = array();
		while ($r_sms = mysqli_fetch_assoc($thongtin_sms)) {
			$list[$i] = $r_sms;
			$i++;
		}
		krsort($list);
		$k = 0;
		foreach ($list as $key => $value) {
			if ($value['user_out'] == $r_tt['user_id']) {
				$value['avatar'] = $r_tt['avatar'];
				if ($k == 0) {
					if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first_smile', $value);
					} else {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first', $value);
					}
				} else {
					if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_smile', $value);
					} else {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in', $value);
					}
				}
				$k++;
			} else {
				if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
					$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out_smile', $value);
				} else {
					$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out', $value);
				}
				$k = 0;
			}
		}
	}
	$r_tt['list'] = $list_x;
	if (time() - (int)$r_tt['end_online'] <= 30) {
		$r_tt['class_status'] = 'online';
	} else {
		$r_tt['class_status'] = 'offline';
	}
	$r_tt['user_id']=$id;
	$box = $skin->skin_replace('skin_members/box_action/box_chat', $r_tt);
	mysqli_query($conn, "UPDATE user_info SET end_online='$hientai' WHERE user_id='$user_id'");
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'html'=>$box
	);
	echo json_encode($info);
}else if($action == 'send_chat') {
	$user_in = preg_replace('/[^0-9]/', '', $_REQUEST['user_in']);
	$user_out = preg_replace('/[^0-9]/', '', $_REQUEST['user_out']);
	$noi_dung = addslashes($_REQUEST['noi_dung']);
	$noi_dung = $check->smile($noi_dung);
	$noi_dung = preg_replace('/style="(.*?)"/', '', $noi_dung);
	$noi_dung = str_replace('{x}', '&', $noi_dung);
	$noi_dung = str_replace('<div>', '<br>', $noi_dung);
	$noi_dung = str_replace('</div>', '', $noi_dung);
	$noi_dung = strip_tags($noi_dung, '<img><br><a><span><strong><p><i><b><u>');
	$last = preg_replace('/[^a-z_]/', '', $_REQUEST['last']);
	$hientai=time();
	if ($user_out!= $user_id) {
		$ok = false;
		$note = 'Bạn chưa đăng nhập...';
		$sms_id = '';
		$sms_out = '';
	} else {
		if (strlen($noi_dung) > 0) {
			$user_all = $user_out . ',' . $user_in;
			mysqli_query($conn, "INSERT INTO sms (user_out,user_in,noi_dung,doc,active,date_post) VALUES ('$user_out','$user_in','$noi_dung','0','$user_all','$hientai')");
			$ok = true;
			$sms_in = $noi_dung;
			$sms_out = $noi_dung;
		} else {
			$note = 'Lỗi! Nội dung quá ngắn...';
			$ok = false;
			$sms_in = '';
			$sms_out = '';
		}

	}
	$info = array(
		'ok' => $ok,
		'note' => $note,
		'user_in' => $user_in,
		'user_out' => $user_out,
		'sms_out' => $sms_out,
		'sms_in' => $sms_in,
	);
	mysqli_query($conn, "UPDATE user_info SET end_online='$hientai' WHERE user_id='$user_id'");
	echo json_encode($info);
}else if($action == 'load_more_sms') {
	$page = intval($_REQUEST['page']);
	$sms_id = intval($_REQUEST['sms_id']);
	$user = preg_replace('/[^0-9]/', '', $_REQUEST['user']);
	$limit = 15;
	$start = $page * $limit - $limit;
	$thongtin = mysqli_query($conn, "SELECT * FROM sms INNER JOIN user_info ON (user_info.user_id='$user' AND sms.user_in='$user' AND sms.user_out='$user_id' AND FIND_IN_SET($user_id,sms.active)>0 AND sms.id<'$sms_id') OR (user_info.user_id='$user' AND sms.user_in='$user_id' AND sms.user_out='$user' AND FIND_IN_SET($user_id,sms.active AND sms.id<'$sms_id') ORDER BY sms.id DESC LIMIT 15");
	$total = mysqli_num_rows($thongtin);
	if ($total == 0) {
		$list_x = '';
		$load = 0;
	} else {
		if ($total < $limit) {
			$load = 0;
		} else {
			$load = 1;
		}
		$list = array();
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['noi_dung'] = $check->smile($r_tt['noi_dung']);
			if ($r_tt['username'] != '') {
				$r_tt['username'] = $r_tt['username'];
			} else {
				$r_tt['username'] = $r_tt['user_id'];
			}
			$list[$i] = $r_tt;
			$i++;
		}
		krsort($list);
		$k = 0;
		foreach ($list as $key => $value) {
			if ($value['user_out'] == $user) {
				if ($k == 0) {
					if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first_smile', $value);
					} else {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_first', $value);
					}
				} else {
					if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in_smile', $value);
					} else {
						$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_in', $value);
					}
				}
				$k++;
			} else {
				if (strpos($value['noi_dung'], '<img') !== false AND strpos($value['noi_dung'], 'smile/default') == false) {
					$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out_smile', $value);
				} else {
					$list_x .= $skin->skin_replace('skin_members/box_action/li_sms_out', $value);
				}
				$k = 0;
			}
		}
	}
	$info = array(
		'list' => $list_x,
		'load' => $load,
		'ok' => true,
	);
	mysqli_query($conn, "UPDATE user_info SET end_online='" . time() . "' WHERE user_id='$user_id'");
	echo json_encode($info);
}else if($action=='read_sms'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM sms WHERE user_out='$user_id' OR user_in='$user_id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
	}else{
		mysqli_query($conn,"UPDATE sms SET doc='1' WHERE user_in='$user_id'");
	}
	$info=array(
		'ok'=>1,
		'thongbao'=>'Đã active box chat',
	);
	echo json_encode($info);
}else if($action=='load_doanhso_chitieu'){
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
	$thongke=json_decode($class_index->thongke_doanhso_chitieu($conn,$user_id,$begin_time,$end_time),true);
	$ok=1;
	$thongbao='Lấy dữ liệu thành công';
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
	$thongke=json_decode($class_index->thongke_doanhso_naptien($conn,$user_id,$begin_time,$end_time),true);
	$ok=1;
	$thongbao='Lấy dữ liệu thành công';
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
	$thongke=json_decode($class_index->thongke_booking($conn,$user_id,$begin_time,$end_time),true);
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
	echo json_encode($bien);
}else if($action=='load_doanhso_dat_booking'){
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
	$thongke=json_decode($class_index->thongke_dat_booking($conn,$user_id,$begin_time,$end_time),true);
	$ok=1;
	$thongbao='Lấy dữ liệu thành công';
	$bien=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
		'doanhso_cho_xacnhan'=>number_format($thongke['doanhso_cho_xacnhan']).' đ',
		'doanhso_hoanthanh'=>number_format($thongke['doanhso_hoanthanh']).' đ',
		'doanhso_xacnhan'=>number_format($thongke['doanhso_xacnhan']).' đ',
		'doanhso_tuchoi'=>number_format($thongke['doanhso_tuchoi']).' đ',
		'booking_cho_xacnhan'=>'Với '.number_format($thongke['booking_cho_xacnhan']).' booking',
		'booking_hoanthanh'=>'Với '.number_format($thongke['booking_hoanthanh']).' booking',
		'booking_xacnhan'=>'Với '.number_format($thongke['booking_xacnhan']).' booking',
		'booking_tuchoi'=>'Với '.number_format($thongke['booking_tuchoi']).' booking',
	);
	echo json_encode($bien);
}else if($action=='add_naptien'){
	$so_tien=preg_replace('/[^0-9-]/', '', $_REQUEST['so_tien']);
	$so_tien=intval($so_tien);
	$hientai=time();
	if($so_tien<50000){
		$ok=0;
		$thongbao='Thất bại! Vui lòng nhập số tiền từ 50 000 đ';
		$html='';
	}else{
		$ok=1;
		$thongbao='Chuyển khoản để hoàn thành giao dịch';
		mysqli_query($conn,"INSERT INTO naptien(user_id,sotien,kich_hoat,status,date_post,update_post)VALUES('$user_id','$so_tien','0','0','$hientai','$hientai')");
		$thongtin=mysqli_query($conn,"SELECT * FROM naptien WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$r_tt['username']=$user_info['username'];
		$r_tt['sotien_2']=$so_tien;
		$r_tt['sotien_1']=number_format($so_tien);
		$r_tt['nganhang']=$index_setting['nganhang'];
		$r_tt['username']=$user_info['username'];
		$r_tt['bank_code']=$index_setting['bank_code'];
		$r_tt['bank_name']=$index_setting['bank_name'];
		$r_tt['bank_account']=preg_replace('/[^0-9]/','',$index_setting['bank_account']);
		$r_tt['bank_holder']=$index_setting['bank_holder'];
		$r_tt['time_del_naptien']=$index_setting['time_del_naptien'];
		$html=$skin->skin_replace('skin_members/box_action/add_naptien_step2',$r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html'=>$html
	);
	echo json_encode($info);
}else if($action=='add_naptien_step2'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM naptien WHERE id='$id' AND user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
		$html='';
	}else{
		$ok=1;
		$thongbao='Thành công! Vui lòng chờ xác nhận';
		mysqli_query($conn,"UPDATE naptien SET status='3' WHERE id='$id' AND user_id='$user_id'");
		$noidung_noti='Có người vừa hoàn thành nạp tiền';
		mysqli_query($conn,"INSERT INTO notification_admin(user_id,bo_phan,noi_dung,doc,booking,date_post)VALUES('$user_id','naptien','$noidung_noti','','$id','$hientai')");
		$html=$skin->skin_normal('skin_members/box_action/add_naptien_step3');
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html'=>$html
	);
	echo json_encode($info);
} else if ($action == "xacnhan_kichhoat") {
	$nam = preg_replace('/[^0-9]/', '', $_REQUEST['nam']);
	$nam=intval($nam);
	$thongtin=mysqli_query($conn,"SELECT * FROM goi_giahan WHERE thoi_gian='$nam'");
	$total=mysqli_num_rows($thongtin);
	$hientai=time();
	if($total==0){
		$ok=0;
		$thongbao='Thất bại! Không có gói gia hạn này';
		$chuyenhuong=0;
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$tongtien=$user_info['user_money'] + $user_info['user_money2'];
		if($tongtien>=$r_tt['gia']){
			$ok = 1;
			$thongbao = 'Gia hạn tài khoản thành công';
			$thongtin_kichhoat=mysqli_query($conn,"SELECT * FROM kich_hoat WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
			$total_kichhoat=mysqli_num_rows($thongtin_kichhoat);
			if($total_kichhoat==0){
				$giahan_expired=time() + $r_tt['thoi_gian']*3600*24;
			}else{
				$r_kh=mysqli_fetch_assoc($thongtin_kichhoat);
				if($r_kh['date_end']>time()){
					$giahan_expired=$r_kh['date_end'] + $r_tt['thoi_gian']*3600*24;
				}else{
					$giahan_expired=time() + $r_tt['thoi_gian']*3600*24;
				}
			}
			if($user_info['user_money']>=$r_tt['gia']){
				$truoc=$user_info['user_money'] + $user_info['user_money2'];
				$sau=$truoc - $r_tt['gia'];
				$conlai=$user_info['user_money'] - $r_tt['gia'];
				mysqli_query($conn,"UPDATE user_info SET user_money='$conlai' WHERE user_id='$user_id'");
			}else{
				$truoc=$user_info['user_money'] + $user_info['user_money2'];
				$sau=$truoc - $r_tt['gia'];
				$conlai=$user_info['user_money2'] - ($r_tt['gia'] - $user_info['user_money']);
				mysqli_query($conn,"UPDATE user_info SET user_money='0',user_money2='$conlai' WHERE user_id='$user_id'");
			}
			$noidung='Gia hạn tài khoản! Gói gia hạn: '.$r_tt['tieu_de'];
			$chuyenhuong=0;
			mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','{$r_tt['gia']}','$truoc','$sau','$noidung','$hientai')");
			mysqli_query($conn,"INSERT INTO kich_hoat(user_id,so_tien,date_end,date_post)VALUES('$user_id','{$r_tt['gia']}','$giahan_expired','$hientai')");
		}else{
			$ok=0;
			$thongbao='Thất bại! Số dư tài khoản không đủ';
			$chuyenhuong=1;
		}
	}
	$info = array(
		'ok' => $ok,
		'chuyenhuong'=>$chuyenhuong,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

}else if($action=='edit_naptien'){
	if (!isset($_COOKIE['emin_id'])) {
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
			if($r_tt['status']==0){
				mysqli_query($conn, "UPDATE naptien SET status='$status',update_post='$hientai' WHERE id='$id'");
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
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='edit_ruttien'){
	if (!isset($_COOKIE['emin_id'])) {
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
}else if($action=='dat_booking'){
	$ngay_trahang=addslashes($_REQUEST['ngay_trahang']);
	$thoi_gian=addslashes($_REQUEST['thoi_gian']);
	$id=intval($_REQUEST['id']);
	$gia = preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
	$thongtin_container=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id'");
	$total=mysqli_num_rows($thongtin_container);
	$hientai=time();
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$ok=0;
		$thongbao='Thất bại! Dữ liệu không tồn tại';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin_container);
		$thongtin_booking=mysqli_query($conn,"SELECT booking.*,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='$id' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT 1");
		$r_booking=mysqli_fetch_assoc($thongtin_booking);
		if($r_tt['user_id']==$user_id){
			$ok=0;
			$thongbao='Thất bại! Bạn ko thể đặt booking của mình';
		}else{
			$thongtin_booking=mysqli_query($conn,"SELECT * FROM list_booking WHERE id_container='$id' AND user_dat='$user_id' AND status='0'");
			$total_booking=mysqli_num_rows($thongtin_booking);
			if($total_booking>0){
				$ok=0;
				$thongbao='Thất bại! Bạn đã đặt booking này';
			}else{
				if($user_info['user_money']>=$index_setting['phi_booking']){
					$sotien=$index_setting['phi_booking'];
					$truoc=$user_info['user_money'];
					$con=$user_info['user_money'] - $index_setting['phi_booking'];
					$phi_booking=$index_setting['phi_booking'];
					mysqli_query($conn,"INSERT INTO list_booking(user_id,user_dat,id_container,phi_booking,gia,ngay,thoi_gian,status,update_post,date_post)VALUES('{$r_tt['user_id']}','$user_id','$id','$phi_booking','$gia','$ngay_trahang','$thoi_gian','0','$hientai','$hientai')");
					$noidung='Trừ phí đặt booking '.number_format($sotien);
					mysqli_query($conn,"INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$sotien','$truoc','$con','$noidung','$hientai')");
					mysqli_query($conn,"UPDATE user_info SET user_money='$con' WHERE user_id='$user_id'");
					$thongtin_moi=mysqli_query($conn,"SELECT * FROM list_booking WHERE user_dat='$user_id' AND id_container='$id' ORDER BY id DESC LIMIT 1");
					$r_moi=mysqli_fetch_assoc($thongtin_moi);
					$noidung_noti='Có người vừa đặt booking #'.strtoupper($r_booking['so_booking']).', số hiệu container #'.strtoupper($r_tt['so_hieu']).' của bạn';
					mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','{$r_tt['user_id']}','$noidung_noti','','{$r_moi['id']}','0','$hientai')");
					$ok=1;
					$thongbao='Đặt booking thành công';
					$box=$skin->skin_replace('skin_members/box_action/box_dat_hoanthanh', $r_tt);
				}else{
					$ok=0;
					$thongbao='Thất bại! Số dư tài khoản không đủ<br>Vui lòng nạp thêm tiền vào tài khoản.';

				}
			}
		}


	}
	$info = array(
		'ok' => $ok,
		'user_id'=>$r_tt['user_id'],
		'box'=>$box,
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
		if (strlen($cong_ty) < 2) {
			$thongbao = "Vui lòng nhập tên công ty";
			$ok = 0;
		}else if (strlen($maso_thue) < 2) {
			$thongbao = "Vui lòng nhập mã số thuế";
			$ok = 0;
		}else if (strlen($name) < 2) {
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
						mysqli_query($conn, "UPDATE user_info SET name='$name',avatar='$minh_hoa',mobile='$mobile',cong_ty='$cong_ty',maso_thue='$maso_thue',email='$email' WHERE user_id='$user_id'");
					} else {
						mysqli_query($conn, "UPDATE user_info SET name='$name',mobile='$mobile',cong_ty='$cong_ty',maso_thue='$maso_thue',email='$email' WHERE user_id='$user_id'");
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
}else if($action=='change_password'){
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
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['password'] != $pass) {
				$ok = 0;
				$thongbao = "Mật khẩu hiện tại không đúng";
			} else {
				$password = md5($new_pass);
				mysqli_query($conn, "UPDATE user_info SET password='$password' WHERE user_id='$user_id'");
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
}else if($action=='del'){
	$loai = addslashes($_REQUEST['loai']);
	$id = preg_replace('/[^0-9a-z-]/', '', $_REQUEST['id']);
	if($loai=='container'){
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM list_container WHERE id='$id' AND user_id='$user_id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			if($r_tt['status']==0){
				$ok=1;
				$thongbao='Xóa container thành công';
				$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
				$r_b=mysqli_fetch_assoc($thongtin_booking);
				$sl_moi=$r_b['so_luong'] - 1;
				mysqli_query($conn,"UPDATE booking SET so_luong='$sl_moi' WHERE ma_booking='{$r_tt['ma_booking']}'");
				mysqli_query($conn,"DELETE FROM list_container WHERE id='$id' AND user_id='$user_id'");
			}else{
				$ok=0;
				$thongbao='Thất bại! Không thể xóa container này';
			}
		}
	}else if($loai=='contact'){
		if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
			echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
			exit();	
		}
		$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM contact WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['total']==0){
			$ok=0;
			$thongbao='Liên hệ không tồn tại';
		}else{
			$ok=1;
			$thongbao='Xóa liên hệ thành công';
			mysqli_query($conn,"DELETE FROM contact WHERE id='$id'");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='upload_tinymce'){
	if (!isset($_COOKIE['emin_id'])) {
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
}else if($action=='upload_photo'){
	if (!isset($_COOKIE['emin_id'])) {
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
}else if($action=='goi_y'){
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
}else if($action=='check_blank'){
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
}else if($action=='check_link'){
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
}else if($action=='add_rate_booking'){
	$rate=intval($_REQUEST['rate']);
	$note=addslashes(strip_tags($_REQUEST['note']));
	$id=intval($_REQUEST['id']);
	$hientai=time();
	$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id'");
	$total=mysqli_num_rows($thongtin);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$thongbao='Thất bại! Dữ liệu không tồn tại';
		$ok=0;
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		if($r_tt['user_id']==$user_id OR $r_tt['user_dat']==$user_id){
			$thongtin_rate=mysqli_query($conn,"SELECT * FROM list_rate WHERE user_id='$user_id' AND booking_id='$id'");
			$total_rate=mysqli_num_rows($thongtin_rate);
			if($r_tt['user_id']==$user_id){
				$user_to=$r_tt['user_dat'];
			}else{
				$user_to=$r_tt['user_id'];
			}
			if($total_rate==0){
				mysqli_query($conn,"INSERT INTO list_rate(booking_id,id_container,user_id,user_to,rate,note,update_post,date_post)VALUES('$id','{$r_tt['id_container']}','$user_id','$user_to','$rate','$note','$hientai','$hientai')");
				$noidung_noti='Vừa có đánh giá booking của bạn';
			}else{
				mysqli_query($conn,"UPDATE list_rate SET rate='$rate',note='$note',update_post='$hientai' WHERE booking_id='$id' AND user_id='$user_id'");
				$noidung_noti='Vừa có cập nhật đánh giá booking của bạn';
			}
			$thongtin_danhgia=mysqli_query($conn,"SELECT SUM(rate) AS diem_rate,count(*) AS total FROM list_rate WHERE user_to='$user_to'");
			$r_dg=mysqli_fetch_assoc($thongtin_danhgia);
			if($r_dg['total']>0){
				$dg_tb=$r_dg['diem_rate']/$r_dg['total'];
				$dg_tb=number_format($dg_tb,1);
				mysqli_query($conn,"UPDATE user_info SET rate='$dg_tb',num_rate='{$r_dg['total']}' WHERE user_id='$user_to'");
			}
			mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','$user_to','$noidung_noti','','$id','0','$hientai')");
			$ok=1;
			$thongbao='Gửi đánh giá thành công';
		}else{
			$thongbao='Thất bại! Bạn không có quyền đánh giá';
			$ok=0;
		}
	}
	$info = array(
		'ok' => $ok,
		'user_id'=>$user_to,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='edit_rate_booking'){
	$rate=intval($_REQUEST['rate']);
	$note=addslashes(strip_tags($_REQUEST['note']));
	$id=intval($_REQUEST['id']);
	$hientai=time();
	$thongtin=mysqli_query($conn,"SELECT * FROM list_rate WHERE id='$id' AND user_id='$user_id'");
	$total=mysqli_num_rows($thongtin);
	if($sudung_expired<=0){
		$ok=0;
		$thongbao='Thất bại! Tài khoản đã hết hạn sử dụng';
	}else if($total==0){
		$thongbao='Thất bại! Bạn không có quyền chỉnh sửa';
		$ok=0;
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$user_to=$r_tt['user_to'];
		mysqli_query($conn,"UPDATE list_rate SET rate='$rate',note='$note',update_post='$hientai' WHERE id='$id' AND user_id='$user_id'");
		$noidung_noti='Vừa có cập nhật đánh giá booking của bạn';
		mysqli_query($conn,"INSERT INTO notification(user_id,user_nhan,noi_dung,doc,booking,admin,date_post)VALUES('$user_id','$user_to','$noidung_noti','','{$r_tt['booking_id']}','0','$hientai')");
		$ok=1;
		$thongbao='Lưu thay đổi thành công';
	}
	$info = array(
		'ok' => $ok,
		'user_id'=>$user_to,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='show_goiy'){
	$id=intval($_REQUEST['id']);
	$thongtin=mysqli_query($conn,"SELECT lc.*,b.loai_hinh,b.hang_tau,b.loai_container,b.tinh,b.huyen,b.xa FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.id='$id'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$ok=0;
		$thongbao='Dữ liệu không tồn tại';
	}else{
		$ok=1;
		$r_tt=mysqli_fetch_assoc($thongtin);
		$tach_list=json_decode($class_index->list_hang_goiy($conn,$r_tt['id'],$r_tt['loai_hinh'],$r_tt['hang_tau'],$r_tt['loai_container'],$r_tt['tinh'],$r_tt['huyen'],$r_tt['xa'], $r_tt['date_time']),true);
		$total_goiy=$tach_list['total'];
		if($total_goiy==0){
			if($r_tt['loai_hinh']=='hangnhap'){
				$list_hang_goiy='<tr>
	                                <th class="sticky-row" width="50">STT</th>
	                                <th class="sticky-row" width="150">Hãng tàu</th>
	                                <th class="sticky-row" width="120">Loại container</th>
	                                <th class="sticky-row" width="120">Mặt hàng</th>
	                                <th class="sticky-row">Địa điểm đóng hàng</th>
	                                <th class="sticky-row" width="150">Thời gian đóng hàng</th>
	                                <th class="sticky-row" width="150">Cước vận chuyển</th>
	                                <th class="sticky-row sticky-column" width="120">Hành động</th>
	                            </tr><tr><td colspan="8">Không có booking phù hợp</td></tr>';
			}else{
				$list_hang_goiy='<tr>
	                                <th class="sticky-row" width="50">STT</th>
	                                <th class="sticky-row" width="150">Hãng tàu</th>
	                                <th class="sticky-row" width="120">Loại container</th>
	                                <th class="sticky-row" width="120">Mặt hàng</th>
	                                <th class="sticky-row">Địa điểm trả hàng</th>
	                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
	                                <th class="sticky-row" width="150">Cước vận chuyển</th>
	                                <th class="sticky-row sticky-column" width="120">Hành động</th>
	                            </tr><tr><td colspan="8">Không có booking phù hợp</td></tr>';

			}
		}else{
			if($r_tt['loai_hinh']=='hangnhap'){
				$list_hang_goiy='<tr>
	                                <th class="sticky-row" width="50">STT</th>
	                                <th class="sticky-row" width="150">Hãng tàu</th>
	                                <th class="sticky-row" width="120">Loại container</th>
	                                <th class="sticky-row" width="120">Mặt hàng</th>
	                                <th class="sticky-row">Địa điểm đóng hàng</th>
	                                <th class="sticky-row" width="150">Thời gian đóng hàng</th>
	                                <th class="sticky-row" width="150">Cước vận chuyển</th>
	                                <th class="sticky-row sticky-column" width="120">Hành động</th>
	                            </tr>'.$tach_list['list'];
			}else{
				$list_hang_goiy='<tr>
	                                <th class="sticky-row" width="50">STT</th>
	                                <th class="sticky-row" width="150">Hãng tàu</th>
	                                <th class="sticky-row" width="120">Loại container</th>
	                                <th class="sticky-row" width="120">Mặt hàng</th>
	                                <th class="sticky-row">Địa điểm trả hàng</th>
	                                <th class="sticky-row" width="150">Thời gian trả hàng</th>
	                                <th class="sticky-row" width="150">Cước vận chuyển</th>
	                                <th class="sticky-row sticky-column" width="120">Hành động</th>
	                            </tr>'.$tach_list['list'];

			}
		}
	}
	$info=array(
		'ok'=>$ok,
		'list_hang_goiy'=>$list_hang_goiy,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='show_edit'){
	$loai=addslashes($_REQUEST['loai']);
	if($loai=='container'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_container WHERE id='$id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$html = $skin->skin_replace('skin_members/box_action/show_edit_container', $r_tt);
		}
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='rate'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_rate WHERE id='$id' AND user_id='$user_id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Dữ liệu không tồn tại';
		}else{
			$ok=1;
			$r_tt=mysqli_fetch_assoc($thongtin);
			$con=5 - $r_tt['rate'];
			for ($i=1; $i <=$r_tt['rate'] ; $i++) { 
				$list_star.='<i class="fa fa-star" data-index="'.$i.'"></i>';
			}
			for ($i=($r_tt['rate'] + 1); $i <=5 ; $i++) { 
				$list_star_o.='<i class="fa fa-star-o" data-index="'.$i.'"></i>';
			}
			$r_tt['list_star']=$list_star.''.$list_star_o;	
			$html = $skin->skin_replace('skin_members/box_action/show_edit_rate', $r_tt);
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
	if($loai=='add_booking'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT list_container.*,booking.gia FROM list_container LEFT JOIN booking ON list_container.ma_booking=booking.ma_booking WHERE list_container.id='$id' GROUP BY list_container.id");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$r_tt['gia']=number_format($r_tt['gia']);
		$ok=1;
		$html = $skin->skin_replace('skin_members/box_action/show_add_booking',$r_tt);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}else if($loai=='rate_booking'){
		$id=intval($_REQUEST['id']);
		$thongtin=mysqli_query($conn,"SELECT * FROM list_booking WHERE id='$id'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$ok=1;
		$html = $skin->skin_replace('skin_members/box_action/show_rate_booking',$r_tt);
		$info=array(
			'ok'=>$ok,
			'html'=>$html,
			'thongbao'=>$thongbao
		);
		echo json_encode($info);
	}
} else {
	echo "Không có hành động nào được xử lý";
}
?>