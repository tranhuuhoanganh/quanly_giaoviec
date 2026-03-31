<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$thongtin=mysqli_query($conn,"SELECT * FROM user_info ORDER BY user_id ASC");

while($r_tt=mysqli_fetch_assoc($thongtin)){
	//$han=mktime(23,59,29,06,30,2024);
	$thongtin_kichhoat=mysqli_query($conn,"SELECT * FROM kich_hoat WHERE user_id='{$r_tt['user_id']}'");
	$total_kichhoat=mysqli_num_rows($thongtin_kichhoat);
	if($total_kichhoat==0){
		$han=time() + 90*3600*24;
	}else{
		$r_sudung=mysqli_fetch_assoc($thongtin_kichhoat);
		$sudung_expired=$r_sudung['date_end'] - time();
		if($sudung_expired>0){
			$han=$r_sudung['date_end'] + 90*3600*24;
		}else{
			$han=time() + 90*3600*24;
		}
	}
	mysqli_query($conn,"INSERT INTO kich_hoat(user_id,so_tien,date_end,date_post)VALUES('{$r_tt['user_id']}','0','$han',".time().")");
}
?>