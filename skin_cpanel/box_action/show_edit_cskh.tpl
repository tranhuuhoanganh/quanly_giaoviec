<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Cập nhật chăm sóc khách hàng</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <label>Nhân viên CSKH</label>
            <select name="cskh">
                <option value="">Chọn CSKH</option>
                {list_cskh}
            </select>
        </div>
        <div class="li_input">
            <label>Họ và tên</label>
            <input type="text" name="ho_ten" value="{ho_ten}" autocomplete="off">
        </div>
        <div class="li_input">
            <label>Điện thoại</label>
            <input type="text" name="dien_thoai" value="{dien_thoai}" autocomplete="off">
        </div>
        <input type="hidden" name="id" value="{user_id}">
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="edit_cskh">Thực hiện</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>