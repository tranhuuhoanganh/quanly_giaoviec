<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile">
            <div class="page_title">
                <h1 class="undefined">Chi tiết liên hệ</h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="col_100">
                <div class="form_group">
                    <label for="" class="bold">Họ tên:</label>
                    {ho_ten}
                </div>
                <div class="form_group">
                    <label for="" class="bold">Email:</label>
                    {email}
                </div>
                <div class="form_group">
                    <label for="" class="bold">Điện thoại:</label>
                    {dien_thoai}
                </div>
                <div class="form_group">
                    <label for="" class="bold">Nội dung:</label>
                    <div>{noi_dung}</div>
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
            if($(this).attr('id')=='menu_lienhe'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>