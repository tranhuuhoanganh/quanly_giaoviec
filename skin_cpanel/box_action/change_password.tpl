<div class="box_right">
  <div class="box_right_content">
    <div class="box_container">
        <div class="box_container_left" style="width: 465px;margin: auto;">
          <div class="title"><span class="text"><i class="fa fa-th"></i> Đổi mật khẩu mới</span></div>
          <div class="box_form">
            <div class="list_tab_content">
                <div class="li_tab_content active" id="tab_hangnhap_content">
                    <div class="li_input">
                        <label>Mật khẩu hiện tại(*)</label>
                        <input type="password" name="password_old" placeholder="Nhập mật khẩu hiện tại" autocomplete="off">
                    </div>
                    <div class="li_input">
                        <label>Mật khẩu mới(*)</label>
                        <input type="password" name="password" placeholder="Nhập mật khẩu mới..." autocomplete="off">
                    </div>
                    <div class="li_input">
                        <label>Nhập lại mật khẩu mới(*)</label>
                        <input type="password" name="confirm" placeholder="Nhập lại mật khẩu mới..." autocomplete="off">
                    </div>
	                <div class="li_input">
	                  <i>Lưu ý: Mật khẩu phải dài từ 6 ký tự</i>
	                </div>
                    <div class="list_button">
                        <button name="button_password">Lưu thay đổi</button>
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