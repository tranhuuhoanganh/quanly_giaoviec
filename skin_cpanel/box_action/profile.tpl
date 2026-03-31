<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 465px;margin: auto;">
              <div class="title"><span class="text"><i class="fa fa-th"></i> Thông tin cá nhân</span></div>
              <div class="box_form">
                <div class="list_tab_content">
                    <div class="li_tab_content active" id="tab_hangnhap_content">
                        <div class="li_input">
                            <div class="khung_mh">
                                <div class="mh" style="cursor: pointer;">
                                    <img src="{avatar}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                                </div>
                                <button id="chon_anh">Chọn ảnh đại diện</button>
                                <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                            </div>
                        </div>
                        <div class="li_input">
                            <label>Tài khoản</label>
                            <input type="text" name="username" value="{username}" disabled="disabled" autocomplete="off">
                        </div>
                        <div class="li_input">
                            <label>Họ và tên(*)</label>
                            <input type="text" name="name" value="{name}" placeholder="Nhập họ và tên đầy đủ của bạn..." autocomplete="off">
                        </div>
                        <div class="li_input">
                            <label>Điện thoại(*)</label>
                            <input type="text" name="mobile" value="{mobile}" placeholder="Nhập số điện thoại" autocomplete="off">
                        </div>
                        <div class="li_input">
                            <label>Email(*)</label>
                            <input type="text" name="email" value="{email}" placeholder="Nhập địa chỉ email" autocomplete="off">
                        </div>
                        <div class="list_button">
                            <button name="button_profile">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_canhan'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>