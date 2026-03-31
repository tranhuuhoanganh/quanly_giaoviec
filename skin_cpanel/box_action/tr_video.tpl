<tr id="tr_{id}">
    <td>{i}</td>
    <td>
        <img src="{minh_hoa}" width="150">
    </td>
    <td style="text-align: left;">{tieu_de}</td>
    <td>{link_video}</td>
    <td>{view}</td>
    <td class="sticky-column">
        <a href="/admincp/edit-video?id={id}">
            <button class="bg_blue b_mobile"><i class="fa fa-pencil-square-o"></i> Sửa</button>
        </a>
        <button class="bg_red b_mobile" onclick="del('video','{id}');"><i class="fa fa-trash-o"></i> Xóa</button>
    </td>
</tr>
<tr>
    <td colspan="6"></td>
</tr>