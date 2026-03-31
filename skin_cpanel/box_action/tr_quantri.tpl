<tr class="tr_{user_id}">
    <td>{i}</td>
    <td>{name}</td>
    <td>{mobile}</td>
    <td>{email}</td>
    <td>{bo_phan}</td>
    <td class="sticky-column">
        <a href="/admincp/edit-quantri?id={user_id}" class="ah_inline"><button class="bg_blue"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>
        <a href="javascript:;" class="ah_inline"><button class="bg_red" onclick="del('quantri','{user_id}');"><i class="fa fa-trash-o"></i> Xóa</button></a>
    </td>
</tr>
<tr class="tr_{user_id}">
    <td colspan="8"></td>
</tr>