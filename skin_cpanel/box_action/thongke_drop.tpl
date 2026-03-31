<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 800px;padding: 10px;">
        <div class="box_time">
            <h2>Thành viên chính thức</h2>
            <div class="list_time" style="text-align: center;color: #f00;font-weight: 700;justify-content: center;font-size: 25px;">
                {total_chinhthuc}
            </div>
        </div>
        <div class="box_result">
            <div class="li_box">
                <h3 class="color_violet">Drop đăng ký hôm qua({homqua})</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_hoanthanh">{total_dangky_homqua} thành viên</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-user bg_violet"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_orange">Drop Nạp Tiền hôm qua({homqua})</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_huy">{total_nap_homqua} thành viên({total_giaodich_homqua} giao dịch)</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_orange"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_green">Drop đăng ký hôm nay(<?php echo date('d/m/Y');?>)</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_hoanthanh">{total_dangky} thành viên</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-user bg_green"></i>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="li_box">
                <h3 class="color_red">Drop Nạp Tiền hôm nay(<?php echo date('d/m/Y');?>)</h3>
                <div class="li_box_content">
                    <div class="li_box_left">
                        <div class="text_doanhthu" id="doanhthu_huy">{total_nap} thành viên({total_giaodich} giao dịch)</div>
                    </div>
                    <div class="li_box_right">
                        <div class="li_box_right_content">
                            <i class="fa fa-dollar bg_red"></i>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="box_time">
            <h2>DROP có đơn hàng</h2>
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
                    <button name="button_thongke_drop">Áp dụng</button>
                </div>
            </div>
        </div>
        <div class="box_result">
            <table class="list_baiviet">
                <tr>
                    <th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
                    <th style="text-align: left;">Tài khoản</th>
                    <th style="text-align: left;">Điện thoại</th>
                    <th style="text-align: left;">Họ và tên</th>
                    <th style="text-align: center;width: 100px;">Tổng đơn</th>
                    <th style="text-align: center;">Doanh số</th>
                    <th style="text-align: center;width: 150px;">Hành động</th>
                </tr>
                {list}
            </table>
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