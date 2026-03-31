<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$thongtin=mysqli_query($conn,"SELECT * FROM list_container WHERE date_time='' ORDER BY id ASC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	if($r_tt['ngay']==''){
		$ngay=date('d/m/Y',$r_tt['date_post']);
		$date_time=$r_tt['date_post'];
		$thoi_gian=date('H:i',$r_tt['date_post']);
		mysqli_query($conn,"UPDATE list_container SET ngay='$ngay',thoi_gian='$thoi_gian',date_time='$date_time' WHERE id='{$r_tt['id']}'");
	}else{
		$ngay=$r_tt['ngay'];
		$thoi_gian=date('H:i',$r_tt['date_post']);
		$tach_ngay=explode('/', $ngay);
		$tach_gio=explode(':', $thoi_gian);
		$date_time=mktime($tach_gio[0],$tach_gio[1],0,$tach_ngay[1],$tach_ngay[0],$tach_ngay[2]);
		mysqli_query($conn,"UPDATE list_container SET ngay='$ngay',thoi_gian='$thoi_gian',date_time='$date_time' WHERE id='{$r_tt['id']}'");

	}

}
?>