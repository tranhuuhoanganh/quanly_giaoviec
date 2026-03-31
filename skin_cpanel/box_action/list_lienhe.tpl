<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Danh sách liên hệ</span></div>
                <div class="list_hang" style="max-height: none;">
                    <table class="table_hang" style="width: 100%;" max-width="1000">
		                <tr>
		                    <th class="sticky-row" style="text-align: center;width: 50px;">STT</th>
		                    <th class="sticky-row">Họ và tên</th>
		                    <th class="sticky-row">Email</th>
		                    <th class="sticky-row">Điện thoại</th>
		                    <th class="sticky-row">Trạng thái</th>
		                    <th class="sticky-row">Thời gian</th>
		                    <th class="sticky-row sticky-column" style="text-align: center;width: 180px;" max-width="100">Hành động</th>
		                </tr>
                        {list_lienhe}
                    </table>
                    {phantrang}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    total_height = 0;
    $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
        total_height += $(this).outerHeight();
        if ($(this).attr('id') == 'menu_lienhe') {
            vitri = total_height - 200;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>