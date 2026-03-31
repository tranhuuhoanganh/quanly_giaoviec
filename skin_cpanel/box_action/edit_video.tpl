<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 465px;margin: auto;">
                <div class="title"><span class="text"><i class="fa fa-th"></i> Chỉnh sửa video</span></div>
                <div class="box_form">
                    <div class="list_tab_content">
                        <div class="li_tab_content active" id="tab_hangnhap_content">
                            <div class="li_input">
                                <div class="khung_mh">
                                    <div class="mh" style="cursor: pointer;">
                                        <img src="{minh_hoa}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                                    </div>
                                    <button id="chon_anh">Chọn ảnh</button>
                                    <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                                </div>
                            </div>
                            <div class="li_input">
                                <label>Tiêu đề(*)</label>
                                <input type="text" name="tieu_de" value="{tieu_de}" placeholder="Nhập tiêu đề video" autocomplete="off">
                            </div>
                            <div class="li_input">
                                <label>Link video(*)</label>
                                <input type="text" name="link_video" value="{link_video}" placeholder="Nhập link video youtube" autocomplete="off">
                            </div>
                            <div class="list_button">
                                <input type="hidden" name="id" value="{id}">
                                <button name="edit_video">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('select[name=status]').val('{status}');
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
    total_height = 0;
    $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
        total_height += $(this).outerHeight();
        if ($(this).attr('id') == 'menu_video') {
            vitri = total_height - 90;
        }
    });
    $('.box_menu_left').animate({ scrollTop: vitri }, 1000);
});
</script>