function scrollSmoothToBottom (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 200);
}
var socket =io("https://chat.socdo.vn");
//var socket =io("https://chat.kaizendms.com");
////////////////////
function smile(str){
	str=str.replace(/&nbsp;/g,' ');
	str=str.replace(/:\)/g,'<img src="/images/smile/default/0.gif">');
	str=str.replace(/:\(/g,'<img src="/images/smile/default/15.gif">');
	str=str.replace(/:p/g,'<img src="/images/smile/default/12.gif">');
	str=str.replace(/<3/g,'<img src="/images/smile/default/66.gif">');
	str=str.replace(/\(y\)/g,'<img src="/images/smile/default/79.gif">');
	str=str.replace(/:’\(/g,'<img src="/images/smile/default/9.gif">');
	str=str.replace(/:3/g,'<img src="/images/smile/default/21.gif">');
	str=str.replace(/3:\)|3:-\)/g,'<img src="/images/smile/default/37.gif">');
	str=str.replace(/:-\(|:\(|:\[|=\(/g,'<img src="/images/smile/default/15.gif">');
	str=str.replace(/:-O|:O|:-o|:o/g,'<img src="/images/smile/default/22.gif">');
	str=str.replace(/8-\)|8\)|B-\)|B\)/g,'<img src="/images/smile/default/16.gif">');
	str=str.replace(/:-D|:D|=D/g,'<img src="/images/smile/default/13.gif">');
	str=str.replace(/>:\(|>:-\(/g,'<img src="/images/smile/default/19.gif">');
	str=str.replace(/\^_\^/g,'<img src="/images/smile/default/6.gif">');
	str=str.replace(/\:-\*|\:\*/g,'<img src="/images/smile/default/65.gif">');
	str=str.replace(/:v/g,'<img src="/images/smile/default/28.gif">');
	return str;
}
////////////////////
socket.on("server_send_chating",function(data){
	text=$('input[name=user_chating]').val();
	user_out=$('input[name=user_out]').val();
	token=$('input[name=token]').val();
	id_time=$('input[name=content_sms]').attr('user_id');
	var info=JSON.parse(data);
	if(user_out==info.user_out){
		user_in=info.user_in;
	}else{
		user_in=info.user_out;
	}
	if(user_out==info.user_in){
		if(info.user_out==id_time){
			name=$('.main_user_inbox_content_title_name').html();
			$('.sms_typing').show();
			$('.sms_typing').html(name+' '+text);
		}else{
			name=$('#box_chat_'+user_in+' .box_chat_top .box_chat_top_name span').html();
			$('#box_chat_'+user_in+' .chating').show();
			$('#box_chat_'+user_in+' .chating').html(name+' '+text);
		}
	}
});
////////////////////
socket.on("server_send_stop_chat",function(data){
	var info=JSON.parse(data);
	user_out=$('input[name=user_out]').val();
	token=$('input[name=token]').val();
	id_time=$('input[name=content_sms]').attr('user_id');
	if(user_out==info.user_out){
		user_in=info.user_in;
	}else{
		user_in=info.user_out;
	}
	$('#box_chat_'+user_in+' .chating').hide();
	$('#box_chat_'+user_in+' .chating').html('');
	if(id_time==info.user_out){
		$('.sms_typing').hide();
		$('.sms_typing').html('');
	}
});
////////////////////
socket.on("server_send_online",function(data){
/*	data.forEach(function(i){
		if($('.status_online_'+i).length>0){
			$('.status_online_'+i).removeClass('offline');
			$('.status_online_'+i).addClass('online');
			$('.status_online_'+i).html('online');
		}
		if($('.box_chat_top_online_'+i).length>0){
			$('.box_chat_top_online_'+i).removeClass('offline');
			$('.box_chat_top_online_'+i).addClass('online');
		}
		//j('#li_ask_post_content').append(i+'<br>');
		//alert(i);
	});*/
/*	$.get('/process.php?action=get_online',
	function(kq){
		var info=JSON.parse(kq);
		if(info.online==null){

		}else{
			info.online.forEach(function(text,i){
				if($('.status_online_'+text).length>0){
					$('.status_online_'+text).removeClass('offline');
					$('.status_online_'+text).addClass('online');
					$('.status_online_'+text).html('online');
				}
				if($('.box_chat_top_online_'+text).length>0){
					$('.box_chat_top_online_'+text).removeClass('offline');
					$('.box_chat_top_online_'+text).addClass('online');
				}

			});
		}
		if(info.offline==null){
		}else{
			info.offline.forEach(function(text,k){
				if($('.status_online_'+text).length>0){
					$('.status_online_'+text).removeClass('online');
					$('.status_online_'+text).addClass('offline');
					$('.status_online_'+text).html('offline');
				}
				if($('.box_chat_top_online_'+text).length>0){
					$('.box_chat_top_online_'+text).removeClass('online');
					$('.box_chat_top_online_'+text).addClass('offline');
				}
			});
		}
	});*/
});
////////////////////
socket.on("server_send_offline",function(data){
	$('.status_online_'+data).removeClass('online');
	$('.status_online_'+data).addClass('offline');
	$('.status_online_'+data).html('offline');
	$('.box_chat_top_online_'+data).removeClass('online');
	$('.box_chat_top_online_'+data).addClass('offline');
});
////////////////////
socket.on("server_send_chat",function(data){
	user_out=$('input[name=user_out]').val();
	var info=JSON.parse(data);
	sms_out=info.sms_out.replace(/\\/g,'');
	sms_in=info.sms_in.replace(/\\/g,'');
	id_time=$('input[name=content_sms]').attr('user_id');
/*	if(info.user_in==user_out){
		$.get('/process.php?action=get_notice',
		function(ok){
			no=JSON.parse(ok);
			$('#icon_mess_header .number_note').html(no.sms);
			$('#icon_friend_header .number_note').html(no.friend);
			$('#icon_note_header .number_note').html(no.notice);
		});
	}else{

	}*/
	if(user_out==info.user_in){
		if(info.user_out==id_time){
			last=$('.main_user_inbox_content_chat_text .li_sms').last().attr("value");
			avatar=$('.avatar_info img').attr("src");
			username=$('.main_user_inbox_content_title_name').html();
			if(last=='sms_out'){
				$('.main_user_inbox_content_chat_text').append('<div class="li_sms_in_first li_sms" value="sms_in_first"><div class="li_sms_in_first_avatar"><a href="'+username+'"><img src="'+avatar+'" onerror="this.src=\'./images/no-avatar.png\';"></a></div><div class="li_sms_in_first_content">'+sms_out+'</div></div>');
			}else{
				$('.main_user_inbox_content_chat_text').append('<div class="li_sms_in li_sms" value="sms_in"><div class="li_sms_in_content">'+sms_out+'</div></div>');
			}
			$('.sms_typing').hide();
			scrollSmoothToBottom('main_user_inbox_content_chat_text');
		}else{
			if(user_out==info.user_in){
				last=$('#box_chat_'+info.user_out+' .box_chat_midle .li_sms').last().attr("value");
				avatar=$('#box_chat_'+info.user_out).attr("avatar");
				username=$('#box_chat_'+info.user_out).attr("username");
				if(last=='sms_out'){
					$('#box_chat_'+info.user_out+' .box_chat_midle').append('<div class="li_sms_in_first li_sms" value="sms_in_first"><div class="li_sms_in_first_avatar"><a href="'+username+'"><img src="'+avatar+'" onerror="this.src=\'./images/no-avatar.png\';"></a></div><div class="li_sms_in_first_content">'+sms_out+'</div></div>');
				}else{
					$('#box_chat_'+info.user_out+' .box_chat_midle').append('<div class="li_sms_in li_sms" value="sms_in"><div class="li_sms_in_content">'+sms_out+'</div></div>');
				}
				$('.sms_typing').hide();
				scrollSmoothToBottom('box_chat_midle_'+info.user_out);
			}
		}
	}else{
	}
});
//////////////////
socket.on("get_notice",function(data){
	var x=JSON.parse(data);
	user_out=$('input[name=user_out]').val();
	if(x.user_online==user_out){
		$.get('/process.php?action=get_notice',
		function(ok){
			var info=JSON.parse(ok);
			$('#icon_mess_header .number_note').html(info.sms);
			$('#icon_friend_header .number_note').html(info.friend);
			$('#icon_note_header .number_note').html(info.notice);
		});
	}else{

	}
});
//////////////////
socket.on("server_send_notice",function(data){
	user_out=$('input[name=user_out]').val();
	var info=JSON.parse(data);
	if(info.user_id==user_out){
		$.get('/process.php?action=get_notice_cat&cat='+info.cat,
		function(ok){
			var no=JSON.parse(ok);
			if(no.cat=='sms'){
				$('#icon_mess_header .number_note').html(no.total);
			}else if(no.cat=='friend'){
				$('#icon_friend_header .number_note').html(no.total);
			}else if(no.cat=='note'){
				$('#icon_note_header .number_note').html(no.total);
			}else{
				
			}
		});
	}
});
//////////////////
socket.on("get_box_chat",function(data){
	token=$('input[name=token]').val();
	user_out=$('input[name=user_out]').val();
	var info=JSON.parse(data);
	length_box=$('#box_chat_'+info.user_out+':visible').length;
	num_box=$('.box_chat:visible').length;
	id_time=$('input[name=content_sms]').attr('user_id');
	if(id_time==info.user_out){		
	}else{
		if(length_box>0){		
		}else{
			if(user_out==info.user_in){
				if(num_box<4){
					if(length_box>0){		
					}else{
						if($('#box_chat_'+info.user_out).length>0){
							$('#box_chat_'+info.user_out).show();
						}else{
							$.get('/process.php?action=show_box_chat&id='+info.user_out+'&user_out='+info.user_in,
							function(ok){
								if(ok.length>10){
									$('.main_box_chat').append(ok);
									scrollSmoothToBottom('box_chat_midle_'+info.user_out);
									setTimeout(function(){
										$('#box_chat_midle_'+info.user_out).attr('loaded','1');
									},1000);
								}else{

								}
							});
						}
					}
				}else{
					if(length_box>0){		
					}else{
						first_box=$('.box_chat:visible').first();
						if(first_box.hasClass('active')==true){
							first_box.next('.box_chat:visible').hide();
						}else{
							first_box.hide();
						}
						if($('#box_chat_'+info.user_out).length>0){
							$('#box_chat_'+info.user_out).show();
						}else{
							$.get('/process.php?action=show_box_chat&id='+info.user_out+'&user_out='+info.user_in,
							function(ok){
								if(ok.length>10){
									$('.main_box_chat').append(ok);
									scrollSmoothToBottom('box_chat_midle_'+info.user_out);
									setTimeout(function(){
										$('#box_chat_midle_'+info.user_out).attr('loaded','1');
									},1000);
								}else{

								}
							});
						}
					}
				}
			}else{

			}
		}
	}
});
///////////////////
function sms_friend(id){
	user_out=$('input[name=user_out]').val();
	length_box=$('#box_chat_'+id+':visible').length;
	num_box=$('.box_chat:visible').length;
	if(num_box<4){
		if(length_box>0){		
		}else{
			if($('#box_chat_'+id).length>0){
				$('#box_chat_'+id).show();
			}else{
				$.get('/process.php?action=show_box_chat&id='+id+'&user_out='+user_out,
				function(data){
					if(data.length>10){
						$('.main_box_chat').append(data);
						scrollSmoothToBottom('box_chat_midle_'+id);
						setTimeout(function(){
							$('#box_chat_midle_'+id).attr('loaded','1');
						},1000);
					}else{

					}
				});
			}
		}
	}else{
		if(length_box>0){		
		}else{
			first_box=$('.box_chat:visible').first();
			if(first_box.hasClass('active')==true){
				first_box.next('.box_chat:visible').hide();
			}else{
				first_box.hide();
			}
			if($('#box_chat_'+id).length>0){
				$('#box_chat_'+id).show();
			}else{
				$.get('/process.php?action=show_box_chat&id='+id+'&user_out='+user_out,
				function(data){
					if(data.length>10){
						$('.main_box_chat').append(data);
						scrollSmoothToBottom('box_chat_midle_'+id);
						setTimeout(function(){
							$('#box_chat_midle_'+id).attr('loaded','1');
						},1000);
					}else{

					}
				});
			}
		}
	}
}
/////////////////////
function send_sms(){
	$('input[name=content_sms]').keypress(function(e){
		token=$('input[name=token]').val();
		text_send=$('input[name=text_send]').val();
		user_out=$('input[name=user_out]').val();
		noi_dung=$(this).val();
		id=$(this).attr('user_id');
		$('input[name=content_sms]').one("click", function () {
			j.ajax({
				url:'/process.php',
				type:'post',
				data:{
					action:'read_sms',
					id:id
				},
				success:function(){

				}
			});
		    //$( this ).off( event );
		});
		var dulieu={
			"token":token,
			"user_out":user_out,
			"user_in":id,
			"noi_dung":noi_dung
		}
		var info_chat=JSON.stringify(dulieu);
		last=$('.main_user_inbox_content_chat_text .li_sms').last().attr("value");
	    if(e.which == 13) {
	    	$('.sms_typing').show();
			$('.sms_typing').html(text_send);
	    	if(noi_dung!=''){
	    		$.get('/process.php?action=send_chat&user_in='+id+'&user_out='+user_out+'&token='+token+'&last='+last+'&noi_dung='+noi_dung,
					function(data){
						var info=JSON.parse(data);
						if(info.ok==true){
							$('.main_user_inbox_content_chat_text').append('<div class="li_sms_out li_sms" value="sms_out"><div class="li_sms_out_content">'+info.sms_in+'</div></div>');
							scrollSmoothToBottom('main_user_inbox_content_chat_text');
							socket.emit('user_send_chat',data);
							socket.emit('show_box_chat',data);
						}else{
							$('.sms_typing').show();
							$('.sms_typing').html(info.note);

						}
					}
				);
				setTimeout(function(){
					$('.sms_typing').hide();
					$('.sms_typing').html('');
				},1000);
	    		$('input[name=content_sms]').val('');
	    	}else{
	    		$('input[name=content_sms]').focus();
	    	}
	    	socket.emit('user_stop_chat',info_chat);
	    }else{
	    	socket.emit('user_chating',info_chat);
	    }

	});
}
///////////////////
function send_chat(id){
	$('#box_chat_'+id+' input[type=text]').keypress(function(e){
    	text_send=$('input[name=text_send]').val();
    	user_out=$('input[name=user_out]').val();
    	noi_dung=$('#box_chat_'+id+' input[type=text]').val();
		var dulieu={
			"user_out":user_out,
			"user_in":id,
			"noi_dung":noi_dung
		}
		var info_chat=JSON.stringify(dulieu);
		last=$('#box_chat_'+id+' .box_chat_midle .li_sms').last().attr("value");
	    if(e.which == 13) {
	    	$('#box_chat_'+id+' .chating').show();
			$('#box_chat_'+id+' .chating').html(text_send);
	    	if(noi_dung!=''){
	    		$.get('/process.php?action=send_chat&user_in='+id+'&user_out='+user_out+'&last='+last+'&noi_dung='+noi_dung,
					function(data){
						var info=JSON.parse(data);
						if(info.ok==true){
							$('#box_chat_'+id+' .box_chat_midle').append('<div class="li_sms_out li_sms" value="sms_out"><div class="li_sms_out_content">'+info.sms_in+'</div></div>');
							scrollSmoothToBottom('box_chat_midle_'+id);
							socket.emit('user_send_chat',data);
							socket.emit('show_box_chat',data);
						}else{
							$('#box_chat_'+id+' .chating').show();
							$('#box_chat_'+id+' .chating').html(info.note);

						}
					}
				);
				setTimeout(function(){
					$('#box_chat_'+id+' .chating').hide();
					$('#box_chat_'+id+' .chating').html('');
				},2000);
	    		$('#box_chat_'+id+' input[type=text]').val('');
	    	}else{
	    		$('#box_chat_'+id+' input[type=text]').focus();
	    	}
	    	socket.emit('user_stop_chat',info_chat);
	    }else{
	    	socket.emit('user_chating',info_chat);
	    }
	});
}
//////////////////////////////
function load_more_chat(id) {
    load = $('#box_chat_midle_' + id).attr('load');
    page = $('#box_chat_midle_' + id).attr('page');
    loaded = $('#box_chat_midle_' + id).attr('loaded');
    text_load_data = $('input[name=text_load_data]').val();
    sms_id = $('#box_chat_midle_' + id + ' .li_sms').first().attr('sms_id');
    if ($('#box_chat_midle_' + id).scrollTop() < 50 && loaded == 1 && load == 1) {
        length_load = $('#box_chat_midle_' + id).find('.loading_header').length;
        if (length_load > 0) {

        } else {
            page++;
            $('#box_chat_midle_' + id).attr('page', page);
            $('#box_chat_midle_' + id).prepend('<div class="loading_header" style="display: block;"><img src="./images/load.gif" width="50"><div class="text_load">' + text_load_data + '</div></div>');
            $.get('/process.php?action=load_more_sms&user=' + id + '&sms_id=' + sms_id + '&page=' + page,
                function(data) {
                    var info = JSON.parse(data);
                    if (info.load == '1') {
                        setTimeout(function() {
                            $('#box_chat_midle_' + id + ' .loading_header').remove();
                            $('#box_chat_midle_' + id).attr('load', info.load);
                            $('#box_chat_midle_' + id).prepend(info.list);
                            $('#box_chat_midle_' + id).scrollTop(200);
                        }, 2000);
                    } else {
                        $('#box_chat_midle_' + id).attr('load', info.load);
                        setTimeout(function() {
                            $('#box_chat_midle_' + id).prepend(info.list);
                            $('#box_chat_midle_' + id + ' .loading_header').remove();
                        }, 2000);
                    }
                });
        }
    } else {
        //alert('ko phai bottom');
    }
}
//////////////////////////////
function active_chat(id){
	$(".box_chat_top").removeClass("active");
	$('#box_chat_'+id).find(".box_chat_top").addClass("active");
	$('#box_chat_'+id).one("click", function () {
		$.ajax({
			url:'/process.php',
			type:'post',
			data:{
				action:'read_sms',
				id:id
			},
			success:function(){

			}
		});
	    //$( this ).off( event );
	});
}
//////////////
function close_chat(id){
	$('#box_chat_'+id).remove();
	length_box_hidden=$('.box_chat:hidden').length;
	if(length_box_hidden>0){
		$('.box_chat:hidden').last().show();
	}
}
//////////////
$(document).ready(function(){
	user_online=$('input[name=user_out]').val();
	var data_online={
		"user_online":user_online
	}
	var info_online=JSON.stringify(data_online);
	setTimeout(function(){
		socket.emit('user_online',info_online);
	},2000);
});