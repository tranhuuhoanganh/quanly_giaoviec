<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$page=intval($page);
if($page>1){
	$page=$page;
	$title_page=' - Page '.$page;
}else{
	$page=1;
	$title_page='';
}
$sort=addslashes($url_query['sort']);
if($url_query['aff']){
	$aff=addslashes(strip_tags($url_query['aff']));
	setcookie("aff",$aff,time() + 2592000,'/');
}else{
	if(isset($_COOKIE['aff'])){
		$aff=$_COOKIE['aff'];
	}else{
		$aff='';
	}
}
if($aff==''){

}else{
	$thongtin_aff=mysqli_query($conn,"SELECT * FROM user_info WHERE username='$aff'");
	$total_aff=mysqli_num_rows($thongtin_aff);
	if($total_aff==0){
		$aff='';
	}

}
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
if(isset($_COOKIE['user_id'])){
	$thongbao="Bạn hiện đã đăng nhập.";
	$replace=array(
		'header'=>$skin->skin_normal('skin/header'),
		'script_footer'=>$skin->skin_normal('skin/script_footer'),
		'logo'=>$index_setting['logo'],
		'title'=>'Bạn đã đăng nhập tài khoản',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}else{
}
$limit=48;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
}else{
	$box_header=$skin->skin_normal('skin/box_header');
}
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'title'=>'Đăng ký tài khoản - '.$index_setting['title'],
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'number_hotline'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_about'=>$index_setting['text_about'],
	'list_dieukhoan_footer'=>$class_index->list_dieukhoan_footer($conn,2,5),
	'aff'=>$aff

	);
echo $skin->skin_replace('skin/dang_ky',$replace);
?>