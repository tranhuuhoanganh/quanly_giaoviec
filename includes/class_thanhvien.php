 <?php
	class class_thanhvien extends class_manage
	{

		function sap_xep_theo_stt_va_time($a, $b)
		{
			if ($a['stt'] == $b['stt']) {
				return $a['time'] - $b['time'];
			}
			return $a['stt'] - $b['stt'];
		}
		///////////////////
		function list_menu($conn, $page, $limit)
		{
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_menu', $r_tt);
			}
			return $list;
		}
		function list_otp($conn, $total, $page, $limit)
		{
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_otp', $r_tt);
			}
			return $list;
		}
		function creat_random($conn, $loai)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			if ($loai == 'phien_traodoi') {
				$string = $check->random_string(6);
				$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM chat WHERE phien='$string'");
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ($r_tt['total'] > 0) {
					$this->creat_random($conn, $loai);
				} else {
					return $string;
				}
			} else if ($loai == 'ma_booking') {
				$string = $check->random_string(6);
				$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM booking WHERE ma_booking='$string'");
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ($r_tt['total'] > 0) {
					$this->creat_random($conn, $loai);
				} else {
					return $string;
				}
			}
		}
		///////////////////
		function list_option_hangtau($conn, $id)
		{
			$skin = $this->load('class_skin');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT lh.*,pk.phi FROM list_hangtau lh LEFT JOIN phi_kethop pk ON lh.viet_tat=pk.hang_tau ORDER BY lh.tieu_de ASC");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				if ($r_tt['id'] == $id) {
					$list .= '<option value="' . $r_tt['id'] . '" phi="' . $r_tt['phi'] . '" selected>' . $r_tt['tieu_de'] . '(' . $r_tt['viet_tat'] . ')</option>';
				} else {
					$list .= '<option value="' . $r_tt['id'] . '" phi="' . $r_tt['phi'] . '">' . $r_tt['tieu_de'] . '(' . $r_tt['viet_tat'] . ')</option>';
				}
			}
			return $list;
		}
		///////////////////
		function list_goiy_hangtau($conn, $id)
		{
			$skin = $this->load('class_skin');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT lh.*,pk.phi FROM list_hangtau lh LEFT JOIN phi_kethop pk ON lh.viet_tat=pk.hang_tau ORDER BY lh.tieu_de ASC");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				if ($r_tt['id'] == $id) {
					$list .= '<div class="li_goiy goiy_hangtau selected" value="' . $r_tt['id'] . '" viet_tat="' . $r_tt['viet_tat'] . '" phi="' . $r_tt['phi'] . '">' . $r_tt['tieu_de'] . '(' . $r_tt['viet_tat'] . ')</div>';
				} else {
					$list .= '<div class="li_goiy goiy_hangtau" value="' . $r_tt['id'] . '" viet_tat="' . $r_tt['viet_tat'] . '" phi="' . $r_tt['phi'] . '">' . $r_tt['tieu_de'] . '(' . $r_tt['viet_tat'] . ')</div>';
				}
			}
			return $list;
		}
		///////////////////
		function list_option_container($conn, $id)
		{
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
		function list_option_cang($conn, $id)
		{
			$skin = $this->load('class_skin');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT * FROM list_cang ORDER BY thu_tu ASC");
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
		function list_option_tinh($conn, $id)
		{
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
		function list_goiy_tinh($conn, $id)
		{
			$skin = $this->load('class_skin');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				if ($r_tt['id'] == $id) {
					$list .= '<div class="li_goiy goiy_tinh selected" value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				} else {
					$list .= '<div class="li_goiy goiy_tinh" value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</div>';
				}
			}
			return $list;
		}
		///////////////////
		function list_option_huyen($conn, $tinh, $id)
		{
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
		function list_option_xa($conn, $huyen, $id)
		{
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
		////////////////////
		function list_naptien_member($conn, $user_id, $page, $limit)
		{
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
					$r_tt['hanhdong'] = '<button class="bg_red" name="huy_naptien" id="{id}"><i class="fa fa-trash-o"></i> Hủy</button>';
				}
				$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_naptien', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_chitieu_member($conn, $user_id, $page, $limit)
		{
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
				if ($r_tt['truoc'] == 0 and $r_tt['sau'] == 0) {
					$r_tt['truoc'] = 'Không xác định';
					$r_tt['sau'] = 'Không xác định';
				} else {
					$r_tt['truoc'] = number_format($r_tt['truoc']);
					$r_tt['sau'] = number_format($r_tt['sau']);
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_chitieu', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_ruttien_member($conn, $user_id, $page, $limit)
		{
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_ruttien', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_dangky_hotro($conn, $total, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $total - $start + 1;
			$thongtin = mysqli_query($conn, "SELECT * FROM pop_hotro LEFT JOIN user_info ON pop_hotro.user_id=user_info.user_id ORDER BY pop_hotro.id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i--;
				$r_tt['i'] = $i;
				$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
				if ($r_tt['thoi_gian'] == '') {
					$r_tt['thoi_gian'] = 'Không nhận hỗ trợ';
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_dangky_hotro', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_naptien($conn, $user_id, $total, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			if ($total > 0) {
				$i = $total - $start + 1;
				$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username,user_info.mobile FROM naptien LEFT JOIN user_info ON user_info.user_id=naptien.user_id WHERE naptien.user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$i--;
					$r_tt['i'] = $i;
					$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
					$r_tt['sotien'] = number_format($r_tt['sotien']);
					if ($r_tt['status'] == 1) {
						$r_tt['status'] = 'Hoàn thành';
						$r_tt['hanhdong'] = '<a href="/members/view-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%">Chi tiết</button></a>';
					} else if ($r_tt['status'] == 3) {
						$r_tt['status'] = 'Chờ xác nhận';
						$r_tt['hanhdong'] = '<a href="/members/view-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%">Chi tiết</button></a>';
					} else if ($r_tt['status'] == 2) {
						$r_tt['status'] = 'Đã hủy';
						$r_tt['hanhdong'] = '<a href="/members/view-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%">Chi tiết</button></a>';
					} else {
						$r_tt['status'] = 'Chờ xử lý';
						$r_tt['hanhdong'] = '<a href="/members/view-naptien?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%">Chi tiết</button></a><button class="bg_red b_mobile" name="huy_naptien" id="' . $r_tt['id'] . '" style="width:100%"><i class="fa fa-trash-o"></i> Hủy</button>';
					}
					$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
					$list .= $skin->skin_replace('skin_members/box_action/tr_naptien', $r_tt);
				}
				return $list;
			} else {
				return '';
			}
		}
		////////////////////
		function list_chitieu($conn, $user_id, $total, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $total - $start + 1;
			$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username,user_info.mobile FROM lichsu_chitieu LEFT JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id WHERE lichsu_chitieu.user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
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
				if ($r_tt['truoc'] == 0 and $r_tt['sau'] == 0) {
					$r_tt['truoc'] = '';
					$r_tt['sau'] = '';
				} else {
					$r_tt['truoc'] = number_format($r_tt['truoc']);
					$r_tt['sau'] = number_format($r_tt['sau']);
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_chitieu', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_ruttien($conn, $total, $page, $limit)
		{
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_ruttien', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_danhgia($conn, $user_id, $name, $dien_thoai, $avatar, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT list_rate.*,user_info.cong_ty FROM list_rate LEFT JOIN user_info ON list_rate.user_to=user_info.user_id WHERE list_rate.user_id='$user_id' ORDER BY list_rate.update_post DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$i++;
				$r_tt['i'] = $i;
				if ($r_tt['update_post'] > $r_tt['date_post']) {
					$r_tt['text_rate'] = 'Chỉnh sửa lúc';
				} else {
					$r_tt['text_rate'] = 'Đánh giá lúc';
				}
				$con = 5 - $r_tt['rate'];
				for ($i = 1; $i <= $r_tt['rate']; $i++) {
					$list_star .= '<i class="fa fa-star"></i>';
				}
				for ($i = 1; $i <= $con; $i++) {
					$list_star_o .= '<i class="fa fa-star-o"></i>';
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['ten_hangtau'] = $r_booking['ten_hangtau'];
				$r_tt['ten_loai_container'] = $r_booking['ten_loai_container'];
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['name'] = $name;
				$r_tt['avatar'] = $avatar;
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['mobile'] = substr($dien_thoai, 0, -3) . '***';
				$r_tt['list_star'] = $list_star . '' . $list_star_o;
				unset($list_star);
				unset($list_star_o);
				$r_tt['update_post'] = date('H:i d/m/Y', $r_tt['update_post']);
				$list .= $skin->skin_replace('skin_members/box_action/li_rate', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_danhgia_khach($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT list_rate.*,user_info.name,user_info.mobile,user_info.avatar,user_info.cong_ty FROM list_rate LEFT JOIN user_info ON list_rate.user_id=user_info.user_id WHERE list_rate.user_to='$user_id' ORDER BY list_rate.update_post DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$i++;
				$r_tt['i'] = $i;
				if ($r_tt['update_post'] > $r_tt['date_post']) {
					$r_tt['text_rate'] = 'Chỉnh sửa lúc';
				} else {
					$r_tt['text_rate'] = 'Đánh giá lúc';
				}
				$con = 5 - $r_tt['rate'];
				for ($i = 1; $i <= $r_tt['rate']; $i++) {
					$list_star .= '<i class="fa fa-star"></i>';
				}
				for ($i = 1; $i <= $con; $i++) {
					$list_star_o .= '<i class="fa fa-star-o"></i>';
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['ten_hangtau'] = $r_booking['ten_hangtau'];
				$r_tt['ten_loai_container'] = $r_booking['ten_loai_container'];
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['mobile'] = substr($r_tt['mobile'], 0, -3) . '***';
				$r_tt['list_star'] = $list_star . '' . $list_star_o;
				unset($list_star);
				unset($list_star_o);
				$r_tt['update_post'] = date('H:i d/m/Y', $r_tt['update_post']);
				$list .= $skin->skin_replace('skin_members/box_action/li_rate_khach', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_booking($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_tau = mysqli_query($conn, "SELECT * FROM list_hangtau WHERE id='{$r_tt['hang_tau']}'");
				$r_tau = mysqli_fetch_assoc($thongtin_tau);
				$r_tt['hang_tau'] = $r_tau['viet_tat'];
				$thongtin_container = mysqli_query($conn, "SELECT * FROM loai_container WHERE id='{$r_tt['loai_container']}'");
				$r_container = mysqli_fetch_assoc($thongtin_container);
				$r_tt['loai_container'] = $r_container['tieu_de'];
				if ($r_tt['loai_hinh'] == 'hangnhap') {
					$r_tt['loai_hinh'] = 'Hàng nhập';
				} else {
					$r_tt['loai_hinh'] = 'Hàng xuất';
				}
				if ($r_tt['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_tt['mat_hang_khac'];
				}
				$r_tt['ngay'] = date('d/m/Y', $r_tt['date_post']);
				if ($r_tt['status'] == 0) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_tt['id'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Hoàn thành';
					$button_edit = '';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				}
				$r_tt['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking', $r_tt);
			}
			return $list;
		}
		////////////////////
		// Danh sách booking trả phí 

		function list_booking_traphi($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			$thongtin = mysqli_query($conn, "
				SELECT lc.id, lc.ma_booking, MAX(lc.date_time) AS max_date_time, lc.ngay 
				FROM list_container AS lc
				JOIN booking AS b ON lc.ma_booking = b.ma_booking
				WHERE lc.loai_hinh = 'hangxuat' 
				AND lc.status = '0' 
				AND lc.user_id = '$user_id' 
				AND b.ket_hop = '1'
				GROUP BY lc.ma_booking, lc.ngay 
				ORDER BY max_date_time DESC 
				LIMIT $start, $limit
			");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.id AS id_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,b.phan_loai,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['id_booking'] = $r_booking['id_booking'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['phan_loai'] == 'vantai_truyenthong') {
					$r_tt['phan_loai'] = 'Vận tải truyền thống';
				} else if ($r_booking['phan_loai'] == 'vantai_kethop') {
					$r_tt['phan_loai'] = 'Vận tải kết hợp';
				} else if ($r_booking['phan_loai'] == 'vantai_banvo_kethop') {
					$r_tt['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
				} else if ($r_booking['phan_loai'] == 'banvo_kethop') {
					$r_tt['phan_loai'] = 'Bán vỏ kết hợp';
				} else {
					$r_tt['phan_loai'] = '';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				$button_edit = '<a href="/members/view-booking?id=' . $r_tt['id'] . '"><button class="bg_blue b_mobile" style="width:100%"> Chi tiết</button></a>';
				// $button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_tt['id'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
				// $button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';

				$r_tt['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_traphi', $r_tt);
			}
			return $list;
		}

		////////////////////
		function timkiem_booking($conn, $user_id, $loai_hinh, $hang_tau, $loai_container, $from, $to, $dia_diem, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$hientai = time();
			if ($loai_hinh == '') {
				$ok = 0;
				$total = 0;
				$list = '';
			} else {
				if ($hang_tau == 0) {
					$where_hang_tau = '';
				} else {
					$where_hang_tau = "AND b.hang_tau='$hang_tau'";
				}
				if ($loai_container == 0) {
					$where_loai_container = '';
				} else {
					$where_loai_container = " AND b.loai_container='$loai_container'";
				}
				if ($from == '') {
					$where_from = '';
				} else {
					$tach_from = explode('/', $from);
					$time_from = mktime(0, 0, 0, $tach_from[1], $tach_from[0], $tach_from[2]);
					$where_from = "AND lc.date_time>='$time_from'";
				}
				if ($to == '') {
					$where_to = '';
				} else {
					$tach_to = explode('/', $to);
					$time_to = mktime(23, 59, 59, $tach_to[1], $tach_to[0], $tach_to[2]);
					$where_to = "AND lc.date_time<='$time_to'";
				}
				if ($dia_diem == 0) {
					$where_dia_diem = '';
				} else {
					$where_dia_diem = "AND b.tinh='$dia_diem'";
				}
				if ($loai_hinh == '') {
					$where_loai_hinh = '';
				} else {
					$where_loai_hinh = "AND lc.loai_hinh='$loai_hinh'";
				}
				$total = 0;
				$thongtin_list_container = mysqli_query($conn, "SELECT b.*,lc.id AS id_container,lc.ngay,lc.thoi_gian FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' AND lc.date_time>'$hientai' $where_hang_tau $where_loai_container $where_dia_diem $where_loai_hinh $where_from $where_to GROUP BY lc.ma_booking,lc.ngay ORDER BY lc.date_time DESC LIMIT $start,$limit");
				while ($r_cont = mysqli_fetch_assoc($thongtin_list_container)) {
					$total++;
					$r_cont['i'] = $total;
					if ($r_cont['mat_hang'] == 'khac') {
						$r_cont['mat_hang'] = $r_cont['mat_hang_khac'];
					}
					$r_cont['gia'] = number_format($r_cont['gia']);
					$thongtin_soluong = mysqli_query($conn, "SELECT count(*) AS total FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND ngay='{$r_cont['ngay']}' AND date_time>='$hientai'");
					$r_sl = mysqli_fetch_assoc($thongtin_soluong);
					$r_cont['so_luong'] = $r_sl['total'];
					if ($r_cont['so_luong'] > 1) {
						$r_cont['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_cont['id_container'] . '"></i>';
					} else {
						$r_cont['more'] = '';
					}
					if ($r_cont['phan_loai'] == 'vantai_truyenthong') {
						$r_cont['phan_loai'] = 'Vận tải truyền thống';
					} else if ($r_cont['phan_loai'] == 'vantai_kethop') {
						$r_cont['phan_loai'] = 'Vận tải kết hợp';
					} else if ($r_cont['phan_loai'] == 'vantai_banvo_kethop') {
						$r_cont['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
					} else if ($r_cont['phan_loai'] == 'banvo_kethop') {
						$r_cont['phan_loai'] = 'Bán vỏ kết hợp';
					} else {
						$r_cont['phan_loai'] = '';
					}
					$r_cont['hang_tau'] = $r_cont['ten_hangtau'];
					$r_cont['loai_container'] = $r_cont['ten_loai_container'];
					if ($loai_hinh == 'hangnhap') {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hangnhap', $r_cont);
					} else if ($loai_hinh == 'hang_noidia') {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hang_noidia', $r_cont);
					} else {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hangxuat', $r_cont);
					}
				}
				if ($total == 0) {
					$ok = 0;
				} else {
					$ok = 1;
				}
			}
			$info = array(
				'ok' => $ok,
				'total' => $total,
				'list' => $list
			);
			return json_encode($info);
		}
		////////////////////
		function timkiem_booking_user($conn, $user_id, $loai_hinh, $hang_tau, $loai_container, $from, $to, $dia_diem, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$hientai = time();
			if ($loai_hinh == '') {
				$ok = 0;
				$total = 0;
				$list = '';
			} else {
				if ($hang_tau == 0) {
					$where_hang_tau = '';
				} else {
					$where_hang_tau = "AND b.hang_tau='$hang_tau'";
				}
				if ($loai_container == 0) {
					$where_loai_container = '';
				} else {
					$where_loai_container = " AND b.loai_container='$loai_container'";
				}
				if ($from == '') {
					$where_from = '';
				} else {
					$tach_from = explode('/', $from);
					$time_from = mktime(0, 0, 0, $tach_from[1], $tach_from[0], $tach_from[2]);
					$where_from = "AND lc.date_time>='$time_from'";
				}
				if ($to == '') {
					$where_to = '';
				} else {
					$tach_to = explode('/', $to);
					$time_to = mktime(23, 59, 59, $tach_to[1], $tach_to[0], $tach_to[2]);
					$where_to = "AND lc.date_time<='$time_to'";
				}
				if ($dia_diem == 0) {
					$where_dia_diem = '';
				} else {
					$where_dia_diem = "AND b.tinh='$dia_diem'";
				}
				if ($loai_hinh == '') {
					$where_loai_hinh = '';
				} else {
					$where_loai_hinh = "AND lc.loai_hinh='$loai_hinh'";
				}
				$total = 0;
				//$thongtin_list_container=mysqli_query($conn,"SELECT * FROM list_container WHERE status='0' AND ma_booking IN ($list_ma) $where_from $where_to GROUP BY ma_booking,ngay ORDER BY date_time ASC");
				$thongtin_list_container = mysqli_query($conn, "SELECT b.*,lc.id AS id_container,lc.ngay,lc.thoi_gian FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.status='0' AND lc.user_id='$user_id' $where_hang_tau $where_loai_container $where_dia_diem $where_loai_hinh $where_from $where_to GROUP BY lc.ma_booking,lc.ngay ORDER BY lc.date_time DESC LIMIT $start,$limit");
				while ($r_cont = mysqli_fetch_assoc($thongtin_list_container)) {
					$total++;
					$r_cont['i'] = $total;
					if ($r_cont['mat_hang'] == 'khac') {
						$r_cont['mat_hang'] = $r_cont['mat_hang_khac'];
					}
					$r_cont['gia'] = number_format($r_cont['gia']);
					$thongtin_soluong = mysqli_query($conn, "SELECT count(*) AS total FROM list_container WHERE ma_booking='{$r_cont['ma_booking']}' AND ngay='{$r_cont['ngay']}'");
					$r_sl = mysqli_fetch_assoc($thongtin_soluong);
					$r_cont['so_luong'] = $r_sl['total'];
					if ($r_cont['so_luong'] > 1) {
						$r_cont['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_cont['id_container'] . '"></i>';
					} else {
						$r_cont['more'] = '';
					}
					$r_cont['hang_tau'] = $r_cont['ten_hangtau'];
					$r_cont['loai_container'] = $r_cont['ten_loai_container'];
					if ($r_cont['phan_loai'] == 'vantai_truyenthong') {
						$r_cont['phan_loai'] = 'Vận tải truyền thống';
					} else if ($r_cont['phan_loai'] == 'vantai_kethop') {
						$r_cont['phan_loai'] = 'Vận tải kết hợp';
					} else if ($r_cont['phan_loai'] == 'vantai_banvo_kethop') {
						$r_cont['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
					} else if ($r_cont['phan_loai'] == 'banvo_kethop') {
						$r_cont['phan_loai'] = 'Bán vỏ kết hợp';
					} else {
						$r_cont['phan_loai'] = '';
					}
					if ($r_tt['status_booking'] == 0) {
						$r_tt['status'] = 'Chưa hoàn thành';
						$button_edit = '<a href="/members/edit-booking?id=' . $r_cont['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
						$button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_cont['id'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
						$button_copy = '<a href="/members/copy-booking?id=' . $r_cont['id'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
					} else if ($r_tt['status_booking'] == 1) {
						$r_tt['status'] = 'Hoàn thành';
						$button_edit = '';
						$button_del = '';
						$button_copy = '<a href="/members/copy-booking?id=' . $r_cont['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
					} else if ($r_tt['status_booking'] == 2) {
						$r_tt['status'] = 'Chưa hoàn thành';
						$button_edit = '<a href="/members/edit-booking?id=' . $r_cont['id'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
						$button_del = '';
						$button_copy = '<a href="/members/copy-booking?id=' . $r_cont['id'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
					}
					$r_cont['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
					if ($loai_hinh == 'hangnhap') {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hangnhap_user', $r_cont);
					} else if ($loai_hinh == 'hang_noidia') {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hang_noidia_user', $r_cont);
					} else {
						$list .= $skin->skin_replace('skin_members/box_action/tr_hangxuat_user', $r_cont);
					}
				}
				if ($total == 0) {
					$ok = 0;
				} else {
					$ok = 1;
				}
			}
			$info = array(
				'ok' => $ok,
				'total' => $total,
				'list' => $list
			);
			return json_encode($info);
		}
		////////////////////
		function list_booking_new($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.user_id='$user_id' AND list_container.status='0' GROUP BY list_container.id ORDER BY list_container.id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['hang_tau'] = $r_tt['ten_hangtau'];
				$r_tt['loai_container'] = $r_tt['ten_loai_container'];
				if ($r_tt['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_tt['mat_hang_khac'];
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_new', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_booking_wait($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT lb.*,u.rate,u.num_rate FROM list_booking lb INNER JOIN user_info u ON u.user_id=lb.user_dat WHERE lb.user_id='$user_id' AND lb.status='0' ORDER BY lb.id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				if ($r_tt['rate'] == 0 && $r_tt['num_rate'] == 0) {
					$r_tt['rate'] = 'Chưa có đánh giá';
					$r_tt['link_rate_detail'] = '';
				} else {
					$con = 5 - $r_tt['rate'];
					for ($i = 1; $i <= $r_tt['rate']; $i++) {
						$list_star .= '<i class="fa fa-star"></i>';
					}
					for ($i = 1; $i <= ceil($con); $i++) {
						$list_star_o .= '<i class="fa fa-star-o"></i>';
					}
					$r_tt['rate'] = $list_star . '' . $list_star_o;
					$r_tt['link_rate_detail'] = '<div><a href="/members/list-rate?id=' . $r_tt['user_dat'] . '">Xem chi tiết</a></div>';
				}
				unset($list_star);
				unset($list_star_o);
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_wait', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_booking_confirm($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_id='$user_id' AND status='2' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$thongtin_huy = mysqli_query($conn, "SELECT * FROM yeucau_huy WHERE id_booking='{$r_tt['id']}' AND user_id='$user_id' AND status='0'");
				$total_huy = mysqli_num_rows($thongtin_huy);
				if ($total_huy > 0) {
					$r_tt['text_yeucau'] = 'Đã yêu cầu hủy';
				} else {
					$r_tt['text_yeucau'] = 'Yêu cầu hủy';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_confirm', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_booking_false($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_id='$user_id' AND status='3' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_false', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_booking_success($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_id='$user_id' AND status='1' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_booking_success', $r_tt);
			}
			return $list;
		}


		////////////////////
		function list_dat_booking_wait($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='0' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_dat_booking_wait', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_dat_booking_confirm($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='2' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$thongtin_huy = mysqli_query($conn, "SELECT * FROM yeucau_huy WHERE id_booking='{$r_tt['id']}' AND user_id='$user_id' AND status='0'");
				$total_huy = mysqli_num_rows($thongtin_huy);
				if ($total_huy > 0) {
					$r_tt['text_yeucau'] = 'Đã yêu cầu hủy';
				} else {
					$r_tt['text_yeucau'] = 'Yêu cầu hủy';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_dat_booking_confirm', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_dat_booking_false($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='3' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_dat_booking_false', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_dat_booking_success($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND status='1' ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT list_container.*,booking.so_booking,booking.mat_hang,booking.mat_hang_khac,booking.ten_hangtau,booking.ten_loai_container,booking.gia,booking.ten_tinh,booking.ten_huyen,booking.ten_xa,booking.ten_cang FROM list_container LEFT JOIN booking ON booking.ma_booking=list_container.ma_booking WHERE list_container.id='{$r_tt['id_container']}'");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				if ($r_booking['mat_hang'] == 'khac') {
					$r_booking['mat_hang'] = $r_booking['mat_hang_khac'];
				}
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['mat_hang'] = $r_booking['mat_hang'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia_booking'] = number_format($r_booking['gia']);
				$r_tt['gia'] = number_format($r_tt['gia']);
				$r_tt['ngay_booking'] = $r_booking['ngay'];
				$r_tt['thoi_gian_booking'] = $r_booking['thoi_gian'];
				$list .= $skin->skin_replace('skin_members/box_action/tr_dat_booking_success', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hangnhap($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();


			$thongtin = mysqli_query($conn, "SELECT id, ma_booking,ngay FROM list_container WHERE loai_hinh='hangnhap' AND status='0' AND date_time>='$hientai' /*GROUP BY ma_booking,ngay*/ ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {

				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_trahang,b.diachi_donghang,b.han_tra_rong,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,b.phan_loai,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai' AND status='0') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['so_hieu'] = $r_booking['so_hieu'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_trahang'] = $r_booking['diachi_trahang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['han_tra_rong'] = $r_booking['han_tra_rong'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['phan_loai'] == 'vantai_truyenthong') {
					$r_tt['phan_loai'] = 'Vận tải truyền thống';
				} else if ($r_booking['phan_loai'] == 'vantai_kethop') {
					$r_tt['phan_loai'] = 'Vận tải kết hợp';
				} else if ($r_booking['phan_loai'] == 'vantai_banvo_kethop') {
					$r_tt['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
				} else if ($r_booking['phan_loai'] == 'banvo_kethop') {
					$r_tt['phan_loai'] = 'Bán vỏ kết hợp';
				} else {
					$r_tt['phan_loai'] = '';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_hangnhap', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hangnhap_user($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangnhap' AND status='0' AND user_id='$user_id' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.id AS id_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.han_tra_rong,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,b.phan_loai,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['id_booking'] = $r_booking['id_booking'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_trahang'] = $r_booking['diachi_trahang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['phan_loai'] == 'vantai_truyenthong') {
					$r_tt['phan_loai'] = 'Vận tải truyền thống';
				} else if ($r_booking['phan_loai'] == 'vantai_kethop') {
					$r_tt['phan_loai'] = 'Vận tải kết hợp';
				} else if ($r_booking['phan_loai'] == 'vantai_banvo_kethop') {
					$r_tt['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
				} else if ($r_booking['phan_loai'] == 'banvo_kethop') {
					$r_tt['phan_loai'] = 'Bán vỏ kết hợp';
				} else {
					$r_tt['phan_loai'] = '';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				if ($r_tt['status'] == 0) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_tt['id_booking'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Hoàn thành';
					$button_edit = '';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				}
				$r_tt['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
				$list .= $skin->skin_replace('skin_members/box_action/tr_hangnhap_user', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hang_noidia_user($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hang_noidia' AND status='0' AND user_id='$user_id' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.id AS id_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.ten_xa_donghang,b.ten_huyen_donghang,b.ten_tinh_donghang,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['id_booking'] = $r_booking['id_booking'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['ten_xa_donghang'] = $r_booking['ten_xa_donghang'];
				$r_tt['ten_huyen_donghang'] = $r_booking['ten_huyen_donghang'];
				$r_tt['ten_tinh_donghang'] = $r_booking['ten_tinh_donghang'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_tt['diachi_trahang'] = $r_booking['diachi_trahang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				if ($r_tt['status'] == 0) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_tt['id_booking'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Hoàn thành';
					$button_edit = '';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				}
				$r_tt['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
				$list .= $skin->skin_replace('skin_members/box_action/tr_hang_noidia_user', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hangxuat_user($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND user_id='$user_id' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.id AS id_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,b.phan_loai,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['id_booking'] = $r_booking['id_booking'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['phan_loai'] == 'vantai_truyenthong') {
					$r_tt['phan_loai'] = 'Vận tải truyền thống';
				} else if ($r_booking['phan_loai'] == 'vantai_kethop') {
					$r_tt['phan_loai'] = 'Vận tải kết hợp';
				} else if ($r_booking['phan_loai'] == 'vantai_banvo_kethop') {
					$r_tt['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
				} else if ($r_booking['phan_loai'] == 'banvo_kethop') {
					$r_tt['phan_loai'] = 'Bán vỏ kết hợp';
				} else {
					$r_tt['phan_loai'] = '';
				}
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				if ($r_tt['status'] == 0) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '<button class="bg_red b_mobile del_list_booking" style="width:100%" id="' . $r_tt['id_booking'] . '"><i class="fa fa-trash-o"></i> Xóa</button>';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Hoàn thành';
					$button_edit = '';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Chưa hoàn thành';
					$button_edit = '<a href="/members/edit-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_blue b_mobile" style="width:100%"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>';
					$button_del = '';
					$button_copy = '<a href="/members/copy-booking?id=' . $r_tt['id_booking'] . '"><button class="bg_orange b_mobile" style="width:100%"><i class="icon icon-stack"></i> Copy</button></a>';
				}
				$r_tt['list_button'] = $button_edit . ' ' . $button_copy . ' ' . $button_del;
				$list .= $skin->skin_replace('skin_members/box_action/tr_hangxuat_user', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hangxuat($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			//$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MIN(date_time) AS min_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY min_date_time ASC LIMIT $start,$limit");
			$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hangxuat' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.mat_hang,b.mat_hang_khac,b.phan_loai,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND status='0' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_booking['phan_loai'] == 'vantai_truyenthong') {
					$r_tt['phan_loai'] = 'Vận tải truyền thống';
				} else if ($r_booking['phan_loai'] == 'vantai_kethop') {
					$r_tt['phan_loai'] = 'Vận tải kết hợp';
				} else if ($r_booking['phan_loai'] == 'vantai_banvo_kethop') {
					$r_tt['phan_loai'] = 'Vận tải & bán vỏ kết hợp';
				} else if ($r_booking['phan_loai'] == 'banvo_kethop') {
					$r_tt['phan_loai'] = 'Bán vỏ kết hợp';
				} else {
					$r_tt['phan_loai'] = '';
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_hangxuat', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hang_noidia($conn, $user_id, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			$thongtin = mysqli_query($conn, "SELECT id, ma_booking, MAX(date_time) AS max_date_time, ngay FROM list_container WHERE loai_hinh='hang_noidia' AND status='0' AND date_time>='$hientai' GROUP BY ma_booking,ngay ORDER BY max_date_time DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$thongtin_booking = mysqli_query($conn, "SELECT lc.*,b.so_booking,b.ten_hangtau,b.ten_loai_container,b.mat_hang,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia,b.ten_xa,b.ten_huyen,b.ten_tinh,b.ten_xa_donghang,b.ten_huyen_donghang,b.ten_tinh_donghang,b.mat_hang,b.mat_hang_khac,(SELECT count(*) FROM list_container WHERE ma_booking='{$r_tt['ma_booking']}' AND ngay='{$r_tt['ngay']}' AND date_time>='$hientai') AS so_luong FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.id='{$r_tt['id']}' GROUP BY lc.id");
				$r_booking = mysqli_fetch_assoc($thongtin_booking);
				$r_tt['hang_tau'] = $r_booking['ten_hangtau'];
				$r_tt['id_container'] = $r_tt['id'];
				$r_tt['loai_container'] = $r_booking['ten_loai_container'];
				$r_tt['gia'] = number_format($r_booking['gia']);
				$r_tt['ten_xa'] = $r_booking['ten_xa'];
				$r_tt['ten_huyen'] = $r_booking['ten_huyen'];
				$r_tt['ten_tinh'] = $r_booking['ten_tinh'];
				$r_tt['ten_xa_donghang'] = $r_booking['ten_xa_donghang'];
				$r_tt['ten_huyen_donghang'] = $r_booking['ten_huyen_donghang'];
				$r_tt['ten_tinh_donghang'] = $r_booking['ten_tinh_donghang'];
				$r_tt['so_booking'] = $r_booking['so_booking'];
				$r_tt['diachi_donghang'] = $r_booking['diachi_donghang'];
				$r_tt['diachi_trahang'] = $r_booking['diachi_trahang'];
				$r_tt['thoi_gian'] = $r_booking['thoi_gian'];
				$r_tt['han_tra_rong'] = $r_booking['han_tra_rong'];
				$r_tt['so_luong'] = $r_booking['so_luong'];
				if ($r_booking['mat_hang'] == 'khac') {
					$r_tt['mat_hang'] = $r_booking['mat_hang_khac'];
				} else {
					$r_tt['mat_hang'] = $r_booking['mat_hang'];
				}
				if ($r_tt['so_luong'] > 1) {
					$r_tt['more'] = '<i class="fa fa-plus-circle" id_container="' . $r_tt['id'] . '"></i>';
				} else {
					$r_tt['more'] = '';
				}
				$list .= $skin->skin_replace('skin_members/box_action/tr_hang_noidia', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_hang_goiy($conn, $id_container, $loai_hinh, $hang_tau, $loai_container, $tinh, $huyen, $xa, $date_time)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$hientai = time();
			if ($loai_hinh == 'hangnhap') {
				$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE loai_hinh='hangxuat' AND hang_tau='$hang_tau' AND loai_container='$loai_container' AND status!='1'");
				$total = mysqli_num_rows($thongtin);
				if ($total == 0) {
					$info = array(
						'total' => 0,
						'list' => ''
					);
					return json_encode($info);
				} else {
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$ma_booking .= "'" . $r_tt['ma_booking'] . "',";
					}
					$ma_booking = substr($ma_booking, 0, -1);
					$time_max = $date_time + 3600 * 24;
					$thongtin_container = mysqli_query($conn, "SELECT lc.*,b.mat_hang,b.mat_hang_khac,b.tinh,b.ten_tinh,b.xa,b.ten_xa,b.huyen,b.ten_huyen,b.hang_tau,b.ten_hangtau,b.loai_container,b.ten_loai_container,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.ma_booking IN ($ma_booking) AND lc.status='0' AND lc.date_time>'$hientai' AND lc.date_time>='$date_time' /*AND lc.date_time<'$time_max'*/ GROUP BY lc.id ORDER BY lc.date_time ASC");
					$total_container = mysqli_num_rows($thongtin_container);
					if ($total_container == 0) {
						$info = array(
							'total' => 0,
							'list' => ''
						);
						return json_encode($info);
					} else {
						while ($r_cont = mysqli_fetch_assoc($thongtin_container)) {
							$id_c = $r_cont['id'];
							$list_tam[$id_c]['ten_tinh'] = $r_cont['ten_tinh'];
							$list_tam[$id_c]['ten_xa'] = $r_cont['ten_xa'];
							$list_tam[$id_c]['ten_huyen'] = $r_cont['ten_huyen'];
							$list_tam[$id_c]['ten_hangtau'] = $r_cont['ten_hangtau'];
							$list_tam[$id_c]['ten_loai_container'] = $r_cont['ten_loai_container'];
							$list_tam[$id_c]['ten_cang'] = $r_cont['ten_cang'];
							$list_tam[$id_c]['diachi_donghang'] = $r_cont['diachi_donghang'];
							$list_tam[$id_c]['diachi_trahang'] = $r_cont['diachi_trahang'];
							$list_tam[$id_c]['gia'] = number_format($r_cont['gia']);
							$list_tam[$id_c]['id'] = $id_c;
							if ($r_cont['mat_hang'] == 'khac') {
								$r_cont['mat_hang'] = $r_cont['mat_hang_khac'];
							}
							$list_tam[$id_c]['ngay'] = $r_cont['ngay'];
							$list_tam[$id_c]['thoi_gian'] = $r_cont['thoi_gian'];
							$list_tam[$id_c]['mat_hang'] = $r_cont['mat_hang'];
							$time_gioihan = $r_cont['date_time'] - $date_time;
							$list_tam[$id_c]['sort_time'] = $time_gioihan;
							if ($r_cont['tinh'] == $tinh and $r_cont['huyen'] == $huyen and $r_cont['xa'] == $xa) {
								$list_tam[$id_c]['sort_dc'] = 1;
							} else if ($r_cont['tinh'] == $tinh and $r_cont['huyen'] == $huyen) {
								$list_tam[$id_c]['sort_dc'] = 2;
							} else if ($r_cont['tinh'] == $tinh) {
								$list_tam[$id_c]['sort_dc'] = 3;
							} else {
								$list_tam[$id_c]['sort_dc'] = 4;
							}
						}
						usort($list_tam, array($this, 'sap_xep_theo_stt_va_time'));
						$ik = 0;
						foreach ($list_tam as $key => $value) {
							$ik++;
							$value['i'] = $ik;
							$list .= $skin->skin_replace('skin_members/box_action/tr_goiy_hangxuat', $value);
						}
						$info = array(
							'total' => $total_container,
							'list' => $list
						);
						return json_encode($info);
					}
				}
			} else if ($loai_hinh == 'hangxuat') {
				$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE loai_hinh='hangnhap' AND hang_tau='$hang_tau' AND loai_container='$loai_container' AND status!='1'");
				$total = mysqli_num_rows($thongtin);
				if ($total == 0) {
					$info = array(
						'total' => 0,
						'list' => ''
					);
					return json_encode($info);
				} else {
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$ma_booking .= "'" . $r_tt['ma_booking'] . "',";
					}
					$ma_booking = substr($ma_booking, 0, -1);
					$time_max = $date_time + 3600 * 24;
					$thongtin_container = mysqli_query($conn, "SELECT lc.*,b.mat_hang,b.mat_hang_khac,b.tinh,b.ten_tinh,b.xa,b.ten_xa,b.huyen,b.ten_huyen,b.hang_tau,b.ten_hangtau,b.loai_container,b.ten_loai_container,b.diachi_trahang,b.diachi_donghang,b.ten_cang,b.gia FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.ma_booking IN ($ma_booking) AND lc.status='0' AND lc.date_time>'$hientai' AND lc.date_time>='$date_time'/* AND lc.date_time<'$time_max'*/ GROUP BY lc.id ORDER BY lc.date_time ASC");
					$total_container = mysqli_num_rows($thongtin_container);
					if ($total_container == 0) {
						$info = array(
							'total' => 0,
							'list' => ''
						);
						return json_encode($info);
					} else {
						while ($r_cont = mysqli_fetch_assoc($thongtin_container)) {
							$id_c = $r_cont['id'];
							$list_tam[$id_c]['ten_tinh'] = $r_cont['ten_tinh'];
							$list_tam[$id_c]['ten_xa'] = $r_cont['ten_xa'];
							$list_tam[$id_c]['ten_huyen'] = $r_cont['ten_huyen'];
							$list_tam[$id_c]['ten_hangtau'] = $r_cont['ten_hangtau'];
							$list_tam[$id_c]['ten_loai_container'] = $r_cont['ten_loai_container'];
							$list_tam[$id_c]['ten_cang'] = $r_cont['ten_cang'];
							$list_tam[$id_c]['diachi_donghang'] = $r_cont['diachi_donghang'];
							$list_tam[$id_c]['diachi_trahang'] = $r_cont['diachi_trahang'];
							$list_tam[$id_c]['gia'] = number_format($r_cont['gia']);
							$list_tam[$id_c]['ngay'] = $r_cont['ngay'];
							$list_tam[$id_c]['thoi_gian'] = $r_cont['thoi_gian'];
							$list_tam[$id_c]['id'] = $id_c;
							if ($r_cont['mat_hang'] == 'khac') {
								$r_cont['mat_hang'] = $r_cont['mat_hang_khac'];
							}
							$list_tam[$id_c]['mat_hang'] = $r_cont['mat_hang'];
							$time_gioihan = $r_cont['date_time'] - $date_time;
							$list_tam[$id_c]['sort_time'] = $time_gioihan;
							if ($r_cont['tinh'] == $tinh and $r_cont['huyen'] == $huyen and $r_cont['xa'] == $xa) {
								$list_tam[$id_c]['sort_dc'] = 1;
							} else if ($r_cont['tinh'] == $tinh and $r_cont['huyen'] == $huyen) {
								$list_tam[$id_c]['sort_dc'] = 2;
							} else if ($r_cont['tinh'] == $tinh) {
								$list_tam[$id_c]['sort_dc'] = 3;
							} else {
								$list_tam[$id_c]['sort_dc'] = 4;
							}
						}
						usort($list_tam, array($this, 'sap_xep_theo_stt_va_time'));
						$ik = 0;
						foreach ($list_tam as $key => $value) {
							$ik++;
							$value['i'] = $ik;
							$list .= $skin->skin_replace('skin_members/box_action/tr_goiy_hangnhap', $value);
						}
						$info = array(
							'total' => $total_container,
							'list' => $list
						);
						return json_encode($info);
					}
				}
			}
		}
		///////////////////
		function list_notification($conn, $user_id, $loai, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			if ($loai == 'all') {
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE user_nhan='$user_id' ORDER BY id DESC LIMIT $start,$limit");
			} else {
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE user_nhan='$user_id' AND (doc IS NULL OR FIND_IN_SET('$user_id', doc) < 1) ORDER BY id DESC LIMIT $start,$limit");
			}
			$i = $start;
			$total = 0;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$total++;
				$i++;
				$r_tt['i'] = $i;
				$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
				if ($r_tt['doc'] == '') {
					$doc = $user_id;
					mysqli_query($conn, "UPDATE notification SET doc='$doc' WHERE id='{$r_tt['id']}'");
				} else {
					$tach_doc = explode(',', $r_tt['doc']);
					if (in_array($user_id, $tach_doc) == true) {
					} else {
						$doc = $r_tt['doc'] . ',' . $user_id;
						mysqli_query($conn, "UPDATE notification SET doc='$doc' WHERE id='{$r_tt['id']}'");
					}
				}
				if($r_tt['phan_loai'] == 'giaoviec_tructiep'){
					$r_tt['view'] = 'view_giaoviec';
				}else if($r_tt['phan_loai'] == 'giaoviec_du_an'){
					$r_tt['view'] = 'view_du_an';
				}
				
				$r_tt['id']= $r_tt['id_congviec'];
				$list .= $skin->skin_replace('skin_members/box_action/li_notification', $r_tt);
			}
			$info = array(
				'total' => $total,
				'list' => $list
			);
			return json_encode($info);
		}
		////////////////////
		function list_category_video($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM category_video ORDER BY thu_tu ASC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$list .= $skin->skin_replace('skin_members/box_action/tr_category_video', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_quantri($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM emin_info ORDER BY id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
				$i++;
				$r_tt['i'] = $i;
				$list .= $skin->skin_replace('skin_members/box_action/tr_quantri', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_slide($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$list .= $skin->skin_replace('skin_members/box_action/tr_slide', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_video($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM video ORDER BY id DESC LIMIT $start,$limit");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$param_video = parse_url($r_tt['link_video']);
				parse_str($param_video['query'], $url_video);
				$id_video = addslashes($url_video['v']);
				$r_tt['id_video'] = $id_video;
				$list .= $skin->skin_replace('skin_members/box_action/li_video', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_thongbao($conn, $page, $limit)
		{
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_thongbao', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_baiviet($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC LIMIT $start,$limit");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$list .= $skin->skin_replace('skin_members/box_action/tr_baiviet', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_quanly($conn)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE leader='1' ORDER BY user_id DESC");
			$i = 0;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['created'] = date('d/m/Y', $r_tt['created']);
				$thongtin_quanly = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE aff='{$r_tt['user_id']}'");
				$r_ql = mysqli_fetch_assoc($thongtin_quanly);
				$r_tt['total'] = $r_ql['total'];
				$list .= $skin->skin_replace('skin_members/box_action/li_quanly', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_thanhvien($conn, $active, $total, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			if ($active == 'all') {
				$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE nhom='0' ORDER BY user_id DESC LIMIT $start,$limit");
			} else {
				$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE nhom='0' AND active='$active' ORDER BY user_id DESC LIMIT $start,$limit");
			}
			$i = $total - $start + 1;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i--;
				$r_tt['i'] = $i;
				$r_tt['user_money'] = number_format($r_tt['user_money']);
				$r_tt['user_donate'] = number_format($r_tt['user_donate']);
				$r_tt['created'] = date('d/m/Y', $r_tt['created']);
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
				if ($active == 2) {
					$list .= $skin->skin_replace('skin_members/box_action/tr_thanhvien_khoa', $r_tt);
				} else if ($active == 3) {
					$list .= $skin->skin_replace('skin_members/box_action/tr_thanhvien_khoa_vinhvien', $r_tt);
				} else {
					$list .= $skin->skin_replace('skin_members/box_action/tr_thanhvien', $r_tt);
				}
			}
			return $list;
		}
		////////////////////
		function list_yeucau($conn, $thanh_vien, $phien)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE chat.user_in='$thanh_vien' OR chat.user_out='$thanh_vien' GROUP BY chat.phien ORDER BY chat.id DESC");
			$i = 0;
			$total = mysqli_num_rows($thongtin);
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['date_post'] = $check->date_update($r_tt['date_post']);
				if ($r_tt['active'] == 1) {
					$r_tt['disable'] = '';
				} else {
					$r_tt['disable'] = 'disable';
				}
				if ($phien == $r_tt['phien'] and $r_tt['active'] == 1) {
					$r_tt['active'] = 'active';
				} else {
					$r_tt['active'] = '';
				}
				$list .= $skin->skin_replace('skin_members/box_action/li_yeucau', $r_tt);
			}
			return $list;
		}
		////////////////////
		function list_chat($conn, $user_id, $name, $avatar, $user_end, $phien, $sms_id, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$thongtin = mysqli_query($conn, "SELECT chat.*,user_info.avatar,user_info.name FROM chat LEFT JOIN user_info ON user_info.user_id=chat.user_out WHERE chat.phien='$phien' AND chat.noi_dung!='' AND chat.id<'$sms_id' ORDER BY chat.id DESC LIMIT $limit");
			$total = mysqli_num_rows($thongtin);
			if ($total == 0) {
				$list = '';
				$load = 0;
			} else {
				if ($total < $limit) {
					$load = 0;
				} else {
					$load = 1;
				}
				$i = 0;
				$_SESSION['user_end'] = $user_end;
				while ($r_tt = mysqli_fetch_assoc($thongtin)) {
					$list_x[$i] = $r_tt;
					$i++;
					if ($r_tt['user_out'] != $r_tt['thanh_vien']) {
						mysqli_query($conn, "UPDATE chat SET doc='1' WHERE id='{$r_tt['id']}'");
					}
				}
				krsort($list_x);
				foreach ($list_x as $key => $value) {
					if ($value['user_out'] == $user_id) {
						$value['name'] = $name;
						$value['avatar'] = $avatar;
					}
					$value['noi_dung'] = $check->smile($value['noi_dung']);
					if ($value['user_out'] == $_SESSION['user_end']) {
						if ($user_id == $_SESSION['user_end']) {
							$list .= $skin->skin_replace('skin_members/box_action/li_chat_right', $value);
						} else {
							$list .= $skin->skin_replace('skin_members/box_action/li_chat_left', $value);
						}
					} else {
						if ($value['user_out'] == $user_id) {
							$list .= $skin->skin_replace('skin_members/box_action/li_chat_right_avatar', $value);
						} else {
							$list .= $skin->skin_replace('skin_members/box_action/li_chat_left_avatar', $value);
						}
					}
					$_SESSION['user_end'] = $value['user_out'];
				}
			}
			$info = array(
				'list' => $list,
				'load' => $load
			);
			return json_encode($info);
		}
		///////////////////
		function list_lienhe($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM contact ORDER BY id DESC LIMIT $start,$limit");
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
				$list .= $skin->skin_replace('skin_members/box_action/tr_lienhe', $r_tt);
			}
			return $list;
		}
		///////////////////
		function list_nhantin($conn, $page, $limit)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM dangky_nhantin WHERE shop='0' ORDER BY id DESC LIMIT $start,$limit");
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
				$list .= $skin->skin_replace('skin_members/box_action/tr_nhantin', $r_tt);
			}
			return $list;
		}
		///////////////////
		function thongke_naptien($conn, $user_id, $dau, $cuoi)
		{
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
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
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
		function thongke_naptien_thang($conn, $user_id, $thang, $nam, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
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
		function thongke_doanhso_naptien($conn, $user_id, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
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
		function thongke_chitieu($conn, $user_id, $dau, $cuoi)
		{
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
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$month = date('m', $r_tt['date_post']);
				$month = intval($month);
				if ($month == 1) {
					$month_1++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_1 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_1 += $r_tt['sotien'];
					}
				} else if ($month == 2) {
					$month_2++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_2 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_2 += $r_tt['sotien'];
					}
				} else if ($month == 3) {
					$month_3++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_3 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_3 += $r_tt['sotien'];
					}
				} else if ($month == 4) {
					$month_4++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_4 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_4 += $r_tt['sotien'];
					}
				} else if ($month == 5) {
					$month_5++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_5 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_5 += $r_tt['sotien'];
					}
				} else if ($month == 6) {
					$month_6++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_6 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_6 += $r_tt['sotien'];
					}
				} else if ($month == 7) {
					$month_7++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_7 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_7 += $r_tt['sotien'];
					}
				} else if ($month == 8) {
					$month_8++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_8 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_8 += $r_tt['sotien'];
					}
				} else if ($month == 9) {
					$month_9++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_9 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_9 += $r_tt['sotien'];
					}
				} else if ($month == 10) {
					$month_10++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_10 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_10 += $r_tt['sotien'];
					}
				} else if ($month == 11) {
					$month_11++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_11 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_11 += $r_tt['sotien'];
					}
				} else if ($month == 12) {
					$month_12++;
					if ($r_tt['truoc'] > $r_tt['sau']) {
						$doanhso_12 += $r_tt['sotien'];
					} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
						$hoan_12 += $r_tt['sotien'];
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
		function thongke_chitieu_thang($conn, $user_id, $thang, $nam, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($thang == 2) {
					if (checkdate(02, 29, $nam) == true) {
						for ($i = 1; $i <= 29; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['truoc'] > $r_tt['sau']) {
									$doanhso[$i] += $r_tt['sotien'];
								} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
									$hoan[$i] += $r_tt['sotien'];
								}
							}
						}
					} else {
						for ($i = 1; $i <= 28; $i++) {
							if ($ngay == $i) {
								$data_ngay[$i]++;
								if ($r_tt['truoc'] > $r_tt['sau']) {
									$doanhso[$i] += $r_tt['sotien'];
								} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
									$hoan[$i] += $r_tt['sotien'];
								}
							}
						}
					}
				} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
					for ($i = 1; $i <= 31; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['truoc'] > $r_tt['sau']) {
								$doanhso[$i] += $r_tt['sotien'];
							} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
								$hoan[$i] += $r_tt['sotien'];
							}
						}
					}
				} else {
					for ($i = 1; $i <= 30; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['truoc'] > $r_tt['sau']) {
								$doanhso[$i] += $r_tt['sotien'];
							} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
								$hoan[$i] += $r_tt['sotien'];
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
		function thongke_doanhso_chitieu($conn, $user_id, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$giaodich_chi = 0;
			$doanhso_chi = 0;
			$giaodich_hoan = 0;
			$doanhso_hoan = 0;
			$thongtin = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($r_tt['truoc'] > $r_tt['sau']) {
					$giaodich_chi++;
					$doanhso_chi += $r_tt['sotien'];
				} else if ($r_tt['truoc'] < $r_tt['sau'] and strpos($r_tt['noidung'], 'Hoàn phí') !== false) {
					$giaodich_hoan++;
					$doanhso_hoan += $r_tt['sotien'];
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
		function thongke_booking($conn, $user_id, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$hoan_thanh = 0;
			$xac_nhan = 0;
			$tu_choi = 0;
			$huy = 0;
			$thongtin = mysqli_query($conn, "SELECT * FROM booking WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			$total_booking = mysqli_num_rows($thongtin);
			$thongtin_container = mysqli_query($conn, "SELECT lc.*,b.gia FROM list_container lc INNER JOIN booking b ON lc.ma_booking=b.ma_booking WHERE lc.user_id='$user_id' AND lc.date_post>='$dau' AND lc.date_post<='$cuoi' GROUP BY lc.id ORDER BY lc.id ASC");
			$booking_tao = mysqli_num_rows($thongtin_container);
			$booking_cho = 0;
			$doanhso_cho = 0;
			while ($r_cont = mysqli_fetch_assoc($thongtin_container)) {
				$doanhso_tao += $r_cont['gia'];
				if ($r_cont['status'] == 0) {
					$doanhso_cho += $r_cont['gia'];
					$booking_cho++;
				}
			}
			$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_booking = mysqli_fetch_assoc($thongtin_booking)) {
				if ($r_booking['status'] == 1) {
					$hoan_thanh++;
					$doanhso_hoanthanh += $r_booking['gia'];
				} else if ($r_booking['status'] == 2) {
					$xac_nhan++;
					$doanhso_xacnhan += $r_booking['gia'];
				} else if ($r_booking['status'] == 3) {
					$tu_choi++;
					$doanhso_tuchoi += $r_booking['gia'];
				} else if ($r_booking['status'] == 0) {
					$cho_xacnhan++;
					$doanhso_cho_xacnhan += $r_booking['gia'];
				} else {
				}
			}
			$info = array(
				'total_booking' => $total_booking,
				'total_container' => $total_container,
				'doanhso_tao' => $doanhso_tao,
				'booking_tao' => $booking_tao,
				'booking_hoanthanh' => $hoan_thanh,
				'booking_xacnhan' => $xac_nhan,
				'booking_tuchoi' => $tu_choi,
				'booking_cho_xacnhan' => $cho_xacnhan,
				'doanhso_hoanthanh' => $doanhso_hoanthanh,
				'doanhso_xacnhan' => $doanhso_xacnhan,
				'doanhso_tuchoi' => $doanhso_tuchoi,
				'doanhso_cho_xacnhan' => $doanhso_cho_xacnhan,
				'booking_cho' => $booking_cho,
				'doanhso_cho' => $doanhso_cho
			);
			return json_encode($info);
		}
		///////////////////
		function thongke_dat_booking($conn, $user_id, $dau, $cuoi)
		{
			$skin = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$hoan_thanh = 0;
			$xac_nhan = 0;
			$tu_choi = 0;
			$huy = 0;
			$thongtin_booking = mysqli_query($conn, "SELECT * FROM list_booking WHERE user_dat='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_booking = mysqli_fetch_assoc($thongtin_booking)) {
				if ($r_booking['status'] == 1) {
					$hoan_thanh++;
					$doanhso_hoanthanh += $r_booking['gia'];
				} else if ($r_booking['status'] == 2) {
					$xac_nhan++;
					$doanhso_xacnhan += $r_booking['gia'];
				} else if ($r_booking['status'] == 3) {
					$tu_choi++;
					$doanhso_tuchoi += $r_booking['gia'];
				} else if ($r_booking['status'] == 0) {
					$cho_xacnhan++;
					$doanhso_cho_xacnhan += $r_booking['gia'];
				} else {
				}
			}
			$info = array(
				'booking_hoanthanh' => $hoan_thanh,
				'booking_xacnhan' => $xac_nhan,
				'booking_tuchoi' => $tu_choi,
				'booking_cho_xacnhan' => $cho_xacnhan,
				'doanhso_hoanthanh' => $doanhso_hoanthanh,
				'doanhso_xacnhan' => $doanhso_xacnhan,
				'doanhso_tuchoi' => $doanhso_tuchoi,
				'doanhso_cho_xacnhan' => $doanhso_cho_xacnhan,
			);
			return json_encode($info);
		}
		///////////////////
		function list_setting($conn, $page, $limit)
		{
			$tlca_skin_cpanel = $this->load('class_skin_cpanel');
			$check = $this->load('class_check');
			$start = $page * $limit - $limit;
			$i = $start;
			$thongtin = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['value'] = $check->words($r_tt['value'], 200);
				$list .= $tlca_skin_cpanel->skin_replace('skin_members/box_action/tr_setting', $r_tt);
			}
			return $list;
		}
		///////////////////////
		function phantrang($page, $total, $link)
		{
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
		function phantrang_timkiem($page, $total, $link)
		{
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
		///////////////////////
		function thanhvien_info($conn, $id)
		{
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
			$total = mysqli_num_rows($thongtin);
			if ($total == "0") {
				$r_tt = '';
			} else {
				$r_tt = mysqli_fetch_assoc($thongtin);
			}
			return $r_tt;
		}
		//////////////////////////
		function my_info($conn)
		{
			$thongtin = mysqli_query($conn, "SELECT * FROM e_min WHERE username='{$_SESSION['e_name']}'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			return $r_tt;
		}
		//////////////////////////////////////////////////////////////////
		function getIdByName($conn, $table, $column, $name) {
			
			$stmt = mysqli_prepare($conn, "SELECT id FROM $table WHERE LOWER($column) = LOWER(?)");
			mysqli_stmt_bind_param($stmt, "s", $name);    
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_assoc($result);
			mysqli_stmt_close($stmt);
			return $row ? $row['id'] : null;
		}

		function getPhiKethop($conn, $hang_tau, $ket_hop) {
			
			if ($ket_hop == 1) {
				$stmt = $conn->prepare("SELECT pk.phi FROM phi_kethop pk JOIN list_hangtau ht ON pk.hang_tau = ht.viet_tat WHERE ht.viet_tat = ?");
				$stmt->bind_param("s", $hang_tau);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				return $row ? $row['phi'] : 0; 
			}
			return 0; 
		}
	}
	?>
