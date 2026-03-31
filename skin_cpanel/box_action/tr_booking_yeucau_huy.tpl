<tr>
    <td>{i}</td>
    <td>{date_post}</td>
    <td>{name}</td>
    <td>{mobile}</td>
    <td>{so_booking}</td>
    <td>{so_hieu}</td>
    <td>{ly_do}</td>
    <td>{status}</td>
    <td class="sticky-column">
        <a href="/admincp/view-dat-booking?id={id_booking}"><button class="bg_blue" id="{id_booking}" style="width: 100%;">Chi tiết</button></a>
        <button class="bg_red" id="{id_booking}" style="width: 100%;" onclick="confirm_action('xacnhan_booking', 'Xác nhận hủy booking', '{id_booking}');">Xác nhận hủy</button>
        <button class="bg_brown" id="{id_booking}" style="width: 100%;" onclick="confirm_action('tuchoi_huy_booking', 'Từ chối yêu cầu hủy booking', '{id_booking}');">Từ chối hủy</button>
    </td>
</tr>
<tr>
    <td colspan="12"></td>
</tr>