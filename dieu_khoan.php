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
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=48;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	if($user_info['nhom']==0){
		$link_member='/members/';
	}else{
		$link_member='/admincp/';

	}
}else{
	$box_header=$skin->skin_normal('skin/box_header');
}
$limit=11;
$list_tintuc=$class_index->list_dieukhoan($conn,2,$page,$limit);
$list_tintuc_right=$class_index->list_dieukhoan_right($conn,2,5);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'title'=>'Điều khoản - '.$index_setting['title'],
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'link_member'=>$link_member,
	'text_footer'=>$index_setting['text_footer'],
	'text_about'=>$index_setting['text_about'],
	'number_hotline'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'list_tintuc'=>$list_tintuc,
	'list_tintuc_right'=>$list_tintuc_right,
	'list_dieukhoan_footer'=>$class_index->list_dieukhoan_footer($conn,2,5),

	);
	echo $skin->skin_replace('skin/dieu_khoan',$replace);
?>