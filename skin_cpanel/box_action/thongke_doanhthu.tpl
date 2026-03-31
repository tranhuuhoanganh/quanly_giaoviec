<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 800px;padding: 10px;">
        <div class="box_time">
            <h2>Chọn khoảng thời gian</h2>
            <div class="list_time">
                <div class="li_time">
                    <label>Thời gian bắt đầu</label>
                    <input type="text" class="datepicker" value="{begin}" name="begin" placeholder="Chọn thời gian bắt đầu">
                </div>
                <div class="li_time">
                    <label>Thời gian kết thúc</label>
                    <input type="text" class="datepicker" value="{end}" name="end" placeholder="Chọn thời gian kết thúc">       
                </div>
                <div class="li_time">
                    <button name="button_doanhthu">Áp dụng</button>
                </div>
            </div>
        </div>
        <div class="box_result">
            <div class="li_box">
                <h3 class="color_green">Đơn hàng hoàn thành</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_hoanthanh">{doanhthu_hoanthanh} đ</div>
                        <div class="text_donhang" id="donhang_hoanthanh"> với {donhang_hoanthanh} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_green"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_brown">Đơn hàng chờ xử lý</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_cho">{doanhthu_cho} đ</div>
                        <div class="text_donhang" id="donhang_cho"> với {donhang_cho} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_brown"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_violet">Đơn hàng đã tiếp nhận</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_tiepnhan">{doanhthu_tiepnhan} đ</div>
                        <div class="text_donhang" id="donhang_tiepnhan"> với {donhang_tiepnhan} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_violet"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_orange">Đơn hàng đang giao</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_giao">{doanhthu_giao} đ</div>
                        <div class="text_donhang" id="donhang_giao"> với {donhang_giao} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_red">Đơn hàng hủy</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_huy">{doanhthu_huy} đ</div>
                        <div class="text_donhang" id="donhang_huy"> với {donhang_huy} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_red"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_blue">Đơn hàng hoàn trả</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_hoan">{doanhthu_hoan} đ</div>
                        <div class="text_donhang" id="donhang_hoan">với {donhang_hoan} đơn hàng</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_blue"></i>
                        </div>
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
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_thongke'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>