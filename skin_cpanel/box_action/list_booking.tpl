<div class="box_right">
    <div class="box_right_content">
        <div class="box_thongke">
        </div>
        <div class="box_timkiem">
            <div class="form_timkiem timkiem_user">
                <div class="li_input">
                    <div class="text">Loại hình</div>
                    <div class="select">
                        <select name="loai_hinh">
                            <option value="">Chọn loại hình</option>
                            <option value="hangxuat" selected="selected">Hàng xuất</option>
                            <option value="hangnhap">Hàng nhập</option>
                            <option value="hang_noidia">Hàng nội địa</option>
                        </select>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Hãng tàu</div>
                    <div class="select">
                        <input type="text" name="hang_tau" placeholder="Hãng tàu">
                        <input type="hidden" name="hang_tau_id">
                        <div class="list_goiy list_goiy_hangtau">{list_hangtau}</div>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Loại container</div>
                    <div class="select">
                        <select name="loai_container">
                            <option value="">Chọn loại</option>
                            {option_container}
                        </select>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Thời gian</div>
                    <div class="list_time">
                        <input type="text" name="from" placeholder="Từ" class="datepicker">
                        <input type="text" name="to" placeholder="Đến" class="datepicker">
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Đia điểm</div>
                    <div class="select">
                        <input type="text" name="dia_diem" placeholder="Địa điểm">
                        <input type="hidden" name="dia_diem_id">
                        <div class="list_goiy list_goiy_tinh">{list_tinh}</div>
                    </div>
                </div>
                <div class="button_search">
                    <button name="timkiem_booking_user"><i class="fa fa-search"></i> Tìm kiếm</button>
                </div>
            </div>
        </div>
        <div class="box_loai_hinh box_loai_hinh_user">
            <div class="li_loai_hinh">Hiển thị:</div>
            <div class="li_loai_hinh">
                <input type="radio" name="loai_hinh_hienthi" checked="checked" value="hangxuat" id="loai_hinh_xuat">
                <label for="loai_hinh_xuat">Hàng xuất</label>
            </div>
            <div class="li_loai_hinh">
                <input type="radio" name="loai_hinh_hienthi" value="hangnhap" id="loai_hinh_nhap">
                <label for="loai_hinh_nhap">Hàng nhập</label>
            </div>
            <div class="li_loai_hinh">
                <input type="radio" name="loai_hinh_hienthi" value="noidia" id="loai_hinh_noidia">
                <label for="loai_hinh_noidia">Hàng nội địa</label>
            </div>
        </div>
        <div class="box_container">
            <div class="box_container_left" id="container_hangxuat" style="display: block;width: 100%;">
                <div class="title"><span><i class="fa fa-th"></i> Hàng xuất({total_hangxuat})</span></div>
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
                            <th class="sticky-row" width="150">Cước vận chuyển</th>
                            <th class="sticky-row sticky-column" width="120">Hành động</th>
                        </tr>
                        {list_hangxuat}
                    </table>
                </div>
            </div>
            <div class="box_container_right" id="container_hangnhap" style="display: none;width: 100%;">
                <div class="title"><i class="fa fa-th"></i> Hàng nhập({total_hangnhap})</div>
                <div class="list_hang" id="list_hangnhap_user" style="overflow: auto;max-height: calc(100vh - 145px)" tiep='1' page='1' loaded="1">
                    <table class="table_hang" style="width: 1368px;" max-width="1364">
                        <tr>
                            <th class="sticky-row" width="50"></th>
                            <th class="sticky-row" width="100">Mã booking</th>
                            <th class="sticky-row" width="150">Hãng tàu</th>
                            <th class="sticky-row" width="100">Loại container</th>
                            <th class="sticky-row" width="100">Số lượng</th>
                            <th class="sticky-row" width="120">Mặt hàng</th>
                            <th class="sticky-row">Địa điểm trả hàng</th>
                            <th class="sticky-row" width="150">Thời gian trả hàng</th>
                            <th class="sticky-row" width="150">Cước vận chuyển</th>
                            <th class="sticky-row sticky-column" width="120">Hành động</th>
                        </tr>
                        {list_hangnhap}
                    </table>
                </div>
            </div>
            <div class="box_container_right" id="container_noidia" style="display: none;width: 100%;">
                <div class="title"><i class="fa fa-th"></i> Hàng nội địa({total_hang_noidia})</div>
                <div class="list_hang" id="list_hang_noidia_user" style="overflow: auto;max-height: calc(100vh - 145px)" tiep='1' page='1' loaded="1">
                    <table class="table_hang" style="width: 1368px;" max-width="1364">
                        <tr>
                            <th class="sticky-row" width="50"></th>
                            <th class="sticky-row" width="100">Loại container</th>
                            <th class="sticky-row" width="100">Số lượng</th>
                            <th class="sticky-row" width="120">Mặt hàng</th>
                            <th class="sticky-row">Địa điểm đóng hàng</th>
                            <th class="sticky-row" width="150">Thời gian đóng hàng</th>
                            <th class="sticky-row">Địa điểm trả hàng</th>
                            <th class="sticky-row" width="150">Cước vận chuyển</th>
                            <th class="sticky-row sticky-column" width="120">Hành động</th>
                        </tr>
                        {list_hang_noidia}
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