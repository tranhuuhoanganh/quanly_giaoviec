<!-- <script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script> -->
<script src="/js/process_cpanel.js?t=<?php echo time();?>"></script>
<div class="load_overlay"></div>
<div class="load_process">
	<div class="load_content">
		<img src="/images/index.svg" alt="loading" width="50">
		<div class="load_note">Hệ thống đang xử lý...</div>
	</div>
</div>
<div class="load_overlay2"></div>
<div class="load_process_2">
  <div class="load_content">
    <div class="loading">
        <div class="loading-container loading-control abslt">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
    </div>
      <div class="load_note">
        <span>Hệ thống đang xử lý</span>
        <div class="list_dot">
            <div class="loading-dot dot1"></div>
            <div class="loading-dot dot2"></div>
            <div class="loading-dot dot3"></div>
        </div>
      </div>
  </div>
</div>
<div class="box_pop" id="box_pop_confirm">
    <div class="box_pop_content">
        <div class="pop_content">
            <div class="li_input" style="font-style: italic;text-align: center;">
                <span style="font-style: italic;text-align: center;font-size: 20px;color: red;font-weight: 700;" id="title_confirm"></span>
            </div>
        </div>
        <div class="li_input text_note" style="font-style: italic;text-align: center;width: 100%;">
            <span style="font-style: italic;font-family: Arial">Bạn có chắc chắn thực hiện hàng động này!</span>
        </div>
        <div class="pop_button">
            <div class="text_center">
                <button id="button_thuchien" action="" post_id="" loai="">Thực hiện</button>
                <button class="button_cancel bg_blue">Hủy</button>
            </div>
        </div>
    </div>
</div>
<div class="box_pop_add" style="display: none;"></div>
<input type="hidden" name="thanhvien_chat" value="{thanhvien_chat}">
<input type="hidden" name="bophan_hotro" value="{bo_phan}">
<audio id="sound_chat">
    <source src="/images/chat.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<audio id="sound_global_message">
    <source src="/images/global_message3.mp3" type="audio/mpeg">
    Không hỗ trợ trình duyệt HTML 5
</audio>
<button id="play_chat" onclick="play_chat()" style="display: none;">Play sound</button>
<button id="play_chat_global" onclick="play_global()" style="display: none;">Play sound</button>
<script>
    var x = document.getElementById("sound_chat"); 
    var y = document.getElementById("sound_global_message"); 
    function play_chat() { 
      x.play(); 
    } 
    function play_global() { 
      y.play(); 
    } 
</script>