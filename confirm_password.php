<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$email=addslashes($url_query['email']);
$token=addslashes($url_query['token']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM forgot_password WHERE email='$email' AND code_active='$token'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Link không tồn tại hoặc đã được sử dụng...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}else{
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
		'title'=>'Thiết lập mật khẩu mới - '.$index_setting['title'],
		'description'=>$index_setting['description'],
		'site_name'=>$index_setting['site_name'],
		'number_hotline'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
		'limit'=>$limit,
		'logo'=>$index_setting['logo'],
		'text_footer'=>$index_setting['text_footer'],
		'text_about'=>$index_setting['text_about'],
		'email'=>$email,
		'token'=>$token,
		'aff'=>$aff

		);
	echo $skin->skin_replace('skin/confirm_password',$replace);
}
?>