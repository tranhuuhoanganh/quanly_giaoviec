<tr id="tr_{id}">
	<td style="text-align: center;">{i}</td>
	<td>{ho_ten}</td>
	<td>{email}</td>
	<td>{dien_thoai}</td>
	<td>{status}</td>
	<td>{date_post}</td>
	<td class="sticky-column">
        <a href="/admincp/contact-detail?id={id}" class="edit"><button class="bg_blue b_mobile"><i class="fa fa-pencil-square-o"></i> Sửa</button></a>
        <button class="bg_red b_mobile" onclick="del('lien_he','{id}');"><i class="fa fa-trash-o"></i> Xóa</button>
	</td>
</tr>
<tr>
	<td colspan="7"></td>
</tr>