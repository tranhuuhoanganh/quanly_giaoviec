<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%; margin: auto; box-shadow: none;">
                <div class="box_form">
                    <div class="list_tab_content">
                        <div class="li_tab_content active" id="tab_du_an_content">
                            <form id="form_add_du_an" autocomplete="off">
                                <!-- Section: Project Information -->
                                <div class="form_section">
                                    <div class="section_header">
                                        <h3 class="section_title">
                                            <i class="fa fa-info-circle"></i>
                                            Thông tin dự án
                                        </h3>
                                    </div>
                                    <div class="section_content">
                                        <!-- Row 1: Project Name and Priority Level -->
                                        <div class="form_row form_row_2col">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-sitemap"></i>
                                                    Tên dự án <span class="required">*</span>
                                                </label>
                                                <div class="input_wrapper">
                                                    <input type="text" class="form_input" name="ten_du_an" id="ten_du_an" placeholder="Nhập tên dự án..." autocomplete="off">
                                                </div>
                                            </div>
                                            
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    Mức độ ưu tiên
                                                </label>
                                                <div class="input_wrapper">
                                                    <select class="form_select" name="muc_do_uu_tien" id="muc_do_uu_tien">
                                                        <option value="binh_thuong" selected>Bình thường</option>
                                                        <option value="thap">Thấp</option>
                                                        <option value="cao">Cao</option>
                                                        <option value="rat_cao">Rất cao</option>
                                                    </select>
                                                    <i class="fa fa-chevron-down input_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Row 2: Project Description -->
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-bars"></i>
                                                    Mô tả dự án <span class="required">*</span>
                                                </label>
                                                <div class="textarea_wrapper">
                                                    <textarea class="form_textarea" name="mo_ta_du_an" id="mo_ta_du_an" rows="2" placeholder="Nhập mô tả chi tiết về dự án..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Row 3: Notes -->
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-sticky-note"></i>
                                                    Ghi chú
                                                </label>
                                                <div class="textarea_wrapper">
                                                    <textarea class="form_textarea" name="ghi_chu" id="ghi_chu" rows="2" placeholder="Ghi chú bổ sung cho dự án..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nhanvien_du_an" style="display: none;"></div>
                                <!-- Form Actions -->
                                <div class="form_actions">
                                    <button type="button" class="btn_add_thanh_vien" name="add_thanh_vien">
                                        <i class="fa fa-users"></i>
                                        Thêm thành viên
                                    </button>
                                    <button type="button" class="btn_submit" name="add_du_an">
                                        <i class="fa fa-plus"></i>
                                        Thêm dự án
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Section Styles */
.form_section {
    margin-bottom: 16px;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.form_section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #0062a0;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.form_section:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 98, 160, 0.15);
}

.form_section:hover::before {
    opacity: 1;
}

.section_header {
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.section_title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section_title i {
    color: #0062a0;
    font-size: 18px;
}

.section_content {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form_row {
    margin-bottom: 16px;
}

.form_row:last-child {
    margin-bottom: 0;
}

.form_row_2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form_group {
    display: flex;
    flex-direction: column;
}

.form_label {
    font-size: 14px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form_label i {
    color: #0062a0;
    font-size: 16px;
}

.required {
    color: #e53e3e;
    font-weight: 700;
    margin-left: 2px;
}

/* Input Wrapper */
.input_wrapper {
    position: relative;
}

.input_wrapper .input_icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    pointer-events: none;
    transition: color 0.3s ease;
}

.input_wrapper:focus-within .input_icon {
    color: #0062a0;
}

.textarea_wrapper {
    position: relative;
}

.form_input,
.form_select,
.form_textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #2d3748;
    background: #f7fafc;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form_input:focus,
.form_select:focus,
.form_textarea:focus {
    outline: none;
    border-color: #0062a0;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(0, 98, 160, 0.1);
    transform: translateY(-1px);
}

.form_input.error,
.form_select.error {
    border-color: #e53e3e;
    background: #fff5f5;
}

.form_textarea {
    resize: vertical;
    min-height: 120px;
    line-height: 1.7;
    padding-top: 12px;
}

.form_select {
    cursor: pointer;
    appearance: none;
    background-image: none;
}

/* Form Actions */
.form_actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    align-items: center;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
}


.btn_add_thanh_vien,
.btn_submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn_add_thanh_vien {
    background: #f3f4f6;
    color: #374151;
}

.btn_add_thanh_vien:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn_add_thanh_vien:active {
    transform: translateY(0);
}

.btn_submit {
    background: #0062A0;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 98, 160, 0.2);
}

.btn_submit:hover {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.3);
}

.btn_submit:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 98, 160, 0.2);
}



.btn_submit i,
.btn_add_thanh_vien i {
    font-size: 14px;
}



/* Error Message */
.error_message {
    margin-top: 8px;
    font-size: 13px;
    color: #e53e3e;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    background: #fff5f5;
    border-left: 2px solid #e53e3e;
    border-radius: 6px;
    animation: shake 0.5s ease;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.error_message i {
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .box_form {
        padding: 25px 20px;
    }
    
    .form_section {
        padding: 20px;
    }
    
    .form_row_2col {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form_actions {
        flex-direction: column-reverse;
    }
    
    .btn_add_thanh_vien,
    .btn_submit {
        width: 100%;
        justify-content: center;
    }
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}
</style>

 
