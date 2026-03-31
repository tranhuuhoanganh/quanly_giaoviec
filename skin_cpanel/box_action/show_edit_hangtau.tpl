<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Chỉnh sửa hãng tàu</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <div class="khung_mh">
                <div class="mh" style="cursor: pointer;">
                    <img src="{logo}" onerror="this.src='/images/no-images.jpg';" width="200" id="preview-minhhoa" title="click để chọn ảnh">
                </div>
                <button id="chon_anh">Chọn ảnh</button>
                <input type="file" name="minh_hoa" id="minh_hoa" style="display: none;">
            </div>
        </div>
        <div class="li_input">
            <label>Tên hãng tàu</label>
            <input type="text" name="tieu_de" value="{tieu_de}">
        </div>
        <div class="li_input">
            <label>Tên viết tắt</label>
            <input type="text" name="viet_tat" value="{viet_tat}">
            <input type="hidden" name="id" value="{id}">
        </div>
        <div class="li_input">
            <label>Link hãng tàu</label>
            <input type="text" name="link" value="{link}">
        </div>
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="edit_hangtau">Thực hiện</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>