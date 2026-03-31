<tr id="tr_{id}">
    <td>{i}</td>
    <td>
        <img src="{minh_hoa}" width="150">
    </td>
    <td style="text-align: left;">{tieu_de}</td>
    <td>{view}</td>
    <td class="sticky-column">
        <a href="/admincp/edit-baiviet?id={id}">
            <button class="bg_blue b_mobile"><i class="fa fa-pencil-square-o"></i> Sửa</button>
        </a>
        <button class="bg_red b_mobile" onclick="del('baiviet','{id}');"><i class="fa fa-trash-o"></i> Xóa</button>
    </td>
</tr>
<tr>
    <td colspan="6"></td>
</tr>