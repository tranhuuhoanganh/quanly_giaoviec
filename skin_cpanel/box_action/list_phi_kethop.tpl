<div class="box_right">
    <div class="box_right_content">
      <div class="box_container">
        <div class="box_container_left" style="width: 100%;">
          <div class="title"><span class="text"><i class="fa fa-th"></i> Danh sách phí kết hợp</span><button onclick="show_add('phi_kethop','');"><i class="fa fa-plus"></i> Thêm mới</button></div>
          <div class="list_hang" style="max-height: none;">
            <table class="table_hang" style="width: 100%;" max-width="1000">
              <tr>
                <th class="sticky-row" width="80">STT</th>
                <th class="sticky-row" width="150">Hãng tàu</th>
                <th class="sticky-row">Phí kết hợp</th>
                <th class="sticky-row sticky-column" width="180" max-width="100">Hành động</th>
              </tr>
              {list_phi_kethop}
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
    $(document).ready(function(){
        $(".datepicker" ).datepicker({dateFormat: 'dd/mm/yy',changeMonth: true,changeYear: true});
        $('input.timepicker').timepicker({'timeFormat': 'H:i:s','step': 5});
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
        if ($(this).attr('id') == 'menu_sanpham') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>