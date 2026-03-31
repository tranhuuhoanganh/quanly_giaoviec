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
	$thongtin_kichhoat=mysqli_query($conn,"SELECT * FROM kich_hoat WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
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
}else if($action=='add_yeucau_huy'){
	$hientai=time();
	$id=intval($_REQUEST['id']);
	$ly_do=addslashes($_REQUEST['ly_do']);
	$ly_do_khac=addslashes($_REQUEST['ly_do_khac']);
	$thongtin=mysqli_query($conn,"SELECT * FROM yeucau_huy WHERE id_booking='$id' AND user_id='$user_id' AND status='0'");
	$total=mysqli_num_rows($thongtin);
	if($total>0){
		$ok=0;
		$thongbao='Thất bại! Bạn đã yêu cầu hủy booking này';
	}else{
		mysqli_query($conn,"INSERT INTO yeucau_huy(user_id,id_booking,ly_do,ly_do_khac,ghi_chu,status,date_post)VALUES('$user_id','$id','$ly_do','$ly_do_khac','','0','$hientai')");
		$ok=1;
		$thongbao='Gửi yêu cầu hủy thành công';
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
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
	
	
	////////////////////////////////
	
	}else if($action=='filter_thongke_congviec'){
		$user_id = $user_info['user_id'];
        $admin_cty = $user_info['admin_cty'];
        $hientai = time();
        $nam = date('Y');
        $thang = date('m');

        $tu_ngay = isset($_POST['tu_ngay']) ? trim($_POST['tu_ngay']) : '';
        $den_ngay = isset($_POST['den_ngay']) ? trim($_POST['den_ngay']) : '';
		$nam_thang = isset($_POST['nam_thang']) ? intval($_POST['nam_thang']) : 0;

		if($nam_thang <= 0){
			$nam_thang = date('Y');
		}
        $tu_ngay_ts = 0;
        $den_ngay_ts = 0;

        if($nam_thang > 0){
            $nam = $nam_thang;
        }

        if($tu_ngay != '' || $den_ngay != ''){
    
			if($tu_ngay != ''){
				$tmp = strtotime($tu_ngay . ' 00:00:00');
				if($tmp !== false){
					$tu_ngay_ts = $tmp;
				}
			}
			if($den_ngay != ''){
				$tmp = strtotime($den_ngay . ' 23:59:59');
				if($tmp !== false){
					$den_ngay_ts = $tmp;
				}
			}
		}
        $r_tt = [
            'nam' => $nam,
            'thang' => $thang,
            'tu_ngay' => $tu_ngay,
            'den_ngay' => $den_ngay
        ];
					
        $tongquan = $class_member->thongke_tongquan_congviec($conn, $user_id, $admin_cty, $tu_ngay_ts, $den_ngay_ts);
        $r_tt = array_merge($r_tt, $tongquan);

        $thang_data = $class_member->thongke_thang_congviec($conn, $user_id, $admin_cty, $nam_thang);
        $r_tt['data_thang_tao'] = $thang_data['data_thang_tao'];
        $r_tt['data_thang_nhanviec'] = $thang_data['data_thang_nhanviec'];
        $r_tt['data_thang_hoanthanh'] = $thang_data['data_thang_hoanthanh'];


        // Render lại toàn bộ box thống kê công việc
        $html = $skin->skin_replace('skin_members/box_action/thongke_congviec', $r_tt);

        $info = array(
            'ok' => 1,
            'html' => $html
        );
        echo json_encode($info);
	
	}else if($action=='filter_thongke_du_an'){
		$user_id = $user_info['user_id'];
        $admin_cty = $user_info['admin_cty'];
        $hientai = time();
        $nam = date('Y');
        $thang = date('m');

        $tu_ngay = isset($_POST['tu_ngay']) ? trim($_POST['tu_ngay']) : '';
        $den_ngay = isset($_POST['den_ngay']) ? trim($_POST['den_ngay']) : '';
		$nam_thang = isset($_POST['nam_thang']) ? intval($_POST['nam_thang']) : 0;

		if($nam_thang <= 0){
			$nam_thang = date('Y');
		}
        $tu_ngay_ts = 0;
        $den_ngay_ts = 0;

        if($nam_thang > 0){
            $nam = $nam_thang;
        }

        if($tu_ngay != '' || $den_ngay != ''){
    
			if($tu_ngay != ''){
				$tmp = strtotime($tu_ngay . ' 00:00:00');
				if($tmp !== false){
					$tu_ngay_ts = $tmp;
				}
			}
			if($den_ngay != ''){
				$tmp = strtotime($den_ngay . ' 23:59:59');
				if($tmp !== false){
					$den_ngay_ts = $tmp;
				}
			}
		}
        $r_tt = [
            'nam' => $nam,
            'thang' => $thang,
            'tu_ngay' => $tu_ngay,
            'den_ngay' => $den_ngay
        ];

        $tongquan = $class_member->thongke_tongquan_du_an($conn,$user_id, $admin_cty, $tu_ngay_ts, $den_ngay_ts);
        $r_tt = array_merge($r_tt, $tongquan);

        $thang_data = $class_member->thongke_thang_du_an($conn, $user_id, $admin_cty, $nam_thang);
		$r_tt['data_thang_tao_du_an'] = $thang_data['data_thang_tao_du_an'];
		$r_tt['data_thang_nhanviec_du_an'] = $thang_data['data_thang_nhanviec_du_an'];
		$r_tt['data_thang_hoanthanh_du_an'] = $thang_data['data_thang_hoanthanh_du_an'];
		$r_tt['data_thang_tao_congviec'] = $thang_data['data_thang_tao_congviec'];
		$r_tt['data_thang_nhanviec_congviec'] = $thang_data['data_thang_nhanviec_congviec'];
		$r_tt['data_thang_hoanthanh_congviec'] = $thang_data['data_thang_hoanthanh_congviec'];
		


        // Render lại toàn bộ box thống kê công việc
        $html = $skin->skin_replace('skin_members/box_action/thongke_du_an', $r_tt);

        $info = array(
            'ok' => 1,
            'html' => $html
        );
        echo json_encode($info);
	
	}else if($action=='load_user_nhan'){
		$phong_ban_nhan = intval($_REQUEST['phong_ban_nhan']);
		$admin_cty = $user_info['admin_cty'];
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE phong_ban='$phong_ban_nhan' AND admin_cty='$admin_cty'");
		$total = mysqli_num_rows($thongtin);
		$list = '';
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$list .='<option value="' . $r_tt['user_id'] . '">' . $r_tt['name'] . '</option>';
		}
		$info = array(
			'ok' => 1,
			'list' => '<option value="">Chọn người nhận việc</option>'.$list,
		);
		echo json_encode($info);
	}else if($action == 'load_user_giamsat'){

		$nguoi_nhan = intval($_REQUEST['nguoi_nhan']);
		$admin_cty  = $user_info['admin_cty'];
	
		$list = '<option value="">Chọn người giám sát</option>';
	
		if($nguoi_nhan <= 0){
			echo json_encode(['ok'=>1,'list'=>$list]);
			exit;
		}
	
		$q_user = mysqli_query(
			$conn,"SELECT phong_ban FROM user_info WHERE user_id='$nguoi_nhan' AND admin_cty='$admin_cty' LIMIT 1");
	
		if(!mysqli_num_rows($q_user)){
			echo json_encode(['ok'=>1,'list'=>$list]);
			exit;
		}
	
		$r_user = mysqli_fetch_assoc($q_user);
		$phong_ban_nhan = intval($r_user['phong_ban']);
		if($phong_ban_nhan <= 0){
			echo json_encode(['ok'=>1,'list'=>$list]);
			exit;
		}
	
		// Lấy phòng ban hiện tại + toàn bộ phòng ban CHA
		$phongban_ids = $class_member->get_all_parent_phongban($conn,$admin_cty,$phong_ban_nhan);
		if(empty($phongban_ids)){
			echo json_encode(['ok'=>1,'list'=>$list]);
			exit;
		}
	
		$ids_str = implode(',', $phongban_ids);
	
		// Lấy user thuộc các phòng ban này (trừ chính người nhận)
		$q = mysqli_query($conn,"SELECT user_id, name FROM user_info WHERE phong_ban IN ($ids_str) AND admin_cty='$admin_cty' AND user_id <> '$nguoi_nhan' ORDER BY user_id ASC");
		while($r = mysqli_fetch_assoc($q)){
			$list .= '<option value="'.$r['user_id'].'">'
				  . $r['name']
				  . '</option>';
		}
	
		echo json_encode([
			'ok'   => 1,
			'list' => $list
		]);
	
}else if($action=='giaoviec_tructiep'){
	$nguoi_nhan = addslashes($_REQUEST['nguoi_nhan']);
	$nguoi_giam_sat = addslashes($_REQUEST['nguoi_giam_sat']);
	$ten_cong_viec = addslashes($_REQUEST['ten_cong_viec']);
	$phong_ban_nhan = addslashes($_REQUEST['phong_ban_nhan']);
	$mo_ta = addslashes($_REQUEST['mo_ta']);
	$thoi_han = addslashes($_REQUEST['thoi_han']);
	$muc_do_uu_tien = addslashes($_REQUEST['muc_do_uu_tien']);
	$thoi_gian_nhan_viec = addslashes($_REQUEST['thoi_gian_nhan_viec']);
	$admin_cty = $user_info['admin_cty'];
	$id_nguoi_giao = $user_info['user_id'];
	$hientai = time();
	// Validation
	if($ten_cong_viec==''){
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên công việc';
	}else if($nguoi_nhan==''){
		$ok = 0;
		$thongbao = 'Vui lòng chọn người nhận việc';
	}else if($nguoi_giam_sat==''){
		$ok = 0;
		$thongbao = 'Vui lòng chọn người giám sát';
	}else if($phong_ban_nhan==''){
		$ok = 0;
		$thongbao = 'Vui lòng chọn phòng ban nhận';
	}else if($thoi_han==''){
		$ok = 0;
		$thongbao = 'Vui lòng nhập thời hạn công việc';
	
	}else{
		// Xử lý upload nhiều file
		$file_congviec = "";
		$list_file = array();
		if(!empty($_FILES['tep_dinh_kem']['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES['tep_dinh_kem']['name'] as $key => $filename){
				if(!empty($filename)){
					// Giữ nguyên tên file ban đầu
					$original_filename = $filename;
					$file_path = $upload_dir.$original_filename;
					
					// Nếu file đã tồn tại, thêm timestamp vào trước phần mở rộng
					if(file_exists($file_path)){
						$path_info = pathinfo($original_filename);
						$name_without_ext = $path_info['filename'];
						$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
						$original_filename = $name_without_ext.'_'.time().$ext;
						$file_path = $upload_dir.$original_filename;
					}
					
					$tmp_name = $_FILES['tep_dinh_kem']['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file[] = $original_filename;
					}
				}
			}
			
			if(count($list_file) > 0){
				$file_congviec = json_encode($list_file, JSON_UNESCAPED_UNICODE);
			}
		}
		mysqli_query($conn, "INSERT INTO giaoviec_tructiep (admin_cty, id_nguoi_nhan, id_nguoi_giao, id_nguoi_giamsat, ten_congviec, mo_ta_congviec, file_congviec, han_hoanthanh, thoigian_nhanviec, xacnhan_nhanviec, mucdo_uutien, lydo_nhan_muon, phantram_hoanthanh,miss_deadline, trang_thai, date_post, update_post) VALUES ('$admin_cty', '$nguoi_nhan', '$id_nguoi_giao', '$nguoi_giam_sat', '$ten_cong_viec', '$mo_ta', '$file_congviec', '$thoi_han', '$thoi_gian_nhan_viec', '0', '$muc_do_uu_tien', '', '0', '0', '0', '$hientai', '$hientai')");
		$id_congviec = mysqli_insert_id($conn);	
		
		if ($id_congviec > 0) {
			if (!empty($nguoi_nhan) && $nguoi_nhan != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$id_nguoi_giao', '$nguoi_nhan', '$id_congviec', ' Bạn có công việc mới', '0', 'giaoviec_tructiep','$hientai')");
			}
			if (!empty($nguoi_giam_sat) && $nguoi_giam_sat != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$id_nguoi_giao', '$nguoi_giam_sat', '$id_congviec', ' Bạn có công việc giám sát mới', '0', 'giaoviec_tructiep','$hientai')");
			}
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'created_task', '$ten_cong_viec', '', 'Tạo công việc mới', 'giaoviec_tructiep', '$hientai')");

			$ok = 1;
			$thongbao = 'Giao việc thành công';
		}else{
			$ok = 0;
			$thongbao = 'Giao việc thất bại';
		}
	}	
	$info = array(
		'id' => isset($id_congviec) ? $id_congviec : 0,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giamsat' => $nguoi_giam_sat,
		'nguoi_giao' => $id_nguoi_giao,
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='load_list_congviec_quanly'){	
	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_bat_dau = addslashes($_REQUEST['search_ngay_bat_dau']);
	$search_han_hoan_thanh = addslashes($_REQUEST['search_han_hoan_thanh']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];

	$list = $class_member->list_search_giaoviec_giao($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='load_list_congviec_cua_toi'){	
	
	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_bat_dau = addslashes($_REQUEST['search_ngay_bat_dau']);
	$search_han_hoan_thanh = addslashes($_REQUEST['search_han_hoan_thanh']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];

	$list = $class_member->list_search_giaoviec_nhan($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='load_list_congviec_giamsat'){
	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_bat_dau = addslashes($_REQUEST['search_ngay_bat_dau']);
	$search_han_hoan_thanh = addslashes($_REQUEST['search_han_hoan_thanh']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];

	$list = $class_member->list_search_giaoviec_giamsat($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='box_pop_view_giaoviec_tructiep'){

	$id = intval($_REQUEST['id']);
	$page_type = isset($_REQUEST['page_type']) ? addslashes($_REQUEST['page_type']) : '';
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id'");
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
	
	// Hiển thị footer khi người dùng là người nhận việc
	if($user_info['user_id'] == $r_tt['id_nguoi_nhan']){
		// Khởi tạo các biến
		$trang_thai = '';
		$xacnhan_congviec = '';
		$xin_giahan = '';
		$thoi_gian_hien_tai = time();
		$han_hoan_thanh = strtotime($r_tt['han_hoanthanh']);
		if($r_tt['miss_deadline'] == 1){
			$check_miss_deadline = "<button class='btn btn-danger check_miss_deadline' disabled><i class='fas fa-exclamation-triangle'></i> Miss Deadline</button>";
		}
		// Xử lý logic footer dựa trên trạng thái
		if ($r_tt['trang_thai'] == 0) {
			$trang_thai = 'Chờ xác nhận';
	
			// Tính thời gian đã trôi qua từ khi tạo
			$thoi_gian_da_troi_qua = time() - $r_tt['date_post']; // Thời gian đã trôi qua (giây)
			$thoi_gian_nhanviec_giay = intval($r_tt['thoigian_nhanviec']) * 60; // Chuyển phút thành giây

			if ($r_tt['xacnhan_nhanviec'] == 0) {
				if ($thoi_gian_da_troi_qua > $thoi_gian_nhanviec_giay) {
						$xacnhan_congviec = "<button class='btn btn-danger' id='box_pop_nhanviec_quahan' data-id='{$id}' > <i class='fas fa-exclamation-triangle'></i> Quá hạn</button>";
				} else {
						$xacnhan_congviec = "<button class='btn btn-draft' id='nhan_congviec_tructiep' data-id='{$id}'  > <i class='fas fa-check'></i>Nhận việc</button>";
				}
			} else {
				// Chỉ người được giao phó mới hiển thị nút
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
				
				$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
			}
			
		} else if ($r_tt['trang_thai'] == 1) {
			$trang_thai = 'Đang thực hiện';
			$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";

			$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
	
		}else if ($r_tt['trang_thai'] == 2) {
			$trang_thai = 'Chờ phê duyệt';
			$xacnhan_congviec = "<button class='btn btn-draft' disabled data-id='{$id}' > <i class='fas fa-clock'></i> Chờ phê duyệt</button>";
		
		} else if ($r_tt['trang_thai'] == 4) {

			$trang_thai = 'Đã từ chối';
		
			// Nút thông báo trạng thái
			$xacnhan_congviec = "
				<button class='btn btn-danger' disabled>
					<i class='fas fa-times'></i> Đã từ chối
				</button>
			";
		
			// Nút gửi lại
			$xacnhan_congviec .= "
				<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' >
					<i class='fas fa-redo'></i> Gửi lại
				</button>
			";
		
	
				$xin_giahan = "
					<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' >
						<i class='fas fa-exclamation-triangle'></i> Xin gia hạn
					</button>
				";
		
		} else if ($r_tt['trang_thai'] == 5) {
			$trang_thai = 'Xin gia hạn';
			// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
			$xin_giahan = "<button class='btn btn-draft' disabled data-id='{$id}' >Đang xin gia hạn</button>";
			$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";

		} else if ($r_tt['trang_thai'] == 6) {
			$trang_thai = 'Đã hoàn thành';
			// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
			$xin_giahan = "<button class='btn btn-success' disabled data-id='{$id}'>Đã hoàn thành</button>";
		}
		
		// Xác định khi nào hiển thị footer
		$should_show_footer = false;
		
		// Nếu tự giao cho mình (người nhận = người giao HOẶC người nhận = người giám sát)
		if($r_tt['id_nguoi_nhan'] == $r_tt['id_nguoi_giao'] || $r_tt['id_nguoi_nhan'] == $r_tt['id_nguoi_giamsat']){
			// Chỉ hiển thị footer khi ở tab "người nhận"
			if($page_type == 'list-congviec-cua-toi'){
				$should_show_footer = true;
			}
		}else{
			// Người khác giao cho mình, luôn hiển thị footer
			$should_show_footer = true;
		}
		
		// Hiển thị footer nếu được phép
		if($should_show_footer){
			$f_nhanviec = array(
				'id' => $id,
				'trang_thai' => $trang_thai,
				'xacnhan_congviec' => $xacnhan_congviec,
				'xin_giahan' => $xin_giahan,
				'check_miss_deadline' => $check_miss_deadline
			);
			// Chỉ lấy phần nút bên phải (không có cấu trúc footer và nút lịch sử)
			$r_tt['footer_action'] = $skin->skin_replace('skin_members/footer_nhanviec_right',$f_nhanviec);
		}else{
			$r_tt['footer_action'] = '';
		}
	}else{
		$r_tt['footer_action'] = '';
	}
	// Xử lý ngay_batdau - có thể là timestamp hoặc chuỗi date
	if(!empty($r_tt['date_post'])){
		if(is_numeric($r_tt['date_post'])){
			$r_tt['ngay_bat_dau'] = date('d/m/Y H:i', intval($r_tt['date_post']));
		} else {
			$timestamp = strtotime($r_tt['date_post']);
			$r_tt['ngay_bat_dau'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
		}
	} else {
		$r_tt['ngay_bat_dau'] = '';
	}
	
	// Xử lý han_hoanthanh - có thể là timestamp hoặc chuỗi date
	if(!empty($r_tt['han_hoanthanh'])){
		if(is_numeric($r_tt['han_hoanthanh'])){
			$r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
			$r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
		} else {
			$timestamp = strtotime($r_tt['han_hoanthanh']);
			$r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
			$r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
		}
	} else {
		$r_tt['han_hoan_thanh'] = '';
		$r_tt['deadline_timestamp'] = 0;
	}
	
	$r_tt['ngay_cap_nhat'] = !empty($r_tt['date_update']) ? date('d/m/Y H:i', intval($r_tt['date_update'])) : '';
	
	// Format trạng thái
	$r_tt['trang_thai_raw'] = $r_tt['trang_thai'];
	switch ($r_tt['trang_thai']) {
		case 0:
			$r_tt['trang_thai_text'] = 'Chờ xử lý';
			break;
		case 1:
			$r_tt['trang_thai_text'] = 'Đang triển khai';
			break;
		case 2:
			$r_tt['trang_thai_text'] = 'Chờ phê duyệt';
			break;
		case 3:
			$r_tt['trang_thai_text'] = 'Miss Deadline';
			break;
		case 4:
			$r_tt['trang_thai_text'] = 'Từ chối';
			break;
		case 5:
			$r_tt['trang_thai_text'] = 'Xin gia hạn';
			break;
		case 6:
			$r_tt['trang_thai_text'] = 'Đã hoàn thành';
			break;
		default:
			$r_tt['trang_thai_text'] = 'Không xác định';
			break;
	}
	
	// Format mức độ ưu tiên
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
		$r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
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
						<span class="file_name">'.$file_name.'</span>
					</div>
					<a href="'.$file_url.'" download>
						<i class="fa fa-download"></i> Tải về
					</a>
				</div>';
			}
		}
		if(!empty($file_list)){
			$file_section = '<div class="box_pop_view_giaoviec_section">
				<h6 class="box_pop_view_giaoviec_section_title">File đính kèm</h6>
				<div class="file_list">'.$file_list.'</div>
			</div>';
		}
	}
	$r_tt['file_section'] = $file_section;
	
	$html = $skin->skin_replace('skin_members/box_action/box_pop_view_giaoviec_tructiep',$r_tt);
	$info = array(
		'html' => $html,
		'deadline_timestamp' => isset($r_tt['deadline_timestamp']) ? $r_tt['deadline_timestamp'] : 0,
		'id' => $id,
		'type' => 'giaoviec_tructiep'
	);
	echo json_encode($info);

}else if($action=='box_pop_edit_giaoviec_tructiep'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$thongtin_user = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}'");
		$r_nguoi_nhan = mysqli_fetch_assoc($thongtin_user);
		$id_phongban_nhan = $r_nguoi_nhan['phong_ban'];
		$admin_cty = $user_info['admin_cty'];

		$r_tt['option_phongban'] = $class_member->list_option_edit_phongban($conn, $admin_cty, $id_phongban_nhan);
		$r_tt['option_nguoi_nhan'] = $class_member->list_option_edit_nguoi_nhan($conn, $admin_cty,$id_phongban_nhan, $r_tt['id_nguoi_nhan']);
		$r_tt['option_nguoi_giamsat'] = $class_member->list_option_edit_nguoi_giamsat($conn, $admin_cty, $r_tt['id_nguoi_giamsat'], $r_tt['id_nguoi_nhan']);

		if(!empty($r_tt['han_hoanthanh'])){
			if(is_numeric($r_tt['han_hoanthanh'])){
				$r_tt['han_hoan_thanh_value'] = date('Y-m-d\TH:i', intval($r_tt['han_hoanthanh']));
			} else {
				$timestamp = strtotime($r_tt['han_hoanthanh']);
				$r_tt['han_hoan_thanh_value'] = $timestamp ? date('Y-m-d\TH:i', $timestamp) : '';
			}
		} else {
			$r_tt['han_hoan_thanh_value'] = '';
		}
		
		// Set selected cho mức độ ưu tiên
		$mucdo_uutien = !empty($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
		$r_tt['selected_thap'] = ($mucdo_uutien == 'thap') ? 'selected' : '';
		$r_tt['selected_binh_thuong'] = ($mucdo_uutien == 'binh_thuong') ? 'selected' : '';
		$r_tt['selected_cao'] = ($mucdo_uutien == 'cao') ? 'selected' : '';
		$r_tt['selected_rat_cao'] = ($mucdo_uutien == 'rat_cao') ? 'selected' : '';
		
		// Lấy thời gian nhận việc
		$r_tt['thoi_gian_nhan_viec'] = !empty($r_tt['thoi_gian_nhan_viec']) ? intval($r_tt['thoi_gian_nhan_viec']) : 60;
		
		// Xử lý file đính kèm hiện có
		$file_list_existing = '';
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
			
			$file_list_html = '';
			foreach($files as $file){
				// Loại bỏ khoảng trắng, dấu ngoặc kép, dấu ngoặc đơn
				$file = trim($file, ' "\'[]');
				if(!empty($file)){
					$file_name = basename($file);
					$file_url = '/uploads/giaoviec/file_congviec_tructiep/'.$file;
					$file_list_html .= '<div class="file_item">
						<div class="file_item_name">
							<i class="fa fa-file"></i>
							<span title="'.$file_name.'">'.$file_name.'</span>
						</div>
						<div style="display: flex; gap: 8px; align-items: center;">
							<a href="'.$file_url.'" download style="color: #0062a0; text-decoration: none;">
								<i class="fa fa-download"></i>
							</a>
							<button type="button" class="file_item_remove" data-file="'.htmlspecialchars($file).'" style="background: none; border: none; color: #e53e3e; cursor: pointer; padding: 6px 12px; border-radius: 8px; transition: all 0.2s ease;">
								<i class="fa fa-times"></i>
							</button>
						</div>
					</div>';
				}
			}
			if(!empty($file_list_html)){
				$file_list_existing = '<div style="margin-bottom: 16px;">
					<label style="font-size: 14px; font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">File hiện có:</label>
					<div class="file_list">'.$file_list_html.'</div>
				</div>';
			}
		}
		$r_tt['file_list_existing'] = $file_list_existing;
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_edit_giaoviec_tructiep', $r_tt);
	}
	$info = array(
		'ok' => isset($ok) ? $ok : 1,
		'thongbao' => isset($thongbao) ? $thongbao : '',
		'html' => isset($html) ? $html : ''
	);
	echo json_encode($info);
}else if($action=='update_giaoviec_tructiep'){

	$id = intval($_REQUEST['id']);
	$nguoi_nhan = addslashes($_REQUEST['nguoi_nhan']);
	$nguoi_giamsat = addslashes($_REQUEST['nguoi_giamsat']);
	$ten_congviec = addslashes($_REQUEST['ten_congviec']);
	$phong_ban_nhan = addslashes($_REQUEST['phong_ban_nhan']);
	$mo_ta = addslashes($_REQUEST['mo_ta']);
	$han_hoanthanh = addslashes($_REQUEST['han_hoanthanh']);
	$mucdo_uutien = addslashes($_REQUEST['mucdo_uutien']);
	$thoi_gian_nhan_viec = addslashes($_REQUEST['thoi_gian_nhan_viec']);
	$admin_cty = $user_info['admin_cty'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Validation
		if(trim($ten_congviec) == ''){
			$ok = 0;
			$thongbao = 'Vui lòng nhập tên công việc';
		}else if($nguoi_nhan == ''){
			$ok = 0;
			$thongbao = 'Vui lòng chọn người nhận việc';
		}else if($nguoi_giamsat == ''){
			$ok = 0;
			$thongbao = 'Vui lòng chọn người giám sát';
		}else if($phong_ban_nhan == ''){
			$ok = 0;
			$thongbao = 'Vui lòng chọn phòng ban nhận';
		}else{
			// Lấy thông tin file cũ
			$r_old = mysqli_fetch_assoc($thongtin);
			$nguoi_giao = $r_old['id_nguoi_giao'];
			$thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$nguoi_giao'");
			$r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
			$ten_nguoi_giao = $r_nguoi_giao['name'];
			$ten_congviec_old = !empty($r_old['ten_congviec']) ? $r_old['ten_congviec'] : '';
			$file_congviec_old = !empty($r_old['file_congviec']) ? $r_old['file_congviec'] : '';
			$list_file_old = array();
			if(!empty($file_congviec_old)){
				// Kiểm tra xem file_congviec có phải là JSON không
				$decoded = json_decode($file_congviec_old, true);
				if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
					// Là JSON array
					$list_file_old = $decoded;
				}else{
					// Là comma-separated string
					// Loại bỏ dấu ngoặc vuông, ngoặc kép và khoảng trắng
					$cleaned = trim($file_congviec_old, '[]"\'');
					$list_file_old = explode(',', $cleaned);
					$list_file_old = array_filter(array_map(function($file){
						return trim($file, ' "\'[]');
					}, $list_file_old));
				}
			}
			
			// Xử lý file mới upload
			$list_file_new = array();
			if(!empty($_FILES['tep_dinh_kem']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['tep_dinh_kem']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên: với file trên server hoặc trong danh sách file cũ
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_old) || in_array($original_filename, $list_file_new)){
							$path_info = pathinfo($filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['tep_dinh_kem']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_new[] = $original_filename;
						}
					}
				}
			}
			
			// Kết hợp file cũ và file mới
			$list_file_all = array_merge($list_file_old, $list_file_new);
			// Lưu file dưới dạng JSON để nhất quán với code tạo mới
			$file_congviec = !empty($list_file_all)
			? json_encode($list_file_all, JSON_UNESCAPED_UNICODE)
			: '';
					
			
			// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
			$old_value = $ten_congviec_old;
			$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='updated_task' AND action='giaoviec_tructiep' ORDER BY date_post DESC LIMIT 1");
			if(mysqli_num_rows($thongtin_log) > 0){
				$r_log = mysqli_fetch_assoc($thongtin_log);
				$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : $ten_congviec_old;
			}
			
			// Update database
			$update_query = "UPDATE giaoviec_tructiep SET 
				id_nguoi_nhan='$nguoi_nhan',
				id_nguoi_giamsat='$nguoi_giamsat',
				ten_congviec='$ten_congviec',
				mo_ta_congviec='$mo_ta',
				file_congviec='$file_congviec',
				han_hoanthanh='$han_hoanthanh',
				thoigian_nhanviec='$thoi_gian_nhan_viec',
				mucdo_uutien='$mucdo_uutien',
				update_post='$hientai'
				WHERE id='$id' AND admin_cty='$admin_cty'";

			$noidung = $ten_nguoi_giao . ' vừa update công việc';
			if (!empty($nguoi_nhan) && $nguoi_nhan != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$nguoi_giao', '$nguoi_nhan', '$id', '$noidung', '0', 'giaoviec_tructiep','$hientai')");
			}
			if (!empty($nguoi_giamsat) && $nguoi_giamsat != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$nguoi_giao', '$nguoi_giamsat', '$id', '$noidung' ,'0', 'giaoviec_tructiep','$hientai')");
			}
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'updated_task', '$ten_congviec', '$old_value', 'Cập nhật công việc', 'giaoviec_tructiep', '$hientai')");

			if(mysqli_query($conn, $update_query)){
				$ok = 1;
				$thongbao = 'Cập nhật công việc thành công';
				
			}else{
				$ok = 0;
				$thongbao = 'Có lỗi xảy ra khi cập nhật công việc';
			}
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat
	);
	echo json_encode($info);
}else if($action=='box_pop_delete_giaoviec_tructiep'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
	
		$html = $skin->skin_replace('skin_members/box_action/box_pop_delete_giaoviec_tructiep', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => isset($thongbao) ? $thongbao : '',
		'html' => isset($html) ? $html : ''
	);
	echo json_encode($info);
}else if($action=='delete_giaoviec_tructiep'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();


	// Lấy thông tin công việc trước khi xóa
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total > 0){
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ten_congviec = $r_tt['ten_congviec'];
		$list_nhanvien = implode(',', array_unique([
			$r_tt['id_nguoi_giamsat'],
			$r_tt['id_nguoi_giao'],
			$r_tt['id_nguoi_nhan']
		]));
		$nguoi_nhan = $r_tt['id_nguoi_nhan'];
		$nguoi_giao = $r_tt['id_nguoi_giao'];
		$nguoi_giamsat = $r_tt['id_nguoi_giamsat'];
		
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='deleted_task' AND phan_loai='giaoviec_tructiep' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		if(mysqli_query($conn, "DELETE FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'")){
			$noidung = 'Công việc "' . $ten_congviec . '" đã bị xóa';
			if (!empty($nguoi_nhan) && $nguoi_nhan != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$nguoi_giao', '$nguoi_nhan', '$id', '$noidung', '0', 'giaoviec_tructiep','$hientai')");
			}
			if (!empty($nguoi_giamsat) && $nguoi_giamsat != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$nguoi_giao', '$nguoi_giamsat', '$id', '$noidung' ,'0', 'giaoviec_tructiep','$hientai')");
			}			
			// Ghi log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'deleted_task', '$ten_congviec', '$old_value', 'Xóa công việc', 'giaoviec_tructiep', '$hientai')");
	
			$ok = 1;
			$thongbao = 'Xóa công việc thành công';
		} else {
			$ok = 0;
			$thongbao = 'Không thể xóa công việc';
		}
	}else{
		$ok = 0;
		$thongbao = 'Xóa công việc thất bại';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => $list_nhanvien
	);
	echo json_encode($info);

}else if($action=='nhan_congviec_tructiep'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Lấy thông tin công việc trước khi update
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$nguoi_nhan=$r_tt['id_nguoi_nhan'];
		$nguoi_giao=$r_tt['id_nguoi_giao'];
		$nguoi_giamsat=$r_tt['id_nguoi_giamsat'];
		$ten_congviec = $r_tt['ten_congviec'];
		
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='accepted_task' AND phan_loai='$action_nhanviec' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}

		// Cập nhật trạng thái
		mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai=1, xacnhan_nhanviec=1, update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'accepted_task', '$ten_congviec', '$old_value', 'Nhận công việc', '$action_nhanviec', '$hientai')");
		
		$ok = 1;
		$thongbao = 'Nhận công việc thành công';
	}
	
	$info = array(
		'ok' => $ok,
		'id' => $id,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

}else if($action=='box_pop_nhanviec_quahan'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$r_tt['nhanviec_quahan'] = 'nhanviec_quahan_tructiep';
		$html = $skin->skin_replace('skin_members/box_action/box_pop_nhanviec_quahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='nhanviec_quahan_tructiep'){
	$id = intval($_REQUEST['id']);
	$ly_do_nhan_muon = isset($_REQUEST['ly_do_nhan_muon']) ? addslashes($_REQUEST['ly_do_nhan_muon']) : '';

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Validation
		if(trim($ly_do_nhan_muon) == ''){
			$ok = 0;
			$thongbao = 'Vui lòng nhập lý do nhận việc muộn';
		}else{
			// Lấy thông tin công việc
			$r_tt = mysqli_fetch_assoc($thongtin);
			$ten_congviec = $r_tt['ten_congviec'];
			$nguoi_nhan = $r_tt['id_nguoi_nhan'];
			$nguoi_giao = $r_tt['id_nguoi_giao'];
			$nguoi_giamsat = $r_tt['id_nguoi_giamsat'];
			
			// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
			$old_value = '';
			$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='accepted_late' AND phan_loai='giaoviec_tructiep' ORDER BY date_post DESC LIMIT 1");
			if(mysqli_num_rows($thongtin_log) > 0){
				$r_log = mysqli_fetch_assoc($thongtin_log);
				$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
			}
			
			// Cập nhật trạng thái và lý do
			mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai=1, xacnhan_nhanviec=1, lydo_nhan_muon='$ly_do_nhan_muon', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
			
			// Ghi log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'accepted_late', '$ten_congviec', '$old_value', '$ly_do_nhan_muon', 'giaoviec_tructiep', '$hientai')");
			
			$ok = 1;
			$thongbao = 'Nhận công việc thành công.';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
	);
	echo json_encode($info);
}else if($action=='box_pop_capnhat_trangthai'){
	
	$id = intval($_REQUEST['id']);
	$action_capnhat_trangthai = isset($_REQUEST['action_capnhat_trangthai']) ? addslashes($_REQUEST['action_capnhat_trangthai']) : '';
	$admin_cty = $user_info['admin_cty'];
	if ($action_capnhat_trangthai == 'giaoviec_tructiep') {
		$table = 'giaoviec_tructiep';
		$capnhat_trangthai = 'capnhat_trangthai_tructiep';
	}else if ($action_capnhat_trangthai == 'giaoviec_du_an') {
		$table = 'congviec_du_an';
		$capnhat_trangthai = 'capnhat_trangthai_du_an';
	}
	$thongtin = mysqli_query($conn, "SELECT * FROM $table WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		// Lấy thông tin người nhận
		if(!empty($r_tt['id_nguoi_nhan'])){
			$thongtin_nguoi_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}'");
			if(mysqli_num_rows($thongtin_nguoi_nhan) > 0){
				$r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
				$r_tt['ten_nguoi_nhan'] = !empty($r_nguoi_nhan['name']) ? $r_nguoi_nhan['name'] : 'Không xác định';
			} else {
				$r_tt['ten_nguoi_nhan'] = 'Không xác định';
			}
		} else {
			$r_tt['ten_nguoi_nhan'] = 'Chưa xác định';
		}
		
		// Lấy phần trăm hoàn thành
		$r_tt['phantram_hoanthanh'] = !empty($r_tt['phantram_hoanthanh']) ? intval($r_tt['phantram_hoanthanh']) : 0;
		$r_tt['capnhat_trangthai'] = $capnhat_trangthai;
		$r_tt['action_capnhat_trangthai'] = $action_capnhat_trangthai;
		$html = $skin->skin_replace('skin_members/box_action/box_pop_capnhat_trangthai', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='capnhat_trangthai_tructiep'){

	$id = intval($_REQUEST['id']);
	$tien_do_hoan_thanh = isset($_REQUEST['tien_do_hoan_thanh']) ? intval($_REQUEST['tien_do_hoan_thanh']) : 0;
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Đảm bảo phần trăm trong khoảng 0-100
	if($tien_do_hoan_thanh < 0) $tien_do_hoan_thanh = 0;
	if($tien_do_hoan_thanh > 100) $tien_do_hoan_thanh = 100;
	
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Lấy thông tin công việc
		$r_tt = mysqli_fetch_assoc($thongtin);
		$nguoi_nhan = $r_tt['id_nguoi_nhan'];
		$nguoi_giao = $r_tt['id_nguoi_giao'];
		$nguoi_giamsat = $r_tt['id_nguoi_giamsat'];
		
		// Xử lý file đính kèm (chỉ lưu file mới người dùng upload)
		$list_file_new = array();
		if(!empty($_FILES['tep_dinh_kem']['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_baocao/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES['tep_dinh_kem']['name'] as $key => $filename){
				if(!empty($filename)){
					// Giữ nguyên tên file ban đầu
					$original_filename = $filename;
					$file_path = $upload_dir.$original_filename;
					
					// Kiểm tra trùng tên
					$counter = 0;
					while(file_exists($file_path) || in_array($original_filename, $list_file_new)){
						$path_info = pathinfo($original_filename);
						$name_without_ext = $path_info['filename'];
						$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
						if($counter == 0){
							$original_filename = $name_without_ext.'_'.time().$ext;
						}else{
							$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
						}
						$file_path = $upload_dir.$original_filename;
						$counter++;
					}
					
					$tmp_name = $_FILES['tep_dinh_kem']['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file_new[] = $original_filename;
					}
				}
			}
		}
		
		// Chỉ lưu file mới vào file_congviec (file cũ sẽ được lưu vào lichsu_baocao)
		$file_congviec = !empty($list_file_new)
		? json_encode($list_file_new, JSON_UNESCAPED_UNICODE)
		: '';
			
		// Xác định trạng thái dựa trên phần trăm hoàn thành
		if($tien_do_hoan_thanh == 100){
			
			$trang_thai_lichsu = 0;

			mysqli_query($conn, "UPDATE giaoviec_tructiep SET 
			trang_thai=2,
			update_post='$hientai'
			WHERE id='$id' AND admin_cty='$admin_cty'");
		}else{
			if($r_tt['trang_thai'] == 5){
				mysqli_query($conn, "UPDATE giaoviec_tructiep SET phantram_hoanthanh='$tien_do_hoan_thanh',trang_thai='5',update_post='$hientai'WHERE id='$id' AND admin_cty='$admin_cty'");	
			}
			else{
				mysqli_query($conn, "UPDATE giaoviec_tructiep SET phantram_hoanthanh='$tien_do_hoan_thanh',trang_thai='1',update_post='$hientai'WHERE id='$id' AND admin_cty='$admin_cty'");	
			}
			$trang_thai_lichsu = 3;
		}
		
		

		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='updated_progress' AND phan_loai='giaoviec_tructiep' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		// Ghi log
		$new_value = $tien_do_hoan_thanh;

		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'updated_progress', '$ghi_chu', '$old_value', '$new_value', 'giaoviec_tructiep', '$hientai')");
		mysqli_query($conn, "INSERT INTO lichsu_baocao(admin_cty,id_congviec,user_id,tiendo_hoanthanh,file_congviec,ghi_chu_capnhat,trang_thai,ghichu_cua_sep,file_congviec_sep,action,date_post) VALUES ('$admin_cty', '$id', '$user_id', '$tien_do_hoan_thanh', '$file_congviec', '$ghi_chu', '$trang_thai_lichsu', '', '', 'giaoviec_tructiep', '$hientai')");
		$ok = 1;
		$thongbao = 'Cập nhật trạng thái thành công';
	}

	$info = array(
		'ok' => $ok,
		'id' => $id,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

}else if($action=='box_pop_lichsu_baocao'){
	
	$id = intval($_REQUEST['id']);
	$page_type = isset($_REQUEST['page_type']) ? $_REQUEST['page_type'] : '';
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
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
		$r_tt['list_lichsu_baocao'] = $class_member->list_lichsu_baocao($conn, $admin_cty, $id, $user_info['user_id']);
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_lichsu_baocao', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);

}else if($action=='box_pop_duyet'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$admin_cty = $user_info['admin_cty'];
	$action_baocao = isset($_REQUEST['action_baocao']) ? $_REQUEST['action_baocao'] : '';
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='$action_baocao'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop duyệt báo cáo';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		if($action_baocao == 'giaoviec_tructiep'){
			$r_tt['duyet_baocao'] = 'duyet_baocao_tructiep';
			$r_tt['tuchoi_baocao'] = 'tuchoi_baocao_tructiep';
		}else if($action_baocao == 'giaoviec_du_an'){
			$r_tt['duyet_baocao'] = 'duyet_baocao_du_an';
			$r_tt['tuchoi_baocao'] = 'tuchoi_baocao_du_an';
		}
		$html = $skin->skin_replace('skin_members/box_action/box_pop_duyet', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='duyet_baocao_tructiep'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';

			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];
				$trang_thai = $r_congviec['trang_thai'];
				$nguoi_giao = $r_congviec['id_nguoi_giao'];
				$nguoi_nhan = $r_congviec['id_nguoi_nhan'];
				$nguoi_giamsat = $r_congviec['id_nguoi_giamsat'];
			}
			
			
			// Xử lý file đính kèm của sếp
			$list_file_sep = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_sep)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_sep[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_sep)
			? json_encode($list_file_sep, JSON_UNESCAPED_UNICODE)
			: '';
					
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();
			$new_value = 'Duyệt báo cáo';

				mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai='6', phantram_hoanthanh='100', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
		
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value', 'giaoviec_tructiep', '$hientai')");

			// Cập nhật lịch sử báo cáo
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='1', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
			
			// Ghi log vào task_log
			
			
			
			$ok = 1;
			$thongbao = 'Duyệt báo cáo thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'id' => $id_congviec,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giamsat' => $nguoi_giamsat,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if($action=='tuchoi_baocao_tructiep'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';

			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];
				$trang_thai = $r_congviec['trang_thai'];
				$nguoi_giao = $r_congviec['id_nguoi_giao'];
				$nguoi_nhan = $r_congviec['id_nguoi_nhan'];
				$nguoi_giamsat = $r_congviec['id_nguoi_giamsat'];
			}
			
			
			// Xử lý file đính kèm của sếp
			$list_file_sep = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_sep)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_sep[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_sep) ? json_encode($list_file_sep) : '';
			
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();
			$new_value = 'Duyệt báo cáo';

				
			mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
			
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'rejected_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value', 'giaoviec_tructiep', '$hientai')");

			// Cập nhật lịch sử báo cáo
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='2', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
			
			// Ghi log vào task_log
			
			
			
			$ok = 1;
			$thongbao = 'Từ chối duyệt báo cáo thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'id' => $id_congviec,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giamsat' => $nguoi_giamsat,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if($action=='box_pop_nhanxet'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$action_baocao = isset($_REQUEST['action_baocao']) ? $_REQUEST['action_baocao'] : '';
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='$action_baocao'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop duyệt báo cáo';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		if($action_baocao == 'giaoviec_tructiep'){
			$r_tt['nhanxet_baocao'] = 'nhanxet_baocao_tructiep';
		}else if($action_baocao == 'giaoviec_du_an'){
			$r_tt['nhanxet_baocao'] = 'nhanxet_baocao_du_an';
		}
		$html = $skin->skin_replace('skin_members/box_action/box_pop_nhanxet', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='nhanxet_baocao_tructiep'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			// Lấy thông tin công việc để ghi log
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';

			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];
				$nguoi_giao = $r_congviec['id_nguoi_giao'];
				$nguoi_nhan = $r_congviec['id_nguoi_nhan'];
				$nguoi_giamsat = $r_congviec['id_nguoi_giamsat'];
				
			}
			
			// Xử lý file đính kèm của sếp
			$list_file_nhanxet = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_nhanxet)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_nhanxet[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_nhanxet)
			? json_encode($list_file_nhanxet, JSON_UNESCAPED_UNICODE)
			: '';
					
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();

			// Cập nhật lịch sử báo cáo
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='4', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
			
			// Ghi log vào task_log
			$new_value = 'Nhận xét báo cáo';
			
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value',' giaoviec_tructiep', '$hientai')");
			
			$ok = 1;
			$thongbao = 'Nhận xét báo cáo thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giamsat' => $nguoi_giamsat,
		'id' => $id_congviec
	);
	echo json_encode($info);
}else if($action=='box_pop_view_baocao'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$action_baocao = isset($_REQUEST['action_baocao']) ? $_REQUEST['action_baocao'] : '';
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='$action_baocao'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop xem báo cáo';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		// Format ngày báo cáo
		$r_tt['date_post'] = !empty($r_tt['date_post']) ? date('d/m/Y H:i', $r_tt['date_post']) : '-';
		
		// Format tiến độ hoàn thành
		$tiendo_value = intval($r_tt['tiendo_hoanthanh']);
		$r_tt['tiendo_hoanthanh'] = $tiendo_value;
		
		// Xác định class CSS theo khoảng tiến độ
		if($tiendo_value >= 0 && $tiendo_value < 50){
			$r_tt['tiendo_class'] = 'progress_low';
		}elseif($tiendo_value >= 50 && $tiendo_value < 70){
			$r_tt['tiendo_class'] = 'progress_medium';
		}elseif($tiendo_value >= 70 && $tiendo_value < 90){
			$r_tt['tiendo_class'] = 'progress_good';
		}else{
			$r_tt['tiendo_class'] = 'progress_complete';
		}
		
		// Format trạng thái
		$r_tt['trang_thai_raw'] = $r_tt['trang_thai'];
		switch($r_tt['trang_thai']){
			case 0:
				$r_tt['trang_thai_text'] = 'Chờ duyệt';
				break;
			case 1:
				$r_tt['trang_thai_text'] = 'Đã duyệt';
				break;
			case 2:
				$r_tt['trang_thai_text'] = 'Từ chối';
				break;
			case 3:
				$r_tt['trang_thai_text'] = 'Chờ nhận xét';
				break;
			case 4:
				$r_tt['trang_thai_text'] = 'Đã nhận xét';
				break;
			default:
				$r_tt['trang_thai_text'] = 'Không xác định';
				break;
		}
		
		// Lấy tên người báo cáo
		$r_tt['ten_nguoi_baocao'] = 'Không xác định';
		if(!empty($r_tt['user_id'])){
			$thongtin_user = mysqli_query($conn, "SELECT name FROM user_info WHERE user_id='{$r_tt['user_id']}' LIMIT 1");
			if(mysqli_num_rows($thongtin_user) > 0){
				$r_user = mysqli_fetch_assoc($thongtin_user);
				$r_tt['ten_nguoi_baocao'] = !empty($r_user['name']) ? $r_user['name'] : 'Không xác định';
			}
		}
		
		// Format ghi chú cập nhật
		$r_tt['ghi_chu_capnhat'] = !empty($r_tt['ghi_chu_capnhat']) ? htmlspecialchars($r_tt['ghi_chu_capnhat']) : '';
		
		// Xử lý file đính kèm của người báo cáo
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
				// Loại bỏ khoảng trắng, dấu ngoặc kép, dấu ngoặc đơn
				$file = trim($file, ' "\'[]');
				if(!empty($file)){
					$file_name = basename($file);
					$file_url = '/uploads/giaoviec/file_baocao/'.$file;
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
				$file_section = '<div class="box_pop_view_baocao_section">
					<h6 class="box_pop_view_baocao_section_title">File đính kèm</h6>
					<div class="file_list">'.$file_list.'</div>
				</div>';
			}
		}
		$r_tt['file_section'] = $file_section;
		
		// Xử lý phản hồi từ quản lý
		$phan_hoi_section = '';
		$has_phan_hoi = false;
		$phan_hoi_content = '';
		
		// Kiểm tra ghi chú của sếp
		if(!empty($r_tt['ghichu_cua_sep'])){
			$has_phan_hoi = true;
			$phan_hoi_content .= '<div class="phan_hoi_content">'.nl2br(htmlspecialchars($r_tt['ghichu_cua_sep'])).'</div>';
		}
		
		// Kiểm tra file của sếp
		if(!empty($r_tt['file_congviec_sep'])){
			$files_sep = array();
			
			// Thử decode JSON trước
			$decoded_sep = json_decode($r_tt['file_congviec_sep'], true);
			if(json_last_error() === JSON_ERROR_NONE && is_array($decoded_sep)){
				$files_sep = $decoded_sep;
			}else{
				$cleaned_sep = trim($r_tt['file_congviec_sep'], '[]"\'');
				$files_sep = explode(',', $cleaned_sep);
			}
			
			$file_list_sep = '';
			foreach($files_sep as $file_sep){
				$file_sep = trim($file_sep, ' "\'[]');
				if(!empty($file_sep)){
					$file_name_sep = basename($file_sep);
					$file_url_sep = '/uploads/giaoviec/file_congviec_tructiep/'.$file_sep;
					$file_list_sep .= '<div class="file_item">
						<div class="file_item_left">
							<i class="fa fa-file"></i>
							<span class="file_name">'.htmlspecialchars($file_name_sep).'</span>
						</div>
						<a href="'.$file_url_sep.'" download>
							<i class="fa fa-download"></i> Tải về
						</a>
					</div>';
				}
			}
			if(!empty($file_list_sep)){
				$has_phan_hoi = true;
				$phan_hoi_content .= '<div style="margin-top: 12px;">
					<div style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">File đính kèm:</div>
					<div class="file_list">'.$file_list_sep.'</div>
				</div>';
			}
		}
		
		if($has_phan_hoi){
			$phan_hoi_section = '<div class="box_pop_view_baocao_section">
				<h6 class="box_pop_view_baocao_section_title">Phản hồi từ quản lý</h6>
				<div class="phan_hoi_section">
					'.$phan_hoi_content.'
				</div>
			</div>';
		}
		$r_tt['phan_hoi_section'] = $phan_hoi_section;
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_baocao', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_giahan'){
	
	$id = intval($_REQUEST['id']);
	$action_giahan = isset($_REQUEST['action_giahan']) ? addslashes($_REQUEST['action_giahan']) : '';
	$admin_cty = $user_info['admin_cty'];
	if ($action_giahan == 'giaoviec_tructiep') {
		$table = 'giaoviec_tructiep';
		$giahan_congviec = 'giahan_tructiep';
	}else if ($action_giahan == 'giaoviec_du_an') {
		$table = 'congviec_du_an';
		$giahan_congviec = 'giahan_du_an';
	}
	$thongtin = mysqli_query($conn, "SELECT * FROM $table WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop gia hạn';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$r_tt['action_giahan'] = $action_giahan;
		$r_tt['han_hientai'] = !empty($r_tt['han_hoanthanh'])? date('Y-m-d H:i:s', strtotime($r_tt['han_hoanthanh'])): '';
		$r_tt['giahan_congviec'] = $giahan_congviec;
		$html = $skin->skin_replace('skin_members/box_action/box_pop_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='giahan_tructiep'){
	$id = intval($_REQUEST['id']);
	$han_sau_giahan = isset($_REQUEST['han_sau_giahan']) ? addslashes($_REQUEST['han_sau_giahan']) : '';
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Lấy thông tin công việc
		$r_tt = mysqli_fetch_assoc($thongtin);
		$nguoi_nhan = $r_tt['id_nguoi_nhan'];
		$nguoi_giao = $r_tt['id_nguoi_giao'];
		$nguoi_giamsat = $r_tt['id_nguoi_giamsat'];
		$time_old = $r_tt['han_hoanthanh'];
		mysqli_query($conn, "UPDATE giaoviec_tructiep SET  trang_thai=5, update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		mysqli_query($conn, "INSERT INTO lichsu_giahan(admin_cty,id_congviec,user_id,lydo_giahan,time_old,time_new,trang_thai,ghichu_cua_sep,action,date_post) VALUES ('$admin_cty', '$id', '$user_id', '$ghi_chu', '$time_old', '$han_sau_giahan', '0', '', 'giaoviec_tructiep','$hientai')");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'request_extend', '$ghi_chu', '$time_old', '$han_sau_giahan', 'giaoviec_tructiep', '$hientai')");
		$ok = 1;
		$thongbao = 'Xin gia hạn thành công';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
	);
	echo json_encode($info);
}else if($action=='giahan_du_an'){
	$id = intval($_REQUEST['id']);
	$han_sau_giahan = isset($_REQUEST['han_sau_giahan']) ? addslashes($_REQUEST['han_sau_giahan']) : '';
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Lấy thông tin công việc
		$r_tt = mysqli_fetch_assoc($thongtin);
		$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$r_tt[id_du_an]' AND admin_cty='$admin_cty'");
		$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
		$list_nhanvien = implode(',', array_unique([
			$r_du_an['user_id'],
			$r_tt['id_nguoi_giao'],
			$r_tt['id_nguoi_nhan']
		]));

		if($r_tt['parent_id'] == 0){
			$id_du_an = $r_tt['id_du_an'];
			mysqli_query($conn, "UPDATE du_an SET trang_thai=5, update_post='$hientai' WHERE id='$id_du_an' AND admin_cty='$admin_cty'");
		}

		$time_old = $r_tt['han_hoanthanh'];
		mysqli_query($conn, "UPDATE congviec_du_an SET  trang_thai=5, update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		mysqli_query($conn, "INSERT INTO lichsu_giahan(admin_cty,id_congviec,user_id,lydo_giahan,time_old,time_new,trang_thai,ghichu_cua_sep,action,date_post) VALUES ('$admin_cty', '$id', '$user_id', '$ghi_chu', '$time_old', '$han_sau_giahan', '0', '', 'giaoviec_du_an','$hientai')");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'request_extend', '$ghi_chu', '$time_old', '$han_sau_giahan', 'giaoviec_du_an', '$hientai')");
		$ok = 1;
		$thongbao = 'Xin gia hạn thành công';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'list_nhanvien' => $list_nhanvien,
	);
	echo json_encode($info);
}else if($action=='box_pop_lichsu_giahan'){
	
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
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
		$r_tt['list_lichsu_giahan'] = $class_member->list_lichsu_giahan($conn,$user_info['user_id'], $admin_cty, $id);
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_lichsu_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_view_giahan'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_giahan
	$action_giahan = isset($_REQUEST['action_giahan']) ? $_REQUEST['action_giahan'] : '';
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='$action_giahan'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop xem yêu cầu gia hạn';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		
		// Lấy thông tin công việc để lấy hạn hoàn thành
		$id_congviec = $r_tt['id_congviec'];
		if($action_giahan == 'giaoviec_tructiep'){
			$thongtin_giaoviec = mysqli_query($conn, "SELECT han_hoanthanh FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_giaoviec) > 0){
				$r_giaoviec = mysqli_fetch_assoc($thongtin_giaoviec);
				$r_tt['han_hoanthanh'] = date('d/m/Y H:i', strtotime($r_giaoviec['han_hoanthanh']));
			} else {
				$r_tt['han_hoanthanh'] = '-';
			}
		}else if($action_giahan == 'giaoviec_du_an'){
			$thongtin_giaoviec = mysqli_query($conn, "SELECT han_hoanthanh FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_giaoviec) > 0){
				$r_giaoviec = mysqli_fetch_assoc($thongtin_giaoviec);
				$r_tt['han_hoanthanh'] = date('d/m/Y H:i', strtotime($r_giaoviec['han_hoanthanh']));
			} else {
				$r_tt['han_hoanthanh'] = '-';
			}
		}else{
			$r_tt['han_hoanthanh'] = '-';
		}
		
		// Format thời gian gia hạn thêm
		if(!empty($r_tt['time_new'])){
			$r_tt['thoi_gian_giahan'] = date('d/m/Y H:i', strtotime($r_tt['time_new']));
		} else {
			$r_tt['thoi_gian_giahan'] = '-';
		}
		
		// Format trạng thái
		$r_tt['trang_thai_raw'] = $r_tt['trang_thai'];
		switch($r_tt['trang_thai']){
			case 0:
				$r_tt['trang_thai_text'] = 'Chờ duyệt';
				break;
			case 1:
				$r_tt['trang_thai_text'] = 'Đã duyệt';
				break;
			case 2:
				$r_tt['trang_thai_text'] = 'Từ chối';
				break;
			default:
				$r_tt['trang_thai_text'] = 'Không xác định';
				break;
		}
		
		
		// Format lý do gia hạn
		$r_tt['lydo_giahan'] = !empty($r_tt['lydo_giahan']) ? htmlspecialchars($r_tt['lydo_giahan']) : '';
		
		// Xử lý phản hồi từ quản lý (chỉ có ghi chú, không có file)
		$phan_hoi_section = '';
		if(!empty($r_tt['ghichu_cua_sep'])){
			$phan_hoi_section = '<div class="box_pop_view_giahan_section">
				<h6 class="box_pop_view_giahan_section_title">Phản hồi từ quản lý</h6>
				<div class="phan_hoi_section">
					<div class="phan_hoi_content">'.nl2br(htmlspecialchars($r_tt['ghichu_cua_sep'])).'</div>
				</div>
			</div>';
		}
		$r_tt['phan_hoi_section'] = $phan_hoi_section;
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_duyet_giahan_tructiep'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_giahan
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop duyệt yêu cầu gia hạn';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$r_tt['duyet_giahan'] = 'duyet_giahan_tructiep';
		$r_tt['tuchoi_giahan'] = 'tuchoi_giahan_tructiep';
		$html = $skin->skin_replace('skin_members/box_action/box_pop_duyet_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='duyet_giahan_tructiep'){
	
	$id = intval($_REQUEST['id']);
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		if($r_tt['trang_thai'] != 0){
			$ok = 0;
			$thongbao = 'Yêu cầu gia hạn này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];

			// Lấy thông tin công việc
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
			$ten_congviec = $r_congviec['ten_congviec'];
			$nguoi_nhan = $r_congviec['id_nguoi_nhan'];
			$nguoi_giao = $r_congviec['id_nguoi_giao'];
			$nguoi_giamsat = $r_congviec['id_nguoi_giamsat'];
			// Cập nhật hạn hoàn thành nếu có time_new
			if(!empty($r_tt['time_new'])){
				mysqli_query($conn, "UPDATE giaoviec_tructiep SET han_hoanthanh='{$r_tt['time_new']}', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
			}
			
			// Cập nhật trạng thái công việc về "Đang triển khai" (1) nếu đang là "Xin gia hạn" (5)
			mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty' AND trang_thai='5'");
			
			// Ghi log vào task_log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty, id_congviec, user_id, action, tieu_de, old_value, new_value, phan_loai, date_post) 
				VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_extend', '$ten_congviec', 'Xin gia hạn', 'Duyệt yêu cầu gia hạn', 'giaoviec_tructiep', '$hientai')");
			
			// Cập nhật lịch sử gia hạn
			mysqli_query($conn, "UPDATE lichsu_giahan SET trang_thai='1', ghichu_cua_sep='$ghichu_cua_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
			
			$ok = 1;
			$thongbao = 'Duyệt yêu cầu gia hạn thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id_congviec,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
	);
	echo json_encode($info);
}else if($action=='tuchoi_giahan_tructiep'){
	
	$id = intval($_REQUEST['id']);
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		if($r_tt['trang_thai'] != 0){
			$ok = 0;
			$thongbao = 'Yêu cầu gia hạn này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];

			// Lấy thông tin công việc
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
			$ten_congviec = $r_congviec['ten_congviec'];
			$nguoi_nhan = $r_congviec['id_nguoi_nhan'];
			$nguoi_giao = $r_congviec['id_nguoi_giao'];
			$nguoi_giamsat = $r_congviec['id_nguoi_giamsat'];
		
			// Cập nhật trạng thái công việc về "Đang triển khai" (1) nếu đang là "Xin gia hạn" (5)
			mysqli_query($conn, "UPDATE giaoviec_tructiep SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty' AND trang_thai='5'");
			
			// Ghi log vào task_log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty, id_congviec, user_id, action, tieu_de, old_value, new_value, phan_loai, date_post) 
				VALUES ('$admin_cty', '$id_congviec', '$user_id', 'rejected_extend', '$ten_congviec', 'Xin gia hạn', 'Từ chối yêu cầu gia hạn', 'giaoviec_tructiep', '$hientai')");
			
			// Cập nhật lịch sử gia hạn
			mysqli_query($conn, "UPDATE lichsu_giahan SET trang_thai='2', ghichu_cua_sep='$ghichu_cua_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep'");
			
			$ok = 1;
			$thongbao = 'Từ chối yêu cầu gia hạn thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id_congviec,
		'nguoi_nhan' => $nguoi_nhan,
		'nguoi_giao' => $nguoi_giao,
		'nguoi_giamsat' => $nguoi_giamsat,
	);
	echo json_encode($info);
}else if($action=='box_pop_view_lichsu_giaoviec'){

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
}else if($action=='add_thanh_vien'){
	$member_index = isset($_REQUEST['member_index']) ? intval($_REQUEST['member_index']) : 1;
	$thongbao = 'Thêm nhân viên thành công';
	$r_tt = array();
	$r_tt['member_index'] = $member_index;
	$r_tt['option_phongban'] = $class_member->list_option_phongban($conn, $user_info['admin_cty'], $user_info['user_id']);
	$html = $skin->skin_replace('skin_members/box_action/add_congviec_nhanvien', $r_tt);
	echo json_encode(array('ok' => 1, 'thongbao' => $thongbao, 'html' => $html));
}else if($action=='add_du_an'){
	
	$ten_du_an = isset($_REQUEST['ten_du_an']) ? addslashes($_REQUEST['ten_du_an']) : '';
	$mo_ta_du_an = isset($_REQUEST['mo_ta_du_an']) ? addslashes($_REQUEST['mo_ta_du_an']) : '';
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$muc_do_uu_tien = isset($_REQUEST['muc_do_uu_tien']) ? addslashes($_REQUEST['muc_do_uu_tien']) : '';
	$list_nhan_vien = isset($_REQUEST['list_nhan_vien']) ? json_decode($_REQUEST['list_nhan_vien'], true) : array();
	$hientai = time();

	if(empty($ten_du_an)){
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên dự án';
	}else if(empty($list_nhan_vien)){
		$ok = 0;
		$thongbao = 'Vui lòng thêm ít nhất một công việc';
	}

	$thongtin_du_an = mysqli_query($conn, "INSERT INTO du_an (
        admin_cty, user_id, ten_du_an, mucdo_uutien, mo_ta, ghi_chu, trang_thai,miss_deadline, date_post, update_post
    ) VALUES (
        '$user_info[admin_cty]', '$user_info[user_id]', '$ten_du_an', '$muc_do_uu_tien', '$mo_ta_du_an', '$ghi_chu', '0', '0', '$hientai', '$hientai'
    )");

	$id_du_an = mysqli_insert_id($conn);
	
	foreach ($list_nhan_vien as $index => $cv) {
		if(empty($cv['ten_cong_viec']) || empty($cv['phong_ban']) || empty($cv['nhan_vien']) || empty($cv['thoi_gian_nhan_viec']) || empty($cv['han_hoan_thanh'])){
			$ok = 0;
			$thongbao = 'Vui lòng nhập đầy đủ thông tin công việc thứ ' . ($index + 1) . ' của dự án';
		}
		
		$all_nhanvien[] = $cv['nhan_vien'];
		// Xử lý file đính kèm cho từng thành viên
		$file_congviec = "";
		$list_file = array();
		$file_key = 'file_dinh_kem_' . $index;
		
		if(!empty($_FILES[$file_key]['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_du_an/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES[$file_key]['name'] as $key => $filename){
				if(!empty($filename)){
					$path_info = pathinfo($filename);
					$name_without_ext = $path_info['filename'];
					$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
					$timestamp = time();
					$new_filename = $name_without_ext . '_' . $timestamp . $ext;
					$file_path = $upload_dir . $new_filename;
					
					$tmp_name = $_FILES[$file_key]['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file[] = $new_filename;
					}
				}
			}
			
			if(count($list_file) > 0){
				$file_congviec = json_encode($list_file);
			}
		}
		$thongtin_congviec_du_an = mysqli_query($conn, "INSERT INTO congviec_du_an (
            admin_cty, id_du_an, id_nguoi_nhan, id_nguoi_giao, parent_id, ten_congviec, mo_ta_congviec, ghi_chu, file_congviec,
            han_hoanthanh, thoigian_nhanviec, xacnhan_nhanviec, lydo_nhan_muon, mucdo_uutien, phantram_hoanthanh,miss_deadline,trang_thai, date_post, update_post
        ) VALUES (
            '$user_info[admin_cty]', '$id_du_an', '$cv[nhan_vien]', '$user_info[user_id]', '0', '$cv[ten_cong_viec]', '$cv[mo_ta_cong_viec]', '$cv[ghi_chu]', '$file_congviec',
            '$cv[han_hoan_thanh]', '$cv[thoi_gian_nhan_viec]', '0', '', '$cv[muc_do_uu_tien]', '0', '0', '0', '$hientai', '$hientai'
        )");

		mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$user_info[user_id]', '$cv[nhan_vien]', '$id_du_an', ' Bạn có công việc giám sát mới', '0', 'giaoviec_du_an','$hientai')");

	}

	if ($thongtin_congviec_du_an && mysqli_affected_rows($conn) > 0) {
		$ok = 1;
		$thongbao = 'Thêm công việc thành công';
	} else {
		$ok = 0;
		$thongbao = 'Thêm công việc thất bại';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id_du_an' => $id_du_an,
		'list_nhanvien' => implode(',', $all_nhanvien)
		
	);
	echo json_encode($info);
}else if($action=='load_list_du_an'){	
	$search_keyword = addslashes($_REQUEST['search_keyword']);
	$search_nguoi_quan_ly = addslashes($_REQUEST['search_nguoi_quan_ly']);
	$search_trang_thai = addslashes($_REQUEST['search_trang_thai']);
	$search_ngay_bat_dau = addslashes($_REQUEST['search_ngay_bat_dau']);
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	if($page < 1) $page = 1;

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];

	$list = $class_member->list_search_du_an($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_nguoi_quan_ly, $page, '10');
	$info=array(
		'list'=>$list,
		'page'=>$page,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='box_cai_dat_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		if($r_tt['user_id'] == $user_info['user_id']){
			$ok = 1;
		}else{
			$ok = 0;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if($action=='box_pop_view_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop xem chi tiết dự án';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		if($r_tt['user_id'] == $user_info['user_id']){
			$r_tt['hoatdong_nguoi_tao'] = 
			'<button type="button" name="box_thongke_du_an" class="box_thongke_du_an" data-id="'.$id.'">
              <i class="fa fa-chart-line"></i>
            </button>
            <button type="button" name="box_cai_dat" class="box_cai_dat" data-id="'.$id.'">
              <i class="fa fa-cog"></i>
            </button>';
		}else{
			$r_tt['hoatdong_nguoi_tao'] = '';
		}
		// Escape HTML cho các giá trị text
		$r_tt['ten_du_an'] = !empty($r_tt['ten_du_an']) ? htmlspecialchars($r_tt['ten_du_an']) : '';
		$r_tt['mo_ta'] = !empty($r_tt['mo_ta']) ? htmlspecialchars($r_tt['mo_ta']) : '';
		$r_tt['ghi_chu'] = !empty($r_tt['ghi_chu']) ? htmlspecialchars($r_tt['ghi_chu']) : '';
		
		// Format ngày tạo
		$r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d-m-Y', $r_tt['date_post']) : '-';
		
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
		
		if($r_tt['miss_deadline'] == 1){
			$r_tt['miss_deadline_text'] = '<span style="color: #dc3545; font-weight: 500; font-size: 13px; padding: 5px 10px;">Đã quá hạn</span>';
		} else {
			$r_tt['miss_deadline_text'] = '';
		}
		// Format trạng thái
		switch ($r_tt['trang_thai']) {
			case 0:
				$r_tt['trang_thai_text'] = 'Chờ xử lý';
				$r_tt['trang_thai_class'] = 'status_0';
				break;
			case 1:
				$r_tt['trang_thai_text'] = 'Đang triển khai';
				$r_tt['trang_thai_class'] = 'status_1';
				break;
			case 2:
				$r_tt['trang_thai_text'] = 'Chờ phê duyệt';
				$r_tt['trang_thai_class'] = 'status_2';
				break;
			case 3:
				$r_tt['trang_thai_text'] = 'Miss Deadline';
				$r_tt['trang_thai_class'] = 'status_3';
				break;
			case 4:
				$r_tt['trang_thai_text'] = 'Từ chối';
				$r_tt['trang_thai_class'] = 'status_4';
				break;
			case 5:
				$r_tt['trang_thai_text'] = 'Xin gia hạn';
				$r_tt['trang_thai_class'] = 'status_5';
				break;
			case 6:
				$r_tt['trang_thai_text'] = 'Hoàn thành';
				$r_tt['trang_thai_class'] = 'status_6';
				break;
			default:
				$r_tt['trang_thai_text'] = 'Không xác định';
				$r_tt['trang_thai_class'] = 'status_default';
				break;
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
		 
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_du_an', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_thongke_du_an'){
	
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ok = 1;
		$thongbao = 'Box pop thống kê dự án';
		$r_tt['id'] = $id;
		$tong_quan = $class_member->thongke_tongquan_congviec_theo_du_an($conn, $admin_cty, $id);
		$r_tt['tong_so_congviec'] = $tong_quan['tong_congviec_du_an'];
		$r_tt['tong_so_congviec_cho_xuly'] = $tong_quan['trangthai_cho_xuly'];
		$r_tt['tong_so_congviec_dang_thuchien'] = $tong_quan['trangthai_dang_thuchien'];
		$r_tt['tong_so_congviec_da_hoanthanh'] = $tong_quan['trangthai_da_hoanthanh'];
		$r_tt['tong_so_congviec_quahangthanh'] = $tong_quan['trangthai_miss_deadline'];
		$r_tt['tong_so_congviec_cho_duyet'] = $tong_quan['trangthai_cho_duyet'];
		$r_tt['tong_so_congviec_tuchoi'] = $tong_quan['trangthai_tuchoi'];
		$r_tt['tong_so_congviec_xin_giahan'] = $tong_quan['trangthai_xin_giahan'];
		$r_tt['list_thongke_nhanvien_du_an'] = $class_member->list_thongke_nhanvien_du_an($conn, $admin_cty, $id);
		$r_tt['list_thongke_congviec_quahan'] = $class_member->list_thongke_congviec_quahan($conn, $admin_cty, $id);
		$html = $skin->skin_replace('skin_members/box_action/box_thongke_du_an', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_view_congviec_du_an'){
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
		if($r_du_an['user_id'] != $user_info['user_id'] && $r_tt['id_nguoi_nhan'] != $user_info['user_id'] && $r_tt['id_nguoi_giao'] != $user_info['user_id']){
			$ok = 0;
			$thongbao = 'Bạn không có quyền xem chi tiết công việc dự án';
			$html = '';
		}else{
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

		if($user_info['user_id'] == $r_tt['id_nguoi_nhan']){
			$r_tt['button_giaopho'] = '<button type="button" class="btn btn-primary btn-sm" id="btn_add_giaoviec_giaopho" data-id="'.$id.'">
                                    <i class="fa fa-plus"></i>
                                    Thêm việc
                                </button>';
			// Khởi tạo các biến
			$trang_thai = '';
			$xacnhan_congviec = '';
			$xin_giahan = '';
			$thoi_gian_hien_tai = time();
			$han_hoan_thanh = strtotime($r_tt['han_hoanthanh']);
			if($r_tt['miss_deadline'] == 1){
				$check_miss_deadline = "<button class='btn btn-danger check_miss_deadline' disabled><i class='fas fa-exclamation-triangle'></i> Miss Deadline</button>";
			}
			
			// Xử lý logic footer dựa trên trạng thái
			if ($r_tt['trang_thai'] == 0) {
				$trang_thai = 'Chờ xác nhận';
		
				// Tính thời gian đã trôi qua từ khi tạo
				$thoi_gian_da_troi_qua = time() - $r_tt['date_post']; // Thời gian đã trôi qua (giây)
				$thoi_gian_nhanviec_giay = intval($r_tt['thoigian_nhanviec']) * 60; // Chuyển phút thành giây
		
				if ($r_tt['xacnhan_nhanviec'] == 0) {
					if ($thoi_gian_da_troi_qua > $thoi_gian_nhanviec_giay) {
							$xacnhan_congviec = "<button class='btn btn-danger' id='box_pop_nhanviec_du_an_quahan' data-id='{$id}' > <i class='fas fa-exclamation-triangle'></i> Quá hạn</button>";
					} else {
							$xacnhan_congviec = "<button class='btn btn-draft' id='nhan_congviec_du_an' data-id='{$id}'  > <i class='fas fa-check'></i>Nhận việc</button>";
					}
				} else {
					// Chỉ người được giao phó mới hiển thị nút
					$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
					
						$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
					
				}
			} else if ($r_tt['trang_thai'] == 1) {
				$trang_thai = 'Đang thực hiện';
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
			
					$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
				
			}else if ($r_tt['trang_thai'] == 2) {
				$trang_thai = 'Chờ phê duyệt';
				$xacnhan_congviec = "<button class='btn btn-draft' disabled data-id='{$id}' > <i class='fas fa-clock'></i> Chờ phê duyệt</button>";
			
			} else if ($r_tt['trang_thai'] == 4) {
		
				$trang_thai = 'Đã từ chối';
			
				// Nút thông báo trạng thái
				$xacnhan_congviec = "
					<button class='btn btn-danger' disabled>
						<i class='fas fa-times'></i> Đã từ chối
					</button>
				";
			
				// Nút gửi lại
				$xacnhan_congviec .= "
					<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' >
						<i class='fas fa-redo'></i> Gửi lại
					</button>
				";
			
				$xin_giahan = "
					<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' >
						<i class='fas fa-exclamation-triangle'></i> Xin gia hạn
					</button>
				";
			} else if ($r_tt['trang_thai'] == 5) {
				$trang_thai = 'Xin gia hạn';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-draft' disabled data-id='{$id}' >Đang xin gia hạn</button>";
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";

			} else if ($r_tt['trang_thai'] == 6) {
				$trang_thai = 'Đã hoàn thành';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-success' disabled data-id='{$id}'>Đã hoàn thành</button>";
			}
			
			// Hiển thị footer cho người nhận
			$f_nhanviec = array(
				'id' => $id,
				'trang_thai' => $trang_thai,
				'xacnhan_congviec' => $xacnhan_congviec,
				'xin_giahan' => $xin_giahan,
				'check_miss_deadline' => $check_miss_deadline
			);
			// Chỉ lấy phần nút bên phải (không có cấu trúc footer và nút lịch sử)
			$r_tt['footer_action'] = $skin->skin_replace('skin_members/footer_nhanviec_right',$f_nhanviec);
		}else{
			$r_tt['footer_action'] = '';
			$r_tt['button_giaopho'] = '';
		}

		$html = $skin->skin_replace('skin_members/box_action/box_pop_view_congviec_du_an', $r_tt);
		}

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
		if($r_du_an['user_id'] != $user_info['user_id'] && $r_tt['id_nguoi_nhan'] != $user_info['user_id'] && $r_tt['id_nguoi_giao'] != $user_info['user_id']){
			$ok = 0;
			$thongbao = 'Bạn không có quyền xem chi tiết công việc dự án';
			$html = '';
		}else{
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

	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='box_pop_view_lichsu_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty' AND trang_thai IN (3, 6)");
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
}else if($action=='box_pop_add_giaoviec_giaopho'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Công việc không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		// Kiểm tra quyền: chỉ người giao việc hoặc người nhận việc mới được thêm công việc giao phó
		if($r_tt['id_nguoi_nhan'] != $user_info['user_id']){
			$ok = 0;
			$thongbao = 'Bạn không có quyền thêm công việc giao phó';
			$html = '';
		}else{
			$ok = 1;
			$thongbao = 'Form thêm công việc giao phó';
			$r_tt['id_congviec'] = $r_tt['id_du_an'];
			$r_tt['parent_id'] = $id;
			$r_tt['option_phongban'] = $class_member->list_option_phongban($conn, $admin_cty, $user_info['user_id']);
			$html = $skin->skin_replace('skin_members/box_action/add_giaoviec_giaopho', $r_tt);
			
			// Thêm form thành viên đầu tiên
			$r_tt_member = array();
			$r_tt_member['member_index'] = 1;
			$r_tt_member['option_phongban'] = $r_tt['option_phongban'];
			$html_member = $skin->skin_replace('skin_members/box_action/add_congviec_nhanvien', $r_tt_member);
			$html = str_replace('<!-- Form thành viên đầu tiên sẽ được thêm vào đây -->', $html_member, $html);
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);

}else if($action=='add_giaoviec_giaopho'){
	$id_congviec = intval($_REQUEST['id_congviec']);
	$parent_id = intval($_REQUEST['parent_id']);
	$list_nhan_vien = isset($_REQUEST['list_nhan_vien']) ? json_decode($_REQUEST['list_nhan_vien'], true) : array();
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Lấy thông tin công việc cha
	$thongtin_cha = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$parent_id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin_cha);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Công việc cha không tồn tại';
		}else{
			$r_cha = mysqli_fetch_assoc($thongtin_cha);
			// Kiểm tra quyền
			if($r_cha['id_nguoi_nhan'] != $user_id){
				$ok = 0;
				$thongbao = 'Bạn không có quyền thêm công việc giao phó';
			}else{
			
				
				if(empty($list_nhan_vien) || !is_array($list_nhan_vien)){
					$ok = 0;
					$thongbao = 'Vui lòng thêm ít nhất một công việc';
				}else{
					$all_nhanvien = array();
					
					foreach ($list_nhan_vien as $index => $cv) {
						// Validation
						if(empty($cv['ten_cong_viec']) || empty($cv['phong_ban']) || empty($cv['nhan_vien']) || empty($cv['thoi_gian_nhan_viec']) || empty($cv['han_hoan_thanh'])){
							$ok = 0;
							$thongbao = 'Vui lòng nhập đầy đủ thông tin công việc thứ ' . ($index + 1);
							break;
						}
						
						$all_nhanvien[] = $cv['nhan_vien'];
						
						// Xử lý file đính kèm cho từng thành viên
						$file_congviec = "";
						$list_file = array();
						$file_key = 'file_dinh_kem_' . $index;
						
						if(!empty($_FILES[$file_key]['name'][0])){
							$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_du_an/";
							if(!is_dir($upload_dir)){
								mkdir($upload_dir, 0777, true);
							}
							
							foreach($_FILES[$file_key]['name'] as $key => $filename){
								if(!empty($filename)){
									$path_info = pathinfo($filename);
									$name_without_ext = $path_info['filename'];
									$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
									$timestamp = time();
									$new_filename = $name_without_ext . '_' . $timestamp . $ext;
									$file_path = $upload_dir . $new_filename;
									
									$tmp_name = $_FILES[$file_key]['tmp_name'][$key];
									
									if(move_uploaded_file($tmp_name, $file_path)){
										$list_file[] = $new_filename;
									}
								}
							}
							
							if(count($list_file) > 0){
								$file_congviec = json_encode($list_file);
							}
						}
						
						// Escape dữ liệu
						$ten_cong_viec = addslashes($cv['ten_cong_viec']);
						$mo_ta_cong_viec = isset($cv['mo_ta_cong_viec']) ? addslashes($cv['mo_ta_cong_viec']) : '';
						$ghi_chu = isset($cv['ghi_chu']) ? addslashes($cv['ghi_chu']) : '';
						$nhan_vien = intval($cv['nhan_vien']);
						$thoi_gian_nhan_viec = intval($cv['thoi_gian_nhan_viec']);
						$muc_do_uu_tien = isset($cv['muc_do_uu_tien']) ? addslashes($cv['muc_do_uu_tien']) : 'binh_thuong';
						$han_hoanthanh = $cv['han_hoan_thanh'];

						
						// Thêm công việc giao phó với parent_id là id công việc cha
						$thongtin_congviec_giaopho = mysqli_query($conn, "INSERT INTO congviec_du_an (
							admin_cty, id_du_an, id_nguoi_nhan, id_nguoi_giao, parent_id, ten_congviec, mo_ta_congviec, ghi_chu, file_congviec,
							han_hoanthanh, thoigian_nhanviec, xacnhan_nhanviec, lydo_nhan_muon, mucdo_uutien, phantram_hoanthanh,miss_deadline,trang_thai, date_post, update_post
						) VALUES (
							'$admin_cty', '$id_congviec', '$nhan_vien', '$user_id', '$parent_id', '$ten_cong_viec', '$mo_ta_cong_viec', '$ghi_chu', '$file_congviec',
							'$han_hoanthanh', '$thoi_gian_nhan_viec', '0', '', '$muc_do_uu_tien', '0', '0', '0', '$hientai', '$hientai'
						)");
						
						if($thongtin_congviec_giaopho && mysqli_affected_rows($conn) > 0){
							$id_congviec_moi = mysqli_insert_id($conn);
							
							// Gửi thông báo
							mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$user_id', '$nhan_vien', '$id_congviec_moi', ' Bạn có công việc giao phó mới', '0', 'giaoviec_du_an','$hientai')");
							
							// Ghi log
							mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec_moi', '$user_id', 'created_subtask', '$ten_cong_viec', '', 'Tạo công việc giao phó mới', 'giaoviec_du_an', '$hientai')");
						    $ok = 1;
							$thongbao = 'Thêm ' . count($list_nhan_vien) . ' công việc giao phó thành công';
						}
					}
					
				}
			}
		}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id_congviec_moi' => $id_congviec_moi,
		'list_nhanvien' => implode(',', $all_nhanvien)
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
}else if($action=='box_pop_nhanviec_du_an_quahan'){
	
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
		$r_tt['nhanviec_quahan'] = 'nhanviec_quahan_du_an';
		$html = $skin->skin_replace('skin_members/box_action/box_pop_nhanviec_quahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='nhanviec_quahan_du_an'){
	$id = intval($_REQUEST['id']);
	$ly_do_nhan_muon = isset($_REQUEST['ly_do_nhan_muon']) ? addslashes($_REQUEST['ly_do_nhan_muon']) : '';

	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Validation
		if(trim($ly_do_nhan_muon) == ''){
			$ok = 0;
			$thongbao = 'Vui lòng nhập lý do nhận việc muộn';
		}else{
			// Lấy thông tin công việc
			$r_tt = mysqli_fetch_assoc($thongtin);
			$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
			$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
			
			$list_nhanvien = implode(',', array_unique([
				$r_du_an['user_id'],
				$r_tt['id_nguoi_giao'],
				$r_tt['id_nguoi_nhan']
			]));
			if($r_tt['parent_id'] == 0){
				$parent_id = '0';
				mysqli_query($conn, "UPDATE du_an SET trang_thai=1, update_post='$hientai' WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
			}else{
				$parent_id = '';
			}
			$ten_congviec = $r_tt['ten_congviec'];

			// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
			$old_value = '';
			$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='accepted_late' AND phan_loai='giaoviec_du_an' ORDER BY date_post DESC LIMIT 1");
			if(mysqli_num_rows($thongtin_log) > 0){
				$r_log = mysqli_fetch_assoc($thongtin_log);
				$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
			}
			
			// Cập nhật trạng thái và lý do
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai=1, xacnhan_nhanviec=1, lydo_nhan_muon='$ly_do_nhan_muon', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");

			// Ghi log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'accepted_late', '$ten_congviec', '$old_value', '$ly_do_nhan_muon', 'giaoviec_du_an', '$hientai')");
			
			$ok = 1;
			$thongbao = 'Nhận công việc thành công.';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'list_nhanvien' => $list_nhanvien,
		'parent_id' => $parent_id
	);
	echo json_encode($info);
}else if($action=='box_pop_delete_du_an'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
	
		$html = $skin->skin_replace('skin_members/box_action/box_pop_delete_du_an', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => isset($thongbao) ? $thongbao : '',
		'html' => isset($html) ? $html : ''
	);
	echo json_encode($info);
}else if($action=='delete_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Lấy thông tin công việc trước khi xóa
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total > 0){
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ten_du_an = $r_tt['ten_du_an'];
		
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='deleted_task' AND phan_loai='giaoviec_du_an' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		// Xóa công việc
		mysqli_query($conn, "DELETE FROM du_an WHERE id='$id' AND admin_cty='$admin_cty'");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'deleted_task', '$ten_congviec', '$old_value', 'Xóa công việc', 'giaoviec_du_an', '$hientai')");
	}
	$ok = 1;
	$thongbao = 'Xóa dự án thành công';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='box_pop_edit_du_an'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop chỉnh sửa dự án';
		$r_tt = mysqli_fetch_assoc($thongtin);	
		$r_tt['id'] = $id;

		$mucdo_uutien = !empty($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
		$r_tt['selected_thap'] = ($mucdo_uutien == 'thap') ? 'selected' : '';
		$r_tt['selected_binh_thuong'] = ($mucdo_uutien == 'binh_thuong') ? 'selected' : '';
		$r_tt['selected_cao'] = ($mucdo_uutien == 'cao') ? 'selected' : '';
		$r_tt['selected_rat_cao'] = ($mucdo_uutien == 'rat_cao') ? 'selected' : '';
		
		$r_tt['list_nhanvien_du_an'] = $class_member->list_nhanvien_du_an($conn, $user_info['admin_cty'], $id);
	
		$html = $skin->skin_replace('skin_members/box_action/box_pop_edit_du_an', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' =>  $thongbao ,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='load_user_nhan_congviec_nhanvien'){
	$phong_ban_nhan = intval($_REQUEST['phong_ban_nhan']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE phong_ban='$phong_ban_nhan' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	$list = '';
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .='<option value="' . $r_tt['user_id'] . '">' . $r_tt['name'] . '</option>';
	}
	$info = array(
		'ok' => 1,
		'list' => '<option value="">Chọn người nhận việc</option>'.$list,
	);
	echo json_encode($info);
}else if($action=='delete_congviec'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Lấy thông tin công việc trước khi xóa
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total > 0){
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ten_congviec = $r_tt['ten_congviec'];
		
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='deleted_task' AND phan_loai='giaoviec_du_an' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		// Xóa công việc
		mysqli_query($conn, "DELETE FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'deleted_task', '$ten_congviec', '$old_value', 'Xóa công việc', 'giaoviec_du_an', '$hientai')");
	}
	$ok = 1;
	$thongbao = 'Xóa công việc thành công';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='nhan_congviec_du_an'){
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Lấy thông tin công việc trước khi update
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$ten_congviec = $r_tt['ten_congviec'];
		
		$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$r_tt[id_du_an]' AND admin_cty='$admin_cty'");
		$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
		$list_nhanvien = implode(',', array_unique([
			$r_du_an['user_id'],
			$r_tt['id_nguoi_giao'],
			$r_tt['id_nguoi_nhan']
		]));
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='accepted_task' AND phan_loai='$action_nhanviec' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		if($r_tt['parent_id'] == 0){
			$id_du_an = $r_tt['id_du_an'];
			mysqli_query($conn, "UPDATE du_an SET trang_thai=1, update_post='$hientai' WHERE id='$id_du_an' AND admin_cty='$admin_cty'");
		}
		// Cập nhật trạng thái
		mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai=1, xacnhan_nhanviec=1, update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		
		// Ghi log
		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'accepted_task', '$ten_congviec', '$old_value', 'Nhận công việc', '$action_nhanviec', '$hientai')");
		
		$ok = 1;
		$thongbao = 'Nhận công việc thành công';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => $list_nhanvien,
		'id' => $id
	);
	echo json_encode($info);
}else if($action=='capnhat_trangthai_du_an'){

	$id = intval($_REQUEST['id']);
	$tien_do_hoan_thanh = isset($_REQUEST['tien_do_hoan_thanh']) ? intval($_REQUEST['tien_do_hoan_thanh']) : 0;
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Đảm bảo phần trăm trong khoảng 0-100
	if($tien_do_hoan_thanh < 0) $tien_do_hoan_thanh = 0;
	if($tien_do_hoan_thanh > 100) $tien_do_hoan_thanh = 100;
	
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		// Lấy thông tin công việc
		$r_tt = mysqli_fetch_assoc($thongtin);
		$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$r_tt[id_du_an]' AND admin_cty='$admin_cty'");

		$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
		$nguoi_tao = $r_du_an['user_id'];
		$list_nhanvien = implode(',', array_unique([
			$nguoi_tao,
			$r_tt['id_nguoi_giao'],
			$r_tt['id_nguoi_nhan']
		]));		
		// Xử lý file đính kèm (chỉ lưu file mới người dùng upload)
		$list_file_new = array();
		if(!empty($_FILES['tep_dinh_kem']['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_baocao/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES['tep_dinh_kem']['name'] as $key => $filename){
				if(!empty($filename)){
					// Giữ nguyên tên file ban đầu
					$original_filename = $filename;
					$file_path = $upload_dir.$original_filename;
					
					// Kiểm tra trùng tên
					$counter = 0;
					while(file_exists($file_path) || in_array($original_filename, $list_file_new)){
						$path_info = pathinfo($original_filename);
						$name_without_ext = $path_info['filename'];
						$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
						if($counter == 0){
							$original_filename = $name_without_ext.'_'.time().$ext;
						}else{
							$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
						}
						$file_path = $upload_dir.$original_filename;
						$counter++;
					}
					
					$tmp_name = $_FILES['tep_dinh_kem']['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file_new[] = $original_filename;
					}
				}
			}
		}
		
		// Chỉ lưu file mới vào file_congviec (file cũ sẽ được lưu vào lichsu_baocao)
		$file_congviec = !empty($list_file_new)
		? json_encode($list_file_new, JSON_UNESCAPED_UNICODE)
		: '';
			
		if($tien_do_hoan_thanh == 100){
			$trang_thai = 2;
			$trang_thai_lichsu = 0;
			// Khi 100%, chỉ update trang_thai = 2, KHÔNG update phantram_hoanthanh
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai='$trang_thai', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		}else{
			$trang_thai = 1;
			$trang_thai_lichsu = 3;
			// Khi < 100%, update cả phantram_hoanthanh và trang_thai = 1
			mysqli_query($conn, "UPDATE congviec_du_an SET phantram_hoanthanh='$tien_do_hoan_thanh', trang_thai='$trang_thai', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
		}

		if($tien_do_hoan_thanh == 100 && $r_tt['parent_id'] == 0){
			$id_du_an = $r_tt['id_du_an'];
			
			// Kiểm tra xem có công việc nào đang chờ duyệt không
			$check_cho_duyet = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an 
				WHERE parent_id='0' AND id_du_an='$id_du_an' AND admin_cty='$admin_cty' AND trang_thai = 2");
			$r_check = mysqli_fetch_assoc($check_cho_duyet);
			
			// Nếu có công việc chờ duyệt, cập nhật dự án sang trạng thái 2
			if($r_check['total'] > 0){
				mysqli_query($conn, "UPDATE du_an SET trang_thai='2', update_post='$hientai' 
					WHERE id='$id_du_an' AND admin_cty='$admin_cty'");
			}
		}
		// Kiểm tra bảng log xem có dòng nào gần nhất giống admin_cty và id_congviec chưa
		$old_value = '';
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='updated_progress' AND phan_loai='giaoviec_du_an' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : '';
		}
		
		// Ghi log
		$new_value = $tien_do_hoan_thanh;

		mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'updated_progress', '$ghi_chu', '$old_value', '$new_value', 'giaoviec_du_an', '$hientai')");
		mysqli_query($conn, "INSERT INTO lichsu_baocao(admin_cty,id_congviec,user_id,tiendo_hoanthanh,file_congviec,ghi_chu_capnhat,trang_thai,ghichu_cua_sep,file_congviec_sep,action,date_post) VALUES ('$admin_cty', '$id', '$user_id', '$tien_do_hoan_thanh', '$file_congviec', '$ghi_chu', '$trang_thai_lichsu', '', '', 'giaoviec_du_an', '$hientai')");
		$ok = 1;
		$thongbao = 'Cập nhật trạng thái thành công';
	}

	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'list_nhanvien' => $list_nhanvien,
	);
	echo json_encode($info);
}else if($action=='duyet_baocao_du_an'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';
			
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];
				$trang_thai = $r_congviec['trang_thai'];
				
				$thongtin_du_an = mysqli_query($conn, "SELECT user_id FROM du_an WHERE id='$r_congviec[id_du_an]' AND admin_cty='$admin_cty'");
				$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
				$list_nhanvien = implode(',', array_unique([
					$r_du_an['user_id'],
					$r_congviec['id_nguoi_giao'],
					$r_congviec['id_nguoi_nhan']
				]));
			}
					
			
			// Xử lý file đính kèm của sếp
			$list_file_sep = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_sep)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_sep[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_sep)
			? json_encode($list_file_sep, JSON_UNESCAPED_UNICODE)
			: '';
					
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();
			$new_value = 'Duyệt báo cáo';
			
			
			
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai='6', phantram_hoanthanh='100', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
			

			if(isset($r_congviec['parent_id']) && $r_congviec['parent_id'] == 0 && isset($r_congviec['id_du_an'])){
				$id_du_an = $r_congviec['id_du_an'];
				
				$check_all_tasks = mysqli_query($conn, "SELECT COUNT(*) as total, 
					SUM(CASE 
						WHEN trang_thai = '6' AND phantram_hoanthanh = '100' THEN 1 
						ELSE 0 
					END) as completed 
					FROM congviec_du_an 
					WHERE parent_id='0' AND id_du_an='$id_du_an' AND admin_cty='$admin_cty'");
				$r_check = mysqli_fetch_assoc($check_all_tasks);
				
				if($r_check['total'] > 0 && $r_check['total'] == $r_check['completed']){
					mysqli_query($conn, "UPDATE du_an SET trang_thai='6', update_post='$hientai' WHERE id='$id_du_an' AND admin_cty='$admin_cty'");
				}
			}
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value', 'giaoviec_du_an', '$hientai')");
			
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='1', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");	
			
			$ok = 1;
			$thongbao = 'Duyệt báo cáo thành công';
		}
	}
		
	$info = array(
		'ok' => $ok,
		'id' => $id_congviec,
		'list_nhanvien' => $list_nhanvien,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if($action=='tuchoi_baocao_du_an'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';
			
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];
				$trang_thai = $r_congviec['trang_thai'];

				$thongtin_du_an = mysqli_query($conn, "SELECT user_id FROM du_an WHERE id='$r_congviec[id_du_an]' AND admin_cty='$admin_cty'");
				$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
				$list_nhanvien = implode(',', array_unique([
					$r_du_an['user_id'],
					$r_congviec['id_nguoi_giao'],
					$r_congviec['id_nguoi_nhan']
				]));
			}
					
			
			// Xử lý file đính kèm của sếp
			$list_file_sep = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_sep)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_sep[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_sep) ? json_encode($list_file_sep) : '';
			
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();
			$new_value = 'Từ chối duyệt báo cáo';
			
			
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
			

			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'rejected_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value', 'giaoviec_du_an', '$hientai')");
			
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='2', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");	
			
			$ok = 1;
			$thongbao = 'Từ chối duyệt báo cáo thành công';
		}
	}
		
	$info = array(
		'ok' => $ok,
		'id' => $id_congviec,
		'list_nhanvien' => $list_nhanvien,
		'thongbao' => $thongbao
	);
	echo json_encode($info);
}else if($action=='edit_du_an'){
	$id_du_an = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	$ten_du_an = isset($_REQUEST['ten_du_an']) ? addslashes($_REQUEST['ten_du_an']) : '';
	$mo_ta_du_an = isset($_REQUEST['mo_ta_du_an']) ? addslashes($_REQUEST['mo_ta_du_an']) : '';
	$ghi_chu = isset($_REQUEST['ghi_chu']) ? addslashes($_REQUEST['ghi_chu']) : '';
	$muc_do_uu_tien = isset($_REQUEST['muc_do_uu_tien']) ? addslashes($_REQUEST['muc_do_uu_tien']) : '';
	$list_nhan_vien = isset($_REQUEST['list_nhan_vien']) ? json_decode($_REQUEST['list_nhan_vien'], true) : array();
	$list_nhan_vien_edit = isset($_REQUEST['list_nhan_vien_edit']) ? json_decode($_REQUEST['list_nhan_vien_edit'], true) : array();
	$hientai = time();
	$ok = 1;
	$thongbao = 'Cập nhật dự án thành công';

	// Kiểm tra dữ liệu đầu vào
	if(empty($id_du_an)){
		$ok = 0;
		$thongbao = 'ID dự án không hợp lệ';
	} else if(empty($ten_du_an)){
		$ok = 0;
		$thongbao = 'Vui lòng nhập tên dự án';
	} 
	// Kiểm tra dự án có tồn tại không
	if($ok == 1){
		$check_du_an = mysqli_query($conn, "SELECT id FROM du_an WHERE id='$id_du_an' AND admin_cty='$user_info[admin_cty]'");
		if(mysqli_num_rows($check_du_an) == 0){
			$ok = 0;
			$thongbao = 'Dự án không tồn tại';
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id_du_an' AND admin_cty='$user_info[admin_cty]'");
			$r_du_an = mysqli_fetch_assoc($thongtin);
			$nguoi_tao = $r_du_an['user_id'];
			$list_nhanvien_congviec[] = $nguoi_tao;

			$thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$nguoi_tao'");
			$r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
			$ten_nguoi_tao = !empty($r_nguoi_tao['name']) ? $r_nguoi_tao['name'] : 'Không xác định';
				
			
		}
	}

	// Cập nhật thông tin dự án
	if($ok == 1){
		$thongtin_du_an = mysqli_query($conn, "UPDATE du_an SET 
			ten_du_an = '$ten_du_an', 
			mucdo_uutien = '$muc_do_uu_tien', 
			mo_ta = '$mo_ta_du_an', 
			ghi_chu = '$ghi_chu', 
			update_post = '$hientai'
		WHERE id = '$id_du_an' AND admin_cty = '$user_info[admin_cty]'");
		
		if(!$thongtin_du_an){
			$ok = 0;
			$thongbao = 'Cập nhật dự án thất bại';
		}
	}
	
	// Xử lý thêm công việc mới (list_nhan_vien)
	if($ok == 1 && !empty($list_nhan_vien)){
	foreach ($list_nhan_vien as $index => $cv) {
			// Validate dữ liệu
		if(empty($cv['ten_cong_viec']) || empty($cv['phong_ban']) || empty($cv['nhan_vien']) || empty($cv['thoi_gian_nhan_viec']) || empty($cv['han_hoan_thanh'])){
			$ok = 0;
				$thongbao = 'Vui lòng nhập đầy đủ thông tin công việc mới thứ ' . ($index + 1);
				break;
			}
			
			// Escape dữ liệu
			$ten_cong_viec = addslashes($cv['ten_cong_viec']);
			$mo_ta_cong_viec = isset($cv['mo_ta_cong_viec']) ? addslashes($cv['mo_ta_cong_viec']) : '';
			$ghi_chu_cv = isset($cv['ghi_chu']) ? addslashes($cv['ghi_chu']) : '';
			$nhan_vien = intval($cv['nhan_vien']);
			$thoi_gian_nhan_viec = intval($cv['thoi_gian_nhan_viec']);
			$han_hoan_thanh = $cv['han_hoan_thanh'];
			$muc_do_uu_tien_cv = isset($cv['muc_do_uu_tien']) ? addslashes($cv['muc_do_uu_tien']) : '';
		
			$list_nhanvien_congviec[] = $nhan_vien;
			// Xử lý file đính kèm cho công việc mới
		$file_congviec = "";
		$list_file = array();
		$file_key = 'file_dinh_kem_' . $index;
		
		if(!empty($_FILES[$file_key]['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_du_an/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES[$file_key]['name'] as $key => $filename){
				if(!empty($filename)){
					$path_info = pathinfo($filename);
					$name_without_ext = $path_info['filename'];
					$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
					$timestamp = time();
					$new_filename = $name_without_ext . '_' . $timestamp . $ext;
					$file_path = $upload_dir . $new_filename;
					
					$tmp_name = $_FILES[$file_key]['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file[] = $new_filename;
					}
				}
			}
			
			if(count($list_file) > 0){
				$file_congviec = json_encode($list_file, JSON_UNESCAPED_UNICODE);
			}
		}
		
		mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$user_info[user_id]', '$nhan_vien', '$id_du_an', ' Bạn có dự án mới', '0', 'giaoviec_du_an','$hientai')");

			// Thêm công việc mới
		$thongtin_congviec_du_an = mysqli_query($conn, "INSERT INTO congviec_du_an (
            admin_cty, id_du_an, id_nguoi_nhan, id_nguoi_giao, parent_id, ten_congviec, mo_ta_congviec, ghi_chu, file_congviec,
				han_hoanthanh, thoigian_nhanviec, xacnhan_nhanviec, lydo_nhan_muon, mucdo_uutien, phantram_hoanthanh,miss_deadline,trang_thai, date_post, update_post
        ) VALUES (
				'$user_info[admin_cty]', '$id_du_an', '$nhan_vien', '$user_info[user_id]', '0', '$ten_cong_viec', '$mo_ta_cong_viec', '$ghi_chu_cv', '$file_congviec',
				'$han_hoan_thanh', '$thoi_gian_nhan_viec', '0', '', '$muc_do_uu_tien_cv', '0', '0', '0', '$hientai', '$hientai'
        )");
			
			if(!$thongtin_congviec_du_an){
				$ok = 0;
				$thongbao = 'Thêm công việc mới thất bại';
				break;
	}
		}
	}

	// Xử lý sửa công việc đã có (list_nhan_vien_edit)
	if($ok == 1 && !empty($list_nhan_vien_edit)){
	foreach ($list_nhan_vien_edit as $index => $cv) {
			// Validate dữ liệu
			if(empty($cv['id']) || empty($cv['ten_cong_viec']) || empty($cv['phong_ban']) || empty($cv['nhan_vien']) || empty($cv['thoi_gian_nhan_viec']) || empty($cv['han_hoan_thanh'])){
			$ok = 0;
				$thongbao = 'Vui lòng nhập đầy đủ thông tin công việc sửa thứ ' . ($index + 1);
				break;
			}
		
			// Escape dữ liệu
			$id_congviec = intval($cv['id']);
			$ten_cong_viec = addslashes($cv['ten_cong_viec']);
			$mo_ta_cong_viec = isset($cv['mo_ta_cong_viec']) ? addslashes($cv['mo_ta_cong_viec']) : '';
			$ghi_chu_cv = isset($cv['ghi_chu']) ? addslashes($cv['ghi_chu']) : '';
			$nhan_vien = intval($cv['nhan_vien']);
			$thoi_gian_nhan_viec = intval($cv['thoi_gian_nhan_viec']);
			$han_hoan_thanh = $cv['han_hoan_thanh'];
			$muc_do_uu_tien_cv = isset($cv['muc_do_uu_tien']) ? addslashes($cv['muc_do_uu_tien']) : '';

			$list_nhanvien_congviec[] = $nhan_vien;
			// Lấy file cũ nếu có
			$file_congviec_old = "";
			$check_cv = mysqli_query($conn, "SELECT file_congviec FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$user_info[admin_cty]' AND id_du_an='$id_du_an'");
			if(mysqli_num_rows($check_cv) > 0){
				$r_cv_old = mysqli_fetch_assoc($check_cv);
				$file_congviec_old = $r_cv_old['file_congviec'];
		}
		
			// Xử lý file đính kèm mới cho công việc sửa
			$file_congviec = $file_congviec_old;
		$list_file = array();
			$file_key = 'file_dinh_kem_edit_' . $index;
			$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_du_an/";
			
			// Xử lý xóa file cũ nếu có
			$files_to_remove = isset($cv['files_to_remove']) && is_array($cv['files_to_remove']) ? $cv['files_to_remove'] : array();
			if(!empty($files_to_remove) && !empty($file_congviec_old)){
				$list_file_old = json_decode($file_congviec_old, true);
				if(is_array($list_file_old)){
					// Loại bỏ file bị xóa khỏi danh sách và xóa file khỏi thư mục
					foreach($list_file_old as $key => $filename){
						if(in_array($filename, $files_to_remove)){
							// Xóa file khỏi thư mục
							$file_path_to_delete = $upload_dir . $filename;
							if(file_exists($file_path_to_delete)){
								@unlink($file_path_to_delete);
							}
							// Loại bỏ khỏi mảng
							unset($list_file_old[$key]);
						}
					}
					// Cập nhật lại danh sách file sau khi xóa
					$list_file_old = array_values($list_file_old); // Re-index array
					$file_congviec_old = !empty($list_file_old)
					? json_encode($list_file_old, JSON_UNESCAPED_UNICODE)
					: "";
					$file_congviec = $file_congviec_old;
				}
			}
			
			// Xử lý upload file mới
		if(!empty($_FILES[$file_key]['name'][0])){
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
				
				// Merge với file cũ còn lại (sau khi đã xóa)
				if(!empty($file_congviec_old)){
					$list_file_old = json_decode($file_congviec_old, true);
					if(is_array($list_file_old)){
						$list_file = $list_file_old;
					}
				}
			
			foreach($_FILES[$file_key]['name'] as $key => $filename){
				if(!empty($filename)){
					$path_info = pathinfo($filename);
					$name_without_ext = $path_info['filename'];
					$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
					$timestamp = time();
					$new_filename = $name_without_ext . '_' . $timestamp . $ext;
					$file_path = $upload_dir . $new_filename;
					
					$tmp_name = $_FILES[$file_key]['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file[] = $new_filename;
					}
				}
			}
			
			if(count($list_file) > 0){
				$file_congviec = json_encode($list_file, JSON_UNESCAPED_UNICODE);
			}
		}
		$noidung = $ten_nguoi_tao . ' dã update dự án';
		mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$user_info[user_id]', '$nhan_vien', '$id_du_an', '$noidung', '0', 'giaoviec_du_an','$hientai')");
			
		// Cập nhật công việc
			$thongtin_congviec_du_an = mysqli_query($conn, "UPDATE congviec_du_an SET 
				ten_congviec = '$ten_cong_viec', 
				mo_ta_congviec = '$mo_ta_cong_viec', 
				ghi_chu = '$ghi_chu_cv', 
				file_congviec = '$file_congviec',
				id_nguoi_nhan = '$nhan_vien',
				han_hoanthanh = '$han_hoan_thanh', 
				thoigian_nhanviec = '$thoi_gian_nhan_viec', 
				mucdo_uutien = '$muc_do_uu_tien_cv', 
				trang_thai = '0',
				xacnhan_nhanviec = '0',
				update_post = '$hientai'
			WHERE id = '$id_congviec' AND admin_cty = '$user_info[admin_cty]' AND id_du_an = '$id_du_an'");

			if(!$thongtin_congviec_du_an){
				$ok = 0;
				$thongbao = 'Cập nhật công việc thất bại';
				break;
			}
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => implode(',', $list_nhanvien_congviec),
		'id_du_an' => $id_du_an
	);
	echo json_encode($info);

}else if($action=='box_pop_duyet_giahan_du_an'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_giahan
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$thongbao = 'Box pop duyệt yêu cầu gia hạn';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$r_tt['duyet_giahan'] = 'duyet_giahan_du_an';
		$r_tt['tuchoi_giahan'] = 'tuchoi_giahan_du_an';
		$html = $skin->skin_replace('skin_members/box_action/box_pop_duyet_giahan', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'html' => $html
	);
	echo json_encode($info);
}else if($action=='duyet_giahan_du_an'){
	
	$id = intval($_REQUEST['id']);
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		if($r_tt['trang_thai'] != 0){
			$ok = 0;
			$thongbao = 'Yêu cầu gia hạn này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];

			// Lấy thông tin công việc
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
			$ten_congviec = $r_congviec['ten_congviec'];
			$thongtin_du_an = mysqli_query($conn, "SELECT user_id FROM du_an WHERE id='$r_congviec[id_du_an]' AND admin_cty='$admin_cty'");
			$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
			$list_nhanvien = implode(',', array_unique([
				$r_du_an['user_id'],
				$r_congviec['id_nguoi_giao'],
				$r_congviec['id_nguoi_nhan']
			]));
			
			// Cập nhật hạn hoàn thành nếu có time_new
			if(!empty($r_tt['time_new'])){
				mysqli_query($conn, "UPDATE congviec_du_an SET han_hoanthanh='{$r_tt['time_new']}', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty'");
			}
			
			// Cập nhật trạng thái công việc về "Đang triển khai" (1) nếu đang là "Xin gia hạn" (5)
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty' AND trang_thai='5'");
			
			// Ghi log vào task_log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty, id_congviec, user_id, action, tieu_de, old_value, new_value, phan_loai, date_post) 
				VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_extend', '$ten_congviec', 'Xin gia hạn', 'Duyệt yêu cầu gia hạn', 'giaoviec_du_an', '$hientai')");
			
			// Cập nhật lịch sử gia hạn
			mysqli_query($conn, "UPDATE lichsu_giahan SET trang_thai='1', ghichu_cua_sep='$ghichu_cua_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
			
			$ok = 1;
			$thongbao = 'Duyệt yêu cầu gia hạn thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => $list_nhanvien,
		'id' => $id_congviec
	);
	echo json_encode($info);
}else if($action=='tuchoi_giahan_du_an'){
	
	$id = intval($_REQUEST['id']);
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		
		if($r_tt['trang_thai'] != 0){
			$ok = 0;
			$thongbao = 'Yêu cầu gia hạn này đã được xử lý';
		}else{
			$id_congviec = $r_tt['id_congviec'];

			// Lấy thông tin công việc
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
			$ten_congviec = $r_congviec['ten_congviec'];
			$thongtin_du_an = mysqli_query($conn, "SELECT user_id FROM du_an WHERE id='$r_congviec[id_du_an]' AND admin_cty='$admin_cty'");
			$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
			$list_nhanvien = implode(',', array_unique([
				$r_du_an['user_id'],
				$r_congviec['id_nguoi_giao'],
				$r_congviec['id_nguoi_nhan']
			]));
					
			// Cập nhật trạng thái công việc về "Đang triển khai" (1) nếu đang là "Xin gia hạn" (5)
			mysqli_query($conn, "UPDATE congviec_du_an SET trang_thai='1', update_post='$hientai' WHERE id='$id_congviec' AND admin_cty='$admin_cty' AND trang_thai='5'");
			
			// Ghi log vào task_log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty, id_congviec, user_id, action, tieu_de, old_value, new_value, phan_loai, date_post) 
				VALUES ('$admin_cty', '$id_congviec', '$user_id', 'rejected_extend', '$ten_congviec', 'Xin gia hạn', 'Từ chối yêu cầu gia hạn', 'giaoviec_du_an', '$hientai')");
			
			// Cập nhật lịch sử gia hạn
			mysqli_query($conn, "UPDATE lichsu_giahan SET trang_thai='2', ghichu_cua_sep='$ghichu_cua_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
			
			$ok = 1;
			$thongbao = 'Từ chối yêu cầu gia hạn thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => $list_nhanvien,
		'id' => $id_congviec
	);
	echo json_encode($info);
}else if($action=='nhanxet_baocao_du_an'){
	
	$id = intval($_REQUEST['id']); // id của lichsu_baocao
	$ghichu_cua_sep = isset($_REQUEST['ghichu_cua_sep']) ? addslashes($_REQUEST['ghichu_cua_sep']) : '';
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		// Kiểm tra trạng thái phải là 0 (chờ duyệt) hoặc 3 (chờ nhận xét)
		if($r_tt['trang_thai'] != 0 && $r_tt['trang_thai'] != 3){
			$ok = 0;
			$thongbao = 'Báo cáo này đã được xử lý';
		}else{
			// Lấy thông tin công việc để ghi log
			$id_congviec = $r_tt['id_congviec'];
			$ten_congviec = '';
			
			$thongtin_congviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id_congviec' AND admin_cty='$admin_cty' LIMIT 1");
			if(mysqli_num_rows($thongtin_congviec) > 0){
				$r_congviec = mysqli_fetch_assoc($thongtin_congviec);
				$ten_congviec = $r_congviec['ten_congviec'];

				$thongtin_du_an = mysqli_query($conn, "SELECT user_id FROM du_an WHERE id='$r_congviec[id_du_an]' AND admin_cty='$admin_cty'");
				$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
				$list_nhanvien = implode(',', array_unique([
					$r_du_an['user_id'],
					$r_congviec['id_nguoi_giao'],
					$r_congviec['id_nguoi_nhan']
				]));
			}
			
			// Xử lý file đính kèm của sếp
			$list_file_nhanxet = array();
			if(!empty($_FILES['file_congviec_sep']['name'][0])){
				$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_tructiep/";
				if(!is_dir($upload_dir)){
					mkdir($upload_dir, 0777, true);
				}
				
				foreach($_FILES['file_congviec_sep']['name'] as $key => $filename){
					if(!empty($filename)){
						// Giữ nguyên tên file ban đầu
						$original_filename = $filename;
						$file_path = $upload_dir.$original_filename;
						
						// Kiểm tra trùng tên
						$counter = 0;
						while(file_exists($file_path) || in_array($original_filename, $list_file_nhanxet)){
							$path_info = pathinfo($original_filename);
							$name_without_ext = $path_info['filename'];
							$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
							if($counter == 0){
								$original_filename = $name_without_ext.'_'.time().$ext;
							}else{
								$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
							}
							$file_path = $upload_dir.$original_filename;
							$counter++;
						}
						
						$tmp_name = $_FILES['file_congviec_sep']['tmp_name'][$key];
						
						if(move_uploaded_file($tmp_name, $file_path)){
							$list_file_nhanxet[] = $original_filename;
						}
					}
				}
			}
			
			// Lưu file vào file_congviec_sep (JSON format)
			$file_congviec_sep = !empty($list_file_nhanxet)
			? json_encode($list_file_nhanxet, JSON_UNESCAPED_UNICODE)
			: '';
					
			// Lấy trạng thái cũ để ghi log
			$trang_thai_cu = $r_tt['trang_thai'];
			$trang_thai_cu_text = '';
			if($trang_thai_cu == 0){
				$trang_thai_cu_text = 'Chờ duyệt';
			} else if($trang_thai_cu == 3){
				$trang_thai_cu_text = 'Chờ nhận xét';
			}
			
			$hientai = time();

			// Cập nhật lịch sử báo cáo
			mysqli_query($conn, "UPDATE lichsu_baocao SET trang_thai='4', ghichu_cua_sep='$ghichu_cua_sep', file_congviec_sep='$file_congviec_sep' WHERE id='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an'");
			
			// Ghi log vào task_log
			$new_value = 'Nhận xét báo cáo';
			
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id_congviec', '$user_id', 'approved_report', '$ten_congviec', '$trang_thai_cu_text', '$new_value',' giaoviec_du_an', '$hientai')");
			
			$ok = 1;
			$thongbao = 'Nhận xét báo cáo thành công';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list_nhanvien' => $list_nhanvien,
		'id' => $id_congviec
	);
	echo json_encode($info);
}else if($action=='box_pop_delete_congviec_nhanvien'){
	$id = intval($_REQUEST['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$ok = 1;
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
	
		$html = $skin->skin_replace('skin_members/box_action/box_pop_delete_congviec', $r_tt);
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => isset($thongbao) ? $thongbao : '',
		'html' => isset($html) ? $html : ''
	);
	echo json_encode($info);
}else if($action=='box_pop_edit_congviec_giaopho'){
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
		$thongbao = 'Box pop chỉnh sửa công việc giao phó';
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		// Lấy thông tin người nhận việc để biết phòng ban
		$id_phongban_nhan = 0;
		if(!empty($r_tt['id_nguoi_nhan'])){
			$thongtin_user = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
			if(mysqli_num_rows($thongtin_user) > 0){
				$r_nguoi_nhan = mysqli_fetch_assoc($thongtin_user);
				$id_phongban_nhan = intval($r_nguoi_nhan['phong_ban']);
			}
		}
		
		// Load option phòng ban
		$r_tt['option_phongban'] = $class_member->list_option_edit_phongban($conn, $admin_cty, $id_phongban_nhan);
		
		// Load option nhân viên
		$r_tt['option_nhan_vien'] = $class_member->list_option_edit_nguoi_nhan($conn, $admin_cty, $id_phongban_nhan, $r_tt['id_nguoi_nhan']);
		
		// Format tên công việc
		$r_tt['ten_congviec'] = !empty($r_tt['ten_congviec']) ? htmlspecialchars($r_tt['ten_congviec']) : '';
		
		// Format mô tả công việc
		$r_tt['mo_ta_congviec'] = !empty($r_tt['mo_ta_congviec']) ? htmlspecialchars($r_tt['mo_ta_congviec']) : '';
		
		// Format ghi chú
		$r_tt['ghi_chu'] = !empty($r_tt['ghi_chu']) ? htmlspecialchars($r_tt['ghi_chu']) : '';
		
		// Format hạn hoàn thành cho datetime-local
		if(!empty($r_tt['han_hoanthanh'])){
			if(is_numeric($r_tt['han_hoanthanh'])){
				$r_tt['han_hoan_thanh_value'] = date('Y-m-d\TH:i', intval($r_tt['han_hoanthanh']));
			} else {
				$timestamp = strtotime($r_tt['han_hoanthanh']);
				$r_tt['han_hoan_thanh_value'] = $timestamp ? date('Y-m-d\TH:i', $timestamp) : '';
			}
		} else {
			$r_tt['han_hoan_thanh_value'] = '';
		}
		
		// Lấy thời gian nhận việc
		$r_tt['thoi_gian_nhan_viec'] = !empty($r_tt['thoigian_nhanviec']) ? intval($r_tt['thoigian_nhanviec']) : 60;
		
		// Set selected cho mức độ ưu tiên
		$mucdo_uutien = !empty($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
		$r_tt['selected_thap'] = ($mucdo_uutien == 'thap') ? 'selected' : '';
		$r_tt['selected_binh_thuong'] = ($mucdo_uutien == 'binh_thuong') ? 'selected' : '';
		$r_tt['selected_cao'] = ($mucdo_uutien == 'cao') ? 'selected' : '';
		$r_tt['selected_rat_cao'] = ($mucdo_uutien == 'rat_cao') ? 'selected' : '';
		
		// Xử lý file đính kèm hiện có
		$file_list_existing = '';
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
			
			$file_list_html = '';
			foreach($files as $file){
				// Loại bỏ khoảng trắng, dấu ngoặc kép, dấu ngoặc đơn
				$file = trim($file, ' "\'[]');
				if(!empty($file)){
					$file_name = basename($file);
					$file_url = '/uploads/giaoviec/file_congviec_du_an/'.$file;
					$file_list_html .= '<div class="file_item_existing">
						<div class="file_item_existing_name">
							<i class="fa fa-file"></i>
							<span title="'.htmlspecialchars($file_name).'">'.htmlspecialchars($file_name).'</span>
						</div>
						<div class="file_item_existing_actions">
							<a href="'.$file_url.'" download class="file_item_existing_download" title="Tải về">
								<i class="fa fa-download"></i>
							</a>
							<button type="button" class="file_item_existing_remove" data-file="'.htmlspecialchars($file).'" data-id="'.$id.'" title="Xóa">
								<i class="fa fa-times"></i>
							</button>
						</div>
					</div>';
				}
			}
			if(!empty($file_list_html)){
				$file_list_existing = $file_list_html;
			}
		}
		$r_tt['file_list_existing'] = $file_list_existing;
		
		$html = $skin->skin_replace('skin_members/box_action/box_pop_edit_congviec_giaopho', $r_tt);
	}
	$info = array(
		'ok' => isset($ok) ? $ok : 1,
		'thongbao' => isset($thongbao) ? $thongbao : '',
		'html' => isset($html) ? $html : ''
	);
	echo json_encode($info);
}else if($action=='update_congviec_giaopho'){
	$id = intval($_REQUEST['id']);
	$ten_cong_viec = addslashes($_REQUEST['ten_cong_viec']);
	$phong_ban = addslashes($_REQUEST['phong_ban_congviec']);
	$nhan_vien = addslashes($_REQUEST['nhan_vien_congviec']);
	$han_hoan_thanh = addslashes($_REQUEST['han_hoan_thanh']);
	$thoi_gian_nhan_viec = addslashes($_REQUEST['thoi_gian_nhan_viec']);
	$mucdo_uutien = addslashes($_REQUEST['mucdo_uutien']);
	$mo_ta_cong_viec = addslashes($_REQUEST['mo_ta_cong_viec']);
	$ghi_chu = addslashes($_REQUEST['ghi_chu']);
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	
	// Kiểm tra record có tồn tại không
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
	}else{
		$r_old = mysqli_fetch_assoc($thongtin);
		$file_congviec_old = !empty($r_old['file_congviec']) ? $r_old['file_congviec'] : '';
		$list_file_old = array();
		
		// Xử lý file cũ
		if(!empty($file_congviec_old)){
			$decoded = json_decode($file_congviec_old, true);
			if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
				$list_file_old = $decoded;
			}else{
				$cleaned = trim($file_congviec_old, '[]"\'');
				$list_file_old = explode(',', $cleaned);
				$list_file_old = array_filter(array_map(function($file){
					return trim($file, ' "\'[]');
				}, $list_file_old));
			}
		}
		
		// Xóa file nếu có
		if(!empty($_REQUEST['files_to_remove'])){
			$files_to_remove = json_decode($_REQUEST['files_to_remove'], true);
			if(is_array($files_to_remove)){
				foreach($files_to_remove as $file_to_remove){
					$file_path = __DIR__."/../uploads/giaoviec/file_congviec_du_an/".$file_to_remove;
					if(file_exists($file_path)){
						unlink($file_path);
					}
					$list_file_old = array_filter($list_file_old, function($file) use ($file_to_remove){
						return $file != $file_to_remove;
					});
				}
			}
		}
		
		// Xử lý file mới upload
		$list_file_new = array();
		if(!empty($_FILES['tep_dinh_kem']['name'][0])){
			$upload_dir = __DIR__."/../uploads/giaoviec/file_congviec_du_an/";
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}
			
			foreach($_FILES['tep_dinh_kem']['name'] as $key => $filename){
				if(!empty($filename)){
					$original_filename = $filename;
					$file_path = $upload_dir.$original_filename;
					
					$counter = 0;
					while(file_exists($file_path) || in_array($original_filename, $list_file_old) || in_array($original_filename, $list_file_new)){
						$path_info = pathinfo($filename);
						$name_without_ext = $path_info['filename'];
						$ext = !empty($path_info['extension']) ? '.'.$path_info['extension'] : '';
						if($counter == 0){
							$original_filename = $name_without_ext.'_'.time().$ext;
						}else{
							$original_filename = $name_without_ext.'_'.time().'_'.$counter.$ext;
						}
						$file_path = $upload_dir.$original_filename;
						$counter++;
					}
					
					$tmp_name = $_FILES['tep_dinh_kem']['tmp_name'][$key];
					
					if(move_uploaded_file($tmp_name, $file_path)){
						$list_file_new[] = $original_filename;
					}
				}
			}
		}
		
		// Kết hợp file cũ và file mới
		$list_file_all = array_merge($list_file_old, $list_file_new);
		$file_congviec = !empty($list_file_all) ? json_encode($list_file_all, JSON_UNESCAPED_UNICODE) : '';
		
		// Convert han_hoan_thanh từ datetime-local format sang timestamp
		$han_hoan_thanh_timestamp = 0;
		if(!empty($han_hoan_thanh)){
			$han_hoan_thanh_formatted = str_replace('T', ' ', $han_hoan_thanh);
			$han_hoan_thanh_timestamp = strtotime($han_hoan_thanh_formatted);
			if($han_hoan_thanh_timestamp === false){
				$han_hoan_thanh_timestamp = 0;
			}
		}
		
		// Lấy thông tin người giao việc
		$id_nguoi_giao = $r_old['id_nguoi_giao'];
		$ten_congviec_old = !empty($r_old['ten_congviec']) ? $r_old['ten_congviec'] : '';
		
		// Lấy old_value từ task_log gần nhất
		$old_value = $ten_congviec_old;
		$thongtin_log = mysqli_query($conn, "SELECT new_value FROM task_log WHERE admin_cty='$admin_cty' AND id_congviec='$id' AND action='updated_task' AND phan_loai='giaoviec_du_an' ORDER BY date_post DESC LIMIT 1");
		if(mysqli_num_rows($thongtin_log) > 0){
			$r_log = mysqli_fetch_assoc($thongtin_log);
			$old_value = !empty($r_log['new_value']) ? $r_log['new_value'] : $ten_congviec_old;
		}
		
		// Update database
		$update_query = "UPDATE congviec_du_an SET 
			id_nguoi_nhan='$nhan_vien',
			ten_congviec='$ten_cong_viec',
			mo_ta_congviec='$mo_ta_cong_viec',
			ghi_chu='$ghi_chu',
			file_congviec='$file_congviec',
			han_hoanthanh='$han_hoan_thanh_timestamp',
			thoigian_nhanviec='$thoi_gian_nhan_viec',
			mucdo_uutien='$mucdo_uutien',
			update_post='$hientai'
			WHERE id='$id' AND admin_cty='$admin_cty'";
		
		if(mysqli_query($conn, $update_query)){
			// Ghi task_log
			mysqli_query($conn, "INSERT INTO task_log(admin_cty,id_congviec,user_id,action,tieu_de,old_value,new_value,phan_loai,date_post) VALUES ('$admin_cty', '$id', '$user_id', 'updated_task', '$ten_cong_viec', '$old_value', 'Cập nhật công việc giao phó', 'giaoviec_du_an', '$hientai')");
			
			// Gửi notification cho người nhận việc
			$noidung = 'Công việc giao phó đã được cập nhật';
			if (!empty($nhan_vien) && $nhan_vien != 0) {
				mysqli_query($conn, "INSERT INTO notification (user_id,user_nhan,id_congviec,noi_dung,doc,phan_loai,date_post) VALUES ('$id_nguoi_giao', '$nhan_vien', '$id', '$noidung', '0', 'giaoviec_du_an','$hientai')");
			}
			$list_nhanvien[] = $nhan_vien;
			$ok = 1;
			$thongbao = 'Cập nhật công việc giao phó thành công';
		}else{
			$ok = 0;
			$thongbao = 'Có lỗi xảy ra khi cập nhật công việc';
		}
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'id' => $id,
		'list_nhanvien' => implode(',', $list_nhanvien)
	);
	echo json_encode($info);
///////////////////////////////////////
// phân trang
}else if($action=='load_list_giaoviec_tructiep_giao'){

	$page = intval($_REQUEST['page']);
	$limit = 5;
	$user_id = $user_info['user_id'];

	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'giao');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_giao($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
		$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	
	$info = array(
		'ok' => 1,	
		'list' => $list_giaoviec['list'],
	);
	echo json_encode($info);
}else if($action=='load_list_giaoviec_tructiep_nhan'){

	$page = intval($_REQUEST['page']);
	$limit = 5;
	$user_id = $user_info['user_id'];

	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'nhan');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_nhan($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
		$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	
	$info = array(
		'ok' => 1,	
		'list' => $list_giaoviec['list'],
	);
	echo json_encode($info);
}else if($action=='load_list_giaoviec_tructiep_giamsat'){

	$page = intval($_REQUEST['page']);
	$limit = 5;
	$user_id = $user_info['user_id'];

	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'giamsat');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_giamsat($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	
	$info = array(
		'ok' => 1,	
		'list' => $list_giaoviec['list'],
	);
	echo json_encode($info);
}else if($action=='load_list_lichsu_giaoviec'){
	$page = intval($_REQUEST['page']);
	$limit = 10;
	$user_id = $user_info['user_id'];

	$thongke = mysqli_query($conn, "SELECT COUNT(*) AS total FROM giaoviec_tructiep WHERE phantram_hoanthanh='100' AND admin_cty='{$user_info['admin_cty']}' AND trang_thai =  '6'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$list_lichsu_giaoviec = json_decode($class_member->list_lichsu_giaoviec($conn, $user_info['admin_cty'], $user_id, $page, $limit),true);
	$r_tt['list_lichsu_giaoviec'] = $list_lichsu_giaoviec['list'];
	$r_tt['start'] = $list_lichsu_giaoviec['start'];
	$r_tt['end'] = $list_lichsu_giaoviec['end'];
	$r_tt['phantrang'] = $class_member->phantrang($page,$total_page,'');
	
	$info = array(
		'ok' => 1,	
		'list' => $list_lichsu_giaoviec['list'],
	);
	echo json_encode($info);
}else if($action=='load_danhsach_du_an'){
	$page = intval($_REQUEST['page']);
	$limit = 5;
	$user_id = $user_info['user_id'];

	$thongke = mysqli_query($conn, "SELECT COUNT(DISTINCT id_du_an) AS total FROM congviec_du_an WHERE (id_nguoi_nhan='$user_id' OR id_nguoi_giao='$user_id') AND admin_cty='{$user_info['admin_cty']}'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_du_an_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_du_an=json_decode($class_member->list_du_an($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_du_an']=$list_du_an['list'];
	$r_tt['start']=$list_du_an['start'];
	$r_tt['end']=$list_du_an['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');

	$info = array(
		'ok' => 1,	
		'list' => $list_du_an['list'],
	);
	echo json_encode($info);
}else if($action=='load_list_lichsu_du_an'){
	$page = intval($_REQUEST['page']);
	$limit = 5;
	$user_id = $user_info['user_id'];

	$thongke = mysqli_query($conn, "
		SELECT COUNT(DISTINCT da.id) AS total 
		FROM du_an as da
		WHERE da.trang_thai IN (3, 6)
		AND da.admin_cty = '{$user_info['admin_cty']}'
		AND EXISTS (
			SELECT 1 
			FROM congviec_du_an cda
			WHERE cda.id_du_an = da.id
			AND (cda.id_nguoi_nhan = '$user_id' 
				OR cda.id_nguoi_giao = '$user_id')
		)
	");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$list_lichsu_du_an = json_decode($class_member->list_lichsu_du_an($conn, $user_info['admin_cty'], $user_id, $page, $limit),true);
	$r_tt['list_lichsu_du_an']=$list_lichsu_du_an['list'];
	$r_tt['start']=$list_lichsu_du_an['start'];
	$r_tt['end']=$list_lichsu_du_an['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');

	$info = array(
		'ok' => 1,	
		'list' => $list_lichsu_du_an['list'],
	);
	echo json_encode($info);
///////////////////////////////
//socket
} else if ($action == 'load_form_giaoviec_giao') {
    $nguoi_giao = intval($_REQUEST['nguoi_giao']);
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		
		$list_giaoviec_giao = json_decode($class_member->list_giaoviec_tructiep_giao($conn, $nguoi_giao, $user_info['admin_cty'], 1, 5), true);
		$list_giaoviec = $list_giaoviec_giao['list'];
		$list = '
		<thead>
			<tr>
				<th width="60" class="text-center">STT</th>
				<th>Tên công việc</th>
				<th width="180">Người tạo công việc</th>
				<th width="120" class="text-center">Mức độ ưu tiên</th>
				<th width="150" class="text-center">Hạn hoàn thành</th>
				<th width="130" class="text-center">Trạng thái</th>
				<th width="140" class="text-center sticky-column">Hành động</th>
			</tr>
		</thead>	
		<tbody id="list_giaoviec_giao">
			' . $list_giaoviec . '
		</tbody>
		';
		
		$total = $class_member->total_giaoviec($conn,$nguoi_giao,$user_info['admin_cty'],'giao');
		$total_giaoviec = '
		<h2><i class="fa fa-tasks"></i> Danh sách công việc</h2>
		<span class="total_count" id="total_giaoviec_giao">Tổng: <strong>' . $total . '</strong> công việc</span>';

		switch ($r_tt['trang_thai']) {
			case 0:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
				break;
			case 1:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang triển khai</span>';
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
				$r_tt['trang_thai_text'] = '<span class="status_badge status_6">Đã hoàn thành</span>';
				break;
			default:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_default">Không xác định</span>';
				break;
		}
		$list_lichsu_baocao = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Ngày báo cáo</th>
					<th>Tiến độ</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_baocao($conn, $admin_cty, $id, $user_info['user_id']).'
			</tbody>';
		$list_lichsu_giahan = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Hạn yêu cầu</th>
					<th>Gia hạn thêm</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_giahan($conn,$user_info['user_id'], $admin_cty, $id).'
			</tbody>';
		$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
		'total_giaoviec' => $total_giaoviec,
		'trang_thai_text' => $r_tt['trang_thai_text'],
		'list_lichsu_baocao' => $list_lichsu_baocao,
		'list_lichsu_giahan' => $list_lichsu_giahan,
		'total_chuadoc' => $thongbao
	);

	echo json_encode($info);	
} else if ($action == 'load_form_giaoviec_nhan') {
    $nguoi_nhan = intval($_REQUEST['nguoi_nhan']);
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$list_giaoviec_nhan = json_decode($class_member->list_giaoviec_tructiep_nhan($conn, $nguoi_nhan, $user_info['admin_cty'], 1, 5), true);
		$list_giaoviec = $list_giaoviec_nhan['list'];
		$list = '
			<thead>
				<tr>
					<th width="60" class="text-center">STT</th>
					<th>Tên công việc</th>
					<th width="180">Người tạo công việc</th>
					<th width="120" class="text-center">Mức độ ưu tiên</th>
					<th width="150" class="text-center">Hạn hoàn thành</th>
					<th width="130" class="text-center">Trạng thái</th>
					<th width="140" class="text-center sticky-column">Hành động</th>
				</tr>
			</thead>	
			<tbody id="list_giaoviec_nhan">
				' . $list_giaoviec . '
			</tbody>
		';
		
		$total = $class_member->total_giaoviec($conn,$nguoi_nhan,$user_info['admin_cty'],'nhan');
		$total_giaoviec = '
		<h2><i class="fa fa-tasks"></i> Danh sách công việc</h2>
		<span class="total_count" id="total_giaoviec_nhan">Tổng: <strong>' . $total . '</strong> công việc</span>';
	
		if($user_info['user_id'] == $r_tt['id_nguoi_nhan']){
			// Khởi tạo các biến
			$trang_thai = '';
			$xacnhan_congviec = '';
			$xin_giahan = '';
			$thoi_gian_hien_tai = time();
			$han_hoan_thanh = strtotime($r_tt['han_hoanthanh']);
			if($r_tt['miss_deadline'] == 1){
				$check_miss_deadline = "<button class='btn btn-danger check_miss_deadline' disabled><i class='fas fa-exclamation-triangle'></i> Miss Deadline</button>";
			}
			// Xử lý logic footer dựa trên trạng thái
			if ($r_tt['trang_thai'] == 0) {
				$trang_thai = 'Chờ xác nhận';
		
				// Tính thời gian đã trôi qua từ khi tạo
				$thoi_gian_da_troi_qua = time() - $r_tt['date_post']; // Thời gian đã trôi qua (giây)
				$thoi_gian_nhanviec_giay = intval($r_tt['thoigian_nhanviec']) * 60; // Chuyển phút thành giây
	
				if ($r_tt['xacnhan_nhanviec'] == 0) {
					if ($thoi_gian_da_troi_qua > $thoi_gian_nhanviec_giay) {
							$xacnhan_congviec = "<button class='btn btn-danger' id='box_pop_nhanviec_quahan' data-id='{$id}' > <i class='fas fa-exclamation-triangle'></i> Quá hạn</button>";
					} else {
							$xacnhan_congviec = "<button class='btn btn-draft' id='nhan_congviec_tructiep' data-id='{$id}'  > <i class='fas fa-check'></i>Nhận việc</button>";
					}
				} else {
					// Chỉ người được giao phó mới hiển thị nút
					$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
		
						$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
					
				}
			} else if ($r_tt['trang_thai'] == 1) {
				$trang_thai = 'Đang thực hiện';
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
				
				$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
			
			}else if ($r_tt['trang_thai'] == 2) {
				$trang_thai = 'Chờ phê duyệt';
				$xacnhan_congviec = "<button class='btn btn-draft' disabled data-id='{$id}' > <i class='fas fa-clock'></i> Chờ phê duyệt</button>";
			} else if ($r_tt['trang_thai'] == 3) {
	
				$trang_thai = 'Miss deadline';
			
				// Nút cảnh báo luôn hiển thị
				$xacnhan_congviec  = "
					<button class='btn btn-danger' disabled>
						<i class='fas fa-exclamation-triangle'></i> Miss Deadline
					</button>
				";
			
				// Nếu chưa hoàn thành đủ 100% thì cho phép cập nhật
				if ($r_tt['phantram_hoanthanh'] < 100) {
					$xacnhan_congviec .= "
						<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' >
							<i class='fas fa-edit'></i> Cập nhật công việc
						</button>
					";
				}
			
			} else if ($r_tt['trang_thai'] == 4) {
	
				$trang_thai = 'Đã từ chối';
			
				// Nút thông báo trạng thái
				$xacnhan_congviec = "
					<button class='btn btn-danger' disabled>
						<i class='fas fa-times'></i> Đã từ chối
					</button>
				";
			
				// Nút gửi lại
				$xacnhan_congviec .= "
					<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' >
						<i class='fas fa-redo'></i> Gửi lại
					</button>
				";
			
				$xin_giahan = "
					<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_tructiep' >
						<i class='fas fa-exclamation-triangle'></i> Xin gia hạn
					</button>
				";
				
			} else if ($r_tt['trang_thai'] == 5) {
				$trang_thai = 'Xin gia hạn';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-draft' disabled data-id='{$id}' >Đang xin gia hạn</button>";
				$xacnhan_congviec .= "
						<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_tructiep' >
							<i class='fas fa-edit'></i> Cập nhật công việc
						</button>
					";
			} else if ($r_tt['trang_thai'] == 6) {
				$trang_thai = 'Đã hoàn thành';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-success' disabled data-id='{$id}'>Đã hoàn thành</button>";
			}
			
			// Hiển thị footer cho người nhận
			$f_nhanviec = array(
				'id' => $id,
				'trang_thai' => $trang_thai,
				'xacnhan_congviec' => $xacnhan_congviec,
				'xin_giahan' => $xin_giahan,
				'check_miss_deadline' => $check_miss_deadline
			);
			// Chỉ lấy phần nút bên phải (không có cấu trúc footer và nút lịch sử)
			$r_tt['footer_action'] = $skin->skin_replace('skin_members/footer_nhanviec_right',$f_nhanviec);
		}else{
			$r_tt['footer_action'] = '';
		}
		switch ($r_tt['trang_thai']) {
			case 0:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
				break;
			case 1:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang triển khai</span>';
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
				$r_tt['trang_thai_text'] = '<span class="status_badge status_6">Đã hoàn thành</span>';
				break;
			default:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_default">Không xác định</span>';
				break;
		}
		$list_lichsu_baocao = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Ngày báo cáo</th>
					<th>Tiến độ</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_baocao($conn, $admin_cty, $id, $user_info['user_id']).'
			</tbody>';
		$list_lichsu_giahan = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Hạn yêu cầu</th>
					<th>Gia hạn thêm</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_giahan($conn,$user_info['user_id'], $admin_cty, $id).'
			</tbody>';
	}
	
	$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';

	$info = array(
		'ok' => 1,
		'list' => $list,
		'total_giaoviec' => $total_giaoviec,
		'trang_thai_text' => $r_tt['trang_thai_text'],
		'footer_action' => $r_tt['footer_action'],
		'list_lichsu_baocao' => $list_lichsu_baocao,
		'list_lichsu_giahan' => $list_lichsu_giahan,
		'total_chuadoc' => $thongbao
	);

	echo json_encode($info);
} else if ($action == 'load_thongbao') {
	
	$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $user_info['admin_cty']).'</span></i>';
	$info = array(
		'ok' => 1,
		'total_chuadoc' => $thongbao
	);

	echo json_encode($info);
} else if ($action == 'load_form_giaoviec_giamsat') {
    $nguoi_giamsat = intval($_REQUEST['nguoi_giamsat']);
	$id = intval($_REQUEST['id']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$list_giaoviec_giamsat = json_decode($class_member->list_giaoviec_tructiep_giamsat($conn, $nguoi_giamsat, $user_info['admin_cty'], 1, 5), true);
		$list_giaoviec = $list_giaoviec_giamsat['list'];
		$list = '
		<thead>
			<tr>
				<th width="60" class="text-center">STT</th>
				<th>Tên công việc</th>
				<th width="180">Người tạo công việc</th>
				<th width="120" class="text-center">Mức độ ưu tiên</th>
				<th width="150" class="text-center">Hạn hoàn thành</th>
				<th width="130" class="text-center">Trạng thái</th>
				<th width="140" class="text-center sticky-column">Hành động</th>
			</tr>
		</thead>	
		<tbody id="list_giaoviec_giamsat">
			' . $list_giaoviec . '
		</tbody>
		';
		
		$total = $class_member->total_giaoviec($conn,$nguoi_giamsat,$user_info['admin_cty'],'giamsat');
		$total_giaoviec = '
		<h2><i class="fa fa-tasks"></i> Danh sách công việc</h2>
		<span class="total_count" id="total_giaoviec_giamsat">Tổng: <strong>' . $total . '</strong> công việc</span>';

		$list_lichsu_baocao = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Ngày báo cáo</th>
					<th>Tiến độ</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_baocao($conn, $admin_cty, $id, $user_info['user_id']).'
			</tbody>';
		$list_lichsu_giahan = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Hạn yêu cầu</th>
					<th>Gia hạn thêm</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_giahan($conn,$user_info['user_id'], $admin_cty, $id).'
			</tbody>';
		switch ($r_tt['trang_thai']) {
			case 0:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
				break;
			case 1:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang triển khai</span>';
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
				$r_tt['trang_thai_text'] = '<span class="status_badge status_6">Đã hoàn thành</span>';
				break;
			default:
				$r_tt['trang_thai_text'] = '<span class="status_badge status_default">Không xác định</span>';
				break;
		}
		$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';

	}
	$info = array(
		'ok' => 1,
		'list' => $list,
		'total_giaoviec' => $total_giaoviec,
		'trang_thai_text' => $r_tt['trang_thai_text'],
		'list_lichsu_baocao' => $list_lichsu_baocao,
		'list_lichsu_giahan' => $list_lichsu_giahan,
		'total_chuadoc' => $thongbao

	);

	echo json_encode($info);	
} else if ($action == 'load_list_giaoviec_tructiep') {
	$list_nhanvien = intval($_REQUEST['list_nhanvien']);
	$page_type = $_REQUEST['page_type'] ?? '';
	$admin_cty = $user_info['admin_cty'];
	if($page_type == 'list-congviec-giamsat'){
		$list_tructiep = $class_member->list_giaoviec_tructiep_giamsat($conn, $list_nhanvien, $admin_cty, 1, 5);
		$id_table = 'list_giaoviec_giamsat';
		$tieu_de = 'giamsat';
		$id_total = 'total_giaoviec_giamsat';
	}else if($page_type == 'list-congviec-cua-toi'){
		$list_tructiep = $class_member->list_giaoviec_tructiep_nhan($conn, $list_nhanvien, $admin_cty, 1, 5);
		$id_table = 'list_giaoviec_nhan';
		$tieu_de = 'nhan';
		$id_total = 'total_giaoviec_nhan';
	}else if($page_type == 'list-congviec-quanly'){
		$list_tructiep = $class_member->list_giaoviec_tructiep_giao($conn, $list_nhanvien, $admin_cty, 1, 5);
		$id_table = 'list_giaoviec_giao';
		$tieu_de = 'giao';
		$id_total = 'total_giaoviec_giao';
	}
		$list_giaoviec_tructiep = json_decode($list_tructiep, true);
		$list_giaoviec = $list_giaoviec_tructiep['list'];
		$list = '
		<thead>
			<tr>
				<th width="60" class="text-center">STT</th>
				<th>Tên công việc</th>
				<th width="180">Người tạo công việc</th>
				<th width="120" class="text-center">Mức độ ưu tiên</th>
				<th width="120" class="text-center">Ngày tạo</th>
				<th width="120" class="text-center">Trạng thái</th>
				<th width="140" class="text-center sticky-column">Hành động</th>
			</tr>
		</thead>	
		<tbody id="'.$id_table.'">
			' . $list_giaoviec . '
		</tbody>
		';
		
		$total = $class_member->total_giaoviec($conn,$list_nhanvien,$user_info['admin_cty'],$tieu_de);
		$total_giaoviec = '
		<h2><i class="fa fa-tasks"></i> Danh sách công việc</h2>
		<span class="total_count" id="'.$id_total.'">Tổng: <strong>' . $total . '</strong> công việc</span>';

		
		$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';

	
	$info = array(
		'ok' => 1,
		'list' => $list,
		'total_giaoviec' => $total_giaoviec,
		'total_chuadoc' => $thongbao,
		'page_type' => $page_type
	);
	echo json_encode($info);	
}else if ($action == 'load_giahan') {
	$id = intval($_REQUEST['id']);
	$type = $_REQUEST['type'] ?? '';
	$admin_cty = $user_info['admin_cty'];
	if($type == 'giaoviec_tructiep'){
		$table = 'giaoviec_tructiep';
	}else if($type == 'giaoviec_du_an'){
		$table = 'congviec_du_an';
	}
	$thongtin = mysqli_query($conn, "SELECT * FROM $table WHERE id='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;

		if(!empty($r_tt['han_hoanthanh'])){
			if(is_numeric($r_tt['han_hoanthanh'])){
				$han_hoan_thanh = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
			} else {
				$timestamp = strtotime($r_tt['han_hoanthanh']);
				$han_hoan_thanh = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
			}
		} else {
			$han_hoan_thanh = '';
		}	

		$list = '<div class="han_hoan_thanh_value">'.$han_hoan_thanh.'</div>';
	}
	$info = array(
		'ok' => 1,
		'list' => $list
	);
	echo json_encode($info);
}else if ($action == 'load_form_du_an') {
	
    $id = intval($_REQUEST['id']);
    $list_nhanvien = intval($_REQUEST['list_nhanvien']);
	$admin_cty = $user_info['admin_cty'];
	$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id' AND admin_cty='$admin_cty'");
	$total = mysqli_num_rows($thongtin);
	if($total == 0){
		$ok = 0;
		$thongbao = 'Dữ liệu không tồn tại';
		$html = '';
	}else{
		$r_tt = mysqli_fetch_assoc($thongtin);
		$r_tt['id'] = $id;
		$list_du_an = json_decode($class_member->list_du_an($conn, $list_nhanvien, $admin_cty, 1, 5), true);
		$list = $list_du_an['list'];
		$list_du_an_table = '
			<thead>
				<tr>
					<th width="60" class="text-center">STT</th>
					<th>Tên dự án</th>
					<th width="180">Người tạo dự án</th>
					<th width="120" class="text-center">Mức độ ưu tiên</th>
					<th width="120" class="text-center">Ngày tạo</th>
					<th width="150" class="text-center">Trạng thái</th>
					<th width="140" class="text-center sticky-column">Hành động</th>
				</tr>
			</thead>
			<tbody id="list_du_an">
				' . $list . '
			</tbody>
			';
		$total = $class_member->total_du_an($conn,$list_nhanvien,$user_info['admin_cty']);
		$total = '
		<h2><i class="fa fa-project-diagram"></i> Danh sách dự án</h2>
		<span class="total_count" id="total_du_an">Tổng: <strong>' . $total . '</strong> dự án</span>';

		$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';

	}
    $info = array(
        'ok' => 1,	
        'list' => $list_du_an_table,
        'total_du_an' => $total,
		'total_chuadoc' => $thongbao

    );
    echo json_encode($info);
} else if ($action == 'load_form_congviec_du_an') {
    $id = intval($_REQUEST['id']);
    $nhanvien_id = intval($_REQUEST['nhanvien_id']);
    $admin_cty = $user_info['admin_cty'];
    $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
    $total = mysqli_num_rows($thongtin);
    if($total == 0){
        $ok = 0;
        $thongbao = 'Dữ liệu không tồn tại';
        $html = '';
    }else{
        $r_tt = mysqli_fetch_assoc($thongtin);
        $r_tt['id'] = $id;
		$id_du_an = $r_tt['id_du_an'];

		
		if($r_tt['parent_id'] == 0){
			$thongtin_du_an = mysqli_query($conn, "SELECT * FROM du_an WHERE id='$id_du_an' AND admin_cty='$admin_cty'");
			$r_du_an = mysqli_fetch_assoc($thongtin_du_an);
			switch ($r_du_an['trang_thai']) {
				case 0:
					$trang_thai_du_an = '<span class="status_badge status_0">Chờ xử lý</span>';
					break;
				case 1:
					$trang_thai_du_an = '<span class="status_badge status_1">Đang thực hiện</span>';
					break;
				case 2:
					$trang_thai_du_an = '<span class="status_badge status_2">Chờ phê duyệt</span>';
					break;
				case 3:
					$trang_thai_du_an = '<span class="status_badge status_3">Miss Deadline</span>';
					break;
				case 4:
					$trang_thai_du_an = '<span class="status_badge status_4">Từ chối</span>';
					break;
				case 5:
					$trang_thai_du_an = '<span class="status_badge status_5">Xin gia hạn</span>';
					break;
				case 6:
					$trang_thai_du_an = '<span class="status_badge status_6">Hoàn thành</span>';
					break;
				default:
					$trang_thai_du_an = '<span class="status_badge">Không xác định</span>';
					break;
			}
			$list_du_an = json_decode($class_member->list_du_an($conn, $nhanvien_id, $admin_cty, 1, 5), true);
			$list = $list_du_an['list'];

			$list_du_an_table = '
				<thead>
					<tr>
						<th width="60" class="text-center">STT</th>
						<th>Tên dự án</th>
						<th width="180">Người tạo dự án</th>
						<th width="120" class="text-center">Mức độ ưu tiên</th>
						<th width="120" class="text-center">Ngày tạo</th>
						<th width="150" class="text-center">Trạng thái</th>
						<th width="140" class="text-center sticky-column">Hành động</th>
					</tr>
				</thead>
				<tbody id="list_du_an">
					' . $list . '
				</tbody>
				';
		}else{
			$list_du_an_table = '';
		}
		
			switch ($r_tt['trang_thai']) {
				case 0:
					$trang_thai_text = '<span class="status_badge status_0">Chờ xử lý</span>';
					break;
				case 1:
					$trang_thai_text = '<span class="status_badge status_1">Đang thực hiện</span>';
					break;
				case 2:
					$trang_thai_text = '<span class="status_badge status_2">Chờ phê duyệt</span>';
					break;
				case 3:
					$trang_thai_text = '<span class="status_badge status_3">Miss Deadline</span>';
					break;
				case 4:
					$trang_thai_text = '<span class="status_badge status_4">Từ chối</span>';
					break;
				case 5:
					$trang_thai_text = '<span class="status_badge status_5">Xin gia hạn</span>';
					break;
				case 6:
					$trang_thai_text = '<span class="status_badge status_6">Hoàn thành</span>';
					break;
				default:
					$trang_thai_text = '<span class="status_badge">Không xác định</span>';
					break;
			}
		$list_nhanviec = '<div class="deadline_list_item"> ' . $class_member->list_han_nhanviec($conn, $admin_cty, $id_du_an) . '</div>';
		$list_lichsu_baocao = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Ngày báo cáo</th>
					<th>Tiến độ</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_baocao_congviec_du_an($conn, $admin_cty, $id, $user_info['user_id']).'
			</tbody>';
		$list_lichsu_giahan = 
			'<thead>
				<tr>
					<th>STT</th>
					<th>Hạn yêu cầu</th>
					<th>Gia hạn thêm</th>
					<th>Trạng thái</th>
					<th>Hành động</th>
				</tr>
			</thead>
			<tbody>
				'.$class_member->list_lichsu_giahan_congviec_du_an($conn,$user_info['user_id'], $admin_cty, $id).'
			</tbody>';
		if($user_info['user_id'] == $r_tt['id_nguoi_nhan']){
			// Khởi tạo các biến
			$trang_thai = '';
			$xacnhan_congviec = '';
			$xin_giahan = '';
			$thoi_gian_hien_tai = time();
			$han_hoan_thanh = strtotime($r_tt['han_hoanthanh']);
			if($r_tt['miss_deadline'] == 1){
				$check_miss_deadline = "<button class='btn btn-danger check_miss_deadline' disabled><i class='fas fa-exclamation-triangle'></i> Miss Deadline</button>";
			}
			// Xử lý logic footer dựa trên trạng thái
			if ($r_tt['trang_thai'] == 0) {
				$trang_thai = 'Chờ xác nhận';
		
				$thoi_gian_da_troi_qua = time() - $r_tt['date_post']; 
				$thoi_gian_nhanviec_giay = intval($r_tt['thoigian_nhanviec']) * 60; 
		
				if ($r_tt['xacnhan_nhanviec'] == 0) {
					if ($thoi_gian_da_troi_qua > $thoi_gian_nhanviec_giay) {
							$xacnhan_congviec = "<button class='btn btn-danger' id='box_pop_nhanviec_du_an_quahan' data-id='{$id}' > <i class='fas fa-exclamation-triangle'></i> Quá hạn</button>";
					} else {
							$xacnhan_congviec = "<button class='btn btn-draft' id='nhan_congviec_du_an' data-id='{$id}'  > <i class='fas fa-check'></i>Nhận việc</button>";
					}
				} else {
					$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
					$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";	
				}
			} else if ($r_tt['trang_thai'] == 1) {
				$trang_thai = 'Đang thực hiện';
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";
				$xin_giahan = "<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-exclamation-triangle'></i> Xin gia hạn</button>";
			}else if ($r_tt['trang_thai'] == 2) {
				$trang_thai = 'Chờ phê duyệt';
				$xacnhan_congviec = "<button class='btn btn-draft' disabled data-id='{$id}' > <i class='fas fa-clock'></i> Chờ phê duyệt</button>";
		
			} else if ($r_tt['trang_thai'] == 4) {
		
				$trang_thai = 'Đã từ chối';
			
				// Nút thông báo trạng thái
				$xacnhan_congviec = "
					<button class='btn btn-danger' disabled>
						<i class='fas fa-times'></i> Đã từ chối
					</button>
				";
			
				// Nút gửi lại
				$xacnhan_congviec .= "
					<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' >
						<i class='fas fa-redo'></i> Gửi lại
					</button>
				";
			
				
				$xin_giahan = "
					<button class='btn btn-giahan' id='box_pop_giahan' data-id='{$id}' action='giaoviec_du_an' >
						<i class='fas fa-exclamation-triangle'></i> Xin gia hạn
					</button>
				";
			
			} else if ($r_tt['trang_thai'] == 5) {
				$trang_thai = 'Xin gia hạn';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-draft' disabled data-id='{$id}' >Đang xin gia hạn</button>";
				$xacnhan_congviec = "<button class='btn btn-draft' id='box_pop_capnhat_trangthai' data-id='{$id}' action='giaoviec_du_an' > <i class='fas fa-edit'></i> Cập nhật công việc</button>";

			} else if ($r_tt['trang_thai'] == 6) {
				$trang_thai = 'Đã hoàn thành';
				// Nút này chỉ hiển thị trạng thái, không cần phân quyền ấn
				$xin_giahan = "<button class='btn btn-success' disabled data-id='{$id}'>Đã hoàn thành</button>";
			}
			
			// Hiển thị footer cho người nhận
			$f_nhanviec = array(
				'id' => $id,
				'trang_thai' => $trang_thai,
				'xacnhan_congviec' => $xacnhan_congviec,
				'xin_giahan' => $xin_giahan,
				'check_miss_deadline' => $check_miss_deadline
			);
			// Chỉ lấy phần nút bên phải (không có cấu trúc footer và nút lịch sử)
			$footer_action = $skin->skin_replace('skin_members/footer_nhanviec_right',$f_nhanviec);
		}else{
			$footer_action = '';
		}

		$thongbao = '<i class="fa fa-bell"><span class="total_notification">'.$class_member->total_thongbao_chua_doc($conn,$user_info['user_id'], $admin_cty).'</span></i>';

	}

	$info = array(
		'ok' => 1,
		'list' => $list_du_an_table,
		'trang_thai_text' => $trang_thai_text,
		'list_nhanviec' => $list_nhanviec,
		'footer_action' => $footer_action,
		'list_lichsu_baocao' => $list_lichsu_baocao,
		'list_lichsu_giahan' => $list_lichsu_giahan,
		'trang_thai_du_an' => $trang_thai_du_an,
		'total_chuadoc' => $thongbao,
		'deadline_timestamp' => isset($r_tt['deadline_timestamp']) ? $r_tt['deadline_timestamp'] : 0,
		'id' => $id,
		'type' => 'giaoviec_du_an'

	);
	echo json_encode($info);

} else if($action=='check_deadline'){
	// API để client check deadline khi countdown về 0
	$id = intval($_REQUEST['id']);
	$type = addslashes($_REQUEST['type']); // 'giaoviec_tructiep' hoặc 'giaoviec_du_an'
	$admin_cty = $user_info['admin_cty'];
	$hientai = time();
	
	$ok = 0;
	$thongbao = '';
	$is_overdue = false;
	$trang_thai = 0;
	$deadline_timestamp = 0;
	
	if($type == 'giaoviec_tructiep') {
		$thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
		if(mysqli_num_rows($thongtin) > 0) {
			$r_tt = mysqli_fetch_assoc($thongtin);
			$trang_thai = intval($r_tt['trang_thai']);
			$deadline_timestamp = intval($r_tt['han_hoanthanh']);
			
			$nguoi_nhan = $r_tt['id_nguoi_nhan'];
			$nguoi_giao = $r_tt['id_nguoi_giao'];
			$nguoi_giamsat = $r_tt['id_nguoi_giamsat'];
			// Kiểm tra quá hạn
			if($deadline_timestamp > 0 && $deadline_timestamp < $hientai && $trang_thai != 6 && $phantram_hoanthanh < 100) {
				$is_overdue = true;
				// Nếu chưa được đánh dấu miss deadline, cập nhật
				if($trang_thai != 3) {
					mysqli_query($conn, "UPDATE giaoviec_tructiep SET miss_deadline='1', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
					$trang_thai = 3;
					
					// Gửi notification
					$noidung = 'Công việc "' . addslashes($r_tt['ten_congviec']) . '" đã quá hạn deadline';
					if(!empty($r_tt['id_nguoi_nhan']) && $r_tt['id_nguoi_nhan'] > 0) {
						mysqli_query($conn, "INSERT INTO notification (user_id, user_nhan, id_congviec, noi_dung, doc, phan_loai, date_post) 
							VALUES ('{$r_tt['id_nguoi_giao']}', '{$r_tt['id_nguoi_nhan']}', '$id', '$noidung', '0', 'giaoviec_tructiep', '$hientai')");
					}
				}
				$ok = 1;
				$thongbao = 'Công việc đã quá hạn deadline';              
			
			} else if($deadline_timestamp > 0 && $deadline_timestamp >= $hientai) {
				$ok = 1;
				$thongbao = 'Công việc vẫn trong thời hạn';
			} else {
				$ok = 1;
				$thongbao = 'Công việc đã hoàn thành';
			}
		} else {
			$thongbao = 'Không tìm thấy công việc';
		}
	} else if($type == 'giaoviec_du_an') {
		$thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
		if(mysqli_num_rows($thongtin) > 0) {
			$r_tt = mysqli_fetch_assoc($thongtin);
			$trang_thai = intval($r_tt['trang_thai']);
			$deadline_timestamp = intval($r_tt['han_hoanthanh']);
			
			// Kiểm tra quá hạn
			if($deadline_timestamp > 0 && $deadline_timestamp < $hientai && $trang_thai != 6 && $phantram_hoanthanh < 100) {
				$is_overdue = true;
				// Nếu chưa được đánh dấu miss deadline, cập nhật
				if($trang_thai != 3) {
					mysqli_query($conn, "UPDATE congviec_du_an SET  miss_deadline='1', update_post='$hientai' WHERE id='$id' AND admin_cty='$admin_cty'");
					$trang_thai = 3;
					
					// Gửi notification
					$noidung = 'Công việc "' . addslashes($r_tt['ten_congviec']) . '" đã quá hạn deadline';
					if(!empty($r_tt['id_nguoi_nhan']) && $r_tt['id_nguoi_nhan'] > 0) {
						mysqli_query($conn, "INSERT INTO notification (user_id, user_nhan, id_congviec, noi_dung, doc, phan_loai, date_post) 
							VALUES ('{$r_tt['id_nguoi_giao']}', '{$r_tt['id_nguoi_nhan']}', '$id', '$noidung', '0', 'giaoviec_du_an', '$hientai')");
					}
					
					// Cập nhật trạng thái dự án nếu là công việc chính
					if(!empty($r_tt['id_du_an']) && $r_tt['parent_id'] == 0) {
						$check_miss = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an 
							WHERE id_du_an='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty' AND trang_thai = 3");
						$r_miss = mysqli_fetch_assoc($check_miss);
						if($r_miss['total'] > 0) {
							mysqli_query($conn, "UPDATE du_an SET miss_deadline='1', update_post='$hientai' 
								WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
						}
					}
				}
				$ok = 1;
				$thongbao = 'Công việc đã quá hạn deadline';
            
				if($r_tt['parent_id'] == 0) {
					mysqli_query($conn, "UPDATE du_an SET miss_deadline='1', update_post='$hientai' WHERE id='{$r_tt['id_du_an']}' AND admin_cty='$admin_cty'");
					$r_tt['trang_thai_list_item'] = '<span class="status_badge status_3">Miss Deadline</span>';
					$r_tt['trang_thai_du_an'] = '<span class="status_badge status_3">Miss Deadline</span>';
				}

			} else if($deadline_timestamp > 0 && $deadline_timestamp >= $hientai) {
				$ok = 1;
				$thongbao = 'Công việc vẫn trong thời hạn';
			} else {
				$ok = 1;
				$thongbao = 'Công việc đã hoàn thành';
			}
		} else {
			$thongbao = 'Không tìm thấy công việc';
		}
	} else {
		$thongbao = 'Loại công việc không hợp lệ';
	}
	
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'is_overdue' => $is_overdue,
		'deadline_timestamp' => $deadline_timestamp,
		'current_time' => $hientai,
		'remaining_seconds' => $deadline_timestamp > 0 ? max(0, $deadline_timestamp - $hientai) : 0,
		'id' => $id,
		'trang_thai_text' => $r_tt['trang_thai_text'],
		'trang_thai_list_item' => $r_tt['trang_thai_list_item'],
		'trang_thai_du_an' => $r_tt['trang_thai_du_an']
	);
	echo json_encode($info);

} else {
	echo "Không có hành động nào được xử lý";
}
?>