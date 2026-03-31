<div class="box_chat" id="box_chat_{user_id}" avatar="{avatar}" user_in="{user_id}">
	<div class="box_chat_top">
		<div class="box_chat_top_name"><div class="box_chat_top_online box_chat_top_online_{user_id} {class_status}"></div><span>{name}</span></div>
		<div class="box_chat_top_menu">
			<div class="box_chat_top_photo" title="Thêm ảnh" onclick="photo_chat('{user_id}');"><i class="fa fa-picture-o" aria-hidden="true"></i></div>
			<div class="box_chat_top_smile" title="Thêm mặt cười" onclick="smile_chat('{user_id}');"><i class="fa fa-meh-o" aria-hidden="true"></i></div>
			<div class="box_chat_top_delete" title="Xóa trò chuyện"><i class="fa fa-trash-o" aria-hidden="true"></i></div>
			<div class="box_chat_top_close" title="Đóng cửa số chat" onclick="close_chat('{user_id}');"><i class="fa fa-times" aria-hidden="true"></i></div>
		</div>
	</div>
	<div class="chating"></div>
	<div class="box_chat_midle" load="1" loaded="" page="1" onscroll="load_more_chat({user_id})" id="box_chat_midle_{user_id}">
		{list}
	</div>
	<div class="box_chat_footer">
		<div class="box_chat_footer_text">
			<input type="text" onfocus="active_chat('{user_id}');" onkeypress="send_chat('{user_id}')" placeholder="Nhập nội dung và bấm Enter...">
		</div>
	</div>
</div>