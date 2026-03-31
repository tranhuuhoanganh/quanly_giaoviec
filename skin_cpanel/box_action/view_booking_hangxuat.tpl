<div class="box_right">
    <div class="box_right_content">
      <div class="box_container">
          <div class="box_container_left" style="width: 100%;">
              <div class="title"><span class="text"><i class="fa fa-th"></i> Thông tin người đăng</span></div>
              <div class="box_form">
                  <div class="list_tab_content">
                      <div class="li_tab_content active" id="tab_hangnhap_content">
                          <div class="li_input">
                              <label>Công ty</label>
                              {cong_ty}
                          </div>
                          <div class="li_input">
                              <label>Mã số thuế</label>
                              {maso_thue}
                          </div>
                          <div class="col_input col_3">
                              <div class="li_input">
                                  <label>Họ và tên</label>
                                  {ho_ten}
                              </div>
                              <div class="li_input">
                                  <label>Điện thoại</label>
                                  {dien_thoai}
                              </div>
                              <div class="li_input">
                                  <label>Email</label>
                                  {email}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        <div class="box_container_left" style="width: 100%;">
          <div class="title"><span class="text"><i class="fa fa-th"></i> Chi tiết booking</span></div>
          <div class="box_form">
          	<div class="list_tab_content">
          		<div class="li_tab_content active" id="tab_hangxuat_content">
                <table class="bang_info">
                  <tr>
                    <td width="180" class="text">Số booking</td>
                    <td class="info">{so_booking}</td>
                  </tr>
                  <tr>
                    <td class="text">Hãng tàu</td>
                    <td class="info">{hang_tau}</td>
                  </tr>
                  <tr>
                    <td class="text">Loại container</td>
                    <td class="info">{loai_container}</td>
                  </tr>
                  <tr>
                    <td class="text">Địa chỉ đóng hàng</td>
                    <td class="info">
                      <table>
                        <tr>
                          <td class="info">{diachi_donghang}</td>
                          <td class="text">{xa}</td>
                          <td class="text">{huyen}</td>
                          <td class="text">{tinh}</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td class="text">Địa chỉ trả hàng(cảng)</td>
                    <td class="info">{diachi_trahang}</td>
                  </tr>
                  <tr>
                    <td class="text">Thời gian trả hàng</td>
                    <td class="info">{thoi_gian} {ngay}</td>
                  </tr>
                  <tr>
                    <td class="text">Mặt hàng</td>
                    <td class="info">{mat_hang}</td>
                  </tr>
                  <tr>
                    <td class="text">Trọng lượng</td>
                    <td class="info">{trong_luong}</td>
                  </tr>
                  <tr>
                    <td class="text">Cước vận chuyển</td>
                    <td class="info color_red"><b>{gia} đ</b></td>
                  </tr>
                  <tr>
                    <td class="text">Phí booking</td>
                    <td class="info"><b class="color_red">{phi_booking} đ</b>(sẽ được hoàn lại nếu booking của bạn bị từ chối)</td>
                  </tr>
                  <tr>
                    <td class="text">Ghi chú</td>
                    <td class="info">{ghi_chu}</td>
                  </tr>
                </table>
          		</div>
          	</div>
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