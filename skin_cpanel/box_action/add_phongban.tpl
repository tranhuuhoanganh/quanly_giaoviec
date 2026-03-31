<div class="box_right">
    <div class="box_phongban_right_content">
        <div class="box_container">
            <div class="box_container_left box-container-left-custom">
                <!-- Phần 1: Form thêm sơ đồ -->
                
                
                <div class="box_form box-form-custom">
                    <div class="form-header">
                        <h3 class="form-title">THIẾT KẾ SƠ ĐỒ CƠ CẤU TỔ CHỨC</h3>
                       
                    </div>
                    
                    <div class="list_tab_content">
                        <div class="li_tab_content active">
                            <div class="li_input">
                                <label class="form-label">Phân cấp Nhân sự</label>
                                <select name="phan_cap" id="phan_cap" class="form-select">
                                    {list_phan_cap}

                                </select>
                            </div>
                            
                            <div class="li_input li-input-spacing-20">
                                <label class="form-label">Cấp nhân sự</label>
                                <input type="text" name="cap_nhan_su" id="cap_nhan_su" placeholder="Ví dụ: Tổng giám đốc hoặc General Director/CEO" 
                                       class="form-input" autocomplete="off">
                            </div>
                            
                            <div class="list_button list-button-spacing">
                                <button name="add_phongban" id="add_so_do" class="form-button-primary">
                                    <i class="fa fa-plus"></i> Thêm sơ đồ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Phần 2: Hiển thị sơ đồ nhân sự -->
                <div class="section-box">
                    <h3 class="form-title">Sơ Đồ Nhân Sự</h3>
                    
                    <div id="so_do_nhan_su" class="so-do-nhan-su">
                        <!-- Dữ liệu mẫu -->
                        {list_phongban}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


