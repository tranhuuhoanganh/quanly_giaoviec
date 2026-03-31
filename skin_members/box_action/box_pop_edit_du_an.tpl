<div class="box_pop_edit_du_an">
    <div class="box_pop_edit_du_an_dialog">
        <div class="box_pop_edit_du_an_content">

            <div class="box_pop_edit_du_an_header">
                <div class="box_pop_edit_du_an_title_wrapper">
                    <h5 class="box_pop_edit_du_an_title">Chỉnh sửa dự án</h5>
                </div>
                <button type="button" class="box_pop_edit_du_an_close" aria-label="Đóng">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="box_pop_edit_du_an_body">
                <form id="form_edit_du_an" autocomplete="off">
                    <input type="hidden" name="id" value="{id}">
                    
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
                                        <input type="text" class="form_input" name="ten_du_an" id="ten_du_an_edit" value="{ten_du_an}" placeholder="Nhập tên dự án..." autocomplete="off">
                                    </div>
                                </div>
                                
                                <div class="form_group">
                                    <label class="form_label">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        Mức độ ưu tiên
                                    </label>
                                    <div class="input_wrapper">
                                        <select class="form_select" name="muc_do_uu_tien" id="muc_do_uu_tien_edit">
                                            <option value="binh_thuong" {selected_binh_thuong}>Bình thường</option>
                                            <option value="thap" {selected_thap}>Thấp</option>
                                            <option value="cao" {selected_cao}>Cao</option>
                                            <option value="rat_cao" {selected_rat_cao}>Rất cao</option>
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
                                        <textarea class="form_textarea" name="mo_ta_du_an" id="mo_ta_du_an_edit" rows="2" placeholder="Nhập mô tả chi tiết về dự án...">{mo_ta}</textarea>
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
                                        <textarea class="form_textarea" name="ghi_chu" id="ghi_chu_edit" rows="2" placeholder="Ghi chú bổ sung cho dự án...">{ghi_chu}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nhanvien_du_an" >
                        {list_nhanvien_du_an}
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form_actions">
                        <button type="button" class="btn_add_thanh_vien" name="add_thanh_vien_edit_du_an">
                            <i class="fa fa-users"></i>
                            Thêm thành viên
                        </button>
                        <button type="button" class="btn-cancel" name="close_box_pop_edit_du_an">Hủy</button>
                        <button type="button" class="btn_submit" name="edit_du_an">
                            <i class="fa fa-save"></i>
                            Cập nhật dự án
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="box_pop_delete" style="display: none;"></div>
<style>
/* Reset và base styles */
.box_pop_edit_du_an,
.box_pop_edit_du_an * {
    box-sizing: border-box;
}

.box_pop_edit_du_an {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Overlay modal */
.box_pop_edit_du_an {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: rgba(0, 0, 0, 0.6);
    z-index: 10000;
    backdrop-filter: blur(4px);
    animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Dialog container */
.box_pop_edit_du_an_dialog {
    width: 100%;
    max-width: 1200px;
    background: transparent;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Content card */
.box_pop_edit_du_an_content {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
}

/* Header */
.box_pop_edit_du_an_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
}

.box_pop_edit_du_an_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.box_pop_edit_du_an_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
}

.box_pop_edit_du_an_close {
    width: 32px;
    height: 32px;
    background: #f3f4f6;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.box_pop_edit_du_an_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
}

.box_pop_edit_du_an_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
}

.box_pop_edit_du_an_close:active {
    transform: scale(0.95);
}

/* Body */
.box_pop_edit_du_an_body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
}

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
.btn_submit,
.btn-cancel {
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
    margin-right: auto;
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

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
}

.btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-cancel:active {
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
    .box_pop_edit_du_an_body {
        padding: 16px;
    }
    
    .form_section {
        padding: 16px;
    }
    
    .form_row_2col {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form_actions {
        flex-direction: column-reverse;
    }
    
    .btn_add_thanh_vien,
    .btn_submit,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
    
    .btn_add_thanh_vien {
        margin-right: 0;
        order: 3;
    }
}
</style>

