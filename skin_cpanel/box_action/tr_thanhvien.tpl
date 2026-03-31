<tr class="tr_{user_id}">
    <td>{i}</td>
    <td>{name}</td>
    <td>{mobile}</td>
    <td>{cong_ty}</td>
    <td>{booking_tao}</td>
    <td>{booking_dat}</td>
    <td>{user_money}</td>
    <td>{user_money2}</td>
    <td>{link_active}</td>
    <td>{cskh}</td>
    <td class="sticky-column">
        <button class="bg_blue b_mobile" onclick="show_edit('thanhvien','{user_id}');" style="width: 100%;"><i class="fa fa-pencil-square-o"></i> Sửa</button>
        <button class="bg_orange b_mobile" onclick="show_edit('cskh','{user_id}');" style="width: 100%;"><i class="fa fa-user"></i> CSKH</button>
        <button class="bg_red b_mobile" onclick="del('thanhvien','{user_id}');" style="width: 100%;"><i class="fa fa-trash-o"></i> Xóa</button>
    </td>
</tr>
<tr class="tr_{user_id}">
    <td colspan="8"></td>
</tr>