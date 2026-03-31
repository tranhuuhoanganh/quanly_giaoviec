<?php
class class_giaoviec extends class_manage {
    function list_option_phan_cap($conn, $admin_cty){
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM phong_ban WHERE admin_cty='$admin_cty' ORDER BY id ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
		}
		return '<option value="">Chọn phân cấp nhân sự</option>'. $list;
    }
    function list_option_edit_phan_cap($conn, $parent_id, $admin_cty){
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM phong_ban WHERE admin_cty='$admin_cty' ORDER BY id ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            
            if ($r_tt['id'] == $parent_id) {
                $list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
            } else {
                $list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
            }
		}
		return '<option value="">Chọn phân cấp nhân sự</option>'. $list;
    }
    
    function list_phongban($conn, $admin_cty){
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        
        // Lấy tất cả dữ liệu
        $thongtin = mysqli_query($conn, "SELECT * FROM phong_ban WHERE admin_cty='$admin_cty' ORDER BY id ASC");
        $items = array();
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $items[$r_tt['id']] = $r_tt;
        }
        
        // Xây dựng cây phân cấp
        $tree = $this->build_tree($items, 0, $skin, $conn, $admin_cty);
        return $tree;
    }
    
    function build_tree($items, $parent_id = 0, $skin, $conn, $admin_cty, $level = 0) {
        $html = '';
        foreach ($items as $item) {
            // So sánh parent_id (có thể là string hoặc int)
            if ((int)$item['parent_id'] == (int)$parent_id) {
                $item['title'] = $item['tieu_de'];
                $item['level'] = $level;
                $item['id'] = $item['id'];
                $item['parent_id'] = $item['parent_id'];
                
                // Đếm số user trong phòng ban này
                $children_count = $this->count_direct_children($conn, $item['id'], $admin_cty);
                $item['children_count'] = $children_count;
               
                // Render node
                $html .= $skin->skin_replace('skin_cpanel/box_action/list_phongban', $item);
                
                // Render children
                $children_html = $this->build_tree($items, $item['id'], $skin, $conn, $admin_cty, $level + 1);
                if ($children_html) {
                    $html .= '<div class="hierarchy-children">' . $children_html . '</div>';
                }
            }
        }
        return $html;
    }
    
    function count_direct_children($conn, $phong_ban_id, $admin_cty) {
        $phong_ban_id = intval($phong_ban_id);
        $thongtin = mysqli_query($conn, "SELECT COUNT(*) as total FROM user_info WHERE phong_ban='$phong_ban_id' AND admin_cty='$admin_cty'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        return isset($r_tt['total']) ? (int)$r_tt['total'] : 0;
    }
    
	function list_user($conn, $id_phongban, $admin_cty, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE phong_ban='$id_phongban' AND admin_cty='$admin_cty' ORDER BY user_id DESC LIMIT $limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			
			// Kiểm tra trạng thái hợp đồng
			if(!empty($r_tt['time_hopdong'])) {
				$time_hopdong_timestamp = strtotime($r_tt['time_hopdong']);
				$current_timestamp = time();
				
				if($time_hopdong_timestamp >= $current_timestamp) {
					$r_tt['time_hopdong'] = date('d/m/Y', $time_hopdong_timestamp) . ' - <span style="color: green;">Còn hợp đồng</span>';
				} else {
					$r_tt['time_hopdong'] = date('d/m/Y', $time_hopdong_timestamp) . ' - <span style="color: red;">Hết hợp đồng</span>';
				}
			} else {
				$r_tt['time_hopdong'] = 'Chưa có hợp đồng';
			}
            if($r_tt['active'] == 1){
                $r_tt['hoat_dong'] = '<button class="box_pop_list_user_btn delete" name="dung_hoat_dong_user" data-user_id="'.$r_tt['user_id'].'" title="Dừng hoạt động">
                <i class="fa fa-trash"></i> Dừng hoạt động
            </button>';
            } else {
                $r_tt['hoat_dong'] = '<button class="box_pop_list_user_btn active" name="kich_hoat_user" data-user_id="'.$r_tt['user_id'].'" title="Kích hoạt">
                <i class="fa fa-check"></i> Kích hoạt
            </button>';
            }

			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_user', $r_tt);
		}
		return $list;
	}
	
	function delete_phongban_recursive($conn, $parent_id) {
		$thongtin = mysqli_query($conn, "SELECT id FROM phong_ban WHERE parent_id='$parent_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$child_id = intval($r_tt['id']);
			$this->delete_phongban_recursive($conn, $child_id);
			mysqli_query($conn, "UPDATE user_info SET active=0 WHERE phong_ban='$child_id'");
			mysqli_query($conn, "DELETE FROM phong_ban WHERE id='$child_id'");
		}
	}   
	
	function delete_phongban($conn, $id) {
		$id = intval($id);
		$this->delete_phongban_recursive($conn, $id);
		mysqli_query($conn, "UPDATE user_info SET active=0 WHERE phong_ban='$id'");
		mysqli_query($conn, "DELETE FROM phong_ban WHERE id='$id'");
		
		return true;
	}
    function list_thongke_congviec($conn, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' ORDER BY id DESC LIMIT $start,$limit");
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
            $list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_giaoviec', $r_tt);
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
    function list_thongke_du_an($conn, $admin_cty, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $start = $page * $limit - $limit;
		$i = $start;
        $thongtin = mysqli_query($conn, "SELECT * FROM du_an WHERE admin_cty='$admin_cty' ORDER BY id DESC LIMIT $start,$limit");
		$total=mysqli_num_rows($thongtin);

        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            
            // Lấy thông tin người tạo dự án
            $thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty'");
            if(mysqli_num_rows($thongtin_nguoi_tao) > 0){
                $r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
                $r_tt['ten_nguoi_tao'] = !empty($r_nguoi_tao['name']) ? $r_nguoi_tao['name'] : 'Không xác định';
                if(!empty($r_nguoi_tao['phong_ban'])){
                    $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_tao['phong_ban']}' AND admin_cty='$admin_cty'");
                    if(mysqli_num_rows($thongtin_phongban) > 0){
                        $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
                        $r_tt['ten_phongban'] = !empty($r_phongban['tieu_de']) ? $r_phongban['tieu_de'] : '';
                    } else {
                        $r_tt['ten_phongban'] = '';
                    }
                } else {
                    $r_tt['ten_phongban'] = '';
                }
            } else {
                $r_tt['ten_nguoi_tao'] = 'Không xác định';
                $r_tt['ten_phongban'] = '';
            }
            
            $r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y', $r_tt['date_post']) : '-';

            $trang_thai_num = $r_tt['trang_thai'];
            
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang triển khai</span>';
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
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

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
            
            $list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_du_an', $r_tt);
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
    function list_option_nguoi_tao($conn, $admin_cty){
        $check = $this->load('class_check');
        $thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE admin_cty='$admin_cty' ORDER BY user_id ASC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $list .= '<option value="' . $r_tt['user_id'] . '">' . $r_tt['name'] . '</option>';
        }
        return '<option value="">Tất cả</option>'. $list;
    }
    function list_search_giaoviec($conn, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_tao_tu, $search_ngay_tao_den, $search_ngay_hoanthanh_tu, $search_ngay_hoanthanh_den, $search_nguoi_tao, $search_nguoi_nhan, $page, $limit){
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

        if(!empty($search_ngay_tao_tu)){
            $tu = strtotime($search_ngay_tao_tu . ' 00:00:00');
            if($tu !== false){
                $where .= " AND date_post >= $tu";
            }
        }

        if(!empty($search_ngay_tao_den)){
            $den = strtotime($search_ngay_tao_den . ' 23:59:59');
            if($den !== false){
                $where .= " AND date_post <= $den";
            }
        }

        if(!empty($search_ngay_hoanthanh_tu)){
            $tu = strtotime($search_ngay_hoanthanh_tu . ' 00:00:00');
            if($tu !== false){
                $where .= " AND han_hoanthanh >= $tu";
            }
        }

        if(!empty($search_ngay_hoanthanh_den)){
            $den = strtotime($search_ngay_hoanthanh_den . ' 23:59:59');
            if($den !== false){
                $where .= " AND han_hoanthanh <= $den";
            }
        }
        if(!empty($search_nguoi_tao)){
            $where .= " AND id_nguoi_giao='$search_nguoi_tao'";
        }
        if(!empty($search_nguoi_nhan)){
            $where .= " AND id_nguoi_nhan='$search_nguoi_nhan'";
        }
        $thongtin = mysqli_query($conn, "SELECT * FROM giaoviec_tructiep WHERE admin_cty='$admin_cty' $where ORDER BY id DESC LIMIT $limit");
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
            $list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_giaoviec', $r_tt);
        }
        return $list;
    }
    function list_search_du_an($conn, $admin_cty, $search_keyword, $search_trang_thai, $search_ngay_tao_tu, $search_ngay_tao_den, $search_ngay_hoanthanh_tu, $search_ngay_hoanthanh_den, $search_nguoi_tao, $search_nguoi_nhan, $page, $limit){
        $check = $this->load('class_check');
        $skin = $this->load('class_skin_cpanel');
        $list = '';
        $i = 0;
        $where = "";
    
        if($search_keyword != ''){
            $where .= " AND du_an.ten_du_an LIKE '%$search_keyword%'";
        }
        if($search_trang_thai != ''){
            $where .= " AND du_an.trang_thai='$search_trang_thai'";
        }
        if(!empty($search_ngay_tao_tu)){
            $tu = strtotime($search_ngay_tao_tu . ' 00:00:00');
            if($tu !== false){
                $where .= " AND du_an.date_post >= $tu";
            }
        }

        if(!empty($search_ngay_tao_den)){
            $den = strtotime($search_ngay_tao_den . ' 23:59:59');
            if($den !== false){
                $where .= " AND du_an.date_post <= $den";
            }
        }

        if(!empty($search_ngay_hoanthanh_tu)){
            $tu = strtotime($search_ngay_hoanthanh_tu . ' 00:00:00');
            if($tu !== false){
                $where .= " AND congviec_du_an.han_hoanthanh >= $tu";
            }
        }

        if(!empty($search_ngay_hoanthanh_den)){
            $den = strtotime($search_ngay_hoanthanh_den . ' 23:59:59');
            if($den !== false){
                $where .= " AND congviec_du_an.han_hoanthanh <= $den";
            }
        }
        if(!empty($search_nguoi_tao)){
            $where .= " AND du_an.user_id='$search_nguoi_tao'";
        }
        if(!empty($search_nguoi_nhan)){
            $where .= " AND congviec_du_an.id_nguoi_nhan='$search_nguoi_nhan'";
        }
        $thongtin = mysqli_query($conn, "SELECT du_an.*, congviec_du_an.id_nguoi_nhan, congviec_du_an.han_hoanthanh FROM du_an INNER JOIN congviec_du_an on du_an.id = congviec_du_an.id_du_an WHERE du_an.admin_cty='$admin_cty' $where GROUP BY du_an.id ORDER BY du_an.id DESC LIMIT $limit");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            
            // Lấy thông tin người tạo dự án
            $thongtin_nguoi_tao = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}' AND admin_cty='$admin_cty'");
            if(mysqli_num_rows($thongtin_nguoi_tao) > 0){
                $r_nguoi_tao = mysqli_fetch_assoc($thongtin_nguoi_tao);
                $r_tt['ten_nguoi_tao'] = !empty($r_nguoi_tao['name']) ? $r_nguoi_tao['name'] : 'Không xác định';
                if(!empty($r_nguoi_tao['phong_ban'])){
                    $thongtin_phongban = mysqli_query($conn, "SELECT * FROM phong_ban WHERE id='{$r_nguoi_tao['phong_ban']}' AND admin_cty='$admin_cty'");
                    if(mysqli_num_rows($thongtin_phongban) > 0){
                        $r_phongban = mysqli_fetch_assoc($thongtin_phongban);
                        $r_tt['ten_phongban'] = !empty($r_phongban['tieu_de']) ? $r_phongban['tieu_de'] : '';
                    } else {
                        $r_tt['ten_phongban'] = '';
                    }
                } else {
                    $r_tt['ten_phongban'] = '';
                }
            } else {
                $r_tt['ten_nguoi_tao'] = 'Không xác định';
                $r_tt['ten_phongban'] = '';
            }
            
            $r_tt['ngay_tao'] = !empty($r_tt['date_post']) ? date('d/m/Y', $r_tt['date_post']) : '-';

            $trang_thai_num = $r_tt['trang_thai'];
            
            switch ($r_tt['trang_thai']) {
                case 0:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_0">Chờ xử lý</span>';
                    break;
                case 1:
                    $r_tt['trang_thai_text'] = '<span class="status_badge status_1">Đang triển khai</span>';
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
            // Giữ giá trị số cho class
            $r_tt['trang_thai'] = $trang_thai_num;

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
            $list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_du_an', $r_tt);
        }
        return $list;
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
}
?>