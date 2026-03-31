{header}
<body>
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
<div class="box_right">
    <div class="box_right_content">
        <div class="container_member" style="width: 1000px;">
            <div class="li_input_line">
                <div class="col_50">
                    <div class="tieu_ngu">{co_quan}</div>
                    <div class="tieu_ngu">{don_vi}</div>
                    <hr style="width:30%;margin-top: 0%; border-top-color: black;margin-bottom: 0px">
                </div>
                <div class="col_50">
                    <div class="tieu_ngu">
                        Cộng hòa xã hội chủ nghĩa Việt Nam
                    </div>
                    <div class="tieu_ngu_2">Độc lập - Tự do - Hạnh phúc</div>
                    <hr style="width:30%;margin-top: 0%; border-top-color: black;margin-bottom: 0px">
                </div>
            </div>
            <div class="li_input_line">
                <div class="col_50">
                    <div class="text_center">Số: {so_hieu}</div>
                    <div class="text_center">V/v: {vv}</div>
                </div>
                <div class="col_50">
                    <div class="text_center"><i>{dia_danh}, ngày {ngay} tháng {thang} năm {nam}</i></div>
                </div>
            </div>
            <div class="li_input_line" style="margin-top: 20px;">
                <div class="col_100">
                    <div class="text_center" style="font-size: 18px; font-weight: 700;">Kính gửi: {kinh_gui}</div>
                </div>
            </div>
            <h2 class="title_muc_2">1. Thông tin người đăng ký thư điện tử công vụ (@sonla.gov.vn)</h2>
            <div class="li_input_line">
                <div class="col_50">
                    <div class="text_normal">Họ và tên: {ho_ten}</div>
                    <div class="text_normal">Chức vụ: {chuc_vu}</div>
                    <div class="text_normal">Email: {email}</div>
                    <div class="text_normal">Địa chỉ tiếp nhận: {dia_chi_nhan}</div>
                    <div class="text_normal">Cơ quan đơn vị: {don_vi}</div>
                </div>
                <div class="col_50">
                    <div class="text_normal">Điện thoại: {dien_thoai}</div>
                    <div class="text_normal">Số CMND/Thẻ CCCD/Hộ chiếu: {cmnd}</div>
                    <div class="text_normal">Ngày cấp: {ngay_cap}  - Nơi cấp: {noi_cap}</div>                                 
                </div>
            </div>
            <h2 class="title_muc_2">2. Số lượng và danh sách đăng ký:</h2>
            <div class="li_input_line">
                <div class="col_100">
                    <div class="text_normal">Số lượng: {soluong}, bao gồm:</div>
                </div>
            </div>
            <table class="table_danhsach print">
                <tr>
                    <th width="80">STT</th>
                    <th width="150">Họ và Tên</th>
                    <th width="180">Chức vụ</th>
                    <th>Đơn vị</th>
                    <th width="150">Ngày Sinh</th>
                </tr>
                {list}
            </table>
            <h2 class="title_muc_2"><i>Nơi nhận:</i></h2>
            <div class="li_input_line">
                <div class="col_100">
                    <div class="text_normal">{noi_nhan}</div>
                </div>
            </div>
            <div class="li_input_line" style="display: flex;">
                <div class="col_30"></div>
                <div class="col_30"></div>
                <div class="col_30">
                    <div class="text_center">T/M {don_vi}</div>
                    <div class="text_center" style="margin-top: 10px;"><b>{chucvu_daidien}</b></div>
                    <div class="text_center" style="height: 60px;"></div>
                    <div class="text_center"><b>{nguoi_daidien}</b></div>
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
        print();
	});
</script>
  {box_script_footer}
</body>
</html>