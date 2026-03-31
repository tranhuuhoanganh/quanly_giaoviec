<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<div class="box_yeucau_hotro">
		    <div class="box_yeucau">
		        <div class="box_search">
		            <input type="text" name="khachang_yeucau" placeholder="Tìm kiếm thành viên">
		            <div class="goi_y scroll"></div>
		        </div>
		        <div class="list_yeucau">
		            <div class="list_yeucau_title">
		                <div class="name">Họ và tên</div>
		                <div class="mobile hide_mobile">Điện thoại</div>
		                <div class="note">Yêu cầu</div>
		            </div>
		            <div class="list scroll" id="list_yeucau">
		            	{list_yeucau}
		            </div>
		        </div>
		    </div>
		    <div class="box_chat">
		        <div class="title_top">
		            <div class="name" id="ten_khach">{ho_ten}</div>
		            <div class="lichsu">
		                <div class="bieutuong"><i class="fa fa-question-circle"></i></div>
		                <div class="txt">Lịch sử yêu cầu</div>
		            </div>
		        </div>
		        <div class="list_chat">
		            <div class="top_chat">
		                <div class="note">
		                    <div class="note_content">
		                        <label>Ghi chú:</label>
		                        <div class="txt">{note}</div>
		                    </div>
		                </div>
		            </div>
		            <div class="list scroll" id="list_chat">
		            	{list_chat}
		            </div>
		            <div class="input_chat">
		                <input type="text" name="noidung_yeucau" placeholder="Nhập nội dung tin nhắn">
		                <input type="hidden" name="thanh_vien" value="{thanh_vien}">
		                <input type="hidden" name="user_out" value="{user_id}">
		                <input type="hidden" name="load_chat" value="1" loaded="1">
		                <button id="submit_yeucau" phien="{phien}"><i class="fa fa-send"></i></button>
		            </div>
		            <div class="bottom_chat">
		                <div class="text_status">
		                    <div class="loading_chat"><i class="icofont-spinner"></i> Đang gửi...</div>
		                </div>
		                <div class="list_action">
		                	<div class="box_sticker">
		                		<div class="list_tab">
		                			<div class="li_tab" id="tab_vuinhon"><img src="/images/smile/zalo/vui-nhon/6.png"></div>
		                			<div class="li_tab" id="tab_yeuroi"><img src="/images/smile/zalo/yeu-roi/2.png"></div>
		                			<div class="li_tab" id="tab_unin"><img src="/images/smile/zalo/un-in/10.png"></div>
		                		</div>
		                		<div class="list_sticker">
		                			<div class="list_sticker_content active scroll" id="tab_vuinhon_content">
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/1.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/2.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/3.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/4.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/5.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/6.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/7.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/8.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/9.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/10.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/11.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/12.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/13.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/14.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/15.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/16.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/17.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/18.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/19.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/vui-nhon/20.png">
		                				</div>
		                			</div>
		                			<div class="list_sticker_content scroll" id="tab_unin_content">
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/1.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/2.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/3.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/4.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/5.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/6.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/7.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/8.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/9.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/10.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/11.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/12.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/13.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/14.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/15.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/16.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/17.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/18.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/19.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/un-in/20.png">
		                				</div>
		                			</div>
		                			<div class="list_sticker_content scroll" id="tab_yeuroi_content">
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/1.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/2.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/3.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/4.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/5.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/6.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/7.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/8.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/9.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/10.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/11.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/12.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/13.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/14.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/15.png">
		                				</div>
		                				<div class="li_sticker">
		                					<img src="/images/smile/zalo/yeu-roi/16.png">
		                				</div>
		                			</div>
		                		</div>
		                	</div>
			                <button id="attachment"><i class="fa fa-cloud-upload"></i></button>
			                <button id="smile"><i class="fa fa-smile-o"></i></button>
			                <button id="dong_yeucau">Đóng phiên trao đổi</button>
		                </div>
		            </div>
		        </div>
		    </div>
  		</div>
  	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_lienhe'){
                vitri=total_height - 200;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
        setTimeout(function(){
	        var top_dong = $('.bottom_chat').offset().top;
	        $('html,body').stop().animate({scrollTop:top_dong - 150}, 500, 'swing', function() { 
	        });
        },500);
    });
</script>
<input type="file" id="dinh_kem" name="file" accept="application/pdf,image/*" multiple style="display: none;">
<style type="text/css">
	.box_sms_bottom{
		display: none;
	}
</style>