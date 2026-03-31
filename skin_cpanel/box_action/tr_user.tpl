<tr id="{user_id}">
    <td>{i}</td>
    <td>
        <div class="box_pop_list_user_employee">
            <div class="box_pop_list_user_employee_info">
                <div class="box_pop_list_user_employee_name">{name}</div>
            </div>
        </div>
    </td>
    <td>{mobile}</td>
    <td>{email}</td>
    <td style="text-align: center;">
        <span class="box_pop_list_user_status {status_class}">{time_hopdong}</span>
    </td>
    <td>
        <div class="box_pop_list_user_actions">
            <button class="box_pop_list_user_btn view" name="view_user" title="Xem chi tiết">
                <i class="fa fa-eye"></i> Xem
            </button>
            <button class="box_pop_list_user_btn edit" name="edit_user" title="Chỉnh sửa">
                <i class="fa fa-pencil"></i> Sửa
            </button>
            <button class="box_pop_list_user_btn move" name="move_user" title="Chuyển phòng ban">
                <i class="fa fa-building"></i> Chuyển
            </button>
            {hoat_dong}
        </div>
    </td>
</tr>

