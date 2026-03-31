function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
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
function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
}

function scrollSmoothToBottom(id) {
    var div = document.getElementById(id);
    $('#' + id).animate({
        scrollTop: div.scrollHeight - div.clientHeight
    }, 200);
}

function check_link() {
    link = $('.link_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_link",
                link: link
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

function check_blank() {
    link = $('.tieude_seo').val();
    if (link.length < 2) {
        $('.check_link').removeClass('ok');
        $('.check_link').addClass('error');
        $('.check_link').html('<i class="fa fa-ban"></i> Đường dẫn không hợp lệ');
    } else {
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_blank",
                link: link
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
$(document).ready(function() {
    var header = $("header");
    if($('.body_index').length>0){
        if ($(window).scrollTop() >= 60) {
            header.addClass('bg_header');
        }
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 60) {
                header.addClass("bg_header");
            } else {
                header.removeClass("bg_header");
            }
        });
    }else{
        header.addClass("bg_header");        
    }
    ////////////////////////////
    $('body').on('click','.chon_file',function(){
        $(this).parent().find('input[type=file]').click();
    });
    ////////////////////////////
    $('body').on('change','.khung_file input[type=file]',function(){
        var fileName = $(this).val().split('\\').pop(); // Lấy tên tệp từ đường dẫn
        $(this).parent().find('.file_name').text(fileName); // Hiển thị tên tệp
    });
    $('body').on('click','#to_contact',function(){
        var top_lienhe = $('.box_contact').offset().top;
        $('html,body').stop().animate({scrollTop:top_lienhe - 150}, 500, 'swing', function() { 
        });
    });
    $('body').on('click','.to_contact',function(){
        var top_lienhe = $('.box_contact').offset().top;
        $('html,body').stop().animate({scrollTop:top_lienhe - 150}, 500, 'swing', function() { 
        });
    });
    /////////////////////////////
    $('body').on('click','header .header_container .button_menu',function(){
        $('header .header_container .navbar').toggle();
    });
    $(document).click(function(e) {
        var dr = $("header .header_container .button_menu");
        // Nếu click bên ngoài .drop_menu
        if (!dr.is(e.target) && dr.has(e.target).length === 0) {
            if($(window).width()<768){
                $('header .header_container .navbar').hide();
            }
        }
    });
    /////////////////////////////
    $('body').on('click','footer .footer_container .li_col_footer .title_footer',function(){
        $(this).parent().find('.list_footer').toggle();
        $(this).toggleClass('up');
    });
    /////////////////////////////
    $('body').on('click','button.create_booking', function() {
        $.ajax({
            url: "/process.php",
            type: "post",
            data: {
                action: "check_login",
            },
            success: function(kq) {
                var info = JSON.parse(kq);
                if(info.ok==1){
                    window.location.href='/members/add-booking'
                }else{
                    $('.load_overlay').show();
                    $('.load_process_2').fadeIn();
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                    }, 2000);
                }
            }

        });
    });
    /////////////////////////////
    $('body').on('click','button[name=timkiem_booking]', function() {
        from = $('.box_timkiem input[name=from]').val();
        to = $('.box_timkiem input[name=to]').val();
        var loai_hinh = $('.box_timkiem select[name=loai_hinh]').val();
        hang_tau = $('.box_timkiem input[name=hang_tau_id]').val();
        loai_container = $('.box_timkiem select[name=loai_container]').val();
        dia_diem = $('.box_timkiem input[name=dia_diem]').val();
        dia_diem_id = $('.box_timkiem input[name=dia_diem_id]').val();
        if(loai_hinh==''){
            noti('Vui lòng chọn loại hình',0,2000);
        }else{
            $('.load_overlay').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/process.php",
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
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if(loai_hinh=='hangnhap'){
                                $('#tab_hangnhap').click();
                                $('#tab_hangnhap_content .table_hang').html(info.list);
                            }else if(loai_hinh=='hang_noidia'){
                                $('#tab_hang_noidia').click();
                                $('#tab_hang_noidia_content .table_hang').html(info.list);
                            }else{
                                $('#tab_hangxuat').click();
                                $('#tab_hangxuat_content .table_hang').html(info.list);
                            }
                        } else {
                        }
                    }, 2000);
                }

            });
        }
    });
    ////////////////////////////
    $('body').on('focus','.box_timkiem input[name=dia_diem]',function(){
        $(this).parent().find('.list_goiy').show();
    });
    ////////////////////////////
    $('body').on('click','.box_timkiem input[name=dia_diem]',function(){
        $(this).parent().find('.list_goiy').show();
    });
    ////////////////////////////
    $('body').on('keyup','.box_timkiem input[name=dia_diem]',function(){
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
    $('body').on('click','.box_timkiem .li_goiy_tinh',function(){
        ten_tinh=$(this).text();
        id_tinh=$(this).attr('value');
        $('.box_timkiem input[name=dia_diem]').val(ten_tinh);
        $('.box_timkiem input[name=dia_diem_id]').val(id_tinh);
        $('.box_timkiem .list_goiy_tinh').hide();
    });
    ////////////////////////////
    $('body').on('focus','.box_timkiem input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
    });
    ////////////////////////////
    $('body').on('click','.box_timkiem input[name=hang_tau]',function(){
        $(this).parent().find('.list_goiy').show();
    });
    ////////////////////////////
    $('body').on('keyup','.box_timkiem input[name=hang_tau]',function(){
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
    $('body').on('click','.box_timkiem .li_goiy_hangtau',function(){
        ten_hangtau=$(this).text();
        id_hang_tau=$(this).attr('value');
        $('.box_timkiem input[name=hang_tau]').val(ten_hangtau);
        $('.box_timkiem input[name=hang_tau_id]').val(id_hang_tau);
        $('.box_timkiem .list_goiy_hangtau').hide();
    });
    $(document).click(function(e) {
        if (!$('.box_timkiem input[name=hang_tau]').is(e.target) && $('.box_timkiem input[name=hang_tau]').has(e.target).length === 0) {
            $('.box_timkiem .list_goiy_hangtau').hide();
        }
        if (!$('.box_timkiem input[name=dia_diem]').is(e.target) && $('.box_timkiem input[name=dia_diem]').has(e.target).length === 0) {
            $('.box_timkiem .list_goiy_tinh').hide();
        }
    });
    $('body').on('click','.box_hieuqua .li_tab',function(){
        $('.box_hieuqua .li_tab').removeClass('active');
        $(this).addClass('active');
        id=$(this).attr('id');
        $('.box_hieuqua .li_tab_content').removeClass('active');
        $('.box_hieuqua #'+id+'_content').addClass('active');
    });
    ////////////////////////
    $('body').on('click','.list_tab_content .fa-long-arrow-up',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        itm.parent().find('i').removeClass('fa-long-arrow-up');
        itm.parent().find('i').addClass('fa-long-arrow-down');
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).hide();
        }else{
        }

    });
    ////////////////////////
    $('body').on('click','.list_tab_content .fa-long-arrow-down',function(){
        var itm=$(this);
        var id_container=$(this).attr('id_container');
        if($('.tr_more_'+id_container).length>0){
            $('.tr_more_'+id_container).show();
            itm.parent().find('i').removeClass('fa-long-arrow-down');
            itm.parent().find('i').addClass('fa-long-arrow-up');
        }else{
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "load_more_container",
                    id_container:id_container
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    if(info.ok==0){
                        $('.load_overlay').show();
                        $('.load_process_2').fadeIn();
                        setTimeout(function() {
                            $('.load_process_2 .load_note span').html(info.thongbao);
                        }, 1000);
                        setTimeout(function() {
                            $('.load_process_2').hide();
                            $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                            $('.load_overlay').hide();
                        }, 2000);
                    }else{
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
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
    $('body').on('click','button[name=dangky_taikhoan]',function(){
       
        ho_ten=$('.form_contact input[name=ho_ten]').val();
        dien_thoai=$('.form_contact input[name=dien_thoai]').val();
        email=$('.form_contact input[name=email]').val();
        password=$('.form_contact input[name=password]').val();
        re_password=$('.form_contact input[name=re_password]').val();

        if(ho_ten.length<3){
            $('.form_contact input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên của bạn',0,2000);
        }else if(dien_thoai.length<3){
            $('.form_contact input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại của bạn',0,2000);
        }else if(email.length<3){
            $('.form_contact input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        }else if(password.length<6){
            $('.form_contact input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu dài từ 6 ký tự',0,2000);
        }else if(re_password!=password){
            $('.form_contact input[name=re_password]').focus();
            noti('Nhập lại mật khẩu chưa khớp',0,2000);
        }else{

            $('.load_overlay').show();
            $('.load_process_2').fadeIn();

            $.ajax({
                url: '/process.php',
                type: 'POST',
                data: {
                    action: 'register',
                    ho_ten: ho_ten,
                    dien_thoai: dien_thoai,
                    email: email,
                    password: password,
                    re_password: re_password
                },
                success: function(kq){
                    var info = JSON.parse(kq);

                    setTimeout(function(){
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    },1000);

                    setTimeout(function(){
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();

                        if(info.ok == 1){
                            $('.hide_success').hide();
                            $('.show_success').show();
                            $('.email_address').html(info.email);
                        }
                    },2000);
                }
            });

        }

    });

    ////////////////////////
    $('body').on('click','button[name=dangky_nhantin]',function(){
        ho_ten=$('.form_contact input[name=ho_ten]').val();
        dien_thoai=$('.form_contact input[name=dien_thoai]').val();
        email=$('.form_contact input[name=email]').val();
        noi_dung=$('.form_contact textarea[name=noi_dung]').val();
        if(ho_ten.length<3){
            $('.form_contact input[name=ho_ten]').focus();
            noti('Vui lòng nhập họ và tên',0,2000);
        }else if(dien_thoai.length<3){
            $('.form_contact input[name=dien_thoai]').focus();
            noti('Vui lòng nhập số điện thoại',0,2000);
        }else if(email.length<3){
            $('.form_contact input[name=email]').focus();
            noti('Vui lòng nhập địa chỉ email',0,2000);
        }else{
            $('.load_overlay').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action: "dangky_nhantin",
                    ho_ten:ho_ten,
                    dien_thoai:dien_thoai,
                    email:email,
                    noi_dung:noi_dung
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if(info.ok==1){
                            $('.form_contact input[name=ho_ten]').val('');
                            $('.form_contact input[name=dien_thoai]').val('');
                            $('.form_contact input[name=email]').val('');
                            $('.form_contact textarea[name=noi_dung]').val('');
                        }
                    }, 2000);
                }
            });
        }

    });
    ////////////////////////
    function handleLogin() {
        email=$('.form_contact input[name=email]').val();
        password=$('.form_contact input[name=password]').val();
        ref=$('.form_contact input[name=ref]').val();
        if(email.length<3){
            $('.form_contact input[name=email]').focus();
            noti('Nhập địa chỉ email hoặc số điện thoại',0,2000);
        }else if(password.length<6){
            $('.form_contact input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu dài từ 6 ký tự',0,2000);
        }else{
            $('.load_overlay').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/process_login.php",
                type: "post",
                data: {
                    email:email,
                    password:password
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            if(ref.length>3){
                                window.location.href=ref;
                            }else{
                                window.location.href='/';
                            }
                        } else {
                        }
                    }, 2000);
                }
            });
        }
    }
    
    $('body').on('click','button[name=dangnhap_taikhoan]',function(){
        handleLogin();
    });
    
    // Thêm chức năng nhấn Enter để đăng nhập
    $('body').on('keypress','.form_contact input[name=email], .form_contact input[name=password]',function(e){
        if(e.which == 13){
            e.preventDefault();
            handleLogin();
        }
    });
    ////////////////////////
    $('body').on('click','button[name=save_password]',function(){
        re_password=$('.form_contact input[name=re_password]').val();
        password=$('.form_contact input[name=password]').val();
        email=$('.form_contact input[name=email]').val();
        token=$('.form_contact input[name=token]').val();
        if(password.length<6){
            $('.form_contact input[name=password]').focus();
            noti('Vui lòng nhập mật khẩu dài từ 6 ký tự',0,2000);
        }else if(password!=re_password){
            $('.form_contact input[name=re_password]').focus();
            noti('Nhập lại mật khẩu không khớp',0,2000);
        }else{
            $('.load_overlay').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action:'save_password',
                    email:email,
                    token:token,
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
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            window.location.href='/members/';
                        } else {
                        }
                    }, 2000);
                }
            });
        }

    });
    ////////////////////////
    $('body').on('click','button[name=quen_matkhau]',function(){
        email=$('.form_contact input[name=email]').val();
        if(email.length<3){
            $('.form_contact input[name=email]').focus();
            noti('Nhập địa chỉ email hoặc số điện thoại',0,2000);
        }else{
            $('.load_overlay').show();
            $('.load_process_2').fadeIn();
            $.ajax({
                url: "/process.php",
                type: "post",
                data: {
                    action:'quen_matkhau',
                    email:email,
                },
                success: function(kq) {
                    var info = JSON.parse(kq);
                    setTimeout(function() {
                        $('.load_process_2 .load_note span').html(info.thongbao);
                    }, 1000);
                    setTimeout(function() {
                        $('.load_process_2').hide();
                        $('.load_process_2 .load_note span').html('Hệ thống đang xử lý');
                        $('.load_overlay').hide();
                        if (info.ok == 1) {
                            $('.hide_success').hide();
                            $('.show_success').show();
                            $('.email_address').html(info.email);
                        } else {
                        }
                    }, 2000);
                }
            });
        }

    });
    ////////////////////////
    $("body").keydown(function(e) {
        if ($('.content_view_chap').length > 0) {
            if (e.keyCode == 37) {
                if ($('.link-prev-chap').length > 0) {
                    link = $('.link-prev-chap').attr('href');
                    window.location.href = link;

                }
            } else if (e.keyCode == 39) {
                if ($('.link-next-chap').length > 0) {
                    link = $('.link-next-chap').attr('href');
                    window.location.href = link;
                }
            }
        } else {

        }
    });
});

///////////////////////////////////
