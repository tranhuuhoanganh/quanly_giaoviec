<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$email=addslashes($url_query['email']);
$token=addslashes($url_query['token']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE email='$email' AND code_active='$token' AND active='0'");
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
	mysqli_query($conn,"UPDATE user_info SET active='1' WHERE email='$email'");
	function token_login($user_id,$password){
	    $pass_1=substr($password, 0,8);
	    $pass_2=substr($password, 8,8);
	    $pass_3=substr($password, 16,8);
	    $pass_4=substr($password, 24,8);
	    $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
	    $token_login=base64_encode($string);
	    return $token_login;
	}
	setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
	$thongbao="Kích hoạt tài khoản thành công...";
	$replace=array(
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/members/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>