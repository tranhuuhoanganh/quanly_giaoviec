<script type="text/javascript" src="/tinymce_4.4.3/tinymce.min.js"></script>
<script type="text/javascript">
var Notepad = Notepad || {};
tinymce.init({
    selector: '#edit_textarea',
    mode: "exact",
    theme: "modern",
    fontsize_formats: "8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 36pt",
    plugins: ["advlist autolink code lists link image hr wordcount fullscreen media emoticons textcolor searchreplace"],
    toolbar1: "undo redo forecolor fontselect | fontsizeselect | bold italic | alignleft aligncenter | bullist numlist | image searchreplace code | removeformat fullscreen",
    image_advtab: true,
    menubar: false,
    height: '250px',
    tabindex: 2,
    relative_urls: false,
    browser_spellcheck: true,
    forced_root_block: false,
    entity_encoding: "raw",
    setup: function(ed) {
        ed.on('init', function() { this.getDoc().body.style.fontSize = '14px'; });
        ed.on('keydown', function() {
            // viet lệnh ở đây
        });
    }
});
</script>
<style type="text/css">
.list_baiviet i {
    font-size: 35px;
}
</style>
<div class="box_right">
    <div class="box_right_content">
        <div class="box_profile" id="tab_thongtin_content" style="width: 100%;padding: 10px;">
            <div class="page_title">
                <h1 class="undefined">Thông tin thành viên <span class="color_green">{username}</span></h1>
                <div class="line"></div>
                <hr>
            </div>
            <div class="list_tab_member">
                <div class="li_tab_member active" id="tab_taikhoan">Tài khoản</div>
                <div class="li_tab_member" id="tab_order">Lịch sử Đặt hàng</div>
                <div class="li_tab_member" id="tab_nap">Lịch sử nạp tiền</div>
                <div class="li_tab_member" id="tab_rut">Lịch sử rút tiền</div>
                <div class="li_tab_member" id="tab_chitieu">Lịch sử chi tiêu</div>
                <div class="li_tab_member" id="tab_hoandon">Lịch sử hoàn đơn</div>
            </div>
            <div class="list_tab_content">
                <div class="li_tab_content active" id="tab_taikhoan_content">
                    <div style="width: 50%;">
                        <div class="form_group">
                            <label for="">Email</label>
                            <input type="text" class="form_control" name="email" value="{email}" disabled="" placeholder="Nhập email...">
                        </div>
                        <div class="form_group">
                            <label for="">Họ và tên</label>
                            <input type="text" class="form_control" name="name" value="{name}" placeholder="Nhập họ và tên...">
                        </div>
                        <div class="form_group">
                            <label for="">Nhóm: <span class="color_red">{ten_nhom}</span></label>
                        </div>
                        <div class="form_group">
                            <label for="">Số dư: <span class="color_red">{user_money} đ</span></label>
                        </div>
                        <div class="form_group">
                            <label for="">Khuyến Mại: <span class="color_red">{user_money2} đ</span></label>
                        </div>
                        <div class="form_group">
                            <label for="">Điện thoại</label>
                            <input type="text" class="form_control" name="dien_thoai" value="{mobile}" placeholder="Nhập số điện thoại...">
                        </div>
                        <div class="form_group">
                            <label for="">Ảnh đại diện</label>
                            <div style="clear: both;"></div>
                            <div class="mh" style="cursor: pointer;">
                                <img src="{avatar}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                            </div>
                            <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
                        </div>
                        <div class="form_group">
                            <label for="">Tình trạng</label>
                            <select class="form_control" name="active">
                                <option value="1">Bình thường</option>
                                <option value="2">Tạm khóa</option>
                                <option value="3">Khóa vĩnh viễn</option>
                            </select>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form_group">
                        <input type="hidden" name="id" value="{user_id}">
                        <button class="button_all" name="edit_thanhvien"> Lưu lại </button>
                    </div>
                </div>
                <div class="li_tab_content" id="tab_order_content" page="1" load="1">
                    <table class="list_baiviet">
                        <tr>
                            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                            <th style="text-align: left;">Mã đơn</th>
                            <th style="text-align: left;" class="hide_mobile">Ngày</th>
                            <th style="text-align: left;">ĐT TV</th>
                            <th style="text-align: left;width: 150px;">Tên thành viên</th>
                            <th style="text-align: left;">Điện thoại</th>
                            <th style="text-align: left;width: 150px;">Họ và tên</th>
                            <th style="text-align: center;">Sản phẩm</th>
                            <th style="text-align: left;" class="hide_mobile">Giá trị</th>
                            <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                            <th style="text-align: center;width: 225px;">Hành động</th>
                        </tr>
                    </table>
                </div>
                <div class="li_tab_content" id="tab_nap_content" page="1" load="1">
                    <table class="list_baiviet">
                        <tr>
                            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                            <th style="text-align: left;">Thời gian</th>
                            <th style="text-align: left;">Thành viên</th>
                            <th style="text-align: left;">Điện thoại</th>
                            <th style="text-align: left;">Số tiền</th>
                            <th style="text-align: left;">Nội dung chuyển khoản</th>
                            <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                            <th style="text-align: center;width: 120px;">Hành động</th>
                        </tr>
                    </table>
                </div>
                <div class="li_tab_content" id="tab_rut_content" page="1" load="1">
                    <table class="list_baiviet">
                        <tr>
                            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                            <th style="text-align: left;">Thời gian</th>
                            <th style="text-align: left;">Thành viên</th>
                            <th style="text-align: left;">Số tiền</th>
                            <th style="text-align: left;">Chủ khoản</th>
                            <th style="text-align: left;">Số tài khoản</th>
                            <th style="text-align: left;">Ngân hàng</th>
                            <th style="text-align: center;" class="hide_mobile">Trạng thái</th>
                            <th style="text-align: center;width: 120px;">Hành động</th>
                        </tr>
                    </table>
                </div>
                <div class="li_tab_content" id="tab_chitieu_content" page="1" load="1">
                    <table class="list_baiviet">
                        <tr>
                            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                            <th style="text-align: left;">Thời gian</th>
                            <th style="text-align: left;">Thành viên</th>
                            <th style="text-align: left;">Điện thoại</th>
                            <th style="text-align: left;">Số tiền</th>
                            <th style="text-align: left;">Số dư trước</th>
                            <th style="text-align: left;">Số dư sau</th>
                            <th style="text-align: left;">Nội dung chi tiêu</th>
                        </tr>
                    </table>
                </div>
                <div class="li_tab_content" id="tab_hoandon_content" page="1" load="1">
                    <table class="list_baiviet">
                        <tr>
                            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
                            <th style="text-align: left;">Mã đơn</th>
                            <th style="text-align: left;" class="hide_mobile">Ngày</th>
                            <th style="text-align: left;">ĐT TV</th>
                            <th style="text-align: left;width: 150px;">Tên thành viên</th>
                            <th style="text-align: left;">Điện thoại</th>
                            <th style="text-align: left;width: 150px;">Họ và tên</th>
                            <th style="text-align: center;">Sản phẩm</th>
                            <th style="text-align: left;" class="hide_mobile">Giá trị</th>
                            <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
                            <th style="text-align: center;width: 140px;">Hành động</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    var active='{active}';
	    $('select[name=active]').val(active); 
        var loai='{loai}';
        $('select[name=loai]').val(loai); 

	});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_thanhvien'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>