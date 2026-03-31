<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Lịch sử nạp tiền</span></div>
                <div class="list_hang" style="max-height: none;">
                    <table class="table_hang" style="width: 100%;" max-width="800">
		                <tr>
		                    <th class="sticky-row" style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
		                    <th class="sticky-row" max-width="100">Thời gian</th>
		                    <th class="sticky-row">Thành viên</th>
		                    <th class="sticky-row">Điện thoại</th>
		                    <th class="sticky-row">Số tiền</th>
		                    <th class="sticky-row" style="text-align: left;">Nội dung chuyển khoản</th>
		                    <th class="sticky-row">Trạng thái</th>
		                    <th class="sticky-row sticky-column" style="text-align: center;width: 120px;" max-width="80">Hành động</th>
		                </tr>
                        {list_naptien}
                    </table>
                </div>
                {phantrang}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    total_height = 0;
    $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
        total_height += $(this).outerHeight();
        if ($(this).attr('id') == 'menu_naptien') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>