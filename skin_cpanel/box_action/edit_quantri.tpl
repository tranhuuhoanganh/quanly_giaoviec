<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 800px;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Chỉnh sửa quản trị viên</span></div>
                <div class="box_form">
                    <div class="list_tab_content">
                        <div class="li_tab_content active" id="tab_hangnhap_content">
                            <div class="li_input">
                                <label>Tài khoản(*)</label>
                                <input type="text" name="username" value="{username}" placeholder="Nhập tài khoản đăng nhập" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Mật khẩu(*)</label>
                                <input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Xác nhận mật khẩu(*)</label>
                                <input type="password" name="re_password" placeholder="Nhập lại mật khẩu đăng nhập" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Họ và tên(*)</label>
                                <input type="text" name="ho_ten" value="{name}" placeholder="Nhập họ và tên" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Điện thoại(*)</label>
                                <input type="text" name="dien_thoai" value="{mobile}" placeholder="Nhập số điện thoại liên hệ" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Email(*)</label>
                                <input type="text" name="email" value="{email}" placeholder="Nhập địa chỉ email" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Phân quyền(*)</label>
                                <div class="list_checkbox">
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="video" id="box_video">
                                        <label for="box_video">Quản lý video</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="booking" id="box_booking">
                                        <label for="box_booking">Quản lý booking</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="naptien" id="box_naptien">
                                        <label for="box_naptien">Quản lý nạp tiền</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="thanhvien" id="box_thanhvien">
                                        <label for="box_thanhvien">Quản lý thành viên</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="quantri" id="box_quantri">
                                        <label for="box_quantri">Quản lý quản trị viên</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="giahan" id="box_giahan">
                                        <label for="box_giahan">Quản lý gói gia hạn</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="hangtau" id="box_hangtau">
                                        <label for="box_hangtau">Quản lý hãng tàu</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="loai_container" id="box_loai_container">
                                        <label for="box_loai_container">Quản lý loại container</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="cang" id="box_cang">
                                        <label for="box_cang">Quản lý cảng</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="tinh" id="box_tinh">
                                        <label for="box_tinh">Quản lý Tỉnh/TP</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="danhgia" id="box_danhgia">
                                        <label for="box_danhgia">Quản lý đánh giá</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="checkbox" name="phanquyen[]" value="lienhe" id="box_lienhe">
                                        <label for="box_lienhe">Quản lý liên hệ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="list_button">
                                <input type="hidden" name="id" value="{user_id}">
                                <button name="edit_quantri">Lưu thay đổi</button>
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
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    {list_group}
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
    $('input.timepicker').timepicker({ 'timeFormat': 'H:i:s', 'step': 5 });
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
        if ($(this).attr('id') == 'menu_naptien') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>