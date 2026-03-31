{header}
<body class="body_scroll body_index">
    {box_header}
    <link rel="stylesheet" href="/aos/aos.css" />
	<link rel="stylesheet" href="/carousel/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="/carousel/assets/owl.theme.default.min.css">
    <div class="top_home">
        <div class="top_home_container">
            <div class="top_home_left" data-aos="fade-down" data-aos-duration="1000">
                <div>
                    <h1>KẾT NỐI VẬN CHUYỂN</h1>
                    <p>Là nền tảng kết nối giữa đơn vị có nhu cầu vận chuyển và bên vận chuyển. Ngoài ra nền tảng còn hỗ trợ tối ưu hóa việc kết hợp container rỗng từ đó tiết kiệm chi phí và gia tăng lợi nhuận vận chuyển..</p>
                    <button id="to_contact">Liên hệ tư vấn</button>
                </div>
            </div>
            <div class="top_home_right" data-aos="fade-down" data-aos-duration="1000">
                <img src="/skin/css/images/illusweb.png">
            </div>
        </div>
    </div>
    <div class="box_timkiem">
        <div class="box_timkiem_container" data-aos="fade-up" data-aos-duration="1000">
            <div class="form_timkiem">
                <div class="li_input">
                    <div class="text">Loại hình</div>
                    <div class="select">
                        <select name="loai_hinh">
                            <option value="">Chọn loại hình</option>
                            <option value="hangxuat">Hàng xuất</option>
                            <option value="hangnhap">Hàng nhập</option>
                        </select>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Hãng tàu</div>
                    <div class="select">
                        <input type="text" name="hang_tau" placeholder="Hãng tàu">
                        <input type="hidden" name="hang_tau_id">
                        <div class="list_goiy list_goiy_hangtau">{list_goiy_hangtau}</div>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Loại container</div>
                    <div class="select">
                        <select name="loai_container">
                            <option value="">Chọn loại container</option>
                            {option_container}
                        </select>
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Thời gian</div>
                    <div class="list_time">
                        <input type="text" name="from" placeholder="Từ" class="datepicker">
                        <input type="text" name="to" placeholder="Đến" class="datepicker">
                    </div>
                </div>
                <div class="li_input">
                    <div class="text">Đia điểm</div>
                    <div class="select">
                        <input type="text" name="dia_diem" placeholder="Địa điểm">
                        <input type="hidden" name="dia_diem_id">
                        <div class="list_goiy list_goiy_tinh">{list_goiy_tinh}</div>
                    </div>
                </div>
                <div class="button_search">
                    <button name="timkiem_booking"><i class="fa fa-search"></i> Tìm kiếm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="box_hieuqua">
        <div class="box_hieuqua_content"  data-aos="fade-up" data-aos-duration="1000">
            <div class="title_box"><i class="fa fa-th-large"></i> Booking đang chờ chạy</div>
            <div class="list_tab">
                <div class="li_tab active" id="tab_hangnhap">Hàng nhập</div>
                <div class="li_tab" id="tab_hangxuat">Hàng xuất</div>
                <button class="create_booking">Thêm booking mới</button>
            </div>
            <div class="list_tab_content">
                <div class="li_tab_content active" id="tab_hangnhap_content">
                    <div class="box_table">
                        <table class="table_hang" style="width: 100%;">
                            <tr>
                                <th width="120">Hãng tàu</th>
                                <th width="120">Loại container</th>
                                <th width="80">Số lượng</th>
                                <th width="120">Mặt hàng</th>
                                <th>Địa điểm trả hàng</th>
                                <th width="150">Thời gian trả hàng</th>
                                <th width="150">Cước vận chuyển</th>
                                <th width="130" class="sticky-column">Hành động</th>
                            </tr>
                            {list_hangnhap}
                        </table>
                    </div>
                    <div class="more" style="{display_hangnhap}"><a href="/members/dashboard"><button>Xem thêm <i class="fa fa-angle-double-down"></i></button></a></div>
                </div>
                <div class="li_tab_content" id="tab_hangxuat_content">
                    <div class="box_table">
                        <table class="table_hang" style="width: 100%;">
                            <tr>
                                <th width="120">Hãng tàu</th>
                                <th width="120">Loại container</th>
                                <th width="80">Số lượng</th>
                                <th width="120">Mặt hàng</th>
                                <th>Địa điểm đóng hàng</th>
                                <th width="150">Thời gian đóng hàng</th>
                                <th width="150">Cước vận chuyển</th>
                                <th width="130" class="sticky-column">Hành động</th>
                            </tr>
                            {list_hangxuat}
                        </table>
                    </div>
                    <div class="more" style="{display_hangnhap}"><a href="/members/dashboard"><button>Xem thêm <i class="fa fa-angle-double-down"></i></button></a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box_toiuu">
        <div class="box_toiuu_container">
            <div class="title_box"><span style="color: #0062a0!important" data-aos="fade-up" data-aos-duration="1000">LỢI ÍCH CỦA NỀN TẢNG</span></div>
            <div class="desc" data-aos="fade-down" data-aos-duration="1000">Nền tảng kết nối giữa các doanh nghiệp với nhau để chia sẻ nguồn lực, mở rộng mạng lưới khách hàng và tiết kiệm tối đa chi phí.</div>
            <div class="list_toiuu" data-aos="fade-up" data-aos-duration="1000">
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_hieuqua.png">
                    </div>
                    <div class="tieude_toiuu">TỐI ƯU NGUỒN LỰC CONTAINER</div>
                    <div class="mota_toiuu">
                        Cho phép các doanh nghiệp tái sử dụng tức thì container đã nhập khẩu cho đơn hàng xuất khẩu.
                    </div>
                </div>
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_caodiem.png">
                    </div>
                    <div class="tieude_toiuu">KẾT NỐI VỚI CÁC ĐƠN VỊ VẬN CHUYỂN</div>
                    <div class="mota_toiuu">
                        Nền tảng giúp các đơn vị xuất khẩu tăng cường khả năng tìm kiếm, trao đổi container với các đơn vị vận tải khác
                    </div>
                </div>
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_chiphi.png">
                    </div>
                    <div class="tieude_toiuu">TỐI ƯU CHI PHÍ VẬN CHUYỂN</div>
                    <div class="mota_toiuu">
                        Chủ hàng luôn tìm được người vận chuyển uy tín với giá tốt nhất trên thị trường. Nhà xe có cơ hội tiếp cận với những đơn hàng liên tục mà không lo xe chạy rỗng, chi phí được thanh toán ngay khi đơn hàng kết thúc
                    </div>
                </div>
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_tau.png">
                    </div>
                    <div class="tieude_toiuu">GIẢM THIỂU ÙN TẮC</div>
                    <div class="mota_toiuu">
                        Việc kết hợp xe container sẽ làm giảm số lượng xe ra / vào cảng dẫn đến giảm thiểu ùn tắc tại các cảng /depot
                    </div>
                </div>
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_vo.png">
                    </div>
                    <div class="tieude_toiuu">GIẢM THIỂU TÌNH TRẠNG THIẾU VỎ CONTAINER</div>
                    <div class="mota_toiuu">
                        Việc tái sử dụng container rỗng 2 chiều sẽ tăng hiệu quả sử dụng và cải thiện tình trạng thiếu vỏ container trên thị trường hiện nay.
                    </div>
                </div>
                <div class="li_toiuu" data-aos="flip-right" data-aos-duration="1000">
                    <div class="icon_toiuu">
                        <img src="/skin/css/images/icon_co2.png">
                    </div>
                    <div class="tieude_toiuu">GIẢM TẢI LƯỢNG KHÍ THẢI CARBON</div>
                    <div class="mota_toiuu">
                        Tham gia cùng các chủ hàng và hãng vận chuyển cam kết loại bỏ chất thải carbon từ dặm trống. Cùng nhau, chúng ta đang giúp ngành công nghiệp vận chuyển có trách nhiệm.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box_hangtau">
        <div class="box_hangtau_container">
            <div class="title_box" data-aos="fade-up" data-aos-duration="1000">Các hãng tàu đối tác</div>
            <div class="list_hangtau owl-carousel"  data-aos="fade-up" data-aos-duration="1000">
            	{list_hangtau}
            </div>
        </div>
    </div>
    <div class="box_khachhang">
        <div class="box_khachhang_container">
            <div class="title_box" data-aos="fade-down" data-aos-duration="1000">Khách hàng của chúng tôi</div>
            <div class="list_khachhang" data-aos="fade-up" data-aos-duration="1000">
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-vija.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">VIJA GROUP</div>
                        <div class="tieu_de">Tập đoàn thép Việt Nhật</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-panasonic.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">PANASONIC</div>
                        <div class="tieu_de">Tập đoàn Panasonic Holdings</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-toshiba.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">TOSHIBA</div>
                        <div class="tieu_de">Tập đoàn Toshiba</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-casper.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">CASPER</div>
                        <div class="tieu_de">Casper Electric Vietnam</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-nitori.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">NITORI</div>
                        <div class="tieu_de">NITORI Co. Ltd</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
                <div class="li_khachhang" data-aos="flip-left" data-aos-duration="1000">
                    <div class="logo_khach">
                        <img src="/skin/css/images/logo-canon.png">
                    </div>
                    <div class="info_khach">
                        <div class="brand">CANON</div>
                        <div class="tieu_de">Canon Vietnam</div>
                        <div class="mo_ta">Cùng hợp tác phát triển và phát triển lâu dài</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box_lienhe" data-aos="fade-up">
        <div class="box_lienhe_container">
            <div class="title_box" data-aos="fade-up" data-aos-duration="1000">KNVC luôn lắng nghe</div>
            <div class="list_box_lienhe">
                <div class="li_box_lienhe" data-aos="flip-up" data-aos-duration="1000">
                    <div class="tieu_de">
                        <div class="icon_lienhe"><img src="/skin/css/images/icon_hotline.png"></div>Hotline
                    </div>
                    <div class="mo_ta">
                        Chăm sóc khách hàng: 0962.892.486<br>
                        Hoạt động 365 ngày/năm từ 7:00 đến 22:00 kể cả ngày nghỉ lễ, tết.
                    </div>
                </div>
                <div class="li_box_lienhe" data-aos="flip-up" data-aos-duration="1000">
                    <div class="tieu_de">
                        <div class="icon_lienhe"><img src="/skin/css/images/icon_zalo.png"></div>KNVC Zalo
                    </div>
                    <div class="mo_ta">
                        Luôn trả lời các thông tin nhanh nhất thông qua các phản hồi trên Zalo.
                    </div>
                </div>
                <div class="li_box_lienhe" data-aos="flip-up" data-aos-duration="1000">
                    <div class="tieu_de">
                        <div class="icon_lienhe"><img src="/skin/css/images/icon_chat.png"></div>Chat trên web & mobile
                    </div>
                    <div class="mo_ta">
                        Luôn có người trực chat để trả lời câu hỏi của các bạn nhanh và hiệu quả nhất suốt 365 ngày/năm.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box_contact" data-aos="fade-down">
        <div class="box_contact_container">
            <div class="box_img" data-aos="flip-right" data-aos-duration="1000">
                <img src="/skin/css/images/contact.png">
            </div>
            <div class="form_contact" data-aos="flip-left" data-aos-duration="1000">
                <div class="title_box">Hãy để KNVC được hỗ trợ bạn</div>
                <div class="li_input">
                    <input type="text" name="ho_ten" placeholder="Họ và tên*" autocomplete="off">
                </div>
                <div class="li_input">
                    <input type="text" name="email" placeholder="Email*" autocomplete="off">
                </div>
                <div class="li_input">
                    <input type="text" name="dien_thoai" placeholder="Số điện thoại*" autocomplete="off">
                </div>
                <div class="li_input">
                    <textarea placeholder="Nội dung cần hỗ trợ" name="noi_dung" autocomplete="off"></textarea>
                </div>
                <div class="li_input">
                    <button name="dangky_nhantin">Đăng ký nhận thông tin yêu cầu tư vấn</button>
                </div>
            </div>
        </div>
    </div>
    {footer}
    {script_footer}
    <script src="/aos/aos.js"></script>
    <script>
      AOS.init({
        easing: 'ease-in-out-sine'
      });
    </script>
    <script src="/carousel/owl.carousel.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$('.owl-carousel').owlCarousel({
			    loop:true,
			    margin:10,
			    nav:false,
			    autoplay:true,
			    autoplayTimeout:3000,
			    autoplayHoverPause:true,
			    responsive:{
			        0:{
			            items:1
			        },
			        600:{
			            items:2
			        },
			        1000:{
			            items:4
			        }
			    }
			})
		});
    </script>    
</body>

</html>