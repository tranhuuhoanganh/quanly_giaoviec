<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 800px;padding: 10px;">
		<div class="page_title">
		    <h1 class="undefined">Lịch sử cộng điểm</h1>
		    <div class="line"></div>
		    <hr>
		</div>
		<style type="text/css">
			.list_baiviet i{
				font-size: 35px;
			}
		</style>
		<table class="list_baiviet">
			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;">Thời gian</th>
				<th style="text-align: left;">Thành viên</th>
				<th style="text-align: left;">Số điểm</th>
				<th style="text-align: left;">Nội dung</th>
			</tr>
			{list_tichdiem}
		</table>
		{phantrang}
  	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_tichdiem'){
                vitri=total_height - 200;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>