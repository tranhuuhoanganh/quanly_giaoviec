 <?php
class class_cpanel extends class_manage {
	///////////////////
	function list_menu($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM menu ORDER BY menu_vitri ASC, menu_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['menu_vitri'] == 'left') {
				$r_tt['menu_vitri'] = 'Menu Trái';
			} else if ($r_tt['menu_vitri'] == 'huongdan') {
				$r_tt['menu_vitri'] = 'Menu hướng dẫn';
			} else if ($r_tt['menu_vitri'] == 'chinhsach') {
				$r_tt['menu_vitri'] = 'Menu chính sách';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_menu', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_danhmuc($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM danhmuc_baiviet ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_danhmuc', $r_tt);
		}
		return $list;
	}
	function list_otp($conn,$total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM code_otp ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_otp', $r_tt);
		}
		return $list;
	}
    function creat_random($conn,$loai){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        if($loai=='phien_traodoi'){
	        $string=$check->random_string(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM chat WHERE phien='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }
    }
	////////////////////
	function list_danhgia($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT list_rate.*,user_info.name,user_info.mobile FROM list_rate LEFT JOIN user_info ON list_rate.user_id=user_info.user_id ORDER BY list_rate.update_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['update_post']>$r_tt['date_post']){
				$r_tt['text_rate']='Chỉnh sửa lúc';
			}else{
				$r_tt['text_rate']='Đánh giá lúc';
			}
			$con=5 - $r_tt['rate'];
			for ($i=1; $i <=$r_tt['rate'] ; $i++) { 
				$list_star.='<i class="fa fa-star"></i>';
			}
			for ($i=1; $i <=$con ; $i++) { 
				$list_star_o.='<i class="fa fa-star-o"></i>';
			}
			$r_tt['mobile']=substr($r_tt['mobile'], 0, - 3).'***';
			$r_tt['list_star']=$list_star.''.$list_star_o;
			unset($list_star);
			unset($list_star_o);				
			$r_tt['update_post']=date('H:i d/m/Y',$r_tt['update_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_rate', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_danhgia_khach($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT list_rate.*,user_info.name,user_info.mobile FROM list_rate LEFT JOIN user_info ON list_rate.user_id=user_info.user_id WHERE list_rate.user_to='$user_id' ORDER BY list_rate.update_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['update_post']>$r_tt['date_post']){
				$r_tt['text_rate']='Chỉnh sửa lúc';
			}else{
				$r_tt['text_rate']='Đánh giá lúc';
			}
			$con=5 - $r_tt['rate'];
			for ($i=1; $i <=$r_tt['rate'] ; $i++) { 
				$list_star.='<i class="fa fa-star"></i>';
			}
			for ($i=1; $i <=$con ; $i++) { 
				$list_star_o.='<i class="fa fa-star-o"></i>';
			}
			$r_tt['mobile']=substr($r_tt['mobile'], 0, - 3).'***';
			$r_tt['list_star']=$list_star.''.$list_star_o;	
			unset($list_star);
			unset($list_star_o);		
			$r_tt['update_post']=date('H:i d/m/Y',$r_tt['update_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_rate_khach', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_booking($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM booking ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_tau=mysqli_query($conn,"SELECT * FROM list_hangtau WHERE id='{$r_tt['hang_tau']}'");
			$r_tau=mysqli_fetch_assoc($thongtin_tau);
			$r_tt['hang_tau']=$r_tau['tieu_de'];
			$thongtin_container=mysqli_query($conn,"SELECT * FROM loai_container WHERE id='{$r_tt['loai_container']}'");
			$r_container=mysqli_fetch_assoc($thongtin_container);
			$r_tt['loai_container']=$r_container['tieu_de'];
			if($r_tt['loai_hinh']=='hangnhap'){
				$r_tt['loai_hinh']='Hàng nhập';
			}else{
				$r_tt['loai_hinh']='Hàng xuất';
			}
			if($r_tt['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
			}
			if($r_tt['status']==0){
				$r_tt['status']='Chưa hoàn thành';
				$button_edit='<a href="/admincp/view-list-booking?id='.$r_tt['id'].'"><button class="bg_blue b_mobile">Chi tiết</button></a>';
				$button_del='<button class="bg_red b_mobile" onclick="del(\'container\',\''.$r_tt['id'].'\');"><i class="fa fa-trash-o"></i> Xóa</button>';
			}else if($r_tt['status']==1){
				$r_tt['status']='Hoàn thành';
				$button_edit='';
				$button_del='';
			}else if($r_tt['status']==2){
				$r_tt['status']='Chưa hoàn thành';
				$button_edit='<a href="/admincp/view-list-booking?id='.$r_tt['id'].'"><button class="bg_blue b_mobile">Chi tiết</button></a>';
				$button_del='';

			}
			$r_tt['list_button']=$button_edit.' '.$button_del;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking($conn,$user_id,$loai_hinh,$hang_tau,$loai_container,$from,$to,$dia_diem,$page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start=$page*$limit - $limit;
		$hientai=time();
		if($loai_hinh==''){
			$ok=0;
			$total=0;
			$list='';
		}else{
			if($hang_tau==0){
				$where_hang_tau='';
			}else{
				$where_hang_tau="AND b.hang_tau='$hang_tau'";
			}
			if($loai_container==0){
				$where_loai_container='';
			}else{
				$where_loai_container=" AND b.loai_container='$loai_container'";
			}
			if($from==''){
				$where_from='';
			}else{
				$tach_from=explode('/', $from);
				$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
				$where_from="AND lc.date_time>='$time_from'";
			}
			if($to==''){
				$where_to='';
			}else{
				$tach_to=explode('/', $to);
				$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
				$where_to="AND lc.date_time<='$time_to'";
			}
			if($dia_diem==0){
				$where_dia_diem='';
			}else{
				$where_dia_diem="AND b.tinh='$dia_diem'";
			}
			if($loai_hinh==''){
				$where_loai_hinh='';
			}else{
				$where_loai_hinh="AND lc.loai_hinh='$loai_hinh'";
			}
			$total=0;
			$thongtin_list_container=mysqli_query($conn,"SELECT b.*,lc.id AS id_container,lc.ngay,lc.thoi_gian FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' AND lc.date_time>'$hientai' $where_hang_tau $where_loai_container $where_dia_diem $where_hang_tau $where_from $where_to GROUP BY lc.ma_booking,lc.ngay ORDER BY lc.date_time DESC LIMIT $start,$limit");
			while($r_cont=mysqli_fetch_assoc($thongtin_list_container)){
				$total++;
				$r_cont['i']=$total;
				if($r_cont['mat_hang']=='khac'){
					$r_cont['mat_hang']=$r_cont['mat_hang_khac'];
				}
				$r_cont['gia']=number_format($r_cont['gia']);
				$thongtin_soluong=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND ngay='{$r_cont['ngay']}' AND date_time>='$hientai'");
				$r_sl=mysqli_fetch_assoc($thongtin_soluong);
				$r_cont['so_luong']=$r_sl['total'];
				if($r_cont['so_luong']>1){
					$r_cont['more']='<i class="fa fa-plus-circle" id_container="'.$r_cont['id_container'].'"></i>';
				}else{
					$r_cont['more']='';
				}
				$r_cont['hang_tau']=$r_cont['ten_hangtau'];
				$r_cont['loai_container']=$r_cont['ten_loai_container'];
				if($loai_hinh=='hangnhap'){
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangnhap', $r_cont);
				}else if($loai_hinh=='hang_noidia'){
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia', $r_cont);
				}else{
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangxuat', $r_cont);
				}
			}
			if($total==0){
				$ok=0;
			}else{
				$ok=1;
			}
		}
		$info=array(
			'ok'=>$ok,
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function timkiem_booking_user($conn,$loai_hinh,$hang_tau,$loai_container,$from,$to,$dia_diem,$page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start=$page*$limit - $limit;
		$hientai=time();
		if($loai_hinh==''){
			$ok=0;
			$total=0;
			$list='';
		}else{
			if($hang_tau==0){
				$where_hang_tau='';
			}else{
				$where_hang_tau="AND b.hang_tau='$hang_tau'";
			}
			if($loai_container==0){
				$where_loai_container='';
			}else{
				$where_loai_container=" AND b.loai_container='$loai_container'";
			}
			if($from==''){
				$where_from='';
			}else{
				$tach_from=explode('/', $from);
				$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
				$where_from="AND lc.date_time>='$time_from'";
			}
			if($to==''){
				$where_to='';
			}else{
				$tach_to=explode('/', $to);
				$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
				$where_to="AND lc.date_time<='$time_to'";
			}
			if($dia_diem==0){
				$where_dia_diem='';
			}else{
				$where_dia_diem="AND b.tinh='$dia_diem'";
			}
			if($loai_hinh==''){
				$where_loai_hinh='';
			}else{
				$where_loai_hinh="AND lc.loai_hinh='$loai_hinh'";
			}
			$total=0;
			$thongtin_list_container=mysqli_query($conn,"SELECT b.*,lc.id AS id_container,lc.ngay,lc.thoi_gian FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' $where_hang_tau $where_loai_container $where_dia_diem $where_loai_hinh $where_from $where_to GROUP BY lc.ma_booking,lc.ngay ORDER BY lc.date_time DESC LIMIT $start,$limit");
			while($r_cont=mysqli_fetch_assoc($thongtin_list_container)){
				$total++;
				$r_cont['i']=$total;
				$thongtin_soluong=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND ngay='{$r_cont['ngay']}'");
				$r_sl=mysqli_fetch_assoc($thongtin_soluong);
				$r_cont['so_luong']=$r_sl['total'];
				if($r_cont['so_luong']>1){
					$r_cont['more']='<i class="fa fa-plus-circle" id_container="'.$r_cont['id_container'].'"></i>';
				}else{
					$r_cont['more']='';
				}
				if($r_cont['mat_hang']=='khac'){
					$r_cont['mat_hang']=$r_cont['mat_hang_khac'];
				}
				$r_cont['hang_tau']=$r_cont['ten_hangtau'];
				$r_cont['loai_container']=$r_cont['ten_loai_container'];
				$r_cont['gia']=number_format($r_cont['gia']);
				if($loai_hinh=='hangnhap'){
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangnhap', $r_cont);
				}else if($loai_hinh=='hang_noidia'){
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia', $r_cont);
				}else{
					$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangxuat', $r_cont);
				}
			}
			if($total==0){
				$ok=0;
			}else{
				$ok=1;
			}
		}
		$info=array(
			'ok'=>$ok,
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_booking_new($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.status='0' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['hang_tau']=$r_tt['ten_hangtau'];
			$r_tt['loai_container']=$r_tt['ten_loai_container'];
			if($r_tt['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_new', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking_new($conn,$cong_ty,$loai_hinh,$from,$to, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		if($cong_ty==''){
			$where_user='';
		}else{
			$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE cong_ty='$cong_ty' ORDER BY user_id ASC");
			$total_user=mysqli_num_rows($thongtin_user);
			if($total_user>0){
				$list_id_user=array();
				while($r_user=mysqli_fetch_assoc($thongtin_user)){
					$list_id_user[]=$r_user['user_id'];
				}
				$list_user=implode(',', $list_id_user);
				$where_user=" AND list_container.user_id IN ($list_user)";
			}else{
				$where_user='';
			}
		}
		if($loai_hinh==''){
			$where_loaihinh="(list_container.loai_hinh='hangnhap' OR list_container.loai_hinh='hangxuat' OR list_container.loai_hinh='hang_noidia')";
		}else{
			$where_loaihinh="list_container.loai_hinh='$loai_hinh'";
		}
		if($from==''){
			$where_from='';
		}else{
			$tach_from=explode('/', $from);
			$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
			$where_from=" AND list_container.date_time>='$time_from'";
		}
		if($to==''){
			$where_to='';
		}else{
			$tach_to=explode('/', $to);
			$time_to=mktime(0,0,0,$tach_to[1],$tach_to[0],$tach_to[2]);
			$where_to=" AND list_container.date_time<='$time_to'";
		}
		$thongtin = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE $where_loaihinh $where_user $where_from $where_to AND list_container.status='0' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT $start,$limit");
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['hang_tau']=$r_tt['ten_hangtau'];
			$r_tt['loai_container']=$r_tt['ten_loai_container'];
			if($r_tt['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_new', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	////////////////////
	function list_booking_wait($conn,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='0' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_wait', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking_wait($conn,$cong_ty,$loai_hinh,$from,$to,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		if($cong_ty==''){
			$where_user='';
		}else{
			$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE cong_ty='$cong_ty' ORDER BY user_id ASC");
			$total_user=mysqli_num_rows($thongtin_user);
			if($total_user>0){
				$list_id_user=array();
				while($r_user=mysqli_fetch_assoc($thongtin_user)){
					$list_id_user[]=$r_user['user_id'];
				}
				$list_user=implode(',', $list_id_user);
				$where_user=" AND user_id IN ($list_user)";
			}else{
				$where_user='';
			}
		}
		if($loai_hinh==''){
			$where_loaihinh="(loai_hinh='hangnhap' OR loai_hinh='hangxuat' OR loai_hinh='hang_noidia')";
		}else{
			$where_loaihinh="loai_hinh='$loai_hinh'";
		}
		if($from==''){
			$where_from='';
		}else{
			$tach_from=explode('/', $from);
			$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
			$where_from=" AND date_time>='$time_from'";
		}
		if($to==''){
			$where_to='';
		}else{
			$tach_to=explode('/', $to);
			$time_to=mktime(0,0,0,$tach_to[1],$tach_to[0],$tach_to[2]);
			$where_to=" AND date_time<='$time_to'";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='0' AND (SELECT count(*) FROM list_container WHERE $where_loaihinh $where_user $where_from $where_to AND id=list_booking.id_container)>0 ORDER BY id DESC LIMIT $start,$limit");
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang,booking.loai_hinh FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['loai_hinh']=$r_booking['loai_hinh'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_wait', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	////////////////////
	function list_booking_confirm($conn,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='2' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_confirm', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking_confirm($conn,$cong_ty,$loai_hinh,$from,$to,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		if($cong_ty==''){
			$where_user='';
		}else{
			$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE cong_ty='$cong_ty' ORDER BY user_id ASC");
			$total_user=mysqli_num_rows($thongtin_user);
			if($total_user>0){
				$list_id_user=array();
				while($r_user=mysqli_fetch_assoc($thongtin_user)){
					$list_id_user[]=$r_user['user_id'];
				}
				$list_user=implode(',', $list_id_user);
				$where_user=" AND user_id IN ($list_user)";
			}else{
				$where_user='';
			}
		}
		if($loai_hinh==''){
			$where_loaihinh="(loai_hinh='hangnhap' OR loai_hinh='hangxuat' OR loai_hinh='hang_noidia')";
		}else{
			$where_loaihinh="loai_hinh='$loai_hinh'";
		}
		if($from==''){
			$where_from='';
		}else{
			$tach_from=explode('/', $from);
			$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
			$where_from=" AND date_time>='$time_from'";
		}
		if($to==''){
			$where_to='';
		}else{
			$tach_to=explode('/', $to);
			$time_to=mktime(0,0,0,$tach_to[1],$tach_to[0],$tach_to[2]);
			$where_to=" AND date_time<='$time_to'";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='2' AND (SELECT count(*) FROM list_container WHERE $where_loaihinh $where_user $where_from $where_to AND id=list_booking.id_container)>0 ORDER BY id DESC LIMIT $start,$limit");
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_confirm', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	////////////////////
	function list_booking_false($conn,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='3' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_false', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking_false($conn,$cong_ty,$loai_hinh,$from,$to,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		if($cong_ty==''){
			$where_user='';
		}else{
			$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE cong_ty='$cong_ty' ORDER BY user_id ASC");
			$total_user=mysqli_num_rows($thongtin_user);
			if($total_user>0){
				$list_id_user=array();
				while($r_user=mysqli_fetch_assoc($thongtin_user)){
					$list_id_user[]=$r_user['user_id'];
				}
				$list_user=implode(',', $list_id_user);
				$where_user=" AND user_id IN ($list_user)";
			}else{
				$where_user='';
			}
		}
		if($loai_hinh==''){
			$where_loaihinh="(loai_hinh='hangnhap' OR loai_hinh='hangxuat' OR loai_hinh='hang_noidia')";
		}else{
			$where_loaihinh="loai_hinh='$loai_hinh'";
		}
		if($from==''){
			$where_from='';
		}else{
			$tach_from=explode('/', $from);
			$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
			$where_from=" AND date_time>='$time_from'";
		}
		if($to==''){
			$where_to='';
		}else{
			$tach_to=explode('/', $to);
			$time_to=mktime(0,0,0,$tach_to[1],$tach_to[0],$tach_to[2]);
			$where_to=" AND date_time<='$time_to'";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='3' AND (SELECT count(*) FROM list_container WHERE $where_loaihinh $where_user $where_from $where_to AND id=list_booking.id_container)>0 ORDER BY id DESC LIMIT $start,$limit");
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_false', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	////////////////////
	function list_booking_success($conn,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='1' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_success', $r_tt);
		}
		return $list;
	}
	////////////////////
	function timkiem_booking_success($conn,$cong_ty,$loai_hinh,$from,$to,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		if($cong_ty==''){
			$where_user='';
		}else{
			$thongtin_user=mysqli_query($conn,"SELECT * FROM user_info WHERE cong_ty='$cong_ty' ORDER BY user_id ASC");
			$total_user=mysqli_num_rows($thongtin_user);
			if($total_user>0){
				$list_id_user=array();
				while($r_user=mysqli_fetch_assoc($thongtin_user)){
					$list_id_user[]=$r_user['user_id'];
				}
				$list_user=implode(',', $list_id_user);
				$where_user=" AND user_id IN ($list_user)";
			}else{
				$where_user='';
			}
		}
		if($loai_hinh==''){
			$where_loaihinh="(loai_hinh='hangnhap' OR loai_hinh='hangxuat' OR loai_hinh='hang_noidia')";
		}else{
			$where_loaihinh="loai_hinh='$loai_hinh'";
		}
		if($from==''){
			$where_from='';
		}else{
			$tach_from=explode('/', $from);
			$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
			$where_from=" AND date_time>='$time_from'";
		}
		if($to==''){
			$where_to='';
		}else{
			$tach_to=explode('/', $to);
			$time_to=mktime(0,0,0,$tach_to[1],$tach_to[0],$tach_to[2]);
			$where_to=" AND date_time<='$time_to'";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE status='1' AND (SELECT count(*) FROM list_container WHERE $where_loaihinh $where_user $where_from $where_to AND id=list_booking.id_container)>0 ORDER BY id DESC LIMIT $start,$limit");
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_success', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	///////////////////
	
	
	////////////////////
	function list_dat_booking_wait($conn,$user_id,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='0' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dat_booking_wait', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_booking_yeucau_huy($conn,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT yeucau_huy.*,user_info.name,user_info.mobile FROM yeucau_huy LEFT JOIN user_info ON yeucau_huy.user_id=user_info.user_id WHERE yeucau_huy.status='0' ORDER BY yeucau_huy.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_container=mysqli_query($conn,"SELECT list_container.* FROM list_booking LEFT JOIN list_container ON list_booking.id_container=list_container.id WHERE list_booking.id='{$r_tt['id_booking']}'");
			$r_cont=mysqli_fetch_assoc($thongtin_container);
			$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
			$thongtin_booking=mysqli_query($conn,"SELECT * FROM booking WHERE ma_booking='{$r_cont['ma_booking']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_tt['ly_do']=='doi_kehoach'){
				if($r_cont['loai_hinh']=='hangnhap'){
					$r_tt['ly_do']='Thay đổi kế hoạch trả hàng';
				}else{
					$r_tt['ly_do']='Thay đổi kế hoạch đóng hàng';
				}
			}else if($r_tt['ly_do']=='vo_container'){
				$r_tt['ly_do']='Vỏ container không đủ điều kiện';
			}else if($r_tt['ly_do']=='khac'){
				$r_tt['ly_do']=$r_tt['ly_do_khac'];
			}
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			if($r_tt['status']==0){
				$r_tt['status']='Chờ xác nhận';
			}else if($r_tt['status']==1){
				$r_tt['status']='Đã chấp nhận hủy';
			}else if($r_tt['status']==2){
				$r_tt['status']='Không chấp nhận hủy';
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_booking_yeucau_huy', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dat_booking_confirm($conn,$user_id,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='2' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dat_booking_confirm', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dat_booking_false($conn,$user_id,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='3' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dat_booking_false', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dat_booking_success($conn,$user_id,$page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='1' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			if($r_booking['mat_hang']=='khac'){
				$r_booking['mat_hang']=$r_booking['mat_hang_khac'];
			}
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['mat_hang']=$r_booking['mat_hang'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['so_hieu']=$r_booking['so_hieu'];
			$r_tt['gia_booking']=number_format($r_booking['gia']);
			$r_tt['gia']=number_format($r_tt['gia']);
			$r_tt['ngay_booking']=$r_booking['ngay'];
			$r_tt['thoi_gian_booking']=$r_booking['thoi_gian'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dat_booking_success', $r_tt);
		}
		return $list;
	}
	///////////////////
	function timkiem_thanhvien($conn, $key, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT user_info.*,cskh.ho_ten,cskh.dien_thoai FROM user_info LEFT JOIN cskh ON user_info.user_id=cskh.user_id WHERE user_info.username LIKE '%$key%' OR user_info.email LIKE '%$key%' OR user_info.name LIKE '%$key%' OR user_info.mobile LIKE '%$key%' OR user_info.cong_ty LIKE '%$key%' ORDER BY user_info.user_id DESC LIMIT $start,$limit");
		$i = $start;
		$t=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$t++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_container=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE user_id='{$r_tt['user_id']}'");
			$r_cont=mysqli_fetch_assoc($thongtin_container);
			$r_tt['booking_tao']=$r_cont['total'];
			$thongtin_dat=mysqli_query($conn,"SELECT count(*) AS total FROM list_booking WHERE user_dat='{$r_tt['user_id']}'");
			$r_dat=mysqli_fetch_assoc($thongtin_dat);
			$r_tt['booking_dat']=$r_dat['total'];
			if ($r_tt['active'] == 2) {
				$r_tt['tinh_trang'] = 'Tạm khóa';
			} else if ($r_tt['active'] == 3) {
				$r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
			} else {
				$r_tt['tinh_trang'] = 'Bình thường';
			}
			if ($r_tt['loai'] == 1) {
				$r_tt['loai'] = '<span class="color_red bold">Nhóm dịch</span>';
			} else {
				$r_tt['loai'] = 'Thành viên';
			}
			if($r_tt['ho_ten']==''){
				$r_tt['cskh']='';
			}else{
				$r_tt['cskh']=$r_tt['ho_ten'].'<br>'.$r_tt['dien_thoai'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
		}
		$bien=array(
			'total'=>$t,
			'list'=>$list
		);
		return json_encode($bien);
	}
	////////////////////
	function list_hangnhap($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hangnhap' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai' AND status='0') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_trahang']=$r_booking['diachi_trahang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangnhap', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hangxuat($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		//$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND status='0' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_donghang']=$r_booking['diachi_donghang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangxuat', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hang_noidia($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hang_noidia' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.ten_xa_donghang,b.ten_huyen_donghang,b.ten_tinh_donghang,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['ten_xa_donghang']=$r_booking['ten_xa_donghang'];
			$r_tt['ten_huyen_donghang']=$r_booking['ten_huyen_donghang'];
			$r_tt['ten_tinh_donghang']=$r_booking['ten_tinh_donghang'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_donghang']=$r_booking['diachi_donghang'];
			$r_tt['diachi_trahang']=$r_booking['diachi_trahang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hangnhap_user($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangnhap' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_trahang']=$r_booking['diachi_trahang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangnhap', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hangxuat_user($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_donghang']=$r_booking['diachi_donghang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangxuat', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hang_noidia_user($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hang_noidia' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.ten_xa_donghang,b.ten_huyen_donghang,b.ten_tinh_donghang,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['id_container']=$r_tt['id'];
			$r_tt['hang_tau']=$r_booking['ten_hangtau'];
			$r_tt['loai_container']=$r_booking['ten_loai_container'];
			$r_tt['gia']=number_format($r_booking['gia']);
			$r_tt['ten_xa']=$r_booking['ten_xa'];
			$r_tt['ten_huyen']=$r_booking['ten_huyen'];
			$r_tt['ten_tinh']=$r_booking['ten_tinh'];
			$r_tt['ten_xa_donghang']=$r_booking['ten_xa_donghang'];
			$r_tt['ten_huyen_donghang']=$r_booking['ten_huyen_donghang'];
			$r_tt['ten_tinh_donghang']=$r_booking['ten_tinh_donghang'];
			$r_tt['so_booking']=$r_booking['so_booking'];
			$r_tt['diachi_donghang']=$r_booking['diachi_donghang'];
			$r_tt['diachi_trahang']=$r_booking['diachi_trahang'];
			$r_tt['thoi_gian']=$r_booking['thoi_gian'];
			$r_tt['so_luong']=$r_booking['so_luong'];
			if($r_booking['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_booking['mat_hang_khac'];
			}else{
				$r_tt['mat_hang']=$r_booking['mat_hang'];
			}
			if($r_tt['so_luong']>1){
				$r_tt['more']='<i class="fa fa-plus-circle" id_container="'.$r_tt['id'].'"></i>';
			}else{
				$r_tt['more']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hang_noidia', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_goiy_tinh($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list.='<div class="li_goiy goiy_tinh selected" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
			} else {
				$list.='<div class="li_goiy goiy_tinh" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
			}
		}
		return $list;
	}
	///////////////////
	function list_goiy_congty($conn) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT DISTINCT cong_ty FROM user_info ORDER BY cong_ty ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$list.='<div class="li_goiy goiy_congty" value="'.$r_tt['cong_ty'].'">'.$r_tt['cong_ty'].'</div>';
		}
		return $list;
	}
	///////////////////
	function list_goiy_hangtau($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT lh.*,pk.phi FROM list_hangtau lh LEFT JOIN phi_kethop pk ON lh.viet_tat=pk.hang_tau ORDER BY lh.tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list.='<div class="li_goiy goiy_hangtau selected" value="'.$r_tt['id'].'" viet_tat="'.$r_tt['viet_tat'].'" phi="'.$r_tt['phi'].'">'.$r_tt['tieu_de'].'('.$r_tt['viet_tat'].')</div>';
			} else {
				$list.='<div class="li_goiy goiy_hangtau" value="'.$r_tt['id'].'" viet_tat="'.$r_tt['viet_tat'].'" phi="'.$r_tt['phi'].'">'.$r_tt['tieu_de'].'('.$r_tt['viet_tat'].')</div>';
			}
		}
		return $list;
	}
	///////////////////
	function list_notification($conn,$user_id,$bo_phan,$loai,$page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($bo_phan=='all'){
			if($loai=='all'){
				$thongtin = mysqli_query($conn, "SELECT * FROM notification_admin ORDER BY id DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT * FROM notification_admin WHERE doc IS NULL OR FIND_IN_SET('$user_id', doc) < 1 ORDER BY id DESC LIMIT $start,$limit");
			}
		}else{
			if($loai=='all'){
				$thongtin = mysqli_query($conn, "SELECT * FROM notification_admin WHERE bo_phan='$bo_phan' ORDER BY id DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT * FROM notification_admin WHERE bo_phan='$bo_phan' AND (doc IS NULL OR FIND_IN_SET('$user_id', doc) < 1) ORDER BY id DESC LIMIT $start,$limit");
			}
		}
		$i = $start;
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
			if($r_tt['doc']==''){
				$doc=$user_id;
				mysqli_query($conn,"UPDATE notification_admin SET doc='$doc' WHERE id='{$r_tt['id']}'");
			}else{
				$tach_doc=explode(',', $r_tt['doc']);
				if(in_array($user_id, $tach_doc)==true){

				}else{
					$doc=$r_tt['doc'].','.$user_id;
					mysqli_query($conn,"UPDATE notification_admin SET doc='$doc' WHERE id='{$r_tt['id']}'");
				}
			}
			if($r_tt['bo_phan']=='naptien'){
				$r_tt['href']='/admincp/edit-naptien?id='.$r_tt['booking'];
			}else if($r_tt['bo_phan']=='chat'){
				$r_tt['href']='/admincp/list-chat';
			}else{
				$r_tt['href']='javascript:;';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_notification', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	///////////////////
	function list_option_hangtau($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '('.$r_tt['viet_tat'].')</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '('.$r_tt['viet_tat'].')</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_hangtau_vt($conn, $viet_tat) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['viet_tat'] == $viet_tat) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '('.$r_tt['viet_tat'].')</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '('.$r_tt['viet_tat'].')</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_tinh($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_huyen($conn, $tinh, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_xa($conn, $huyen, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_container($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM loai_container ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_cang($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_cang ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_danhmuc($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM danhmuc_baiviet ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	////////////////////
	function list_naptien_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username,user_info.mobile FROM naptien LEFT JOIN user_info ON user_info.user_id=naptien.user_id WHERE naptien.user_id='$user_id' ORDER BY naptien.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['sotien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chitieu_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username,user_info.mobile FROM lichsu_chitieu LEFT JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id WHERE lichsu_chitieu.user_id='$user_id' ORDER BY lichsu_chitieu.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if (strpos($r_tt['sotien'], '-') !== false) {
				$r_tt['sotien'] = number_format($r_tt['sotien']);
			} else if ($r_tt['truoc'] < $r_tt['sau']) {
				$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
			} else if ($r_tt['truoc'] > $r_tt['sau']) {
				$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
			} else {
				if (strpos($r_tt['noidung'], 'Đặt hàng drop') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Mua') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Cài đặt giao diện') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Đặt mua tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Yêu cầu hỗ trợ cài đặt tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else {
					$r_tt['sotien'] = number_format($r_tt['sotien']);
				}
			}
			if ($r_tt['truoc'] == 0 AND $r_tt['sau'] == 0) {
				$r_tt['truoc'] = 'Không xác định';
				$r_tt['sau'] = 'Không xác định';
			} else {
				$r_tt['truoc'] = number_format($r_tt['truoc']);
				$r_tt['sau'] = number_format($r_tt['sau']);
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_chitieu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_ruttien_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT rut_tien.*,user_info.username FROM rut_tien LEFT JOIN user_info ON user_info.user_id=rut_tien.user_id WHERE rut_tien.user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['so_tien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-ruttien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dangky_hotro($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM pop_hotro LEFT JOIN user_info ON pop_hotro.user_id=user_info.user_id ORDER BY pop_hotro.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if($r_tt['thoi_gian']==''){
				$r_tt['thoi_gian']='Không nhận hỗ trợ';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dangky_hotro', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_naptien($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username,user_info.mobile FROM naptien LEFT JOIN user_info ON user_info.user_id=naptien.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['sotien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Chờ xác nhận';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
			}
			if($r_tt['kich_hoat']==1){
				$r_tt['loai_nap']='Kích hoạt tài khoản';

			}else{
				$r_tt['loai_nap']='Nạp tiền vào tài khoản';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chitieu($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username,user_info.mobile FROM lichsu_chitieu LEFT JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			//$r_tt['sotien']=number_format($r_tt['sotien']);
			if (strpos($r_tt['sotien'], '-') !== false) {
				$r_tt['sotien'] = number_format($r_tt['sotien']);
			} else if ($r_tt['truoc'] < $r_tt['sau']) {
				$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
			} else if ($r_tt['truoc'] > $r_tt['sau']) {
				$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
			} else {
				if (strpos($r_tt['noidung'], 'Đặt hàng drop') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Mua') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Cài đặt giao diện') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Đặt mua tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Yêu cầu hỗ trợ cài đặt tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else {
					$r_tt['sotien'] = number_format($r_tt['sotien']);
				}
			}
			if ($r_tt['truoc'] == 0 AND $r_tt['sau'] == 0) {
				$r_tt['truoc'] = '';
				$r_tt['sau'] = '';
			} else {
				$r_tt['truoc'] = number_format($r_tt['truoc']);
				$r_tt['sau'] = number_format($r_tt['sau']);
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_chitieu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_ruttien($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT rut_tien.*,user_info.username FROM rut_tien LEFT JOIN user_info ON user_info.user_id=rut_tien.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['so_tien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-ruttien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_goi_giahan($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM goi_giahan ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['active']==1){
				$r_tt['status']='Hiển thị';
			}else{
				$r_tt['status']='Ẩn';
			}
			$r_tt['gia']=number_format($r_tt['gia']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_goi_giahan', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_quantri($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE nhom!='0' ORDER BY user_id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['nhom']==1){
				$r_tt['bo_phan']='Quản trị viên';
			}else if($r_tt['nhom']==2){
				$r_tt['bo_phan']='Chăm sóc khách hàng';
			}else{
				$r_tt['bo_phan']='';
			}
			if($r_tt['nhom']==1){
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_quantri', $r_tt);
			}else if($r_tt['nhom']==2){
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_cskh', $r_tt);
			}
		}
		return $list;
	}
	////////////////////
	function list_theloai($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['cat_icon'] == '') {
				$r_tt['cat_icon'] = '<span class="icon"><i class="icon icon-movie"></i></span>';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_category', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_tinh($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_tinh', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_huyen($conn,$tinh, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_huyen', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_xa($conn,$huyen, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_xa', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_slide($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_slide', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_banner($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM banner ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['vi_tri'] == 'top') {
				$r_tt['vi_tri'] = 'Banner top';
			} else if ($r_tt['vi_tri'] == 'bottom_slide') {
				$r_tt['vi_tri'] = 'Banner dưới slide';
			} else if ($r_tt['vi_tri'] == 'sanpham_banchay') {
				$r_tt['vi_tri'] = 'Box sản phẩm bán chạy';
			} else if ($r_tt['vi_tri'] == 'sanpham_noibat') {
				$r_tt['vi_tri'] = 'Box sản phẩm nổi bật';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_banner', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_video($conn,$total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM video ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_video', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thongbao($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['pop'] == 1) {
				$r_tt['pop'] = 'Có';
			} else {
				$r_tt['pop'] = 'Không';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongbao', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_baiviet($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_baiviet', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_quanly($conn) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE leader='1' ORDER BY user_id DESC");
		$i=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_quanly=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE aff='{$r_tt['user_id']}'");
			$r_ql=mysqli_fetch_assoc($thongtin_quanly);
			$r_tt['total']=$r_ql['total'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_quanly', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien($conn, $active, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($active == 'all') {
			$thongtin = mysqli_query($conn, "SELECT user_info.*,cskh.ho_ten,cskh.dien_thoai FROM user_info LEFT JOIN cskh ON user_info.user_id=cskh.user_id WHERE user_info.nhom='0' ORDER BY user_info.user_id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT user_info.*,cskh.ho_ten,cskh.dien_thoai FROM user_info LEFT JOIN cskh ON user_info.user_id=cskh.user_id WHERE user_info.nhom='0' AND user_info.active='$active' ORDER BY user_info.user_id DESC LIMIT $start,$limit");
		}
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_money2'] = number_format($r_tt['user_money2']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_container=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE user_id='{$r_tt['user_id']}'");
			$r_cont=mysqli_fetch_assoc($thongtin_container);
			$r_tt['booking_tao']=$r_cont['total'];
			$thongtin_dat=mysqli_query($conn,"SELECT count(*) AS total FROM list_booking WHERE user_dat='{$r_tt['user_id']}'");
			$r_dat=mysqli_fetch_assoc($thongtin_dat);
			$r_tt['booking_dat']=$r_dat['total'];
			if($r_tt['active']==1){
				$r_tt['link_active']='Đã active';
			}else{
				$r_tt['link_active']='<a href="javascript:;" class="active_user" user_id="'.$r_tt['user_id'].'">Kích hoạt</a>';
			}
			if ($r_tt['active'] == 2) {
				$r_tt['tinh_trang'] = 'Tạm khóa';
			} else if ($r_tt['active'] == 3) {
				$r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
			} else {
				$r_tt['tinh_trang'] = 'Bình thường';
			}
			if ($r_tt['loai'] == 1) {
				$r_tt['loai'] = '<span class="color_red bold">Nhóm dịch</span>';
			} else {
				$r_tt['loai'] = 'Thành viên';
			}
			if($r_tt['ho_ten']==''){
				$r_tt['cskh']='';
			}else{
				$r_tt['cskh']=$r_tt['ho_ten'].'<br>'.$r_tt['dien_thoai'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_cang($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_cang ORDER BY thu_tu ASC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_cang', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_phi_kethop($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM phi_kethop ORDER BY id ASC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['phi']=number_format($r_tt['phi']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_phi_kethop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_hangtau($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau ORDER BY tieu_de ASC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hangtau', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_container($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM loai_container ORDER BY tieu_de ASC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_container', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_lienhe($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM lien_he ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_lienhe', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_nhantin($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM dangky_nhantin WHERE shop='0' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_nhantin', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_yeucau($conn,$user_id,$bo_phan,$thanh_vien){
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		if($bo_phan=='all'){
			$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE /*(chat.user_in='$user_id' OR chat.user_out='$user_id' OR chat.user_in='0') AND*/ chat.active='1' AND chat.noi_dung='' GROUP BY chat.thanh_vien ORDER BY chat.id DESC,chat.active DESC");
		}else{
			$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE (chat.user_in='$user_id' OR chat.user_out='$user_id' OR chat.user_in='0') AND chat.active='1' AND chat.noi_dung='' AND chat.bo_phan='$bo_phan' GROUP BY chat.thanh_vien ORDER BY chat.id DESC,chat.active DESC");
		}
		
		$i=0;
		$total=mysqli_num_rows($thongtin);
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post']=$check->date_update($r_tt['date_post']);
			if($thanh_vien==$r_tt['thanh_vien']){
				$r_tt['active']='active';
			}else{
				$r_tt['active']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_yeucau', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chat($conn,$user_id,$name,$avatar,$thanhvien_name,$thanhvien_avatar,$user_end, $phien,$sms_id,$limit){
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.avatar,user_info.name FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.noi_dung!='' AND chat.id<'$sms_id' ORDER BY chat.id DESC LIMIT $limit");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$list='';
			$load=0;
		}else{
			if($total<$limit){
				$load=0;
			}else{
				$load=1;
			}
			$i=0;
			$_SESSION['user_end']=$user_end;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$list_x[$i] = $r_tt;
				$i++;
				if($r_tt['user_out']-=$r_tt['thanh_vien']){
					mysqli_query($conn,"UPDATE chat SET doc='1' WHERE id='{$r_tt['id']}'");
				}
			}
			krsort($list_x);
			foreach ($list_x as $key => $value) {
				if($value['user_out']==$user_id){
					$value['name']=$name;
					$value['avatar']=$avatar;
				}else if($value['user_out']==$value['thanh_vien']){
					$value['name']=$thanhvien_name;
					$value['avatar']=$thanhvien_avatar;
				}
				$value['noi_dung']=$check->smile($value['noi_dung']);
				if($value['user_out']==$_SESSION['user_end']){
					if($value['thanh_vien']==$_SESSION['user_end']){
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_left', $value);
					}else{
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_right', $value);
					}
				}else{
					if($value['user_out']==$value['thanh_vien']){
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $value);
					}else{
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $value);
					}
				}
				$_SESSION['user_end']=$value['user_out'];
			}

		}
		$info=array(
			'list'=>$list,
			'load'=>$load
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_thanhvien_nam($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['created']);
				$month = intval($month);
				if ($month == 1) {
					$month_1++;
				} else if ($month == 2) {
					$month_2++;
				} else if ($month == 3) {
					$month_3++;
				} else if ($month == 4) {
					$month_4++;
				} else if ($month == 5) {
					$month_5++;
				} else if ($month == 6) {
					$month_6++;
				} else if ($month == 7) {
					$month_7++;
				} else if ($month == 8) {
					$month_8++;
				} else if ($month == 9) {
					$month_9++;
				} else if ($month == 10) {
					$month_10++;
				} else if ($month == 11) {
					$month_11++;

				} else if ($month == 12) {
					$month_12++;
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){
				$month_1=0;
				$month_2=0;
				$month_3=0;
				$month_4=0;
				$month_5=0;
				$month_6=0;
				$month_7=0;
				$month_8=0;
				$month_9=0;
				$month_10=0;
				$month_11=0;
				$month_12=0;
			}else{
				$month_1=0;
				$month_2=0;
				$month_3=0;
				$month_4=0;
				$month_5=0;
				$month_6=0;
				$month_7=0;
				$month_8=0;
				$month_9=0;
				$month_10=0;
				$month_11=0;
				$month_12=0;
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$month = date('m', $r_tt['created']);
					$month = intval($month);
					if ($month == 1) {
						$month_1++;
					} else if ($month == 2) {
						$month_2++;
					} else if ($month == 3) {
						$month_3++;
					} else if ($month == 4) {
						$month_4++;
					} else if ($month == 5) {
						$month_5++;
					} else if ($month == 6) {
						$month_6++;
					} else if ($month == 7) {
						$month_7++;
					} else if ($month == 8) {
						$month_8++;
					} else if ($month == 9) {
						$month_9++;
					} else if ($month == 10) {
						$month_10++;
					} else if ($month == 11) {
						$month_11++;

					} else if ($month == 12) {
						$month_12++;
					}
				}
			}
		}
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_thanhvien_thang($conn,$user_id,$nhom, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['created']);
				$ngay = intval($ngay);
				if ($thang == 2) {
					if (checkdate(02, 29, $nam) == true) {
						for ($i = 1; $i <= 29; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					} else {
						for ($i = 1; $i <= 28; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					}
				} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
					for ($i = 1; $i <= 31; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 30; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$ngay = date('d', $r_tt['created']);
					$ngay = intval($ngay);
					if ($thang == 2) {
						if (checkdate(02, 29, $nam) == true) {
							for ($i = 1; $i <= 29; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
								}
							}
						} else {
							for ($i = 1; $i <= 28; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
								}
							}
						}
					} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
						for ($i = 1; $i <= 31; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					} else {
						for ($i = 1; $i <= 30; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					}
				}
			}
		}		
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_thanhvien_tuan($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['created']);
				$day = date('d', $r_tt['created']);
				$year = date('Y', $r_tt['created']);
				$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
				if ($wkday == 'Monday') {
					$mon++;
				} else if ($wkday == 'Tuesday') {
					$tus++;
				} else if ($wkday == 'Wednesday') {
					$web++;
				} else if ($wkday == 'Thursday') {
					$thu++;
				} else if ($wkday == 'Friday') {
					$fri++;
				} else if ($wkday == 'Saturday') {
					$sat++;
				} else if ($wkday == 'Sunday') {
					$sun++;
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$month = date('m', $r_tt['created']);
					$day = date('d', $r_tt['created']);
					$year = date('Y', $r_tt['created']);
					$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
					if ($wkday == 'Monday') {
						$mon++;
					} else if ($wkday == 'Tuesday') {
						$tus++;
					} else if ($wkday == 'Wednesday') {
						$web++;
					} else if ($wkday == 'Thursday') {
						$thu++;
					} else if ($wkday == 'Friday') {
						$fri++;
					} else if ($wkday == 'Saturday') {
						$sat++;
					} else if ($wkday == 'Sunday') {
						$sun++;
					}
				}
			}
		}
		return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
	///////////////////
	function thongke_thanhvien_nam_cskh($conn,$user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
		if($total_thanhvien==0){
			$month_1=0;
			$month_2=0;
			$month_3=0;
			$month_4=0;
			$month_5=0;
			$month_6=0;
			$month_7=0;
			$month_8=0;
			$month_9=0;
			$month_10=0;
			$month_11=0;
			$month_12=0;
		}else{
			$month_1=0;
			$month_2=0;
			$month_3=0;
			$month_4=0;
			$month_5=0;
			$month_6=0;
			$month_7=0;
			$month_8=0;
			$month_9=0;
			$month_10=0;
			$month_11=0;
			$month_12=0;
			while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
				$list_id.=$r_tv['user_id'].',';
			}
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['created']);
				$month = intval($month);
				if ($month == 1) {
					$month_1++;
				} else if ($month == 2) {
					$month_2++;
				} else if ($month == 3) {
					$month_3++;
				} else if ($month == 4) {
					$month_4++;
				} else if ($month == 5) {
					$month_5++;
				} else if ($month == 6) {
					$month_6++;
				} else if ($month == 7) {
					$month_7++;
				} else if ($month == 8) {
					$month_8++;
				} else if ($month == 9) {
					$month_9++;
				} else if ($month == 10) {
					$month_10++;
				} else if ($month == 11) {
					$month_11++;

				} else if ($month == 12) {
					$month_12++;
				}
			}
		}
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_thanhvien_thang_cskh($conn,$user_id, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
		if($total_thanhvien==0){

		}else{
			while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
				$list_id.=$r_tv['user_id'].',';
			}
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['created']);
				$ngay = intval($ngay);
				if ($thang == 2) {
					if (checkdate(02, 29, $nam) == true) {
						for ($i = 1; $i <= 29; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					} else {
						for ($i = 1; $i <= 28; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
							}
						}
					}
				} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
					for ($i = 1; $i <= 31; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 30; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				}
			}
		}		
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_thanhvien_tuan_cskh($conn,$user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
		if($total_thanhvien==0){

		}else{
			while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
				$list_id.=$r_tv['user_id'].',';
			}
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id IN ($list_id) AND created>='$dau' AND created<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['created']);
				$day = date('d', $r_tt['created']);
				$year = date('Y', $r_tt['created']);
				$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
				if ($wkday == 'Monday') {
					$mon++;
				} else if ($wkday == 'Tuesday') {
					$tus++;
				} else if ($wkday == 'Wednesday') {
					$web++;
				} else if ($wkday == 'Thursday') {
					$thu++;
				} else if ($wkday == 'Friday') {
					$fri++;
				} else if ($wkday == 'Saturday') {
					$sat++;
				} else if ($wkday == 'Sunday') {
					$sun++;
				}
			}
		}
		return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
	///////////////////
	function thongke_naptien($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$month_1 = 0;
		$month_2 = 0;
		$month_3 = 0;
		$month_4 = 0;
		$month_5 = 0;
		$month_6 = 0;
		$month_7 = 0;
		$month_8 = 0;
		$month_9 = 0;
		$month_10 = 0;
		$month_11 = 0;
		$month_12 = 0;
		$daydon = 0;
		$tiepnhan = 0;
		$sanxuat = 0;
		$hoanthanh = 0;
		$hoandon = 0;
		$danggiao = 0;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['date_post']);
				$month = intval($month);
				if ($month == 1) {
					$month_1++;
					if ($r_tt['status'] == 0) {
						$cho_1++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_1++;
					} else if ($r_tt['status'] == 2) {
						$huy_1++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_1++;
					}
				} else if ($month == 2) {
					$month_2++;
					if ($r_tt['status'] == 0) {
						$cho_2++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_2++;
					} else if ($r_tt['status'] == 2) {
						$huy_2++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_2++;
					}
				} else if ($month == 3) {
					$month_3++;
					if ($r_tt['status'] == 0) {
						$cho_3++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_3++;
					} else if ($r_tt['status'] == 2) {
						$huy_3++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_3++;
					}
				} else if ($month == 4) {
					$month_4++;
					if ($r_tt['status'] == 0) {
						$cho_4++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_4++;
					} else if ($r_tt['status'] == 2) {
						$huy_4++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_4++;
					}
				} else if ($month == 5) {
					$month_5++;
					if ($r_tt['status'] == 0) {
						$cho_4++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_5++;
					} else if ($r_tt['status'] == 2) {
						$huy_5++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_5++;
					}
				} else if ($month == 6) {
					$month_6++;
					if ($r_tt['status'] == 0) {
						$cho_6++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_6++;
					} else if ($r_tt['status'] == 2) {
						$huy_6++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_6++;
					}
				} else if ($month == 7) {
					$month_7++;
					if ($r_tt['status'] == 0) {
						$cho_7++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_7++;
					} else if ($r_tt['status'] == 2) {
						$huy_7++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_7++;
					}
				} else if ($month == 8) {
					$month_8++;
					if ($r_tt['status'] == 0) {
						$cho_8++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_8++;
					} else if ($r_tt['status'] == 2) {
						$huy_8++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_8++;
					}
				} else if ($month == 9) {
					$month_9++;
					if ($r_tt['status'] == 0) {
						$cho_9++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_9++;
					} else if ($r_tt['status'] == 2) {
						$huy_9++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_9++;
					}
				} else if ($month == 10) {
					$month_10++;
					if ($r_tt['status'] == 0) {
						$cho_10++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_10++;
					} else if ($r_tt['status'] == 2) {
						$huy_10++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_10++;
					}
				} else if ($month == 11) {
					$month_11++;
					if ($r_tt['status'] == 0) {
						$cho_11++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_11++;
					} else if ($r_tt['status'] == 2) {
						$huy_11++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_11++;
					}
				} else if ($month == 12) {
					$month_12++;
					if ($r_tt['status'] == 0) {
						$cho_12++;
					} else if ($r_tt['status'] == 1) {
						$hoanthanh_12++;
					} else if ($r_tt['status'] == 2) {
						$huy_12++;
					} else if ($r_tt['status'] == 3) {
						$cho_xacnhan_12++;
					}
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$month = date('m', $r_tt['date_post']);
					$month = intval($month);
					if ($month == 1) {
						$month_1++;
						if ($r_tt['status'] == 0) {
							$cho_1++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_1++;
						} else if ($r_tt['status'] == 2) {
							$huy_1++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_1++;
						}
					} else if ($month == 2) {
						$month_2++;
						if ($r_tt['status'] == 0) {
							$cho_2++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_2++;
						} else if ($r_tt['status'] == 2) {
							$huy_2++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_2++;
						}
					} else if ($month == 3) {
						$month_3++;
						if ($r_tt['status'] == 0) {
							$cho_3++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_3++;
						} else if ($r_tt['status'] == 2) {
							$huy_3++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_3++;
						}
					} else if ($month == 4) {
						$month_4++;
						if ($r_tt['status'] == 0) {
							$cho_4++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_4++;
						} else if ($r_tt['status'] == 2) {
							$huy_4++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_4++;
						}
					} else if ($month == 5) {
						$month_5++;
						if ($r_tt['status'] == 0) {
							$cho_4++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_5++;
						} else if ($r_tt['status'] == 2) {
							$huy_5++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_5++;
						}
					} else if ($month == 6) {
						$month_6++;
						if ($r_tt['status'] == 0) {
							$cho_6++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_6++;
						} else if ($r_tt['status'] == 2) {
							$huy_6++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_6++;
						}
					} else if ($month == 7) {
						$month_7++;
						if ($r_tt['status'] == 0) {
							$cho_7++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_7++;
						} else if ($r_tt['status'] == 2) {
							$huy_7++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_7++;
						}
					} else if ($month == 8) {
						$month_8++;
						if ($r_tt['status'] == 0) {
							$cho_8++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_8++;
						} else if ($r_tt['status'] == 2) {
							$huy_8++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_8++;
						}
					} else if ($month == 9) {
						$month_9++;
						if ($r_tt['status'] == 0) {
							$cho_9++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_9++;
						} else if ($r_tt['status'] == 2) {
							$huy_9++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_9++;
						}
					} else if ($month == 10) {
						$month_10++;
						if ($r_tt['status'] == 0) {
							$cho_10++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_10++;
						} else if ($r_tt['status'] == 2) {
							$huy_10++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_10++;
						}
					} else if ($month == 11) {
						$month_11++;
						if ($r_tt['status'] == 0) {
							$cho_11++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_11++;
						} else if ($r_tt['status'] == 2) {
							$huy_11++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_11++;
						}
					} else if ($month == 12) {
						$month_12++;
						if ($r_tt['status'] == 0) {
							$cho_12++;
						} else if ($r_tt['status'] == 1) {
							$hoanthanh_12++;
						} else if ($r_tt['status'] == 2) {
							$huy_12++;
						} else if ($r_tt['status'] == 3) {
							$cho_xacnhan_12++;
						}
					}
				}
			}

		}
		$info = array(
			'data_giaodich' => $month_1 . ',' . $month_2 . ',' . $month_3 . ',' . $month_4 . ',' . $month_5 . ',' . $month_6 . ',' . $month_7 . ',' . $month_8 . ',' . $month_9 . ',' . $month_10 . ',' . $month_11 . ',' . $month_12,
			'data_cho' => intval($cho_1) . ',' . intval($cho_2) . ',' . intval($cho_3) . ',' . intval($cho_4) . ',' . intval($cho_5) . ',' . intval($cho_6) . ',' . intval($cho_7) . ',' . intval($cho_8) . ',' . intval($cho_9) . ',' . intval($cho_10) . ',' . intval($cho_11) . ',' . intval($cho_12),
			'data_huy' => intval($huy_1) . ',' . intval($huy_2) . ',' . intval($huy_3) . ',' . intval($huy_4) . ',' . intval($huy_5) . ',' . intval($huy_6) . ',' . intval($huy_7) . ',' . intval($huy_8) . ',' . intval($huy_9) . ',' . intval($huy_10) . ',' . intval($huy_11) . ',' . intval($huy_12),
			'data_cho_xacnhan' => intval($cho_xacnhan_1) . ',' . intval($cho_xacnhan_2) . ',' . intval($cho_xacnhan_3) . ',' . intval($cho_xacnhan_4) . ',' . intval($cho_xacnhan_5) . ',' . intval($cho_xacnhan_6) . ',' . intval($cho_xacnhan_7) . ',' . intval($cho_xacnhan_8) . ',' . intval($cho_xacnhan_9) . ',' . intval($cho_xacnhan_10) . ',' . intval($cho_xacnhan_11) . ',' . intval($cho_xacnhan_12),
			'data_hoanthanh' => intval($hoanthanh_1) . ',' . intval($hoanthanh_2) . ',' . intval($hoanthanh_3) . ',' . intval($hoanthanh_4) . ',' . intval($hoanthanh_5) . ',' . intval($hoanthanh_6) . ',' . intval($hoanthanh_7) . ',' . intval($hoanthanh_8) . ',' . intval($hoanthanh_9) . ',' . intval($hoanthanh_10) . ',' . intval($hoanthanh_11) . ',' . intval($hoanthanh_12),
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_naptien_thang($conn,$user_id,$nhom, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($thang == 2) {
					if (checkdate(02, 29, $nam) == true) {
						for ($i = 1; $i <= 29; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['status'] == 0) {
									$cho[$i]++;
								} else if ($r_tt['status'] == 1) {
									$hoanthanh[$i]++;
								} else if ($r_tt['status'] == 2) {
									$huy[$i]++;
								} else if ($r_tt['status'] == 3) {
									$cho_xacnhan[$i]++;
								}
							}
						}
					} else {
						for ($i = 1; $i <= 28; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['status'] == 0) {
									$cho[$i]++;
								} else if ($r_tt['status'] == 1) {
									$hoanthanh[$i]++;
								} else if ($r_tt['status'] == 2) {
									$huy[$i]++;
								} else if ($r_tt['status'] == 3) {
									$cho_xacnhan[$i]++;
								}
							}
						}

					}
				} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
					for ($i = 1; $i <= 31; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['status'] == 0) {
								$cho[$i]++;
							} else if ($r_tt['status'] == 1) {
								$hoanthanh[$i]++;
							} else if ($r_tt['status'] == 2) {
								$huy[$i]++;
							} else if ($r_tt['status'] == 3) {
								$cho_xacnhan[$i]++;
							}
						}
					}
				} else {
					for ($i = 1; $i <= 30; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['status'] == 0) {
								$cho[$i]++;
							} else if ($r_tt['status'] == 1) {
								$hoanthanh[$i]++;
							} else if ($r_tt['status'] == 2) {
								$huy[$i]++;
							} else if ($r_tt['status'] == 3) {
								$cho_xacnhan[$i]++;
							}
						}
					}

				}

			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$ngay = date('d', $r_tt['date_post']);
					$ngay = intval($ngay);
					if ($thang == 2) {
						if (checkdate(02, 29, $nam) == true) {
							for ($i = 1; $i <= 29; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
									if ($r_tt['status'] == 0) {
										$cho[$i]++;
									} else if ($r_tt['status'] == 1) {
										$hoanthanh[$i]++;
									} else if ($r_tt['status'] == 2) {
										$huy[$i]++;
									} else if ($r_tt['status'] == 3) {
										$cho_xacnhan[$i]++;
									}
								}
							}
						} else {
							for ($i = 1; $i <= 28; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
									if ($r_tt['status'] == 0) {
										$cho[$i]++;
									} else if ($r_tt['status'] == 1) {
										$hoanthanh[$i]++;
									} else if ($r_tt['status'] == 2) {
										$huy[$i]++;
									} else if ($r_tt['status'] == 3) {
										$cho_xacnhan[$i]++;
									}
								}
							}

						}
					} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
						for ($i = 1; $i <= 31; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['status'] == 0) {
									$cho[$i]++;
								} else if ($r_tt['status'] == 1) {
									$hoanthanh[$i]++;
								} else if ($r_tt['status'] == 2) {
									$huy[$i]++;
								} else if ($r_tt['status'] == 3) {
									$cho_xacnhan[$i]++;
								}
							}
						}
					} else {
						for ($i = 1; $i <= 30; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['status'] == 0) {
									$cho[$i]++;
								} else if ($r_tt['status'] == 1) {
									$hoanthanh[$i]++;
								} else if ($r_tt['status'] == 2) {
									$huy[$i]++;
								} else if ($r_tt['status'] == 3) {
									$cho_xacnhan[$i]++;
								}
							}
						}

					}

				}
			}
		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
					$data_huy_thang .= intval($huy[$i]) . ',';
					$data_cho_xacnhan_thang .= intval($cho_xacnhan[$i]) . ',';
					$data_cho_thang .= intval($cho[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
					$data_huy_thang .= intval($huy[$i]) . ',';
					$data_cho_xacnhan_thang .= intval($cho_xacnhan[$i]) . ',';
					$data_cho_thang .= intval($cho[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
				$data_huy_thang .= intval($huy[$i]) . ',';
				$data_cho_xacnhan_thang .= intval($cho_xacnhan[$i]) . ',';
				$data_cho_thang .= intval($cho[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
				$data_huy_thang .= intval($huy[$i]) . ',';
				$data_cho_xacnhan_thang .= intval($cho_xacnhan[$i]) . ',';
				$data_cho_thang .= intval($cho[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		$data_hoanthanh_thang = substr($data_hoanthanh_thang, 0, -1);
		$data_huy_thang = substr($data_huy_thang, 0, -1);
		$data_cho_xacnhan_thang = substr($data_cho_xacnhan_thang, 0, -1);
		$data_cho_thang = substr($data_cho_thang, 0, -1);
		$info = array(
			'data_thang' => $data_thang,
			'data_hoanthanh_thang' => $data_hoanthanh_thang,
			'data_huy_thang' => $data_huy_thang,
			'data_cho_xacnhan_thang' => $data_cho_xacnhan_thang,
			'data_cho_thang' => $data_cho_thang,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhso_naptien($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($r_tt['status'] == 3) {
					$cho_xacnhan++;
					$doanhthu_cho_xacnhan += $r_tt['sotien'];
				} else if ($r_tt['status'] == 2) {
					$huy++;
					$doanhthu_huy += $r_tt['sotien'];
				} else if ($r_tt['status'] == 1) {
					$hoanthanh++;
					$doanhthu_hoanthanh += $r_tt['sotien'];
				} else if ($r_tt['status'] == 0) {
					$cho++;
					$doanhthu_cho += $r_tt['sotien'];
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$ngay = date('d', $r_tt['date_post']);
					$ngay = intval($ngay);
					if ($r_tt['status'] == 3) {
						$cho_xacnhan++;
						$doanhthu_cho_xacnhan += $r_tt['sotien'];
					} else if ($r_tt['status'] == 2) {
						$huy++;
						$doanhthu_huy += $r_tt['sotien'];
					} else if ($r_tt['status'] == 1) {
						$hoanthanh++;
						$doanhthu_hoanthanh += $r_tt['sotien'];
					} else if ($r_tt['status'] == 0) {
						$cho++;
						$doanhthu_cho += $r_tt['sotien'];
					}
				}
			}

		}
		$info = array(
			'giaodich_hoanthanh' => $hoanthanh,
			'doanhthu_hoanthanh' => $doanhthu_hoanthanh,
			'giaodich_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'giaodich_cho' => $cho,
			'doanhthu_cho' => $doanhthu_cho,
			'giaodich_cho_xacnhan' => $cho_xacnhan,
			'doanhthu_cho_xacnhan' => $doanhthu_cho_xacnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhso_naptien_cskh($conn,$user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
		if($total_thanhvien==0){

		}else{
			while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
				$list_id.=$r_tv['user_id'].',';
			}
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($r_tt['status'] == 3) {
					$cho_xacnhan++;
					$doanhthu_cho_xacnhan += $r_tt['sotien'];
				} else if ($r_tt['status'] == 2) {
					$huy++;
					$doanhthu_huy += $r_tt['sotien'];
				} else if ($r_tt['status'] == 1) {
					$hoanthanh++;
					$doanhthu_hoanthanh += $r_tt['sotien'];
				} else if ($r_tt['status'] == 0) {
					$cho++;
					$doanhthu_cho += $r_tt['sotien'];
				}
			}
		}
		$info = array(
			'giaodich_hoanthanh' => $hoanthanh,
			'doanhthu_hoanthanh' => $doanhthu_hoanthanh,
			'giaodich_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'giaodich_cho' => $cho,
			'doanhthu_cho' => $doanhthu_cho,
			'giaodich_cho_xacnhan' => $cho_xacnhan,
			'doanhthu_cho_xacnhan' => $doanhthu_cho_xacnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_chitieu($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$month_1 = 0;
		$month_2 = 0;
		$month_3 = 0;
		$month_4 = 0;
		$month_5 = 0;
		$month_6 = 0;
		$month_7 = 0;
		$month_8 = 0;
		$month_9 = 0;
		$month_10 = 0;
		$month_11 = 0;
		$month_12 = 0;
		$daydon = 0;
		$tiepnhan = 0;
		$sanxuat = 0;
		$hoanthanh = 0;
		$hoandon = 0;
		$danggiao = 0;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['date_post']);
				$month = intval($month);
				if ($month == 1) {
					$month_1++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_1+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_1+=$r_tt['sotien'];
					}
				} else if ($month == 2) {
					$month_2++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_2+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_2+=$r_tt['sotien'];
					}
				} else if ($month == 3) {
					$month_3++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_3+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_3+=$r_tt['sotien'];
					}
				} else if ($month == 4) {
					$month_4++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_4+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_4+=$r_tt['sotien'];
					}
				} else if ($month == 5) {
					$month_5++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_5+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_5+=$r_tt['sotien'];
					}
				} else if ($month == 6) {
					$month_6++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_6+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_6+=$r_tt['sotien'];
					}
				} else if ($month == 7) {
					$month_7++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_7+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_7+=$r_tt['sotien'];
					}
				} else if ($month == 8) {
					$month_8++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_8+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_8+=$r_tt['sotien'];
					}
				} else if ($month == 9) {
					$month_9++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_9+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_9+=$r_tt['sotien'];
					}
				} else if ($month == 10) {
					$month_10++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_10+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_10+=$r_tt['sotien'];
					}
				} else if ($month == 11) {
					$month_11++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_11+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_11+=$r_tt['sotien'];
					}
				} else if ($month == 12) {
					$month_12++;
					if($r_tt['truoc']>$r_tt['sau']){
						$doanhso_12+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$hoan_12+=$r_tt['sotien'];
					}
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$month = date('m', $r_tt['date_post']);
					$month = intval($month);
					if ($month == 1) {
						$month_1++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_1+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_1+=$r_tt['sotien'];
						}
					} else if ($month == 2) {
						$month_2++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_2+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_2+=$r_tt['sotien'];
						}
					} else if ($month == 3) {
						$month_3++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_3+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_3+=$r_tt['sotien'];
						}
					} else if ($month == 4) {
						$month_4++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_4+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_4+=$r_tt['sotien'];
						}
					} else if ($month == 5) {
						$month_5++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_5+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_5+=$r_tt['sotien'];
						}
					} else if ($month == 6) {
						$month_6++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_6+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_6+=$r_tt['sotien'];
						}
					} else if ($month == 7) {
						$month_7++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_7+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_7+=$r_tt['sotien'];
						}
					} else if ($month == 8) {
						$month_8++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_8+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_8+=$r_tt['sotien'];
						}
					} else if ($month == 9) {
						$month_9++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_9+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_9+=$r_tt['sotien'];
						}
					} else if ($month == 10) {
						$month_10++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_10+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_10+=$r_tt['sotien'];
						}
					} else if ($month == 11) {
						$month_11++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_11+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_11+=$r_tt['sotien'];
						}
					} else if ($month == 12) {
						$month_12++;
						if($r_tt['truoc']>$r_tt['sau']){
							$doanhso_12+=$r_tt['sotien'];
						}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
							$hoan_12+=$r_tt['sotien'];
						}
					}
				}
			}

		}
		$info = array(
			'data_giaodich' => $month_1 . ',' . $month_2 . ',' . $month_3 . ',' . $month_4 . ',' . $month_5 . ',' . $month_6 . ',' . $month_7 . ',' . $month_8 . ',' . $month_9 . ',' . $month_10 . ',' . $month_11 . ',' . $month_12,
			'data_doanhso' => intval($doanhso_1) . ',' . intval($doanhso_2) . ',' . intval($doanhso_3) . ',' . intval($doanhso_4) . ',' . intval($doanhso_5) . ',' . intval($doanhso_6) . ',' . intval($doanhso_7) . ',' . intval($doanhso_8) . ',' . intval($doanhso_9) . ',' . intval($doanhso_10) . ',' . intval($doanhso_11) . ',' . intval($doanhso_12),
			'data_hoan' => intval($hoan_1) . ',' . intval($hoan_2) . ',' . intval($hoan_3) . ',' . intval($hoan_4) . ',' . intval($hoan_5) . ',' . intval($hoan_6) . ',' . intval($hoan_7) . ',' . intval($hoan_8) . ',' . intval($hoan_9) . ',' . intval($hoan_10) . ',' . intval($hoan_11) . ',' . intval($hoan_12),
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_chitieu_thang($conn,$user_id,$nhom, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($thang == 2) {
					if (checkdate(02, 29, $nam) == true) {
						for ($i = 1; $i <= 29; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if($r_tt['truoc']>$r_tt['sau']){
									$doanhso[$i]+=$r_tt['sotien'];
								}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
									$hoan[$i]+=$r_tt['sotien'];
								}
							}
						}
					} else {
						for ($i = 1; $i <= 28; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if($r_tt['truoc']>$r_tt['sau']){
									$doanhso[$i]+=$r_tt['sotien'];
								}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
									$hoan[$i]+=$r_tt['sotien'];
								}
							}
						}

					}
				} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
					for ($i = 1; $i <= 31; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if($r_tt['truoc']>$r_tt['sau']){
								$doanhso[$i]+=$r_tt['sotien'];
							}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
								$hoan[$i]+=$r_tt['sotien'];
							}
						}
					}
				} else {
					for ($i = 1; $i <= 30; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if($r_tt['truoc']>$r_tt['sau']){
								$doanhso[$i]+=$r_tt['sotien'];
							}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
								$hoan[$i]+=$r_tt['sotien'];
							}
						}
					}

				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$ngay = date('d', $r_tt['date_post']);
					$ngay = intval($ngay);
					if ($thang == 2) {
						if (checkdate(02, 29, $nam) == true) {
							for ($i = 1; $i <= 29; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
									if($r_tt['truoc']>$r_tt['sau']){
										$doanhso[$i]+=$r_tt['sotien'];
									}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
										$hoan[$i]+=$r_tt['sotien'];
									}
								}
							}
						} else {
							for ($i = 1; $i <= 28; $i++) {
								if ($ngay == $i) {
									$data_ngay[$i]++;
									if($r_tt['truoc']>$r_tt['sau']){
										$doanhso[$i]+=$r_tt['sotien'];
									}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
										$hoan[$i]+=$r_tt['sotien'];
									}
								}
							}

						}
					} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
						for ($i = 1; $i <= 31; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if($r_tt['truoc']>$r_tt['sau']){
									$doanhso[$i]+=$r_tt['sotien'];
								}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
									$hoan[$i]+=$r_tt['sotien'];
								}
							}
						}
					} else {
						for ($i = 1; $i <= 30; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if($r_tt['truoc']>$r_tt['sau']){
									$doanhso[$i]+=$r_tt['sotien'];
								}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
									$hoan[$i]+=$r_tt['sotien'];
								}
							}
						}

					}

				}
			}
		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_doanhso_thang .= intval($doanhso[$i]) . ',';
					$data_hoan_thang .= intval($hoan[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_doanhso_thang .= intval($doanhso[$i]) . ',';
					$data_hoan_thang .= intval($hoan[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_doanhso_thang .= intval($doanhso[$i]) . ',';
				$data_hoan_thang .= intval($hoan[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_doanhso_thang .= intval($doanhso[$i]) . ',';
				$data_hoan_thang .= intval($hoan[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		$data_doanhso_thang = substr($data_doanhso_thang, 0, -1);
		$data_hoan_thang = substr($data_hoan_thang, 0, -1);
		$info = array(
			'data_thang' => $data_thang,
			'data_doanhso_thang' => $data_doanhso_thang,
			'data_hoan_thang' => $data_hoan_thang,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhso_chitieu($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$giaodich_chi=0;
		$doanhso_chi=0;
		$giaodich_hoan=0;
		$doanhso_hoan=0;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if($r_tt['truoc']>$r_tt['sau']){
					$giaodich_chi++;
					$doanhso_chi+=$r_tt['sotien'];
				}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
					$giaodich_hoan++;
					$doanhso_hoan+=$r_tt['sotien'];
				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$ngay = date('d', $r_tt['date_post']);
					$ngay = intval($ngay);
					if($r_tt['truoc']>$r_tt['sau']){
						$giaodich_chi++;
						$doanhso_chi+=$r_tt['sotien'];
					}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
						$giaodich_hoan++;
						$doanhso_hoan+=$r_tt['sotien'];
					}
				}
			}

		}
		$info = array(
			'giaodich_chi' => $giaodich_chi,
			'doanhso_chi' => $doanhso_chi,
			'giaodich_hoan' => $giaodich_hoan,
			'doanhso_hoan' => $doanhso_hoan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhso_chitieu_cskh($conn,$user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$giaodich_chi=0;
		$doanhso_chi=0;
		$giaodich_hoan=0;
		$doanhso_hoan=0;
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
		if($total_thanhvien==0){

		}else{
			while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
				$list_id.=$r_tv['user_id'].',';
			}
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if($r_tt['truoc']>$r_tt['sau']){
					$giaodich_chi++;
					$doanhso_chi+=$r_tt['sotien'];
				}else if($r_tt['truoc']<$r_tt['sau'] AND strpos($r_tt['noidung'], 'Hoàn phí')!==false){
					$giaodich_hoan++;
					$doanhso_hoan+=$r_tt['sotien'];
				}
			}
		}
		$info = array(
			'giaodich_chi' => $giaodich_chi,
			'doanhso_chi' => $doanhso_chi,
			'giaodich_hoan' => $giaodich_hoan,
			'doanhso_hoan' => $doanhso_hoan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_booking($conn,$user_id,$nhom, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$hoan_thanh=0;
		$xac_nhan=0;
		$tu_choi=0;
		$huy=0;
		if($nhom==1){
			$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE date_post>='$dau' AND date_post<='$cuoi'");
			$total_booking=mysqli_num_rows($thongtin);
			$thongtin_container = mysqli_query($conn, "SELECT lc.*,b.gia FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.date_post>='$dau' AND lc.date_post<='$cuoi' GROUP BY lc.id ORDER BY lc.id ASC");
			$booking_tao=mysqli_num_rows($thongtin_container);
			$booking_cho=0;
			$doanhso_cho=0;
			while($r_cont=mysqli_fetch_assoc($thongtin_container)){
				$doanhso_tao+=$r_cont['gia'];
				if($r_cont['status']==0){
					$doanhso_cho+=$r_cont['gia'];
					$booking_cho++;
				}
			}
			$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_booking WHERE date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_booking = mysqli_fetch_assoc($thongtin_booking)) {
				if($r_booking['status']==1){
					$hoan_thanh++;
					$doanhso_hoanthanh+=$r_booking['gia'];
				}else if($r_booking['status']==2){
					$xac_nhan++;
					$doanhso_xacnhan+=$r_booking['gia'];
				}else if($r_booking['status']==3){
					$tu_choi++;
					$doanhso_tuchoi+=$r_booking['gia'];
				}else if($r_booking['status']==0){
					$cho_xacnhan++;
					$doanhso_cho_xacnhan+=$r_booking['gia'];
				}else{

				}
			}
		}else{
			$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			$total_thanhvien=mysqli_num_rows($thongtin_thanhvien);
			if($total_thanhvien==0){

			}else{
				while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
					$list_id.=$r_tv['user_id'].',';
				}
				$list_id=substr($list_id, 0,-1);
				$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				$total_booking=mysqli_num_rows($thongtin);
				$thongtin_container = mysqli_query($conn, "SELECT lc.*,b.gia FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id IN ($list_id) AND  lc.date_post>='$dau' AND lc.date_post<='$cuoi' GROUP BY lc.id ORDER BY lc.id ASC");
				$booking_tao=mysqli_num_rows($thongtin_container);
				$booking_cho=0;
				$doanhso_cho=0;
				while($r_cont=mysqli_fetch_assoc($thongtin_container)){
					$doanhso_tao+=$r_cont['gia'];
					if($r_cont['status']==0){
						$doanhso_cho+=$r_cont['gia'];
						$booking_cho++;
					}
				}
				$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
				while ($r_booking = mysqli_fetch_assoc($thongtin_booking)) {
					if($r_booking['status']==1){
						$hoan_thanh++;
						$doanhso_hoanthanh+=$r_booking['gia'];
					}else if($r_booking['status']==2){
						$xac_nhan++;
						$doanhso_xacnhan+=$r_booking['gia'];
					}else if($r_booking['status']==3){
						$tu_choi++;
						$doanhso_tuchoi+=$r_booking['gia'];
					}else if($r_booking['status']==0){
						$cho_xacnhan++;
						$doanhso_cho_xacnhan+=$r_booking['gia'];
					}else{

					}
				}
			}
		}
		$info = array(
			'total_booking'=>$total_booking,
			'total_container'=>$total_container,
			'doanhso_tao'=>$doanhso_tao,
			'booking_tao'=>$booking_tao,
			'booking_hoanthanh' => $hoan_thanh,
			'booking_xacnhan' => $xac_nhan,
			'booking_tuchoi' => $tu_choi,
			'booking_cho_xacnhan' => $cho_xacnhan,
			'doanhso_hoanthanh'=>$doanhso_hoanthanh,
			'doanhso_xacnhan'=>$doanhso_xacnhan,
			'doanhso_tuchoi'=>$doanhso_tuchoi,
			'doanhso_cho_xacnhan'=>$doanhso_cho_xacnhan,
			'booking_cho'=>$booking_cho,
			'doanhso_cho'=>$doanhso_cho
		);
		return json_encode($info);
	}
	///////////////////
	function list_kq_timkiem_thanhvien($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%' OR user_id='$key' OR mobile LIKE '%$key%' ORDER BY name ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_container=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE user_id='{$r_tt['user_id']}'");
			$r_cont=mysqli_fetch_assoc($thongtin_container);
			$r_tt['booking_tao']=$r_cont['total'];
			$thongtin_dat=mysqli_query($conn,"SELECT count(*) AS total FROM list_booking WHERE user_dat='{$r_tt['user_id']}'");
			$r_dat=mysqli_fetch_assoc($thongtin_dat);
			$r_tt['booking_dat']=$r_dat['total'];
			if ($r_tt['active'] == 2) {
				$r_tt['tinh_trang'] = 'Tạm khóa';
			} else if ($r_tt['active'] == 3) {
				$r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
			} else {
				$r_tt['tinh_trang'] = 'Bình thường';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////////////////////////////
	function list_setting($conn, $page, $limit) {
		$tlca_skin_cpanel = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['value'] = $check->words($r_tt['value'], 200);
			$list .= $tlca_skin_cpanel->skin_replace('skin_cpanel/box_action/tr_setting', $r_tt);
		}
		return $list;
	}
	///////////////////////
	function phantrang($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total == 2) {
				if ($page < $total) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == $total) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a></div></div>';
				}
			} else if ($total == 3) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><span>3</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a></div></div>';
				}
			} else if ($total == 4) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span> . . . <a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>3</span><a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=4">Next</a></div></div>';
				} else if ($page == 4) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=3">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>4</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=4">4</a></div></div>';
				}
			} else {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>3</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=4">Next</a></div></div>';
				} else if ($page <= $total - 2) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page < $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <a href="' . $link . '?page=' . $back . '">' . $back . '</a><span>' . $page . '</span></div></div>';
				} else {
					$k = $total - 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a> . . . <a href="' . $link . '?page=' . $k . '">' . $k . '</a><a href="' . $link . '?page=' . $total . '">' . $total . '</a></div></div>';
				}
			}
		}
	}
	///////////////////////
	function phantrang_timkiem($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total == 2) {
				if ($page < $total) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == $total) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a></div></div>';
				}
			} else if ($total == 3) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><span>3</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a></div></div>';
				}
			} else if ($total == 4) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span> . . . <a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>3</span><a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=4">Next</a></div></div>';
				} else if ($page == 4) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=3">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>4</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=4">4</a></div></div>';
				}
			} else {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>3</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=4">Next</a></div></div>';
				} else if ($page <= $total - 2) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page < $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <a href="' . $link . '&page=' . $back . '">' . $back . '</a><span>' . $page . '</span></div></div>';
				} else {
					$k = $total - 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a> . . . <a href="' . $link . '&page=' . $k . '">' . $k . '</a><a href="' . $link . '&page=' . $total . '">' . $total . '</a></div></div>';
				}
			}
		}
	}
	/////////////////////////////////////
	function thanhvien_info($conn, $id) {
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
		$total = mysqli_num_rows($thongtin);
		if ($total == "0") {
			$r_tt = '';
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin);
		}
		return $r_tt;
	}


	/////////////////////////////////////
	
}
?>
