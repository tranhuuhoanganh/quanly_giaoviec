<div class="box_right">
    <div class="box_right_content">
        <div class="box_thongke">
        </div>
        <div class="box_timkiem">
            
       
       
        <div class="box_container">
            <div class="box_container_left" id="container_hangxuat" style="display: block;width: 100%;">
                <div class="title"><span><i class="fa fa-th"></i> Danh sách booking trả phí({total_hangxuat})</span></div>
                <div class="list_hang" id="list_hangxuat_user" style="overflow: auto;max-height: calc(100vh - 145px)" tiep='1' page='1' loaded="1">
                    <table class="table_hang" style="width: 1368px;" max-width="1364">
                        <tr>
                            <th class="sticky-row" width="50"></th>
                            <th class="sticky-row" width="100">Mã booking</th>
                            <th class="sticky-row" width="150">Hãng tàu</th>
                            <th class="sticky-row" width="100">Loại container</th>
                            <th class="sticky-row" width="100">Số lượng</th>
                            <th class="sticky-row" width="120">Mặt hàng</th>
                            <th class="sticky-row">Địa điểm đóng hàng</th>
                            <th class="sticky-row" width="150">Thời gian đóng hàng</th>
                            <th class="sticky-row" width="150">Loại hình</th>
                            <th class="sticky-row" width="150">Cước vận chuyển</th>
                            <th class="sticky-row sticky-column" width="120">Hành động</th>
                        </tr>
                        {list_hangxuat}
                    </table>
                </div>
            </div>
            
        </div>
    </div>
  </div>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
  <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/js/jquery.timepicker.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
    $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
    $.datepicker.setDefaults({
        closeText: "Đóng",
        prevText: "&#x3C;Trước",
        nextText: "Tiếp&#x3E;",
        currentText: "Hôm nay",
        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
        ],
        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
        ],
        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        weekHeader: "Tu",
        firstDay: 0,
        isRTL: false,
        minDate: "today",
        showMonthAfterYear: false,
        yearSuffix: ""
    });
  })
  </script>
  <script type="text/javascript">
  $(document).ready(function() {
    document.addEventListener("DOMContentLoaded", function() {
        var table = document.querySelector("table");
  
        table.addEventListener("scroll", function() {
            var leftStickyColumn = document.querySelector(".sticky-column");
            leftStickyColumn.style.transform = "translateX(" + (table.scrollLeft - 1) + "px)";
        });
    });
    total_height = 0;
    $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
        total_height += $(this).outerHeight();
        if ($(this).attr('id') == 'menu_lienket') {
            $(this).find('span i').removeClass('fa-plus-circle');
            $(this).find('span i').addClass('fa-minus-circle');
          vitri = total_height - 90;
          $('.menu_li.menu_quanly_dat_booking').show();
        }else{
          if($(this).find('span i').length>0){
            $(this).find('span i').removeClass('fa-minus-circle');
            $(this).find('span i').addClass('fa-plus-circle');
            $('.menu_li.'+$(this).attr('id')).hide();
          }
        }
    });
  });
  </script>