<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Danh sách cài đặt</span></div>
                <div class="list_hang" style="max-height: none;">
                    <table class="table_hang" style="width: 100%;" max-width="800">
                        <tr>
                            <th class="sticky-row" width="80">STT</th>
                            <th class="sticky-row" style="text-align: left;">Mục</th>
                            <th class="sticky-row" style="text-align: left;">Giá trị</th>
                            <th class="sticky-row sticky-column" width="120">Hành động</th>
                        </tr>
                        {list_setting}
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
        if ($(this).attr('id') == 'menu_caidat') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>