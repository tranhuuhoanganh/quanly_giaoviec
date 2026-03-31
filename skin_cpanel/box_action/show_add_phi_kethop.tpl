<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Thêm phí kết hợp mới</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <label>Hãng tàu</label>
            <select name="hangtau">
                <option value="">Chọn hãng tàu</option>
                {option_hangtau}
            </select>
        </div>
        <div class="li_input">
            <label>Phí kết hợp</label>
            <input type="text" name="phi" value="" class="format_number">
        </div>
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="add_phi_kethop">Thực hiện</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>