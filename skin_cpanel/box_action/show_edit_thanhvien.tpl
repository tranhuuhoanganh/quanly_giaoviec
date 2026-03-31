<div class="box_pop_add_content" style="width: 500px;">
    <div class="pop_title">
        <h5>Chỉnh sửa thành viên</h5>
        <span><i class="fa fa-close"></i></span>
    </div>
    <div class="pop_content">
        <div class="li_input">
            <label>Công ty</label>
            <input type="text" name="cong_ty" value="{cong_ty}">
        </div>
        <div class="li_input">
            <label>Mã số thuế</label>
            <input type="text" name="maso_thue" value="{maso_thue}">
        </div>
        <div class="li_input">
            <label>Họ và tên</label>
            <input type="text" name="ho_ten" value="{name}">
        </div>
        <div class="li_input">
            <label>Điện thoại</label>
            <input type="text" name="dien_thoai" value="{mobile}">
        </div>
        <div class="li_input">
            <label>Email</label>
            <input type="text" name="email" value="{email}">
        </div>
        <div class="li_input">
            <label>Nhóm</label>
            <select name="nhom">
                <option value="0">Thành viên</option>
                <option value="1">Quản trị</option>
            </select>
        </div>
        <input type="hidden" name="id" value="{user_id}">
    </div>
    <div class="pop_button">
        <div class="button_left">
        </div>
        <div class="button_center">
            <button id="cancel">Hủy</button>
            <button class="bg_green" name="edit_thanhvien">Thực hiện</button>
        </div>
        <div class="button_right">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('select[name=nhom]').val('{nhom}');
    });
</script>