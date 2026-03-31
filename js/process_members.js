//var nice = j("html").niceScroll();  // The document page (body)
//$(".list_cat_smile").niceScroll({ cursorborder: "", cursorcolor: "rgb(246, 119, 26)", boxzoom: false }); // First scrollable DIV
//$(".img_resize").niceScroll({ cursorborder: "", boxzoom: false }); // First scrollable DIV
//j('.list_top_mem').niceScroll({cursorborder:"",boxzoom:false}); // First scrollable DIV
//$(".box_menu_left").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$(".menu_top_left .drop_menu").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
//$("#content_detail").niceScroll({ cursorborder: "", cursorcolor: "rgb(0, 0, 0)",cursorwidth:"8px", boxzoom: false,iframeautoresize: true }); // First scrollable DIV
function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $('#' + id).animate({
        scrollTop: div.scrollHeight - div.clientHeight
    }, 200);
}
// var socket =io("http://localhost:3000");
// Tắt socket.io để tránh failed requests (521 errors) - có thể bật lại khi server hoạt động
// Tạo mock object để code không bị lỗi khi gọi socket.emit() hoặc socket.on()
// var socket = {
//     emit: function() { 
//         // console.log('socket.emit called but socket.io is disabled');
//         return false; 
//     },
//     on: function() { 
//         // console.log('socket.on called but socket.io is disabled');
//         return false; 
//     },
//     off: function() { 
//         return false; 
//     },
//     disconnect: function() {
//         return false;
//     }
// };
// Để bật lại socket.io, uncomment dòng dưới và comment phần mock object trên
// var socket = io("https://chat.kaizendms.com");
var socket = io("https://chat.socdo.vn");
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
        reader.onload = function (e) {
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
            url: "/members/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link,
                loai: loai
            },
            success: function (kq) {
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
            url: "/members/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link,
                loai: loai
            },
            success: function (kq) {
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
function close_chat(id) {
    $('#box_chat_' + id).remove();
}
//////////////////////////////
function active_chat(id) {
    $(".box_chat_top").removeClass("active");
    $('#box_chat_' + id).find(".box_chat_top").addClass("active");
    $('#box_chat_' + id).one("click", function () {
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'read_sms',
                id: id
            },
            success: function () {

            }
        });
    });
}
///////////////////
function send_chat(id) {
    $('#box_chat_' + id + ' input[type=text]').keypress(function (e) {
        text_send = $('input[name=text_send]').val();
        user_out = $('input[name=thanhvien_chat]').val();
        noi_dung = $('#box_chat_' + id + ' input[type=text]').val();
        user_in = $('#box_chat_' + id).attr('user_in');
        var dulieu = {
            "user_out": user_out,
            "user_in": user_in,
            "noi_dung": noi_dung
        }
        var info_chat = JSON.stringify(dulieu);
        last = $('#box_chat_' + id + ' .box_chat_midle .li_sms').last().attr("value");
        if (e.which == 13) {
            $('#box_chat_' + id + ' .chating').show();
            $('#box_chat_' + id + ' .chating').html(text_send);
            if (noi_dung != '') {
                $.get('/members/process.php?action=send_chat&user_in=' + user_in + '&user_out=' + user_out + '&last=' + last + '&noi_dung=' + noi_dung,
                    function (data) {
                        var info = JSON.parse(data);
                        if (info.ok == true) {
                            $('#box_chat_' + id + ' .box_chat_midle').append('<div class="li_sms_out li_sms" value="sms_out"><div class="li_sms_out_content">' + info.sms_in + '</div></div>');
                            scrollSmoothToBottom('box_chat_midle_' + id);
                            socket.emit('user_send_chat', data);
                            socket.emit('show_box_chat', data);
                        } else {
                            $('#box_chat_' + id + ' .chating').show();
                            $('#box_chat_' + id + ' .chating').html(info.note);

                        }
                    }
                );
                setTimeout(function () {
                    $('#box_chat_' + id + ' .chating').hide();
                    $('#box_chat_' + id + ' .chating').html('');
                }, 2000);
                $('#box_chat_' + id + ' input[type=text]').val('');
            } else {
                $('#box_chat_' + id + ' input[type=text]').focus();
            }
            socket.emit('user_stop_chat', info_chat);
        } else {
            socket.emit('user_chating', info_chat);
        }
    });
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
        url: "/members/process.php",
        type: "post",
        data: {
            action: "tuchoi",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
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
        url: "/members/process.php",
        type: "post",
        data: {
            action: "del",
            loai: loai,
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
                $('.load_process').hide();
                $('.load_note').html('Hệ thống đang xử lý');
                $('.load_overlay').hide();
                if (info.ok == 1) {
                    $('#tr_' + id).remove();
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
        url: "/members/process.php",
        type: "post",
        data: {
            action: "huy",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            setTimeout(function () {
                $('.load_note').html(info.thongbao);
            }, 1000);
            setTimeout(function () {
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
function show_goiy(id) {
    noti('Hệ thống đang xử lý', 500, 1500);
    $.ajax({
        url: "/members/process.php",
        type: "post",
        data: {
            action: "show_goiy",
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_gan').show();
                    $('.box_gan .table_hang').html(info.list_hang_goiy);
                }, 1000);
            } else {
                noti(info.thongbao, 500, 1500);
            }
        }

    });
}
function show_edit(loai, id) {
    noti('Hệ thống đang xử lý', 500, 1500);
    $.ajax({
        url: "/members/process.php",
        type: "post",
        data: {
            action: "show_edit",
            loai: loai,
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                }, 1000);
            } else {
                noti(info.thongbao, 500, 1500);
            }
        }

    });
}
function show_add(loai, id) {
    noti('Hệ thống đang xử lý', 0, 1000);
    $.ajax({
        url: "/members/process.php",
        type: "post",
        data: {
            action: "show_add",
            loai: loai,
            id: id
        },
        success: function (kq) {
            var info = JSON.parse(kq);
            if (info.ok == 1) {
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                }, 1000);
            } else {
                noti(info.thongbao, 0, 1000);
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
        c.split(/[,;]/).map(function (cookie) {
            var parts = cookie.split(/=/, 2),
                name = decodeURIComponent(parts[0].trimLeft()),
                value = parts.length > 1 ? decodeURIComponent(parts[1].trimRight()) : null;
            cookies[name] = value;
        });
    } else {
        c.match(/(?:^|\s+)([!#$%&'*+\-.0-9A-Z^`a-z|~]+)=([!#$%&'*+\-.0-9A-Z^`a-z|~]*|"(?:[\x20-\x7E\x80\xFF]|\\[\x00-\x7F])*")(?=\s*[,;]|$)/g).map(function ($0, $1) {
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
function show_thongbao(text, loai) {
    if (loai == 'error') {
        $('.box_thongbao #text_note b').html(text);
        $('.box_thongbao #text_note b').removeClass('color_green');
        $('.box_thongbao #text_note b').addClass('color_red');
        $('.box_thongbao .icon_thongbao').html('<i class="fa fa-exclamation-triangle"></i>');
        $('.box_thongbao .icon_thongbao').removeClass('color_green');
        $('.box_thongbao .icon_thongbao').addClass('color_red');
    } else if (loai == 'success') {
        $('.box_thongbao #text_note b').html(text);
        $('.box_thongbao #text_note b').removeClass('color_red');
        $('.box_thongbao #text_note b').addClass('color_green');
        $('.box_thongbao .icon_thongbao').html('<i class="fa fa-check-circle"></i>');
        $('.box_thongbao .icon_thongbao').removeClass('color_red');
        $('.box_thongbao .icon_thongbao').addClass('color_green');
    }
    $('.box_thongbao').fadeIn();
}
function noti2(text, time_start, time_end) {
    $('.load_overlay').show();
    $('.load_process').fadeIn();
    setTimeout(function () {
        $('.load_process .load_note').html(text);
    }, time_start);
    setTimeout(function () {
        $('.load_process').hide();
        $('.load_process .load_note').html('Hệ thống đang xử lý');
        $('.load_overlay').hide();
    }, time_end);
}
function noti(text, time_start, time_end) {
    $('.load_overlay').show();
    $('.load_process_2').fadeIn();
    setTimeout(function () {
        $('.load_process_2 .load_note span').html(text);
    }, time_start);
    setTimeout(function () {
        $('.load_process_2').hide();
        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
        $('.load_overlay').hide();
    }, time_end);
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
$(document).ready(function () {
    setTimeout(function () {
        $('.loadpage').fadeOut();
        $('.page_body').fadeIn();
    }, 300);
    if ($('#chon_kho').length > 0) {
        if (get_cookie('admin_kho')) {
            $('#chon_kho').val(get_cookie('admin_kho'));
        } else {

        }
    }
    $('#chon_kho').on('change', function () {
        kho = $(this).val();
        create_cookie('admin_kho', kho, 365, '/');
        window.location.reload();
    });
    if ($(window).width() < 768) {
        $('[max-width]').each(function () {
            var maxWidthValue = $(this).attr('max-width');
            $(this).attr('style', 'width:' + maxWidthValue + 'px !important');
        });
        $('.b_mobile').each(function () {
            $(this).attr('style', 'width:100% !important');
        });
        $('[over]').each(function () {
            $(this).attr('style', 'overflow: auto;');
        });
    }
    ////////////////////////////
    $('body').on('click', '.chon_file', function () {
        $(this).parent().find('input[type=file]').click();
    });
    ////////////////////////////
    $('body').on('change', '.khung_file input[type=file]', function () {
        var fileName = $(this).val().split('\\').pop(); // Lấy tên tệp từ đường dẫn
        $(this).parent().find('.file_name').text(fileName); // Hiển thị tên tệp
    });
    ////////////////////////////
    $('body').on('click', '.list_checkbox input[name=mat_hang]', function () {
        mat_hang = $(this).val();
        if (mat_hang == 'khac') {
            $(this).parent().find('input[name=mat_hang_khac]').show();
        } else {
            $(this).parent().parent().find('input[name=mat_hang_khac]').hide();
        }

    });
    ////////////////////////////
    $('body').on('click', '.box_phanloai_kieu input[name=option]:checked', function () {
        $(this).parent().find('button').removeClass('active');
        $(this).addClass('active');
        phan_loai = $(this).attr('value');
        if (phan_loai == 'banvo_kethop') {
            $('#input_cuoc').hide();
        } else {
            $('#input_cuoc').show();
        }
    });
    $('body').on('focus', '.box_timkiem input[name=dia_diem]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    $('body').on('click', '.box_timkiem input[name=dia_diem]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup', '.box_timkiem input[name=dia_diem]', function () {
        text = $(this).val();
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        if (text.length >= 1) {
            $(this).parent().find('.list_goiy').show();
            $(this).parent().find('.list_goiy').scrollTop(0);
            $selectOptionsList.each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(text.toLowerCase())) {
                    //$(this).show();
                    $(this).prependTo($list_goiy);
                } else {
                    //$(this).hide();
                }
            });
        } else {
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click', '.box_timkiem .goiy_tinh', function () {
        ten_tinh = $(this).text();
        id_tinh = $(this).attr('value');
        $('.box_timkiem input[name=dia_diem]').val(ten_tinh);
        $('.box_timkiem input[name=dia_diem_id]').val(id_tinh);
        $('.box_timkiem .list_goiy_tinh').hide();
    });
    ////////////////////////////
    $('body').on('focus', '.box_timkiem input[name=hang_tau]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click', '.box_timkiem input[name=hang_tau]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup', '.box_timkiem input[name=hang_tau]', function () {
        text = $(this).val();
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        if (text.length >= 1) {
            $(this).parent().find('.list_goiy').show();
            $(this).parent().find('.list_goiy').scrollTop(0);
            $selectOptionsList.each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(text.toLowerCase())) {
                    //$(this).show();
                    $(this).prependTo($list_goiy);
                } else {
                    //$(this).hide();
                }
            });
        } else {
            $('.box_timkiem .list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click', '.box_timkiem .goiy_hangtau', function () {
        ten_hangtau = $(this).attr('viet_tat');
        id_hangtau = $(this).attr('value');
        $('.box_timkiem input[name=hang_tau]').val(ten_hangtau);
        $('.box_timkiem input[name=hang_tau_id]').val(id_hangtau);
        $('.box_timkiem .list_goiy_hangtau').hide();
    });
    ////////////////////////////
    $('body').on('focus', '.li_input input[name=tinh]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click', '.li_input input[name=tinh]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup', '.li_input input[name=tinh]', function () {
        text = $(this).val();
        ten = $(this).attr('ten');
        if (ten != text) {
            $(this).parent().parent().find('select[name=huyen]').html('<option value="">Chọn quận/huyện</option>');
            $(this).parent().parent().find('select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
        }
        var div = $(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if (text.length >= 1) {
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(text.toLowerCase())) {
                    //$(this).show();
                    $(this).prependTo($list_goiy);
                } else {
                    //$(this).hide();
                }
            });
        } else {
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('focus', '.li_input input[name=tinh_donghang]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click', '.li_input input[name=tinh_donghang]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup', '.li_input input[name=tinh_donghang]', function () {
        text = $(this).val();
        ten = $(this).attr('ten');
        if (ten != text) {
            $(this).parent().parent().find('select[name=huyen_donghang]').html('<option value="">Chọn quận/huyện</option>');
            $(this).parent().parent().find('select[name=xa_donghang]').html('<option value="">Chọn xã/thị trấn</option>');
        }
        var div = $(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if (text.length >= 1) {
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(text.toLowerCase())) {
                    //$(this).show();
                    $(this).prependTo($list_goiy);
                } else {
                    //$(this).hide();
                }
            });
        } else {
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click', '.li_input .goiy_tinh', function () {
        ten_tinh = $(this).text();
        id_tinh = $(this).attr('value');
        var div = $(this);
        div.parent().parent().find('input[name=tinh]').val(ten_tinh);
        div.parent().parent().find('input[name=tinh]').attr('ten', ten_tinh);
        div.parent().parent().find('input[name=tinh_id]').val(id_tinh);
        div.parent().parent().find('.list_goiy').hide();
    });
    ////////////////////////////
    $('body').on('click', '.list_goiy_tinh_donghang .goiy_tinh', function () {
        ten_tinh = $(this).text();
        id_tinh = $(this).attr('value');
        var div = $(this);
        div.parent().parent().find('input[name=tinh_donghang]').val(ten_tinh);
        div.parent().parent().find('input[name=tinh_donghang]').attr('ten', ten_tinh);
        div.parent().parent().find('input[name=tinh_donghang_id]').val(id_tinh);
        div.parent().parent().find('.list_goiy').hide();
    });
    ////////////////////////////
    $('body').on('focus', '.li_input input[name=hang_tau]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('click', '.li_input input[name=hang_tau]', function () {
        $(this).parent().find('.list_goiy').show();
        $(this).parent().find('.list_goiy').scrollTop(0);
    });
    ////////////////////////////
    $('body').on('keyup', '.li_input input[name=hang_tau]', function () {
        text = $(this).val();
        var div = $(this);
        var $list_goiy = $(this).parent().find(".list_goiy");
        var $selectOptionsList = $(this).parent().find(".list_goiy .li_goiy");
        $(this).parent().find('.list_goiy').scrollTop(0);
        if (text.length >= 1) {
            $(this).parent().find('.list_goiy').show();
            $selectOptionsList.each(function () {
                var optionText = $(this).text().toLowerCase();
                if (optionText.includes(text.toLowerCase())) {
                    //$(this).show();
                    $(this).prependTo($list_goiy);
                } else {
                    //$(this).hide();
                }
            });
        } else {
            $(this).parent().find('.list_goiy').hide();
        }
    });
    ////////////////////////////
    $('body').on('click', '.li_input .goiy_hangtau', function () {
        ten_hangtau = $(this).attr('viet_tat');
        id_hangtau = $(this).attr('value');
        var div = $(this);
        div.parent().parent().find('input[name=hang_tau]').val(ten_hangtau);
        div.parent().parent().find('input[name=hang_tau_id]').val(id_hangtau);
        div.parent().parent().find('.list_goiy').hide();
    });
    ////////////////////////////
    $('body').on('click', '#tab_hangxuat_content .goiy_hangtau', function () {
        phi = $(this).attr('phi');
        $('#tab_hangxuat_content .phi_kethop').html(format_number(phi) + ' đ');
    });
    /////////////////////////////
    $('body').on('click', '#tab_hangnhap_content .goiy_tinh', function () {
        tinh = $(this).attr('value');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangnhap_content select[name=huyen]').html(info.list);
                $('#tab_hangnhap_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '#tab_hangxuat_content .goiy_tinh', function () {
        tinh = $(this).attr('value');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangxuat_content select[name=huyen]').html(info.list);
                $('#tab_hangxuat_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '#tab_noidia_content .list_goiy_tinh .goiy_tinh', function () {
        tinh = $(this).attr('value');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_noidia_content select[name=huyen]').html(info.list);
                $('#tab_noidia_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '#tab_noidia_content .list_goiy_tinh_donghang .goiy_tinh', function () {
        tinh = $(this).attr('value');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_noidia_content select[name=huyen_donghang]').html(info.list);
                $('#tab_noidia_content select[name=xa_donghang]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    if ($('#list_chat').length > 0) {
        setTimeout(function () {
            scrollSmoothToBottom('list_chat');
        }, 500);
    }
    /////////////////////////////
    // Khởi tạo: đóng tất cả menu mặc định khi tải trang
    var currentUrl = window.location.pathname;

    // 1. Đóng tất cả menu trước
    $('.menu_header').each(function () {
        var menuId = $(this).attr('id');
        $('.menu_li.' + menuId.replace('menu_', 'menu_')).hide();

        $(this).find('span i')
            .removeClass('fa-minus-circle')
            .addClass('fa-plus-circle');
    });

    // 2. Tìm menu_li có link trùng URL hiện tại
    $('.menu_li a').each(function () {
        var href = $(this).attr('href');

        if (href === currentUrl) {
            // Đánh dấu active menu con
            $(this).addClass('active');

            // Lấy class menu cha (vd: menu_congviec)
            var parentMenuClass = $(this).parent().attr('class').split(' ')[1];

            // 3. Mở menu cha
            $('.menu_li.' + parentMenuClass).show();

            // Đổi icon menu_header sang mở
            $('#'+ parentMenuClass.replace('menu_', 'menu_'))
                .find('span i')
                .removeClass('fa-plus-circle')
                .addClass('fa-minus-circle');
        }
    });
    /////////////////////////////
    $('body').on('click', '.menu_header', function () {
        if ($(this).find('span i').length > 0) {
            id = $(this).attr('id');
            $('.' + id).toggle();
            if ($(this).find('span i').hasClass('fa-plus-circle')) {
                $(this).find('span i').removeClass('fa-plus-circle');
                $(this).find('span i').addClass('fa-minus-circle');
            } else {
                $(this).find('span i').removeClass('fa-minus-circle');
                $(this).find('span i').addClass('fa-plus-circle');
            }
        }

    });
    /////////////////////////////
    $('button[name=button_doanhso_naptien]').on('click', function () {
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
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=button_doanhso_chitieu]').on('click', function () {
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
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=button_doanhso_booking]').on('click', function () {
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
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('button[name=button_doanhso_dat_booking]').on('click', function () {
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
            form_data.append('action', 'load_doanhso_dat_booking');
            form_data.append('time_begin', time_begin);
            form_data.append('time_end', time_end);
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#doanhso_hoanthanh').html(info.doanhso_hoanthanh);
                            $('#doanhso_cho_xacnhan').html(info.doanhso_cho_xacnhan);
                            $('#doanhso_xacnhan').html(info.doanhso_xacnhan);
                            $('#doanhso_tuchoi').html(info.doanhso_tuchoi);
                            $('#booking_hoanthanh').html(info.booking_hoanthanh);
                            $('#booking_cho_xacnhan').html(info.booking_cho_xacnhan);
                            $('#booking_xacnhan').html(info.booking_xacnhan);
                            $('#booking_tuchoi').html(info.booking_tuchoi);
                        } else {

                        }
                    }, 2000);
                }

            });
        }
    });
    ///////////////////////////
    $('body').on('click', '.box_container_left .title .cancel', function () {
        $(this).parent().parent().hide();
    });
    ///////////////////////////
    $('body').on('click', '.box_container_left .title button[name=loc]', function () {
        $('.box_loc').toggle();
        $('.box_xuat').toggle();
    });
    ///////////////////////////
    $('body').on('click', '.box_container_left .title button[name=export_naptien]', function () {
        $('.box_xuat').toggle();
        $('.box_loc').toggle();
    });
    $(document).click(function (e) {
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
    });
    /////////////////////////////
    $('body').on('click', '.box_xuat button[name=export_naptien_process]', function () {
        from = $('.box_xuat input[name=from]').val();
        to = $('.box_xuat input[name=to]').val();
        status = $('.box_xuat select[name=status]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "export_naptien",
                from: from,
                to: to,
                status: status
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('.box_xuat').hide();
                        window.open(info.link, '_blank');
                    } else {
                    }
                }, 2000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.box_xuat button[name=export_booking_process]', function () {
        from = $('.box_xuat input[name=from]').val();
        to = $('.box_xuat input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "export_booking",
                from: from,
                to: to
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('.box_xuat').hide();
                        window.open(info.link, '_blank');
                    } else {
                    }
                }, 2000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.box_xuat button[name=export_dat_booking_process]', function () {
        from = $('.box_xuat input[name=from]').val();
        to = $('.box_xuat input[name=to]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "export_dat_booking",
                from: from,
                to: to
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('.box_xuat').hide();
                        window.open(info.link, '_blank');
                    } else {
                    }
                }, 2000);
            }

        });
    });
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_right .notification .tab_notification .li_tab', function () {
        $('.tab_notification .li_tab').removeClass('active');
        $(this).addClass('active');
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_notification',
                loai: loai,
                page: 1
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.list_notification .list_noti .loading_notification').remove();
                    $('.list_notification .list_noti').append(info.list);
                    $('.list_notification .list_noti').attr('page', info.page);
                    $('.list_notification .list_noti').attr('tiep', info.tiep);
                    $('.list_notification .list_noti').attr('loaded', 1);

                }, 1000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '.menu_top .menu_top_right .notification .icon_notification', function () {
        $('.list_notification').toggleClass('active');
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        if ($('.list_notification').hasClass('active')) {
            $('.list_notification .list_noti').html('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: 'load_notification',
                    loai: loai,
                    page: 1
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.list_notification .list_noti .loading_notification').remove();
                        $('.list_notification .list_noti').append(info.list);
                        $('.list_notification .list_noti').attr('page', info.page);
                        $('.list_notification .list_noti').attr('tiep', info.tiep);
                        $('.list_notification .list_noti').attr('loaded', 1);
                        var dulieu = {
                            hd: 'load_thongbao',
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    }, 1000);
                }
            });
        } else {
        }
    });
    ////////////////////////
    $('.list_notification .list_noti').on('scroll', function () {
        tab = $('.tab_notification .li_tab.active').attr('id');
        if (tab == 'tab_all') {
            loai = 'all';
        } else {
            loai = 'chuadoc';
        }
        div_notification = $('.list_notification .list_noti');
        if (div_notification.scrollTop() + div_notification.innerHeight() >= div_notification[0].scrollHeight - 10) {
            tiep = $('.list_notification .list_noti').attr('tiep');
            page = $('.list_notification .list_noti').attr('page');
            loaded = $('.list_notification .list_noti').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('.list_notification .list_noti').prepend('<div class="loading_notification"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('.list_notification .list_noti').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: 'load_notification',
                            loai: 'all',
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.list_notification .list_noti .loading_notification').remove();
                            $('.list_notification .list_noti').append(info.list);
                            $('.list_notification .list_noti').attr('page', info.page);
                            $('.list_notification .list_noti').attr('tiep', info.tiep);
                            $('.list_notification .list_noti').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
    })
    //////////////////
    socket.on("get_box_chat", function (data) {
        user_out = $('input[name=thanhvien_chat]').val();
        var info = JSON.parse(data);
        length_box = $('#box_chat_' + info.user_out + ':visible').length;
        num_box = $('.box_chat:visible').length;
        if (user_out == info.user_in) {
            if (length_box > 0) {
                $('#box_chat_' + info.user_out + ' .box_chat_top_online').removeClass('offline');
                $('#box_chat_' + info.user_out + ' .box_chat_top_online').addClass('online');
            } else {
                if (num_box < 4) {
                    if (length_box > 0) {
                        $('#box_chat_' + info.user_out + ' .box_chat_top_online').removeClass('offline');
                        $('#box_chat_' + info.user_out + ' .box_chat_top_online').addClass('online');
                    } else {
                        if ($('#box_chat_' + info.user_out).length > 0) {
                            $('#box_chat_' + info.user_out).show();
                            $('#box_chat_' + info.user_out + ' .box_chat_top_online').removeClass('offline');
                            $('#box_chat_' + info.user_out + ' .box_chat_top_online').addClass('online');
                        } else {
                            $.get('/members/process.php?action=show_box_chat&id=' + info.user_out + '&user_out=' + user_out,
                                function (kq) {
                                    var info_kq = JSON.parse(kq);
                                    if (info_kq.ok == 1) {
                                        $('.main_box_chat').append(info_kq.html);
                                        scrollSmoothToBottom('box_chat_midle_' + info_kq.user_out);
                                        setTimeout(function () {
                                            $('#box_chat_midle_' + info_kq.user_out).attr('loaded', '1');
                                        }, 1000);
                                    } else {

                                    }
                                });
                        }
                    }
                } else {
                    if (length_box > 0) {
                    } else {
                        first_box = $('.box_chat:visible').first();
                        if (first_box.hasClass('active') == true) {
                            first_box.next('.box_chat:visible').hide();
                        } else {
                            first_box.hide();
                        }
                        if ($('#box_chat_' + info.booking).length > 0) {
                            $('#box_chat_' + info.booking).show();
                        } else {
                            $.get('/members/process.php?action=show_box_chat&id=' + info.booking + '&user_out=' + user_out,
                                function (kq) {
                                    var info_kq = JSON.parse(kq);
                                    if (info_kq.ok == 1) {
                                        $('.main_box_chat').append(info_kq.html);
                                        scrollSmoothToBottom('box_chat_midle_' + info_kq.booking);
                                        setTimeout(function () {
                                            $('#box_chat_midle_' + info_kq.booking).attr('loaded', '1');
                                        }, 1000);
                                    } else {

                                    }
                                });
                        }
                    }
                }
            }
        } else {
        }
    });
    ////////////////////
    socket.on("server_send_chating", function (data) {
        text = $('input[name=user_chating]').val();
        user_out = $('input[name=thanhvien_chat]').val();
        var info = JSON.parse(data);
        if (user_out == info.user_in) {
            name = $('#box_chat_' + info.user_out + ' .box_chat_top .box_chat_top_name span').html();
            $('#box_chat_' + info.user_out + ' .chating').show();
            $('#box_chat_' + info.user_out + ' .chating').html(name + ' ' + text);
        }
    });
    ////////////////////
    socket.on("server_send_stop_chat", function (data) {
        var info = JSON.parse(data);
        user_out = $('input[name=thanhvien_chat]').val();
        $('#box_chat_' + info.user_out + ' .chating').hide();
        $('#box_chat_' + info.user_out + ' .chating').html('');
    });
    ////////////////////
    socket.on("server_send_chat", function (data) {
        user_out = $('input[name=thanhvien_chat]').val();
        var info = JSON.parse(data);
        sms_out = info.sms_out.replace(/\\/g, '');
        sms_in = info.sms_in.replace(/\\/g, '');
        console.log(info);
        if (user_out == info.user_in) {
            last = $('#box_chat_' + info.user_out + ' .box_chat_midle .li_sms').last().attr("value");
            avatar = $('#box_chat_' + info.user_out).attr("avatar");
            username = $('#box_chat_' + info.user_out).attr("username");
            if (last == 'sms_out') {
                $('#box_chat_' + info.user_out + ' .box_chat_midle').append('<div class="li_sms_in_first li_sms" value="sms_in_first"><div class="li_sms_in_first_avatar"><a href="' + username + '"><img src="' + avatar + '" onerror="this.src=\'/images/user.png\';"></a></div><div class="li_sms_in_first_content">' + sms_out + '</div></div>');
            } else {
                $('#box_chat_' + info.user_out + ' .box_chat_midle').append('<div class="li_sms_in li_sms" value="sms_in"><div class="li_sms_in_content">' + sms_out + '</div></div>');
            }
            $('.sms_typing').hide();
            scrollSmoothToBottom('box_chat_midle_' + info.user_out);
        } else {
        }
    });
    /////////////////////////////
    // socket.on("server_send_hoatdong", function (data) {
    //     var info = JSON.parse(data);
    //     var thanhvien_chat = $('input[name=thanhvien_chat]').val();
    //     console.log(info);
    //     console.log(thanhvien_chat);
    //     if (info.hd == 'huy_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'tuchoi_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'rate_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'xacnhan_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             var id_booking = info.id_booking;
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_show_box',
    //                     id_booking: id_booking
    //                 },
    //                 success: function (kqx) {
    //                     var infox = JSON.parse(kqx);
    //                     $('.box_dat_hoanthanh').show();
    //                     $('.box_dat_hoanthanh .text_success').html('Booking đã được chấp nhận');
    //                     $('.box_dat_hoanthanh .table_success').html(infox.box);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'hoanthanh_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'dat_booking') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     } else if (info.hd == 'xacnhan_naptien') {
    //         if (info.user_id == thanhvien_chat) {
    //             $.ajax({
    //                 url: "/members/process.php",
    //                 type: "post",
    //                 data: {
    //                     action: 'load_tk_notification',
    //                 },
    //                 success: function (kq) {
    //                     var info = JSON.parse(kq);
    //                     if (info.total == 0) {
    //                     } else {
    //                         $('#play_chat_global').click();
    //                     }
    //                     $('.total_notification').html(info.total);
    //                     $('.total_booking_wait').html(info.total_booking_wait);
    //                     $('.total_booking_confirm').html(info.total_booking_confirm);
    //                     $('.total_booking_false').html(info.total_booking_false);
    //                     $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
    //                     $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
    //                     $('.total_dat_booking_false').html(info.total_dat_booking_false);
    //                 }
    //             });
    //         }
    //     }
    // });
    ////////////////////////////
    $('body').on('click', '.box_loai_hinh_dashboard input[type=radio]', function () {
        loai_hinh_hienthi = $('.box_loai_hinh input[name=loai_hinh_hienthi]:checked').val();
        if (loai_hinh_hienthi == 'hangnhap') {
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').show();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangnhap');
        } else if (loai_hinh_hienthi == 'hangxuat') {
            $('.box_container #container_hangxuat').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hangxuat');
        } else if (loai_hinh_hienthi == 'noidia') {
            $('.box_container #container_noidia').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_hangxuat').hide();
            $('.timkiem_dashboard select[name=loai_hinh]').val('hang_noidia');
        } else if (loai_hinh_hienthi == 'goi_y') {
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').show();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "load_booking_goiy",
                    page: 1
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('#container_goiy .table_hang').html(info.list);
                    } else {
                        noti(info.thongbao, 0, 2000);
                    }
                }
            });
        }
    });
    ////////////////////////////
    $('body').on('click', '.box_loai_hinh_user input[type=radio]', function () {
        loai_hinh_hienthi = $('.box_loai_hinh input[name=loai_hinh_hienthi]:checked').val();
        if (loai_hinh_hienthi == 'hangnhap') {
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').show();
            $('.box_container #container_noidia').hide();
            $('.timkiem_user select[name=loai_hinh]').val('hangnhap');
        } else if (loai_hinh_hienthi == 'hangxuat') {
            $('.box_container #container_hangxuat').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $('.timkiem_user select[name=loai_hinh]').val('hangxuat');
        } else if (loai_hinh_hienthi == 'noidia') {
            $('.box_container #container_noidia').show();
            $('.box_container #container_goiy').hide();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_hangxuat').hide();
            $('.timkiem_user select[name=loai_hinh]').val('hang_noidia');
        } else if (loai_hinh_hienthi == 'goi_y') {
            $('.box_container #container_hangxuat').hide();
            $('.box_container #container_goiy').show();
            $('.box_container #container_hangnhap').hide();
            $('.box_container #container_noidia').hide();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "load_booking_goiy",
                    page: 1
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('#container_goiy .table_hang').html(info.list);
                    } else {
                        noti(info.thongbao, 0, 2000);
                    }
                }
            });
        }
    });
    var lastScrollTop = 0;
    var lastScrollLeft = 0;
    ////////////////////////
    $('#list_hangxuat_user').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hangxuat_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hangxuat_user').attr('tiep');
            page = $('#list_hangxuat_user').attr('page');
            loaded = $('#list_hangxuat_user').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hangxuat_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangxuat_user').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangxuat_user .loading_hang').remove();
                            $('#list_hangxuat_user .table_hang').append(info.list);
                            $('#list_hangxuat_user').attr('page', info.page);
                            $('#list_hangxuat_user').attr('tiep', info.tiep);
                            $('#list_hangxuat_user').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangnhap_user').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hangnhap_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hangnhap_user').attr('tiep');
            page = $('#list_hangnhap_user').attr('page');
            loaded = $('#list_hangnhap_user').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hangnhap_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangnhap_user').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangnhap_user .loading_hang').remove();
                            $('#list_hangnhap_user .table_hang').append(info.list);
                            $('#list_hangnhap_user').attr('page', info.page);
                            $('#list_hangnhap_user').attr('tiep', info.tiep);
                            $('#list_hangnhap_user').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hang_noidia_user').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hang_noidia_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hang_noidia_user').attr('tiep');
            page = $('#list_hang_noidia_user').attr('page');
            loaded = $('#list_hang_noidia_user').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hang_noidia_user').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hang_noidia_user').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_user",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hang_noidia_user .loading_hang').remove();
                            $('#list_hang_noidia_user .table_hang').append(info.list);
                            $('#list_hang_noidia_user').attr('page', info.page);
                            $('#list_hang_noidia_user').attr('tiep', info.tiep);
                            $('#list_hang_noidia_user').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangxuat_dashboard').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hangxuat_dashboard');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hangxuat_dashboard').attr('tiep');
            page = $('#list_hangxuat_dashboard').attr('page');
            loaded = $('#list_hangxuat_dashboard').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hangxuat_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangxuat_dashboard').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangxuat_dashboard .loading_hang').remove();
                            $('#list_hangxuat_dashboard .table_hang').append(info.list);
                            $('#list_hangxuat_dashboard').attr('page', info.page);
                            $('#list_hangxuat_dashboard').attr('tiep', info.tiep);
                            $('#list_hangxuat_dashboard').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangnhap_dashboard').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hangnhap_dashboard');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hangnhap_dashboard').attr('tiep');
            page = $('#list_hangnhap_dashboard').attr('page');
            loaded = $('#list_hangnhap_dashboard').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hangnhap_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangnhap_dashboard').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hangnhap_dashboard .loading_hang').remove();
                            $('#list_hangnhap_dashboard .table_hang').append(info.list);
                            $('#list_hangnhap_dashboard').attr('page', info.page);
                            $('#list_hangnhap_dashboard').attr('tiep', info.tiep);
                            $('#list_hangnhap_dashboard').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////
    $('#list_hangnhap').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        var div_hang = $('#list_hangnhap');

        // Lấy các giá trị từ input tìm kiếm
        var from = $('.box_timkiem input[name=from]').val();
        var to = $('.box_timkiem input[name=to]').val();
        var ten_xa = $('.box_timkiem input[name=ten_xa]').val();
        var ten_huyen = $('.box_timkiem input[name=ten_huyen]').val();
        var ten_tinh = $('.box_timkiem select[name=ten_tinh]').val();


        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30) {
            var tiep = $('#list_hangnhap').attr('tiep');
            var page = $('#list_hangnhap').attr('page');
            var loaded = $('#list_hangnhap').attr('loaded');

            if (loaded == 1 && tiep == 1) {
                $('#list_hangnhap').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hangnhap').attr('loaded', 0);

                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "POST",
                        data: {
                            action: "load_timkiem_hangnhap",
                            ten_xa: ten_xa,
                            ten_huyen: ten_huyen,
                            ten_tinh: ten_tinh,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (response) {
                            try {
                                var info = JSON.parse(response);
                                $('#list_hangnhap .loading_hang').remove();
                                $('#list_hangnhap .table_hang').append(info.list);
                                $('#list_hangnhap').attr('page', info.page);
                                $('#list_hangnhap').attr('tiep', info.tiep);
                                $('#list_hangnhap').attr('loaded', 1);
                            } catch (e) {
                                console.error("Lỗi khi xử lý dữ liệu phản hồi: ", e);
                                $('#list_hangnhap .loading_hang').remove();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Lỗi AJAX:", status, error);
                            $('#list_hangnhap .loading_hang').remove();
                        }
                    });
                }, 1000);
            }
        }
    });

    //////////////////////
    $('#list_hang_noidia_dashboard').on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var scrollLeft = $(this).scrollLeft();
        div_hang = $('#list_hang_noidia_user');
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (div_hang.scrollTop() + div_hang.innerHeight() >= div_hang[0].scrollHeight - 30 && scrollTop != lastScrollTop) {
            tiep = $('#list_hang_noidia_dashboard').attr('tiep');
            page = $('#list_hang_noidia_dashboard').attr('page');
            loaded = $('#list_hang_noidia_dashboard').attr('loaded');
            if (loaded == 1 && tiep == 1) {
                $('#list_hang_noidia_dashboard').append('<div class="loading_hang"><i class="fa fa-refresh fa-spin"></i> Đang tải dữ liệu...</div>');
                $('#list_hang_noidia_dashboard').attr('loaded', 0);
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_timkiem_booking_dashboard",
                            loai_hinh: loai_hinh,
                            hang_tau: hang_tau,
                            hang_tau_id: hang_tau_id,
                            loai_container: loai_container,
                            dia_diem: dia_diem,
                            dia_diem_id: dia_diem_id,
                            from: from,
                            to: to,
                            page: page,
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_hang_noidia_dashboard .loading_hang').remove();
                            $('#list_hang_noidia_dashboard .table_hang').append(info.list);
                            $('#list_hang_noidia_dashboard').attr('page', info.page);
                            $('#list_hang_noidia_dashboard').attr('tiep', info.tiep);
                            $('#list_hang_noidia_dashboard').attr('loaded', 1);
                        }
                    });
                }, 1000);
            }
        }
        lastScrollTop = scrollTop;
        lastScrollLeft = scrollLeft;
    });
    ////////////////////////////
    $('body').on('click', '.box_pop_add .pop_title .fa-close', function () {
        $('.box_pop_add').hide();
        $('.box_pop_add').html('');
    });
    ////////////////////////////
    $('body').on('click', '.box_pop_add button#cancel', function () {
        $('.box_pop_add').hide();
        $('.box_pop_add').html('');
    });
    ////////////////////////////
    $('body').on('click', 'button[name=show_chat]', function () {
        id = $(this).attr('id');
        if ($('.main_box_chat #box_chat_' + id).length > 0) {
        } else {
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "show_box_chat",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.main_box_chat').append(info.html);
                    } else {
                        noti(info.thongbao, 0, 2000);
                    }
                }
            });
        }
    });
    ////////////////////////////
    $('body').on('click', '.box_player .close', function () {
        $('.box_player').fadeOut();
        $('.box_player #content_video').html('');
    });
    ////////////////////////////
    $('body').on('click', '.list_video .li_video', function () {
        id_video = $(this).attr('id_video');
        tieu_de = $(this).find('.tieu_de a').html();
        $('.box_player .title').html('<i class="fa fa-play-circle"></i> ' + tieu_de);
        $('.box_player #content_video').html('<iframe src="https://www.youtube.com/embed/' + id_video + '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $('.box_player').show();
    });
    ////////////////////////
    $('body').on('click', '#container_hangxuat .table_hang .fa-minus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container = ($('.tr_more_' + id_container).length) / 2 + 1;
        $(this).parent().parent().find('td:eq(4)').html(total_container);
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).hide();
        } else {
        }

    });
    ////////////////////////
    $('body').on('click', '#container_hangxuat .table_hang .fa-plus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(4)').html('1');
        } else {
            $(this).parent().parent().find('td:eq(4)').html('1');
            if ($('.timkiem_user').length > 0) {
                action = 'load_more_user_container';
            } else {
                action = 'load_more_container';
            }
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container: id_container
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 0) {
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function () {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    } else {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_' + id_container).after(info.list);

                        } else {
                        }
                    }
                }
            });
        }

    });
    ////////////////////////
    $('body').on('click', '#container_hangnhap .table_hang .fa-minus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container = ($('.tr_more_' + id_container).length) / 2 + 1;
        $(this).parent().parent().find('td:eq(4)').html(total_container);
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).hide();
        } else {
        }

    });
    ////////////////////////
    $('body').on('click', '#container_hangnhap .table_hang .fa-plus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(4)').html('1');
        } else {
            $(this).parent().parent().find('td:eq(4)').html('1');
            if ($('.timkiem_user').length > 0) {
                action = 'load_more_user_container';
            } else {
                action = 'load_more_container';
            }
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container: id_container
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 0) {
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function () {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    } else {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_' + id_container).after(info.list);

                        } else {
                        }
                    }
                }
            });
        }

    });
    ////////////////////////
    $('body').on('click', '#container_noidia .table_hang .fa-minus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-minus-circle');
        itm.parent().find('i').addClass('fa-plus-circle');
        total_container = ($('.tr_more_' + id_container).length) / 2 + 1;
        $(this).parent().parent().find('td:eq(2)').html(total_container);
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).hide();
        } else {
        }

    });
    ////////////////////////
    $('body').on('click', '#container_noidia .table_hang .fa-plus-circle', function () {
        var itm = $(this);
        var id_container = $(this).attr('id_container');
        if ($('.tr_more_' + id_container).length > 0) {
            $('.tr_more_' + id_container).show();
            itm.parent().find('i').removeClass('fa-plus-circle');
            itm.parent().find('i').addClass('fa-minus-circle');
            $(this).parent().parent().find('td:eq(2)').html('1');
        } else {
            $(this).parent().parent().find('td:eq(2)').html('1');
            if ($('.timkiem_user').length > 0) {
                action = 'load_more_user_container';
            } else {
                action = 'load_more_container';
            }
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: action,
                    id_container: id_container
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 0) {
                        $('.load_overlay2').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function () {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay2').hide();
                        }, 2000);
                    } else {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            itm.parent().find('i').removeClass('fa-plus-circle');
                            itm.parent().find('i').addClass('fa-minus-circle');
                            $('#tr_' + id_container).after(info.list);

                        } else {
                        }
                    }
                }
            });
        }

    });
    /////////////////////////////
    $('body').on('click', 'button[name=show_yeucau_huy]', function () {
        noti('Hệ thống đang xử lý', 0, 1000);
        id = $(this).attr('id');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "show_add",
                loai: 'show_yeucau_huy',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.box_pop_add').html(info.html);
                        $('.box_pop_add').show();
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
                            showMonthAfterYear: false,
                            yearSuffix: ""
                        });
                    }, 1000);
                } else {
                    noti(info.thongbao, 0, 1000);
                }
            }

        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=add_booking]', function () {
        noti('Hệ thống đang xử lý', 0, 1000);
        id = $('.box_form input[name=id]').val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "show_add",
                loai: 'add_booking',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.box_pop_add').html(info.html);
                        $('.box_pop_add').show();
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
                            showMonthAfterYear: false,
                            yearSuffix: ""
                        });
                    }, 1000);
                } else {
                    noti(info.thongbao, 0, 1000);
                }
            }

        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=rate_booking]', function () {
        noti('Hệ thống đang xử lý', 0, 1000);
        id = $('.box_form input[name=id]').val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "show_add",
                loai: 'rate_booking',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        $('.box_pop_add').html(info.html);
                        $('.box_pop_add').show();
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
                            showMonthAfterYear: false,
                            yearSuffix: ""
                        });
                    }, 1000);
                } else {
                    noti(info.thongbao, 0, 1000);
                }
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_hangnhap_content select[name=tinh]', function () {
        tinh = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangnhap_content select[name=huyen]').html(info.list);
                $('#tab_hangnhap_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_hangnhap_content select[name=tinh]', function () {
        tinh = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangnhap_content select[name=huyen]').html(info.list);
                $('#tab_hangnhap_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_hangnhap_content select[name=huyen]', function () {
        huyen = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_xa",
                huyen: huyen
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangnhap_content select[name=xa]').html(info.list);
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_hangxuat_content select[name=tinh]', function () {
        tinh = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_huyen",
                tinh: tinh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangxuat_content select[name=huyen]').html(info.list);
                $('#tab_hangxuat_content select[name=xa]').html('<option value="">Chọn xã/thị trấn</option>');
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_hangxuat_content select[name=huyen]', function () {
        huyen = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_xa",
                huyen: huyen
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_hangxuat_content select[name=xa]').html(info.list);
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_noidia_content select[name=huyen]', function () {
        huyen = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_xa",
                huyen: huyen
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_noidia_content select[name=xa]').html(info.list);
            }

        });
    });
    /////////////////////////////
    $('body').on('change', '#tab_noidia_content select[name=huyen_donghang]', function () {
        huyen = $(this).val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "get_xa",
                huyen: huyen
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('#tab_noidia_content select[name=xa_donghang]').html(info.list);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.box_sticker .li_tab', function () {
        tab = $(this).attr('id');
        $('.list_sticker_content').removeClass('active');
        $('#' + tab + '_content').addClass('active');

    });
    /////////////////////////////
    $('body').on('click', '#smile', function () {
        $('.box_sticker').toggle();
    });
    /////////////////////////////
    $('body').on('click', '.box_gan .li_tab', function () {
        li_tab = $(this).attr('id');
        $('.box_gan .li_tab').removeClass('active');
        $(this).addClass('active');
        $('.box_gan .li_tab_content').removeClass('active');
        $('.box_gan .li_tab_content#' + li_tab + '_content').addClass('active');
    });

    /////////////////////////////
    $('body').on('click', '.box_note_gan', function () {
        $('.box_gan').fadeIn();
    });
    /////////////////////////////
    $('body').on('click', '.box_gan .title .fa', function () {
        $('.box_gan').hide();
    });
    /////////////////////////////
    $('body').on('click', '#attachment', function () {
        $('#dinh_kem').click();
    });
    //////////////////////////////

    //////////////////////////////
    $('body').on('click', '.box_dat_hoanthanh .close', function () {
        $('.box_dat_hoanthanh').hide();
    });
    //////////////////////////////
    $('body').on('click', '.box_kichhoat .close', function () {
        $('.box_kichhoat').hide();
    });
    //////////////////////////////
    $('body').on('click', '.box_form .list_tab .li_tab', function () {
        tab = $(this).attr('id');
        $('.box_form .list_tab .li_tab').removeClass('active');
        $(this).addClass('active');
        $('.box_form .list_tab_content .li_tab_content').removeClass('active');
        $('.box_form .list_tab_content #' + tab + '_content').addClass('active');

    });
    //////////////////////////////
    $('body').on('click', '#tab_hangnhap_content .del_container', function () {
        id_container = $(this).attr('id_container');
        if (id_container == '') {
            $(this).parent().parent().remove();
            so_luong = $('#tab_hangnhap_content .li_container').length;
            $('#tab_hangnhap_content input[name=so_luong]').val(so_luong);
        } else {
            $('#box_pop_confirm').show();
            $('#box_pop_confirm .text_note').html('Hành động xóa này sẽ không thể phục hồi!<br>Bạn có chắc muốn thực hiện?');
            $('#button_thuchien').attr('action', 'del_container');
            $('#button_thuchien').attr('post_id', id_container);

        }
    });
    //////////////////////////////
    $('body').on('input', '#tab_hangnhap_content .sl_container', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;

                for (var i = 0; i < sl_hon; i++) {
                    var li_container = '';

                    // Nếu đây là ô thứ 2 trở đi (i + sl_ht > 0) thì thêm phần có thể hiển thị nút "Sao chép"
                    if (sl_ht + i > 0) {
                        li_container = '<div class="li_container">' +
                            '<div class="left_container">' +
                            '<label>Số hiệu</label>' +
                            '<input type="text" name="so_hieu[]" placeholder="Số hiệu container" autocomplete="off">' +
                            '</div>' +
                            '<div class="right_container">' +
                            '<label>Thời gian trả hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" autocomplete="off" placeholder="Nhập ngày trả hàng">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian trả hàng">' +
                            '<button class="copy-btn" ><i class="fa-regular fa-copy"></i></button>' + // Nút "Sao chép" ẩn đi ban đầu
                            '</div>' +
                            '</div>';
                    } else {
                        // Ô đầu tiên không có nút "Sao chép"
                        li_container = '<div class="li_container">' +
                            '<div class="left_container">' +
                            '<label>Số hiệu</label>' +
                            '<input type="text" name="so_hieu[]" placeholder="Số hiệu container" autocomplete="off">' +
                            '</div>' +
                            '<div class="right_container">' +
                            '<label>Thời gian trả hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" autocomplete="off" placeholder="Nhập ngày trả hàng">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian trả hàng">' +
                            '</div>' +
                            '</div>';
                    }

                    $(this).parent().parent().parent().find('.list_container').append(li_container);

                    // Initialize datepicker and timepicker
                    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
                    $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
                    $.datepicker.setDefaults({
                        closeText: "Đóng",
                        prevText: "&#x3C;Trước",
                        nextText: "Tiếp&#x3E;",
                        currentText: "Hôm nay",
                        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
                        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
                        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        weekHeader: "Tu",
                        firstDay: 0,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else if (sl < sl_ht) {
                k = 0;
                $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                    k++;
                    if (k > sl) {
                        $(this).remove();
                    }
                });
            }
        } else {
            $(this).parent().parent().parent().find('#input_container').hide();
            $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                $(this).remove();
            });
        }
    });

    // Hiển thị nút "Sao chép" khi người dùng nhấn vào ô thứ 2 trở đi
    $('body').on('focus', '.li_container input', function () {
        var container = $(this).closest('.li_container');
        if (container.index() > 0) { // Chỉ hiện nút "Sao chép" từ ô thứ 2 trở đi
            container.find('.copy-btn').show();
        }
    });

    // Xử lý sự kiện khi người dùng nhấn nút "Sao chép"
    $('body').on('click', '.copy-btn', function () {
        var currentContainer = $(this).closest('.li_container');
        var prevContainer = currentContainer.prev('.li_container'); // Lấy dòng liền trước

        if (prevContainer.length) {
            var prev_ngay_trahang = prevContainer.find('input[name^=ngay_trahang]').val();
            var prev_thoi_gian = prevContainer.find('input[name^=thoi_gian]').val();

            // Sao chép giá trị từ dòng trước vào dòng hiện tại
            currentContainer.find('input[name^=ngay_trahang]').val(prev_ngay_trahang);
            currentContainer.find('input[name^=thoi_gian]').val(prev_thoi_gian);
        }

        // Ẩn nút "Sao chép" sau khi sao chép xong
        $(this).hide();
    });


    //////////////////////////////
    $('body').on('input', '#tab_hangnhap_content .sl_container_edit', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;
                for (var i = 0; i < sl_hon; i++) {
                    $(this).parent().parent().parent().find('.list_container').append('<div class="li_container"><div class="left_container"><label>Số hiệu</label><input type="text" name="so_hieu[]" placeholder="Số hiệu container" autocomplete="off"></div><div class="right_container"><label>Thời gian trả hàng</label><input type="text" name="ngay_trahang[]" autocomplete="off" class="datepicker" placeholder="Nhập ngày trả hàng"><input type="text" name="thoi_gian[]" class="timepicker" placeholder="Nhập thời gian trả hàng" autocomplete="off"><span class="del_container" id_container=""><i class="fa fa-trash-o"></i> xóa</span></div></div>');
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
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else {
            }
        } else {

        }

    });
    //////////////////////////////
    $('body').on('input', '#tab_hangxuat_content .sl_container', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;
                for (var i = 0; i < sl_hon; i++) {
                    var li_container = '';

                    // Nếu đây là ô thứ 2 trở đi, thêm nút "Sao chép"
                    if (sl_ht + i > 0) {
                        li_container = '<div class="li_container">' +
                            '<div class="right_container">' +
                            '<label>Thời gian đóng hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" placeholder="Nhập ngày đóng hàng" autocomplete="off">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian đóng hàng">' +
                            '<button class="copy-btn"><i class="fa-regular fa-copy"></i></button>' + // Nút "Sao chép" ẩn đi ban đầu
                            '</div>' +
                            '</div>';
                    } else {
                        // Ô đầu tiên không có nút "Sao chép"
                        li_container = '<div class="li_container">' +
                            '<div class="right_container">' +
                            '<label>Thời gian đóng hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" placeholder="Nhập ngày đóng hàng" autocomplete="off">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian đóng hàng">' +
                            '</div>' +
                            '</div>';
                    }

                    $(this).parent().parent().parent().find('.list_container').append(li_container);

                    // Initialize datepicker and timepicker
                    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
                    $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
                    $.datepicker.setDefaults({
                        closeText: "Đóng",
                        prevText: "&#x3C;Trước",
                        nextText: "Tiếp&#x3E;",
                        currentText: "Hôm nay",
                        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
                        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
                        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        weekHeader: "Tu",
                        firstDay: 0,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else if (sl < sl_ht) {
                k = 0;
                $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                    k++;
                    if (k > sl) {
                        $(this).remove();
                    }
                });
            }
        } else {
            $(this).parent().parent().parent().find('#input_container').hide();
            $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                $(this).remove();
            });
        }
    });

    // Hiển thị nút "Sao chép" khi người dùng nhấn vào ô thứ 2 trở đi
    $('body').on('focus', '.li_container input', function () {
        var container = $(this).closest('.li_container');
        if (container.index() > 0) { // Chỉ hiện nút "Sao chép" từ ô thứ 2 trở đi
            container.find('.copy-btn').show();
        }
    });

    // Xử lý sự kiện khi người dùng nhấn nút "Sao chép"
    $('body').on('click', '.copy-btn', function () {
        var currentContainer = $(this).closest('.li_container');
        var prevContainer = currentContainer.prev('.li_container'); // Lấy dòng liền trước

        if (prevContainer.length) {
            var prev_ngay_trahang = prevContainer.find('input[name^=ngay_trahang]').val();
            var prev_thoi_gian = prevContainer.find('input[name^=thoi_gian]').val();

            // Sao chép giá trị từ dòng trước vào dòng hiện tại
            currentContainer.find('input[name^=ngay_trahang]').val(prev_ngay_trahang);
            currentContainer.find('input[name^=thoi_gian]').val(prev_thoi_gian);
        }

        // Ẩn nút "Sao chép" sau khi sao chép xong
        $(this).hide();
    });

    //////////////////////////////
    $('body').on('input', '#tab_hangxuat_content .sl_container_edit', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;
                for (var i = 0; i < sl_hon; i++) {
                    $(this).parent().parent().parent().find('.list_container').append('<div class="li_container"><div class="right_container"><label>Thời gian đóng hàng</label><input type="text" name="ngay_trahang[]" autocomplete="off" class="datepicker" placeholder="Nhập ngày đóng hàng"><input type="text" name="thoi_gian[]" class="timepicker" placeholder="Nhập thời gian đóng hàng" autocomplete="off"><span class="del_container" id_container=""><i class="fa fa-trash-o"></i> xóa</span></div></div>');
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
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else {
            }
        } else {
        }

    });
    //////////////////////////////
    $('body').on('input', '#tab_noidia_content .sl_container', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;
                for (var i = 0; i < sl_hon; i++) {
                    var li_container = '';

                    // Nếu đây là ô thứ 2 trở đi, thêm nút "Sao chép"
                    if (sl_ht + i > 0) {
                        li_container = '<div class="li_container">' +
                            '<div class="right_container">' +
                            '<label>Thời gian đóng hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" placeholder="Nhập ngày đóng hàng" autocomplete="off">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian đóng hàng">' +
                            '<button class="copy-btn"><i class="fa-regular fa-copy"></i></button>' + // Nút "Sao chép" ẩn đi ban đầu
                            '</div>' +
                            '</div>';
                    } else {
                        // Ô đầu tiên không có nút "Sao chép"
                        li_container = '<div class="li_container">' +
                            '<div class="right_container">' +
                            '<label>Thời gian đóng hàng</label>' +
                            '<input type="text" name="ngay_trahang[]" class="datepicker" placeholder="Nhập ngày đóng hàng" autocomplete="off">' +
                            '<input type="text" name="thoi_gian[]" class="timepicker" autocomplete="off" placeholder="Nhập thời gian đóng hàng">' +
                            '</div>' +
                            '</div>';
                    }

                    $(this).parent().parent().parent().find('.list_container').append(li_container);

                    // Initialize datepicker and timepicker
                    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
                    $('input.timepicker').timepicker({ 'timeFormat': 'H:i', 'step': 5 });
                    $.datepicker.setDefaults({
                        closeText: "Đóng",
                        prevText: "&#x3C;Trước",
                        nextText: "Tiếp&#x3E;",
                        currentText: "Hôm nay",
                        monthNames: ["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                            "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai"],
                        monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                            "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                        dayNames: ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"],
                        dayNamesShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                        weekHeader: "Tu",
                        firstDay: 0,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else if (sl < sl_ht) {
                k = 0;
                $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                    k++;
                    if (k > sl) {
                        $(this).remove();
                    }
                });
            }
        } else {
            $(this).parent().parent().parent().find('#input_container').hide();
            $(this).parent().parent().parent().find('.list_container .li_container').each(function () {
                $(this).remove();
            });
        }
    });

    // Hiển thị nút "Sao chép" khi người dùng nhấn vào ô thứ 2 trở đi
    $('body').on('focus', '.li_container input', function () {
        var container = $(this).closest('.li_container');
        if (container.index() > 0) { // Chỉ hiện nút "Sao chép" từ ô thứ 2 trở đi
            container.find('.copy-btn').show();
        }
    });

    // Xử lý sự kiện khi người dùng nhấn nút "Sao chép"
    $('body').on('click', '.copy-btn', function () {
        var currentContainer = $(this).closest('.li_container');
        var prevContainer = currentContainer.prev('.li_container'); // Lấy dòng liền trước

        if (prevContainer.length) {
            var prev_ngay_trahang = prevContainer.find('input[name^=ngay_trahang]').val();
            var prev_thoi_gian = prevContainer.find('input[name^=thoi_gian]').val();

            // Sao chép giá trị từ dòng trước vào dòng hiện tại
            currentContainer.find('input[name^=ngay_trahang]').val(prev_ngay_trahang);
            currentContainer.find('input[name^=thoi_gian]').val(prev_thoi_gian);
        }

        // Ẩn nút "Sao chép" sau khi sao chép xong
        $(this).hide();
    });

    //////////////////////////////
    $('body').on('input', '#tab_noidia_content .sl_container_edit', function () {
        sl = $(this).val();
        sl_ht = $(this).parent().parent().parent().find('.list_container .li_container').length;
        var sl = sl.replace(/\D/g, '');
        sl = parseInt(sl);
        if (isNaN(sl)) {
            sl = 0;
        }
        if (sl > 0) {
            $(this).parent().parent().parent().find('#input_container').show();
            if (sl > sl_ht) {
                sl_hon = sl - sl_ht;
                for (var i = 0; i < sl_hon; i++) {
                    $(this).parent().parent().parent().find('.list_container').append('<div class="li_container"><div class="right_container"><label>Thời gian đóng hàng</label><input type="text" name="ngay_trahang[]" autocomplete="off" class="datepicker" placeholder="Nhập ngày đóng hàng"><input type="text" name="thoi_gian[]" class="timepicker" placeholder="Nhập thời gian đóng hàng" autocomplete="off"><span class="del_container" id_container=""><i class="fa fa-trash-o"></i> xóa</span></div></div>');
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
                        showMonthAfterYear: false,
                        yearSuffix: ""
                    });
                }
            } else {
            }
        } else {
        }

    });
    /////////////////////////////
    $('body').on('click', '.box_pop_add button[name=dat_booking]', function () {
        gia = $('.box_pop_add input[name=gia]').val();
        ngay_trahang = $('.box_pop_add input[name=ngay_trahang]').val();
        thoi_gian = $('.box_pop_add input[name=thoi_gian]').val();
        id = $('.box_pop_add input[name=id]').val();
        if (gia.length < 2) {
            $('.box_pop_add input[name=gia]').focus();
            noti('Vui lòng nhập giá cước nhận', 0, 2000);
        } else if (ngay_trahang.length < 3) {
            $('.box_pop_add input[name=ngay_trahang]').focus();
            noti('Vui lòng nhập ngày trả hàng dự kiến', 0, 2000);
        } else if (thoi_gian.length < 3) {
            $('.box_pop_add input[name=thoi_gian]').focus();
            noti('Vui lòng nhập thời gian trả hàng', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "dat_booking",
                    gia: gia,
                    ngay_trahang: ngay_trahang,
                    thoi_gian: thoi_gian,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            var dulieu = {
                                'hd': 'dat_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.href = '/members/list-dat-booking-wait';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=add_hangnhap]', function () {
        var so_booking = $('#tab_hangnhap_content input[name=so_booking]').val();
        var hang_tau = $('#tab_hangnhap_content input[name=hang_tau_id]').val();
        var phan_loai = $('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var loai_container = $('#tab_hangnhap_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangnhap_content select[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangnhap_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_hangnhap_content input[name=tinh_id]').val();
        var han_tra_rong = $('#tab_hangnhap_content input[name=han_tra_rong]').val();
        var huyen = $('#tab_hangnhap_content select[name=huyen]').val();
        var xa = $('#tab_hangnhap_content select[name=xa]').val();
        var mat_hang = $('#tab_hangnhap_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangnhap_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangnhap_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangnhap_content input[name=trong_luong]').val();
        var gia = $('#tab_hangnhap_content input[name=gia]').val();
        var ghi_chu = $('#tab_hangnhap_content textarea[name=ghi_chu]').val();
        var ten_hangtau = $('#tab_hangnhap_content input[name=hang_tau]').val();
        var ten_loai_container = $('#tab_hangnhap_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangnhap_content select[name=diachi_donghang] option:selected').text();
        var ten_tinh = $('#tab_hangnhap_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangnhap_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangnhap_content select[name=xa] option:selected').text();
        var list_container = '';
        if ($('#tab_hangnhap_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangnhap_content .list_container .li_container').each(function () {
                so_hieu = $(this).find('input[name^=so_hieu]').val();
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                if (so_hieu.length > 1) {
                    s++;
                    if (s == 1) {
                        list_container += '{"so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng chọn địa chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng nhập địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
            // } else if (gia == '') {
            //     show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var file_data = $('#tab_hangnhap_content input[name=file_booking]').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_hangnhap');
            form_data.append('file', file_data);
            form_data.append('so_booking', so_booking);
            form_data.append('phan_loai', phan_loai);
            form_data.append('hang_tau', hang_tau);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('han_tra_rong', han_tra_rong);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form .list_tab').hide();
                            $('#tab_hangnhap_content').html(info.html);
                            if (info.total > 0) {
                                $('.box_gan').show();
                                $('.table_hang').html(info.list_hang_goiy);
                            } else {
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=edit_hangnhap]', function () {
        var so_booking = $('#tab_hangnhap_content input[name=so_booking]').val();
        var phan_loai = $('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var hang_tau = $('#tab_hangnhap_content input[name=hang_tau_id]').val();
        var loai_container = $('#tab_hangnhap_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangnhap_content select[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangnhap_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_hangnhap_content input[name=tinh_id]').val();
        var huyen = $('#tab_hangnhap_content select[name=huyen]').val();
        var xa = $('#tab_hangnhap_content select[name=xa]').val();
        var mat_hang = $('#tab_hangnhap_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangnhap_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangnhap_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangnhap_content input[name=trong_luong]').val();
        var gia = $('#tab_hangnhap_content input[name=gia]').val();
        var han_tra_rong = $('#tab_hangnhap_content input[name=han_tra_rong]').val();
        var ghi_chu = $('#tab_hangnhap_content textarea[name=ghi_chu]').val();
        var id = $('#tab_hangnhap_content input[name=id]').val();
        var ten_hangtau = $('#tab_hangnhap_content input[name=hang_tau]').val();
        var ten_loai_container = $('#tab_hangnhap_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangnhap_content select[name=diachi_donghang] option:selected').text();
        var ten_tinh = $('#tab_hangnhap_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangnhap_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangnhap_content select[name=xa] option:selected').text();
        var list_container = '';
        if ($('#tab_hangnhap_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangnhap_content .list_container .li_container').each(function () {
                so_hieu = $(this).find('input[name^=so_hieu]').val();
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                id_container = $(this).attr('id_container');
                if (so_hieu.length > 1) {
                    s++;
                    if (s == 1) {
                        list_container += '{"id":"' + id_container + '","so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"id":"' + id_container + '","so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng chọn địa chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng nhập địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
            // } else if (gia == '') {
            //     show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'edit_hangnhap');
            var file_data = $('#tab_hangnhap_content input[name=file_booking]').prop('files')[0];
            form_data.append('so_booking', so_booking);
            form_data.append('phan_loai', phan_loai);
            form_data.append('file', file_data);
            form_data.append('hang_tau', hang_tau);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('han_tra_rong', han_tra_rong);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href = '/members/list-booking';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=copy_hangnhap]', function () {
        var so_booking = $('#tab_hangnhap_content input[name=so_booking]').val();
        var phan_loai = $('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var hang_tau = $('#tab_hangnhap_content input[name=hang_tau_id]').val();
        var loai_container = $('#tab_hangnhap_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangnhap_content select[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangnhap_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_hangnhap_content input[name=tinh_id]').val();
        var huyen = $('#tab_hangnhap_content select[name=huyen]').val();
        var xa = $('#tab_hangnhap_content select[name=xa]').val();
        var mat_hang = $('#tab_hangnhap_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangnhap_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangnhap_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangnhap_content input[name=trong_luong]').val();
        var gia = $('#tab_hangnhap_content input[name=gia]').val();
        var ghi_chu = $('#tab_hangnhap_content textarea[name=ghi_chu]').val();
        var ten_hangtau = $('#tab_hangnhap_content input[name=hang_tau]').val();
        var han_tra_rong = $('#tab_hangnhap_content input[name=han_tra_rong]').val();
        var ten_loai_container = $('#tab_hangnhap_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangnhap_content select[name=diachi_donghang] option:selected').text();
        var ten_tinh = $('#tab_hangnhap_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangnhap_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangnhap_content select[name=xa] option:selected').text();
        var list_container = '';
        if ($('#tab_hangnhap_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangnhap_content .list_container .li_container').each(function () {
                so_hieu = $(this).find('input[name^=so_hieu]').val();
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                if (so_hieu.length > 1) {
                    s++;
                    if (s == 1) {
                        list_container += '{"so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"so_hieu":"' + so_hieu + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangnhap_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng chọn địa chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng nhập địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
            // } else if (gia == '') {
            //     show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'copy_hangnhap');
            var file_data = $('#tab_hangnhap_content input[name=file_booking]').prop('files')[0];
            form_data.append('so_booking', so_booking);
            form_data.append('phan_loai', phan_loai);
            form_data.append('file', file_data);
            form_data.append('hang_tau', hang_tau);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('han_tra_rong', han_tra_rong);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form .list_tab').hide();
                            $('#tab_hangnhap_content').html(info.html);
                            if (info.total > 0) {
                                $('.box_gan').show();
                                $('.table_hang').html(info.list_hang_goiy);
                            } else {
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('change', '.box_pop_add select[name=ly_do]', function () {
        ly_do = $(this).val();
        if (ly_do == 'khac') {
            $('#input_lydo_khac').show();
        } else {
            $('#input_lydo_khac').hide();
        }

    });    //////////////////////////////
    $('body').on('click', '.box_pop_add_content button[name=yeucau_huy]', function () {
        var ly_do = $('.box_pop_add_content select[name=ly_do]').val();
        var ly_do_khac = $('.box_pop_add_content textarea[name=ly_do_khac]').val();
        var id = $('.box_pop_add_content input[name=id]').val();
        if (ly_do == '') {
            show_thongbao('Vui lòng chọn lý do', 'error');
        } else if (ly_do == 'khac' && ly_do_khac == '') {
            show_thongbao('Vui lòng nhập lý do hủy khác', 'error');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_yeucau_huy');
            form_data.append('ly_do', ly_do);
            form_data.append('ly_do_khac', ly_do_khac);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('button[name=show_yeucau_huy][id=' + id + ']').html('Đã yêu cầu hủy');
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=add_hangxuat]', function () {
        var so_booking = $('#tab_hangxuat_content input[name=so_booking]').val();
        var hang_tau = $('#tab_hangxuat_content input[name=hang_tau_id]').val();
        var loai_container = $('#tab_hangxuat_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangxuat_content input[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangxuat_content select[name=diachi_trahang]').val();
        var tinh = $('#tab_hangxuat_content input[name=tinh_id]').val();
        var huyen = $('#tab_hangxuat_content select[name=huyen]').val();
        var xa = $('#tab_hangxuat_content select[name=xa]').val();
        var mat_hang = $('#tab_hangxuat_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangxuat_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangxuat_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangxuat_content input[name=trong_luong]').val();
        var gia = $('#tab_hangxuat_content input[name=gia]').val();
        var ghi_chu = $('#tab_hangxuat_content textarea[name=ghi_chu]').val();
        var ten_hangtau = $('#tab_hangxuat_content input[name=hang_tau]').val();
        var ten_loai_container = $('#tab_hangxuat_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangxuat_content select[name=diachi_trahang] option:selected').text();
        var ten_tinh = $('#tab_hangxuat_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangxuat_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangxuat_content select[name=xa] option:selected').text();
        var ket_hop = $('#tab_hangxuat_content input[name=ket_hop]:checked').val();
        var phan_loai = $('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var list_container = '';
        if ($('#tab_hangxuat_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangxuat_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var file_data = $('#tab_hangxuat_content input[name=file_booking]').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'add_hangxuat');
            form_data.append('file', file_data);
            form_data.append('so_booking', so_booking);
            form_data.append('phan_loai', phan_loai);
            form_data.append('hang_tau', hang_tau);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ket_hop', ket_hop);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form .list_tab').hide();
                            $('#tab_hangxuat_content').html(info.html);
                            if (info.total > 0) {
                                $('.box_gan').show();
                                $('.table_hang').html(info.list_hang_goiy);
                            } else {
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=edit_hangxuat]', function () {
        var so_booking = $('#tab_hangxuat_content input[name=so_booking]').val();
        var phan_loai = $('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var hang_tau = $('#tab_hangxuat_content input[name=hang_tau_id]').val();
        var loai_container = $('#tab_hangxuat_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangxuat_content input[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangxuat_content select[name=diachi_trahang]').val();
        var tinh = $('#tab_hangxuat_content input[name=tinh_id]').val();
        var huyen = $('#tab_hangxuat_content select[name=huyen]').val();
        var xa = $('#tab_hangxuat_content select[name=xa]').val();
        var mat_hang = $('#tab_hangxuat_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangxuat_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangxuat_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangxuat_content input[name=trong_luong]').val();
        var gia = $('#tab_hangxuat_content input[name=gia]').val();
        var ghi_chu = $('#tab_hangxuat_content textarea[name=ghi_chu]').val();
        var ten_hangtau = $('#tab_hangxuat_content input[name=hang_tau]').val();
        var ten_loai_container = $('#tab_hangxuat_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangxuat_content select[name=diachi_trahang] option:selected').text();
        var ten_tinh = $('#tab_hangxuat_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangxuat_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangxuat_content select[name=xa] option:selected').text();
        var ket_hop = $('#tab_hangxuat_content input[name=ket_hop]:checked').val();
        var id = $('#tab_hangxuat_content input[name=id]').val();
        var list_container = '';
        if ($('#tab_hangxuat_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangxuat_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                id_container = $(this).attr('id_container');
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'edit_hangxuat');
            var file_data = $('#tab_hangxuat_content input[name=file_booking]').prop('files')[0];
            form_data.append('so_booking', so_booking);
            form_data.append('file', file_data);
            form_data.append('hang_tau', hang_tau);
            form_data.append('phan_loai', phan_loai);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ket_hop', ket_hop);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href = '/members/list-booking';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=copy_hangxuat]', function () {
        var so_booking = $('#tab_hangxuat_content input[name=so_booking]').val();
        var phan_loai = $('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').attr('value');
        var hang_tau = $('#tab_hangxuat_content input[name=hang_tau_id]').val();
        var loai_container = $('#tab_hangxuat_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_hangxuat_content input[name=diachi_donghang]').val();
        var diachi_trahang = $('#tab_hangxuat_content select[name=diachi_trahang]').val();
        var tinh = $('#tab_hangxuat_content input[name=tinh_id]').val();
        var huyen = $('#tab_hangxuat_content select[name=huyen]').val();
        var xa = $('#tab_hangxuat_content select[name=xa]').val();
        var mat_hang = $('#tab_hangxuat_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_hangxuat_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_hangxuat_content input[name=so_luong]').val();
        var trong_luong = $('#tab_hangxuat_content input[name=trong_luong]').val();
        var gia = $('#tab_hangxuat_content input[name=gia]').val();
        var ghi_chu = $('#tab_hangxuat_content textarea[name=ghi_chu]').val();
        var ten_hangtau = $('#tab_hangxuat_content input[name=hang_tau]').val();
        var ten_loai_container = $('#tab_hangxuat_content select[name=loai_container] option:selected').text();
        var ten_cang = $('#tab_hangxuat_content select[name=diachi_trahang] option:selected').text();
        var ten_tinh = $('#tab_hangxuat_content input[name=tinh]').val();
        var ten_huyen = $('#tab_hangxuat_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_hangxuat_content select[name=xa] option:selected').text();
        var ket_hop = $('#tab_hangxuat_content input[name=ket_hop]:checked').val();
        var list_container = '';
        if ($('#tab_hangxuat_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_hangxuat_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (so_booking == '') {
            show_thongbao('Vui lòng nhập số booking', 'error');
        } else if ($('#tab_hangxuat_content .box_phanloai_kieu input[name=option]:checked').length < 1) {
            show_thongbao('Vui lòng chọn loại hình vận tải', 'error');
        } else if (hang_tau == '') {
            show_thongbao('Vui lòng chọn hãng tàu', 'error');
        } else if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'copy_hangxuat');
            var file_data = $('#tab_hangxuat_content input[name=file_booking]').prop('files')[0];
            form_data.append('so_booking', so_booking);
            form_data.append('phan_loai', phan_loai);
            form_data.append('file', file_data);
            form_data.append('hang_tau', hang_tau);
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_hangtau', ten_hangtau);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_cang', ten_cang);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ket_hop', ket_hop);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form .list_tab').hide();
                            $('#tab_hangxuat_content').html(info.html);
                            if (info.total > 0) {
                                $('.box_gan').show();
                                $('.table_hang').html(info.list_hang_goiy);
                            } else {
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click', 'button[name=edit_container]', function () {
        so_hieu = $('.box_pop_add input[name=so_hieu]').val();
        ngay = $('.box_pop_add input[name=ngay]').val();
        thoi_gian = $('.box_pop_add input[name=thoi_gian]').val();
        id = $('.box_pop_add input[name=id]').val();
        if (ngay.length < 2) {
            $('.box_pop_add input[name=ngay]').focus();
            noti('Vui lòng nhập ngày trả hàng', 0, 2000);
        } else if (thoi_gian.length < 3) {
            $('.box_pop_add input[name=thoi_gian]').focus();
            noti('Vui lòng nhập thời gian trả hàng', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "edit_container",
                    so_hieu: so_hieu,
                    ngay: ngay,
                    thoi_gian: thoi_gian,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
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
    //////////////////////////////
    $('body').on('click', 'button[name=add_hang_noidia]', function () {
        var loai_container = $('#tab_noidia_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_noidia_content input[name=diachi_donghang]').val();
        var tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang_id]').val();
        var huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang]').val();
        var xa_donghang = $('#tab_noidia_content select[name=xa_donghang]').val();
        var diachi_trahang = $('#tab_noidia_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_noidia_content input[name=tinh_id]').val();
        var huyen = $('#tab_noidia_content select[name=huyen]').val();
        var xa = $('#tab_noidia_content select[name=xa]').val();
        var mat_hang = $('#tab_noidia_content input[name=mat_hang]:checked').val();
        var han_tra_rong = $('#tab_hangnhap_content input[name=han_tra_rong]').val();
        var mat_hang_khac = $('#tab_noidia_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_noidia_content input[name=so_luong]').val();
        var trong_luong = $('#tab_noidia_content input[name=trong_luong]').val();
        var gia = $('#tab_noidia_content input[name=gia]').val();
        var ghi_chu = $('#tab_noidia_content textarea[name=ghi_chu]').val();
        var ten_loai_container = $('#tab_noidia_content select[name=loai_container] option:selected').text();
        var ten_tinh = $('#tab_noidia_content input[name=tinh]').val();
        var ten_huyen = $('#tab_noidia_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_noidia_content select[name=xa] option:selected').text();
        var ten_tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang]').val();
        var ten_huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang] option:selected').text();
        var ten_xa_donghang = $('#tab_noidia_content select[name=xa_donghang] option:selected').text();
        var list_container = '';
        if ($('#tab_noidia_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_noidia_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (tinh_donghang == '') {
            show_thongbao('Vui lòng chọn tỉnh đóng hàng', 'error');
        } else if (huyen_donghang == '') {
            show_thongbao('Vui lòng chọn huyện đóng hàng', 'error');
        } else if (xa_donghang == '') {
            show_thongbao('Vui lòng chọn xã đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh trả hàng', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện trả hàng', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã trả hàng', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'add_hang_noidia');
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('tinh_donghang', tinh_donghang);
            form_data.append('huyen_donghang', huyen_donghang);
            form_data.append('xa_donghang', xa_donghang);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ten_tinh_donghang', ten_tinh_donghang);
            form_data.append('ten_huyen_donghang', ten_huyen_donghang);
            form_data.append('ten_xa_donghang', ten_xa_donghang);
            form_data.append('han_tra_rong', han_tra_rong);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form .list_tab').hide();
                            $('#tab_noidia_content').html(info.html);
                            if (info.total > 0) {
                                $('.box_gan').show();
                                $('.table_hang').html(info.list_hang_goiy);
                            } else {
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=edit_hang_noidia]', function () {
        var loai_container = $('#tab_noidia_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_noidia_content input[name=diachi_donghang]').val();
        var tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang_id]').val();
        var huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang]').val();
        var xa_donghang = $('#tab_noidia_content select[name=xa_donghang]').val();
        var diachi_trahang = $('#tab_noidia_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_noidia_content input[name=tinh_id]').val();
        var huyen = $('#tab_noidia_content select[name=huyen]').val();
        var xa = $('#tab_noidia_content select[name=xa]').val();
        var mat_hang = $('#tab_noidia_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_noidia_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_noidia_content input[name=so_luong]').val();
        var trong_luong = $('#tab_noidia_content input[name=trong_luong]').val();
        var gia = $('#tab_noidia_content input[name=gia]').val();
        var ghi_chu = $('#tab_noidia_content textarea[name=ghi_chu]').val();
        var ten_loai_container = $('#tab_noidia_content select[name=loai_container] option:selected').text();
        var ten_tinh = $('#tab_noidia_content input[name=tinh]').val();
        var ten_huyen = $('#tab_noidia_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_noidia_content select[name=xa] option:selected').text();
        var ten_tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang]').val();
        var ten_huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang] option:selected').text();
        var ten_xa_donghang = $('#tab_noidia_content select[name=xa_donghang] option:selected').text();
        var id = $('#tab_noidia_content input[name=id]').val();
        var list_container = '';
        if ($('#tab_noidia_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_noidia_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                id_container = $(this).attr('id_container');
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (tinh_donghang == '') {
            show_thongbao('Vui lòng chọn tỉnh đóng hàng', 'error');
        } else if (huyen_donghang == '') {
            show_thongbao('Vui lòng chọn huyện đóng hàng', 'error');
        } else if (xa_donghang == '') {
            show_thongbao('Vui lòng chọn xã đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh trả hàng', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện trả hàng', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã trả hàng', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'edit_hang_noidia');
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('tinh_donghang', tinh_donghang);
            form_data.append('huyen_donghang', huyen_donghang);
            form_data.append('xa_donghang', xa_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ten_tinh_donghang', ten_tinh_donghang);
            form_data.append('ten_huyen_donghang', ten_huyen_donghang);
            form_data.append('ten_xa_donghang', ten_xa_donghang);
            form_data.append('id', id);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href = '/members/list-booking';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    //////////////////////////////
    $('body').on('click', 'button[name=copy_hang_noidia]', function () {
        var loai_container = $('#tab_noidia_content select[name=loai_container]').val();
        var diachi_donghang = $('#tab_noidia_content input[name=diachi_donghang]').val();
        var tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang_id]').val();
        var huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang]').val();
        var xa_donghang = $('#tab_noidia_content select[name=xa_donghang]').val();
        var diachi_trahang = $('#tab_noidia_content input[name=diachi_trahang]').val();
        var tinh = $('#tab_noidia_content input[name=tinh_id]').val();
        var huyen = $('#tab_noidia_content select[name=huyen]').val();
        var xa = $('#tab_noidia_content select[name=xa]').val();
        var mat_hang = $('#tab_noidia_content input[name=mat_hang]:checked').val();
        var mat_hang_khac = $('#tab_noidia_content input[name=mat_hang_khac]').val();
        var so_luong = $('#tab_noidia_content input[name=so_luong]').val();
        var trong_luong = $('#tab_noidia_content input[name=trong_luong]').val();
        var gia = $('#tab_noidia_content input[name=gia]').val();
        var ghi_chu = $('#tab_noidia_content textarea[name=ghi_chu]').val();
        var ten_loai_container = $('#tab_noidia_content select[name=loai_container] option:selected').text();
        var ten_tinh = $('#tab_noidia_content input[name=tinh]').val();
        var ten_huyen = $('#tab_noidia_content select[name=huyen] option:selected').text();
        var ten_xa = $('#tab_noidia_content select[name=xa] option:selected').text();
        var ten_tinh_donghang = $('#tab_noidia_content input[name=tinh_donghang]').val();
        var ten_huyen_donghang = $('#tab_noidia_content select[name=huyen_donghang] option:selected').text();
        var ten_xa_donghang = $('#tab_noidia_content select[name=xa_donghang] option:selected').text();
        var list_container = '';
        if ($('#tab_noidia_content .list_container .li_container').length > 0) {
            s = 0;
            $('#tab_noidia_content .list_container .li_container').each(function () {
                ngay_trahang = $(this).find('input[name^=ngay_trahang]').val();
                thoi_gian = $(this).find('input[name^=thoi_gian]').val();
                id_container = $(this).attr('id_container');
                if (ngay_trahang.length > 4) {
                    s++;
                    if (s == 1) {
                        list_container += '{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    } else {
                        list_container += ',{"id":"' + id_container + '","ngay_trahang":"' + ngay_trahang + '","thoi_gian":"' + thoi_gian + '"}';
                    }
                }
            });
        }
        if (loai_container == '') {
            show_thongbao('Vui lòng chọn loại container', 'error');
        } else if (diachi_donghang == '') {
            show_thongbao('Vui lòng nhập chỉ đóng hàng', 'error');
        } else if (tinh_donghang == '') {
            show_thongbao('Vui lòng chọn tỉnh đóng hàng', 'error');
        } else if (huyen_donghang == '') {
            show_thongbao('Vui lòng chọn huyện đóng hàng', 'error');
        } else if (xa_donghang == '') {
            show_thongbao('Vui lòng chọn xã đóng hàng', 'error');
        } else if (diachi_trahang == '') {
            show_thongbao('Vui lòng chọn địa chỉ trả hàng', 'error');
        } else if (tinh == '') {
            show_thongbao('Vui lòng chọn tỉnh trả hàng', 'error');
        } else if (huyen == '') {
            show_thongbao('Vui lòng chọn huyện trả hàng', 'error');
        } else if (xa == '') {
            show_thongbao('Vui lòng chọn xã trả hàng', 'error');
        } else if (mat_hang == '') {
            show_thongbao('Vui lòng chọn mặt hàng', 'error');
        } else if (mat_hang == 'khac' && mat_hang_khac == '') {
            show_thongbao('Vui lòng nhập mặt hàng khác', 'error');
        } else if (so_luong == '') {
            show_thongbao('Vui lòng nhập số lượng', 'error');
        } else if (trong_luong == '') {
            show_thongbao('Vui lòng nhập trọng lượng', 'error');
        } else if (gia == '') {
            show_thongbao('Vui lòng nhập chi phí vận chuyển', 'error');
        } else if (list_container == '') {
            show_thongbao('Vui lòng nhập thông tin container', 'error');
        } else {
            var list_container = '[' + list_container + ']';
            var form_data = new FormData();
            form_data.append('action', 'copy_hang_noidia');
            form_data.append('loai_container', loai_container);
            form_data.append('diachi_donghang', diachi_donghang);
            form_data.append('tinh_donghang', tinh_donghang);
            form_data.append('huyen_donghang', huyen_donghang);
            form_data.append('xa_donghang', xa_donghang);
            form_data.append('diachi_trahang', diachi_trahang);
            form_data.append('tinh', tinh);
            form_data.append('huyen', huyen);
            form_data.append('xa', xa);
            form_data.append('mat_hang', mat_hang);
            form_data.append('mat_hang_khac', mat_hang_khac);
            form_data.append('so_luong', so_luong);
            form_data.append('trong_luong', trong_luong);
            form_data.append('gia', gia);
            form_data.append('list_container', list_container);
            form_data.append('ghi_chu', ghi_chu);
            form_data.append('ten_loai_container', ten_loai_container);
            form_data.append('ten_tinh', ten_tinh);
            form_data.append('ten_huyen', ten_huyen);
            form_data.append('ten_xa', ten_xa);
            form_data.append('ten_tinh_donghang', ten_tinh_donghang);
            form_data.append('ten_huyen_donghang', ten_huyen_donghang);
            form_data.append('ten_xa_donghang', ten_xa_donghang);
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            window.location.href = '/members/list-booking';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click', 'button[name=add_rate_booking]', function () {
        rate = $('.box_pop_add .rating .fa-star').length;
        note = $('.box_pop_add textarea[name=note]').val();
        id = $('.box_pop_add input[name=id]').val();
        if (rate == '') {
            noti('Vui lòng chọn điểm đánh giá', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "add_rate_booking",
                    rate: rate,
                    note: note,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            var dulieu = {
                                'hd': 'rate_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.href = '/members/list-danhgia';
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click', 'button[name=edit_rate_booking]', function () {
        rate = $('.box_pop_add .rating .fa-star').length;
        note = $('.box_pop_add textarea[name=note]').val();
        id = $('.box_pop_add input[name=id]').val();
        if (rate == '') {
            noti('Vui lòng chọn điểm đánh giá', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "edit_rate_booking",
                    rate: rate,
                    note: note,
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            var dulieu = {
                                'hd': 'rate_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.timkiem_dashboard button[name=timkiem_booking]', function () {
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (loai_hinh == '') {
            noti('Vui lòng chọn loại hình', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking",
                    loai_hinh: loai_hinh,
                    hang_tau: hang_tau,
                    hang_tau_id: hang_tau_id,
                    loai_container: loai_container,
                    dia_diem: dia_diem,
                    dia_diem_id: dia_diem_id,
                    from: from,
                    to: to
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            if (loai_hinh == 'hangnhap') {
                                $('.box_loai_hinh #loai_hinh_nhap').click();
                                $('#container_hangxuat').hide();
                                $('#container_noidia').hide();
                                $('#container_hangnhap').show();
                                $('#container_hangnhap .table_hang').html(info.list);
                            } else if (loai_hinh == 'hang_noidia') {
                                $('.box_loai_hinh #loai_hinh_noidia').click();
                                $('#container_hangxuat').hide();
                                $('#container_hangnhap').hide();
                                $('#container_noidia').show();
                                $('#container_noidia .table_hang').html(info.list);
                            } else {
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
    /////////////////////////////
    $('body').on('click', '.timkiem_user button[name=timkiem_booking]', function () {
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau]').val();
        hang_tau_id = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if (loai_hinh == '') {
            noti('Vui lòng chọn loại hình', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "timkiem_booking_user",
                    loai_hinh: loai_hinh,
                    hang_tau: hang_tau,
                    hang_tau_id: hang_tau_id,
                    loai_container: loai_container,
                    dia_diem: dia_diem,
                    dia_diem_id: dia_diem_id,
                    from: from,
                    to: to
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_pop_add').hide();
                            $('.box_pop_add').html('');
                            if (loai_hinh == 'hangnhap') {
                                $('.box_loai_hinh #loai_hinh_nhap').click();
                                $('#container_hangxuat').hide();
                                $('#container_noidia').hide();
                                $('#container_hangnhap').show();
                                $('#container_hangnhap .table_hang').html(info.list);
                            } else if (loai_hinh == 'hang_noidia') {
                                $('.box_loai_hinh #loai_hinh_noidia').click();
                                $('#container_hangxuat').hide();
                                $('#container_hangnhap').hide();
                                $('#container_noidia').show();
                                $('#container_noidia .table_hang').html(info.list);
                            } else {
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
    //////////////////////////////
    $('#dinh_kem').on('change', function () {
        var phien = $('#submit_yeucau').attr('phien');
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        var form_data = new FormData();
        form_data.append('action', 'upload_dinhkem');
        $.each($("input[name=file]")[0].files, function (i, file) {
            form_data.append('file[]', file);
        });
        form_data.append('phien', phien);
        form_data.append('sms_id', sms_id);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu = {
                            "list_out": info.list_out,
                            'list': info.list,
                            'phien': phien,
                            'loai': 'admin',
                            'user_out': info.user_out,
                            'thanh_vien': info.thanh_vien
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi', info_chat);
                    }
                }, 3000);
            }

        });
    });
    ///////////////////
    setTimeout(function () {
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "load_tk_notification"
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.total_notification').html(info.total);
                $('.total_booking_wait').html(info.total_booking_wait);
                $('.total_booking_confirm').html(info.total_booking_confirm);
                $('.total_booking_false').html(info.total_booking_false);
                $('.total_dat_booking_wait').html(info.total_dat_booking_wait);
                $('.total_dat_booking_confirm').html(info.total_dat_booking_confirm);
                $('.total_dat_booking_false').html(info.total_dat_booking_false);
            }

        });

    }, 3000);
    ///////////////////////////
    $('body').on('click', '#xacnhan_kichhoat', function () {
        nam = $('.box_sotien select[name=nam]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'xacnhan_kichhoat',
                nam: nam
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    if (info.ok == 0) {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.chuyenhuong == 1) {
                            window.location.href = '/members/add-naptien';
                        }
                    } else {
                        window.location.href = '/members/list-chitieu';
                    }
                }, 3000);
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '.hide_pop_thirth', function () {
        $('.pop_thirth').html('');
        $('.pop_thirth').hide();
        if ($('.box_pop_add .pop_second').length < 1) {
            $('.box_pop_add').html('');
            $('.box_pop_add').hide();
        } else {

        }
    });
    ////////////////////////////
    $('body').on('click', '.pop_second .title .material-icons', function () {
        $('.pop_second').hide();
        $('.pop_second').html('');
        if ($('.box_pop_add_content').length < 1) {
            $('.box_pop_add').hide();
            $('.box_pop_add').html('');
        }
    });
    ///////////////////
    $('.box_select_nguoinhan .box_title .fa').on('click', function () {
        $('.box_select_nguoinhan').hide();
        $('.box_select_nguoinhan .box_list').html('');
        $('.box_select_nguoinhan .box_list').attr('page', 1);
        $('.box_select_nguoinhan input[name=key_member]').val('');
    });
    $('.box_select_nguoinhan').on('click', '.action button', function () {
        var button = $(this);
        user_id = $(this).attr('user');
        username = $(this).attr('username');
        $('.list_nguoinhan').append('<div class="li_member ' + username + '" user="' + user_id + '">' + username + ' <i class="fa fa-close"></i>');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.list_nguoinhan .' + username).remove();
        } else {
            $(this).addClass('active');
        }
    });
    /////////////////////////////
    $('select[name=apdung]').on('change', function () {
        kieu = $(this).val();
        if (kieu == 'all') {
            $('#box_sanpham').hide();
        } else {
            $('#box_sanpham').show();
        }

    });
    /////////////////////////////
    $('.box_right_content').on('click', '.del_server', function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.box_right_content').on('click', '.add_server', function () {
        $('.block_bottom').before('<div class="col_100 block_server"><div class="form_group"><label for="">Tên server</label><input type="text" class="form_control" name="server" value="" placeholder="Nhập tên server..."></div><div class="form_group"><label for="">Link nguồn</label><input type="text" class="form_control" name="nguon" value="" placeholder="Nhập nguồn dữ liệu..."></div><div style="clear: both;"></div><div class="form_group"><label for="">Nội dung</label><textarea name="noidung" class="form_control" placeholder="Nhập link ảnh, mỗi ảnh một dòng" style="width: 100%;height: 150px;"></textarea></div><button class="button_select_photo">Chọn ảnh</button><button class="del_server"><i class="fa fa-trash-o"></i> Xóa server</button><div style="clear: both;"></div></div>');
    });
    /////////////////////////////
    $('.cover').click(function () {
        $('#cover').click();
    });
    /////////////////////////////
    $('.mh').click(function () {
        $('#minh_hoa').click();
    });
    /////////////////////////////
    $('#chon_anh').click(function () {
        $('#minh_hoa').click();
    });
    $("#minh_hoa").change(function () {
        readURL(this, 'preview-minhhoa');
    });
    $("#cover").change(function () {
        readURL(this, 'preview-cover');
    });
    /////////////////////////////
    $('.mh_socdo').click(function () {
        $('#minh_hoa_socdo').click();
    });
    $("#minh_hoa_socdo").change(function () {
        readURL(this, 'preview-minhhoa-socdo');
    });
    /////////////////////////////
    $('.mh_popup').click(function () {
        $('#popup').click();
    });
    $("#popup").change(function () {
        readURL(this, 'preview-popup');
    });
    /////////////////////////////
    $('#box_pop_confirm .button_cancel').on('click', function () {
        $('#title_confirm').html('');
        $('#button_thuchien').attr('action', '');
        $('#button_thuchien').attr('post_id', '');
        $('#button_thuchien').attr('loai', '');
        $('#box_pop_confirm').hide();
    });
    /////////////////////////////
    $('body').on('click', 'button[name=xacnhan_booking]', function () {
        id = $(this).attr('id');
        phi_booking = $('input[name=phi_booking_setting]').val();
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn sẽ bị trừ <b>' + phi_booking + ' đ phí booking</b> khi bấm thực hiện!<br>Bạn có chắc chắn thực hiện hành động này?');
        $('#button_thuchien').attr('action', 'xacnhan_booking');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', 'button[name=hoanthanh_booking]', function () {
        id = $(this).attr('id');
        phi_booking = $('input[name=phi_booking_setting]').val();
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang xác nhận <b>booking đã hoàn thành</b>!<br>Bạn có chắc chắn muốn thực hiện?');
        $('#button_thuchien').attr('action', 'hoanthanh_booking');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', 'button[name=tuchoi_booking]', function () {
        id = $(this).attr('id');
        phi_booking = $('input[name=phi_booking_setting]').val();
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang muốn <b>từ chối</b> booking này!<br>Bạn có chắc chắn muốn thực hiện?');
        $('#button_thuchien').attr('action', 'tuchoi_booking');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', 'button[name=huy_booking]', function () {
        id = $(this).attr('id');
        phi_booking = $('input[name=phi_booking_setting]').val();
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang muốn <b>hủy</b> đặt booking này!<br>Bạn có chắc chắn muốn thực hiện?');
        $('#button_thuchien').attr('action', 'huy_booking');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', 'button[name=huy_naptien]', function () {
        id = $(this).attr('id');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang muốn <b>hủy giao dịch nạp tiền</b>!<br>Bạn có chắc chắn muốn thực hiện?');
        $('#button_thuchien').attr('action', 'huy_naptien');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', '.del_list_booking', function () {
        id = $(this).attr('id');
        $('#box_pop_confirm').show();
        $('#box_pop_confirm .text_note').html('Bạn đang muốn <b>xóa booking này</b>!<br>Lưu ý: Khi bạn xóa dữ liệu sẽ không thể khôi phục!<br>Bạn có chắc chắn muốn thực hiện?');
        $('#button_thuchien').attr('action', 'del_list_booking');
        $('#button_thuchien').attr('post_id', id);
    });
    /////////////////////////////
    $('body').on('click', '#box_pop_confirm #button_thuchien', function () {
        action = $(this).attr('action');
        id = $(this).attr('post_id');
        loai = $(this).attr('loai');
        if (action == 'xacnhan_booking') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "xacnhan_booking",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.tr_' + id).hide();
                            var dulieu = {
                                'hd': 'xacnhan_booking',
                                'user_id': info.user_id,
                                'id_booking': info.id_booking
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            $('.box_dat_hoanthanh').show();
                            $('.box_dat_hoanthanh .text_success').html('Xác nhận booking thành công');
                            $('.box_dat_hoanthanh .table_success').html(info.box);
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'hoanthanh_booking') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "hoanthanh_booking",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $.ajax({
                                url: "/members/process.php",
                                type: "post",
                                data: {
                                    action: "show_add",
                                    loai: 'rate_booking',
                                    id: id
                                },
                                success: function (kq2) {
                                    var info_2 = JSON.parse(kq2);
                                    if (info_2.ok == 1) {
                                        $('.load_process_2').hide();
                                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                                        $('.load_overlay').hide();
                                        $('.box_pop_add').html(info_2.html);
                                        $('.box_pop_add').show();
                                    } else {
                                    }
                                }

                            });
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.tr_' + id).hide();
                            var dulieu = {
                                'hd': 'hoanthanh_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'tuchoi_booking') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "tuchoi_booking",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.tr_' + id).hide();
                            var dulieu = {
                                'hd': 'tuchoi_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'huy_booking') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "huy_booking",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.tr_' + id).hide();
                            var dulieu = {
                                'hd': 'huy_booking',
                                'user_id': info.user_id
                            }
                            var info_chat = JSON.stringify(dulieu);
                            socket.emit('user_send_hoatdong', info_chat);
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'huy_naptien') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "huy_naptien",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'del_list_booking') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "del_list_booking",
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            window.location.reload();
                        } else {
                        }
                    }, 2000);
                }

            });
        } else if (action == 'del_container') {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "del",
                    loai: 'container',
                    id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('#title_confirm').html('');
                            $('#button_thuchien').attr('action', '');
                            $('#button_thuchien').attr('post_id', '');
                            $('#button_thuchien').attr('loai', '');
                            $('#box_pop_confirm').hide();
                            $('.li_container[id_container=' + id + ']').remove();
                            so_luong = $('.li_tab_content .li_container').length;
                            $('.li_tab_content input[name=so_luong]').val(so_luong);
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    /////////////////////////////
    $('.box_profile').on('click', '.button_select_photo', function () {
        $('#photo-add').click();
    });
    $('.button_add_info').on('click', function () {
        $('.list_info').append('<div class="li_info"><div class="info_name"><input type="text" name="info_name[]" placeholder="Nhập tên thông tin"></div><div class="info_value"><input type="text" name="info_value[]" placeholder="Nhập giá trị thông tin"></div></div>');
    });
    $('#photo-add').on('change', function () {
        var form_data = new FormData();
        form_data.append('action', 'upload_photo');
        $.each($("input[name=file]")[0].files, function (i, file) {
            form_data.append('file[]', file);
        });
        //form_data.append('file', file_data);
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
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
    $('.tieude_seo').on('paste', function (event) {
        if ($(this).hasClass('uncheck_blank')) { } else {
            setTimeout(function () {
                check_blank();
            }, 1000);
        }
    });
    $('input[name=link_video]').on('paste', function (event) {
        setTimeout(function () {
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
    $('input[name=slug]').on('keyup', function () {
        slug = $(this).val();
        id = $('input[name=id]').val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "check_slug",
                slug: slug,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.check_slug').html(info.thongbao);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.drop_down button', function () {
        //$('.drop_down').find('.drop_menu').slideUp('300');
        if ($(this).parent().find('.drop_menu').is(':visible')) {
            $(this).parent().find('.drop_menu').slideUp('300');
        } else {
            $(this).parent().find('.drop_menu').slideDown('300');
        }
    });
    $(document).click(function (e) {
        var dr = $(".drop_menu");
        var drd = $('.drop_down');
        // Nếu click bên ngoài .drop_menu
        if (!dr.is(e.target) && dr.has(e.target).length === 0 && !drd.is(e.target) && drd.has(e.target).length === 0) {
            dr.slideUp('300');
        }
    });
    $('body').on('click', '#main_category .li_input input', function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_category',
                    cat_id: id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {

                        if ($('#sub_category .li_input').length > 0) {
                            $('#sub_category').append('<hr class="hr_' + id + '">' + info.list);
                        } else {
                            $('#sub_category').append(info.list);
                        }
                    } else { }
                }
            });
        } else {
            id = $(this).val();
            $('.li_input_' + id).remove();
            $('.hr_' + id).remove();
            $('.hr_main_' + id).remove();
            $('.li_input_main_' + id).remove();
        }
    });
    $('body').on('click', '#sub_category .li_input input', function () {
        if ($(this).is(":checked")) {
            id = $(this).val();
            main = $(this).attr('main_id');
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                data: {
                    action: 'load_sub_sub_category',
                    cat_id: id,
                    main: main
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    if (info.ok == 1) {
                        if ($('#sub_sub_category .li_input').length > 0) {
                            $('#sub_sub_category').append('<hr class="hr_' + id + ' hr_main_' + main + '">' + info.list);
                        } else {
                            $('#sub_sub_category').append(info.list);
                        }
                    } else { }
                }
            });
        } else {
            id = $(this).val();
            $('.hr_' + id).remove();
            $('.li_input_' + id).remove();
        }
    });
    $('#timkiem_thuonghieu').on('change', function () {
        thuong_hieu = $(this).val();
        $('.pagination').hide();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'timkiem_sanpham_thuonghieu',
                thuong_hieu: thuong_hieu
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.list_baiviet').html(info.list);
                        $('.load_sanpham').hide();
                    } else {

                    }
                }, 1000);
            }
        });
    });
    $('input[name=key]').keypress(function (e) {
        if (e.which == 13) {
            key = $('input[name=key]').val();
            if ($('button[name=timkiem_sanpham]').length > 0) {
                action = 'timkiem_sanpham';
            } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
                action = 'timkiem_sanpham_trend';
            } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
                action = 'timkiem_sanpham_tuan';
            } else if ($('button[name=timkiem_thanhvien]').length > 0) {
                action = 'timkiem_thanhvien';
            } else if ($('button[name=timkiem_thanhvien_nhom]').length > 0) {
                id = $('button[name=timkiem_thanhvien_nhom]').attr('nhom');
                action = 'timkiem_thanhvien_nhom';
            } else if ($('button[name=timkiem_thanhvien_drop]').length > 0) {
                action = 'timkiem_thanhvien_drop';
            } else if ($('button[name=timkiem_bom]').length > 0) {
                action = 'timkiem_bom';
            } else if ($('button[name=timkiem_donhang]').length > 0) {
                action = 'timkiem_donhang';
            } else if ($('button[name=timkiem_donhang_ctv]').length > 0) {
                var action = 'timkiem_donhang_ctv';
            }
            if (key.length < 1) {
                $('input[name=key]').focus();
            } else {
                if (action == 'timkiem_thanhvien_nhom') {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/members/process.php',
                        type: 'post',
                        data: {
                            action: action,
                            key: key,
                            id: id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function () {
                                $('.load_note').html(info.thongbao);
                            }, 500);
                            setTimeout(function () {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if (info.ok == 1) {
                                    $('.list_baiviet').html(info.list);
                                    $('.pagination').hide();
                                } else {

                                }
                            }, 1000);
                        }
                    });
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $.ajax({
                        url: '/members/process.php',
                        type: 'post',
                        data: {
                            action: action,
                            key: key
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            setTimeout(function () {
                                $('.load_note').html(info.thongbao);
                            }, 500);
                            setTimeout(function () {
                                $('.load_process').hide();
                                $('.load_note').html('Hệ thống đang xử lý');
                                $('.load_overlay').hide();
                                if (info.ok == 1) {
                                    $('.list_baiviet').html(info.list);
                                    $('.pagination').hide();
                                    if (action == 'timkiem_sanpham_tuan') {
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
                                                    status = $this.attr('status');
                                                    if (status == 0) {
                                                        $this.find('.text_time').html('Kết thúc sau:');
                                                        con = $this.attr('thoigian') * 1000;
                                                        $this.countdown(con + currentDate.valueOf(), call_flash);
                                                        $this.attr('status', 1);
                                                    } else {
                                                        $this.fadeTo('slow', .5);
                                                        $this.html('Đã kết thúc');
                                                        finished = true;
                                                    }
                                                    break;
                                            }
                                        }
                                        $('.count_down').each(function () {
                                            con = $(this).attr('time') * 1000;
                                            $(this).countdown(con + currentDate.valueOf(), call_flash);
                                        });
                                    }
                                } else {

                                }
                            }, 1000);
                        }
                    });
                }
            }
        }
    });
    $('.button_timkiem').on('click', function () {
        key = $('input[name=key]').val();
        if ($('button[name=timkiem_sanpham]').length > 0) {
            var action = 'timkiem_sanpham';
        } else if ($('button[name=timkiem_sanpham_trend]').length > 0) {
            var action = 'timkiem_sanpham_trend';
        } else if ($('button[name=timkiem_sanpham_tuan]').length > 0) {
            var action = 'timkiem_sanpham_tuan';
        } else if ($('button[name=timkiem_thanhvien]').length > 0) {
            var action = 'timkiem_thanhvien';
        } else if ($('button[name=timkiem_thanhvien_nhom]').length > 0) {
            id = $('button[name=timkiem_thanhvien_nhom]').attr('nhom');
            var action = 'timkiem_thanhvien_nhom';
        } else if ($('button[name=timkiem_thanhvien_drop]').length > 0) {
            var action = 'timkiem_thanhvien_drop';
        } else if ($('button[name=timkiem_bom]').length > 0) {
            var action = 'timkiem_bom';
        } else if ($('button[name=timkiem_donhang]').length > 0) {
            var action = 'timkiem_donhang';
        } else if ($('button[name=timkiem_donhang_ctv]').length > 0) {
            var action = 'timkiem_donhang_ctv';
        }
        if (key.length < 1) {
            $('input[name=key]').focus();
        } else {
            if (action == 'timkiem_thanhvien_nhom') {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/members/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key,
                        id: id
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $('.list_baiviet').html(info.list);
                                $('.pagination').hide();
                            } else {

                            }
                        }, 1000);
                    }
                });
            } else {
                $('.load_overlay').show();
                $('.load_process').fadeIn();
                $.ajax({
                    url: '/members/process.php',
                    type: 'post',
                    data: {
                        action: action,
                        key: key
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 500);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                $('.list_baiviet').html(info.list);
                                $('.pagination').hide();
                                if (action == 'timkiem_sanpham_tuan') {
                                    console.log('ok');
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
                                                status = $this.attr('status');
                                                if (status == 0) {
                                                    $this.find('.text_time').html('Kết thúc sau:');
                                                    con = $this.attr('thoigian') * 1000;
                                                    $this.countdown(con + currentDate.valueOf(), call_flash);
                                                    $this.attr('status', 1);
                                                } else {
                                                    $this.fadeTo('slow', .5);
                                                    $this.html('Đã kết thúc');
                                                    finished = true;
                                                }
                                                break;
                                        }
                                    }
                                    $('.count_down').each(function () {
                                        con = $(this).attr('time') * 1000;
                                        $(this).countdown(con + currentDate.valueOf(), call_flash);
                                    });
                                }
                            } else {

                            }
                        }, 1000);
                    }
                });
            }
        }
    });
    /////////////////////////////
    $('#ckOk').on('click', function () {
        if ($('#ckOk').is(":checked")) {
            $('#lbtSubmit').attr("disabled", false);
        } else {
            $('#lbtSubmit').attr("disabled", true);
        }
    });
    /////////////////////////////
    $('#txbQuery').keypress(function (e) {
        if (e.which == 13) {
            key = $('#txbQuery').val();
            type = $('input[name=search_type]:checked').val();
            link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
            window.location.href = link;
            return false; //<---- Add this line
        }
    });
    //////////////////
    $('#btnSearch').on('click', function () {
        key = $('#txbQuery').val();
        type = $('input[name=search_type]:checked').val();
        link = '/tim-kiem.html?type=' + type + '&q=' + encodeURI(key).replace(/%20/g, '+');
        window.location.href = link;
        return false; //<---- Add this line
    });
    /////////////////////////////
    $('.panel-lyrics .panel-heading').on('click', function () {
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
    $('.item-cat a').on('click', function () {
        $(this).parent().find('div').click();

    });
    /////////////////////////////
    $('.remember').on('click', function () {
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
    $('body').on('click', '.li_photo i', function () {
        var item = $(this);
        if (item.parent().find('video').length > 0) {
            anh = item.parent().find('video').attr('src');

        } else {
            anh = item.parent().find('img').attr('src');
        }
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "del_photo",
                anh: anh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                item.parent().parent().remove();
            }

        });
    });
    /////////////////////////////
    $('body').on('click', '.box_yeucau .box_search #show_add_hotro', function () {
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_box_pop_thirth',
                loai: 'add_yeucau_lienhe'
            },
            success: function (kq) {
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
    $('body').on('click', '.pop_add_lienhe button[name=gui_ykien]', function () {
        var noi_dung = $('.pop_add_lienhe textarea[name=noi_dung]').val();
        var quy_trinh = $('.pop_add_lienhe select[name=quy_trinh]').val();
        var user_out = $('.box_chat input[name=user_out]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'add_yeucau_traodoi',
                quy_trinh: quy_trinh,
                noi_dung: noi_dung,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 500);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('#list_yeucau .li_yeucau').removeClass('active');
                        $('#list_yeucau').prepend(info.list);
                        $('.box_yeucau_hotro #ten_khach').html(info.ho_ten);
                        $('.box_yeucau_hotro #submit_yeucau').attr('phien', info.phien_traodoi);
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', false);
                        $('.box_yeucau_hotro #list_chat').html('');
                        $('.box_yeucau_hotro .note_content .txt').html(noi_dung);
                        $('.box_pop_add').hide();
                        $('.box_pop_add').html('');
                        setTimeout(function () {
                            var top_dong = $('.bottom_chat').offset().top;
                            $('html,body').stop().animate({ scrollTop: top_dong - 150 }, 500, 'swing', function () {
                            });
                        }, 500);
                        var dulieu = {
                            'user_out': user_out,
                            'thanh_vien': info.thanh_vien,
                            'bo_phan': info.bo_phan
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_list_yeucau', info_chat);
                    } else {

                    }
                }, 2000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_yeucau_hotro .box_yeucau .list_yeucau .list .li_yeucau', function () {
        var phien = $(this).attr('phien');
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_khach_traodoi',
                phien: phien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_yeucau').html(info.list);
                    $('.box_yeucau_hotro #submit_yeucau').attr('phien', info.phien);
                    $('.box_yeucau_hotro #list_chat').html(info.list_chat);
                    $('.box_yeucau_hotro .note_content .txt').html(info.note);
                    $('input[name=load_chat]').val(info.load_chat);
                    scrollSmoothToBottom('list_chat');
                    if (info.active == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', false);
                    } else {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                    }
                } else {

                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_chat #submit_yeucau', function () {
        var phien = $(this).attr('phien');
        var noi_dung = $('.box_chat input[name=noidung_yeucau]').val();
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'add_sms_traodoi',
                phien: phien,
                noi_dung: noi_dung,
                sms_id: sms_id
            },
            success: function (kq) {
                $('.box_chat input[name=noidung_yeucau]').val('');
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu = {
                        "list_out": info.list_out,
                        'list': info.list,
                        'phien': phien,
                        'loai': 'thanh_vien',
                        'user_out': info.user_out,
                        'bo_phan': info.bo_phan,
                        'thanh_vien': user_out
                    }
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi', info_chat);
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý...');
                        $('.load_overlay').hide();
                    }, 2000);
                }
            }
        });

    });
    $('body').on('keypress', '.box_chat input[name=noidung_yeucau]', function (e) {
        if (e.which == 13) {
            var phien = $('.box_chat #submit_yeucau').attr('phien');
            var noi_dung = $('.box_chat input[name=noidung_yeucau]').val();
            var user_out = $('.box_chat input[name=user_out]').val();
            if ($('#list_chat .txt').length > 0) {
                sms_id = $('#list_chat .li_sms').last().attr('sms_id');
            } else {
                sms_id = 0;
            }
            $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
            $('.box_chat .text_status .loading_chat').show();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: 'add_sms_traodoi',
                    phien: phien,
                    noi_dung: noi_dung,
                    sms_id: sms_id
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('.box_chat .text_status .loading_chat').hide();
                    $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                    $('.box_chat input[name=noidung_yeucau]').val('');
                    if (info.ok == 1) {
                        $('#list_chat').append(info.list);
                        scrollSmoothToBottom('list_chat');
                        var dulieu = {
                            "list_out": info.list_out,
                            'list': info.list,
                            'phien': phien,
                            'loai': 'thanh_vien',
                            'bo_phan': info.bo_phan,
                            'user_out': info.user_out,
                            'thanh_vien': user_out
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_traodoi', info_chat);
                    } else {
                        $('.load_overlay').show();
                        $('.load_process').fadeIn();
                        $('.load_note').html(info.thongbao);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý...');
                            $('.load_overlay').hide();
                        }, 2000);
                    }
                }
            });
        } else {
        }
    });
    $('body').on('click', '.box_sticker .li_sticker img', function (e) {
        $('.box_sticker').hide();
        var phien = $('.box_chat #submit_yeucau').attr('phien');
        var src = $(this).attr('src');
        var user_out = $('.box_chat input[name=user_out]').val();
        if ($('#list_chat .txt').length > 0) {
            sms_id = $('#list_chat .li_sms').last().attr('sms_id');
        } else {
            sms_id = 0;
        }
        $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
        $('.box_chat .text_status .loading_chat').show();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'add_sticker_traodoi',
                phien: phien,
                src: src,
                sms_id: sms_id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_chat .text_status .loading_chat').hide();
                $('.box_chat .text_status .loading_chat').html('<i class="icofont-spinner spinx"></i> Đang gửi tin');
                $('.box_chat input[name=noidung_yeucau]').val('');
                if (info.ok == 1) {
                    $('#list_chat').append(info.list);
                    scrollSmoothToBottom('list_chat');
                    var dulieu = {
                        "list_out": info.list_out,
                        'list': info.list,
                        'phien': phien,
                        'loai': 'thanh_vien',
                        'user_out': info.user_out,
                        'thanh_vien': user_out,
                        'bo_phan': info.bo_phan
                    }
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_traodoi', info_chat);
                } else {
                    $('.load_overlay').show();
                    $('.load_process').fadeIn();
                    $('.load_note').html(info.thongbao);
                    setTimeout(function () {
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
    $('#list_chat').scroll(function () {
        var st = $(this).scrollTop();
        if (st > lastScrollTop) {

        } else {
            load = $('input[name=load_chat]').val();
            loaded = $('input[name=load_chat]').attr('loaded');
            sms_id = $('#list_chat .li_sms').first().attr('sms_id');
            var phien = $('.box_chat #submit_yeucau').attr('phien');
            if (st < 50 && loaded == 1 && load == 1) {
                $('#list_chat').prepend('<div class="li_load_chat"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
                $('input[name=load_chat]').attr('loaded', '0');
                setTimeout(function () {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: "load_chat_sms",
                            phien: phien,
                            sms_id: sms_id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('#list_chat .li_load_chat').remove();
                            $('input[name=load_chat]').val(info.load_chat);
                            $('input[name=load_chat]').attr('loaded', '1');
                            if (info.ok == 1) {
                                $('#list_chat').prepend(info.list_chat);
                                total_height = 0;
                                $('#list_chat .li_sms').each(function () {
                                    if ($(this).attr('sms_id') < sms_id) {
                                        total_height += $(this).outerHeight();
                                    }
                                });
                                $('#list_chat').animate({
                                    scrollTop: total_height - 50
                                }, 200);
                            } else {
                            }
                        }
                    });
                }, 3000);
            } else {

            }
        }
        lastScrollTop = st;

    });
    /////////////////////////////
    socket.on("server_send_traodoi", function (data) {
        user_out = $('.box_chat input[name=user_out]').val();
        thanhvien_chat = $('input[name=thanhvien_chat]').val();
        phien = $('#submit_yeucau').attr('phien');
        var info = JSON.parse(data);
        if (thanhvien_chat == info.user_out) {
        } else {
            if (thanhvien_chat == info.thanh_vien) {
                $('#play_chat').click();
            }
            if (phien == info.phien) {
                $('#list_chat').append(info.list_out);
                scrollSmoothToBottom('list_chat');
            }
        }
    });
    /////////////////////////////
    socket.on("server_send_list_yeucau", function (data) {
        phien = $('#submit_yeucau').attr('phien');
        user_out = $('.box_chat input[name=user_out]').val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: 'load_list_yeucau',
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#list_yeucau').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    socket.on("server_send_dong_yeucau", function (data) {
        phien = $('#submit_yeucau').attr('phien');
        user_out = $('.box_chat input[name=user_out]').val();
        var info = JSON.parse(data);
        if (user_out == info.user_out || user_out != info.thanh_vien) {
        } else {
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: 'load_list_yeucau',
                    phien: phien,
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    $('#list_yeucau').html(info.list);
                }
            });
        }
    });
    /////////////////////////////
    $('body').on('click', '.box_chat #dong_yeucau', function () {
        phien = $('.box_chat #submit_yeucau').attr('phien');
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'dong_yeucau',
                phien: phien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý...');
                    $('.load_overlay').hide();
                    if (info.ok == 1) {
                        $('.box_yeucau_hotro .box_chat .list_chat .input_chat input[name=noidung_yeucau]').prop('disabled', true);
                        var dulieu = {
                            'user_out': info.user_out,
                            'thanh_vien': info.thanh_vien,
                            'phien': info.phien,
                            'bo_phan': info.bo_phan
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_dong_yeucau', info_chat);
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=add_naptien]', function () {
        so_tien = $('.box_form input[name=so_tien]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "add_naptien",
                so_tien: so_tien
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('#tab_hangnhap_content').html(info.html);
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=edit_naptien]', function () {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "edit_naptien",
                status: status,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        window.location.href = '/members/list-naptien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('body').on('click', 'button#add_naptien_step2', function () {
        var id = $(this).attr('id_nap');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "add_naptien_step2",
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        $('#tab_hangnhap_content').html(info.html);
                        var dulieu = {
                            'hd': 'add_naptien',
                            'id': id
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=edit_ruttien]').on('click', function () {
        id = $('input[name=id]').val();
        status = $('select[name=status]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "edit_ruttien",
                status: status,
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    if (info.ok == 1) {
                        window.location.href = '/members/list-ruttien';
                    } else {

                    }
                }, 3000);
            }

        });
    });
    /////////////////////////////
    $('button[name=login]').on('click', function () {
        password = $('input[name=password]').val();
        username = $('input[name=username]').val();
        remember = $('.remember').attr('value');
        if (username.length < 4) {
            $('input[name=username]').focus();
        } else if (password.length < 6) {
            $('input[name=password]').focus();
        } else {
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "dangnhap",
                    username: username,
                    password: password,
                    remember: remember
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_note').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process').hide();
                        $('.load_note').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href = '/members/dashboard';
                        } else {

                        }
                    }, 3000);
                }

            });

        }

    });
    /////////////////////////////
    $('button[name=forgot_password]').on('click', function () {
        email = $('input[name=email]').val();
        $('.load_overlay').show();
        $('.load_process').fadeIn();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: "forgot_password",
                email: email
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_note').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process').hide();
                    $('.load_note').html('Hệ thống đang xử lý');
                    $('.load_overlay').hide();
                }, 3000);
                setTimeout(function () {
                    if (info.ok == 1) {
                        window.location.href = '/forgot-password?step=2';
                    } else {

                    }
                }, 3500);
            }

        });
    });
    /////////////////////////////
    $('button[name=button_profile]').on('click', function () {
        cong_ty = $('.box_form input[name=cong_ty]').val();
        maso_thue = $('.box_form input[name=maso_thue]').val();
        name = $('.box_form input[name=name]').val();
        mobile = $('.box_form input[name=mobile]').val();
        email = $('.box_form input[name=email]').val();
        if (cong_ty.length < 2) {
            $('.box_form input[name=cong_ty]').focus();
            noti('Vui lòng nhập tên công ty', 0, 2000);
        } else if (maso_thue.length < 2) {
            $('.box_form input[name=maso_thue]').focus();
            noti('Vui lòng nhập mã số thuế', 0, 2000);
        } else if (name.length < 2) {
            $('.box_form input[name=name]').focus();
            noti('Vui lòng nhập họ và tên', 0, 2000);
        } else if (mobile.length < 2) {
            $('.box_form input[name=mobile]').focus();
            noti('Vui lòng nhập số điện thoại', 0, 2000);
        } else if (email.length < 2) {
            $('.box_form input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            var file_data = $('#minh_hoa').prop('files')[0];
            var form_data = new FormData();
            form_data.append('action', 'edit_profile');
            form_data.append('file', file_data);
            form_data.append('cong_ty', cong_ty);
            form_data.append('maso_thue', maso_thue);
            form_data.append('name', name);
            form_data.append('mobile', mobile);
            form_data.append('email', email);
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
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
    $('.button_change_avatar').click(function () {
        $('#file').click();
    });
    /////////////////////////////
    $('.cover_now .button_change').click(function () {
        $('#file_cover').click();
    });
    /////////////////////////////
    $('button[name=add_share_sanpham]').on('click', function () {
        noidung = tinyMCE.get('edit_textarea').getContent();
        var list_photo = [];
        $('.list_photo img, .list_photo video').each(function () {
            list_photo.push($(this).attr('src'));
        });
        anh = list_photo.toString();
        sp_id = $('input[name=sp_id]').val();
        if (noidung.length < 10) {
            tinymce.execCommand('mceFocus', false, 'edit_textarea');
        } else {
            var form_data = new FormData();
            form_data.append('action', 'add_share_sanpham');
            form_data.append('anh', anh);
            form_data.append('noidung', noidung);
            form_data.append('sp_id', sp_id);
            $('.load_overlay').show();
            $('.load_process').fadeIn();
            $.ajax({
                url: '/members/process.php',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (kq) {
                    if (isJson(kq) == true) {
                        var info = JSON.parse(kq);
                        setTimeout(function () {
                            $('.load_note').html(info.thongbao);
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                            if (info.ok == 1) {
                                window.location.reload();
                            }
                        }, 3000);
                    } else {
                        setTimeout(function () {
                            $('.load_note').html('Gặp lỗi trong lúc đăng! Vui lòng thử lại');
                        }, 1000);
                        setTimeout(function () {
                            $('.load_process').hide();
                            $('.load_note').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 3000);
                    }
                }

            });

        }
    });

    /////////////////////////////
    $('button[name=button_password]').on('click', function () {
        old_pass = $('.box_form input[name=password_old]').val();
        new_pass = $('.box_form input[name=password]').val();
        confirm = $('.box_form input[name=confirm]').val();
        if (old_pass.length < 6) {
            $('.box_form input[name=password_old]').focus();
            noti('Vui lòng nhập mật khẩu hiện tại', 0, 2000);
        } else if (new_pass.length < 6) {
            $('.box_form input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu mới', 0, 2000);
        } else if (new_pass != confirm) {
            $('.box_form input[name=confirm]').focus();
            noti('Nhập lại mật khẩu mới không khớp', 0, 2000);
        } else {
            $('.load_overlay2').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "change_password",
                    old_pass: old_pass,
                    new_pass: new_pass,
                    confirm: confirm
                },
                success: function (kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function () {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function () {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay2').hide();
                        if (info.ok == 1) {
                            $('.box_form input[name=password_old]').val('');
                            $('.box_form input[name=password]').val('');
                            $('.box_form input[name=confirm]').val('');
                        }
                    }, 3000);
                }

            });
        }

    });
    /////////////////////////////
    $('input[name=goi_y]').on('keyup', function () {
        tieu_de = $(this).val();
        cat = $('select[name=category]').val();
        if (tieu_de.length < 2) { } else {
            $.ajax({
                url: "/members/process.php",
                type: "post",
                data: {
                    action: "goi_y",
                    cat: cat,
                    tieu_de: tieu_de
                },
                success: function (kq) {
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
    $('.khung_sanpham').on('click', 'ul li i', function () {
        $(this).parent().remove();
    });
    /////////////////////////////
    $('.khung_goi_y').on('click', 'ul li', function (e) {
        text = $(this).find('span').text();
        id = $(this).attr('value');
        $('.khung_sanpham ul').prepend('<li value="' + id + '"><i class="icon icofont-close-circled"></i><span>' + text + '</span></li>');
        e.stopPropagation();
    });
    /////////////////////////////
    $(document).click(function () {
        $('.khung_goi_y:visible').slideUp('300');
        //j('.main_list_menu:visible').hide();
    });
    /////////////////////////////


});

// upload file
$(document).ready(function () {
    // Mở modal khi nhấn nút
    $('#openModalButton').click(function () {
        $('#importModal').show();
    });

    // Đóng modal khi nhấn vào "X"
    $('.close').click(function () {
        $('#importModal').hide();
    });

    // Đóng modal khi nhấn ra ngoài modal
    $(window).click(function (e) {
        if ($(e.target).is('#importModal')) {
            $('#importModal').hide();
        }
    });

    // Xử lý sự kiện khi nhấn nút tải lên
    $('#uploadButton').click(function () {
        var file_data = $('#file_booking').prop('files')[0];

        if (!file_data) {
            alert("Vui lòng chọn file trước khi tải lên!");
            return;
        }

        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('action', 'import_booking');

        $.ajax({
            url: 'process.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                $('#status').html(response.message);

            },
            error: function () {
                alert("Đã xảy ra lỗi khi tải file!");
            }
        });
    });
});


$(document).ready(function () {
    /////////////////////////////
    $('body').on('change', '.form_select[name=phong_ban_nhan]', function () {
        phong_ban_nhan = $(this).val();
        console.log(phong_ban_nhan);
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_user_nhan',
                phong_ban_nhan: phong_ban_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.form_select[name=nguoi_nhan]').html(info.list);
            }
        });
    });
    
    /////////////////////////////
    $('body').on('change', '.form_select[name=nguoi_nhan]', function () {
        nguoi_nhan = $(this).val();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_user_giamsat',
                nguoi_nhan: nguoi_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.form_select[name=nguoi_giam_sat]').html(info.list);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=giaoviec_tructiep]', function (e) {
        e.preventDefault();

        var $form = $('#form_giaoviec_tructiep');
        var phong_ban_nhan = $form.find('select[name=phong_ban_nhan]').val();
        var nguoi_nhan = $form.find('select[name=nguoi_nhan]').val();
        var nguoi_giam_sat = $form.find('select[name=nguoi_giam_sat]').val();
        var ten_cong_viec = $form.find('input[name=ten_cong_viec]').val().trim();
        var mo_ta = $form.find('textarea[name=mo_ta]').val().trim();
        var thoi_han = $form.find('input[name=thoi_han]').val();
        var muc_do_uu_tien = $form.find('select[name=muc_do_uu_tien]').val();
        var thoi_gian_nhan_viec = $form.find('input[name=thoi_gian_nhan_viec]').val();

        var form_data = new FormData();
        form_data.append('action', 'giaoviec_tructiep');
        form_data.append('phong_ban_nhan', phong_ban_nhan || '');
        form_data.append('nguoi_nhan', nguoi_nhan || '');
        form_data.append('nguoi_giam_sat', nguoi_giam_sat || '');
        form_data.append('ten_cong_viec', ten_cong_viec);
        form_data.append('mo_ta', mo_ta);
        form_data.append('thoi_han', thoi_han || '');
        form_data.append('muc_do_uu_tien', muc_do_uu_tien);
        form_data.append('thoi_gian_nhan_viec', thoi_gian_nhan_viec);

        var fileInput = $form.find('input[name="tep_dinh_kem[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('tep_dinh_kem[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        var $form = $('#form_giaoviec_tructiep');

                        $form[0].reset();
                        $form.find('select').prop('selectedIndex', 0).trigger('change');
                        $form.find('input[type="file"]').val('');
                        $form.find('textarea').val('');
                        $form.find('input[name=ten_cong_viec]').focus();

                        $('.box_pop_add').hide();
                        $('.box_pop_add').html('');
                        var dulieu = {
                            'hd': 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giamsat: info.nguoi_giamsat,
                            nguoi_giao: info.nguoi_giao
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                    }
                }, 3000);
            }
        });
    });

    //////////////////////////
    $('body').on('click', 'button[name=search_list_congviec_quanly]', function (e) {
        var search_keyword = $('input[name=search_keyword]').val();
        var search_trang_thai = $('select[name=filter_trang_thai]').val();
        var search_ngay_bat_dau = $('input[name=filter_ngay_bat_dau]').val();
        var search_han_hoan_thanh = $('input[name=filter_han_hoan_thanh]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_list_congviec_quanly',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_bat_dau: search_ngay_bat_dau,
                search_han_hoan_thanh: search_han_hoan_thanh
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    $('#list_giaoviec').html(info.list);
                }, 1000);
                if (info.ok == 1) {
                    $('#list_giaoviec_giao').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=search_list_congviec_cua_toi]', function (e) {
        var search_keyword = $('input[name=search_keyword]').val();
        var search_trang_thai = $('select[name=filter_trang_thai]').val();
        var search_ngay_bat_dau = $('input[name=filter_ngay_bat_dau]').val();
        var search_han_hoan_thanh = $('input[name=filter_han_hoan_thanh]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_list_congviec_cua_toi',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_bat_dau: search_ngay_bat_dau,
                search_han_hoan_thanh: search_han_hoan_thanh
            },
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    $('#list_giaoviec_nhan').html(info.list);
                }, 1000);
                if (info.ok == 1) {
                    $('#list_giaoviec_nhan').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=search_list_congviec_giamsat]', function (e) {
        var search_keyword = $('input[name=search_keyword]').val();
        var search_trang_thai = $('select[name=filter_trang_thai]').val();
        var search_ngay_bat_dau = $('input[name=filter_ngay_bat_dau]').val();
        var search_han_hoan_thanh = $('input[name=filter_han_hoan_thanh]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_list_congviec_giamsat',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_bat_dau: search_ngay_bat_dau,
                search_han_hoan_thanh: search_han_hoan_thanh
            },
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    $('#list_giaoviec_giamsat').html(info.list);
                }, 1000);
                if (info.ok == 1) {
                    $('#list_giaoviec_giamsat').html(info.list);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=view_giaoviec]', function (e) {
        var id = $(this).data('id');
        // Lấy page_type từ URL hiện tại
        var current_url = window.location.href;
        var page_type = '';
        if (current_url.indexOf('list-congviec-quanly') > -1) {
            page_type = 'list-congviec-quanly';
        } else if (current_url.indexOf('list-congviec-cua-toi') > -1) {
            page_type = 'list-congviec-cua-toi';
        } else if (current_url.indexOf('list-congviec-giamsat') > -1) {
            page_type = 'list-congviec-giamsat';
        }
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_giaoviec_tructiep',
                id: id,
                page_type: page_type
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_add').html(info.html);
                $('.box_pop_add').show();
                // Khởi tạo countdown sau khi load HTML - sử dụng data từ response
                setTimeout(function() {
                    if (typeof DeadlineCountdown !== 'undefined' && info.deadline_timestamp && info.deadline_timestamp > 0) {
                        // Cập nhật data attributes nếu chưa có
                        $('.box_pop_add .deadline_countdown').attr('data-deadline', info.deadline_timestamp);
                        $('.box_pop_add .deadline_countdown').attr('data-id', info.id);
                        $('.box_pop_add .deadline_countdown').attr('data-type', info.type || 'giaoviec_tructiep');
                        // Khởi tạo countdown
                        $('.box_pop_add .deadline_countdown').each(function() {
                            DeadlineCountdown.init(this);
                        });
                    }
                }, 100);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_pop_view_giaoviec_close, button[name=close_box_pop_view_giaoviec_tructiep]', function (e) {
        $('.box_pop_add').hide();
    });

    ////////////////////////////
    $('body').on('click', 'button[name=box_pop_edit_giaoviec_tructiep]', function (e) {
        var id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_edit_giaoviec_tructiep',
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
    $('body').on('click', 'button[name=box_pop_edit_giaoviec_tructiep_close]', function (e) {
        $('.box_pop_add').hide();
    });
    
    /////////////////////////////
    $('body').on('click', '.box_pop_edit_giaoviec_tructiep_close , button[name=close_box_pop_edit_giaoviec_tructiep]', function (e) {
        $('.box_pop_add').hide();
    });
    /////////////////////////////
    $('body').on('click', 'button[name=update_giaoviec_tructiep]', function (e) {
        e.preventDefault();

        var $form = $('#form_edit_giaoviec_tructiep');
        var id = $form.find('input[name=id]').val();
        var phong_ban_nhan = $form.find('select[name=phong_ban_nhan]').val();
        var nguoi_nhan = $form.find('select[name=nguoi_nhan]').val();
        var nguoi_giamsat = $form.find('select[name=nguoi_giam_sat]').val();
        var ten_congviec = ($form.find('input[name=ten_cong_viec]').val() || '').trim();
        var mo_ta = ($form.find('textarea[name=mo_ta]').val() || '').trim();
        var han_hoanthanh = $form.find('input[name=han_hoan_thanh]').val();
        var mucdo_uutien = $form.find('select[name=mucdo_uutien]').val();
        var thoi_gian_nhan_viec = $form.find('input[name=thoi_gian_nhan_viec]').val();
        var form_data = new FormData();

        form_data.append('action', 'update_giaoviec_tructiep');
        form_data.append('id', id);
        form_data.append('phong_ban_nhan', phong_ban_nhan || '');
        form_data.append('nguoi_nhan', nguoi_nhan || '');
        form_data.append('nguoi_giamsat', nguoi_giamsat || '');
        form_data.append('ten_congviec', ten_congviec);
        form_data.append('mo_ta', mo_ta);
        form_data.append('han_hoanthanh', han_hoanthanh);
        form_data.append('mucdo_uutien', mucdo_uutien);
        form_data.append('thoi_gian_nhan_viec', thoi_gian_nhan_viec);
        var fileInput = $form.find('input[name="tep_dinh_kem[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('tep_dinh_kem[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_add').hide();
                        var dulieu = {
                            'hd': 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giamsat: info.nguoi_giamsat,
                            nguoi_giao:info.nguoi_giao
                        }
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    }
                }, 3000);
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=box_pop_delete_giaoviec_tructiep]', function (e) {
        var id = $(this).parents('tr').attr('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_delete_giaoviec_tructiep',
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
    $('body').on('click', '.box_pop_delete_giaoviec_tructiep_close , button[name=close_box_pop_delete_giaoviec_tructiep]', function (e) {
        $('.box_pop_add').hide();
    });
    /////////////////////////////
    $('body').on('click', 'button[name=delete_giaoviec_tructiep]', function (e) {
        var id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'delete_giaoviec_tructiep',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_add').hide();
                    var dulieu = {
                        hd: 'load_list_giaoviec_tructiep',
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '#nhan_congviec_tructiep', function (e) {
        var id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'nhan_congviec_tructiep',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    var dulieu = {
                        hd: 'load_giaoviec_tructiep',
                        id: info.id,
                        nguoi_nhan: info.nguoi_nhan,
                        nguoi_giamsat: info.nguoi_giamsat,
                        nguoi_giao: info.nguoi_giao,
                        
                    };
                    
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '#box_pop_nhanviec_quahan', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_nhanviec_quahan',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_nhanviec').html(info.html);
                $('.box_pop_nhanviec').show();
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=nhanviec_quahan_tructiep]', function (e) {
        e.preventDefault();
        var $form = $('#form_nhanviec_quahan');

        var id = $form.find('input[name=id]').val();
        var ly_do_nhan_muon = ($form.find('textarea[name=ly_do_nhan_muon]').val() || '').trim();
        var form_data = new FormData();
        form_data.append('action', 'nhanviec_quahan_tructiep');
        form_data.append('id', id);
        form_data.append('ly_do_nhan_muon', ly_do_nhan_muon);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_nhanviec').hide();
                    var dulieu = {
                        hd: 'load_giaoviec_tructiep',
                        id: info.id,
                        nguoi_nhan: info.nguoi_nhan,
                        nguoi_giao: info.nguoi_giao,
                        nguoi_giamsat: info.nguoi_giamsat,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                }
            }
        });
    });
    /////////////////////////////
    $('body').on('click', 'button[name=close_box_pop_nhanviec_quahan],.box_pop_nhanviec_quahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ////////////////////////////
    $('body').on('click', '#box_pop_capnhat_trangthai', function (e) {
        var id = $(this).data('id');
        var action_capnhat_trangthai = $(this).attr('action');
        let hien_thi = '';
        if (action_capnhat_trangthai == 'giaoviec_tructiep') {
            hien_thi = '.box_pop_nhanviec';
        } else if (action_capnhat_trangthai == 'giaoviec_du_an') {
            hien_thi = '.box_pop_lichsu';
        }
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_capnhat_trangthai',
                id: id,
                action_capnhat_trangthai: action_capnhat_trangthai
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html);
                $(hien_thi).show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=capnhat_trangthai_tructiep]', function (e) {
        e.preventDefault();

        var $form = $('#form_capnhat_trangthai');
        var id = $form.find('input[name=id]').val();
        var tien_do_hoan_thanh = $form.find('input[name=tien_do_hoan_thanh]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var form_data = new FormData();

        form_data.append('action', 'capnhat_trangthai_tructiep');
        form_data.append('id', id);
        form_data.append('tien_do_hoan_thanh', tien_do_hoan_thanh || '');
        form_data.append('ghi_chu', ghi_chu || '');
        var fileInput = $form.find('input[name="tep_dinh_kem[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('tep_dinh_kem[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_nhanviec').hide();
                        var dulieu = {
                            hd: 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giao: info.nguoi_giao,
                            nguoi_giamsat: info.nguoi_giamsat,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_capnhat_trangthai],.box_pop_capnhat_trangthai_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
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
    ///////////////////////////
    $('body').on('click', 'button[name=box_pop_duyet]', function (e) {
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
                action: 'box_pop_duyet',
                id: id,
                action_baocao: action_baocao
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html);
                $(hien_thi).show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_duyet],.box_pop_duyet_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=duyet_baocao_tructiep]', function (e) {
        e.preventDefault();
        var $form = $('#form_duyet');
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'duyet_baocao_tructiep');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_nhanviec').hide();
                        var dulieu = {
                            hd: 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giao: info.nguoi_giao,
                            nguoi_giamsat: info.nguoi_giamsat,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                        alert(info.thongbao);
                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=tuchoi_baocao_tructiep]', function (e) {
        e.preventDefault();
        var $form = $('#form_duyet');
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'tuchoi_baocao_tructiep');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_nhanviec').hide();
                        var dulieu = {
                            hd: 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giao: info.nguoi_giao,
                            nguoi_giamsat: info.nguoi_giamsat,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                        alert(info.thongbao);
                    }
                }, 3000);
            }
        });
    });
    //////////////////////////
    $('body').on('click', 'button[name=box_pop_nhanxet]', function (e) {
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
                action: 'box_pop_nhanxet',
                id: id,
                action_baocao: action_baocao
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html);
                $(hien_thi).show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_nhanxet],.box_pop_nhanxet_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=nhanxet_baocao_tructiep]', function (e) {
        e.preventDefault();
        var $form = $('#form_nhanxet');
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'nhanxet_baocao_tructiep');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_nhanviec').hide();
                        var dulieu = {
                            hd: 'load_giaoviec_tructiep',
                            id: info.id,
                            nguoi_nhan: info.nguoi_nhan,
                            nguoi_giao: info.nguoi_giao,
                            nguoi_giamsat: info.nguoi_giamsat,
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);                        
                    } else {
                        
                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=nhanxet_baocao_du_an]', function (e) {
        e.preventDefault();
        var $form = $('#form_nhanxet');
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'nhanxet_baocao_du_an');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $.ajax({
                            url: '/members/process.php',
                            type: 'post',
                            data: {
                                action: 'box_pop_lichsu_baocao_congviec_du_an',
                                id: info.id,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_pop_lichsu').html(info.html);
                                $('.box_pop_lichsu').show();
                            }
                        });
                        var dulieu = {
                            hd: 'load_congviec_du_an',
                            id: info.id,
                            list_nhanvien: info.list_nhanvien
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);                        
                    } else {
                        
                    }
                }, 3000);
            }
        });
    });
    ///////////////////////////
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
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_view_baocao],.box_pop_view_baocao_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', '#box_pop_giahan', function (e) {
        var id = $(this).data('id');
        var action_giahan = $(this).attr('action');
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
                action: 'box_pop_giahan',
                id: id,
                action_giahan: action_giahan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $(hien_thi).html(info.html);
                $(hien_thi).show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_giahan],.box_pop_giahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=giahan_tructiep]', function (e) {
        e.preventDefault();
        var $form = $('#form_giahan');
        var id = $form.find('input[name=id]').val();
        var han_sau_giahan = $form.find('input[name=han_sau_giahan]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var form_data = new FormData();
        form_data.append('action', 'giahan_tructiep');
        form_data.append('id', id);
        form_data.append('han_sau_giahan', han_sau_giahan);
        form_data.append('ghi_chu', ghi_chu);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_nhanviec').hide();
                    var dulieu = {
                        hd: 'load_giaoviec_tructiep',
                        id: info.id,
                        nguoi_nhan: info.nguoi_nhan,
                        nguoi_giao: info.nguoi_giao,
                        nguoi_giamsat: info.nguoi_giamsat,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=giahan_du_an]', function (e) {
        e.preventDefault();
        var $form = $('#form_giahan');
        var id = $form.find('input[name=id]').val();
        var han_sau_giahan = $form.find('input[name=han_sau_giahan]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var form_data = new FormData();
        form_data.append('action', 'giahan_du_an');
        form_data.append('id', id);
        form_data.append('han_sau_giahan', han_sau_giahan);
        form_data.append('ghi_chu', ghi_chu);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_lichsu').hide();
                    var dulieu = {
                        hd: 'load_congviec_du_an',
                        id: info.id,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });

    ///////////////////////////
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
    ///////////////////////////
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
    ///////////////////////////
    $('body').on('click', 'button[name=close_box_pop_view_giahan],.box_pop_view_giahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=box_pop_duyet_giahan_tructiep]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_duyet_giahan_tructiep',
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
    $('body').on('click', 'button[name=close_box_pop_duyet_giahan],.box_pop_duyet_giahan_close', function (e) {
        $('.box_pop_nhanviec').hide();
        $('.box_pop_lichsu').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=duyet_giahan_tructiep]', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var ghichu_cua_sep = $('#ghichu_cua_sep_giahan').val();
        console.log(ghichu_cua_sep);
        console.log(id);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'duyet_giahan_tructiep',
                id: id,
                ghichu_cua_sep: ghichu_cua_sep || ''
            },
            success: function (kq) {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_nhanviec').hide();
                    var dulieu = {
                        hd: 'load_giaoviec_tructiep',
                        id: info.id,
                        nguoi_nhan: info.nguoi_nhan,
                        nguoi_giao: info.nguoi_giao,
                        nguoi_giamsat: info.nguoi_giamsat,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);

                    socket.emit('user_send_hoatdong', JSON.stringify({
                        hd: 'load_giahan',
                        id: info.id,
                        type: 'giaoviec_tructiep'
                    }));
                } else {
                    alert(info.thongbao);
                }
            },
            error: function () {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=tuchoi_giahan_tructiep]', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var ghichu_cua_sep = $('#ghichu_cua_sep_giahan').val();

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'tuchoi_giahan_tructiep',
                id: id,
                ghichu_cua_sep: ghichu_cua_sep || ''
            },
            success: function (kq) {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_nhanviec').hide();
                    var dulieu = {
                        hd: 'load_giaoviec_tructiep',
                        id: info.id,
                        nguoi_nhan: info.nguoi_nhan,
                        nguoi_giao: info.nguoi_giao,
                        nguoi_giamsat: info.nguoi_giamsat,
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                    
                } else {
                    alert(info.thongbao);
                }
            },
            error: function () {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=box_pop_view_lichsu_giaoviec]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_lichsu_giaoviec',
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
    $('body').on('click', 'button[name=close_box_pop_view_lichsu_giaoviec],.box_pop_view_lichsu_giaoviec_close', function (e) {
        $('.box_pop_add').hide();
    });
    ///////////////////////////
    $('body').on('click', 'button[name=box_pop_view_lichsu_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
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
            url: '/members/process.php',
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
    $('body').on('click', 'button[name=add_thanh_vien]', function (e) {
        // Đếm số thành viên hiện có
        var currentCount = $('.form_add_nhanvien').length;
        var memberIndex = currentCount + 1;

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'add_thanh_vien',
                member_index: memberIndex
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    // Append thay vì replace để có thể thêm nhiều form
                    $('.nhanvien_du_an').append(info.html);
                    $('.nhanvien_du_an').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });

    ///////////////////////////
    // Xóa thành viên
    $('body').on('click', '.btn_remove_member', function (e) {
        if (confirm('Bạn có chắc chắn muốn xóa thành viên này?')) {
            $(this).closest('.form_add_nhanvien').fadeOut(300, function () {
                $(this).remove();
                // Cập nhật lại số thứ tự
                $('.form_add_nhanvien').each(function (index) {
                    var newIndex = index + 1;
                    $(this).attr('data-member-index', newIndex);
                    $(this).find('.member_index_text').text('Thành viên #' + newIndex);
                });
            });
        }
    });
    ///////////////////////////
    $('body').on('change', '.form_select[name^=add_phong_ban_]', function () {
        var name = $(this).attr('name'); // "phong_ban_1" hoặc "phong_ban_2"
        var member_index = name.split('_').pop(); // Lấy phần cuối: "1", "2", ...
        phong_ban_nhan = $(this).val();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_user_nhan',
                phong_ban_nhan: phong_ban_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.form_select[name=add_nhan_vien_' + member_index + ']').html(info.list);
            }
        });
    });
    //////////////////////////
    $('body').on('click', 'button[name=add_du_an]', function (e) {
        var $form = $('#form_add_du_an');
        var ten_du_an = $form.find('input[name=ten_du_an]').val();
        var mo_ta_du_an = $form.find('textarea[name=mo_ta_du_an]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var muc_do_uu_tien = $form.find('select[name=muc_do_uu_tien]').val();

        // Lấy dữ liệu từ tất cả các form thành viên
        var list_nhan_vien = [];
        $('.form_add_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var memberData = {
                ten_cong_viec: $memberForm.find('input[name=ten_cong_viec]').val(),
                phong_ban: $memberForm.find('select[name^="add_phong_ban_"]').val(),
                nhan_vien: $memberForm.find('select[name^="add_nhan_vien_"]').val(),
                thoi_gian_nhan_viec: $memberForm.find('input[name=thoi_gian_nhan_viec]').val(),
                han_hoan_thanh: $memberForm.find('input[name=han_hoan_thanh]').val(),
                muc_do_uu_tien: $memberForm.find('select[name=muc_do_uu_tien]').val(),
                mo_ta_cong_viec: $memberForm.find('textarea[name=mo_ta_cong_viec]').val(),
                ghi_chu: $memberForm.find('textarea[name=ghi_chu]').val()
            };
            
            list_nhan_vien.push(memberData);
        });

        if(list_nhan_vien.length == 0) {
            alert('Vui lòng thêm ít nhất một công việc');
            return;
        }
        
        var form_data = new FormData();
        form_data.append('action', 'add_du_an');
        form_data.append('ten_du_an', ten_du_an);
        form_data.append('mo_ta_du_an', mo_ta_du_an);
        form_data.append('ghi_chu', ghi_chu);
        form_data.append('muc_do_uu_tien', muc_do_uu_tien);
        form_data.append('list_nhan_vien', JSON.stringify(list_nhan_vien));

        // Thêm file đính kèm cho từng thành viên
        $('.form_add_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var fileInput = $memberForm.find('input[name="file_dinh_kem[]"]')[0];
            if (fileInput && fileInput.files.length > 0) {
                $.each(fileInput.files, function (i, file) {
                    form_data.append('file_dinh_kem_' + index + '[]', file);
                });
            }
        });
        

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    // ===== RESET FORM DỰ ÁN =====
                    $('#form_add_du_an')[0].reset();

                    // ===== XÓA TOÀN BỘ FORM NHÂN VIÊN =====
                    $('.form_add_nhanvien').remove();
                    var dulieu = {
                        hd: 'load_du_an',
                        id: info.id_du_an,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=search_list_du_an_quanly]', function (e) {
        var search_keyword = $('input[name=search_keyword]').val();
        var search_nguoi_quan_ly = $('select[name=search_nguoi_quan_ly]').val();
        var search_trang_thai = $('select[name=filter_trang_thai]').val();
        var search_ngay_bat_dau = $('input[name=filter_ngay_bat_dau]').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_list_du_an',
                search_keyword: search_keyword,
                search_trang_thai: search_trang_thai,
                search_ngay_bat_dau: search_ngay_bat_dau,
                search_nguoi_quan_ly: search_nguoi_quan_ly
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                    $('#list_du_an').html(info.list);
                }, 1000);
                if (info.ok == 1) {
                    $('#list_du_an').html(info.list);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=view_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_add').html(info.html);
                    $('.box_pop_add').show();
                    initDeadlineCountdown('.deadline_list');
                    
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    // Mở setting
    $('body').on('click', 'button[name=box_cai_dat]', function (e) {
        e.stopPropagation(); // chặn nổi bọt
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_cai_dat_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.setting-menu').show();
                } else {
                }
            }
        });
    });

    $('body').on('click', '.setting-menu', function (e) {
        e.stopPropagation();
    });

    $('body').on('click', function () {
        $('.setting-menu').hide();
    });

    ///////////////////////////
    $('body').on('click', '.box_congviec_du_an', function (e) {
        var id = $(this).closest('.box_congviec_du_an').attr('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_view_congviec_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_congviec_du_an').html(info.html);
                    $('.box_pop_congviec_du_an').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '#box_pop_lichsu_baocao_congviec_du_an', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
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
            url: '/members/process.php',
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
    $('body').on('click', '#box_pop_nhanviec_du_an_quahan', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_nhanviec_du_an_quahan',
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
    $('body').on('click', 'button[name=nhanviec_quahan_du_an]', function (e) {
        e.preventDefault();
        var $form = $('#form_nhanviec_quahan');

        var id = $form.find('input[name=id]').val();
        var ly_do_nhan_muon = ($form.find('textarea[name=ly_do_nhan_muon]').val() || '').trim();
        var form_data = new FormData();
        form_data.append('action', 'nhanviec_quahan_du_an');
        form_data.append('id', id);
        form_data.append('ly_do_nhan_muon', ly_do_nhan_muon);
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_lichsu').hide();
                    var dulieu = {
                        hd: 'load_congviec_du_an',
                        id: info.id,
                        list_nhanvien: info.list_nhanvien,
                        parent_id: info.parent_id
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    /////////////////////////
    $('body').on('click', 'button[name=box_pop_delete_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_delete_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_congviec_du_an').html(info.html);
                $('.box_pop_congviec_du_an').show();
            }
        });
    });
    /////////////////////////////
    $('body').on('click', '.box_pop_delete_du_an_close,button[name=close_box_pop_delete_du_an]', function (e) {
        $('.box_pop_congviec_du_an').hide();
    });
    ////////////////////////////
    $('body').on('click', 'button[name=delete_du_an]', function (e) {
        var id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'delete_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_congviec_du_an').hide();
                    $('.box_pop_add').hide();
                    $('#' + id).remove();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=box_pop_edit_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_edit_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_congviec_du_an').html(info.html);
                $('.box_pop_congviec_du_an').show();
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '.box_pop_edit_du_an_close,button[name=close_box_pop_edit_du_an]', function (e) {
        $('.box_pop_congviec_du_an').hide();
    });
    ////////////////////////////
    $('body').on('change', '.form_select[name^=phong_ban_]', function () {
        // Lấy member_index từ name attribute
        var name = $(this).attr('name'); // "phong_ban_1" hoặc "phong_ban_2"
        var member_index = name.split('_').pop(); // Lấy phần cuối: "1", "2", ...

        var phong_ban_nhan = $(this).val();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_user_nhan_congviec_nhanvien',
                phong_ban_nhan: phong_ban_nhan,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.form_select[name=nhan_vien_' + member_index + ']').html(info.list);
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=box_pop_delete_congviec_nhanvien]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_delete_congviec_nhanvien',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_delete').html(info.html);
                $('.box_pop_delete').show();
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '.box_pop_delete_congviec_close,button[name=close_box_pop_delete_congviec]', function (e) {
        $('.box_pop_delete').hide();
        $('.box_pop_lichsu').hide();
    });
    ////////////////////////////
    $('body').on('click', 'button[name=delete_congviec]', function (e) {
        var id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'delete_congviec',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    $('.box_pop_delete').hide();
                    $('.box_pop_lichsu').hide();
                    $('#' + id).remove();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#nhan_congviec_du_an', function (e) {
        var id = $(this).data('id');
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'nhan_congviec_du_an',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    var dulieu = {
                        hd: 'load_congviec_du_an',
                        id: info.id,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=capnhat_trangthai_du_an]', function (e) {
        e.preventDefault();

        var $form = $('#form_capnhat_trangthai');
        var id = $form.find('input[name=id]').val();
        var tien_do_hoan_thanh = $form.find('input[name=tien_do_hoan_thanh]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var form_data = new FormData();

        form_data.append('action', 'capnhat_trangthai_du_an');
        form_data.append('id', id);
        form_data.append('tien_do_hoan_thanh', tien_do_hoan_thanh || '');
        form_data.append('ghi_chu', ghi_chu || '');
        var fileInput = $form.find('input[name="tep_dinh_kem[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('tep_dinh_kem[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_lichsu').hide();
                        var dulieu = {
                            hd: 'load_congviec_du_an',
                            id: info.id,
                            list_nhanvien: info.list_nhanvien
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    }
                }, 3000);
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=duyet_baocao_du_an]', function (e) {
        e.preventDefault();
        var $form = $('#form_duyet');      
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'duyet_baocao_du_an');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $.ajax({
                            url: '/members/process.php',
                            type: 'post',
                            data: {
                                action: 'box_pop_lichsu_baocao_congviec_du_an',
                                id: info.id,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_pop_lichsu').html(info.html);
                                $('.box_pop_lichsu').show();
                            }
                        });
                        var dulieu = {
                            hd: 'load_congviec_du_an',
                            id: info.id,
                            list_nhanvien: info.list_nhanvien
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                        alert(info.thongbao);
                    }
                }, 3000);
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=tuchoi_baocao_du_an]', function (e) {
        e.preventDefault();
        var $form = $('#form_duyet');      
        var id = $(this).data('id');
        var ghichu_cua_sep = $form.find('textarea[name=ghichu_cua_sep]').val();
        var form_data = new FormData();

        form_data.append('action', 'tuchoi_baocao_du_an');
        form_data.append('id', id);
        form_data.append('ghichu_cua_sep', ghichu_cua_sep || '');
        // Thêm file vào form_data
        var fileInput = $form.find('input[name="file_congviec_sep[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('file_congviec_sep[]', file);
            });
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $.ajax({
                            url: '/members/process.php',
                            type: 'post',
                            data: {
                                action: 'box_pop_lichsu_baocao_congviec_du_an',
                                id: info.id,
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                $('.box_pop_lichsu').html(info.html);
                                $('.box_pop_lichsu').show();
                            }
                        });
                        var dulieu = {
                            hd: 'load_congviec_du_an',
                            id: info.id,
                            list_nhanvien: info.list_nhanvien
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                        alert(info.thongbao);
                    }
                }, 3000);
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=box_pop_duyet_giahan_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_duyet_giahan_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.box_pop_lichsu').html(info.html);
                $('.box_pop_lichsu').show();
            }
        });
    });
    ///////////////////////////
    $('body').on('click', 'button[name=duyet_giahan_du_an]', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var ghichu_cua_sep = $('#ghichu_cua_sep_giahan').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'duyet_giahan_du_an',
                id: id,
                ghichu_cua_sep: ghichu_cua_sep || ''
            },
            success: function (kq) {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    // $.ajax({
                    //     url: '/members/process.php',
                    //     type: 'post',
                    //     data: {
                    //         action: 'box_pop_lichsu_giahan_congviec_du_an',
                    //         id: info.id,
                    //     },
                    //     success: function (kq) {
                    //         var info = JSON.parse(kq);
                    //         $('.box_pop_lichsu').html(info.html);
                    //         $('.box_pop_lichsu').show();
                    //     }
                    // });
                    $('.box_pop_lichsu').hide();
                    var dulieu = {
                        hd: 'load_congviec_du_an',
                        id: info.id,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);

                    socket.emit('user_send_hoatdong', JSON.stringify({
                        hd: 'load_giahan',
                        id: info.id,
                        type: 'giaoviec_du_an'
                    }));

                } else {
                }
            },
            error: function () {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=tuchoi_giahan_du_an]', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var ghichu_cua_sep = $('#ghichu_cua_sep_giahan').val();
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'tuchoi_giahan_du_an',
                id: id,
                ghichu_cua_sep: ghichu_cua_sep || ''
            },
            success: function (kq) {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    var dulieu = {
                        hd: 'load_congviec_du_an',
                        id: info.id,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                }
            },
            error: function () {
                $('.load_overlay2').hide();
                $('.load_process_2').fadeOut();
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=add_thanh_vien_edit_du_an]', function (e) {
        // Đếm số thành viên hiện có
        var currentCount = $('.form_edit_congviec_nhanvien').length;
        var memberIndex = currentCount + 1;

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'add_thanh_vien',
                member_index: memberIndex
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    // Append thay vì replace để có thể thêm nhiều form
                    $('.nhanvien_du_an').append(info.html);
                    $('.nhanvien_du_an').show();
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });

    
    ////////////////////////////
    $('body').on('click', 'button[name=edit_du_an]', function (e) {
        var $form = $('#form_edit_du_an');
        var id = $form.find('input[name=id]').val();
        var ten_du_an = $form.find('input[name=ten_du_an]').val();
        var mo_ta_du_an = $form.find('textarea[name=mo_ta_du_an]').val();
        var ghi_chu = $form.find('textarea[name=ghi_chu]').val();
        var muc_do_uu_tien = $form.find('select[name=muc_do_uu_tien]').val();

        // Lấy dữ liệu từ tất cả các form thành viên
        var list_nhan_vien = [];
        $('.form_add_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var memberData = {
                ten_cong_viec: $memberForm.find('input[name=ten_cong_viec]').val(),
                phong_ban: $memberForm.find('select[name^="add_phong_ban_"]').val(),
                nhan_vien: $memberForm.find('select[name^="add_nhan_vien_"]').val(),
                thoi_gian_nhan_viec: $memberForm.find('input[name=thoi_gian_nhan_viec]').val(),
                han_hoan_thanh: $memberForm.find('input[name=han_hoan_thanh]').val(),
                muc_do_uu_tien: $memberForm.find('select[name=muc_do_uu_tien]').val(),
                mo_ta_cong_viec: $memberForm.find('textarea[name=mo_ta_cong_viec]').val(),
                ghi_chu: $memberForm.find('textarea[name=ghi_chu]').val()
            };
            list_nhan_vien.push(memberData);
        });

        var list_nhan_vien_edit = [];
        $('.form_edit_congviec_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var filesToRemove = $memberForm.data('files-to-remove') || [];
            var memberData = {
                id: $memberForm.find('input[name=id]').val(),
                ten_cong_viec: $memberForm.find('input[name=ten_cong_viec]').val(),
                phong_ban: $memberForm.find('select[name^="phong_ban_"]').val(),
                nhan_vien: $memberForm.find('select[name^="nhan_vien_"]').val(),
                thoi_gian_nhan_viec: $memberForm.find('input[name=thoi_gian_nhan_viec]').val(),
                han_hoan_thanh: $memberForm.find('input[name=han_hoan_thanh]').val(),
                muc_do_uu_tien: $memberForm.find('select[name=muc_do_uu_tien]').val(),
                mo_ta_cong_viec: $memberForm.find('textarea[name=mo_ta_cong_viec]').val(),
                ghi_chu: $memberForm.find('textarea[name=ghi_chu]').val(),
                files_to_remove: filesToRemove
            };
            list_nhan_vien_edit.push(memberData);
        });

        var form_data = new FormData();
        form_data.append('action', 'edit_du_an');
        form_data.append('id', id);
        form_data.append('ten_du_an', ten_du_an);
        form_data.append('mo_ta_du_an', mo_ta_du_an);
        form_data.append('ghi_chu', ghi_chu);
        form_data.append('muc_do_uu_tien', muc_do_uu_tien);
        form_data.append('list_nhan_vien', JSON.stringify(list_nhan_vien));
        form_data.append('list_nhan_vien_edit', JSON.stringify(list_nhan_vien_edit));

        // Thêm file đính kèm cho từng thành viên
        $('.form_add_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var fileInput = $memberForm.find('input[name="file_dinh_kem[]"]')[0];
            if (fileInput && fileInput.files.length > 0) {
                $.each(fileInput.files, function (i, file) {
                    form_data.append('file_dinh_kem_' + index + '[]', file);
                });
            }
        });

        $('.form_edit_congviec_nhanvien').each(function (index) {
            var $memberForm = $(this);
            var fileInput = $memberForm.find('input[name="file_dinh_kem[]"]')[0];
            if (fileInput && fileInput.files.length > 0) {
                $.each(fileInput.files, function (i, file) {
                    form_data.append('file_dinh_kem_edit_' + index + '[]', file);
                });
            }
        });
       
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: form_data,
            contentType: false,
            processData: false,
            success: function (kq) {
                var info = JSON.parse(kq);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if (info.ok == 1) {
                    var id = info.id_du_an;
                    $.ajax({
                        url: '/members/process.php',
                        type: 'post',
                        data: {
                            action: 'box_pop_view_du_an',
                            id: id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            if (info.ok == 1) {
                                $('.box_pop_add').html(info.html);
                                $('.box_pop_add').show();
                                initDeadlineCountdown('.deadline_list');
                            } else {
                                alert(info.thongbao);
                            }
                        }
                    });
                    var dulieu = {
                        hd: 'load_du_an',
                        id: info.id_du_an,
                        list_nhanvien: info.list_nhanvien
                    };
                    var info_chat = JSON.stringify(dulieu);
                    socket.emit('user_send_hoatdong', info_chat);
                } else {
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#btn_add_giaoviec_giaopho', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_pop_add_giaoviec_giaopho',
                id: id,
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                
                $('.box_pop_congviec_du_an').html(info.html);
                $('.box_pop_congviec_du_an').show();

            }
        });
    });    
    ////////////////////////////
    $('body').on('click', '.btn_close_form, .btn_cancel', function (e) {
        $('.box_pop_congviec_du_an').hide();
    });
    
    ////////////////////////////
    $('body').on('click', 'button[name="add_thanh_vien_giaopho"]', function (e) {
        e.preventDefault();
        var currentCount = $('.form_add_nhanvien').length;
        var memberIndex = currentCount + 1;
        
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'add_thanh_vien',
                member_index: memberIndex
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok == 1) {
                    $('.nhanvien_giaoviec_giaopho').append(info.html);
                } else {
                }
            }
        });
    });
    ////////////////////////////
    // Submit form
    $('body').on('click', 'button[name="submit_congviec_giaopho"]', function (e) {
        e.preventDefault();
        var id_congviec = $(this).data('id_congviec');
        var parent_id = $(this).data('parent_id');
        // Lấy dữ liệu từ tất cả các form thành viên
        var list_nhan_vien = [];
        
        $('.form_add_nhanvien').each(function(index) {
            
            var $memberForm = $(this);
            var memberData = {
                ten_cong_viec: $memberForm.find('input[name="ten_cong_viec"]').val().trim(),
                phong_ban: $memberForm.find('select[name^="add_phong_ban_"]').val(),
                nhan_vien: $memberForm.find('select[name^="add_nhan_vien_"]').val(),
                thoi_gian_nhan_viec: $memberForm.find('input[name="thoi_gian_nhan_viec"]').val(),
                han_hoan_thanh: $memberForm.find('input[name="han_hoan_thanh"]').val(),
                muc_do_uu_tien: $memberForm.find('select[name="muc_do_uu_tien"]').val(),
                mo_ta_cong_viec: $memberForm.find('textarea[name="mo_ta_cong_viec"]').val().trim(),
                ghi_chu: $memberForm.find('textarea[name="ghi_chu"]').val().trim()
            };
            list_nhan_vien.push(memberData);
        });
    
        // Tạo FormData
        var form_data = new FormData();
        form_data.append('action', 'add_giaoviec_giaopho');
        form_data.append('id_congviec', id_congviec);
        form_data.append('parent_id', parent_id);
        form_data.append('list_nhan_vien', JSON.stringify(list_nhan_vien));
        
        // Thêm file đính kèm cho từng thành viên
        $('.form_add_nhanvien').each(function(index) {
            var $memberForm = $(this);
            var fileInput = $memberForm.find('input[type="file"]')[0];
            if(fileInput && fileInput.files.length > 0) {
                for(var i = 0; i < fileInput.files.length; i++) {
                    form_data.append('file_dinh_kem_' + index + '[]', fileInput.files[i]);
                }
            }
        });
        
        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();
        
        $.ajax({
            url: '/members/process.php',
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response) {
                var info = JSON.parse(response);
                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);
                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();
                }, 3000);
                if(info.ok == 1) {
                    $.ajax({
                        url: '/members/process.php',
                        type: 'post',
                        data: {
                            action: 'box_pop_view_du_an',
                            id: id_congviec
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            if (info.ok == 1) {
                                $('.box_pop_add').html(info.html);
                                $('.box_pop_add').show();
                                initDeadlineCountdown('.deadline_list');
                                
                            } else {
                                alert(info.thongbao);
                            }
                        }
                    });
                    $('.box_pop_congviec_du_an').hide();
                } else {
                }
            },
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name="delete_congviec_giaopho"]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: { 
                action: 'box_pop_delete_congviec_nhanvien',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if(info.ok == 1) {
                    $('.box_pop_lichsu').html(info.html);
                    $('.box_pop_lichsu').show();
                } else {
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name="edit_congviec_giaopho"]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: { 
                action: 'box_pop_edit_congviec_giaopho',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if(info.ok == 1) {
                    $('.box_pop_lichsu').html(info.html);
                    $('.box_pop_lichsu').show();
                } else {
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('change', '.form_select[name=phong_ban_congviec]', function () {
        phong_ban_nhan = $(this).val();
        console.log(phong_ban_nhan);
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'load_user_nhan',
                phong_ban_nhan: phong_ban_nhan
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                $('.form_select[name=nguoi_nhan_congviec]').html(info.list);
            }
        });
    });
    ////////////////////////////
    // Xóa file existing
    $('body').on('click', '.file_item_existing_remove', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $item = $btn.closest('.file_item_existing');
        
        if (confirm('Bạn có chắc chắn muốn xóa file này?')) {
            // Đánh dấu file đã bị xóa
            $btn.data('removed', true);
            // Ẩn item
            $item.fadeOut(300, function() {
                $(this).remove();
            });
        }
    });

    // Close button handler
    $('body').on('click', '.box_pop_edit_congviec_giaopho_close,button[name=close_box_pop_edit_congviec_giaopho]', function (e) {
        $('.box_pop_lichsu').hide();
    });
    ////////////////////////////
    $('body').on('click', 'button[name=update_congviec_giaopho]', function (e) {
        e.preventDefault();

        var $form = $('#form_edit_congviec_giaopho');
        var id = $form.find('input[name=id]').val();
        var ten_cong_viec = ($form.find('input[name=ten_cong_viec]').val() || '').trim();
        var phong_ban_congviec = $form.find('select[name=phong_ban_congviec]').val();
        var nhan_vien_congviec = $form.find('select[name=nhan_vien_congviec]').val();
        var han_hoan_thanh = $form.find('input[name=han_hoan_thanh]').val();
        var thoi_gian_nhan_viec = $form.find('input[name=thoi_gian_nhan_viec]').val();
        var mucdo_uutien = $form.find('select[name=mucdo_uutien]').val();
        var mo_ta_cong_viec = ($form.find('textarea[name=mo_ta_cong_viec]').val() || '').trim();
        var ghi_chu = ($form.find('textarea[name=ghi_chu]').val() || '').trim();

        var form_data = new FormData();
        form_data.append('action', 'update_congviec_giaopho');
        form_data.append('id', id);
        form_data.append('ten_cong_viec', ten_cong_viec);
        form_data.append('phong_ban_congviec', phong_ban_congviec || '');
        form_data.append('nhan_vien_congviec', nhan_vien_congviec || '');
        form_data.append('han_hoan_thanh', han_hoan_thanh);
        form_data.append('thoi_gian_nhan_viec', thoi_gian_nhan_viec);
        form_data.append('mucdo_uutien', mucdo_uutien);
        form_data.append('mo_ta_cong_viec', mo_ta_cong_viec);
        form_data.append('ghi_chu', ghi_chu);

        // Thêm file đính kèm
        var fileInput = $form.find('input[name="tep_dinh_kem[]"]')[0];
        if (fileInput && fileInput.files.length > 0) {
            $.each(fileInput.files, function (i, file) {
                form_data.append('tep_dinh_kem[]', file);
            });
        }

        // Thêm danh sách file cần xóa (nếu có)
        var filesToRemove = [];
        $form.find('.file_item_existing_remove').each(function() {
            var $btn = $(this);
            if ($btn.data('removed') === true) {
                filesToRemove.push($btn.data('file'));
            }
        });
        if (filesToRemove.length > 0) {
            form_data.append('files_to_remove', JSON.stringify(filesToRemove));
        }

        $('.load_overlay2').show();
        $('.load_process_2').fadeIn();

        $.ajax({
            url: '/members/process.php',
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (kq) {
                var info = JSON.parse(kq);

                setTimeout(function () {
                    $('.load_process_2 .load_note span').html(info.thongbao);
                }, 1000);

                setTimeout(function () {
                    $('.load_process_2').hide();
                    $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                    $('.load_overlay2').hide();

                    if (info.ok == 1) {
                        $('.box_pop_lichsu').hide();
                        var dulieu = {
                            hd: 'load_congviec_giaopho',
                            id: info.id,
                            list_nhanvien: info.list_nhanvien
                        };
                        var info_chat = JSON.stringify(dulieu);
                        socket.emit('user_send_hoatdong', info_chat);
                    } else {
                    }
                }, 3000);
            },
            
        });
    });
    ///////////////////////////
    $('body').on('click', '.filter_trangthai', function (e) {
        e.preventDefault();
        var tu_ngay = $('input[name="tu_ngay"]').val();
        var den_ngay = $('input[name="den_ngay"]').val();
        var nam_thang = $('input[name="nam_thang"]').val();
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'filter_thongke_congviec',
                tu_ngay: tu_ngay,
                den_ngay: den_ngay,
                nam_thang: nam_thang
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1 && info.html) {
                    $('.box_right').replaceWith(info.html);
                }
            }
        });
    });
    ///////////////////////////
    $('body').on('click', '.filter_du_an', function (e) {
        e.preventDefault();
        var tu_ngay = $('input[name="tu_ngay"]').val();
        var den_ngay = $('input[name="den_ngay"]').val();
        var nam_thang = $('input[name="nam_thang"]').val();
        
        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'filter_thongke_du_an',
                tu_ngay: tu_ngay,
                den_ngay: den_ngay,
                nam_thang: nam_thang
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1 && info.html) {
                    $('.box_right').replaceWith(info.html);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=box_thongke_du_an]', function (e) {
        var id = $(this).data('id');
        $.ajax({
            url: '/members/process.php',
            type: 'post',
            data: {
                action: 'box_thongke_du_an',
                id: id
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('.box_pop_congviec_du_an').html(info.html);
                    $('.box_pop_congviec_du_an').show();
                    
                } else {
                    alert(info.thongbao);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', 'button[name=box_thongke_du_an_close]', function (e) {
        $('.box_pop_congviec_du_an').hide();
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_giaoviec_tructiep_giao .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_giaoviec_tructiep_giao .li_phantrang').removeClass('active');
        $('#phantrang_giaoviec_tructiep_giao .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_list_giaoviec_tructiep_giao',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {

                    // 🔥 clear timer trước khi render DOM mới
                    if (typeof DeadlineCountdown !== 'undefined') {
                        DeadlineCountdown.stopAll();
                    }
            
                    $('#list_giaoviec_giao').html(info.list);
            
                    initDeadlineCountdown('#list_giaoviec_giao');
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_giaoviec_tructiep_nhan .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_giaoviec_tructiep_nhan .li_phantrang').removeClass('active');
        $('#phantrang_giaoviec_tructiep_nhan .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_list_giaoviec_tructiep_nhan',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {

                    // 🔥 clear timer trước khi render DOM mới
                    if (typeof DeadlineCountdown !== 'undefined') {
                        DeadlineCountdown.stopAll();
                    }
            
                    $('#list_giaoviec_nhan').html(info.list);
            
                    initDeadlineCountdown('#list_giaoviec_nhan');
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_giaoviec_tructiep_giamsat .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_giaoviec_tructiep_giamsat .li_phantrang').removeClass('active');
        $('#phantrang_giaoviec_tructiep_giamsat .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_list_giaoviec_tructiep_giamsat',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    if (info.ok == 1) {

                        // 🔥 clear timer trước khi render DOM mới
                        if (typeof DeadlineCountdown !== 'undefined') {
                            DeadlineCountdown.stopAll();
                        }
                
                        $('#list_giaoviec_giamsat').html(info.list);
                
                        initDeadlineCountdown('#list_giaoviec_giamsat');
                    }
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_lichsu_giaoviec .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_lichsu_giaoviec .li_phantrang').removeClass('active');
        $('#phantrang_lichsu_giaoviec .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_list_lichsu_giaoviec',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_lichsu_giaoviec').html(info.list);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_list_du_an .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_list_du_an .li_phantrang').removeClass('active');
        $('#phantrang_list_du_an .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_danhsach_du_an',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_du_an').html(info.list);
                }
            }
        });
    });
    ////////////////////////////
    $('body').on('click', '#phantrang_lichsu_du_an .li_phantrang', function () {
        page = $(this).attr('page');
        $('#phantrang_lichsu_du_an .li_phantrang').removeClass('active');
        $('#phantrang_lichsu_du_an .li_phantrang[page="' + page + '"]').not(':has(i)').addClass('active');

        $.ajax({
            url: "/members/process.php",
            type: "post",
            data: {
                action: 'load_list_lichsu_du_an',
                page: page
            },
            success: function (kq) {
                var info = JSON.parse(kq);
                if (info.ok == 1) {
                    $('#list_lichsu_du_an').html(info.list);
                }
            }
        });
    });
    ////////////////////////////
    socket.on("server_send_hoatdong", function (data) {
            var info = JSON.parse(data);
            var user_id = $('input[name=user_id]').val();
            // console.log(user_id);
            if(info.hd == 'load_du_an'){
                var arr_nhanvien = info.list_nhanvien.split(',');
                
                // Xử lý từng nhân viên
                arr_nhanvien.forEach(function(nhanvien_id) {
                    if(nhanvien_id.trim() == user_id){
                        $.ajax({
                            url: "/members/process.php",
                            type: "post",
                            data: {
                                action: 'load_form_du_an',
                                list_nhanvien: nhanvien_id.trim(),
                                id: info.id
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                if(info.ok == 1){
                                    $('.table_du_an').html(info.list);
                                    $('.header_title_du_an').html(info.total_du_an);
                                    $('.icon_notification').html(info.total_chuadoc);

                                }
                            }
                        });
                    }
                });
            }else if (info.hd == 'load_congviec_du_an') {
                var arr_nhanvien = info.list_nhanvien.split(',');
                arr_nhanvien.forEach(function(nhanvien_id) {
                    if(nhanvien_id.trim() == user_id){
                        $.ajax({
                            url: "/members/process.php",
                            type: "post",
                            data: {
                                action: 'load_form_congviec_du_an',
                                nhanvien_id: nhanvien_id.trim(),
                                id: info.id
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                if(info.ok == 1){
                                    $('.table_du_an').html(info.list);
                                    $('#status_trang_thai').html(info.trang_thai_text);
                                    $('.deadline_list').html(info.list_nhanviec);
                                    $('.box_pop_view_congviec_du_an_actions_right').html(info.footer_action);
                                    $('.table_lichsu_baocao').html(info.list_lichsu_baocao);
                                    $('.table_lichsu_giahan').html(info.list_lichsu_giahan);
                                    $('#status_trang_thai_du_an').html(info.trang_thai_du_an);
                                    $('.icon_notification').html(info.total_chuadoc);

                                }
                            }
                        });
                    }
                });

            }else if (info.hd == 'load_thongbao') {
                        $.ajax({
                            url: "/members/process.php",
                            type: "post",
                            data: {
                                action: 'load_thongbao',
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                if(info.ok == 1){
                                    $('.icon_notification').html(info.total_chuadoc);
                                }
                            }
                        });
            }else if (info.hd == 'load_giaoviec_tructiep') {
                if (info.nguoi_nhan == user_id) {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: 'load_form_giaoviec_nhan',
                            nguoi_nhan: info.nguoi_nhan,
                            id: info.id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.table_giaoviec_nhan').html(info.list);
                            $('.header_title_nhan').html(info.total_giaoviec);
                            $('#status_trang_thai').html(info.trang_thai_text);
                            $('.box_pop_view_giaoviec_actions_right').html(info.footer_action);
                            $('.table_lichsu_baocao').html(info.list_lichsu_baocao);
                            $('.table_lichsu_giahan').html(info.list_lichsu_giahan);
                            $('.icon_notification').html(info.total_chuadoc);
                            initDeadlineCountdown('.table_giaoviec_nhan');

                        }
                    });
                }
                if (info.nguoi_giamsat == user_id) {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: 'load_form_giaoviec_giamsat',
                            nguoi_giamsat: info.nguoi_giamsat,
                            id: info.id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.table_giaoviec_giamsat').html(info.list);
                            $('.header_title_giamsat').html(info.total_giaoviec);
                            $('#status_trang_thai').html(info.trang_thai_text);
                            $('.table_lichsu_baocao').html(info.list_lichsu_baocao);
                            $('.table_lichsu_giahan').html(info.list_lichsu_giahan);
                            $('.icon_notification').html(info.total_chuadoc);
                            initDeadlineCountdown('.table_giaoviec_giamsat');

                        }
                    });
                }
                if (info.nguoi_giao == user_id) {
                    $.ajax({
                        url: "/members/process.php",
                        type: "post",
                        data: {
                            action: 'load_form_giaoviec_giao',
                            nguoi_giao: info.nguoi_giao,
                            id: info.id
                        },
                        success: function (kq) {
                            var info = JSON.parse(kq);
                            $('.table_giaoviec').html(info.list);
                            $('.header_title_giao').html(info.total_giaoviec);
                            $('#status_trang_thai').html(info.trang_thai_text);
                            $('.table_lichsu_baocao').html(info.list_lichsu_baocao);
                            $('.table_lichsu_giahan').html(info.list_lichsu_giahan);
                            $('.icon_notification').html(info.total_chuadoc);
                            initDeadlineCountdown('.table_giaoviec');

                        }
                    });
                }
            }else if (info.hd == 'load_list_giaoviec_tructiep') {
                var arr_nhanvien = info.list_nhanvien.split(',');
                arr_nhanvien.forEach(function(nhanvien_id) {
                    if(nhanvien_id.trim() == user_id){
                        var current_url = window.location.href;
                        var page_type = '';
                        if (current_url.indexOf('list-congviec-quanly') > -1) {
                            page_type = 'list-congviec-quanly';
                        } else if (current_url.indexOf('list-congviec-cua-toi') > -1) {
                            page_type = 'list-congviec-cua-toi';
                        } else if (current_url.indexOf('list-congviec-giamsat') > -1) {
                            page_type = 'list-congviec-giamsat';
                        }
                        $.ajax({
                            url: "/members/process.php",
                            type: "post",
                            data: {
                                action: 'load_list_giaoviec_tructiep',
                                list_nhanvien: info.list_nhanvien,
                                page_type: page_type
                            },
                            success: function (kq) {
                                var info = JSON.parse(kq);
                                if(info.ok == 1){
                                    if (info.page_type == 'list-congviec-cua-toi') {
                                        $('.table_giaoviec_nhan').html(info.list);
                                        $('.header_title_nhan').html(info.total_giaoviec);
                                    }
                                    if (info.page_type == 'list-congviec-giamsat') {
                                        $('.table_giaoviec_giamsat').html(info.list);
                                        $('.header_title_giamsat').html(info.total_giaoviec);
                                    }
                                    if (info.page_type == 'list-congviec-quanly') {
                                        $('.table_giaoviec').html(info.list);
                                        $('.header_title_giao').html(info.total_giaoviec);
                                    }
                                    $('.icon_notification').html(info.total_chuadoc);

                                }
                            }
                        });
                    }
                });
            }else if (info.hd == 'load_giahan') {
                $.ajax({
                    url: "/members/process.php",
                    type: "post",
                    data: {
                        action: 'load_giahan',
                        id: info.id,
                        type: info.type
                    },
                    success: function (kq) {
                        var info = JSON.parse(kq);
                        if(info.ok == 1){
                            $('#han_hoan_thanh').html(info.list);
                        }
                    }
                });
            }
        });
    ////////////////////////////
});
