<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Thêm quận/huyện mới</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <label>Tên Tỉnh/TP</label>
            <input type="text" value="{tieu_de}" disabled="disabled" placeholder="Nhập tên tỉnh">
        </div>
        <div class="li_input">
            <label>Tên quận/huyện</label>
            <input type="text" name="tieu_de" value="" placeholder="Nhập tên quận/huyện">
        </div>
        <div class="li_input">
            <label>Thứ tự</label>
            <input type="text" name="thu_tu" value="" placeholder="Nhập số thứ tự">
            <input type="hidden" name="tinh" value="{id}">
        </div>
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="add_huyen">Thực hiện</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>