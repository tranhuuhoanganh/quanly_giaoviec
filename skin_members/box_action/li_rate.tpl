<div class="li_rate">
    <div class="avatar_rate">
        <img src="{avatar}" onerror="this.src='/images/user.png'">
    </div>
    <div class="info_rate">
        <div class="name">{name} - {mobile}</div>
        <div class="list_star">
            {list_star}
        </div>
        <div class="note">{note}</div>
        <div class="time_rate">
            <div class="time">{text_rate}: {update_post}</div>
            <span>|</span>
            <div onclick="show_edit('rate','{id}');" class="show_edit_rate"><i class="fa fa-pencil-square-o"></i> chỉnh sửa</div>
        </div>
    </div>
    <div class="info_booking">
        <table class="">
            <tr>
                <td class="left">Công ty</td>
                <td class="right">{cong_ty}</td>
            </tr>
            <tr>
                <td class="left">Số booking</td>
                <td class="right">{so_booking}</td>
            </tr>
            <tr>
                <td class="left">Hãng Tàu</td>
                <td class="right">{ten_hangtau}</td>
            </tr>
            <tr>
                <td class="left">Loại vỏ</td>
                <td class="right">{ten_loai_container}</td>
            </tr>
            <tr>
                <td class="left">Mặt hàng</td>
                <td class="right">{mat_hang}</td>
            </tr>
        </table>
    </div>
</div>