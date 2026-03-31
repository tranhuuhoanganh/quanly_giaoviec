<div class="box_right">
  <div class="box_right_content">
      <div class="box_container">
        <div class="box_container_left" style="width: 100%;">
          <div class="title"><span class="text"><i class="fa fa-th"></i> Danh sách video</span></div>
          <div class="list_hang" style="max-height: none;">
            <table class="table_hang" style="width: 100%;" max-width="1364">
              <tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="150">Minh họa</th>
                <th class="sticky-row" width="350" style="text-align: left;">Tiêu đề</th>
                <th class="sticky-row">Link video</th>
                <th class="sticky-row" width="100">Lượt xem</th>
                <th class="sticky-row sticky-column" width="180" max-width="100">Hành động</th>
              </tr>
              {list_video}
            </table>
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
            if($(this).attr('id')=='menu_video'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>