<?php
class class_index extends class_manage {
    function creat_random($conn,$loai){
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
        if($loai=='coupon'){
	        $string=$check->random_number(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM coupon WHERE ma='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }else if($loai=='donhang'){
	        $string=$check->random_number(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM donhang WHERE ma_don='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }
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
	function list_goiy_tinh($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<div class="li_goiy li_goiy_tinh selected" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
			} else {
				$list .= '<div class="li_goiy li_goiy_tinh" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
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
	//////////////////////////////////////////////////////////////////
	function list_option_danhmuc($conn, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_option_category"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		mysqli_free_result($thongtin);
		return $list;
	}
	///////////////////
	function list_hangtau($conn) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau ORDER BY id ASC");
		$i = 0;
		$k=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$list_anh[$k].='<a href="'.$r_tt['link'].'" target="_blank" title="'.$r_tt['tieu_de'].'"><img src="'.$r_tt['logo'].'" onerror="this.src=\'/images/no-logo.png\'"></a>';
			if($i==2){
				$k++;
				$i=0;
			}
		}
		foreach ($list_anh as $key => $value) {
			$r_tt['value']=$value;
			$list .= $skin->skin_replace('skin/box_li/li_hangtau', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_slide($conn) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='0' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin/box_li/li_slide', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_booking_new($conn,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT noti.*,us.name,us.mobile FROM notification noti INNER JOIN user_info us ON noti.user_id=us.user_id WHERE noti.id_congviec>'0' ORDER BY noti.id DESC LIMIT $limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
			$r_tt['mobile']=substr($r_tt['mobile'], 0,-3).'xxx';
			//{noi_dung}, trị giá <span>{tong_tien}</span>
			$tach_noidung=explode(' của bạn', $r_tt['noi_dung']);
			if(strpos($r_tt['noi_dung'], 'của bạn đã được xác nhận hoàn thành')!==false){
				$r_tt['noi_dung']='Xác nhận hoàn thành '.$tach_noidung[0];
			}else if(strpos($r_tt['noi_dung'], 'của bạn đã được chấp nhận')!==false){
				$r_tt['noi_dung']='Chấp nhận đơn đặt '.$tach_noidung[0];				
			}else if(strpos($r_tt['noi_dung'], 'của bạn đã bị từ chối')!==false){
				$r_tt['noi_dung']='Đã từ chối '.$tach_noidung[0];				
			}else if($r_tt['noi_dung']=='Có người vừa đặt booking của bạn'){
				$r_tt['noi_dung']='Vừa có đơn booking được đặt';
			}
			$list .= $skin->skin_replace('skin/box_li/li_booking_new', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_tintuc($conn,$cat,$page,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE cat='$cat' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['trich']=$check->words($r_tt['noi_dung'],35);
			$r_tt['link']=$check->blank($r_tt['tieu_de']);
			$r_tt['date_post']=date('d/m/Y H:i:s',$r_tt['date_post']);
			$list .= $skin->skin_replace('skin/box_li/li_tintuc_left', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_tintuc_right($conn,$cat,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE cat='$cat' ORDER BY view DESC LIMIT $limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['trich']=$check->words($r_tt['noi_dung'],35);
			$r_tt['link']=$check->blank($r_tt['tieu_de']);
			$r_tt['date_post']=date('d/m/Y H:i:s',$r_tt['date_post']);
			$list .= $skin->skin_replace('skin/box_li/li_tintuc_right', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_dieukbutton_profile($conn,$cat,$page,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE cat='$cat' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['trich']=$check->words($r_tt['noi_dung'],35);
			$r_tt['link']=$check->blank($r_tt['tieu_de']);
			$r_tt['date_post']=date('d/m/Y H:i:s',$r_tt['date_post']);
			$list .= $skin->skin_replace('skin/box_li/li_dieukhoan_left', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_dieukhoan_right($conn,$cat,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE cat='$cat' ORDER BY view DESC LIMIT $limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['trich']=$check->words($r_tt['noi_dung'],35);
			$r_tt['link']=$check->blank($r_tt['tieu_de']);
			$r_tt['date_post']=date('d/m/Y H:i:s',$r_tt['date_post']);
			$list .= $skin->skin_replace('skin/box_li/li_dieukhoan_right', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_dieukhoan_footer($conn,$cat,$limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM bai_viet WHERE cat='$cat' ORDER BY id ASC LIMIT $limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['trich']=$check->words($r_tt['noi_dung'],35);
			$r_tt['link']=$check->blank($r_tt['tieu_de']);
			$r_tt['date_post']=date('d/m/Y H:i:s',$r_tt['date_post']);
			$list .= '<div class="li_footer"><a href="/dieu-khoan/'.$r_tt['id'].'/'.$r_tt['link'].'.html">'.$r_tt['tieu_de'].'</a></div>';
		}
		return $list;
	}
	////////////////////
	function list_hangnhap2($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin=mysqli_query($conn,"SELECT lc.*,b.ten_tinh,b.ten_huyen,b.ten_xa,b.diachi_trahang,b.mat_hang,b.mat_hang_khac,b.ten_loai_container,b.ten_cang,b.ten_hangtau,b.gia FROM list_container lc INNER JOIN (SELECT ma_booking, MIN(date_time) AS min_date_time FROM list_container GROUP BY ma_booking) lc_min ON lc.ma_booking = lc_min.ma_booking AND lc.date_time = lc_min.min_date_time LEFT JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' AND lc.loai_hinh='hangnhap' AND lc.date_time>'$hientai' ORDER BY lc.date_time ASC LIMIT $start,$limit");
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
			}
			$r_tt['gia']=number_format($r_tt['gia']);
			$list .= $skin->skin_replace('skin/box_li/tr_hangnhap', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_hangxuat2($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin=mysqli_query($conn,"SELECT lc.*,b.ten_tinh,b.ten_huyen,b.ten_xa,b.diachi_trahang,b.diachi_donghang,b.mat_hang,b.mat_hang_khac,b.ten_loai_container,b.ten_cang,b.ten_hangtau,b.gia FROM list_container lc INNER JOIN (SELECT ma_booking, MIN(date_time) AS min_date_time FROM list_container GROUP BY ma_booking) lc_min ON lc.ma_booking = lc_min.ma_booking AND lc.date_time = lc_min.min_date_time LEFT JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' AND lc.loai_hinh='hangxuat' AND lc.date_time>'$hientai' ORDER BY lc.date_time ASC LIMIT $start,$limit");
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$total++;
			$r_tt['i'] = $i;
			if($r_tt['mat_hang']=='khac'){
				$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
			}
			$r_tt['gia']=number_format($r_tt['gia']);
			$list .= $skin->skin_replace('skin/box_li/tr_hangxuat', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_hangnhap($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hangnhap' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$total++;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['ten_hangtau']=$r_booking['ten_hangtau'];
			$r_tt['ten_loai_container']=$r_booking['ten_loai_container'];
			if(isset($_COOKIE['user_id'])){
				$r_tt['gia']=number_format($r_booking['gia']).' đ';
			}else{
				$r_tt['gia']='Đăng nhập tài khoản để xem được giá';
			}
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
			$list .= $skin->skin_replace('skin/box_li/tr_hangnhap', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_hangxuat($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$total++;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['ten_hangtau']=$r_booking['ten_hangtau'];
			$r_tt['ten_loai_container']=$r_booking['ten_loai_container'];
			if(isset($_COOKIE['user_id'])){
				$r_tt['gia']=number_format($r_booking['gia']).' đ';
			}else{
				$r_tt['gia']='Đăng nhập tài khoản để xem được giá';
			}
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
			$list .= $skin->skin_replace('skin/box_li/tr_hangxuat', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_hang_noidia($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$hientai=time();
		$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hang_noidia' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$total++;
			$thongtin_booking=mysqli_query($conn,"SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.ten_xa_donghang,b.ten_huyen_donghang,b.ten_tinh_donghang,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
			$r_booking=mysqli_fetch_assoc($thongtin_booking);
			$r_tt['ten_hangtau']=$r_booking['ten_hangtau'];
			$r_tt['ten_loai_container']=$r_booking['ten_loai_container'];
			if(isset($_COOKIE['user_id'])){
				$r_tt['gia']=number_format($r_booking['gia']).' đ';
			}else{
				$r_tt['gia']='Đăng nhập tài khoản để xem được giá';
			}
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
			$list .= $skin->skin_replace('skin/box_li/tr_hang_noidia', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function timkiem_booking($conn,$loai_hinh,$hang_tau,$loai_container,$from,$to,$dia_diem) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$hientai=time();
		if($loai_hinh==''){
			$ok=0;
			$total=0;
			$list='';
		}else{
			if($hang_tau==0){
				$where_hang_tau='';
			}else{
				$where_hang_tau="AND hang_tau='$hang_tau'";
			}
			if($loai_container==0){
				$where_loai_container='';
			}else{
				$where_loai_container=" AND loai_container='$loai_container'";
			}
			if($from==''){
				$where_from='';
			}else{
				$tach_from=explode('/', $from);
				$time_from=mktime(0,0,0,$tach_from[1],$tach_from[0],$tach_from[2]);
				$where_from="AND date_time>='$time_from'";
			}
			if($to==''){
				$where_to='';
			}else{
				$tach_to=explode('/', $to);
				$time_to=mktime(23,59,59,$tach_to[1],$tach_to[0],$tach_to[2]);
				$where_to="AND date_time<='$time_to'";
			}
			if($dia_diem==0){
				$where_dia_diem='';
			}else{
				$where_dia_diem="AND tinh='$dia_diem'";
			}
			$list_ma='';
			$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE status!='1' AND loai_hinh='$loai_hinh' $where_hang_tau $where_loai_container $where_dia_diem ORDER BY id ASC");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				if($r_tt['mat_hang']=='khac'){
					$r_tt['mat_hang']=$r_tt['mat_hang_khac'];
				}
				$list_ma .="'".$r_tt['ma_booking']."',";
				$ma_booking=$r_tt['ma_booking'];
				$info_booking[$ma_booking]['ten_hangtau']=$r_tt['ten_hangtau'];
				$info_booking[$ma_booking]['ten_loai_container']=$r_tt['ten_loai_container'];
				if(isset($_COOKIE['user_id'])){
					$r_tt['gia']=number_format($r_tt['gia']).' đ';
				}else{
					$r_tt['gia']='Đăng nhập tài khoản để xem được giá';
				}
				$info_booking[$ma_booking]['gia']=$r_tt['gia'];
				$info_booking[$ma_booking]['mat_hang']=$r_tt['mat_hang'];
				$info_booking[$ma_booking]['diachi_donghang']=$r_tt['diachi_donghang'];
				$info_booking[$ma_booking]['diachi_trahang']=$r_tt['diachi_trahang'];
				$info_booking[$ma_booking]['ten_xa']=$r_tt['ten_xa'];
				$info_booking[$ma_booking]['ten_huyen']=$r_tt['ten_huyen'];
				$info_booking[$ma_booking]['ten_tinh']=$r_tt['ten_tinh'];
				$info_booking[$ma_booking]['ten_xa_donghang']=$r_tt['ten_xa_donghang'];
				$info_booking[$ma_booking]['ten_huyen_donghang']=$r_tt['ten_huyen_donghang'];
				$info_booking[$ma_booking]['ten_tinh_donghang']=$r_tt['ten_tinh_donghang'];
			}
			if($list_ma==''){
				$total=0;
				$ok=0;
				$list='';
			}else{
				$list_ma=substr($list_ma, 0,-1);
				$total=0;
				$thongtin_list_container=mysqli_query($conn,"SELECT * FROM list_container WHERE status='0' AND date_time>'$hientai' AND ma_booking IN ($list_ma) $where_from $where_to GROUP BY ma_booking,ngay ORDER BY date_time ASC");
				while($r_cont=mysqli_fetch_assoc($thongtin_list_container)){
					$total++;
					$r_cont['i']=$total;
					$ma_bk=$r_cont['ma_booking'];
					$thongtin_soluong=mysqli_query($conn,"SELECT count(*) AS total FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND ngay='{$r_cont['ngay']}'");
					$r_sl=mysqli_fetch_assoc($thongtin_soluong);
					$r_cont['so_luong']=$r_sl['total'];
					$r_cont['ten_hangtau']=$info_booking[$ma_bk]['ten_hangtau'];
					$r_cont['ten_loai_container']=$info_booking[$ma_bk]['ten_loai_container'];
					$r_cont['ten_xa']=$info_booking[$ma_bk]['ten_xa'];
					$r_cont['ten_huyen']=$info_booking[$ma_bk]['ten_huyen'];
					$r_cont['ten_tinh']=$info_booking[$ma_bk]['ten_tinh'];
					$r_cont['ten_xa_donghang']=$info_booking[$ma_bk]['ten_xa_donghang'];
					$r_cont['ten_huyen_donghang']=$info_booking[$ma_bk]['ten_huyen_donghang'];
					$r_cont['ten_tinh_donghang']=$info_booking[$ma_bk]['ten_tinh_donghang'];
					$r_cont['gia']=$info_booking[$ma_bk]['gia'];
					$r_cont['mat_hang']=$info_booking[$ma_bk]['mat_hang'];
					$r_cont['diachi_donghang']=$info_booking[$ma_bk]['diachi_donghang'];
					$r_cont['diachi_trahang']=$info_booking[$ma_bk]['diachi_trahang'];
					if($loai_hinh=='hangnhap'){
						$list .= $skin->skin_replace('skin/box_li/tr_hangnhap', $r_cont);
					}else if($loai_hinh=='hang_noidia'){
						$list .= $skin->skin_replace('skin/box_li/tr_hang_noidia', $r_cont);
					}else{
						$list .= $skin->skin_replace('skin/box_li/tr_hangxuat', $r_cont);
					}
				}
				if($total==0){
					$ok=0;
				}else{
					$ok=1;
				}
			}
		}
		$info=array(
			'ok'=>$ok,
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
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_goiy_hangtau($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_hangtau ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<div class="li_goiy li_goiy_hangtau selected" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'('.$r_tt['viet_tat'].')</div>';
			} else {
				$list .= '<div class="li_goiy li_goiy_hangtau" value="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'('.$r_tt['viet_tat'].')</div>';
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
	///////////////////////
	function phantrang_sanpham($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 AND $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="javascript:;" page="' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="javascript:;" page="' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}

			}
		}
	}
	///////////////////////
	function phantrang($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 AND $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '?page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '?page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}

			}
		}
	}
	///////////////////////
	function phantrang_timkiem($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total <= 5) {
				for ($i = 1; $i <= $total; $i++) {
					if ($page == $i) {
						$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
					} else {
						$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
					}
				}
				return $list;
			} else {
				if ($page <= 3) {
					for ($i = 1; $i <= 5; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else if ($page > 3 AND $page <= ($total - 2)) {
					$start = $page - 2;
					$end = $page + 2;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				} else {
					$start = $total - 4;
					$end = $total;
					for ($i = $start; $i <= $end; $i++) {
						if ($page == $i) {
							$list .= '<a href="' . $link . '&page=' . $i . '" class="active">' . $i . '</a>';
						} else {
							$list .= '<a href="' . $link . '&page=' . $i . '">' . $i . '</a>';
						}
					}
					return $list;
				}

			}
		}
	}

	
}
?>

