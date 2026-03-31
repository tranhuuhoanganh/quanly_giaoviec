<div class="box_right">
  <div class="box_right_content">
	<div class="box_container">
		<div class="box_container_left" style="width: 100%;margin: auto;">
		  <div class="title"><span class="text"><i class="fa fa-th"></i> Video hướng dẫn</span></div>
		  <div class="list_hang" style="max-height: none;">
		  	<div class="list_video">{list_video}</div>
		  </div>
		  {phantrang}
		</div>
	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
            total_height += $(this).outerHeight();
            if ($(this).attr('id') == 'menu_video') {
                $(this).find('span i').removeClass('fa-plus-circle');
                $(this).find('span i').addClass('fa-minus-circle');
              vitri = total_height - 90;
              $('.menu_li.menu_video').show();
            }else{
              if($(this).find('span i').length>0){
                $(this).find('span i').removeClass('fa-minus-circle');
                $(this).find('span i').addClass('fa-plus-circle');
                $('.menu_li.'+$(this).attr('id')).hide();
              }
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>