<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Chỉnh sửa phòng ban</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <label>Phân cấp Nhân sự</label>
            <select name="phan_cap_edit" id="phan_cap_edit" class="form-select">
                {list_phan_cap_edit}
            </select>
        </div>
        <div class="li_input">
            <label>Cấp nhân sự</label>
            <input type="text" name="tieu_de" value="{tieu_de}" placeholder="Ví dụ: Tổng giám đốc hoặc General Director/CEO">
            <input type="hidden" name="id" value="{id}">
        </div>
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="edit_phongban" data-id="{id}">Lưu lại</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>
