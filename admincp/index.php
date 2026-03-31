<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_cpanel');
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
$class_member=$tlca_do->load('class_member');
$class_giaoviec=$tlca_do->load('class_giaoviec');
$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
$user_id=$user_info['user_id'];
if(intval($user_id)<1){
	$thongbao="Thông tin không hợp lệ...";
	$replace=array(
		'title'=>'Thông tin không hợp lệ...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/admincp/logout'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();	
}
if($user_info['nhom']==0){
	$thongbao="Bạn không có quyền truy cập...";
	$replace=array(
		'title'=>'Bạn không có quyền truy cập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
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
$time_del_naptien=$index_setting['time_del_naptien']*60;
$gioihan_nap=time() - $time_del_naptien;
mysqli_query($conn,"DELETE FROM naptien WHERE date_post<'$gioihan_nap' AND status='0'");
$thaythe=array(
	'header'=>$skin->skin_normal('skin_cpanel/header'),
	'box_menu'=>$skin->skin_normal('skin_cpanel/box_menu'),
	'footer'=>$skin->skin_normal('skin_cpanel/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_cpanel/box_script_footer'),
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	//'phantrang'=>$class_index->phantrang($page,$total_page,'/'),
	'phantrang'=>'',
	'fullname'=>$user_info['name'],
	'email'=>$user_info['email'],
	'point'=>'0',
	'bo_phan'=>$user_info['bo_phan'],
	'thanhvien_chat'=>$user_info['id'],
	'name'=>$name,
	'avatar'=>$user_info['avatar'],
	'user_money'=>'0',
	'user_money2'=>'0'
);
if($action=='list_otp'){
	$thaythe['title']='Danh sách mã OTP';
	$thaythe['title_action']='Danh sách mã OTP';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT * FROM code_otp");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total=mysqli_num_rows($thongke);
	$total_page=ceil($total/$limit);
	$bien=array(
		'list_otp'=>$class_index->list_otp($conn,$total,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-otp')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_otp',$bien);
}else if($action=='profile'){
	$thaythe['title']='Profile';
	$thaythe['title_action']='Profile';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/profile',$user_info);
}else if($action=='change_password'){
	$thaythe['title']='Change Password';
	$thaythe['title_action']='Change Password';
	$bien=array(
		'phantrang'=>$class_index->phantrang($page,$total,10,'/admincp/list-nhac')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/change_password',$bien);


}else if($action=='add_phongban'){
	if(in_array('phongban', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm phòng ban mới';
	$thaythe['title_action']='Thêm phòng ban mới';
	$r_tt['list_phan_cap']=$class_giaoviec->list_option_phan_cap($conn, $user_info['admin_cty']);
	$r_tt['list_phongban']=$class_giaoviec->list_phongban($conn, $user_info['admin_cty']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_phongban',$r_tt);
}else if($action == 'dashboard'){
	if(in_array('dashboard', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Dashboard';
	$thaythe['title_action']='Dashboard';
	$admin_cty = $user_info['admin_cty'];
	$tong_phongban = mysqli_query($conn, "SELECT COUNT(*) AS total FROM phong_ban WHERE admin_cty='$admin_cty' ");
	$r_phongban = mysqli_fetch_assoc($tong_phongban);
	$bien['tong_phongban'] = $r_phongban['total'];	
	$tong_nhansu = mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_info WHERE admin_cty='$admin_cty' ");
	$r_nhansu = mysqli_fetch_assoc($tong_nhansu);
	$bien['tong_nhansu'] = $r_nhansu['total'];	
	$tong_congviec_tructiep = mysqli_query($conn, "SELECT COUNT(*) AS total FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' ");
	$r_congviec_tructiep = mysqli_fetch_assoc($tong_congviec_tructiep);
	$bien['tong_congviec_tructiep'] = $r_congviec_tructiep['total'];
	
	$tong_duan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM du_an WHERE admin_cty='$admin_cty' ");
	$r_tcd = mysqli_fetch_assoc($tong_duan);
	$bien['tong_duan'] = $r_tcd['total'];
	$tong_congviec_duan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM congviec_du_an WHERE admin_cty='$admin_cty' ");
	$r_congviec_duan = mysqli_fetch_assoc($tong_congviec_duan);
	$bien['tong_congviec_duan'] = $r_congviec_duan['total'];
	$bien['tong_congviec'] = $r_congviec_duan['total'] + $r_congviec_tructiep['total'];
	$thongke_deadline = mysqli_query($conn, "SELECT 
		SUM(CASE WHEN miss_deadline = '1' THEN 1 ELSE 0 END) AS tre_han,
		SUM(CASE WHEN miss_deadline = '1' THEN 0 ELSE 1 END) AS dung_han
		FROM (
			SELECT miss_deadline FROM giaoviec_tructiep WHERE admin_cty='$admin_cty'
			UNION ALL
			SELECT miss_deadline FROM congviec_du_an WHERE admin_cty='$admin_cty'
		) AS cv_deadline");
	$r_deadline = $thongke_deadline ? mysqli_fetch_assoc($thongke_deadline) : null;
	$cv_tre_han = (int) ($r_deadline['tre_han'] ?? 0);
	$cv_dung_han = (int) ($r_deadline['dung_han'] ?? 0);
	$bien['cv_tre_han'] = $cv_tre_han;
	$bien['cv_dung_han'] = $cv_dung_han;
	$bien['chart_deadline_json'] = json_encode(array('dung_han' => $cv_dung_han, 'tre_han' => $cv_tre_han), JSON_UNESCAPED_UNICODE);
	$thongke_trangthai = mysqli_query($conn, "SELECT trang_thai, COUNT(*) AS cnt FROM (
		SELECT trang_thai FROM giaoviec_tructiep WHERE admin_cty='$admin_cty'
		UNION ALL
		SELECT trang_thai FROM congviec_du_an WHERE admin_cty='$admin_cty'
	) AS cv_tt GROUP BY trang_thai ORDER BY trang_thai ASC");
	$map_tt = array(
		0 => 'Chờ xử lý',
		1 => 'Đang triển khai',
		2 => 'Chờ phê duyệt',

		4 => 'Từ chối',
		5 => 'Xin gia hạn',
		6 => 'Đã hoàn thành',
	);
	$color_tt = array(
		0 => '#FF9800',
		1 => '#2196F3',
		2 => '#FFC107',
		3 => '#dc3545',
		4 => '#E91E63',
		5 => '#9C27B0',
		6 => '#4CAF50',
	);
	$labels_tt = array();
	$values_tt = array();
	$colors_tt = array();
	if ($thongke_trangthai) {
		while ($r_tt = mysqli_fetch_assoc($thongke_trangthai)) {
			$st = (int) $r_tt['trang_thai'];
			$cnt = (int) $r_tt['cnt'];
			$labels_tt[] = isset($map_tt[$st]) ? $map_tt[$st] : ('Trạng thái ' . $st);
			$values_tt[] = $cnt;
			$colors_tt[] = isset($color_tt[$st]) ? $color_tt[$st] : '#9E9E9E';
		}
	}
	$bien['chart_trangthai_json'] = json_encode(array(
		'labels' => $labels_tt,
		'values' => $values_tt,
		'colors' => $colors_tt,
	), JSON_UNESCAPED_UNICODE);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/dashboard',$bien);

}else if($action=='thongke_congviec'){
	if(in_array('phongban', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thống kê công việc';
	$thaythe['title_action']='Thống kê công việc';
	$limit=10;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$thongke = mysqli_query($conn, "
		SELECT COUNT(*) AS total FROM giaoviec_tructiep as gv WHERE gv.admin_cty = '{$user_info['admin_cty']}'
	");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$list_thongke_congviec = json_decode($class_giaoviec->list_thongke_congviec($conn, $user_info['admin_cty'], $page, $limit),true);
	$r_tt['list_thongke_congviec'] = $list_thongke_congviec['list'];
	$r_tt['start'] = $list_thongke_congviec['start'];
	$r_tt['end'] = $list_thongke_congviec['end'];
	$r_tt['phantrang'] = $class_giaoviec->phantrang($page,$total_page,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thongke_giaoviec',$r_tt);
}else if($action=='thongke_du-an'){
	if(in_array('phongban', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thống kê dự án';
	$thaythe['title_action']='Thống kê dự án';
	$limit=10;
	$page = 1;
	if($page<1){
		$page=1;
	}
	$thongke = mysqli_query($conn, "
		SELECT COUNT(*) AS total FROM du_an as da WHERE da.admin_cty = '{$user_info['admin_cty']}'
	");
	$r_tk = mysqli_fetch_assoc($thongke);
	$r_tt['total'] = $r_tk['total'];
	$total_page = ceil($r_tt['total']/$limit);
	$list_thongke_du_an = json_decode($class_giaoviec->list_thongke_du_an($conn, $user_info['admin_cty'], $page, $limit),true);
	$r_tt['list_thongke_du_an'] = $list_thongke_du_an['list'];
	$r_tt['start'] = $list_thongke_du_an['start'];
	$r_tt['end'] = $list_thongke_du_an['end'];
	$r_tt['phantrang'] = $class_giaoviec->phantrang($page,$total_page,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thongke_du_an',$r_tt);
}else if($action=='add_video'){
	if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm video mới';
	$thaythe['title_action']='Thêm video mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_video',$r_tt);
}else if($action=='edit_video'){
	if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chỉnh sửa video';
	$thaythe['title_action']='Chỉnh sửa video';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM video WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_video',$r_tt);
}else if($action=='list_video'){
	if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách video';
	$thaythe['title_action']='Danh sách video';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM video");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	if($r_tk['total']==0){
		$list_video='<tr><td colspan="6">Bạn chưa có giao dịch nào!</td></tr>';
	}else{
		$list_video=$class_index->list_video($conn,$r_tk['total'],$page,$limit);	
	}
	$bien=array(
		'list_video'=>$list_video,
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-video')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_video',$bien);

	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm tỉnh mới';
	$thaythe['title_action']='Thêm tỉnh mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_tinh',$r_tt);
}else if($action=='add_baiviet'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm bài viết mới';
	$thaythe['title_action']='Thêm bài viết mới';
	$r_tt['option_danhmuc']=$class_index->list_option_danhmuc($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_baiviet',$r_tt);
}else if($action=='edit_baiviet'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chỉnh sửa bài viết';
	$thaythe['title_action']='Chỉnh sửa bài viết';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM bai_viet WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Bài viết không tồn tại...";
		$replace=array(
			'title'=>'Bài viết không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-baiviet'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	$r_tt['gia']=number_format($r_tt['gia']);
	$r_tt['option_danhmuc']=$class_index->list_option_danhmuc($conn,$r_tt['cat']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_baiviet',$r_tt);
}else if($action=='list_baiviet'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách bài viết';
	$thaythe['title_action']='Danh sách bài viết';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM bai_viet");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_baiviet'=>$class_index->list_baiviet($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-baiviet')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_baiviet',$bien);
}else if($action=='add_danhmuc'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm danh mục bài viết';
	$thaythe['title_action']='Thêm danh mục bài viết';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_danhmuc',$r_tt);
}else if($action=='edit_danhmuc'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chỉnh sửa danh mục bài viết';
	$thaythe['title_action']='Chỉnh sửa danh mục bài viết';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM danhmuc_baiviet WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Bài viết không tồn tại...";
		$replace=array(
			'title'=>'Danh mục bài viết không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-danhmuc'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	$r_tt['gia']=number_format($r_tt['gia']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_danhmuc',$r_tt);
}else if($action=='list_danhmuc'){
	if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách danh mục';
	$thaythe['title_action']='Danh sách danh mục';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM danhmuc_baiviet");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_danhmuc'=>$class_index->list_danhmuc($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-danhmuc')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_danhmuc',$bien);
}else if($action=='add_naptien'){
	if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Tặng, hoàn tiền';
	$thaythe['title_action']='Tặng, hoàn tiền';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_naptien',$r_tt);
}else if($action=='edit_naptien'){
	if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Sửa giao dịch nạp tiền';
	$thaythe['title_action']='Sửa giao dịch nạp tiền';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM naptien WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Giao dịch không tồn tại...";
		$replace=array(
			'title'=>'Giao dịch không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-naptien'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_naptien',$r_tt);
}else if($action=='list_naptien'){
	if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Lịch sử nạp tiền';
	$thaythe['title_action']='Lịch sử nạp tiền';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM naptien");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_naptien'=>$class_index->list_naptien($conn,$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-naptien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_naptien',$bien);
}else if($action=='add_goi-giahan'){
	if(in_array('giahan', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thêm gói gia hạn mới';
	$thaythe['title_action']='Thêm gói gia hạn mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_goi_giahan',$r_tt);
}else if($action=='edit_goi-giahan'){
	if(in_array('giahan', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Sửa gói gia hạn';
	$thaythe['title_action']='Sửa gói gia hạn';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM goi_giahan WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Gói gia hạn không tồn tại...";
		$replace=array(
			'title'=>'Gói gia hạn không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-goi-giahan'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	$r_tt['gia']=number_format($r_tt['gia']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_goi_giahan',$r_tt);

    $thaythe['title']='Danh sách booking trả phí';
    $thaythe['title_action']='Danh sách booking trả phí';
    $limit=25;
    $hientai=time();
    // Chỉ lấy các booking có `ket_hop=1`
    $thongtin_booking_xuat=mysqli_query($conn, "SELECT count(*) AS total FROM booking WHERE status='0' AND loai_hinh='hangxuat' AND user_id='$user_id' AND ket_hop='1'");
    $r_hangxuat=mysqli_fetch_assoc($thongtin_booking_xuat);
    $bien=array(
        'option_hangtau'=>$class_index->list_option_hangtau($conn,''),
        'option_container'=>$class_index->list_option_container($conn,''),    
        'option_tinh'=>$class_index->list_option_tinh($conn,''),
        'list_tinh'=>$class_index->list_goiy_tinh($conn,''),
        'list_hangtau'=>$class_index->list_goiy_hangtau($conn,''),    
        'list_hangxuat'=>$class_index->list_booking_traphi($conn,$user_id, 1, $limit),    
        'total_hangxuat'=>number_format($r_hangxuat['total']),
        'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-booking-traphi')
    );
    $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_booking_traphi',$bien);


}else if($action=='list_chitieu'){
	if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Lịch sử chi tiêu';
	$thaythe['title_action']='Lịch sử chi tiêu';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM lichsu_chitieu");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_chitieu'=>$class_index->list_chitieu($conn,$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-chitieu')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_chitieu',$bien);
}else if($action=='list_ruttien'){
	if(in_array('ruttien', explode(',', $user_info['emin_group']))==false AND in_array('xem_ruttien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Lịch sử rút tiền';
	$thaythe['title_action']='Lịch sử rút tiền';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM rut_tien");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_ruttien'=>$class_index->list_ruttien($conn,$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-ruttien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_ruttien',$bien);
}else if($action=='edit_ruttien'){
	if(in_array('ruttien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Sửa giao dịch rút tiền';
	$thaythe['title_action']='Sửa giao dịch rút tiền';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM rut_tien WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Giao dịch không tồn tại...";
		$replace=array(
			'title'=>'Giao dịch không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-ruttien'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_ruttien',$r_tt);

	if(in_array('booking', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chi tiết đặt booking';
	$thaythe['title_action']='Chi tiết đặt booking';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT list_booking.*, count(*) AS total,list_container.so_hieu,list_container.ma_booking,list_container.thoi_gian AS thoi_gian_booking,list_container.ngay AS ngay_booking FROM list_booking LEFT JOIN list_container ON list_booking.id_container=list_container.id WHERE list_booking.id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Dữ liệu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin_members/chuyenhuong',$replace);
		exit();
	}
	$thongtin_nguoidang=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
	$r_nd=mysqli_fetch_assoc($thongtin_nguoidang);
	$r_tt['cong_ty']=$r_nd['cong_ty'];
	$r_tt['ho_ten']=$r_nd['name'];
	$r_tt['dien_thoai']=$r_nd['mobile'];
	$r_tt['maso_thue']=$r_nd['maso_thue'];
	$r_tt['email']=$r_nd['email'];
	$thongtin_nguoidat=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_dat']}'");
	$r_dat=mysqli_fetch_assoc($thongtin_nguoidat);
	$r_tt['cong_ty_dat']=$r_dat['cong_ty'];
	$r_tt['ho_ten_dat']=$r_dat['name'];
	$r_tt['dien_thoai_dat']=$r_dat['mobile'];
	$r_tt['maso_thue_dat']=$r_dat['maso_thue'];
	$r_tt['email_dat']=$r_dat['email'];
	$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_tt['ma_booking']}'");
	$r_booking=mysqli_fetch_assoc($thongtin_booking);
	$r_tt['hang_tau']=$r_booking['ten_hangtau'];
	$r_tt['loai_container']=$r_booking['ten_loai_container'];
	$r_tt['phi_booking']=number_format($index_setting['phi_booking']);
	$r_tt['gia']=number_format($r_tt['gia']);
	$r_tt['tinh']=$r_booking['ten_tinh'];
	$r_tt['huyen']=$r_booking['ten_huyen'];
	$r_tt['xa']=$r_booking['ten_xa'];
	$r_tt['so_booking']=$r_booking['so_booking'];
	$r_tt['diachi_trahang']=$r_booking['diachi_trahang'];
	$r_tt['diachi_donghang']=$r_booking['diachi_donghang'];
	$r_tt['mat_hang']=$r_booking['mat_hang'];
	$r_tt['trong_luong']=$r_booking['trong_luong'];
	$r_tt['ghi_chu']=$r_booking['ghi_chu'];
	$r_tt['gia_booking']=number_format($r_booking['gia']);
	$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
	if($r_tt['status']==0){
		$r_tt['status']='<span style="color:#f60;font-weight:700;">Chờ xác nhận</span>';
		$r_tt['lien_he']='Sẽ hiển thị sau khi được chấp nhận';
		$r_tt['button_rate']='';
	}else if($r_tt['status']==1){
		$r_tt['status']='Đã hoàn thành';
		$r_tt['lien_he']='';
		$r_tt['button_rate']='';
	}else if($r_tt['status']==2){
		$r_tt['status']='Đã chấp nhận';
		if($user_id==$r_tt['user_dat']){
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_dat']}'");
			$r_tv=mysqli_fetch_assoc($thongtin_thanhvien);
		}
		$r_tt['lien_he']=$r_tv['mobile'];
		$r_tt['button_rate']='';
	}else if($r_tt['status']==3){
		$r_tt['status']='Đã từ chối';
		$r_tt['lien_he']='Chỉ hiển thị khi được chấp nhận';
		$r_tt['button_rate']='';
	}else if($r_tt['status']==4){
		$r_tt['status']='Đã hủy';
		$r_tt['lien_he']='Chỉ hiển thị khi được chấp nhận';
		$r_tt['button_rate']='';
	}
	if($r_booking['loai_hinh']=='hangnhap'){
		$r_tt['diachi_donghang']=$r_booking['ten_cang'];
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/view_dat_booking_hangnhap',$r_tt);
	}else{
		$r_tt['diachi_trahang']=$r_booking['ten_cang'];
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/view_dat_booking_hangxuat',$r_tt);
	}
}else if($action=='list_danhgia'){
	if(in_array('danhgia', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách đánh giá của bạn';
	$thaythe['title_action']='Danh sách đánh giá của bạn';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_rate");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	if($r_tk['total']==0){
		$list_rate='<div style="padding:20px;text-align:center">Bạn chưa có đánh giá nào</div>';
	}else{
		$list_rate=$class_index->list_danhgia($conn,$page,$limit);
	}
	$bien=array(
		'list_rate'=>$list_rate,
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-danhgia')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_danhgia',$bien);

	if(in_array('tinh', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách xã/phường/thị trấn';
	$thaythe['title_action']='Danh sách xã/phường/thị trấn';
	$limit=100;
	$huyen=addslashes($url_query['huyen']);
	$thongtin=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi LEFT JOIN tinh_moi ON huyen_moi.tinh=tinh_moi.id WHERE huyen_moi.id='$huyen'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM xa_moi WHERE huyen='$huyen'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'ten_tinh'=>$r_tt['ten_tinh'],
		'ten_huyen'=>$r_tt['tieu_de'],
		'huyen'=>$huyen,
		'list_xa'=>$class_index->list_xa($conn,$huyen,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-xa?huyen='.$huyen)
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_xa',$bien);
}else if($action=='edit_setting'){
	if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chỉnh sửa cài đặt';
	$thaythe['title_action']='Chỉnh sửa cài đặt';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM index_setting WHERE name='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Mục cài đặt không tồn tại...";
		$replace=array(
			'title'=>'Mục cài đặt không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-setting'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	if($r_tt['loai']=='img'){
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting_img',$r_tt);
	}else if($r_tt['loai']=='html'){
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting_html',$r_tt);
	}else{
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting',$r_tt);
	}

	if(in_array('hangtau', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách phí kết hợp';
	$thaythe['title_action']='Danh sách phí kết hợp';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM phi_kethop");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_phi_kethop'=>$class_index->list_phi_kethop($conn,$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-hangtau')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_phi_kethop',$bien);

	if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Sửa quản trị viên';
	$thaythe['title_action']='Sửa quản trị viên';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE user_id='$id' AND nhom='1'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Quản trị viên không tồn tại...";
		$replace=array(
			'title'=>'Quản trị viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-quantri'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	if(strpos($r_tt['emin_group'], ',')!==false){
		$tach_group=explode(',', $r_tt['emin_group']);
		foreach ($tach_group as $key => $value) {
			$list_group.="$('.list_checkbox input[type=\"checkbox\"][value=\"".$value."\"]').prop('checked', true);";
		}
	}else if(strlen($r_tt['emin_group'])==1){
		$list_group.="$('.list_checkbox input[type=\"checkbox\"]').prop('checked', true);";
	}else if($r_tt['emin_group']!=''){
		$list_group.="$('.list_checkbox input[type=\"checkbox\"][value=\"".$r_tt['emin_group']."\"]').prop('checked', true);";
	}else{
		$list_group='';
	}
	$r_tt['list_group']=$list_group;
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_quantri',$r_tt);
}else if($action=='list_thanhvien'){
	if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách thành viên';
	$thaythe['title_action']='Danh sách thành viên';
	$limit=100;
	if($user_info['nhom']==1){
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE nhom='0'");
	}else{
		$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE nhom='0'");
	}
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien($conn,'all',$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien',$bien);
}else if($action=='edit_thanhvien'){
	if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thông tin thành viên';
	$thaythe['title_action']='Thông tin thành viên';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thành viên này không tồn tại...";
		$replace=array(
			'title'=>'Thành viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-thanhvien'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	if($r_tt['nhom']!=''){
		$thongtin_nhom=mysqli_query($conn,"SELECT *,count(*) AS total FROM nhom WHERE id='{$r_tt['nhom']}'");
		$r_nhom=mysqli_fetch_assoc($thongtin_nhom);
		if($r_nhom['total']>0){
			$r_tt['ten_nhom']=$r_nhom['tieu_de'];
		}else{
			$r_tt['ten_nhom']='Chưa tham gia nhóm';
		}

	}else{
		$r_tt['ten_nhom']='Chưa tham gia nhóm';
	}
	$r_tt['user_money']='0';
	$r_tt['user_money2']='0';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_thanhvien',$r_tt);
} else if ($action == 'list_chat') {
	if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title'] = 'Danh sách yêu cầu hỗ trợ';
	$thaythe['title_action'] = 'Danh sách yêu cầu hỗ trợ';
	$limit = 100;
	if($user_info['bo_phan']=='all'){
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE /*chat.active='1' AND */chat.noi_dung='' ORDER BY chat.id DESC LIMIT 1");
	}else{
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name FROM chat INNER JOIN user_info ON user_info.user_id=chat.thanh_vien WHERE chat.active='1' AND chat.bo_phan='{$user_info['bo_phan']}' AND chat.noi_dung='' ORDER BY chat.id DESC LIMIT 1");
	}
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		$list_chat='';
		$list_yeucau='';
		$ho_ten='';
		$note='';
		$phien='';
		$thanh_vien='';
	}else{
		$r_tt=mysqli_fetch_assoc($thongtin);
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['thanh_vien']}'");
		$r_user=mysqli_fetch_assoc($thongtin_thanhvien);
		$phien=$r_tt['phien'];
		$thongtin_cuoi=mysqli_query($conn,"SELECT * FROM chat WHERE phien='$phien' ORDER BY id DESC LIMIT 1");
		$r_c=mysqli_fetch_assoc($thongtin_cuoi);
		$sms_id=$r_c['id'] + 1;
		$tach_chat=json_decode($class_index->list_chat($conn,$user_info['user_id'],$user_info['name'],$user_info['avatar'],$r_user['name'],$r_user['avatar'],$r_c['user_out'], $phien,$sms_id,10),true);
		$list_yeucau=$class_index->list_yeucau($conn,$user_info['user_id'],$user_info['bo_phan'],$r_c['thanh_vien']);
		$ho_ten=$r_tt['name'];
		$note=$r_tt['tieu_de'];
		$thanh_vien=$r_c['thanh_vien'];
	}
	$bien=array(
		'ok'=>1,
		'list_chat'=>$tach_chat['list'],
		'list_yeucau'=>$list_yeucau,
		'ho_ten'=>$ho_ten,
		'note'=>$note,
		'phien'=>$phien,
		'thanh_vien'=>$thanh_vien,
		'user_id'=>$user_info['user_id'],
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_chat', $bien);
}else if($action=='contact_detail'){
	if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Chi tiết liên hệ';
	$thaythe['title_action']='Chi tiết liên hệ';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM lien_he WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Liên hệ không tồn tại...";
		$replace=array(
			'title'=>'Liên hệ không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/list-lienhe'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	mysqli_query($conn, "UPDATE lien_he SET status='1' WHERE id='$id'");
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/contact_detail',$r_tt);
}else if($action=='list_lienhe') {
	if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title'] = 'Danh sách liên hệ';
	$thaythe['title_action'] = 'Danh sách liên hệ';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM lien_he");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_lienhe' => $class_index->list_lienhe($conn, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/list-lienhe'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_lienhe', $bien);
}else if($action=='list_setting'){
	if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Danh sách cài đặt';
	$thaythe['title_action']='Danh sách cài đặt';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM index_setting");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_setting'=>$class_index->list_setting($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-setting')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_setting',$bien);

	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thống kê thành viên';
	$thaythe['title_action']='Thống kê thành viên';
	$limit=10;
	$homnay=date('d');
	$thangnay=intval(date('m'));
	$namnay=date('Y');
	$date  = mktime(0, 0, 0, $thangnay, $homnay, $namnay);
	$week  = (int)date('W', $date);
	$ngay_dau=mktime(0,0,0,01,01,date('Y'));
	$ngay_cuoi=mktime(0,0,0,12,31,date('Y'));
	if($thangnay==2){
		if(checkdate(02,29,$namnay)==true){
			$ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
			$ngay_cuoi_thang=mktime(0,0,0,$thangnay,29,$namnay);
			for ($i=1; $i <=29 ; $i++) {
				if($i<10){
					$list_ngay.='0'.$i.',';
				}else{
					$list_ngay.=$i.',';
				}
			}
		}else{
			$ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
			$ngay_cuoi_thang=mktime(0,0,0,$thangnay,28,$namnay);
			for ($i=1; $i <=20 ; $i++) { 
				if($i<10){
					$list_ngay.='0'.$i.',';
				}else{
					$list_ngay.=$i.',';
				}
			}

		}
	}else if(in_array($thangnay, array('1','3','5','7','8','10','12'))==true){
		$ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
		$ngay_cuoi_thang=mktime(0,0,0,$thangnay,31,$namnay);
		for ($i=1; $i <=31 ; $i++) { 
			if($i<10){
				$list_ngay.='0'.$i.',';
			}else{
				$list_ngay.=$i.',';
			}
		}
	}else{
		$ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
		$ngay_cuoi_thang=mktime(0,0,0,$thangnay,30,$namnay);
		for ($i=1; $i <=30 ; $i++) { 
			if($i<10){
				$list_ngay.='0'.$i.',';
			}else{
				$list_ngay.=$i.',';
			}
		}
	}
	$list_ngay=substr($list_ngay, 0,-1);
	$ngay_tuan=$check->day_from_monday(date('d-m-Y'));
	$ngay_dau_tuan=mktime(0,0,0,$thangnay,$ngay_tuan[0],$namnay);
	$ngay_cuoi_tuan=mktime(0,0,0,$thangnay,$ngay_tuan[6],$namnay);
	$bien=array(
		'tuan'=>$week,
		'thang'=>date('m'),
		'nam'=>date('Y'),
		'ngay'=>date('d'),
		'ngay_dau_tuan'=>$ngay_tuan[0].'/'.$thangnay.'/'.$namnay,
		'ngay_cuoi_tuan'=>$ngay_tuan[6].'/'.$thangnay.'/'.$namnay,
		'data_nam'=>$class_index->thongke_thanhvien_nam($conn,$user_id,$user_info['nhom'],$ngay_dau,$ngay_cuoi),
		'list_ngay'=>$list_ngay,
		'data_thang'=>$class_index->thongke_thanhvien_thang($conn,$user_id,$user_info['nhom'],$thangnay,$namnay,$ngay_dau_thang,$ngay_cuoi_thang),
		'data_tuan'=>$class_index->thongke_thanhvien_tuan($conn,$user_id,$user_info['nhom'],$ngay_dau_tuan,$ngay_cuoi_tuan)
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_thanhvien',$bien);

	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$id=intval($url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thaythe['title']='Báo cáo doanh số chi tiêu của CSKH '.$r_tt['name'];
	$thaythe['title_action']='Báo cáo doanh số chi tiêu của CSKH '.$r_tt['name'];
	$end=date('d/m/Y');
	$date_end=date('d');
	$month_end=date('m');
	$year_end=date('Y');
	$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
	$begin_time=$end_time - 31*24*3600;
	$begin=date('d/m/Y',$begin_time);
	$thongke=json_decode($class_index->thongke_doanhso_chitieu_cskh($conn,$id,$begin_time,$end_time),true);
	$bien=array(
		'footer'=>$skin->skin_normal('skin_admin/footer'),
		'end'=>$end,
		'begin'=>$begin,
		'doanhso_chi'=>number_format($thongke['doanhso_chi']),
		'doanhso_hoan'=>number_format($thongke['doanhso_hoan']),
		'giaodich_chi'=>number_format($thongke['giaodich_chi']),
		'giaodich_hoan'=>number_format($thongke['giaodich_hoan']),
		'id'=>$id
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_doanhso_chitieu_cskh',$bien);

	if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1 AND $user_info['nhom']!=2){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();		
	}
	$thaythe['title']='Thống kê booking';
	$thaythe['title_action']='Thống kê booking';
	$end=date('d/m/Y');
	$date_end=date('d');
	$month_end=date('m');
	$year_end=date('Y');
	$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
	$begin_time=$end_time - 31*24*3600;
	$begin=date('d/m/Y',$begin_time);
	$thongke=json_decode($class_index->thongke_booking($conn,$user_id,$user_info['nhom'],$begin_time,$end_time),true);
	$bien=array(
		'end'=>$end,
		'begin'=>$begin,
		'doanhso_cho_xacnhan'=>number_format($thongke['doanhso_cho_xacnhan']),
		'doanhso_hoanthanh'=>number_format($thongke['doanhso_hoanthanh']),
		'doanhso_xacnhan'=>number_format($thongke['doanhso_xacnhan']),
		'doanhso_tuchoi'=>number_format($thongke['doanhso_tuchoi']),
		'doanhso_cho'=>number_format($thongke['doanhso_cho']),
		'doanhso_tao'=>number_format($thongke['doanhso_tao']),
		'booking_cho_xacnhan'=>number_format($thongke['booking_cho_xacnhan']),
		'booking_hoanthanh'=>number_format($thongke['booking_hoanthanh']),
		'booking_xacnhan'=>number_format($thongke['booking_xacnhan']),
		'booking_tuchoi'=>number_format($thongke['booking_tuchoi']),
		'booking_cho'=>number_format($thongke['booking_cho']),
		'booking_tao'=>number_format($thongke['booking_tao']),
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_booking',$bien);
}else{

}
echo $skin->skin_replace('skin_cpanel/index',$thaythe);
?>