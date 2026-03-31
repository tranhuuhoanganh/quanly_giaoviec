function scrollSmoothToBottom (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 200);
}
//var socket =io("http://localhost:3000");
var socket =io("https://chat.socdo.vn");
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}

function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
/*$(function() {
    var imagesPreview = function(input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var img_name=input.files[i].name;
                $(placeToInsertImagePreview).append('<div class="li_upload"><div class="img"><i class="fa fa-picture-o"></i></div><div class="img_info"><div class="img_name">'+img_name+'</div><div class="img_icon"><i class="fa fa-spinner fa-spin"></i></div></div></div>');
            }
        }
    };
    $('#photo-add').on('change', function() {
        imagesPreview(this, '.list_upload');
    });
});*/
function check_link(loai) {
    link = $('.link_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link,
                loai: loai
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if (info.ok == 1) {
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                } else {
                    if ($('#link_old').length > 0) {
                        link_old = $('#link_old').val();
                        if (link_old == info.link) {
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    } else {
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}

function check_blank(loai) {
    link = $('.tieude_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link,
                loai: loai
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.link_seo').val(info.link);
                if (info.ok == 1) {
                    $('.check_link').removeClass('error');
                    $('.check_link').addClass('ok');
                    $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                } else {
                    if ($('#link_old').length > 0) {
                        link_old = $('#link_old').val();
                        if (link_old == info.link) {
                            $('.check_link').removeClass('error');
                            $('.check_link').addClass('ok');
                            $('.check_link').html('<i class="fa fa-check-circle-o"></i> Đường dẫn hợp lệ');
                        }

                    } else {
                        $('.check_link').removeClass('ok');
                        $('.check_link').addClass('error');
                        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn đã tồn tại');
                    }
                }
            }
        });
    }
}
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
function tuchoi(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "tuchoi",
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            setTimeout(function() {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}

function confirm_del(action, loai, title, id) {
    $('#title_confirm').html(title);
    $('#button_thuchien').attr('action', action);
    $('#button_thuchien').attr('post_id', id);
    $('#button_thuchien').attr('loai', loai);
    $('#box_pop_confirm').show();
}

function confirm_action(action, title, id) {
    $('#box_pop_confirm_action .title_confirm').html(title);
    $('#button_thuchien_action').attr('action', action);
    $('#button_ok').attr('class', action);
    $('#button_thuchien_action').attr('post_id', id);
    $('#box_pop_confirm_action').show();
}

function confirm_success(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "confirm_success",
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            setTimeout(function() {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}

function del(loai, id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            setTimeout(function() {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    $('#tr_' + id).remove();
                    $('.tr_' + id).remove();
                } else {

                }
            }, 2000);
        }

    });
}

function huy(id) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "huy",
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            setTimeout(function() {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    window.location.reload();
                } else {

                }
            }, 2000);
        }

    });
}
function noti2(text,time_start,time_end){
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    setTimeout(function() {
        $('.load_process .load_note').html(text);
    }, time_start);
    setTimeout(function() {
        $('.load_process').hide();
        $('.load_process .load_note').html('Hệ thống đang xử lý');
        $('.load_overlay').hide();
    }, time_end);
}
function noti(text,time_start,time_end){
    $('.load_overlay').show();
    $('.load_process_2').fadeIn();
    setTimeout(function() {
        $('.load_process_2 .load_note span').html(text);
    }, time_start);
    setTimeout(function() {
        $('.load_process_2').hide();
        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
        $('.load_overlay').hide();
    }, time_end);
}
function show_edit(loai,id) {
    //noti('Hệ thống đang xử lý',500,1500);
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "show_edit",
            loai:loai,
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            if(info.ok==1){
                //setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                //}, 1000);
            }else{
                noti(info.thongbao,500,1500);
            }
        }

    });
}
function show_add(loai,id) {
    //noti('Hệ thống đang xử lý',0,1000);
    $.ajax({
        url: "/admincp/process.php",
        type: "post",
        data: {
            action: "show_add",
            loai:loai,
            id: id
        },
        success: function(kq) {
            var info = JSON.parse(kq);
            if(info.ok==1){
                //setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                //}, 1000);
            }else{
                noti(info.thongbao,0,1000);
            }
        }

    });
}
function getCookies() {
    var c = document.cookie,
        v = 0,
        cookies = {};
    if (document.cookie.match(/^\s*\$Version=(?:"1"|1);\s*(.*)/)) {
        c = RegExp.$1;
        v = 1;
    }
    if (v === 0) {
        c.split(/[,;]/).map(function(cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function($0, $1) {
            var name = $0,
                value = $1.charAt(0) === '"' ?
                $1.substr(1, -1).replace(/\\(.)/g, "$1") :
                $1;
            cookies[name] = value;
        });
    }
    return cookies;
}

function get_cookie(name) {
    return getCookies()[name];
}
function getCaretPosition(element) {
    var caretOffset = 0;
    var doc = element.ownerDocument || element.document;
    var win = doc.defaultView || doc.parentWindow;
    var sel;
    if (typeof win.getSelection != "undefined") {
        sel = win.getSelection();
        if (sel.rangeCount > 0) {
            var range = sel.getRangeAt(0);
            var preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            caretOffset = preCaretRange.toString().length;
        }
    } else if ((sel = doc.selection) && sel.type != "Control") {
        var textRange = sel.createRange();
        var preCaretTextRange = doc.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        caretOffset = preCaretTextRange.text.length;
    }
    return caretOffset;
}

function setCaretPosition(element, offset) {
    var range = document.createRange();
    var sel = window.getSelection();
    if (element.childNodes.length > 0) {
        var node = element.childNodes[0];
        range.setStart(node, Math.min(offset, node.length));
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
    }
}
function format_number(input) {
    // Loại bỏ tất cả ký tự không phải số và dấu chấm
    var number = input.replace(/[^\d.]/g, '');
    
    // Kiểm tra nếu số chứa nhiều hơn một dấu chấm, chỉ giữ lại dấu chấm đầu tiên
    if ((number.match(/\./g) || []).length > 1) {
        number = number.replace(/\.+$/, "");
    }
    
    // Phân tách phần thập phân (nếu có)
    var parts = number.split('.');
    var integerPart = parts[0];
    var decimalPart = parts.length > 1 ? '.' + parts[1] : '';

    // Thêm dấu phẩy vào phần nguyên
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    return integerPart + decimalPart;
}
$(document).ready(function() {
    ////////////////////////////
    $('body').on('click','.chon_file',function(){
        $(this).parent().find('input[type=file]').click();
    });
    ////////////////////////////
    $('body').on('change','.khung_file input[type=file]',function(){
        var fileName = $(this).val().split('\\').pop(); // Lấy tên tệp từ đường dẫn
        $(this).parent().find('.file_name').text(fileName); // Hiển thị tên tệp
    });
    setTimeout(function() {
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    }, 300);
    if($('#chon_kho').length>0){
        if(get_cookie('admin_kho')){
            $('#chon_kho').val(get_cookie('admin_kho'));
        }else{

        }
    }
    $('#chon_kho').on('change',function(){
        kho=$(this).val();
        create_cookie('admin_kho', kho, 365, '/');
        window.location.reload();
    });
    if($('#list_chat').length>0){
        setTimeout(function(){
            scrollSmoothToBottom('list_chat');
        },500);
    }
    if($(window).width()<768){
        $('[max-width]').each(function() {
            var maxWidthValue = $(this).attr('max-width');
            $(this).attr('style','width:'+maxWidthValue+'px !important');
        });
        $('.b_mobile').each(function() {
            $(this).attr('style','width:100% !important');
        });
        $('[over]').each(function() {
            $(this).attr('style','overflow: auto;');
        });
    }
    $('body').on('input','.format_number',function(){
        if($(this).is('div')){
            var div = $(this)[0];
            if (div.childNodes.length === 0) {
                div.appendChild(document.createTextNode(''));
            }
            var cursorPosition = getCaretPosition(div);
            var originalLength = div.innerText.length;
            var formattedNumber = format_number(div.innerText);
            div.innerText = formattedNumber;
            var newLength = formattedNumber.length;
            var newCursorPosition = cursorPosition + (newLength - originalLength);
            // Ensure cursor position is within valid range
            newCursorPosition = Math.max(0, Math.min(newCursorPosition, formattedNumber.length));

            setCaretPosition(div, newCursorPosition);
        }else{
            var input = $(this);
            var cursorPosition = input[0].selectionStart;
            var originalLength = input.val().length;
            var formattedNumber = format_number(input.val());
            input.val(formattedNumber);
            var newLength = formattedNumber.length;
            var newCursorPosition = cursorPosition + (newLength - originalLength);
            input[0].setSelectionRange(newCursorPosition, newCursorPosition);
        }
    });
    /////////////////////////////
    $('body').on('click','.box_sticker .li_tab',function(){
        tab=$(this).attr('id');
        $('.list_sticker_content').removeClass('active');
        $('#'+tab+'_content').addClass('active');

    });
    /////////////////////////////
    $('body').on('click','#smile',function(){
        $('.box_sticker').toggle();
    });
    /////////////////////////////
    $('body').on('click', '#attachment', function() {
        $('#dinh_kem').click();
    });
    ////////////////////////////
    $('body').on('change','select[name=cskh]',function(){
        name=$('select[name=cskh] option:selected').attr('name');
        mobile=$('select[name=cskh] option:selected').attr('mobile');
        $('.box_pop_add_content input[name=ho_ten]').val(name);
        $('.box_pop_add_content input[name=dien_thoai]').val(mobile);
    });
    ////////////////////////////
    $('body').on('click','.active_user',function(){
        user_id=$(this).attr('user_id');
        var tr=$(this);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "active_user",
                user_id: user_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if(info.ok==1){
                        tr.parent().html('Đã active');
                    }else{

                    }
                }, 1500);
            }
        });
    });
    ////////////////////////////
    $('body').on('click','.box_loai_hinh_dashboard input[type=radio]',function(){
        loai_hinh_hienthi=$('.box_loai_hinh input[name=loai_hinh_hienthi]:checked').val();
        if(loai_hinh_hienthi=='hangnhap'){
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').show();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangnhap');
        }else if(loai_hinh_hienthi=='hangxuat'){
            $('.box_container #container_hangxuat').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangxuat');
        }else if(loai_hinh_hienthi=='noidia'){
            $('.box_container #container_noidia').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_hangxuat').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hang_noidia');
        }else if(loai_hinh_hienthi=='goi_y'){
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').show();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_booking_goiy",
                    page: 1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        $('#container_goiy .table_hang').html(info.list);
                    }else{
                        noti(info.thongbao,0,2000);
                    }
                }
            });
        }
    });
    ////////////////////////////
    $('body').on('click','.box_loai_hinh_user input[type=radio]',function(){
        loai_hinh_hienthi=$('.box_loai_hinh input[name=loai_hinh_hienthi]:checked').val();
        if(loai_hinh_hienthi=='hangnhap'){
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').show();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangnhap');
        }else if(loai_hinh_hienthi=='hangxuat'){
            $('.box_container #container_hangxuat').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangxuat');
        }else if(loai_hinh_hienthi=='noidia'){
            $('.box_container #container_noidia').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_hangxuat').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hang_noidia');
        }else if(loai_hinh_hienthi=='goi_y'){
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').show();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "load_booking_goiy",
                    page: 1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        $('#container_goiy .table_hang').html(info.list);
                    }else{
                        noti(info.thongbao,0,2000);
                    }
                }
            });
        }
    });
    var lastScrollTop = 0;
    var lastScrollLeft = 0;
    $(window).scroll(function() {
        // Kiểm tra vị trí cuộn hiện tại
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
            // Tải thêm dữ liệu
            loadMoreData();
        }
    });
    function loadMoreData() {
        if($('#timkiem_booking_new').length>0){
            cong_ty=$('.box_search input[name=cong_ty]').val();
            loai_hinh=$('.box_search select[name=loai_hinh]').val();
            from=$('.box_search input[name=from]').val();
            to=$('.box_search input[name=to]').val();
            tiep=$('.list_hang').attr('tiep');
            page=$('.list_hang').attr('page');
            loaded=$('.list_hang').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_hang').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_hang').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "timkiem_booking_new",
                            loai_hinh:loai_hinh,
                            cong_ty:cong_ty,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_hang .loading_hang').remove();
                            $('.list_hang .table_hang').append(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }else if($('#timkiem_booking_wait').length>0){
            cong_ty=$('.box_search input[name=cong_ty]').val();
            loai_hinh=$('.box_search select[name=loai_hinh]').val();
            from=$('.box_search input[name=from]').val();
            to=$('.box_search input[name=to]').val();
            tiep=$('.list_hang').attr('tiep');
            page=$('.list_hang').attr('page');
            loaded=$('.list_hang').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_hang').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_hang').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "timkiem_booking_wait",
                            loai_hinh:loai_hinh,
                            cong_ty:cong_ty,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_hang .loading_hang').remove();
                            $('.list_hang .table_hang').append(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }else if($('#timkiem_booking_false').length>0){
            cong_ty=$('.box_search input[name=cong_ty]').val();
            loai_hinh=$('.box_search select[name=loai_hinh]').val();
            from=$('.box_search input[name=from]').val();
            to=$('.box_search input[name=to]').val();
            tiep=$('.list_hang').attr('tiep');
            page=$('.list_hang').attr('page');
            loaded=$('.list_hang').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_hang').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_hang').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "timkiem_booking_false",
                            loai_hinh:loai_hinh,
                            cong_ty:cong_ty,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_hang .loading_hang').remove();
                            $('.list_hang .table_hang').append(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }else if($('#timkiem_booking_confirm').length>0){
            cong_ty=$('.box_search input[name=cong_ty]').val();
            loai_hinh=$('.box_search select[name=loai_hinh]').val();
            from=$('.box_search input[name=from]').val();
            to=$('.box_search input[name=to]').val();
            tiep=$('.list_hang').attr('tiep');
            page=$('.list_hang').attr('page');
            loaded=$('.list_hang').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_hang').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_hang').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "timkiem_booking_confirm",
                            loai_hinh:loai_hinh,
                            cong_ty:cong_ty,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_hang .loading_hang').remove();
                            $('.list_hang .table_hang').append(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }else if($('#timkiem_booking_success').length>0){
            cong_ty=$('.box_search input[name=cong_ty]').val();
            loai_hinh=$('.box_search select[name=loai_hinh]').val();
            from=$('.box_search input[name=from]').val();
            to=$('.box_search input[name=to]').val();
            tiep=$('.list_hang').attr('tiep');
            page=$('.list_hang').attr('page');
            loaded=$('.list_hang').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_hang').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_hang').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "timkiem_booking_success",
                            loai_hinh:loai_hinh,
                            cong_ty:cong_ty,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_hang .loading_hang').remove();
                            $('.list_hang .table_hang').append(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
    }
    ////////////////////////
    $('body').on('click','#timkiem_booking_new',function(){
        cong_ty=$('.box_search input[name=cong_ty]').val();
        loai_hinh=$('.box_search select[name=loai_hinh]').val();
        from=$('.box_search input[name=from]').val();
        to=$('.box_search input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_new",
                    loai_hinh:loai_hinh,
                    cong_ty:cong_ty,
                    from:from,
                    to:to,
                    page: 0,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if(info.ok==1){
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }else{

                        }
                    }, 2000);
                }
            });
        },1000);
    });
    ////////////////////////
    $('body').on('click','#timkiem_booking_wait',function(){
        cong_ty=$('.box_search input[name=cong_ty]').val();
        loai_hinh=$('.box_search select[name=loai_hinh]').val();
        from=$('.box_search input[name=from]').val();
        to=$('.box_search input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_wait",
                    loai_hinh:loai_hinh,
                    cong_ty:cong_ty,
                    from:from,
                    to:to,
                    page: 0,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if(info.ok==1){
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }else{

                        }
                    }, 2000);
                }
            });
        },1000);
    });
    ////////////////////////
    $('body').on('click','#timkiem_booking_false',function(){
        cong_ty=$('.box_search input[name=cong_ty]').val();
        loai_hinh=$('.box_search select[name=loai_hinh]').val();
        from=$('.box_search input[name=from]').val();
        to=$('.box_search input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_false",
                    loai_hinh:loai_hinh,
                    cong_ty:cong_ty,
                    from:from,
                    to:to,
                    page: 0,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if(info.ok==1){
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }else{

                        }
                    }, 2000);
                }
            });
        },1000);
    });
    ////////////////////////
    $('body').on('click','#timkiem_booking_confirm',function(){
        cong_ty=$('.box_search input[name=cong_ty]').val();
        loai_hinh=$('.box_search select[name=loai_hinh]').val();
        from=$('.box_search input[name=from]').val();
        to=$('.box_search input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_confirm",
                    loai_hinh:loai_hinh,
                    cong_ty:cong_ty,
                    from:from,
                    to:to,
                    page: 0,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if(info.ok==1){
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }else{

                        }
                    }, 2000);
                }
            });
        },1000);
    });
    ////////////////////////
    $('body').on('click','#timkiem_booking_success',function(){
        cong_ty=$('.box_search input[name=cong_ty]').val();
        loai_hinh=$('.box_search select[name=loai_hinh]').val();
        from=$('.box_search input[name=from]').val();
        to=$('.box_search input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_success",
                    loai_hinh:loai_hinh,
                    cong_ty:cong_ty,
                    from:from,
                    to:to,
                    page: 0,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if(info.ok==1){
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                            $('.list_hang').attr('page',info.page);
                            $('.list_hang').attr('tiep',info.tiep);
                            $('.list_hang').attr('loaded',1);
                        }else{

                        }
                    }, 2000);
                }
            });
        },1000);
    });
    ////////////////////////
    $('#list_hangxuat_user').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hangxuat_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hangxuat_user').attr('tiep');
            page=$('#list_hangxuat_user').attr('page');
            loaded=$('#list_hangxuat_user').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hangxuat_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangxuat_user').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangxuat_user .loading_hang').remove();
                            $('#list_hangxuat_user .table_hang').append(info.list);
                            $('#list_hangxuat_user').attr('page',info.page);
                            $('#list_hangxuat_user').attr('tiep',info.tiep);
                            $('#list_hangxuat_user').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangnhap_user').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hangnhap_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hangnhap_user').attr('tiep');
            page=$('#list_hangnhap_user').attr('page');
            loaded=$('#list_hangnhap_user').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hangnhap_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangnhap_user').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangnhap_user .loading_hang').remove();
                            $('#list_hangnhap_user .table_hang').append(info.list);
                            $('#list_hangnhap_user').attr('page',info.page);
                            $('#list_hangnhap_user').attr('tiep',info.tiep);
                            $('#list_hangnhap_user').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hang_noidia_user').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hang_noidia_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hang_noidia_user').attr('tiep');
            page=$('#list_hang_noidia_user').attr('page');
            loaded=$('#list_hang_noidia_user').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hang_noidia_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hang_noidia_user').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hang_noidia_user .loading_hang').remove();
                            $('#list_hang_noidia_user .table_hang').append(info.list);
                            $('#list_hang_noidia_user').attr('page',info.page);
                            $('#list_hang_noidia_user').attr('tiep',info.tiep);
                            $('#list_hang_noidia_user').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangxuat_dashboard').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hangxuat_dashboard');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hangxuat_dashboard').attr('tiep');
            page=$('#list_hangxuat_dashboard').attr('page');
            loaded=$('#list_hangxuat_dashboard').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hangxuat_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangxuat_dashboard').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangxuat_dashboard .loading_hang').remove();
                            $('#list_hangxuat_dashboard .table_hang').append(info.list);
                            $('#list_hangxuat_dashboard').attr('page',info.page);
                            $('#list_hangxuat_dashboard').attr('tiep',info.tiep);
                            $('#list_hangxuat_dashboard').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangnhap_dashboard').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hangnhap_dashboard');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hangnhap_dashboard').attr('tiep');
            page=$('#list_hangnhap_dashboard').attr('page');
            loaded=$('#list_hangnhap_dashboard').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hangnhap_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangnhap_dashboard').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangnhap_dashboard .loading_hang').remove();
                            $('#list_hangnhap_dashboard .table_hang').append(info.list);
                            $('#list_hangnhap_dashboard').attr('page',info.page);
                            $('#list_hangnhap_dashboard').attr('tiep',info.tiep);
                            $('#list_hangnhap_dashboard').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hang_noidia_dashboard').on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang=$('#list_hang_noidia_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep=$('#list_hang_noidia_dashboard').attr('tiep');
            page=$('#list_hang_noidia_dashboard').attr('page');
            loaded=$('#list_hang_noidia_dashboard').attr('loaded');
            if(loaded==1 && tiep==1){
                $('#list_hang_noidia_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hang_noidia_dashboard').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh:loai_hinh,
                            hang_tau:hang_tau,
                            hang_tau_id:hang_tau_id,
                            loai_container:loai_container,
                            dia_diem:dia_diem,
                            dia_diem_id:dia_diem_id,
                            from:from,
                            to:to,
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_hang_noidia_dashboard .loading_hang').remove();
                            $('#list_hang_noidia_dashboard .table_hang').append(info.list);
                            $('#list_hang_noidia_dashboard').attr('page',info.page);
                            $('#list_hang_noidia_dashboard').attr('tiep',info.tiep);
                            $('#list_hang_noidia_dashboard').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('body').on('click','#container_hangxuat .table_hang .fa-minus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container=($('.tr_more_'+id_container).length)/2 + 1;
        $(this).parent().parent().find('td:eq(4)').html(total_container);
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).hide();
        }else{
        }

    });
    ////////////////////////
    $('body').on('click','#container_hangxuat .table_hang .fa-plus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(4)').html('1');
        }else{
            $(this).parent().parent().find('td:eq(4)').html('1');
            if($('.timkiem_user').length>0){
                action='load_more_user_container';
            }else{
                action='load_more_container';
            }
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container:id_container
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    }else{
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_'+id_container).after(info.list);
                            
                        } else {
                        }
                    }
                }
            });
        }

    });
    ////////////////////////
    $('body').on('click','#container_hangnhap .table_hang .fa-minus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container=($('.tr_more_'+id_container).length)/2 + 1;
        $(this).parent().parent().find('td:eq(4)').html(total_container);
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).hide();
        }else{
        }

    });
    ////////////////////////
    $('body').on('click','#container_hangnhap .table_hang .fa-plus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(4)').html('1');
        }else{
            $(this).parent().parent().find('td:eq(4)').html('1');
            if($('.timkiem_user').length>0){
                action='load_more_user_container';
            }else{
                action='load_more_container';
            }
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container:id_container
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    }else{
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_'+id_container).after(info.list);
                            
                        } else {
                        }
                    }
                }
            });
        }

    });
    ////////////////////////
    $('body').on('click','#container_noidia .table_hang .fa-minus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container=($('.tr_more_'+id_container).length)/2 + 1;
        $(this).parent().parent().find('td:eq(2)').html(total_container);
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).hide();
        }else{
        }

    });
    ////////////////////////
    $('body').on('click','#container_noidia .table_hang .fa-plus-circle',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(2)').html('1');
        }else{
            $(this).parent().parent().find('td:eq(2)').html('1');
            if($('.timkiem_user').length>0){
                action='load_more_user_container';
            }else{
                action='load_more_container';
            }
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container:id_container
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    }else{
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_'+id_container).after(info.list);
                            
                        } else {
                        }
                    }
                }
            });
        }

    });
    $('body').on('focus','.box_timkiem input[name=dia_diem]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    $('body').on('click','.box_timkiem input[name=dia_diem]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup','.box_timkiem input[name=dia_diem]',function(){
        text=$(this).val();
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        if(text.length>=1){
            $(this).parent().find('.list_goiy').show();
            $(this).parent().find('.list_goiy').scrollTop(0);
            $selectOptionsList.each(function() {
              var optionText = $(this).text().toLowerCase();
              if (optionText.includes(text.toLowerCase())) {
                //$(this).show();
                $(this).prependTo($list_goiy);
              } else {
                //$(this).hide();
              }
            });
        }else{
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click','.box_timkiem .goiy_tinh',function(){
        ten_tinh=$(this).text();
        id_tinh=$(this).attr('value');
        $('.box_timkiem input[name=dia_diem]').val(ten_tinh);
        $('.box_timkiem input[name=dia_diem_id]').val(id_tinh);
        $('.box_timkiem .list_goiy_tinh').hide();
    });
    ////////////////////////////
    $('body').on('focus','.box_timkiem input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click','.box_timkiem input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup','.box_timkiem input[name=hang_tau]',function(){
        text=$(this).val();
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        if(text.length>=1){
            $(this).parent().find('.list_goiy').show();
            $(this).parent().find('.list_goiy').scrollTop(0);
            $selectOptionsList.each(function() {
              var optionText = $(this).text().toLowerCase();
              if (optionText.includes(text.toLowerCase())) {
                //$(this).show();
                $(this).prependTo($list_goiy);
              } else {
                //$(this).hide();
              }
            });
        }else{
            $('.box_timkiem .list_goiy').hide();
        }
    });
/*    ////////////////////////////
    $('body').on('click','.box_timkiem .goiy_hangtau',function(){
        ten_hangtau=$(this).attr('viet_tat');
        id_hangtau=$(this).attr('value');
        $('.box_timkiem input[name=hang_tau]').val(ten_hangtau);
        $('.box_timkiem input[name=hang_tau_id]').val(id_hangtau);
        $('.box_timkiem .list_goiy_hangtau').hide();
    });
*/    ////////////////////////////
    $('body').on('click','.li_input .goiy_hangtau',function(){
        ten_hangtau=$(this).attr('viet_tat');
        id_hangtau=$(this).attr('value');
        var div=$(this);
        div.parent().parent().find('input[name=hang_tau]').val(ten_hangtau);
        div.parent().parent().find('input[name=hang_tau_id]').val(id_hangtau);
        div.parent().parent().find('.list_goiy').hide();
    });
    ////////////////////////////
    $('body').on('focus','.li_input input[name=tinh]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click','.li_input input[name=tinh]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup','.li_input input[name=tinh]',function(){
        text=$(this).val();
        ten=$(this).attr('ten');
        if(ten!=text){
            $(this).parent().parent().find('select[name=huyen]').html('<option value="">Chọn quận/huyện</option>');
            $(this).parent().parent().find('select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
        }
        var div=$(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if(text.length>=1){
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function() {
              var optionText = $(this).text().toLowerCase();
              if (optionText.includes(text.toLowerCase())) {
                //$(this).show();
                $(this).prependTo($list_goiy);
              } else {
                //$(this).hide();
              }
            });
        }else{
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click','.li_input .goiy_tinh',function(){
        ten_tinh=$(this).text();
        id_tinh=$(this).attr('value');
        var div=$(this);
        div.parent().parent().find('input[name=tinh]').val(ten_tinh);
        div.parent().parent().find('input[name=tinh]').attr('ten',ten_tinh);
        div.parent().parent().find('input[name=tinh_id]').val(id_tinh);
        div.parent().parent().find('.list_goiy').hide();
    });
    ////////////////////////////
    $('body').on('focus','.li_input input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click','.li_input input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup','.li_input input[name=hang_tau]',function(){
        text=$(this).val();
        var div=$(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if(text.length>=1){
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function() {
              var optionText = $(this).text().toLowerCase();
              if (optionText.includes(text.toLowerCase())) {
                //$(this).show();
                $(this).prependTo($list_goiy);
              } else {
                //$(this).hide();
              }
            });
        }else{
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('focus','.box_search input[name=cong_ty]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click','.box_search input[name=cong_ty]',function(){
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup','.box_search input[name=cong_ty]',function(){
        text=$(this).val();
        var div=$(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if(text.length>=1){
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function() {
              var optionText = $(this).text().toLowerCase();
              if (optionText.includes(text.toLowerCase())) {
                //$(this).show();
                $(this).prependTo($list_goiy);
              } else {
                //$(this).hide();
              }
            });
        }else{
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click','.box_search .goiy_congty',function(){
        ten_congty=$(this).text();
        $('.box_search input[name=cong_ty]').val(ten_congty);
        $('.box_search .list_goiy_congty').hide();
    });
    ////////////////////////////
    $('body').on('keyup','.box_timkiem input[name=dia_diem]',function(){
        text=$(this).val();
        if(text.length>2){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'goiy_tinh',
                    text:text,
                },
                dataType:'json',
                success: function(info) {
                    $('.goiy').html(info.list);
                    if(info.ok==1){
                        $('.box_timkiem .list_goiy').html(info.list);
                    }else{
                        $('.box_timkiem .list_goiy').html('');
                    }
                    
                }
            });
        }else{
            $('.box_timkiem .list_goiy').html('');
        }
    });
/*    ////////////////////////////
    $('body').on('click','.box_timkiem .li_goiy',function(){
        ten_tinh=$(this).text();
        id_tinh=$(this).attr('value');
        $('.box_timkiem input[name=dia_diem]').val(ten_tinh);
        $('.box_timkiem input[name=dia_diem_id]').val(id_tinh);
        $('.box_timkiem .list_goiy').html('');
    });*/
    $(document).click(function(e) {
        if (!$('button[name=export_naptien]').is(e.target) && $('button[name=export_naptien]').has(e.target).length === 0 && !$('.box_xuat').is(e.target) && $('.box_xuat').has(e.target).length === 0) {
            $('.box_xuat').hide();
        }
        if (!$('button[name=loc]').is(e.target) && $('button[name=loc]').has(e.target).length === 0 && !$('.box_loc').is(e.target) && $('.box_loc').has(e.target).length === 0) {
            $('.box_loc').hide();
        }
        if (!$('.li_tab_content input[name=hang_tau]').is(e.target) && $('.li_tab_content input[name=hang_tau]').has(e.target).length === 0 && !$('.li_tab_content .list_goiy_hangtau').is(e.target) && $('.li_tab_content .list_goiy_hangtau').has(e.target).length === 0) {
            $('.li_tab_content .list_goiy_hangtau').hide();
        }
        if (!$('.li_tab_content input[name=tinh_donghang]').is(e.target) && $('.li_tab_content input[name=tinh_donghang]').has(e.target).length === 0 && !$('.li_tab_content input[name=tinh]').is(e.target) && $('.li_tab_content input[name=tinh]').has(e.target).length === 0 && !$('.li_tab_content .list_goiy_tinh').is(e.target) && $('.li_tab_content .list_goiy_tinh').has(e.target).length === 0) {
            $('.li_tab_content .list_goiy_tinh').hide();
        }
        if (!$('.box_timkiem input[name=hang_tau]').is(e.target) && $('.box_timkiem input[name=hang_tau]').has(e.target).length === 0 && !$('.box_timkiem .list_goiy_hangtau').is(e.target) && $('.box_timkiem .list_goiy_hangtau').has(e.target).length === 0) {
            $('.box_timkiem .list_goiy_hangtau').hide();
        }
        if (!$('.box_timkiem input[name=dia_diem]').is(e.target) && $('.box_timkiem input[name=dia_diem]').has(e.target).length === 0 && !$('.box_timkiem .list_goiy_tinh').is(e.target) && $('.box_timkiem .list_goiy_tinh').has(e.target).length === 0) {
            $('.box_timkiem .list_goiy_tinh').hide();
        }
        if (!$('.box_search input[name=cong_ty]').is(e.target) && $('.box_search input[name=cong_ty]').has(e.target).length === 0 && !$('.box_search .list_goiy_congty').is(e.target) && $('.box_search .list_goiy_congty').has(e.target).length === 0) {
            $('.box_search .list_goiy_congty').hide();
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=timkiem_booking]', function() {
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem select[name=hang_tau]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(loai_hinh==''){
            noti('Vui lòng chọn loại hình',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking",
                    loai_hinh:loai_hinh,
                    hang_tau:hang_tau,
                    loai_container:loai_container,
                    dia_diem:dia_diem,
                    dia_diem_id:dia_diem_id,
                    from:from,
                    to:to
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            if(loai_hinh=='hangnhap'){
                                $('.box_loai_hinh #loai_hinh_nhap').click();
                                $('.box_container_left').hide();
                                $('.box_container_right').show();
                                $('.box_container_right .table_hang').html(info.list);
                            }else{
                                $('.box_loai_hinh #loai_hinh_xuat').click();
                                $('.box_container_left').show();
                                $('.box_container_right').hide();
                                $('.box_container_left .table_hang').html(info.list);
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=timkiem_booking_user]', function() {
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem select[name=hang_tau]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(loai_hinh==''){
            noti('Vui lòng chọn loại hình',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_user",
                    loai_hinh:loai_hinh,
                    hang_tau:hang_tau,
                    loai_container:loai_container,
                    dia_diem:dia_diem,
                    dia_diem_id:dia_diem_id,
                    from:from,
                    to:to
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            if(loai_hinh=='hangnhap'){
                                $('.box_loai_hinh #loai_hinh_nhap').click();
                                $('#container_hangxuat').hide();
                                $('#container_noidia').hide();
                                $('#container_hangnhap').show();
                                $('#container_hangnhap .table_hang').html(info.list);
                            }else if(loai_hinh=='hang_noidia'){
                                $('.box_loai_hinh #loai_hinh_noidia').click();
                                $('#container_hangxuat').hide();
                                $('#container_hangnhap').hide();
                                $('#container_noidia').show();
                                $('#container_noidia .table_hang').html(info.list);
                            }else{
                                $('.box_loai_hinh #loai_hinh_xuat').click();
                                $('#container_hangxuat').show();
                                $('#container_noidia').hide();
                                $('#container_hangnhap').hide();
                                $('#container_hangxuat .table_hang').html(info.list);
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    ///////////////////
    setTimeout(function(){
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "load_tk_notification"
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.total_notification').html(info.total);
                $('.total_booking_wait').html(info.total_booking_wait);
                $('.total_booking_confirm').html(info.total_booking_confirm);
                $('.total_booking_false').html(info.total_booking_false);
                $('.total_nap').html(info.total_naptien);
                $('.total_chat').html(info.total_chat);
            }

        });
        
    },3000);
    ///////////////////////////
    $('body').on('click','.menu_top .menu_top_right .notification .tab_notification .li_tab',function(){
        $('.tab_notification .li_tab').removeClass('active');
        $(this).addClass('active');
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }
        $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_notification',
                loai:loai,
                page:1
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.list_notification .list_noti .loading_notification').remove();
                    $('.list_notification .list_noti').append(info.list);
                    $('.list_notification .list_noti').attr('page',info.page);
                    $('.list_notification .list_noti').attr('tiep',info.tiep);
                    $('.list_notification .list_noti').attr('loaded',1);
                }, 1000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click','.menu_top .menu_top_right .notification .icon_notification',function(){
        $('.list_notification').toggleClass('active');
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }        
        if($('.list_notification').hasClass('active')){
            $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_notification',
                    loai:loai,
                    page:1
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.list_notification .list_noti .loading_notification').remove();
                        $('.list_notification .list_noti').append(info.list);
                        $('.list_notification .list_noti').attr('page',info.page);
                        $('.list_notification .list_noti').attr('tiep',info.tiep);
                        $('.list_notification .list_noti').attr('loaded',1);
                    }, 1000);
                }
            });
        }else{
        }
    });
        ////////////////////////
    $('.list_notification .list_noti').on('scroll', function() {
        tab=$('.tab_notification .li_tab.active').attr('id');
        if(tab=='tab_all'){
            loai='all';
        }else{
            loai='chuadoc';
        }
        div_notification=$('.list_notification .list_noti');
        if(div_notification.scrollTop() + div_notification.innerHeight() >= div_notification[0].scrollHeight - 10) {
            tiep=$('.list_notification .list_noti').attr('tiep');
            page=$('.list_notification .list_noti').attr('page');
            loaded=$('.list_notification .list_noti').attr('loaded');
            if(loaded==1 && tiep==1){
                $('.list_notification .list_noti').prepend('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_notification .list_noti').attr('loaded',0);
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: 'load_notification',
                            loai:'all',
                            page: page,
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('.list_notification .list_noti .loading_notification').remove();
                            $('.list_notification .list_noti').append(info.list);
                            $('.list_notification .list_noti').attr('page',info.page);
                            $('.list_notification .list_noti').attr('tiep',info.tiep);
                            $('.list_notification .list_noti').attr('loaded',1);
                        }
                    });
                },1000);
            }
        }
    })
    //////////////////////////////
    $('#dinh_kem').on('change', function() {
        var phien=$('#submit_yeucau').attr('phien');
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        var form_data = new FormData();
        form_data.append('action', 'upload_dinhkem');
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        form_data.append('phien', phien);
        form_data.append('sms_id', sms_id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu={
                            "list_out":info.list_out,
                            'list':info.list,
                            'phien':phien,
                            'loai':'admin',
                            'user_out':info.user_out,
                            'thanh_vien':info.thanh_vien
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi',info_chat);
                    }
                }, 3000);
            }

        });
    });
    ////////////////////////////
    $('body').on('click','.hide_pop_thirth',function(){
        $('.pop_thirth').html('');
        $('.pop_thirth').hide();
        if($('.box_pop_add .pop_second').length<1){
            $('.box_pop_add').html('');
            $('.box_pop_add').hide();
        }else{

        }
    });
    ////////////////////////////
    $('body').on('click','.pop_second .title .material-icons',function(){
        $('.pop_second').hide();
        $('.pop_second').html('');
        if($('.box_pop_add_content').length<1){
            $('.box_pop_add').hide();
            $('.box_pop_add').html('');
        }
    });
    ////////////////////////////
    $('body').on('click','.box_pop_add .pop_title .fa-close',function(){
        $('.box_pop_add').hide();
        $('.box_pop_add').html('');
    });
    ////////////////////////////
    $('body').on('click','.box_pop_add button#cancel',function(){
        $('.box_pop_add').hide();
        $('.box_pop_add').html('');
    });
    $('body').on('keyup','.note_edit',function(){
        noidung=$(this).html();
        id=$(this).attr('id_bh');
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'update_note_baohanh',
                    noidung:noidung,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                }
            });
        },1000);

    });
    $('body').on('keyup','.note_edit_hotro',function(){
        noidung=$(this).html();
        id=$(this).attr('id_bh');
        setTimeout(function(){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'update_note_hotro',
                    noidung:noidung,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                }
            });
        },1000);

    });
    /////////////////////////////
    $('.cover').click(function() {
        $('#cover').click();
    });
    /////////////////////////////
    $('body').on('click','.mh',function() {
        $('#minh_hoa').click();
    });
    /////////////////////////////
    $('body').on('click','#chon_anh',function() {
        $('#minh_hoa').click();
    });
    $("body").on('change','#minh_hoa',function() {
        readURL(this, 'preview-minhhoa');
    });
    $("#cover").change(function() {
        readURL(this, 'preview-cover');
    });
    /////////////////////////////
    $('.mh_socdo').click(function() {
        $('#minh_hoa_socdo').click();
    });
    $("#minh_hoa_socdo").change(function() {
        readURL(this, 'preview-minhhoa-socdo');
    });
    /////////////////////////////
    $('.mh_popup').click(function() {
        $('#popup').click();
    });
    $("#popup").change(function() {
        readURL(this, 'preview-popup');
    });
    /////////////////////////////
    $('#box_pop_confirm .button_cancel').on('click', function() {
        $('#title_confirm').html('');
        $('#button_thuchien').attr('action', '');
        $('#button_thuchien').attr('post_id', '');
        $('#button_thuchien').attr('loai', '');
        $('#box_pop_confirm').hide();
    });
    /////////////////////////////
    $('body').on('click','.del_xa',function(){
        id=$(this).attr('id');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang muốn <b>xóa</b> xã/phường này!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'del_xa');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click','.del_huyen',function(){
        id=$(this).attr('id');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Khi bạn thực hiện sẽ <b>xóa</b> quận/huyện và địa phương trực thuộc!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'del_huyen');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click','.del_tinh',function(){
        id=$(this).attr('id');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Khi bạn thực hiện sẽ <b>xóa</b> Tỉnh/TP và địa phương trực thuộc!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'del_tinh');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click','#box_pop_confirm #button_thuchien',function(){
        action=$(this).attr('action');
        id=$(this).attr('post_id');
        loai=$(this).attr('loai');
        if(action=='del_xa'){
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "del",
                    loai:'xa',
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }else if(action=='del_huyen'){
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "del",
                    loai:'huyen',
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }else if(action=='del_tinh'){
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "del",
                    loai:'tinh',
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('.box_profile').on('click', '.button_select_photo', function() {
        $('#photo-add').click();
    });
    $('#photo-add').on('change', function() {
        var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        $.each($("input[name=file]")[0].files, function(i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.list_photo').append(info.list);
                    }
                }, 3000);
            }

        });
    });
    $('.tieude_seo').on('paste', function(event) {
        if ($(this).hasClass('uncheck_blank')) {} else {
            setTimeout(function() {
                check_blank();
            }, 1000);
        }
    });
    $('.box_form input[name=link_video]').on('paste', function(event) {
        setTimeout(function() {
            link_video = $('input[name=link_video]').val();
            var vars = [],
                hash;
            var hashes = link_video.slice(link_video.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++) {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            id_video = vars['v'];
            $('#preview-minhhoa').attr('src', 'https://i.ytimg.com/vi/' + id_video + '/sddefault.jpg');
        }, 500);
    });
    /////////////////////////////
    $('body').on('click','.drop_down button', function() {
        //$('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).parent().find('.drop_menu').is(':visible')) {
            $(this).parent().find('.drop_menu').slideUp('300');
        } else {
            $(this).parent().find('.drop_menu').slideDown('300');
        }
    });
    $(document).click(function(e) {
        var dr = $(".drop_menu");
        var drd=$('.drop_down');
        // Nếu click bên ngoài .drop_menu
        if (!dr.is(e.target) && dr.has(e.target).length === 0 && !drd.is(e.target) && drd.has(e.target).length === 0) {
            dr.slideUp('300');
        }
    });
    /////////////////////////////
    $('#ckOk').on('click', function() {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function(e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////
    $('#btnSearch').on('click', function() {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function() {
        var t = $(this);
        var p = $(this).parent().find('.panel-collapse');
        if (t.hasClass("active-panel")) {
            $(this).parent().find('.panel-collapse').slideUp();
        } else {
            $(this).parent().find('.panel-collapse').slideDown();
        }
        /*      if(p.hasClass("active-panel")){
                    setTimeout(function(){
                        $(this).parent().find('.panel-collapse').removeClass('in');
                    },1000);
                }else{
                    setTimeout(function(){
                        $(this).parent().find('.panel-collapse').addClass('in');
                    },1000);
                }*/
        $(this).toggleClass('active-panel');

    });
    /////////////////////////////
    $('.item-cat a').on('click', function() {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('button[name=button_doanhso_naptien]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhso_naptien');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_cho_xacnhan').html(info.doanhthu_cho_xacnhan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#giaodich_hoanthanh').html(info.giaodich_hoanthanh);
                            $('#giaodich_huy').html(info.giaodich_huy);
                            $('#giaodich_cho_xacnhan').html(info.giaodich_cho_xacnhan);
                            $('#giaodich_cho').html(info.giaodich_cho);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_doanhso_naptien_cskh]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        time_end = $('.box_time input[name=id]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhso_naptien_cskh');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhthu_hoanthanh').html(info.doanhthu_hoanthanh);
                            $('#doanhthu_huy').html(info.doanhthu_huy);
                            $('#doanhthu_cho_xacnhan').html(info.doanhthu_cho_xacnhan);
                            $('#doanhthu_cho').html(info.doanhthu_cho);
                            $('#giaodich_hoanthanh').html(info.giaodich_hoanthanh);
                            $('#giaodich_huy').html(info.giaodich_huy);
                            $('#giaodich_cho_xacnhan').html(info.giaodich_cho_xacnhan);
                            $('#giaodich_cho').html(info.giaodich_cho);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_doanhso_chitieu]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhso_chitieu');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhso_chi').html(info.doanhso_chi);
                            $('#doanhso_hoan').html(info.doanhso_hoan);
                            $('#giaodich_chi').html(info.giaodich_chi);
                            $('#giaodich_hoan').html(info.giaodich_hoan);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_doanhso_chitieu_cskh]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        id=$('.box_time input[name=id]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhso_chitieu_cskh');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhso_chi').html(info.doanhso_chi);
                            $('#doanhso_hoan').html(info.doanhso_hoan);
                            $('#giaodich_chi').html(info.giaodich_chi);
                            $('#giaodich_hoan').html(info.giaodich_hoan);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('.box_search #timkiem_thanhvien').on('click', function() {
        key = $('.box_search input[name=key]').val();
        if (key.length < 2) {
            $('.box_search input[name=key]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'timkiem_thanhvien');
            form_data.append('key', key);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('.box_search input[name=key]').on('keypress', function(e) {
        if(e.which==13){
            key = $('.box_search input[name=key]').val();
            if (key.length < 2) {
                $('.box_search input[name=key]').focus();
            } else {
                $('.load_overlay2').show();
                $('.load_process_2').fadeIn();
                var form_data = new FormData();
                form_data.append('action', 'timkiem_thanhvien');
                form_data.append('key', key);
                $.ajax({
                    url: '/admincp/process.php',
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function() {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                            if (info.ok == 1) {
                                $(".table_hang tr:not(:first)").remove();
                                $(".table_hang tr:first").after(info.list);
                            } else {

                            }
                        }, 2000);
                    }

                });
            }
        }
    });
    /////////////////////////////
    $('button[name=button_doanhso_booking]').on('click', function() {
        time_begin = $('input[name=begin]').val();
        time_end = $('input[name=end]').val();
        if (time_begin.length < 10) {
            $('input[name=begin]').focus();
        } else if (time_end.length < 10) {
            $('input[name=end]').focus();
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var form_data = new FormData();
            form_data.append('action', 'load_doanhso_booking');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhso_tao').html(info.doanhso_tao);
                            $('#doanhso_hoanthanh').html(info.doanhso_hoanthanh);
                            $('#doanhso_cho_xacnhan').html(info.doanhso_cho_xacnhan);
                            $('#doanhso_xacnhan').html(info.doanhso_xacnhan);
                            $('#doanhso_cho').html(info.doanhso_cho);
                            $('#doanhso_tuchoi').html(info.doanhso_tuchoi);
                            $('#booking_tao').html(info.booking_tao);
                            $('#booking_hoanthanh').html(info.booking_hoanthanh);
                            $('#booking_cho_xacnhan').html(info.booking_cho_xacnhan);
                            $('#booking_xacnhan').html(info.booking_xacnhan);
                            $('#booking_cho').html(info.booking_cho);
                            $('#booking_tuchoi').html(info.booking_tuchoi);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('.remember').on('click', function() {
        value = $(this).attr('value');
        if (value == 'on') {
            $('.remember i').removeClass('fa-check-circle-o');
            $('.remember i').addClass('fa-circle-o');
            $(this).attr('value', 'off');
        } else {
            $('.remember i').removeClass('fa-circle-o');
            $('.remember i').addClass('fa-check-circle-o');
            $(this).attr('value', 'on');
        }

    });
    /////////////////////////////
    $('body').on('click', '.li_photo i', function() {
        var item = $(this);
        if(item.parent().find('video').length>0){
            anh = item.parent().find('video').attr('src');

        }else{
            anh = item.parent().find('img').attr('src');
        }
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "del_photo",
                anh: anh
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                item.parent().parent().remove();
            }

        });
    });
    /////////////////////////////
    $('body').on('keyup','.box_yeucau .box_search input',function(){
        ten_khach=$(this).val();
        if(ten_khach.length>2){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'goiy_khach',
                    ten_khach:ten_khach,
                },
                dataType:'json',
                success: function(info) {
                    $('.box_yeucau .box_search .goi_y').html(info.list);
                    if(info.ok==1){
                        $('.box_yeucau .box_search .goi_y').show();
                    }else{
                        $('.box_yeucau .box_search .goi_y').hide();
                    }
                    
                }
            });
        }else{
            $('.box_yeucau .box_search .goi_y').html('');
            $('.box_yeucau .box_search .goi_y').hide();
        }
    });
    /////////////////////////////
    $('body').on('click','.box_yeucau .box_search .goi_y .li_goi_y',function(){
        thanh_vien=$(this).attr('thanhvien');
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_box_pop_thirth',
                thanh_vien:thanh_vien,
                loai: 'add_yeucau_lienhe'
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html('<div class="pop_thirth"></div>');
                $('.pop_thirth').html(info.html);
                $('.pop_thirth').fadeIn();
                $('.box_pop_add').show();
                $('.box_yeucau .box_search input').val('');
                $('.box_yeucau .box_search .goi_y').html('');
                $('.box_yeucau .box_search .goi_y').hide();
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.pop_add_lienhe button[name=gui_ykien]',function(){
        var noi_dung=$('.pop_add_lienhe textarea[name=noi_dung]').val();
        var thanh_vien=$('.pop_add_lienhe input[name=thanh_vien]').val();
        var user_out=$('.pop_add_lienhe input[name=user_out]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_yeucau_traodoi',
                thanh_vien:thanh_vien,
                noi_dung:noi_dung,
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if(info.ok==1){
                        $('#list_yeucau .li_yeucau').removeClass('active');
                        $('#list_yeucau').prepend(info.list);
                        $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                        $('.box_yeucau_hotro #submit_yeucau').attr('phien',info.phien_traodoi);
                        $('.box_yeucau_hotro #list_chat').html('');
                        $('.box_yeucau_hotro .note_content .txt').html(noi_dung);
                        $('.box_pop_add').hide();
                        $('.box_pop_add').html('');
                        var dulieu={
                            'user_out':user_out,
                            'thanh_vien':thanh_vien
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_list_yeucau',info_chat);
                    }else{

                    }
                }, 2000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.box_yeucau_hotro .box_yeucau .list_yeucau .list .li_yeucau',function(){
        var thanh_vien=$(this).attr('thanh_vien');
        var user_out=$('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=user_out]').val();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_khach_traodoi',
                thanh_vien:thanh_vien,
                user_out:user_out
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    $('#list_yeucau').html(info.list);
                    $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                    $('.box_yeucau_hotro #submit_yeucau').attr('phien',info.phien);
                    $('.box_yeucau_hotro #list_chat').html(info.list_chat);
                    $('input[name=load_chat]').val(info.load_chat);
                    $('.box_chat input[name=thanh_vien]').val(info.thanh_vien);
                    $('.box_yeucau_hotro .note_content .txt').html(info.note);
/*                    var dulieu={
                        'user_out':info.user_out,
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_list_yeucau',info_chat);*/
                }else{

                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click','.box_chat #submit_yeucau',function(){
        var phien=$(this).attr('phien');
        var noi_dung=$('.box_chat input[name=noidung_yeucau]').val();
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_sms_traodoi',
                phien:phien,
                noi_dung:noi_dung,
                sms_id:sms_id
            },
            success: function(kq) {
                $('.box_chat input[name=noidung_yeucau]').val('');
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                var info = JSON.parse(kq);
                $('#list_chat').append(info.list);
                scrollSmoothToBottom('list_chat');
                var dulieu={
                    "list_out":info.list_out,
                    'list':info.list,
                    'user_out':info.user_out,
                    'phien':info.phien,
                    'loai':'admin',
                    'thanh_vien':info.thanh_vien
                }
                var info_chat=JSON.stringify(dulieu);
                socket.emit('user_send_traodoi',info_chat);
            }
        });

    });
    $('body').on('keypress','.box_chat input[name=noidung_yeucau]',function(e){
        if(e.which == 13) {
            var phien=$('.box_chat #submit_yeucau').attr('phien');
            var noi_dung=$('.box_chat input[name=noidung_yeucau]').val();
            var user_out=$('.box_chat input[name=user_out]').val();
            if($('#list_chat .txt').length>0){
                sms_id=$('#list_chat .li_sms').last().attr('sms_id');
            }else{
                sms_id=0;
            }
            $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
            $('.box_chat .text_status .loading_chat').show();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'add_sms_traodoi',
                    phien:phien,
                    noi_dung:noi_dung,
                    sms_id:sms_id
                },
                success: function(kq) {
                    $('.box_chat input[name=noidung_yeucau]').val('');
                    $('.box_chat .text_status .loading_chat').hide();
                    $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                    var info = JSON.parse(kq);
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu={
                        "list_out":info.list_out,
                        'list':info.list,
                        'user_out':info.user_out,
                        'phien':info.phien,
                        'loai':'admin',
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi',info_chat);
                }
            });
        }else{
        }
    });
    $('body').on('click','.box_sticker .li_sticker img',function(e){
        $('.box_sticker').hide();
        var phien=$('.box_chat #submit_yeucau').attr('phien');
        var src=$(this).attr('src');
        var user_out=$('.box_chat input[name=user_out]').val();
        if($('#list_chat .txt').length>0){
            sms_id=$('#list_chat .li_sms').last().attr('sms_id');
        }else{
            sms_id=0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'add_sticker_traodoi',
                phien:phien,
                src:src,
                sms_id:sms_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                $('.box_chat input[name=noidung_yeucau]').val('');
                if(info.ok==1){
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu={
                        "list_out":info.list_out,
                        'list':info.list,
                        'phien':phien,
                        'loai':'admin',
                        'user_out':info.user_out,
                        'thanh_vien':info.thanh_vien
                    }
                    var info_chat=JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi',info_chat);
                }else{
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý...');
                        $('.load_overlay').hide();
                    }, 2000);
                }
            }
        });
    });
    //////////////////////////
    var lastScrollTop = 0;
    $('#list_chat').scroll(function() {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {

        } else {
            load = $('input[name=load_chat]').val();
            loaded = $('input[name=load_chat]').attr('loaded');
            sms_id=$('#list_chat .li_sms').first().attr('sms_id');
            var phien=$('.box_chat #submit_yeucau').attr('phien');
            if(st < 50 && loaded == 1 && load == 1) {
                $('#list_chat').prepend('<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
                $('input[name=load_chat]').attr('loaded','0');
                setTimeout(function(){
                    $.ajax({
                        url: "/admincp/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_sms",
                            phien:phien,
                            sms_id:sms_id
                        },
                        success: function(kq) {
                            var info = JSON.parse(kq);
                            $('#list_chat .li_load_chat').remove();
                            $('input[name=load_chat]').val(info.load_chat);
                            $('input[name=load_chat]').attr('loaded','1');
                            if(info.ok==1){
                                $('#list_chat').prepend(info.list_chat);
                                total_height=0;
                                $('#list_chat .li_sms').each(function(){
                                    if($(this).attr('sms_id')<sms_id){
                                        total_height+=$(this).outerHeight();
                                    }
                                });
                                $('#list_chat').animate({
                                    scrollTop: total_height - 50
                                }, 200);
                            }else{
                            }
                        }
                    });
                },3000);
            } else {

            }
        }
        lastScrollTop = st;

    });
    /////////////////////////////
    socket.on("server_send_traodoi",function(data){
        user_out=$('.box_chat input[name=user_out]').val();
        phien=$('#submit_yeucau').attr('phien');
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        console.log('user out:'+user_out);
        console.log('info out:'+info.user_out);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $('#play_chat').click();
                if(phien==info.phien){
                    if(info.loai=='admin'){
                        $('#list_chat').append(info.list);
                    }else{
                        $('#list_chat').append(info.list_out);
                    }
                    scrollSmoothToBottom('list_chat');
                }
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_list_yeucau",function(data){
        phien=$('#submit_yeucau').attr('phien');
        user_out=$('.box_chat input[name=user_out]').val();
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'load_list_yeucau',
                        phien:phien
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        if(info.total==0){
                        }else{
                            $('#play_chat_global').click();
                        }
                        $('#list_yeucau').html(info.list);
                        $('.total_notification').html(info.total);
                        $('.total_booking_wait').html(info.total_booking_wait);
                        $('.total_booking_confirm').html(info.total_booking_confirm);
                        $('.total_booking_false').html(info.total_booking_false);
                        $('.total_nap').html(info.total_naptien);
                        $('.total_chat').html(info.total_chat);
                    }
                });
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_dong_yeucau",function(data){
        phien=$('#submit_yeucau').attr('phien');
        user_out=$('.box_chat input[name=user_out]').val();
        bo_phan=$('input[name=bophan_hotro]').val();
        var info=JSON.parse(data);
        if(user_out==info.user_out){
        }else{
            if(bo_phan==info.bo_phan || bo_phan=='all'){
                $.ajax({
                    url: "/admincp/process.php",
                    type: "post",
                    data: {
                        action: 'load_list_yeucau',
                        phien:phien
                    },
                    success: function(kq) {
                        var info = JSON.parse(kq);
                        $('#list_yeucau').html(info.list);
                    }
                });
            }
        }
    });
    /////////////////////////////
    $('body').on('click','.box_chat #dong_yeucau',function(){
        phien=$('.box_chat #submit_yeucau').attr('phien');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'dong_yeucau',
                phien:phien
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                        var dulieu={
                            'user_out':info.user_out,
                            'thanh_vien':info.thanh_vien,
                            'phien':info.phien,
                            'bo_phan':info.bo_phan
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_dong_yeucau',info_chat);
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    socket.on("server_send_hoatdong",function(data){
        var info=JSON.parse(data);
        bo_phan=$('input[name=bophan_hotro]').val();
        if(info.hd=='user_notification'){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_tk_notification',
                    bo_phan:bo_phan
                },
                success: function(kq) {
                    var infox = JSON.parse(kq);
                    if(infox.total==0){
                    }else{
                        $('#play_chat_global').click();
                    }
                    $('.total_notification').html(infox.total);
                    $('.total_booking_wait').html(infox.total_booking_wait);
                    $('.total_booking_confirm').html(infox.total_booking_confirm);
                    $('.total_booking_false').html(infox.total_booking_false);
                    $('.total_nap').html(infox.total_naptien);
                    $('.total_chat').html(infox.total_chat);
                }
            });
        }else if(info.hd=='add_naptien'){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_tk_notification',
                    bo_phan:bo_phan
                },
                success: function(kqx) {
                    var infox = JSON.parse(kqx);
                    if(infox.total==0){
                    }else{
                        $('#play_chat_global').click();
                    }
                    $('.total_notification').html(infox.total);
                    $('.total_booking_wait').html(infox.total_booking_wait);
                    $('.total_booking_confirm').html(infox.total_booking_confirm);
                    $('.total_booking_false').html(infox.total_booking_false);
                    $('.total_nap').html(infox.total_naptien);
                    $('.total_chat').html(infox.total_chat);
                }
            });
        }else if(info.hd=='hoatdong_user'){
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: 'load_list_user',
                    phongban:info.phongban
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==1){
                        $('.box_pop_list_user_table').html(info.list);
                    }
                }
            });
        }
    });
    /////////////////////////////
    $('.box_form button[name=add_tinh]').on('click', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        thu_tu = $('.box_form input[name=thu_tu]').val();
        if(tieu_de.length<3){
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên Tỉnh/TP',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_tinh",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form input[name=tieu_de]').val('');
                            $('.box_form input[name=thu_tu]').val('');
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=add_tinh]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên Tỉnh/TP',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_tinh",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=edit_tinh]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        id = $('.box_pop_add input[name=id]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên Tỉnh/TP',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_tinh",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=add_huyen]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        tinh = $('.box_pop_add input[name=tinh]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên quận/huyện',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_huyen",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    tinh:tinh
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=edit_huyen]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        id = $('.box_pop_add input[name=id]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên quận/huyện',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_huyen",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=add_xa]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        tinh = $('.box_pop_add input[name=tinh]').val();
        huyen = $('.box_pop_add input[name=huyen]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên xã/phường',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_xa",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    tinh:tinh,
                    huyen:huyen
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click','.box_pop_add button[name=edit_xa]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        id = $('.box_pop_add input[name=id]').val();
        if(tieu_de.length<3){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên quận/huyện',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_huyen",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=add_naptien]').on('click', function() {
        username = $('.box_form input[name=username]').val();
        sotien = $('.box_form input[name=sotien]').val();
        loai = $('.box_form select[name=loai]').val();
        noidung = $('.box_form textarea[name=noidung]').val();
        if(username.length<3){
            $('.box_form input[name=username]').focus();
            noti('Vui lòng nhập tài khoản nhận tiền',0,2000);
        }else if(sotien==''){
            $('.box_form input[name=sotien]').focus();
            noti('Vui lòng nhập số tiền',0,2000);
        }else if(noidung==''){
            $('.box_form textarea[name=noidung]').focus();
            noti('Vui lòng nhập nội dung',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_naptien",
                    username: username,
                    sotien: sotien,
                    loai: loai,
                    noidung: noidung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=edit_naptien]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_naptien",
                status: status,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        var dulieu={
                            'hd':'xacnhan_naptien',
                            'user_id':info.user_id
                        }
                        var info_chat=JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong',info_chat);
                        window.location.href = '/admincp/list-naptien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_ruttien]').on('click', function() {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_ruttien",
                status: status,
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admincp/list-ruttien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click','button[name=add_goi_giahan]', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        so_tien = $('.box_form input[name=so_tien]').val();
        thoi_gian = $('.box_form input[name=thoi_gian]').val();
        thu_tu = $('.box_form input[name=thu_tu]').val();
        status = $('.box_form input[name=active]:checked').val();
        if(tieu_de.length<3){
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên gói',0,2000);
        }else if(so_tien==''){
            $('.box_form input[name=so_tien]').focus();
            noti('Vui lòng nhập phí gia hạn',0,2000);
        }else if(thoi_gian==''){
            $('.box_form input[name=thoi_gian]').focus();
            noti('Vui lòng nhập số ngày gia hạn',0,2000);
        }else if(thu_tu==''){
            $('.box_form input[name=thu_tu]').focus();
            noti('Vui lòng nhập số thứ tự hiển thị',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_goi_giahan",
                    tieu_de:tieu_de,
                    so_tien:so_tien,
                    thoi_gian:thoi_gian,
                    thu_tu:thu_tu,
                    status:status
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form input[name=tieu_de]').val('');
                            $('.box_form input[name=so_tien]').val('');
                            $('.box_form input[name=thoi_gian]').val('');
                            $('.box_form input[name=thu_tu]').val('');
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_goi_giahan]', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        so_tien = $('.box_form input[name=so_tien]').val();
        thoi_gian = $('.box_form input[name=thoi_gian]').val();
        thu_tu = $('.box_form input[name=thu_tu]').val();
        id = $('.box_form input[name=id]').val();
        status = $('.box_form input[name=active]:checked').val();
        if(tieu_de.length<3){
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên gói',0,2000);
        }else if(so_tien==''){
            $('.box_form input[name=so_tien]').focus();
            noti('Vui lòng nhập phí gia hạn',0,2000);
        }else if(thoi_gian==''){
            $('.box_form input[name=thoi_gian]').focus();
            noti('Vui lòng nhập số ngày gia hạn',0,2000);
        }else if(thu_tu==''){
            $('.box_form input[name=thu_tu]').focus();
            noti('Vui lòng nhập số thứ tự hiển thị',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_goi_giahan",
                    tieu_de:tieu_de,
                    so_tien:so_tien,
                    thoi_gian:thoi_gian,
                    thu_tu:thu_tu,
                    status:status,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href='/admincp/list-goi-giahan';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=add_danhmuc]', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        if(tieu_de.length<3){
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên gói',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_danhmuc",
                    tieu_de:tieu_de,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form input[name=tieu_de]').val('');
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_danhmuc]', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        id = $('.box_form input[name=id]').val();
        if(tieu_de.length<3){
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên gói',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_danhmuc",
                    tieu_de:tieu_de,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href='/admincp/list-danhmuc';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_cskh]', function() {
        id = $('.box_pop_add input[name=id]').val();
        ho_ten = $('.box_pop_add input[name=ho_ten]').val();
        dien_thoai = $('.box_pop_add input[name=dien_thoai]').val();
        cskh = $('.box_pop_add select[name=cskh]').val();
        if(ho_ten.length<3){
            $('.box_pop_add input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        }else if(dien_thoai.length<3){
            $('.box_pop_add input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_cskh",
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    cskh:cskh,
                    id: id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_thanhvien]', function() {
        id = $('.box_pop_add input[name=id]').val();
        cong_ty = $('.box_pop_add input[name=cong_ty]').val();
        maso_thue = $('.box_pop_add input[name=maso_thue]').val();
        ho_ten = $('.box_pop_add input[name=ho_ten]').val();
        dien_thoai = $('.box_pop_add input[name=dien_thoai]').val();
        email = $('.box_pop_add input[name=email]').val();
        nhom = $('.box_pop_add select[name=nhom]').val();
        if(cong_ty.length<3){
            $('.box_pop_add input[name=cong_ty]').focus();
            noti('Vui lòng nhập tên công ty',0,2000);
        }else if(maso_thue.length<3){
            $('.box_pop_add input[name=maso_thue]').focus();
            noti('Vui lòng nhập mã số thuế',0,2000);
        }else if(ho_ten.length<3){
            $('.box_pop_add input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        }else if(dien_thoai.length<3){
            $('.box_pop_add input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        }else if(email.length<3){
            $('.box_pop_add input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_thanhvien",
                    cong_ty:cong_ty,
                    maso_thue:maso_thue,
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    email:email,
                    nhom:nhom,
                    id: id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=add_thanhvien]', function() {
        cong_ty = $('.box_pop_add input[name=cong_ty]').val();
        maso_thue = $('.box_pop_add input[name=maso_thue]').val();
        ho_ten = $('.box_pop_add input[name=ho_ten]').val();
        dien_thoai = $('.box_pop_add input[name=dien_thoai]').val();
        email = $('.box_pop_add input[name=email]').val();
        nhom = $('.box_pop_add select[name=nhom]').val();
        password = $('.box_pop_add input[name=password]').val();
        re_password = $('.box_pop_add input[name=re_password]').val();
        if(cong_ty.length<3){
            $('.box_pop_add input[name=cong_ty]').focus();
            noti('Vui lòng nhập tên công ty',0,2000);
        }else if(maso_thue.length<3){
            $('.box_pop_add input[name=maso_thue]').focus();
            noti('Vui lòng nhập mã số thuế',0,2000);
        }else if(ho_ten.length<3){
            $('.box_pop_add input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        }else if(dien_thoai.length<3){
            $('.box_pop_add input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        }else if(email.length<3){
            $('.box_pop_add input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        }else if(password.length<3){
            $('.box_pop_add input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu dài từ 6 ký tự',0,2000);
        }else if(password!=re_password){
            $('.box_pop_add input[name=re_password]').focus();
            noti('Xác nhận mật khẩu không khớp',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_thanhvien",
                    cong_ty:cong_ty,
                    maso_thue:maso_thue,
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    email:email,
                    nhom:nhom,
                    password:password,
                    re_password:re_password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=add_cang]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        dia_chi = $('.box_pop_add input[name=dia_chi]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên cảng',0,2000);
        }else if(dia_chi.length<3){
            $('.box_pop_add input[name=dia_chi]').focus();
            noti('Vui lòng nhập địa chỉ cảng',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_cang",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    dia_chi:dia_chi
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_cang]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        thu_tu = $('.box_pop_add input[name=thu_tu]').val();
        dia_chi = $('.box_pop_add input[name=dia_chi]').val();
        id = $('.box_pop_add input[name=id]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên cảng',0,2000);
        }else if(dia_chi.length<3){
            $('.box_pop_add input[name=dia_chi]').focus();
            noti('Vui lòng nhập địa chỉ cảng',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_cang",
                    tieu_de:tieu_de,
                    thu_tu:thu_tu,
                    dia_chi:dia_chi,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=add_hangtau]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        viet_tat = $('.box_pop_add input[name=viet_tat]').val();
        link = $('.box_pop_add input[name=link]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên hãng tàu',0,2000);
        }else if(viet_tat.length<1){
            $('.box_pop_add input[name=viet_tat]').focus();
            noti('Vui lòng nhập tên viết tắt',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_hangtau');
            form_data.append('tieu_de', tieu_de);
            form_data.append('viet_tat', viet_tat);
            form_data.append('link', link);
            form_data.append('file', file_data);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_hangtau]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        viet_tat = $('.box_pop_add input[name=viet_tat]').val();
        link = $('.box_pop_add input[name=link]').val();
        id = $('.box_pop_add input[name=id]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên hãng tàu',0,2000);
        }else if(viet_tat.length<1){
            $('.box_pop_add input[name=viet_tat]').focus();
            noti('Vui lòng nhập tên viết tắt',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_hangtau');
            form_data.append('tieu_de', tieu_de);
            form_data.append('viet_tat', viet_tat);
            form_data.append('link', link);
            form_data.append('file', file_data);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
        /////////////////////////////
    $('body').on('click','button[name=add_container]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên loại container',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_container",
                    tieu_de:tieu_de
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_container]', function() {
        tieu_de = $('.box_pop_add input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        if(tieu_de.length<2){
            $('.box_pop_add input[name=tieu_de]').focus();
            noti('Vui lòng nhập tên loại container',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_container",
                    tieu_de:tieu_de,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $('.table_hang').html(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
        /////////////////////////////
    $('body').on('click','button[name=add_phi_kethop]', function() {
        hang_tau = $('.box_pop_add select[name=hangtau]').val();
        phi = $('.box_pop_add input[name=phi]').val();
        if(phi.length<2){
            $('.box_pop_add input[name=phi]').focus();
            noti('Vui lòng nhập phí kết hợp',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "add_phi_kethop",
                    hang_tau:hang_tau,
                    phi:phi
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click','button[name=edit_phi_kethop]', function() {
        hang_tau = $('.box_pop_add select[name=hangtau]').val();
        phi = $('.box_pop_add input[name=phi]').val();
        id = $('input[name=id]').val();
        if(phi.length<2){
            $('.box_pop_add input[name=phi]').focus();
            noti('Vui lòng nhập phí kết hợp',0,2000);
        }else{
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "edit_phi_kethop",
                    hang_tau:hang_tau,
                    phi:phi,
                    id:id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            $(".table_hang tr:not(:first)").remove();
                            $(".table_hang tr:first").after(info.list);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_slide]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_slide');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('target', target);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_slide]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        id = $('input[name=id]').val();
        target = $('select[name=target]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_slide');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('target', target);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admincp/list-slide';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_banner]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        bg_banner = $('input[name=bg_banner]').val();
        target = $('select[name=target]').val();
        vi_tri = $('select[name=vi_tri]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_banner');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('bg_banner', bg_banner);
            form_data.append('target', target);
            form_data.append('vi_tri', vi_tri);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_banner]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        link = $('input[name=link]').val();
        thu_tu = $('input[name=thu_tu]').val();
        bg_banner = $('input[name=bg_banner]').val();
        id = $('input[name=id]').val();
        target = $('select[name=target]').val();
        vi_tri = $('select[name=vi_tri]').val();
        if (tieu_de.length < 2) {
            $('input[name=tieu_de]').focus();
        } else if (thu_tu == '') {
            $('input[name=thu_tu]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_banner');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link', link);
            form_data.append('thu_tu', thu_tu);
            form_data.append('bg_banner', bg_banner);
            form_data.append('target', target);
            form_data.append('vi_tri', vi_tri);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/admincp/list-banner';
                        } else {

                        }
                    }, 3000);
                }

            });
        }
    });
    ///////////////////////////////
    $('button[name=edit_setting_img]').on('click', function() {
        name = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_setting_img');
        form_data.append('file', file_data);
        form_data.append('name', name);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admincp/list-setting';
                    } else {

                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////////
    $('button[name=edit_setting_html]').on('click', function() {
        name = $('input[name=id]').val();
        value = tinyMCE.activeEditor.getContent();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                value: value
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admincp/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    ///////////////////////////////
    $('button[name=edit_setting]').on('click', function() {
        name = $('input[name=id]').val();
        value = $('textarea[name=value]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: "edit_setting",
                name: name,
                value: value
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.href = '/admincp/list-setting';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_thanhvien]').on('click', function() {
        name = $('input[name=name]').val();
        dien_thoai = $('input[name=dien_thoai]').val();
        active = $('select[name=active]').val();
        id = $('input[name=id]').val();
        var file_data = $('#minh_hoa').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_thanhvien');
        form_data.append('file', file_data);
        form_data.append('name', name);
        form_data.append('dien_thoai', dien_thoai);
        form_data.append('active', active);
        form_data.append('id', id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        window.location.reload();
                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function() {
        name = $('.box_form input[name=name]').val();
        mobile = $('.box_form input[name=mobile]').val();
        email = $('.box_form input[name=email]').val();
        if (name.length < 2) {
            $('.box_form input[name=name]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        }else if (mobile.length < 2) {
            $('.box_form input[name=mobile]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        }else if (email.length < 2) {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        }else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_profile');
            form_data.append('file', file_data);
            form_data.append('name', name);
            form_data.append('mobile', mobile);
            form_data.append('email', email);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('.button_change_avatar').click(function() {
        $('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function() {
        $('#file_cover').click();
    });
    /////////////////////////////
    // add phòng ban
    $('button[name=add_phongban]').on('click', function() {
        phan_cap = $('select[name=phan_cap]').val();
        cap_nhan_su = $('input[name=cap_nhan_su]').val();
    
        if(cap_nhan_su.length < 3) {
            $('input[name=cap_nhan_su]').focus();
            noti('Vui lòng nhập cấp nhân sự',0,2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
    
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                data: {
                    action: 'add_phongban',
                    phan_cap: phan_cap,
                    cap_nhan_su: cap_nhan_su
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
    
                    setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
    
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    // show box pop edit phòng ban
    $('body').on('click','.edit-title-icon', function() {
        id = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_edit_phongban',
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    noti(info.thongbao,0,2000);
                }
            }
        });
    });
    /////////////////////////////
    // edit phòng ban
    $('body').on('click', 'button[name=edit_phongban]', function() {
        id = $(this).data('id');
        phan_cap = $('select[name=phan_cap_edit]').val();
        cap_nhan_su = $('input[name=tieu_de]').val();
        
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'edit_phongban',
                id: id,
                phan_cap: phan_cap,
                cap_nhan_su: cap_nhan_su
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                    setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);

                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                    }, 3000);
                } else {
                    noti(info.thongbao,0,2000);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                    }, 3000);
                }
            }
        });
    });
    /////////////////////////////
    // box pop delete phòng ban
    $('body').on('click', 'button[name=box_pop_delete_phongban]', function() {
        id = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_delete_phongban',
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////
    // close box pop delete phòng ban
    $('body').on('click', '.box_pop_delete_phongban_close , button[name=close_box_pop_delete_phongban]', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////
    // delete phòng ban
    $('body').on('click', 'button[name=delete_phongban]', function() {
        id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'delete_phongban',
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                    
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                    }, 3000);
                }
            }
        });
    });
    
    /////////////////////////////
    // box pop nhân sự
    $('body').on('click', 'button[name=box_pop_add_user]', function() {
        id_phongban = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_add_user',
                id_phongban: id_phongban
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////////
    //close box pop add nhân sự
    $('body').on('click', '.box_pop_add_user_close', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////////
    //save add nhân sự 
    $('body').on('click', 'button[name=add_nhansu]', function() {
        id_phongban = $(this).data('id_phongban');
        username = $("input[name=username]").val();
        password =  $("input[name=password]").val();
        name_nhanvien = $("input[name=name]").val();
        email = $("input[name=email]").val();
        mobile = $("input[name=mobile]").val();
        address = $("input[name=address]").val();
        var so_hopdong = $('#input_so_hopdong').prop('files')[0];
        time_hopdong = $("input[name=time_hopdong]").val();
        so_cccd = $("input[name=so_cccd]").val();
        ngay_cap_cccd = $("input[name=ngay_cap_cccd]").val();
        loai_hopdong = $("input[name=loai_hopdong]:checked").val();
        var file_data = $('#input_avatar').prop('files')[0];

        var form_data = new FormData();

        form_data.append('action', 'add_nhansu');
        form_data.append('id_phongban', id_phongban);
        form_data.append('username', username);
        form_data.append('password', password);
        form_data.append('name_nhanvien', name_nhanvien);
        form_data.append('email', email);
        form_data.append('mobile', mobile);
        form_data.append('address', address);
        form_data.append('so_hopdong', so_hopdong);
        form_data.append('time_hopdong', time_hopdong);
        form_data.append('so_cccd', so_cccd);
        form_data.append('ngay_cap_cccd', ngay_cap_cccd);
        form_data.append('avatar', file_data);
        form_data.append('loai_hopdong', loai_hopdong);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('.box_pop_add').hide();

                    }
                }, 3000);
            }
        });
    });

    /////////////////////////////
    // box pop list user
    $('body').on('click', 'button[name=box_pop_list_user]', function() {
        id_phongban = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_list_user',
                id_phongban: id_phongban
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////////
    // close box pop list user
    $('body').on('click', '.box_pop_list_user_close', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////////
    // close box pop view user
    $('body').on('click', '.box_pop_view_user_close', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////////
    // view user detail
    $('body').on('click', 'button[name=view_user]', function() {
        id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_user',
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    }); 
    /////////////////////////////////
    // box pop edit user
    $('body').on('click', 'button[name=edit_user]', function() {
            id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_edit_user',
                id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////////
    // close box pop edit user
    $('body').on('click', '.box_pop_edit_user_close', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////////
    // save edit user
    $('body').on('click', 'button[name=save_edit_user]', function() {
        user_id = $(this).data('user_id');
        username = $("input[name=username]").val();
        password = $("input[name=password]").val();
        name = $("input[name=name]").val();
        email = $("input[name=email]").val();
        mobile = $("input[name=mobile]").val();
        address = $("input[name=address]").val();
        var so_hopdong = $('#input_so_hopdong').prop('files')[0];
        time_hopdong = $("input[name=time_hopdong]").val();
        so_cccd = $("input[name=so_cccd]").val();
        ngay_cap_cccd = $("input[name=ngay_cap_cccd]").val();
        loai_hopdong = $("input[name=loai_hopdong]:checked").val();
        var file_data = $('#input_avatar').prop('files')[0];
        var form_data = new FormData();
        form_data.append('action', 'edit_nhansu');
        form_data.append('user_id', user_id);
        form_data.append('username', username);
        form_data.append('password', password);
        form_data.append('name', name);
        form_data.append('email', email);
        form_data.append('mobile', mobile);
        form_data.append('address', address);
        form_data.append('so_hopdong', so_hopdong);
        form_data.append('time_hopdong', time_hopdong);
        form_data.append('so_cccd', so_cccd);
        form_data.append('ngay_cap_cccd', ngay_cap_cccd);
        form_data.append('avatar', file_data);
        form_data.append('loai_hopdong', loai_hopdong);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                }
            }
        });
    });
    /////////////////////////////
    // box pop chuyển phòng ban
    $('body').on('click', 'button[name=move_user]', function() {
        id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_chuyen_user',
                user_id: id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////////
    // close box pop chuyển phòng ban
    $('body').on('click', '.box_pop_chuyen_user_close', function() {
        $('.box_pop_add').hide();
    });
    /////////////////////////////////
    // save chuyển phòng ban
    $('body').on('click', 'button[name=chuyen_user]', function() {
        user_id = $(this).data('user_id');
        phong_ban_moi = $("select[name=phong_ban_moi]").val();

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'chuyen_user',
                user_id: user_id,
                phong_ban_moi: phong_ban_moi
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                setTimeout(function() {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function() {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('.box_pop_add').hide();
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////////
    //box_pop_delete_user
    $('body').on('click', 'button[name=delete_user]', function() {
        user_id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_delete_user',
                user_id: user_id
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                $('.box_pop_delete').html(info.html);
                $('.box_pop_delete').show();
            }
        });
    });
    /////////////////////////////////
    // close box pop delete user
    $('body').on('click', '.box_pop_delete_user_close', function() {
        $('.box_pop_delete').hide();
    });
    /////////////////////////////////
    // delete user
        $('body').on('click', 'button[name=dung_hoat_dong_user]', function() {
            user_id = $(this).data('user_id');
            console.log(user_id);
            
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                data: {
                    action: 'dung_hoat_dong_user',
                    user_id: user_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $du_lieu = {
                                'hd': 'hoatdong_user',
                                'phongban': info.phongban
                            }
                            var info_chat = JSON.stringify($du_lieu);
                            socket.emit('user_send_hoatdong', info_chat);
                        }
                    }, 3000);
                }
            });
        });
        $('body').on('click', 'button[name=kich_hoat_user]', function() {
            user_id = $(this).data('user_id');
            console.log(user_id);
            
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                data: {
                    action: 'kich_hoat_user',
                    user_id: user_id
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $du_lieu = {
                                'hd': 'hoatdong_user',
                                'phongban': info.phongban
                            }
                            var info_chat = JSON.stringify($du_lieu);
                            socket.emit('user_send_hoatdong', info_chat);
                        }
                    }, 3000);
                }
            });
        });
    ////////////////////////////////
    $('button[name=add_video]').on('click', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        link_video = $('.box_form input[name=link_video]').val();
        if (tieu_de.length < 3) {
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tiêu đề video',0,2000);
        } else if (link_video.length < 3) {
            $('.box_form input[name=link_video]').focus();
            noti('Vui lòng nhập link video',0,2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_video');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link_video', link_video);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_video]').on('click', function() {
        tieu_de = $('.box_form input[name=tieu_de]').val();
        link_video = $('.box_form input[name=link_video]').val();
        id = $('.box_form input[name=id]').val();
        if (tieu_de.length < 3) {
            $('.box_form input[name=tieu_de]').focus();
            noti('Vui lòng nhập tiêu đề video',0,2000);
        } else if (link_video.length < 3) {
            $('.box_form input[name=link_video]').focus();
            noti('Vui lòng nhập link video',0,2000);
        }else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_video');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('link_video', link_video);
            form_data.append('id', id);
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href='/admincp/list-video';
                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=add_baiviet]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        danhmuc=$('.box_form select[name=danhmuc]').val();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function() {});
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_baiviet');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('danhmuc', danhmuc);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_baiviet]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        danhmuc=$('.box_form select[name=danhmuc]').val();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_baiviet');
            form_data.append('file', file_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('noidung', noidung);
            form_data.append('danhmuc', danhmuc);            
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }
            });
        }
    });
    /////////////////////////////
    $('button[name=add_thongbao]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_noidang = [];
        $('.li_input input[name^=noi_dang]:checked').each(function() {
            list_noidang.push($(this).val());
        });
        list_noidang = list_noidang.toString();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (document.getElementById("minh_hoa").files.length == 0) {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            setTimeout(function() {
                $('.load_note').html('Vui lòng chọn hình minh họa');
            }, 500);
            setTimeout(function() {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                var top_minhhoa = $('#preview-minhhoa').offset().top;
                $('html,body').stop().animate({ scrollTop: top_minhhoa - 150 }, 500, 'swing', function() {});
            }, 2000);
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var pop_data = $('#popup').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_thongbao');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('pop', pop);
            form_data.append('noi_dang', list_noidang);
            form_data.append('noidung', noidung);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_thongbao]').on('click', function() {
        tieu_de = $('input[name=tieu_de]').val();
        id = $('input[name=id]').val();
        pop = $('input[name=pop]:checked').val();
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_noidang = [];
        $('.li_input input[name^=noi_dang]:checked').each(function() {
            list_noidang.push($(this).val());
        });
        list_noidang = list_noidang.toString();
        if (tieu_de.length < 3) {
            $('input[name=tieu_de]').focus();
        } else if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var file_data = $('#minh_hoa').prop('files')[0];
            var pop_data = $('#popup').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_thongbao');
            form_data.append('file', file_data);
            form_data.append('file_popup', pop_data);
            form_data.append('tieu_de', tieu_de);
            form_data.append('pop', pop);
            form_data.append('noi_dang', list_noidang);
            form_data.append('noidung', noidung);
            form_data.append('id', id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.reload();
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=button_password]').on('click', function() {
        old_pass = $('input[name=password_old]').val();
        new_pass = $('input[name=password]').val();
        confirm = $('input[name=confirm]').val();
        if (old_pass.length < 6) {
            $('input[name=password_old]').focus();
        } else if (new_pass.length < 6) {
            $('input[name=password]').focus();
        } else if (new_pass != confirm) {
            $('input[name=confirm]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('input[name=password_old]').val('');
                            $('input[name=password]').val('');
                            $('input[name=confirm]').val('');
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('button[name=add_quantri').on('click', function() {
        username = $('.box_form input[name=username]').val();
        password = $('.box_form input[name=password]').val();
        re_password = $('.box_form input[name=re_password]').val();
        ho_ten = $('.box_form input[name=ho_ten]').val();
        dien_thoai = $('.box_form input[name=dien_thoai]').val();
        email = $('.box_form input[name=email]').val();
        var list_group = [];
        $('.list_checkbox input:checked').each(function() {
            list_group.push($(this).val());
        });
        list_group = list_group.toString();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
            noti('Vui lòng nhập tài khoản đăng nhập',0,2000);
        } else if (password.length < 6) {
            $('.box_form input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu đăng nhập',0,2000);
        } else if (password!=re_password) {
            $('.box_form input[name=re_password]').focus();
            noti('Xác nhận mật khẩu không khớp',0,2000);
        } else if (ho_ten=='') {
            $('.box_form input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        } else if (dien_thoai=='') {
            $('.box_form input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        } else if (email=='') {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_quantri');
            form_data.append('username', username);
            form_data.append('password', password);
            form_data.append('re_password', re_password);
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('email', email);
            form_data.append('group', list_group);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_quantri').on('click', function() {
        username = $('.box_form input[name=username]').val();
        password = $('.box_form input[name=password]').val();
        re_password = $('.box_form input[name=re_password]').val();
        ho_ten = $('.box_form input[name=ho_ten]').val();
        dien_thoai = $('.box_form input[name=dien_thoai]').val();
        email = $('.box_form input[name=email]').val();
        id = $('.box_form input[name=id]').val();
        var list_group = [];
        $('.list_checkbox input:checked').each(function() {
            list_group.push($(this).val());
        });
        list_group = list_group.toString();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
            noti('Vui lòng nhập tài khoản đăng nhập',0,2000);
        } else if (password.length < 6 && password!='') {
            $('.box_form input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu đăng nhập',0,2000);
        } else if (password!=re_password && password!='') {
            $('.box_form input[name=re_password]').focus();
            noti('Xác nhận mật khẩu không khớp',0,2000);
        } else if (ho_ten=='') {
            $('.box_form input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        } else if (dien_thoai=='') {
            $('.box_form input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        } else if (email=='') {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_quantri');
            form_data.append('username', username);
            form_data.append('password', password);
            form_data.append('re_password', re_password);
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('email', email);
            form_data.append('group', list_group);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=add_cskh').on('click', function() {
        username = $('.box_form input[name=username]').val();
        password = $('.box_form input[name=password]').val();
        re_password = $('.box_form input[name=re_password]').val();
        ho_ten = $('.box_form input[name=ho_ten]').val();
        dien_thoai = $('.box_form input[name=dien_thoai]').val();
        email = $('.box_form input[name=email]').val();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
            noti('Vui lòng nhập tài khoản đăng nhập',0,2000);
        } else if (password.length < 6) {
            $('.box_form input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu đăng nhập',0,2000);
        } else if (password!=re_password) {
            $('.box_form input[name=re_password]').focus();
            noti('Xác nhận mật khẩu không khớp',0,2000);
        } else if (ho_ten=='') {
            $('.box_form input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        } else if (dien_thoai=='') {
            $('.box_form input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        } else if (email=='') {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_cskh');
            form_data.append('username', username);
            form_data.append('password', password);
            form_data.append('re_password', re_password);
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('email', email);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('button[name=edit_cskh').on('click', function() {
        username = $('.box_form input[name=username]').val();
        password = $('.box_form input[name=password]').val();
        re_password = $('.box_form input[name=re_password]').val();
        ho_ten = $('.box_form input[name=ho_ten]').val();
        dien_thoai = $('.box_form input[name=dien_thoai]').val();
        email = $('.box_form input[name=email]').val();
        id = $('.box_form input[name=id]').val();
        if (username.length < 4) {
            $('.box_form input[name=username]').focus();
            noti('Vui lòng nhập tài khoản đăng nhập',0,2000);
        } else if (password.length < 6 && password!='') {
            $('.box_form input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu đăng nhập',0,2000);
        } else if (password!=re_password && password!='') {
            $('.box_form input[name=re_password]').focus();
            noti('Xác nhận mật khẩu không khớp',0,2000);
        } else if (ho_ten=='') {
            $('.box_form input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        } else if (dien_thoai=='') {
            $('.box_form input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        } else if (email=='') {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        } else {
            var form_data = new FormData();
            form_data.append('action', 'edit_cskh');
            form_data.append('username', username);
            form_data.append('password', password);
            form_data.append('re_password', re_password);
            form_data.append('ho_ten', ho_ten);
            form_data.append('dien_thoai', dien_thoai);
            form_data.append('email', email);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/admincp/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    }, 3000);
                }

            });
        }
    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup', function() {
        tieu_de = $(this).val();
        cat = $('select[name=category]').val();
        if (tieu_de.length < 2) {} else {
            $.ajax({
                url: "/admincp/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat: cat,
                    tieu_de: tieu_de
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    $('.khung_goi_y ul').html(info.list);
                    if (info.list.length > 10) {
                        $('.khung_goi_y').show();
                    } else {
                        $('.khung_goi_y').hide();

                    }
                }

            });

        }
        e.stopPropagation();
    });
    /////////////////////////////
    $('.khung_sanpham').on('click', 'ul li i', function() {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click', 'ul li', function(e) {
        text = $(this).find('span').text();
        id = $(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="' + id + '"><i class="icon icofont-close-circled"></i><span>' + text + '</span></li>');
        e.stopPropagation();
    });
    /////////////////////////////
    $(document).click(function() {
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////
    $('body').on('click', 'button[name=view_giaoviec]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_giaoviec_tructiep',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_pop_view_giaoviec_close, button[name=close_box_pop_view_giaoviec_tructiep]', function (e) {
        $('.box_pop_add').hide();
    });
    ////////////////////////////
    $('body').on('click', '#box_pop_lichsu_baocao', function (e) {
        var id = $(this).data('id');
       
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_lichsu_baocao',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_nhanviec').html(info.html);
                $('.box_pop_nhanviec').show();
            }
        });
    });
    //////////////////////////
    $('body').on('click', '.box_pop_lichsu_baocao_close', function (e) {
        $('.box_pop_nhanviec').hide();
    });
    //////////////////////////
    $('body').on('click', '#box_pop_lichsu_giahan', function (e) {
        var id = $(this).data('id');
        
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_lichsu_giahan',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_nhanviec').html(info.html);
                $('.box_pop_nhanviec').show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '.box_pop_lichsu_giahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
    });
    //////////////////////////
    $('body').on('click', 'button[name=box_pop_view_baocao]', function (e) {
        var id = $(this).data('id');
        var action_baocao = $(this).data('action');
        let hien_thi = '';

        if (action_baocao === 'giaoviec_tructiep') {
            hien_thi = '.box_pop_nhanviec';
        } else if (action_baocao === 'giaoviec_du_an') {
            hien_thi = '.box_pop_lichsu';
        }
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_baocao',
                id: id,
                action_baocao: action_baocao
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html).show();
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=close_box_pop_view_baocao],.box_pop_view_baocao_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    /////////////////////////////
    $('body').on('click', 'button[name=view_lichsu_giahan]', function (e) {
        var id = $(this).data('id');
        var action_giahan = $(this).data('action');
        console.log(action_giahan);
        let hien_thi = '';
        if (action_giahan == 'giaoviec_tructiep') {
            hien_thi = '.box_pop_nhanviec';
        } else if (action_giahan == 'giaoviec_du_an') {
            hien_thi = '.box_pop_lichsu';
        }
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_giahan',
                id: id,
                action_giahan: action_giahan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html).show();

            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=close_box_pop_view_giahan],.box_pop_view_giahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    /////////////////////////////
    $('body').on('click', '#phantrang_thongke_congviec .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_thongke_congviec .li_phantrang').removeClass('active');
        $('#phantrang_thongke_congviec .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/admincp/process.php",
            type: "post",
            data: {
                action: 'load_list_thongke_congviec',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_thongke_congviec').html(info.list);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=box_pop_view_lichsu_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_lichsu_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_view_lichsu_du_an],.box_pop_view_lichsu_du_an_close', function (e) {
        $('.box_pop_add').hide();
    });
    ///////////////////////////
    $('body').on('click', '.box_lichsu_congviec_du_an', function (e) {
        // Chỉ trigger khi click vào node trong orgchart (có data-id và là node)
        var id = $(this).data('id');
        // Nếu không có data-id, không phải là node hợp lệ
        if (!id || id === 'root_0') {
            return;
        }
        e.stopPropagation();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_lichsu_congviec_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_view_lichsu_congviec_du_an').html(info.html);
                    $('.box_pop_view_lichsu_congviec_du_an').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    }); 
    ///////////////////////////
    $('body').on('click', '#btn_filter_du_an', function (e) {
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_filter_du_an'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '#btn_filter_giaoviec', function (e) {
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_filter_giaoviec'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    //////////////////////////
    $('body').on('click', '#submit_filter_giaoviec', function (e) {
        var $form = $('#form_filter');

        var search_keyword = $form.find('input[name=search_keyword]').val();
        var search_trang_thai = $form.find('select[name=trang_thai]').val();
        var search_ngay_tao_tu = $form.find('input[name=ngay_tao_tu]').val();
        var search_ngay_tao_den = $form.find('input[name=ngay_tao_den]').val();
        var search_ngay_hoanthanh_tu = $form.find('input[name=ngay_hoanthanh_tu]').val();
        var search_ngay_hoanthanh_den = $form.find('input[name=ngay_hoanthanh_den]').val();
        var search_nguoi_tao = $form.find('select[name=nguoi_tao]').val();
        var search_nguoi_nhan = $form.find('select[name=nguoi_nhan]').val();
        
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'load_list_giaoviec',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_tao_tu: search_ngay_tao_tu,
                search_ngay_tao_den: search_ngay_tao_den,
                search_ngay_hoanthanh_tu: search_ngay_hoanthanh_tu,
                search_ngay_hoanthanh_den: search_ngay_hoanthanh_den,
                search_nguoi_tao: search_nguoi_tao,
                search_nguoi_nhan: search_nguoi_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 1000);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                    $('#list_thongke_congviec').html(info.list);
                }
            }
        });
    });
    //////////////////////////
    $('body').on('click', '#submit_filter_du_an', function (e) {
        var $form = $('#form_filter');

        var search_keyword = $form.find('input[name=search_keyword]').val();
        var search_trang_thai = $form.find('select[name=trang_thai]').val();
        var search_ngay_tao_tu = $form.find('input[name=ngay_tao_tu]').val();
        var search_ngay_tao_den = $form.find('input[name=ngay_tao_den]').val();
        var search_ngay_hoanthanh_tu = $form.find('input[name=ngay_hoanthanh_tu]').val();
        var search_ngay_hoanthanh_den = $form.find('input[name=ngay_hoanthanh_den]').val();
        var search_nguoi_tao = $form.find('select[name=nguoi_tao]').val();
        var search_nguoi_nhan = $form.find('select[name=nguoi_nhan]').val();
        
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'load_list_du_an',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_tao_tu: search_ngay_tao_tu,
                search_ngay_tao_den: search_ngay_tao_den,
                search_ngay_hoanthanh_tu: search_ngay_hoanthanh_tu,
                search_ngay_hoanthanh_den: search_ngay_hoanthanh_den,
                search_nguoi_tao: search_nguoi_tao,
                search_nguoi_nhan: search_nguoi_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 1000);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                    $('#list_thongke_du_an').html(info.list);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '#box_pop_lichsu_baocao_congviec_du_an', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_lichsu_baocao_congviec_du_an',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_lichsu').html(info.html);
                $('.box_pop_lichsu').show();
            }
        });
    });
     //////////////////////////
     $('body').on('click', '.box_pop_lichsu_baocao_close', function (e) {
        $('.box_pop_lichsu').hide();
    });
    /////////////////////////
    $('body').on('click', '#box_pop_lichsu_giahan_congviec_du_an', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_lichsu_giahan_congviec_du_an',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_lichsu').html(info.html);
                $('.box_pop_lichsu').show();
            }
        });
    });
    //////////////////////////
    $('body').on('click', '.box_pop_lichsu_giahan_close', function (e) {
        $('.box_pop_lichsu').hide();
    });
    //////////////////////////
    $('body').on('click', '#btn_export_du_an', function (e) {
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_export_du_an'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '#btn_export_giaoviec', function (e) {
        $.ajax({
            url: '/admincp/process.php',
            type: 'post',
            data: {
                action: 'box_pop_export_giaoviec'
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    //////////////////////////////
    $('body').on('click', '.box_pop_export_close', function (e) {
        $('.box_pop_add').hide();
    });
    //////////////////////////////
    $('body').on('click', '#submit_export_giaoviec', function () {
        var $form = $('#form_export');
        var nguoi_dung = $form.find('select[name=nguoi_dung]').val();

        $.ajax({
            url: '/admincp/process.php',
            type: 'POST',
            data: {
                action: 'submit_export_giaoviec',
                nguoi_dung: nguoi_dung, 
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = response.filePath;
                } else {
                    alert(response.error || 'Có lỗi xảy ra khi xuất file!');
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", status, error);
                alert("Đã xảy ra lỗi khi yêu cầu xuất file!");
            }
        });
    });
    //////////////////////////////
    $('body').on('click', '#submit_export_du_an', function () {
        var $form = $('#form_export');
        var nguoi_dung = $form.find('select[name=nguoi_dung]').val();

        $.ajax({
            url: '/admincp/process.php',
            type: 'POST',
            data: {
                action: 'submit_export_du_an',
                nguoi_dung: nguoi_dung, 
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = response.filePath;
                } else {
                    alert(response.error || 'Có lỗi xảy ra khi xuất file!');
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi AJAX:", status, error);
                alert("Đã xảy ra lỗi khi yêu cầu xuất file!");
            }
        });
    });
});