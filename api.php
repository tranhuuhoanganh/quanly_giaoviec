<?php
include './includes/tlca_world.php';
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$api_token=array('9981');
$token=addslashes(strip_tags($_REQUEST['token']));
if(in_array($token, $api_token)==true){
	if($action=='get_order'){
		$partner=addslashes(strip_tags($_REQUEST['partner']));
		$page=intval($_REQUEST['page']);
		$limit=intval($_REQUEST['limit']);
		$start=$limit*$page - $limit;
		$thongtin=mysqli_query($conn,"SELECT * FROM donhang WHERE utm_source='$partner' ORDER BY id DESC LIMIT $start,$limit");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$ok=0;
			$thongbao='Không có dữ liệu nào phù hợp';
			$list='';
		}else{
			$ok=1;
			$thongbao='Lấy dự liệu thành công';
			while($r_tt=mysqli_fetch_assoc($thongtin)){
				$list[]=$r_tt;
			}
		}
		echo json_encode($list);

	}else {
		echo "Không có hành động nào được xử lý";
	}
}else{
	$ok=0;
	$thongbao='Bạn không có quyền truy cập';
}
?>