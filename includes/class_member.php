<?php
class class_member extends class_manage{
    function user_info($conn,$user_id){
        $check = $this->load('class_check');
        $tach=json_decode($check->token_login_decode($user_id),true);
        $user_id=$tach['user_id'];
        $password=$tach['password'];
     
        $info=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$user_id' AND password='$password' ORDER BY user_id ASC LIMIT 1");
        $total=mysqli_num_rows($info);
        if($total>0){
            $r_info=mysqli_fetch_assoc($info);
            return $r_info;
        }else{
            return '';
        }
    }
    function list_option_phongban($conn, $admin_cty, $user_id, $disable_parent = false){
        $html = '<option value="">Chọn phòng ban</option>';
        $phong_ban_user = 0;
        if($user_id > 0){
            $q = mysqli_query($conn,"SELECT phong_ban FROM user_info WHERE user_id='$user_id' AND admin_cty='$admin_cty' LIMIT 1");
            if(mysqli_num_rows($q)){
                $r = mysqli_fetch_assoc($q);
                $phong_ban_user = intval($r['phong_ban']);
            }
        }
        if($phong_ban_user == 0) return $html;
    
        $root = mysqli_query($conn,"SELECT id, tieu_de FROM phong_ban  WHERE id='$phong_ban_user' AND admin_cty='$admin_cty' LIMIT 1");
    
        if(!mysqli_num_rows($root)) return $html;
    
        $r_root = mysqli_fetch_assoc($root);
    
        $disabled = $disable_parent ? ' disabled' : '';
        $html .= '<option value="'.$r_root['id'].'"'.$disabled.'>'
              . $r_root['tieu_de']
              . '</option>';
    
        $html .= $this->render_phongban_tree($conn,$admin_cty,$r_root['id'],1,$disable_parent);
        return $html;
    }
    function render_phongban_tree($conn, $admin_cty, $parent_id, $level = 0, $disable_parent = false){
        $html = '';
        $prefix = str_repeat('— ', $level);
    
        $sql = "SELECT id, tieu_de 
                FROM phong_ban 
                WHERE parent_id='$parent_id' 
                  AND admin_cty='$admin_cty'
                ORDER BY id ASC";
        $query = mysqli_query($conn, $sql);
    
        while($row = mysqli_fetch_assoc($query)){
            $has_child = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM phong_ban  WHERE parent_id='".$row['id']."' AND admin_cty='$admin_cty' LIMIT 1")) > 0;
    
            $disabled = ($disable_parent && $has_child) ? ' disabled' : '';
    
            $html .= '<option value="'.$row['id'].'"'.$disabled.'>'
                  . $prefix . $row['tieu_de']
                  . '</option>';
    
            $html .= $this->render_phongban_tree($conn,$admin_cty,$row['id'],$level + 1,$disable_parent);
        }
    
        return $html;
    }
        
    function total_giaoviec($conn, $user_id, $admin_cty, $type){
        $check = $this->load('class_check');
        if($type == 'nhan'){
            $where_condition = "id_nguoi_nhan = '$user_id'";
        } else if($type == 'giao'){
            $where_condition = "id_nguoi_giao = '$user_id'";
        } else if($type == 'giamsat'){
            $where_condition = "id_nguoi_giamsat = '$user_id'";
        }
        $thongtin = mysqli_query($conn, "SELECT COUNT(*) as total FROM giaoviec_tructiep WHERE $where_condition AND admin_cty='$admin_cty' AND phantram_hoanthanh!='100' AND trang_thai !=  '6'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        return $r_tt['total'];
    }
    function list_giaoviec_tructiep_nhan($conn, $user_id, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $where_condition = "id_nguoi_nhan = '$user_id'";
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND $where_condition AND phantram_hoanthanh!='100' AND trang_thai != '6' ORDER BY id DESC LIMIT $start,$limit");
		$total=mysqli_num_rows($thongtin);

        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];

            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }

            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            $list .= $skin->skin_replace('skin_members/box_action/tr_nhanviec', $r_tt);
        }
        if($i==0){
			$start=0;
		}else{
			$start=$start + 1;
		}
		$info=array(
            'total' => $total,
			'start'=>$start,
			'end'=>$i,
			'list'=>$list
		);
		return json_encode($info);
    }
    function list_giaoviec_tructiep_giao($conn, $user_id, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $where_condition = "id_nguoi_giao = '$user_id'";
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND $where_condition AND phantram_hoanthanh!='100' AND trang_thai != '6' ORDER BY id DESC LIMIT $start,$limit");
        $total=mysqli_num_rows($thongtin);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) { 
            $i++;
            $r_tt['i'] = $i;
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
           
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }
            
            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            $list .= $skin->skin_replace('skin_members/box_action/tr_giaoviec', $r_tt);
        }
        if($i==0){
			$start=0;
		}else{
			$start=$start + 1;
		}
		$info=array(
            'total' => $total,
			'start'=>$start,
			'end'=>$i,
			'list'=>$list
		);
		return json_encode($info);
    }
    function list_giaoviec_tructiep_giamsat($conn, $user_id, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $where_condition = "id_nguoi_giamsat = '$user_id'";
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND $where_condition AND phantram_hoanthanh!='100' AND trang_thai != '6' ORDER BY id DESC LIMIT $start,$limit");
        $total=mysqli_num_rows($thongtin);
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }

            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            $list .= $skin->skin_replace('skin_members/box_action/tr_nhanviec', $r_tt);
        }
        if($i==0){
			$start=0;
		}else{
            $start=$start + 1;
        }
        $info=array(
            'total' => $total,
            'start'=>$start,
            'end'=>$i,
            'list'=>$list
        );
        return json_encode($info);
    }
    function list_search_giaoviec_giao($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $where = "";
        if($search_keyword != ''){
            $where .= " AND ten_congviec LIKE '%$search_keyword%'";
        }
        if($search_trang_thai != ''){
            $where .= " AND trang_thai='$search_trang_thai'";
        }
        if (!empty($search_ngay_bat_dau)) {
            $start = strtotime($search_ngay_bat_dau . ' 00:00:00');
            $end   = strtotime($search_ngay_bat_dau . ' 23:59:59');

            $where .= " AND date_post BETWEEN $start AND $end"; 
        }

        if (!empty($search_han_hoan_thanh)) {
            $where .= " AND han_hoanthanh LIKE '$search_han_hoan_thanh%'";
        }

        $where .= " AND (id_nguoi_giao = '$user_id')";
        
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND trang_thai != '6' $where ORDER BY id DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }
            $list .= $skin->skin_replace('skin_members/box_action/tr_giaoviec', $r_tt);
        }
        return $list;
    }
    function list_search_giaoviec_nhan($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $where = "";
        if($search_keyword != ''){
            $where .= " AND ten_congviec LIKE '%$search_keyword%'";
        }
        if($search_trang_thai != ''){
            $where .= " AND trang_thai='$search_trang_thai'";
        }
        if (!empty($search_ngay_bat_dau)) {
            $start = strtotime($search_ngay_bat_dau . ' 00:00:00');
            $end   = strtotime($search_ngay_bat_dau . ' 23:59:59');

            $where .= " AND date_post BETWEEN $start AND $end"; 
        }

        if (!empty($search_han_hoan_thanh)) {
            $where .= " AND han_hoanthanh LIKE '$search_han_hoan_thanh%'";
        }
        $where .= " AND id_nguoi_nhan = '$user_id'";
        
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND trang_thai != '6' $where ORDER BY id DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }
            $list .= $skin->skin_replace('skin_members/box_action/tr_giaoviec', $r_tt);
        }
        return $list;
    }
    function list_search_giaoviec_giamsat($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_han_hoan_thanh, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $where = "";
        if($search_keyword != ''){
            $where .= " AND ten_congviec LIKE '%$search_keyword%'";
        }
        if($search_trang_thai != ''){
            $where .= " AND trang_thai='$search_trang_thai'";
        }
        if (!empty($search_ngay_bat_dau)) {
            $start = strtotime($search_ngay_bat_dau . ' 00:00:00');
            $end   = strtotime($search_ngay_bat_dau . ' 23:59:59');

            $where .= " AND date_post BETWEEN $start AND $end"; 
        }
        $where .= " AND id_nguoi_giamsat = '$user_id'";
        
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND trang_thai != '6' $where ORDER BY id DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$r_tt[id_nguoi_giao]' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$r_nguoi_giao[phong_ban]'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['ten_phongban'] = $r_phongban['tieu_de'];
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ngay_tao'] = date('d/m/Y',($r_tt['date_post']));

            $trang_thai_num = $r_tt['trang_thai'];
            
                    switch ($r_tt['trang_thai']) {
                    case 0:
                        $r_tt['trang_thai_text'] = '<span style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</span>';
                        break;
                    case 1:
                        $r_tt['trang_thai_text'] = '<span style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</span>';
                        break;
                    case 2:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</span>';
                        break;
                    case 3:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</span>';
                        break;
                    case 4:
                        $r_tt['trang_thai_text'] = '<span style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</span>';
                        break;
                    case 5:
                        $r_tt['trang_thai_text'] = '<span style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</span>';
                        break;
                    case 6:
                        $r_tt['trang_thai_text'] = '<span style="color: #28a745; font-weight: bold; font-size: 14px;">Đã hoàn thành</span>';
                        break;
                    default:
                        $r_tt['trang_thai_text'] = '<span>Không xác định</span>';
                        break;
                }
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

            // Lưu giá trị gốc cho class
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }
            $list .= $skin->skin_replace('skin_members/box_action/tr_giaoviec', $r_tt);
        }
        return $list;
    }
    function list_option_edit_phongban($conn, $admin_cty, $id_phongban_nhan){
        $html = '<option value="">Chọn phòng ban</option>';
        $html .= $this->render_phongban_tree_edit($conn,$admin_cty,0,0,$id_phongban_nhan);
        return $html;
    }
    function render_phongban_tree_edit($conn,$admin_cty,$parent_id = 0,$level = 0,$selected_id = 0){
        $html = '';
        $prefix = str_repeat('— ', $level);
    
        $sql = "SELECT id, tieu_de FROM phong_ban WHERE parent_id='$parent_id' AND admin_cty='$admin_cty' ORDER BY id ASC";
        $query = mysqli_query($conn, $sql);
    
        while($row = mysqli_fetch_assoc($query)){
            $selected = ($row['id'] == $selected_id) ? ' selected' : '';
    
            $html .= '<option value="'.$row['id'].'"'.$selected.'>'
                  . $prefix . $row['tieu_de']
                  . '</option>';
    
            $html .= $this->render_phongban_tree_edit($conn,$admin_cty,$row['id'],$level + 1,$selected_id);
        }
        return $html;
    }
    
    function list_option_edit_nguoi_nhan($conn, $admin_cty, $id_phongban_nhan, $id_nguoi_nhan){
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE phong_ban='$id_phongban_nhan' AND admin_cty='$admin_cty' ORDER BY user_id ASC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $selected = ($r_tt['user_id'] == $id_nguoi_nhan) ? ' selected' : '';
            $list .= '<option value="' . $r_tt['user_id'] . '"' . $selected . '>' . $r_tt['name'] . '</option>';
        }
        return '<option value="">Chọn người nhận việc</option>'. $list;
    }
    function list_option_edit_nguoi_giamsat($conn,$admin_cty,$id_nguoi_giamsat,$id_nguoi_nhan = 0){
        $list = '<option value="">Chọn người giám sát</option>';
    
        if($id_nguoi_nhan <= 0) return $list;
    
        // Lấy phòng ban của người nhận
        $q_user = mysqli_query($conn,"SELECT phong_ban FROM user_info WHERE user_id='$id_nguoi_nhan'AND admin_cty='$admin_cty'LIMIT 1");
    
        if(!mysqli_num_rows($q_user)) return $list;
    
        $r_user = mysqli_fetch_assoc($q_user);
        $phong_ban_nhan = intval($r_user['phong_ban']);
        if($phong_ban_nhan <= 0) return $list;
    
        // Lấy phòng ban hiện tại + toàn bộ cha
        $phongban_ids = $this->get_all_parent_phongban($conn,$admin_cty,$phong_ban_nhan);
        if(empty($phongban_ids)) return $list;
    
        $ids_str = implode(',', $phongban_ids);
    
        // Lấy user thuộc các phòng ban này
        $thongtin = mysqli_query($conn,"SELECT user_id, name FROM user_info WHERE phong_ban IN ($ids_str) AND admin_cty='$admin_cty'ORDER BY user_id ASC");
    
        while($r_tt = mysqli_fetch_assoc($thongtin)){
            $selected = ($r_tt['user_id'] == $id_nguoi_giamsat) ? ' selected' : '';
            $list .= '<option value="'.$r_tt['user_id'].'"'.$selected.'>'
                  . $r_tt['name']
                  . '</option>';
        }
    
        return $list;
    }
function get_all_parent_phongban($conn, $admin_cty, $phongban_id){
    $ids = [];

    while($phongban_id > 0){
        $ids[] = $phongban_id;
        $q = mysqli_query($conn,"SELECT parent_id FROM phong_ban WHERE id='$phongban_id' AND admin_cty='$admin_cty' LIMIT 1");
        if(!mysqli_num_rows($q)) break;
        $r = mysqli_fetch_assoc($q);
        $phongban_id = intval($r['parent_id']);
    }

    return array_unique($ids);
}
    
    function list_lichsu_baocao($conn, $admin_cty, $id, $user_id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id_congviec='$id' AND admin_cty='$admin_cty' AND action='giaoviec_tructiep' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y H:i', ($r_tt['date_post']));
            $tiendo_value = intval($r_tt['tiendo_hoanthanh']);
            $r_tt['tiendo_value'] = $tiendo_value;
            // Xác định class CSS theo khoảng tiến độ
            if($tiendo_value >= 0 && $tiendo_value < 50){
                $r_tt['tiendo_class'] = 'progress_low';
            }elseif($tiendo_value >= 50 && $tiendo_value < 70){
                $r_tt['tiendo_class'] = 'progress_medium';
            }elseif($tiendo_value >= 70 && $tiendo_value < 90){
                $r_tt['tiendo_class'] = 'progress_good';
            }else{
                $r_tt['tiendo_class'] = 'progress_complete';
            }
            $thongtin_giaoviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
            $r_giaoviec = mysqli_fetch_assoc($thongtin_giaoviec);
            $id_nguoi_giao = $r_giaoviec['id_nguoi_giao'];
            if($user_id == $id_nguoi_giao){
                if($r_tt['trang_thai'] == 0){
                        $r_tt['action_buttons'] = '<button class="btn_action btn_nhanxet" name="box_pop_duyet" data-id="'.$r_tt['id'].'" data-action="giaoviec_tructiep" title="Duyệt">
                            <i class="fa fa-check"></i>    
                        </button>';
                } else if($r_tt['trang_thai'] == 3){
                        $r_tt['action_buttons'] = '<button class="btn_action btn_nhanxet" name="box_pop_nhanxet" data-id="'.$r_tt['id'].'" data-action="giaoviec_tructiep" title="Nhận xét">
                            <i class="fa fa-comment"></i>
                        </button>';
                }else {
                    $r_tt['action_buttons'] = '';
                }
            }else {
                $r_tt['action_buttons'] = '';
            }
            $r_tt['tiendo_hoanthanh'] = $r_tt['tiendo_hoanthanh'] . '%';
            
            // Xử lý hiển thị trạng thái
            switch($r_tt['trang_thai']){
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_pending">Chờ duyệt</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_approved">Đã duyệt</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_rejected">Từ chối</span>';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_comment">Chờ nhận xét</span>';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_commented">Đã nhận xét</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            $r_tt['ghi_chu_capnhat'] = $r_tt['ghi_chu_capnhat'];
            $r_tt['file_list_existing'] = '';
            $r_tt['file_list_display'] = '';
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_baocao', $r_tt);
        }
        return $list;
    }
    function list_lichsu_giahan($conn, $user_id, $admin_cty, $id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id_congviec='$id' AND admin_cty='$admin_cty' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $thongtin_giaoviec = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE id='$id' AND admin_cty='$admin_cty'");
            $r_giaoviec = mysqli_fetch_assoc($thongtin_giaoviec);
            $id_nguoi_giao = $r_giaoviec['id_nguoi_giao'];
            $r_tt['han_hoanthanh'] = date('d/m/Y H:i', strtotime($r_giaoviec['han_hoanthanh']));
            
            // Format thời gian gia hạn thêm
            if(!empty($r_tt['time_new'])){
                $r_tt['thoi_gian_giahan'] = date('d/m/Y H:i', strtotime($r_tt['time_new']));
            } else {
                $r_tt['thoi_gian_giahan'] = '-';
            }
            
            // Format trạng thái
            switch($r_tt['trang_thai']){
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_pending">Chờ duyệt</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_approved">Đã duyệt</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_rejected">Từ chối</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            // Chỉ hiển thị action buttons cho trang_thai = 0 khi ở trang list-congviec-quanly và là người giao việc
            if($r_tt['trang_thai'] == 0){
                if($id_nguoi_giao == $user_id){
                    $r_tt['action_buttons'] = '<button class="btn_action btn_view" name="box_pop_duyet_giahan_tructiep" data-id="'.$r_tt['id'].'" data-action="giaoviec_tructiep" title="Duyệt">
                        <i class="fa fa-check"></i>
                    </button>';
                } else {
                    $r_tt['action_buttons'] = '';
                }
            } else {
                $r_tt['action_buttons'] = '';
            }
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_giahan', $r_tt);
        }
        return $list;
    }
    function list_lichsu_giaoviec($conn, $admin_cty, $user_id, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' AND trang_thai = '6'  AND (id_nguoi_giao = '$user_id' OR id_nguoi_nhan = '$user_id') ORDER BY id DESC LIMIT $start,$limit");
        $total=mysqli_num_rows($thongtin);
		$k=$total;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
          
            $i++;
            // Đảm bảo tất cả biến có giá trị, không null
            $r_tt['i'] = $i;
            $r_tt['id'] = $r_tt['id'];
            
            // Format ngày hoàn thành
            $r_tt['ngay_hoanthanh'] = !empty($r_tt['update_post']) ? date('d/m/Y H:i', $r_tt['update_post']) : '-';
            
            // Lấy tên người nhận việc
            $r_tt['ten_nguoi_nhan'] = 'Không xác định';
            if(!empty($r_tt['id_nguoi_giao'])){
                $thongtin_nguoi_giao = mysqli_query($conn, "SELECT name FROM user_info WHERE user_id='{$r_tt['id_nguoi_giao']}' AND admin_cty='$admin_cty' LIMIT 1");
                if(mysqli_num_rows($thongtin_nguoi_giao) > 0){
                    $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
                    $r_tt['ten_nguoi_giao'] = !empty($r_nguoi_giao['name']) ? $r_nguoi_giao['name'] : 'Không xác định';
                }
            }
            if(!empty($r_tt['id_nguoi_nhan'])){
                $thongtin_nguoi_nhan = mysqli_query($conn, "SELECT name FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty' LIMIT 1");
                if(mysqli_num_rows($thongtin_nguoi_nhan) > 0){
                    $r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
                    $r_tt['ten_nguoi_nhan'] = !empty($r_nguoi_nhan['name']) ? $r_nguoi_nhan['name'] : 'Không xác định';
                }
            }
            // Format tên công việc
            $r_tt['ten_congviec'] = !empty($r_tt['ten_congviec']) ? htmlspecialchars($r_tt['ten_congviec']) : '-';
            
            // Format phần trăm công việc
            $r_tt['phantram_hoanthanh'] = !empty($r_tt['phantram_hoanthanh']) ? intval($r_tt['phantram_hoanthanh']) : 0;
            
            // Trạng thái luôn là "Hoàn thành"
            if($r_tt['trang_thai'] == 6){
                $r_tt['trang_thai_text'] = '<span class="status_badge status_completed">Hoàn thành</span>';
            } else if($r_tt['trang_thai'] == 3){
                $r_tt['trang_thai_text'] = '<span class="status_badge status_pending">Miss Deadline</span>';
            }
            
           
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_giaoviec', $r_tt);
        }
        if($i==0){
			$start=0;
		}else{
			$start=$start + 1;
		}
		$info=array(
			'start'=>$start,
			'end'=>$i,
			'list'=>$list
		);
		return json_encode($info);
    }
    function list_du_an($conn, $user_id, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        
        // Lấy danh sách các dự án duy nhất mà user có liên quan (người nhận hoặc người giao)
        $thongtin = mysqli_query($conn, "
            SELECT DISTINCT 
                da.*
            FROM du_an as da
            WHERE da.admin_cty = '$admin_cty' AND trang_thai != 6
            AND EXISTS (
                SELECT 1 
                FROM congviec_du_an cda
                WHERE cda.id_du_an = da.id
                AND (cda.id_nguoi_nhan = '$user_id' 
                    OR cda.id_nguoi_giao = '$user_id')
            )
            ORDER BY da.id DESC 
            LIMIT $start, $limit
        ");        
        $total=mysqli_num_rows($thongtin);
		$k=$total;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y', $r_tt['date_post']) : '-';

            $r_tt['id'] = $r_tt['id'];
            // Lấy thông tin người tạo dự án
            $thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty'");
            $r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
            $r_tt['ten_nguoi_tao'] = !empty($r_nguoi_tao['name']) ? $r_nguoi_tao['name'] : 'Không xác định';
            
            // Lấy thông tin phòng ban
            if(!empty($r_nguoi_tao['phong_ban'])){
                $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_tao['phong_ban']}'");
                $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
                $r_tt['ten_phongban'] = !empty($r_phongban['tieu_de']) ? $r_phongban['tieu_de'] : '';
            } else {
                $r_tt['ten_phongban'] = '';
            }
            
           
            
            // Format mức độ ưu tiên
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            if($r_tt['miss_deadline'] == 1){
                $r_tt['miss_deadline_text'] = '<span style="color: #dc3545; font-weight: 500; font-size: 14px; padding: 5px 10px;">Đã quá hạn</span>';
            } else {
                $r_tt['miss_deadline_text'] = '';
            }
            // Format trạng thái
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang thực hiện</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_2">Chờ phê duyệt</span>';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_3">Miss Deadline</span>';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_4">Từ chối</span>';
                    break;
                case 5:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_5">Xin gia hạn</span>';
                    break;
                case 6:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_6">Hoàn thành</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            // Format tên dự án
            $r_tt['ten_du_an'] = !empty($r_tt['ten_du_an']) ? htmlspecialchars($r_tt['ten_du_an']) : '-';
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_du_an', $r_tt);
        }
        if($i==0){
			$start=0;
		}else{
			$start=$start + 1;
		}
		$info=array(
			'start'=>$start,
			'end'=>$i,
			'list'=>$list
		);
		return json_encode($info);
    }
    function total_du_an($conn,$user_id, $admin_cty){
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an WHERE id_nguoi_nhan='$user_id' AND admin_cty='$admin_cty'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		return $r_tt['total'];
	}
    function list_search_du_an($conn, $user_id, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_bat_dau, $search_nguoi_quan_ly, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $where = "";
        if($search_keyword != ''){
            $where .= " AND da.ten_du_an LIKE '%$search_keyword%'";
        }
        if($search_trang_thai != ''){
            $where .= " AND da.trang_thai='$search_trang_thai'";
        }
        if (!empty($search_ngay_bat_dau)) {
            $start = strtotime($search_ngay_bat_dau . ' 00:00:00');
            $end   = strtotime($search_ngay_bat_dau . ' 23:59:59');
            $where .= " AND da.date_post BETWEEN $start AND $end"; 
        }
        if($search_nguoi_quan_ly != ''){
            $where .= " AND da.user_id='$search_nguoi_quan_ly'";
        }
        // Lấy danh sách các dự án duy nhất mà user có liên quan (người nhận hoặc người giao) từ congviec_du_an
        $thongtin = mysqli_query($conn, "SELECT DISTINCT da.id, da.admin_cty, da.user_id, da.ten_du_an, da.mucdo_uutien, da.mo_ta, da.ghi_chu, da.trang_thai, da.date_post, da.update_post
            FROM congviec_du_an cda 
            INNER JOIN du_an da ON cda.id_du_an = da.id 
            WHERE (cda.id_nguoi_nhan='$user_id' OR cda.id_nguoi_giao='$user_id') AND da.trang_thai != 6
            AND cda.admin_cty='$admin_cty' 
            AND da.admin_cty='$admin_cty'
            $where
            ORDER BY da.id DESC 
            LIMIT $limit");
        
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            // Lấy thông tin người tạo dự án
            $thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty'");
            $r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
            $r_tt['ten_nguoi_tao'] = !empty($r_nguoi_tao['name']) ? $r_nguoi_tao['name'] : 'Không xác định';
            
            // Lấy thông tin phòng ban
            if(!empty($r_nguoi_tao['phong_ban'])){
                $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_tao['phong_ban']}'");
                $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
                $r_tt['ten_phongban'] = !empty($r_phongban['tieu_de']) ? $r_phongban['tieu_de'] : '';
            } else {
                $r_tt['ten_phongban'] = '';
            }
            
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y', $r_tt['date_post']) : '-';
            
            // Format mức độ ưu tiên
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            $r_tt['miss_deadline_text'] = '';
            if($r_tt['miss_deadline'] == 1){
                $r_tt['miss_deadline_text'] = '<span style="color: #dc3545; font-weight: 500; font-size: 14px; padding: 5px 10px;">Đã quá hạn</span>';
            } else {
                $r_tt['miss_deadline_text'] = '';
            }
            // Format trạng thái
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang thực hiện</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_2">Chờ phê duyệt</span>';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_3">Miss Deadline</span>';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_4">Từ chối</span>';
                    break;
                case 5:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_5">Xin gia hạn</span>';
                    break;
                case 6:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_6">Hoàn thành</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            // Format tên dự án
            $r_tt['ten_du_an'] = !empty($r_tt['ten_du_an']) ? htmlspecialchars($r_tt['ten_du_an']) : '-';
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_du_an', $r_tt);
        }
        return $list;
    }
    // Hàm xây dựng cây phân cấp sơ đồ phân công (HTML cũ - giữ lại để tương thích)
    function build_org_chart_tree($items, $parent_id = 0, $level = 0) {
        $html = '';
        $children_found = array();
        
        // Tìm tất cả các item có parent_id tương ứng
        foreach ($items as $item) {
            if ((int)$item['parent_id'] == (int)$parent_id) {
                $children_found[] = $item;
            }
        }
        
        // Nếu không có con, trả về rỗng
        if (empty($children_found)) {
            return '';
        }
        
        // Nếu có nhiều con, wrap chúng trong container
        if (count($children_found) > 1 && $level > 0) {
            $html .= '<div class="org_chart_children">';
        }
        
        foreach ($children_found as $item) {
            $html .= '<div class="org_chart_node" data-level="' . $level . '">';
            
            // Nếu không phải cấp đầu tiên, thêm mũi tên từ cha
            if ($level > 0) {
                $html .= '<div class="org_chart_arrow"></div>';
            }
            
            // Card công việc
            $html .= '<div class="org_chart_item">';
            $html .= '<div class="org_chart_avatar"><i class="fa fa-briefcase"></i></div>';
            $html .= '<div class="org_chart_name">' . $item['ten_congviec'] . '</div>';
            $html .= '<div class="org_chart_info">';
            $html .= '<div class="org_chart_person"><i class="fa fa-user"></i> ' . $item['ten_nguoi_nhan'] . '</div>';
            if (!empty($item['phong_ban_nhan'])) {
                $html .= '<div class="org_chart_department"><i class="fa fa-building"></i> ' . $item['phong_ban_nhan'] . '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            
            // Tìm và render các con (gọi đệ quy)
            $children_html = $this->build_org_chart_tree($items, $item['id'], $level + 1);
            if ($children_html) {
                $html .= $children_html;
            }
            
            $html .= '</div>';
        }
        
        // Đóng container nếu có nhiều con
        if (count($children_found) > 1 && $level > 0) {
            $html .= '</div>';
        }
        
        return $html;
    }
    
    // Hàm xây dựng dữ liệu JSON cho OrgChart.js
    function build_org_chart_json($items, $parent_id = 0) {
        $result = array();
        
        // Tìm tất cả các item có parent_id tương ứng
        foreach ($items as $item) {
            if ((int)$item['parent_id'] == (int)$parent_id) {
                $node = array(
                    'id' => (string)$item['id'],
                    'name' => $item['ten_nguoi_nhan'], // OrgChart.js dùng 'name' để hiển thị
                    'title' => $item['ten_nguoi_nhan'],
                    'department' => !empty($item['phong_ban_nhan']) ? $item['phong_ban_nhan'] : '',
                    'ngay_giao' => !empty($item['ngay_giao']) ? $item['ngay_giao'] : '',
                    'deadline' => !empty($item['deadline']) ? $item['deadline'] : '',
                    'is_miss_deadline' => !empty($item['is_miss_deadline']) ? $item['is_miss_deadline'] : false,
                    'trang_thai' => !empty($item['trang_thai']) ? $item['trang_thai'] : 0,
                    'role' => !empty($item['role']) ? $item['role'] : '',
                    'isRoot' => ($parent_id == 0 && empty($result)) // Đánh dấu node đầu tiên
                );
                
                // Tìm và thêm các con
                $children = $this->build_org_chart_json($items, $item['id']);
                if (!empty($children)) {
                    $node['children'] = $children;
                }
                
                $result[] = $node;
            }
        }
        
        return $result;
    }
    
    // Format danh sách thành viên cho template
    function list_han_nhanviec($conn, $admin_cty, $id_du_an){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';

        $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id_du_an' AND admin_cty='$admin_cty' ORDER BY id ASC");
        while($r_tt = mysqli_fetch_assoc($thongtin)){
            $r_tt['id'] = $r_tt['id'];
            $id_nguoi_nhan = $r_tt['id_nguoi_nhan'];
            $thongtin_nguoi_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id_nguoi_nhan' AND admin_cty='$admin_cty'");
            $r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
            $r_tt['ten_nguoi_nhan'] = !empty($r_nguoi_nhan['name']) ? $r_nguoi_nhan['name'] : 'Không xác định';
            $phong_ban = $r_nguoi_nhan['phong_ban'];
            $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$phong_ban' AND admin_cty='$admin_cty'");
            $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
            $r_tt['phong_ban_nhan'] = !empty($r_phongban['tieu_de']) ? $r_phongban['tieu_de'] : '';
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_nhan'] = '<div style="color:rgb(255, 94, 7);font-weight: bold; font-size: 14px;">Chờ xử lý</div>';
                    break;
                case 1:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #007bff;font-weight: bold; font-size: 14px;">Đang triển khai</div>';
                    break;
                case 2:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #ffc107; font-weight: bold;font-size: 14px;">Chờ phê duyệt</div>';
                    break;
                case 3:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #dc3545; font-weight: bold; font-size: 14px;">Miss Deadline</div>';
                    break;
                case 4:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #dc3545; font-weight: bold; font-size: 14px;">Từ chối</div>';
                    break;
                case 5:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #ffc107; font-weight: bold; font-size: 14px;">Xin gia hạn</div>';
                    break;
                case 6:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #28a745; font-weight: bold; font-size: 14px;">Hoàn thành</div>';
                    break;
                default:
                    $r_tt['trang_thai_nhan'] = '<div style="color: #6c757d; font-weight: bold; font-size: 14px;">Không xác định</div>  ';
                    break;
            }
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', intval($r_tt['han_hoanthanh']));
                    $r_tt['deadline_timestamp'] = intval($r_tt['han_hoanthanh']);
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = $timestamp ? date('d/m/Y H:i', $timestamp) : '';
                    $r_tt['deadline_timestamp'] = $timestamp ? $timestamp : 0;
                }
            } else {
                $r_tt['han_hoan_thanh'] = '';
                $r_tt['deadline_timestamp'] = 0;
            }
            $list .= $skin->skin_replace('skin_members/box_action/tr_han_nhanviec', $r_tt);
        }
        return $list;
    }
    function list_lichsu_baocao_congviec_du_an($conn, $admin_cty, $id, $user_id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM lichsu_baocao WHERE id_congviec='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y H:i', ($r_tt['date_post']));
            $tiendo_value = intval($r_tt['tiendo_hoanthanh']);
            $r_tt['tiendo_value'] = $tiendo_value;
            // Xác định class CSS theo khoảng tiến độ
            if($tiendo_value >= 0 && $tiendo_value < 50){
                $r_tt['tiendo_class'] = 'progress_low';
            }elseif($tiendo_value >= 50 && $tiendo_value < 70){
                $r_tt['tiendo_class'] = 'progress_medium';
            }elseif($tiendo_value >= 70 && $tiendo_value < 90){
                $r_tt['tiendo_class'] = 'progress_good';
            }else{
                $r_tt['tiendo_class'] = 'progress_complete';
            }
            $thongtin_nguoi_giao = mysqli_query($conn, "SELECT id_nguoi_giao FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
            $id_nguoi_giao = $r_nguoi_giao['id_nguoi_giao'];
            
            if($id_nguoi_giao == $user_id){
                if($r_tt['trang_thai'] == 0){
                    $r_tt['action_buttons'] = '<button class="btn_action btn_nhanxet" name="box_pop_duyet" data-id="'.$r_tt['id'].'" data-action="giaoviec_du_an" title="Duyệt">
                        <i class="fa fa-check"></i>    
                    </button>';
                } else if($r_tt['trang_thai'] == 3){
                    $r_tt['action_buttons'] = '<button class="btn_action btn_nhanxet" name="box_pop_nhanxet" data-id="'.$r_tt['id'].'" data-action="giaoviec_du_an" title="Nhận xét">
                        <i class="fa fa-comment"></i>
                    </button>';
                }else {
                    $r_tt['action_buttons'] = '';
                }
            } else {
                $r_tt['action_buttons'] = '';
            }
            
            $r_tt['tiendo_hoanthanh'] = $r_tt['tiendo_hoanthanh'] . '%';
            
            // Xử lý hiển thị trạng thái
            switch($r_tt['trang_thai']){
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_pending">Chờ duyệt</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_approved">Đã duyệt</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_rejected">Từ chối</span>';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_comment">Chờ nhận xét</span>';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_commented">Đã nhận xét</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            $r_tt['ghi_chu_capnhat'] = $r_tt['ghi_chu_capnhat'];
            $r_tt['file_list_existing'] = '';
            $r_tt['file_list_display'] = '';
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_baocao', $r_tt);
        }
        return $list;
    }
    function list_lichsu_giahan_congviec_du_an($conn, $user_id, $admin_cty, $id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM lichsu_giahan WHERE id_congviec='$id' AND admin_cty='$admin_cty' AND action='giaoviec_du_an' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            
            $i++;
            $r_tt['i'] = $i;
            $thongtin_giaoviec = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id='$id' AND admin_cty='$admin_cty'");
            $r_giaoviec = mysqli_fetch_assoc($thongtin_giaoviec);
            $id_nguoi_giao = $r_giaoviec['id_nguoi_giao'];
            $r_tt['han_hoanthanh'] = date('d/m/Y H:i', strtotime($r_giaoviec['han_hoanthanh']));
            
            // Format thời gian gia hạn thêm
            if(!empty($r_tt['time_new'])){
                $r_tt['thoi_gian_giahan'] = date('d/m/Y H:i', strtotime($r_tt['time_new']));
            } else {
                $r_tt['thoi_gian_giahan'] = '-';
            }
            
            // Format trạng thái
            switch($r_tt['trang_thai']){
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_pending">Chờ duyệt</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_approved">Đã duyệt</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_rejected">Từ chối</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            // Chỉ hiển thị action buttons cho trang_thai = 0 khi ở trang list-congviec-quanly và là người giao việc
            if($r_tt['trang_thai'] == 0){
                if($id_nguoi_giao == $user_id){
                    $r_tt['action_buttons'] = '<button class="btn_action btn_view" name="box_pop_duyet_giahan_du_an" data-id="'.$r_tt['id'].'" data-action="giaoviec_du_an" title="Duyệt">
                        <i class="fa fa-check"></i>
                    </button>';
                } else {
                    $r_tt['action_buttons'] = '';
                }
            } else {
                $r_tt['action_buttons'] = '';
            }
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_giahan', $r_tt);
        }
        return $list;
    }
    function list_nhanvien_du_an($conn, $admin_cty, $id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id' AND admin_cty='$admin_cty' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            
            $i++;
            $r_tt['member_index'] = $i;
            $r_tt['id'] = $r_tt['id'];
            $thongtin_user = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
            $r_nguoi_nhan = mysqli_fetch_assoc($thongtin_user);
            $id_phongban_nhan = $r_nguoi_nhan['phong_ban'];

            $r_tt['option_phongban'] = $this->list_option_edit_phongban($conn, $admin_cty, $id_phongban_nhan);
            $r_tt['option_nguoi_nhan'] = $this->list_option_edit_nguoi_nhan($conn, $admin_cty, $id_phongban_nhan, $r_tt['id_nguoi_nhan']);
       
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $r_tt['han_hoan_thanh_value'] = date('Y-m-d\TH:i', intval($r_tt['han_hoanthanh']));
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh_value'] = $timestamp ? date('Y-m-d\TH:i', $timestamp) : '';
                }
            } else {
                $r_tt['han_hoan_thanh_value'] = '';
            }

            $mucdo_uutien = !empty($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
            $r_tt['selected_thap'] = ($mucdo_uutien == 'thap') ? 'selected' : '';
            $r_tt['selected_binh_thuong'] = ($mucdo_uutien == 'binh_thuong') ? 'selected' : '';
            $r_tt['selected_cao'] = ($mucdo_uutien == 'cao') ? 'selected' : '';
            $r_tt['selected_rat_cao'] = ($mucdo_uutien == 'rat_cao') ? 'selected' : '';
            $file_list_existing = '';

            if(!empty($r_tt['file_congviec'])){
                $files = array();
                
                // Thử decode JSON trước
                $decoded = json_decode($r_tt['file_congviec'], true);
                if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
                    // Là JSON array
                    $files = $decoded;
                }else{
                    // Không phải JSON, xử lý như chuỗi comma-separated
                    // Loại bỏ dấu ngoặc vuông, ngoặc kép và khoảng trắng
                    $cleaned = trim($r_tt['file_congviec'], '[]"\'');
                    $files = explode(',', $cleaned);
                }
                
                $file_list_html = '';
                foreach($files as $file){
                    // Loại bỏ khoảng trắng, dấu ngoặc kép, dấu ngoặc đơn
                    $file = trim($file, ' "\'[]');
                    if(!empty($file)){
                        $file_name = basename($file);
                        $file_url = '/uploads/giaoviec/file_congviec_du_an/'.$file;
                        $file_list_html .= '<div class="file_item" data-file-name="'.htmlspecialchars($file, ENT_QUOTES).'">
                            <div class="file_item_name">
                                <i class="fa fa-file"></i>
                                <span title="'.$file_name.'">'.$file_name.'</span>
                            </div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="'.$file_url.'" download style="color: #0062a0; text-decoration: none;" target="_blank">
                                    <i class="fa fa-download"></i> 
                                </a>
                                <button type="button" class="btn_remove_file" data-file-name="'.htmlspecialchars($file, ENT_QUOTES).'" data-id="'.$r_tt['id'].'" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 4px 8px;" title="Xóa file">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>';
                    }
                }
                if(!empty($file_list_html)){
                    $file_list_existing = '<div style="margin-bottom: 16px;">
                        <label style="font-size: 14px; font-weight: 600; color: #2d3748; margin-bottom: 8px; display: block;">File hiện có:</label>
                        <div class="file_list_existing">'.$file_list_html.'</div>
                    </div>';
                }
                $r_tt['file_list_existing'] = $file_list_existing;
            }
            $list .= $skin->skin_replace('skin_members/box_action/edit_congviec_nhanvien', $r_tt);
            
        }
        return $list;
    }
    function list_lichsu_du_an($conn, $admin_cty, $user_id, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
        $i = $start;
        
        // Query tối ưu: Lấy thông tin dự án và người tạo luôn, tránh trùng lặp
        $thongtin = mysqli_query($conn, "
            SELECT DISTINCT 
                da.*
            FROM du_an as da
            WHERE da.trang_thai IN (3, 6)
            AND da.admin_cty = '$admin_cty'
            AND EXISTS (
                SELECT 1 
                FROM congviec_du_an cda
                WHERE cda.id_du_an = da.id
                AND (cda.id_nguoi_nhan = '$user_id' 
                     OR cda.id_nguoi_giao = '$user_id'
                     )
            )
            ORDER BY da.id DESC 
            LIMIT $start, $limit
        ");
        $total=mysqli_num_rows($thongtin);
    
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            
            // Dữ liệu đã lấy từ query chính, không cần query thêm
            $r_tt['ten_congviec'] = !empty($r_tt['ten_du_an']) ? $r_tt['ten_du_an'] : 'Không xác định';
            $r_tt['ngay_hoanthanh'] = !empty($r_tt['date_post']) ? date('d/m/Y H:i', $r_tt['date_post']) : '-';
            
            $r_tt['ten_nguoi_giao'] = 'Không xác định';
            if(!empty($r_tt['user_id'])){
                $thongtin_nguoi_giao = mysqli_query($conn, "SELECT name FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty' LIMIT 1");
                if(mysqli_num_rows($thongtin_nguoi_giao) > 0){
                    $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoi_giao);
                    $r_tt['ten_nguoi_giao'] = !empty($r_nguoi_giao['name']) ? $r_nguoi_giao['name'] : 'Không xác định';
                }
            }
            // Format mức độ ưu tiên
            $mucdo_uutien_original = $r_tt['mucdo_uutien'];
            if($r_tt['mucdo_uutien'] == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($r_tt['mucdo_uutien'] == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($r_tt['mucdo_uutien'] == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($r_tt['mucdo_uutien'] == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Khẩn cấp';
            } else {
                $r_tt['mucdo_uutien_text'] = $r_tt['mucdo_uutien'];
            }
            // Giữ giá trị gốc cho class
            $r_tt['mucdo_uutien'] = $mucdo_uutien_original;
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang thực hiện</span>';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_2">Chờ phê duyệt</span>';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_3">Miss Deadline</span>';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_4">Từ chối</span>';
                    break;
                case 5:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_5">Xin gia hạn</span>';
                    break;
                case 6:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_6">Hoàn thành</span>';
                    break;
                default:
                    $r_tt['trang_thai_text'] = '<span class="status_badge">Không xác định</span>';
                    break;
            }
            
            $list .= $skin->skin_replace('skin_members/box_action/tr_lichsu_du_an', $r_tt);
        }
        
        if($i == 0){
            $start = 0;
        } else {
            $start = $start + 1;
        }
        
        $info = array(
            'start' => $start,
            'end' => $i,
            'total' => $total,
            'list' => $list
        );
        return json_encode($info);
    }
    function phantrang($page, $total, $link) {
        if ($total <= 1) {
            return '';
        }
        
        $list = '';
        
        // Back luôn = 1, Next luôn = total
        $back = 1;
        $next = $total;
        
        if ($total <= 5) {
            // Hiển thị tất cả các trang
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $page) {
                    $list .= '<div class="li_phantrang active" page="' . $i . '">' . $i . '</div>';
                } else {
                    $list .= '<div class="li_phantrang" page="' . $i . '">' . $i . '</div>';
                }
            }
        } else {
            // Tổng > 5 trang
            if ($page <= 3) {
                // 3 trang đầu: hiển thị 1-5
                for ($i = 1; $i <= 5; $i++) {
                    if ($i == $page) {
                        $list .= '<div class="li_phantrang active" page="' . $i . '">' . $i . '</div>';
                    } else {
                        $list .= '<div class="li_phantrang" page="' . $i . '">' . $i . '</div>';
                    }
                }
            } else if ($page >= $total - 2) {
                // 3 trang cuối: hiển thị 5 trang cuối
                for ($i = $total - 4; $i <= $total; $i++) {
                    if ($i == $page) {
                        $list .= '<div class="li_phantrang active" page="' . $i . '">' . $i . '</div>';
                    } else {
                        $list .= '<div class="li_phantrang" page="' . $i . '">' . $i . '</div>';
                    }
                }
            } else {
                // Ở giữa: hiển thị 2 trang trước và sau
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        $list .= '<div class="li_phantrang active" page="' . $i . '">' . $i . '</div>';
                    } else {
                        $list .= '<div class="li_phantrang" page="' . $i . '">' . $i . '</div>';
                    }
                }
            }
        }
        
        return '<div class="li_phantrang" page="' . $back . '"><i class="fa fa-caret-left"></i></div>' . 
               $list . 
               '<div class="li_phantrang" page="' . $next . '"><i class="fa fa-caret-right"></i></div>';
    }
    function total_thongbao_chua_doc($conn, $user_id, $admin_cty){
        $sql = "
            SELECT COUNT(*) AS total
            FROM notification
            WHERE user_nhan = '$user_id'
            AND (
                doc IS NULL
                OR doc = ''
                OR FIND_IN_SET('$user_id', doc) = 0
            )
        ";
    
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($query);
    
        return (int)$row['total'];
    }
    function list_giaoviec_giaopho($conn, $admin_cty, $id,$user_id){
        
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE parent_id='$id' AND admin_cty='$admin_cty' AND id_nguoi_giao='$user_id' ORDER BY id DESC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            
            $i++;
            $r_tt['i'] = $i;
            $r_tt['id'] = $r_tt['id'];
            $r_tt['ten_congviec'] = !empty($r_tt['ten_congviec']) ? $r_tt['ten_congviec'] : 'Không xác định';
            
            // Xử lý trạng thái
            $trang_thai = isset($r_tt['trang_thai']) ? intval($r_tt['trang_thai']) : 0;
            $r_tt['trang_thai'] = $trang_thai;
            switch ($trang_thai) {
                case 0:
                    $r_tt['trang_thai_text'] = 'Chờ xử lý';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = 'Đang triển khai';
                    break;
                case 2:
                    $r_tt['trang_thai_text'] = 'Chờ phê duyệt';
                    break;
                case 3:
                    $r_tt['trang_thai_text'] = 'Miss Deadline';
                    break;
                case 4:
                    $r_tt['trang_thai_text'] = 'Từ chối';
                    break;
                case 5:
                    $r_tt['trang_thai_text'] = 'Xin gia hạn';
                    break;
                case 6:
                    $r_tt['trang_thai_text'] = 'Đã hoàn thành';
                    break;
                default:
                    $r_tt['trang_thai_text'] = 'Không xác định';
                    break;
            }
            
            // Xử lý mức độ ưu tiên
            $mucdo_uutien = isset($r_tt['mucdo_uutien']) ? $r_tt['mucdo_uutien'] : 'binh_thuong';
            $r_tt['mucdo_uutien'] = $mucdo_uutien;
            if($mucdo_uutien == 'thap'){
                $r_tt['mucdo_uutien_text'] = 'Thấp';
            }else if($mucdo_uutien == 'binh_thuong'){
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
            }else if($mucdo_uutien == 'cao'){
                $r_tt['mucdo_uutien_text'] = 'Cao';
            }else if($mucdo_uutien == 'rat_cao'){
                $r_tt['mucdo_uutien_text'] = 'Rất cao';
            }else{
                $r_tt['mucdo_uutien_text'] = 'Bình thường';
                $r_tt['mucdo_uutien'] = 'binh_thuong';
            }
            
            // Xử lý ngày hạn hoàn thành
            $r_tt['is_overdue_class'] = '';
            if(!empty($r_tt['han_hoanthanh'])){
                if(is_numeric($r_tt['han_hoanthanh'])){
                    $han_hoanthanh_timestamp = intval($r_tt['han_hoanthanh']);
                    $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', $han_hoanthanh_timestamp);
                    
                    // Kiểm tra quá hạn
                    $hientai = time();
                    if($han_hoanthanh_timestamp < $hientai && $trang_thai != 6){
                        $r_tt['is_overdue_class'] = 'overdue';
                    }
                } else {
                    $timestamp = strtotime($r_tt['han_hoanthanh']);
                    if($timestamp){
                        $r_tt['han_hoan_thanh'] = date('d/m/Y H:i', $timestamp);
                        $hientai = time();
                        if($timestamp < $hientai && $trang_thai != 6){
                            $r_tt['is_overdue_class'] = 'overdue';
                        }
                    } else {
                        $r_tt['han_hoan_thanh'] = '-';
                    }
                }
            } else {
                $r_tt['han_hoan_thanh'] = '-';
            }
            if($user_id == $r_tt['id_nguoi_giao']){
                $r_tt['hoat_dong'] = '<button class="btn_action btn_edit" name="edit_congviec_giaopho" title="Chỉnh sửa" data-id="'.$r_tt['id'].'">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="btn_action btn_delete" name="delete_congviec_giaopho" title="Xóa" data-id="'.$r_tt['id'].'">
                    <i class="fa fa-trash-o"></i>
                </button>';
            }else{
                $r_tt['hoat_dong'] = '';
            }
            $list .= $skin->skin_replace('skin_members/box_action/tr_giaoviec_giaopho', $r_tt);
        }
        return $list;
    }

    // ========== CÁC HÀM THỐNG KÊ DỰ ÁN ==========
    
   
 
    function thongke_tongquan_du_an($conn,$user_id, $admin_cty, $tu_ngay_ts=0, $den_ngay_ts=0) {
    
        $data = [];
        $where = "admin_cty='$admin_cty'";
        if($tu_ngay_ts > 0){
            $where .= " AND date_post >= $tu_ngay_ts";
        }
        if($den_ngay_ts > 0){
            $where .= " AND date_post <= $den_ngay_ts";
        }
        
        $thongtin_giao = mysqli_query($conn, "SELECT COUNT(*) as total FROM du_an WHERE $where AND user_id='$user_id'");
        $data['tong_du_an_giao'] = mysqli_fetch_assoc($thongtin_giao)['total'];
 
        $trang_thai_data = array_fill_keys(['0','1','2','3','4','5','6'], 0);
        $result = mysqli_query($conn, "SELECT trang_thai, COUNT(*) as so_luong FROM du_an 
            WHERE $where AND user_id='$user_id' GROUP BY trang_thai");
        while($row = mysqli_fetch_assoc($result)) {
            $trang_thai_data[$row['trang_thai']] = $row['so_luong'];
        }
        $data['trangthai_cho_xuly'] = $trang_thai_data['0'];
        $data['trangthai_dang_thuchien'] = $trang_thai_data['1'];
        $data['trangthai_cho_pheduyet'] = $trang_thai_data['2'];
        $data['trangthai_miss_deadline'] = $trang_thai_data['3'];
        $data['trangthai_tuchoi'] = $trang_thai_data['4'];
        $data['trangthai_xin_giahan'] = $trang_thai_data['5'];
        $data['trangthai_da_hoanthanh'] = $trang_thai_data['6'];
        
        // Tổng số công việc
        $thongtin_giao = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an WHERE $where AND id_nguoi_giao='$user_id'");
        $data['tong_congviec_giao'] = mysqli_fetch_assoc($thongtin_giao)['total'];
        $thongtin_nhan = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an WHERE $where AND id_nguoi_nhan='$user_id'");
        $data['tong_congviec_nhan'] = mysqli_fetch_assoc($thongtin_nhan)['total'];

        // Số công việc theo trạng thái
        $trang_thai_cv_data = array_fill_keys(['0','1','2','4','5','6'], 0);
        $result = mysqli_query($conn, "SELECT trang_thai, COUNT(*) as so_luong FROM congviec_du_an 
            WHERE $where AND id_nguoi_nhan='$user_id' GROUP BY trang_thai");
        while($row = mysqli_fetch_assoc($result)) {
            $trang_thai_cv_data[$row['trang_thai']] = $row['so_luong'];
        }
        $data['cv_cho_xuly'] = $trang_thai_cv_data['0'];
        $data['cv_dang_thuchien'] = $trang_thai_cv_data['1'];
        $data['cv_cho_duyet'] = $trang_thai_cv_data['2'];
        $data['cv_tuchoi'] = $trang_thai_cv_data['4'];
        $data['cv_xin_giahan'] = $trang_thai_cv_data['5'];
        $data['cv_da_hoanthanh'] = $trang_thai_cv_data['6'];
        
        $thongtin_qua_han = mysqli_query($conn, "SELECT COUNT(*) as total FROM congviec_du_an WHERE $where AND miss_deadline='1'");
        $data['cv_miss_deadline'] = mysqli_fetch_assoc($thongtin_qua_han)['total'];

        return $data;
    }

    function thongke_thang_du_an($conn,$user_id, $admin_cty, $nam) {
        $data_thang_tao_du_an = $data_thang_hoanthanh_du_an = $data_thang_tao_congviec = $data_thang_nhanviec_congviec = $data_thang_hoanthanh_congviec = [];
        for($i = 1; $i <= 12; $i++) {
            $start = mktime(0, 0, 0, $i, 1, $nam);
            $end = mktime(23, 59, 59, $i, date('t', $start), $nam);
            
            $data_thang_tao_du_an[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM du_an 
                WHERE admin_cty='$admin_cty' AND date_post BETWEEN $start AND $end"))['total'];
            
            $data_thang_hoanthanh_du_an[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM du_an 
                WHERE admin_cty='$admin_cty' AND trang_thai = 6 AND update_post BETWEEN $start AND $end"))['total'];

            $data_thang_tao_congviec[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM congviec_du_an 
                WHERE admin_cty='$admin_cty' AND id_nguoi_giao='$user_id' AND date_post BETWEEN $start AND $end"))['total'];
            
            $data_thang_nhanviec_congviec[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM congviec_du_an 
                WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND date_post BETWEEN $start AND $end"))['total'];
            
            $data_thang_hoanthanh_congviec[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM congviec_du_an 
                WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND trang_thai = 6 AND update_post BETWEEN $start AND $end"))['total'];
        }
        return [
            'data_thang_tao_du_an' => implode(',', $data_thang_tao_du_an),
            'data_thang_hoanthanh_du_an' => implode(',', $data_thang_hoanthanh_du_an),
            'data_thang_tao_congviec' => implode(',', $data_thang_tao_congviec),
            'data_thang_nhanviec_congviec' => implode(',', $data_thang_nhanviec_congviec),
            'data_thang_hoanthanh_congviec' => implode(',', $data_thang_hoanthanh_congviec)
        ];
    }
    


    // ========== CÁC HÀM THỐNG KÊ CÔNG VIỆC TRỰC TIẾP =========
    
   
    function thongke_tongquan_congviec($conn, $user_id, $admin_cty, $tu_ngay_ts = 0, $den_ngay_ts = 0) {
        $data = [];

        $where = "admin_cty='$admin_cty'";
        if($tu_ngay_ts > 0){
            $where .= " AND date_post >= $tu_ngay_ts";
        }
        if($den_ngay_ts > 0){
            $where .= " AND date_post <= $den_ngay_ts";
        }
        
        $thongtin_giao = mysqli_query($conn, "SELECT COUNT(*) as total FROM giaoviec_tructiep WHERE $where AND id_nguoi_giao='$user_id'");
        $data['tong_congviec_giao'] = mysqli_fetch_assoc($thongtin_giao)['total'];
        $thongtin_nhan = mysqli_query($conn, "SELECT COUNT(*) as total FROM giaoviec_tructiep WHERE $where AND id_nguoi_nhan='$user_id'");
        $data['tong_congviec_nhan'] = mysqli_fetch_assoc($thongtin_nhan)['total'];
        
        $trang_thai_data = array_fill_keys(['0','1','2','4','5','6'], 0);
        $result = mysqli_query($conn, "SELECT trang_thai, COUNT(*) as so_luong FROM giaoviec_tructiep 
            WHERE $where AND id_nguoi_nhan='$user_id' GROUP BY trang_thai");
        while($row = mysqli_fetch_assoc($result)) {
            $trang_thai_data[$row['trang_thai']] = $row['so_luong'];
        }
        $data['trangthai_cho_xuly'] = $trang_thai_data['0'];
        $data['trangthai_dang_thuchien'] = $trang_thai_data['1'];
        $data['trangthai_cho_duyet'] = $trang_thai_data['2'];
        $data['trangthai_tuchoi'] = $trang_thai_data['4'];
        $data['trangthai_xin_giahan'] = $trang_thai_data['5'];
        $data['trangthai_da_hoanthanh'] = $trang_thai_data['6'];
        
        $thongtin_qua_han = mysqli_query($conn, "SELECT COUNT(*) as total FROM giaoviec_tructiep WHERE $where AND id_nguoi_nhan='$user_id' AND miss_deadline='1'");
        $data['trangthai_miss_deadline'] = mysqli_fetch_assoc($thongtin_qua_han)['total'];

       
        return $data;
    }



    function thongke_thang_congviec($conn, $user_id, $admin_cty, $nam_thang) {
        $data_thang_nhanviec = $data_thang_tao = $data_thang_hoanthanh = [];
        for($i = 1; $i <= 12; $i++) {
            $start = mktime(0, 0, 0, $i, 1, $nam_thang);
            $end = mktime(23, 59, 59, $i, date('t', $start), $nam_thang);

            $data_thang_tao[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM giaoviec_tructiep 
                WHERE admin_cty='$admin_cty' AND id_nguoi_giao='$user_id' AND date_post BETWEEN $start AND $end"))['total'];

            $data_thang_nhanviec[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM giaoviec_tructiep 
                WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND date_post BETWEEN $start AND $end"))['total'];
            
            $data_thang_hoanthanh[] = mysqli_fetch_assoc(mysqli_query($conn, 
                "SELECT COUNT(*) as total FROM giaoviec_tructiep 
                WHERE admin_cty='$admin_cty' AND id_nguoi_nhan='$user_id' AND trang_thai = 6 AND update_post BETWEEN $start AND $end"))['total'];
        }
        return [
            'data_thang_tao' => implode(',', $data_thang_tao),
            'data_thang_nhanviec' => implode(',', $data_thang_nhanviec),
            'data_thang_hoanthanh' => implode(',', $data_thang_hoanthanh)
        ];
    }

    function thongke_tongquan_congviec_theo_du_an($conn, $admin_cty, $id_du_an) {
        $id_du_an = intval($id_du_an);
        $admin_esc = mysqli_real_escape_string($conn, (string) $admin_cty);
        $where = "admin_cty='$admin_esc' AND id_du_an='$id_du_an'";

        $data = [];
        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM congviec_du_an WHERE $where"));
        $data['tong_congviec_du_an'] = (int) ($row['total'] ?? 0);

        $trang_thai_data = array_fill_keys(['0', '1', '2', '4', '5', '6'], 0);
        $result = mysqli_query($conn, "SELECT trang_thai, COUNT(*) AS so_luong FROM congviec_du_an WHERE $where GROUP BY trang_thai");
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $k = (string) $row['trang_thai'];
                if (array_key_exists($k, $trang_thai_data)) {
                    $trang_thai_data[$k] = (int) $row['so_luong'];
                }
            }
        }
        $data['trangthai_cho_xuly'] = $trang_thai_data['0'];
        $data['trangthai_dang_thuchien'] = $trang_thai_data['1'];
        $data['trangthai_cho_duyet'] = $trang_thai_data['2'];
        $data['trangthai_tuchoi'] = $trang_thai_data['4'];
        $data['trangthai_xin_giahan'] = $trang_thai_data['5'];
        $data['trangthai_da_hoanthanh'] = $trang_thai_data['6'];

        $qh = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM congviec_du_an WHERE $where AND miss_deadline='1'"));
        $data['trangthai_miss_deadline'] = (int) ($qh['total'] ?? 0);

        return $data;
    }

    function list_thongke_nhanvien_du_an($conn, $admin_cty, $id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id' AND admin_cty='$admin_cty' GROUP BY id_nguoi_nhan");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $thongtin_nguoi_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
            $r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nguoi_nhan);
            $r_tt['ten_nhanvien'] = $r_nguoi_nhan['name'] ?? '';
            $phong_ban_nhan = $r_nguoi_nhan['phong_ban'] ?? '';
            $thongtin_phongban_nhan = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$phong_ban_nhan' AND admin_cty='$admin_cty'");
            $r_phongban_nhan = mysqli_fetch_assoc($thongtin_phongban_nhan);
            $r_tt['ten_phongban_nhan'] = $r_phongban_nhan['tieu_de'] ?? '';
            $id_du_an = intval($id);
            $id_nguoi_nhan = intval($r_tt['id_nguoi_nhan']);
            $thongke = mysqli_query($conn, "SELECT 
                COUNT(*) AS so_congviec,
                SUM(CASE WHEN trang_thai = 0 THEN 1 ELSE 0 END) AS so_congviec_cho_xuly,
                SUM(CASE WHEN (trang_thai = 1 or trang_thai = 2 or trang_thai = 5 or trang_thai = 4) THEN 1 ELSE 0 END) AS so_congviec_dang_thuchien,
                SUM(CASE WHEN trang_thai = 6 THEN 1 ELSE 0 END) AS so_congviec_da_hoanthanh,
                SUM(CASE WHEN miss_deadline = 1 THEN 1 ELSE 0 END) AS so_congviec_quahangthanh,
                AVG(CAST(phantram_hoanthanh AS DECIMAL(10,2))) AS tien_do_tb
                FROM congviec_du_an 
                WHERE id_du_an='$id_du_an' AND admin_cty='$admin_cty' AND id_nguoi_nhan='$id_nguoi_nhan'");
            $r_thongke = mysqli_fetch_assoc($thongke) ?: [];
            $r_tt['so_congviec'] = (int) ($r_thongke['so_congviec'] ?? 0);
            $r_tt['so_congviec_cho_xuly'] = (int) ($r_thongke['so_congviec_cho_xuly'] ?? 0);
            $r_tt['so_congviec_dang_thuchien'] = (int) ($r_thongke['so_congviec_dang_thuchien'] ?? 0);
            $r_tt['so_congviec_da_hoanthanh'] = (int) ($r_thongke['so_congviec_da_hoanthanh'] ?? 0);
            $r_tt['so_congviec_quahangthanh'] = (int) ($r_thongke['so_congviec_quahangthanh'] ?? 0);
            $tb = $r_thongke['tien_do_tb'] ?? null;
            $r_tt['tien_do_hoanthanh'] = ($tb !== null && $tb !== '') ? (string) round((float) $tb, 1) . '%' : '0%';

            $list .= $skin->skin_replace('skin_members/box_action/tr_thongke_nhanvien_duan', $r_tt);
            
        }
        return $list;
    }   
    function list_thongke_congviec_quahan($conn, $admin_cty, $id){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $thongtin = mysqli_query($conn, "SELECT * FROM congviec_du_an WHERE id_du_an='$id' AND admin_cty='$admin_cty' AND miss_deadline='1'");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['ten_congviec'] = $r_tt['ten_congviec'];
            $thongtin_nguoigiao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_giao']}' AND admin_cty='$admin_cty'");
            $r_nguoi_giao = mysqli_fetch_assoc($thongtin_nguoigiao);
            $r_tt['ten_nguoi_giao'] = $r_nguoi_giao['name'];
            $phong_ban_giao = $r_nguoi_giao['phong_ban'];
            $thongtin_phongban_giao = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$phong_ban_giao' AND admin_cty='$admin_cty'");
            $r_phongban_giao = mysqli_fetch_assoc($thongtin_phongban_giao);
            $r_tt['ten_phongban_giao'] = $r_phongban_giao['tieu_de'];
            $thongtin_nhan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['id_nguoi_nhan']}' AND admin_cty='$admin_cty'");
            $r_nguoi_nhan = mysqli_fetch_assoc($thongtin_nhan);
            $r_tt['ten_nguoi_nhan'] = $r_nguoi_nhan['name'];
            $phong_ban_nhan = $r_nguoi_nhan['phong_ban'];
            $thongtin_phongban_nhan = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='$phong_ban_nhan' AND admin_cty='$admin_cty'");
            $r_phongban_nhan = mysqli_fetch_assoc($thongtin_phongban_nhan);
            $r_tt['ten_phongban_nhan'] = $r_phongban_nhan['tieu_de']; 
            $r_tt['han_hoanthanh'] = date('d/m/Y H:i', strtotime($r_tt['han_hoanthanh']));
            $list .= $skin->skin_replace('skin_members/box_action/tr_thongke_congviec_quahan', $r_tt);
        }
        return $list;
    }   
}
