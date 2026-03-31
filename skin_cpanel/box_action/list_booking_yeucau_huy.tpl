<div class="box_right">
    <div class="box_right_content">
      <div class="box_container">
<!--         <div class="box_search">
            <div class="li_input" style="width: 250px;">
                <input type="text" name="cong_ty" placeholder="Công ty" style="width: 250px;">
                <div class="list_goiy list_goiy_congty">{list_congty}</div>
            </div>
            <div class="li_input">
                <select name="loai_hinh">
                    <option value="">Loại hình</option>
                    <option value="hangxuat">Hàng xuất</option>
                    <option value="hangnhap">Hàng nhập</option>
                    <option value="hang_noidia">Hàng nội địa</option>
                </select>
            </div>
            <div class="li_input" style="width: 100px;">
                <input type="text" style="width: 100px;" class="datepicker" name="from" placeholder="Từ ngày...">
            </div>
            <div class="li_input" style="width: 100px;">
                <input type="text" style="width: 100px;" class="datepicker" name="to" placeholder="Đến ngày...">
            </div>
            <button id="timkiem_booking_confirm">Tìm kiếm</button>
        </div> -->
        <div class="box_container_left" style="width: 100%;">
          <div class="title"><span class="text"><i class="fa fa-th"></i> Booking yêu cầu hủy</span></div>
          <div class="list_hang" style="max-height: none;" tiep='1' page='1' loaded="1">
            <table class="table_hang" style="width: 100%;">
              <tr>
                <th class="sticky-row" width="50">STT</th>
                <th class="sticky-row" width="120">Thời gian</th>
                <th class="sticky-row" width="150">Người yêu cầu</th>
                <th class="sticky-row" width="120">Điện thoại</th>
                <th class="sticky-row">Booking</th>
                <th class="sticky-row">Số hiệu container</th>
                <th class="sticky-row">Lý do</th>
                <th class="sticky-row" width="120">Trạng thái</th>
                <th class="sticky-row sticky-column" width="130"  max-width="100">Hành động</th>
              </tr>
              {list_booking}
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
        if ($(this).attr('id') == 'menu_quanly_booking') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>