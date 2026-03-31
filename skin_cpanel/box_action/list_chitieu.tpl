<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Lịch sử chi tiêu</span></div>
                <div class="list_hang" style="max-height: none;">
                    <table class="table_hang" style="width: 100%;" max-width="1000">
                        <tr>
                            <th style="text-align: center;width: 50px;">STT</th>
                            <th class="sticky-row" style="text-align: center;" max-width="100">Thời gian</th>
                            <th class="sticky-row" style="text-align: center;">Thành viên</th>
                            <th class="sticky-row" style="text-align: center;">Điện thoại</th>
                            <th class="sticky-row" style="text-align: center;">Số tiền</th>
                            <th class="sticky-row" style="text-align: center;width: 120px;">Số dư trước</th>
                            <th class="sticky-row" style="text-align: center;width: 120px;">Số dư sau</th>
                            <th class="sticky-row" style="text-align: left;">Nội dung chi tiêu</th>
                        </tr>
                        {list_chitieu}
                    </table>
                </div>
                {phantrang}
                <p style="font-style: italic;">Lưu ý: Số dư trước là tổng số tiền của tài khoản chính và tài khoản khuyến mại trước giao dịch.<br>Số dư sau là tổng số tiền của tài khoản chính và tài khoản khuyến mại sau giao dịch.</p>
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