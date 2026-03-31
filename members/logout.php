<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_thanhvien');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$class_member=$tlca_do->load('class_member');
$skin=$tlca_do->load('class_skin_cpanel');
if(isset($_COOKIE['user_id'])){
	setcookie("user_id",$_COOKIE['user_id'],time() - 3600,'/');
	$thongbao="Đăng xuất tài khoản thành công.";
	$replace=array(
		'title'=>'Hệ thống chuyển hướng...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}else{
	$thongbao="Hiện tại bạn chưa đăng nhập.";
	$replace=array(
		'title'=>'Hệ thống chuyển hướng...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>