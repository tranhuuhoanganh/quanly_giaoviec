<!-- <script type="text/javascript" src="/js/jquery.nicescroll.min.js"></script> -->
<script src="/js/process_members.js?t=<?php echo time();?>"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
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
<div class="box_pop_add"></div>
<div class="box_dat_hoanthanh">
    <div class="box_dat_hoanthanh_content">
        <div class="title">THÔNG BÁO</div>
        <span class="close"><i class="fa fa-times-circle"></i></span>
        <div class="content_hoanthanh">
            <div class="text_success">Xác nhận booking thành công</div>
            <div class="table_success"></div>
        </div>
    </div>
</div>

<div class="box_kichhoat box_thongbao">
    <div class="box_kichhoat_content" style="width: 450px;">
        <div class="title"></div>
        <span class="close"><i class="fa fa-times-circle"></i></span>
        <div style="text-align: left;margin-top: 10px;">
            <div style="width: 100%;text-align: center;font-size: 40px;" class="icon_thongbao"><i class="fa fa-exclamation-triangle"></i></div>
            <div style="text-align: center;padding: 10px;border-radius: 5px;" id="text_note"><b class="color_red">Bạn đã hết thời gian sử dụng!</b></div>
        </div>
    </div>
</div>

<div class="box_gan">
    <div class="box_gan_container" style="width: 1250px;max-width: calc(100% - 10px);">
        <div class="title">
            Gợi ý booking phù hợp <i class="fa fa-close"></i>
        </div>
        <div class="list_booking">
            <div class="list_tab_content">
                <div class="li_tab_content active">
                    <table class="table_hang" style="width: 100%;" max-width="1250"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box_player">
    <div class="box_player_content">
        <div class="title"></div>
        <span class="close"><i class="fa fa-times-circle"></i></span>
        <div id="content_video"></div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script type="text/javascript" src="/js/deadline_countdown.js?t=<?php echo time();?>"></script>
<script type="text/javascript" charset="utf-8">
$(function() {
    var currentDate = new Date(),
        finished = false,
        availiableExamples = {
            set5ngay: 15 * 24 * 60 * 60 * 1000,
            set5phut: 5 * 60 * 1000,
            set1phut: 1 * 10 * 1000
        };

    function call_flash(event) {
        $this = $(this);
        switch (event.type) {
            case "seconds":
            case "minutes":
            case "hours":
            case "days":
            case "weeks":
            case "daysLeft":
                $this.find('.' + event.type).html(event.value);
                if (finished) {
                    $this.fadeTo(0, 1);
                    finished = false;
                }
                break;
            case "finished":
                time_start = $(this).attr('time_start') * 1000;
                con = $(this).attr('time') * 1000;
                if (time_start > 0) {
                    $this.attr('time_start', '0');
                    $this.find('.text_status').html('Còn');
                    $(this).countdown(con + currentDate.valueOf(), call_flash);
                } else {
                    $this.fadeTo('slow', .5);
                    $this.html('Đã hết hạn');
                }
                finished = true;
                break;
        }
    }
    $('.timer_countdown').each(function() {
        time_start = $(this).attr('time_start') * 1000;
        con = $(this).attr('time') * 1000;
        if (time_start > 0) {
            $(this).countdown(time_start + currentDate.valueOf(), call_flash);
        } else {
            $(this).countdown(con + currentDate.valueOf(), call_flash);
        }
    });
});
</script>
<input type="hidden" name="user_id" value="{user_id}">
<input type="hidden" name="bophan_hotro" value="{bo_phan}">
<input type="hidden" name="phi_booking_setting" value="{phi_booking_setting}">
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
<div class="main_box_chat">
    <input type="hidden" name="user_chating" value="Đang soạn tin...">
    <input type="hidden" name="text_send" value="Đang gửi tin nhắn...">
    <input type="hidden" name="text_load_data" value="Đang tải dữ liệu...">
</div>
<div class="navs-container home-zone">
    <link rel="stylesheet" media="all" type="text/css" href="/skin_members/css/util-navs.min.css">
    <!-- <ul id="navs" data-open="-" data-close="+" class="arc-menu">
        <li class="arc-item-1 zalo"><a href="https://chat.zalo.me/?phone={number_hotline}" title="Chat với hỗ trợ qua zalo" target="_blank" rel="nofollow"><i class="icon-cps-chat-zalo"></i></a></li>
        <li class="arc-item-2 call"><a href="tel:{number_hotline}" rel="nofollow" title="Gọi điện hỗ trợ qua hotline"><i class="icon-cps-call"></i></a></li>
        <li class="arc-item-3 chat"><a href="/members/list-chat" title="Chat với nhân viên hỗ trợ"><i class="icon-cps-chat"></i></a></li>
    </ul> -->
    <div class="navs-bg"></div>
    <script type="text/javascript">
    $(function() {
        var screenWidth = $(window).width();
        var isTouch = !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
        var isPhone = isTouch || screenWidth <= 600;

        var icon = {};
        icon.top = "&#11165;";
        icon.phone = "&phone;";
        icon.cart = "&#128722;";
        var ul = $("#navs"),
            li = $("li", ul),
            length = li.length,
            n = length - 1,
            r = 70;
        ul.on('switchArc', function() {
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                for (var i = 0; i < length; i++) {
                    li.eq(i).css({
                        'transition-delay': "" + (50 * i) + "ms",
                        '-webkit-transition-delay': "" + (50 * i) + "ms",
                        'left': -1 * (r * Math.cos(90 / n * i * (Math.PI / 180))),
                        'top': (-r * Math.sin(90 / n * i * (Math.PI / 180)))
                    });
                }
            } else {
                li.removeAttr('style');
            }
        });
        if (isPhone) {
            ul.on('click touch', function() {
                console.log("ul.click");
                $(this).trigger('switchArc');
            });
        } else {
            ul.hover(function() {
                    if (!$(this).hasClass('active'))
                        $(this).trigger('switchArc');
                },
                function() {
                    if ($(this).hasClass('active'))
                        $(this).trigger('switchArc');
                });
        }

        /*        $(".arc-item-3.gotop a").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if ($('html, body').scrollTop() == 0) return;
                    $('html, body').animate({
                        scrollTop: 0
                    }, 1000, function() {
                        if ($('ul.arc-menu').hasClass('active')) {
                            console.log("trigger switchArc");
                            $('ul.arc-menu').trigger('switchArc');
                        }
                    });

                });*/

        $('.navs-bg').on('click touch', function() {
            if (isPhone)
                $('ul.arc-menu').trigger('switchArc');
        })

    });
    </script>
</div>