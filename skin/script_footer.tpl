<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/skin/css/jquery.timepicker.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/jquery.timepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
    $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
    $.datepicker.setDefaults({
        closeText: "Đóng",
        prevText: "&#x3C;Trước",
        nextText: "Tiếp&#x3E;",
        currentText: "Hôm nay",
        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"
        ],
        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
        ],
        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
        weekHeader: "Tu",
        firstDay: 0,
        isRTL: false,
        minDate: "today",
        showMonthAfterYear: false,
        yearSuffix: ""
    });
})
</script>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script src="/swiper/swiper.min.js"></script>
<script type="text/javascript" src="/js/jquery.priceformat.min.js"></script>
<script type="text/javascript" src="/js/demo_price.js"></script>
<script type="text/javascript" src="/js/lazyload.min.js"></script>
<script src="/js/process.js?t=<?php echo time();?>"></script>
<div class="load_overlay" style="display: none;"></div>
<div class="load_process" style="display: none;">
    <div class="load_content">
        <img src="/images/index.svg" alt="loading" width="70">
        <div class="load_note">Hệ thống đang xử lý</div>
    </div>
</div>
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
<div class="navs-container home-zone">
    <link rel="stylesheet" media="all" type="text/css" href="/skin/css/util-navs.min.css">
    <!-- <ul id="navs" data-open="-" data-close="+" class="arc-menu">
        <li class="arc-item-1 zalo"><a href="javascript:;" id="nutzalo" title="Chat với hỗ trợ qua zalo" target="_blank" rel="nofollow"><i class="icon-cps-chat-zalo"></i></a></li>
        <li class="arc-item-2 call"><a href="tel:{number_hotline}" rel="nofollow" title="Gọi điện hỗ trợ qua hotline"><i class="icon-cps-call"></i></a></li>
        <li class="arc-item-3 chat"><a href="{link_facebook}"  title="Fanpage KNVC"><i class="icon-cps-chat"></i></a></li>
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
    <script>
        function isMobileDevice() {
          return /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        }
        const nutzalo = document.getElementById('nutzalo');
        function ZaloClick() {
          let link;
          if (isMobileDevice()) {
                if (navigator.userAgent.includes('Android')) {
                  // android    
                  link = 'https://zaloapp.com/qr/p/1wmcig4hul5ff';
                  // với link này để mở zalo điện thoại anh em chỉ cần vào cá nhân / lấy "Mã QR của tôi" sau đó lưu mã lấy đt quét mã đó rồi copy link ở trình duyệt dán vào đây
                } else {
                  // ios
                  link = 'zalo://qr/p/1wmcig4hul5ff';
                  // lấy đoạn link phía sau ở phần quét mã qr thay vào "1wmcig4hul5ff" là được
                }
          } else {
            // link mở zalo pc
            link = 'https://chat.zalo.me/?phone={number_hotline}';
            // với link này để mở zalo pc anh em chỉ cần thay sđt zalo phía sau "0359355369"
          }
          window.open(link, '_blank');
        }
        nutzalo.addEventListener('click', ZaloClick);
    </script>
</div>