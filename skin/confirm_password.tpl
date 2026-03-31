{header}
<body class="body_scroll">
	{box_header}
	<div class="box_contact" style="padding-top: 80px;">
		<div class="box_contact_container">
			<div class="box_img">
				<img src="/images/giaoviec2-removebg-preview.png">
			</div>
			<div class="form_contact">
				<div class="title_box">Thiết lập mật khẩu mới</div>
				<div class="li_input hide_success">
					<input type="password" name="password" autocomplete="off" placeholder="Nhập mật khẩu mới*">
				</div>
				<div class="li_input hide_success">
					<input type="password" name="re_password" autocomplete="off" placeholder="Nhập lại mật khẩu mới*">
				</div>
				<div class="li_input hide_success">
					<input type="hidden" name="email" value="{email}">
					<input type="hidden" name="token" value="{token}">
					<button name="save_password">Hoàn thành</button>
				</div>
			</div>
		</div>
	</div>
	{footer}
	{script_footer}
</body>
</html>