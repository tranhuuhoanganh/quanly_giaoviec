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
                            <div class="col_input col_2">
                                <div class="li_input">
                                    <label>Số booking(*)</label>
                                    <input type="text" name="so_booking" value="{so_booking}" placeholder="Nhập số booking" autocomplete="off">
                                </div>
                                <div class="li_input">
                                    <label>File booking(*)</label>
                                    <div class="khung_file">
                                        <input type="file" name="file_booking">
                                        <button class="chon_file">Chọn file</button>
                                        <div class="file_name">{file_booking}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col_input col_2">
                                <div class="li_input">
                                    <label>Hãng tàu(*)</label>
                                    <select name="hang_tau">
                                        <option value="">Chọn hãng tàu</option>
                                        {option_hangtau}
                                    </select>
                                </div>
                                <div class="li_input">
                                    <label>Loại container(*)</label>
                                    <select name="loai_container">
                                        <option value="">Chọn loại container</option>
                                        {option_container}
                                    </select>
                                </div>
                            </div>
                            <div class="li_input">
                                <label>Địa chỉ đóng hàng(*)</label>
                                <input type="text" name="diachi_donghang" value="{diachi_donghang}" placeholder="Nhập địa chỉ đóng hàng" autocomplete="off">
                            </div>
                            <div class="col_input col_3">
                                <div class="li_input">
                                    <label>Tỉnh/TP(*)</label>
                                    <select name="tinh">
                                        <option value="">Chọn tỉnh/tp</option>
                                        {option_tinh}
                                    </select>
                                </div>
                                <div class="li_input">
                                    <label>Quận/Huyện(*)</label>
                                    <select name="huyen">
                                        <option value="">Chọn quận/huyện</option>
                                        {option_huyen}
                                    </select>
                                </div>
                                <div class="li_input">
                                    <label>Xã/Thị Trấn(*)</label>
                                    <select name="xa">
                                        <option value="">Chọn xã/thị trấn</option>
                                        {option_xa}
                                    </select>
                                </div>
                            </div>
                            <div class="li_input">
                                <label>Địa chỉ trả hàng(*)</label>
                                <select name="diachi_trahang">
                                    <option value="">Chọn cảng</option>
                                    {option_cang}
                                </select>
                            </div>
                            <div class="li_input">
                                <label>Mặt hàng(*)</label>
                                <div class="list_checkbox">
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="May mặc">
                                        <label>May mặc</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="Thực phẩm">
                                        <label>Thực phẩm</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="Thiết bị điện tử">
                                        <label>Thiết bị điện tử</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="Linh kiện">
                                        <label>Linh kiện</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="Máy móc">
                                        <label>Máy móc</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="Nguyên vật liệu">
                                        <label>Nguyên vật liệu</label>
                                    </div>
                                    <div class="li_checkbox">
                                        <input type="radio" name="mat_hang" value="khac">
                                        <label class="khac">Khác</label>
                                        <input type="text" class="khac" name="mat_hang_khac" value="{mat_hang_khac}" placeholder="Nhập tên mặt hàng khác">
                                    </div>
                                </div>
                            </div>
                            <div class="col_input col_3">
                                <div class="li_input">
                                    <label>Số lượng container(*)</label>
                                    <input type="number" name="so_luong" value="{so_luong}" class="sl_container_edit" placeholder="Nhập số lượng container" autocomplete="off">
                                </div>
                                <div class="li_input">
                                    <label>Trọng lượng/container(*)</label>
                                    <input type="number" name="trong_luong" value="{trong_luong}" placeholder="Đơn vị tấn" autocomplete="off">
                                </div>
                                <div class="li_input">
                                    <label>Cước vận chuyển/container(*)</label>
                                    <input type="text" name="gia" value="{gia}" class="price_format" placeholder="Nhập cước vận chuyển cho 1 container" autocomplete="off">
                                </div>
                            </div>
                            <div class="li_input" id="input_container">
                                <label>Danh sách container(*)</label>
                                <div class="list_container">{list_container}</div>
                            </div>
                            <div class="li_input">
                                <label>Ghi chú</label>
                                <textarea name="ghi_chu" placeholder="Nội dung ghi chú" autocomplete="off">{ghi_chu}</textarea>
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
        showMonthAfterYear: false,
        yearSuffix: ""
    });
})
</script>
<script type="text/javascript">
$(document).ready(function() {
    mat_hang = '{mat_hang}';
    $("input[name=mat_hang][value='{mat_hang}']").prop('checked', true);
    if (mat_hang == 'khac') {
        $('input[name=mat_hang_khac]').show();
    }
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