<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$action=$_REQUEST['action'];
if($action=='huy_don'){
    $data=$_REQUEST;
    $xxx=json_encode($data);
    $log_huy='./uploads/log_ninja/log_huy_'.time().'.txt';
    $fh = fopen($log_huy, "w");
    fwrite($fh, $xxx);
    fclose($fh);
    echo $xxx;
}else if($action=='giao_thanhcong'){
    $data=$_REQUEST;
    $xxx=json_encode($data);
    $log_huy='./uploads/log_ninja/log_thanhcong_'.time().'.txt';
    $fh = fopen($log_huy, "w");
    fwrite($fh, $xxx);
    fclose($fh);
    echo $xxx;
}
?>