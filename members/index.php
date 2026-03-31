<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_thanhvien');
$class_member=$tlca_do->load('class_member');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');
if(intval($page)<1){
	$page=1;
}else{
	$page=intval($page);
}
if(isset($_REQUEST['action'])){
	$action=addslashes($_REQUEST['action']);
}else{
	$action='dashboard';
}
if(!isset($_COOKIE['user_id'])){
	$thongbao="Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
$user_id=$user_info['user_id'];
if(intval($user_id)<1){
	$thongbao="Thông tin không hợp lệ...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/members/logout'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();	
}
if($user_info['nhom']==1 OR $user_info['nhom']==2){
	$thongbao="Hệ thống đang chuyển hướng...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/admincp/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();	
}
$tach_name=explode(' ', $user_info['name']);
$name=$tach_name[count($tach_name) -1];
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}

$thaythe=array(
	'header'=>$skin->skin_normal('skin_members/header'),
	'box_menu'=>$skin->skin_normal('skin_members/box_menu'),
	'footer'=>$skin->skin_normal('skin_members/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_members/box_script_footer'),
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'phantrang'=>'',
	'fullname'=>$user_info['name'],
	'email'=>$user_info['email'],
	'user_id'=>$user_info['user_id'],
	'number_hotline'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'phi_booking_setting'=>number_format($index_setting['phi_booking']),
	'name'=>$name,
	'avatar'=>$user_info['avatar'],
	'display_kh'=>$display_kh,
	'box_cskh'=>$box_cskh,
	'display_sudung'=>$display_sudung,
	'sudung_expired'=>$sudung_expired,
	'option_goi_giahan'=>$option_goi,

);
if($action=='list_thongbao'){
	$thaythe['title']='Danh sách thông báo';
	$thaythe['title_action']='Danh sách thông báo';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM thongbao");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thongbao'=>$class_index->list_thongbao($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/members/list-thongbao')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_thongbao',$bien);
}else if($action=='profile'){
	$thaythe['title']='Hồ sơ cá nhân';
	$thaythe['title_action']='Hồ sơ cá nhân';
	$thongtin_kichhoat=mysqli_query($conn,"SELECT * FROM kich_hoat WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	$total=mysqli_num_rows($thongtin_kichhoat);
	// if($total==0){
	// 	$sudung_expired=$user_info['created']+3600*24*30;
	// 	$user_info['date_end']=date('H:i:s d/m/Y',$sudung_expired);
	// }else{
	// 	$r_kh=mysqli_fetch_assoc($thongtin_kichhoat);
	// 	$user_info['date_end']=date('H:i:s d/m/Y',$r_kh['date_end']);
	// }
	// $user_info['created']=date('H:i:s d/m/Y',$user_info['created']);
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/profile',$user_info);
}else if($action=='change_password'){
	$thaythe['title']='Change Password';
	$thaythe['title_action']='Change Password';
	$bien=array(
		'phantrang'=>$class_index->phantrang($page,$total,10,'/members/list-nhac')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/change_password',$bien);
}else if($action=='dashboard'){
	$thaythe['title']='Dashboard';
	$thaythe['title_action']='Dashboard';
	$hientai=time();
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$bien = array();
	
	$ngay_hom_nay_bat_dau = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$ngay_hom_nay_ket_thuc = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
	$ngay_sap_den_han = $ngay_hom_nay_ket_thuc + (3 * 24 * 3600); // 3 ngày tới

	$tong_congviec_tructiep = mysqli_query($conn, "SELECT COUNT(*) AS total FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id'");
	$r_tct = mysqli_fetch_assoc($tong_congviec_tructiep);
	$bien['tong_congviec_tructiep'] = $r_tct['total'];
	
	$tong_congviec_duan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM congviec_du_an WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id'");
	$r_tcd = mysqli_fetch_assoc($tong_congviec_duan);
	$bien['tong_congviec_duan'] = $r_tcd['total'];
	
	$bien['tong_congviec'] = $bien['tong_congviec_tructiep'] + $bien['tong_congviec_duan'];
	
	$list_hom_nay = '';
	
	$hom_nay_tructiep = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND trang_thai != '6' ORDER BY id DESC LIMIT 20");
	while($r_cv = mysqli_fetch_assoc($hom_nay_tructiep)){
		$is_hom_nay = false;
		$label = '';
		
		if(!empty($r_cv['han_hoanthanh'])){
			$deadline_str = str_replace('T', ' ', $r_cv['han_hoanthanh']);
			if(preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $deadline_str)){
				$deadline_str .= ':00';
			}
			$deadline_ts = strtotime($deadline_str);
			if($deadline_ts && $deadline_ts >= $ngay_hom_nay_bat_dau && $deadline_ts <= $ngay_hom_nay_ket_thuc){
				$is_hom_nay = true;
				$deadline = date('d/m/Y H:i', $deadline_ts);
				$label = 'Hạn: ' . $deadline;
			}
		}
		
		if(!$is_hom_nay && !empty($r_cv['date_post'])){
			$date_post_ts = is_numeric($r_cv['date_post']) ? intval($r_cv['date_post']) : strtotime($r_cv['date_post']);
			if($date_post_ts >= $ngay_hom_nay_bat_dau && $date_post_ts <= $ngay_hom_nay_ket_thuc){
				$is_hom_nay = true;
				$ngay_giao = date('d/m/Y H:i', $date_post_ts);
				$label = 'Mới giao: ' . $ngay_giao;
			}
		}
		
		if($is_hom_nay){
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
			$list_hom_nay .= '<div class="congviec-item"><div class="congviec-title">' . $ten_congviec . '</div><div class="congviec-meta"><span class="congviec-type">Công việc trực tiếp</span> | <span class="congviec-deadline">' . $label . '</span></div></div>';
		}
	}
	
	$hom_nay_duan = mysqli_query($conn, "SELECT cda.*, da.ten_du_an FROM congviec_du_an cda INNER JOIN du_an da ON cda.id_du_an = da.id WHERE cda.admin_cty='$admin_cty' AND cda.id_nguoi_nhan='$user_id' AND cda.trang_thai != '6' ORDER BY cda.id DESC LIMIT 20");
	while($r_cv = mysqli_fetch_assoc($hom_nay_duan)){
		$is_hom_nay = false;
		$label = '';
		
		if(!empty($r_cv['han_hoanthanh'])){
			$deadline_str = str_replace('T', ' ', $r_cv['han_hoanthanh']);
			if(preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $deadline_str)){
				$deadline_str .= ':00';
			}
			$deadline_ts = strtotime($deadline_str);
			if($deadline_ts && $deadline_ts >= $ngay_hom_nay_bat_dau && $deadline_ts <= $ngay_hom_nay_ket_thuc){
				$is_hom_nay = true;
				$deadline = date('d/m/Y H:i', $deadline_ts);
				$label = 'Hạn: ' . $deadline;
			}
		}
		
		if(!$is_hom_nay && !empty($r_cv['date_post'])){
			$date_post_ts = is_numeric($r_cv['date_post']) ? intval($r_cv['date_post']) : strtotime($r_cv['date_post']);
			if($date_post_ts >= $ngay_hom_nay_bat_dau && $date_post_ts <= $ngay_hom_nay_ket_thuc){
				$is_hom_nay = true;
				$ngay_giao = date('d/m/Y H:i', $date_post_ts);
				$label = 'Mới giao: ' . $ngay_giao;
			}
		}
		
		if($is_hom_nay){
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
			$ten_du_an = htmlspecialchars($r_cv['ten_du_an']);
			$list_hom_nay .= '<div class="congviec-item"><div class="congviec-title">' . $ten_congviec . '</div><div class="congviec-meta"><span class="congviec-type">Dự án: ' . $ten_du_an . '</span> | <span class="congviec-deadline">' . $label . '</span></div></div>';
		}
	}
	
	if(empty($list_hom_nay)){
		$list_hom_nay = '<div class="congviec-empty">Không có công việc nào hôm nay</div>';
	}
	
	$bien['list_congviec_hom_nay'] = $list_hom_nay;
	
	$list_sap_den_han = '';
	

	$sap_den_han_tructiep = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND trang_thai != '6' ORDER BY han_hoanthanh ASC LIMIT 20");
	while($r_cv = mysqli_fetch_assoc($sap_den_han_tructiep)){
	
		if(empty($r_cv['han_hoanthanh'])) continue;
		
		$deadline_str = str_replace('T',' ',$r_cv['han_hoanthanh']);
		$deadline_ts = strtotime($deadline_str);	
		$canh_bao = $deadline_ts - (3 * 24 * 3600);

		if($hientai >= $canh_bao && $hientai <= $deadline_ts){

			$deadline = date('d/m/Y H:i', $deadline_ts);
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
	
			$list_sap_den_han .= '
			<div class="congviec-item">
				<div class="congviec-title">'.$ten_congviec.'</div>
				<div class="congviec-meta">
					<span class="congviec-type">Công việc trực tiếp</span> |
					<span class="congviec-deadline">Hạn: '.$deadline.'</span>
				</div>
			</div>';
		}elseif($hientai > $deadline_ts){
	
			$deadline = date('d/m/Y H:i', $deadline_ts);
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
	
			$list_sap_den_han .= '
			<div class="congviec-item qua-han">
				<div class="congviec-title">'.$ten_congviec.'</div>
				<div class="congviec-meta">
					<span class="congviec-type">Công việc trực tiếp</span> |
					<span class="congviec-deadline" style="color:red;">Quá hạn: '.$deadline.'</span>
				</div>
			</div>';
		}
	}
	
	$sap_den_han_duan = mysqli_query($conn, "SELECT cda.*, da.ten_du_an FROM congviec_du_an cda INNER JOIN du_an da ON cda.id_du_an = da.id WHERE cda.admin_cty='$admin_cty' AND cda.id_nguoi_nhan='$user_id' AND cda.trang_thai != '6' ORDER BY cda.han_hoanthanh ASC LIMIT 20");
	while($r_cv = mysqli_fetch_assoc($sap_den_han_duan)){
		
		if(empty($r_cv['han_hoanthanh'])) continue;
		
		$deadline_str = str_replace('T',' ',$r_cv['han_hoanthanh']);
		$deadline_ts = strtotime($deadline_str);		
		$canh_bao = $deadline_ts - (3 * 24 * 3600);
	
		if($hientai >= $canh_bao && $hientai <= $deadline_ts){
			$deadline = date('d/m/Y H:i', $deadline_ts);
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
			$ten_du_an = htmlspecialchars($r_cv['ten_du_an']);
	
			$list_sap_den_han .= '
			<div class="congviec-item">
				<div class="congviec-title">'.$ten_congviec.'</div>
				<div class="congviec-meta">
					<span class="congviec-type">Dự án: '.$ten_du_an.'</span> |
					<span class="congviec-deadline">Hạn: '.$deadline.'</span>
				</div>
			</div>';
		}elseif($hientai > $deadline_ts){
			$deadline = date('d/m/Y H:i', $deadline_ts);
			$ten_congviec = htmlspecialchars($r_cv['ten_congviec']);
			$ten_du_an = htmlspecialchars($r_cv['ten_du_an']);
	
			$list_sap_den_han .= '
			<div class="congviec-item qua-han">
				<div class="congviec-title">'.$ten_congviec.'</div>
				<div class="congviec-meta">
					<span class="congviec-type">Dự án: '.$ten_du_an.'</span> |
					<span class="congviec-deadline" style="color:red;">Quá hạn: '.$deadline.'</span>
				</div>
			</div>';
		}
	}
	
	if(empty($list_sap_den_han)){
		$list_sap_den_han = '<div class="congviec-empty">Không có công việc nào sắp đến hạn</div>';
	}
	
	$bien['list_congviec_sap_den_han'] = $list_sap_den_han;

	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/dashboard',$bien);
}else if($action=='add_giaoviec-tructiep'){
	$thaythe['title']='Thêm công việc trực tiếp';
	$thaythe['title_action']='Thêm công việc trực tiếp';
	$r_tt['option_phongban']=$class_member->list_option_phongban($conn,$user_info['admin_cty'],$user_id);
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/add_giaoviec_tructiep',$r_tt);
}else if($action=='list_congviec-quanly'){
	$thaythe['title']='Danh sách công việc trực tiếp';
	$thaythe['title_action']='Danh sách công việc trực tiếp';
	$limit=5;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'giao');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_giao($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	$r_tt['id_phantrang']='phantrang_giaoviec_tructiep_giao';
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_giaoviec_tructiep',$r_tt);
}else if($action=='list_congviec-cua-toi'){
	$thaythe['title']='Danh sách công việc nhận';
	$thaythe['title_action']='Danh sách công việc nhận';
	$limit=5;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'nhan');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_cua_toi"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_nhan($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	$r_tt['id_phantrang']='phantrang_giaoviec_tructiep_nhan';
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_giaoviec_tructiep_nhan',$r_tt);
}else if($action=='list_congviec-giamsat'){
	$thaythe['title']='Danh sách công việc giám sát';
	$thaythe['title_action']='Danh sách công việc giám sát';
	$limit=5;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$r_tt['total']=$class_member->total_giaoviec($conn,$user_id,$user_info['admin_cty'],'giamsat');
	$total_page = ceil($r_tt['total']/$limit);
	$r_tt['search_list']='<button class="btn_filter" name="search_list_congviec_giamsat"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_giaoviec=json_decode($class_member->list_giaoviec_tructiep_giamsat($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_giaoviec']=$list_giaoviec['list'];
	$r_tt['start']=$list_giaoviec['start'];
	$r_tt['end']=$list_giaoviec['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	$r_tt['id_phantrang']='phantrang_giaoviec_tructiep_giamsat';
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_giaoviec_tructiep_giamsat',$r_tt);
}else if($action=='list_lichsu-giaoviec'){
	$thaythe['title']='Lịch sử giao việc';
	$thaythe['title_action']='Lịch sử giao việc';
	$limit=10;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$thongke = mysqli_query($conn, "SELECT COUNT(*) AS total FROM giaoviec_tructiep WHERE admin_cty='{$user_info['admin_cty']}' AND trang_thai = '6' AND (id_nguoi_giao = '{$user_id}' OR id_nguoi_nhan = '{$user_id}')");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$list_lichsu_giaoviec = json_decode($class_member->list_lichsu_giaoviec($conn, $user_info['admin_cty'], $user_id, $page, $limit),true);
	$r_tt['list_lichsu_giaoviec'] = $list_lichsu_giaoviec['list'];
	$r_tt['start'] = $list_lichsu_giaoviec['start'];
	$r_tt['end'] = $list_lichsu_giaoviec['end'];
	$r_tt['phantrang'] = $class_member->phantrang($page,$total_page,'');
	
	// Hiển thị empty state nếu không có dữ liệu
	if(empty($r_tt['list_lichsu_giaoviec'])){
		$r_tt['list_lichsu_giaoviec'] = '<tr><td colspan="8" class="text-center" style="padding: 40px;"><div class="empty_state"><div class="empty_icon"><i class="fa fa-clipboard-check"></i></div><div class="empty_text"><h3>Chưa có công việc nào đã hoàn thành</h3><p>Danh sách các công việc đã hoàn thành sẽ hiển thị ở đây</p></div></div></td></tr>';
	}
	
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_lichsu_giaoviec',$r_tt);
}else if($action=='add_du-an'){
	$thaythe['title']='Thêm công việc trực tiếp';
	$thaythe['title_action']='Thêm dự án';
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/add_du_an',$r_tt);
}else if($action=='list_du-an'){
	$thaythe['title']='Danh sách dự án';
	$thaythe['title_action']='Danh sách dự án';
	$limit=5;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$thongke = mysqli_query($conn, "
	SELECT COUNT(DISTINCT da.id) AS total 
	FROM du_an as da
	WHERE da.admin_cty = '{$user_info['admin_cty']}' AND da.trang_thai != 6
	AND EXISTS (
		SELECT 1 
		FROM congviec_du_an cda
		WHERE cda.id_du_an = da.id
		AND (cda.id_nguoi_nhan = '{$user_info['user_id']}' 
			OR cda.id_nguoi_giao = '{$user_info['user_id']}')
	)");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$thongtin_nguoi_quan_ly = mysqli_query($conn, "SELECT * FROM user_info WHERE admin_cty='{$user_info['admin_cty']}'");
	$r_tt['list_nguoi_quan_ly'] = '';
	while ($r_nguoi_quan_ly = mysqli_fetch_assoc($thongtin_nguoi_quan_ly)) {
		$r_tt['list_nguoi_quan_ly'] .='<option value="' . $r_nguoi_quan_ly['user_id'] . '">' . $r_nguoi_quan_ly['name'] . '</option>';
	}
	$r_tt['search_list']='<button class="btn_filter" name="search_list_du_an_quanly"><i class="fa fa-search"></i> Tìm kiếm</button>';
	$list_du_an=json_decode($class_member->list_du_an($conn,$user_id,$user_info['admin_cty'],$page,$limit),true);
	$r_tt['list_du_an']=$list_du_an['list'];
	$r_tt['start']=$list_du_an['start'];
	$r_tt['end']=$list_du_an['end'];
	$r_tt['phantrang']=$class_member->phantrang($page,$total_page,'');
	$r_tt['id_phantrang']='phantrang_du_an';
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_du_an',$r_tt);
}else if($action=='list_lichsu-du-an'){

	$thaythe['title']='Lịch sử dự án';
	$thaythe['title_action']='Lịch sử dự án';
	$limit=5;
	$page = 1;
	if($page<1){
		$page=1;
	}
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
	$r_tt['list_lichsu_du_an'] = $list_lichsu_du_an['list'];
	$r_tt['start'] = $list_lichsu_du_an['start'];
	$r_tt['end'] = $list_lichsu_du_an['end'];
	$r_tt['phantrang'] = $class_member->phantrang($page,$total_page,'');
	
	// Hiển thị empty state nếu không có dữ liệu
	if(empty($r_tt['list_lichsu_du_an'])){
		$r_tt['list_lichsu_du_an'] = '<tr><td colspan="8" class="text-center" style="padding: 40px;"><div class="empty_state"><div class="empty_icon"><i class="fa fa-clipboard-check"></i></div><div class="empty_text"><h3>Chưa có dự án nào đã hoàn thành</h3><p>Danh sách các dự án đã hoàn thành sẽ hiển thị ở đây</p></div></div></td></tr>';
	}
	
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_lichsu_du_an',$r_tt);
}else if($action=='thongke_du-an'){
	$thaythe['title']='Thống kê dự án';
	$thaythe['title_action']='Thống kê dự án';
	
	$admin_cty = $user_info['admin_cty'];
	$user_id = $user_info['user_id'];
	$hientai = time();
	$nam = date('Y');
	$thang = date('m');

	$tu_ngay = isset($_GET['tu_ngay']) ? trim($_GET['tu_ngay']) : '';
	$den_ngay = isset($_GET['den_ngay']) ? trim($_GET['den_ngay']) : '';

	$tu_ngay_ts = 0;
	$den_ngay_ts = 0;

	if($tu_ngay != ''){
		$tu_ngay_ts = strtotime($tu_ngay . ' 00:00:00');
	}
	if($den_ngay != ''){
		$den_ngay_ts = strtotime($den_ngay . ' 23:59:59');
	}
	$r_tt = ['nam' => $nam, 'thang' => $thang, 'tu_ngay' => $tu_ngay, 'den_ngay' => $den_ngay];

	$tongquan = $class_member->thongke_tongquan_du_an($conn,$user_id, $admin_cty, $tu_ngay_ts, $den_ngay_ts);
	$r_tt = array_merge($r_tt, $tongquan);
	
	$thang_data = $class_member->thongke_thang_du_an($conn, $user_id, $admin_cty, $nam);
	$r_tt['data_thang_tao_du_an'] = $thang_data['data_thang_tao_du_an'];
	$r_tt['data_thang_nhanviec_du_an'] = $thang_data['data_thang_nhanviec_du_an'];
	$r_tt['data_thang_hoanthanh_du_an'] = $thang_data['data_thang_hoanthanh_du_an'];
	$r_tt['data_thang_tao_congviec'] = $thang_data['data_thang_tao_congviec'];
	$r_tt['data_thang_nhanviec_congviec'] = $thang_data['data_thang_nhanviec_congviec'];
	$r_tt['data_thang_hoanthanh_congviec'] = $thang_data['data_thang_hoanthanh_congviec'];
	
	
	
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/thongke_du_an',$r_tt);
}else if($action=='thongke_congviec'){

	$thaythe['title']='Thống kê công việc';
	$thaythe['title_action']='Thống kê công việc';
	$user_id = $user_info['user_id'];
	$admin_cty = $user_info['admin_cty'];
	$hientai = time();
	$nam = date('Y');
	$thang = date('m');

	// Lọc theo khoảng ngày (ngày tạo công việc)
	$tu_ngay = isset($_GET['tu_ngay']) ? trim($_GET['tu_ngay']) : '';
	$den_ngay = isset($_GET['den_ngay']) ? trim($_GET['den_ngay']) : '';

	$tu_ngay_ts = 0;
	$den_ngay_ts = 0;

	$r_tt = [
		'nam' => $nam,
		'thang' => $thang,
		'tu_ngay' => $tu_ngay,
		'den_ngay' => $den_ngay
	];

	$tongquan = $class_member->thongke_tongquan_congviec($conn, $user_id, $admin_cty, $tu_ngay_ts, $den_ngay_ts);
	$r_tt = array_merge($r_tt, $tongquan);	

	$thang_data = $class_member->thongke_thang_congviec($conn, $user_id, $admin_cty, $nam);
	$r_tt['data_thang_tao'] = $thang_data['data_thang_tao'];
	$r_tt['data_thang_nhanviec'] = $thang_data['data_thang_nhanviec'];
	$r_tt['data_thang_hoanthanh'] = $thang_data['data_thang_hoanthanh'];

	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/thongke_congviec',$r_tt);

}else if($action=='list_video'){
	$thaythe['title']='Danh sách video';
	$thaythe['title_action']='Danh sách video';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM video");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	if($r_tk['total']==0){
		$list_video='<div style="padding:10px;text-align:center;width:100%;">Hiện tại chưa có video nào!</div>';
	}else{
		$list_video=$class_index->list_video($conn,$page,$limit);	
	}
	$bien=array(
		'list_video'=>$list_video,
		'phantrang'=>$class_index->phantrang($page,$total_page,'/members/list-video')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_members/box_action/list_video',$bien);

}else{

}
echo $skin->skin_replace('skin_members/index',$thaythe);
?>