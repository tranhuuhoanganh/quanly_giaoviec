<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%; margin: auto; box-shadow: none;">
                <div class="box_form">
                    <div class="list_tab_content">
                        <div class="li_tab_content active" id="tab_giaoviec_content">
                            <form id="form_giaoviec_tructiep" autocomplete="off">
                                <!-- Section: Recipient and Supervisor -->
                                <div class="form_section">
                                    <div class="section_header">
                                        <h3 class="section_title">Thông tin người nhận</h3>
                                    </div>
                                    <div class="section_content" >
                                        <div class="form_row form_row_3col">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-building"></i>
                                                    Phòng ban nhận
                                                </label>
                                                <div class="input_wrapper">
                                                    <select class="form_select" name="phong_ban_nhan" id="phong_ban_nhan">
                                                        {option_phongban}
                                                    </select>
                                                    <i class="fa fa-chevron-down input_icon"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-user"></i>
                                                    Người nhận việc
                                                </label>
                                                <div class="input_wrapper">
                                                    <select class="form_select" name="nguoi_nhan" id="nguoi_nhan">

                                                    </select>
                                                    <i class="fa fa-chevron-down input_icon"></i>
                                                </div>
                                            </div>
                                            
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-user-shield"></i>
                                                    Người giám sát
                                                </label>
                                                <div class="input_wrapper">
                                                    <select class="form_select" name="nguoi_giam_sat" id="nguoi_giam_sat">
                                                    </select>
                                                    <i class="fa fa-chevron-down input_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Task Details -->
                                <div class="form_section">
                                    <div class="section_header">
                                        <h3 class="section_title">Chi tiết công việc</h3>
                                    </div>
                                    <div class="section_content">
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-heading"></i>
                                                    Tên công việc <span class="required">*</span>
                                                </label>
                                                <div class="input_wrapper">
                                                    <input type="text" class="form_input" name="ten_cong_viec" id="ten_cong_viec" placeholder="Nhập tiêu đề công việc..." autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-align-left"></i>
                                                    Mô tả chi tiết
                                                </label>
                                                <div class="textarea_wrapper">
                                                    <textarea class="form_textarea" name="mo_ta" id="mo_ta" rows="2" placeholder="Nhập mô tả chi tiết về công việc cần thực hiện..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-clock"></i>
                                                    Thời hạn (SA: Sáng || CH: Chiều Tối)
                                                </label>
                                                <div class="input_wrapper" id="thoi_han_wrapper">
                                                    <input type="datetime-local" class="form_input" name="thoi_han" id="thoi_han" placeholder="VD: 15/12/2024 - SA" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form_row">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-paperclip"></i>
                                                    Tệp đính kèm (Ảnh, Word, Excel, PDF)
                                                </label>
                                                <div class="file_upload_area" id="file_upload_area">
                                                    <input type="file" class="form_file_input" name="tep_dinh_kem[]" id="tep_dinh_kem" multiple accept=".jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx,.pdf">
                                                    <div class="file_upload_content" onclick="document.getElementById('tep_dinh_kem').click()">
                                                        <div class="file_upload_icon">
                                                            <i class="fa fa-cloud-upload-alt"></i>
                                                        </div>
                                                        <div class="file_upload_text">
                                                            <span class="file_upload_main">Kéo thả tệp vào đây hoặc <span class="file_upload_link">chọn tệp</span></span>
                                                            <span class="file_selected_text" id="file_selected_text">Không có tệp nào được chọn</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="file_info">
                                                    <i class="fa fa-info-circle"></i>
                                                    Chỉ chấp nhận: JPG, PNG, GIF, DOC, DOCX, XLS, XLSX, PDF (tối đa 10MB/file)
                                                </div>
                                                <div class="file_list" id="file_list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section: Priority and Response Time -->
                                <div class="form_section">
                                    <div class="section_header">
                                        <h3 class="section_title">Thiết lập ưu tiên</h3>
                                    </div>
                                    <div class="section_content">
                                        <div class="form_row form_row_2col">
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-flag"></i>
                                                    Mức độ ưu tiên <span class="required">*</span>
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
                                            
                                            <div class="form_group">
                                                <label class="form_label">
                                                    <i class="fa fa-hourglass-half"></i>
                                                    Thời gian nhận việc <span class="required">*</span>
                                                </label>
                                                <div class="input_with_unit">
                                                    <input type="number" class="form_input" name="thoi_gian_nhan_viec" id="thoi_gian_nhan_viec" value="60" min="1" autocomplete="off">
                                                    <span class="input_unit">phút</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="form_actions">
                                    <button type="submit" class="btn_submit" name="giaoviec_tructiep">
                                        <i class="fa fa-paper-plane"></i>
                                        <span>Giao việc ngay</span>
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
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e5e7eb;
}

.section_title {
    font-size: 14px;
    font-weight: 600;
    color: #4a5568;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

.form_row_3col {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
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

.textarea_icon {
    position: absolute;
    top: 14px;
    right: 14px;
    color: #a0aec0;
    pointer-events: none;
    transition: color 0.3s ease;
}

.textarea_wrapper:focus-within .textarea_icon {
    color: #0062a0;
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

.form_select[multiple] {
    min-height: 120px;
    padding: 12px;
    background: #fff;
}

.form_select[multiple] option {
    padding: 10px;
    margin: 4px 0;
    border-radius: 6px;
    transition: background 0.2s ease;
}

.form_select[multiple] option:hover {
    background: #f0f0f5;
}

.form_select[multiple] option:checked {
    background: #0062a0;
    color: #fff;
}

/* File Upload Styles */
.file_upload_area {
    margin-bottom: 12px;
}

.form_file_input {
    display: none;
}

.file_upload_content {
    border: 2px dashed #cbd5e0;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    background: linear-gradient(to bottom, #f7fafc 0%, #edf2f7 100%);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.file_upload_content::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 98, 160, 0.1), transparent);
    transition: left 0.5s ease;
}

.file_upload_content:hover {
    border-color: #0062a0;
    background: linear-gradient(to bottom, #fff 0%, #f0f0f5 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 98, 160, 0.15);
}

.file_upload_content:hover::before {
    left: 100%;
}

.file_upload_icon {
    font-size: 48px;
    color: #0062a0;
    margin-bottom: 15px;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.file_upload_text {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.file_upload_main {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
}

.file_upload_link {
    color: #0062a0;
    text-decoration: underline;
}

.file_selected_text {
    font-size: 14px;
    color: #718096;
    font-style: italic;
}

.file_info {
    font-size: 13px;
    color: #718096;
    margin-top: 10px;
    padding-left: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.file_info i {
    color: #0062a0;
}

.file_list {
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.file_item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    background: linear-gradient(to right, #f7fafc 0%, #edf2f7 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-size: 14px;
    color: #2d3748;
    transition: all 0.3s ease;
}

.file_item:hover {
    border-color: #0062a0;
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.15);
}

.file_item_name {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    overflow: hidden;
}

.file_item_name i {
    color: #0062a0;
    font-size: 18px;
}

.file_item_remove {
    background: none;
    border: none;
    color: #e53e3e;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 16px;
}

.file_item_remove:hover {
    background: #fed7d7;
    transform: scale(1.1);
}

/* Input with Unit */
.input_with_unit {
    position: relative;
    display: flex;
    align-items: center;
}

.input_with_unit .form_input {
    padding-right: 70px;
}

.input_with_unit .input_icon {
    right: 50px;
}

.input_unit {
    position: absolute;
    right: 16px;
    font-size: 14px;
    color: #718096;
    font-weight: 600;
    pointer-events: none;
    background: #edf2f7;
    padding: 4px 8px;
    border-radius: 6px;
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

/* Submit Button */
.form_actions {
    margin-top: 32px;
    display: flex;
    justify-content: flex-end;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
}

.btn_submit {
    padding: 12px 32px;
    background: #0062a0;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(0, 98, 160, 0.2);
    position: relative;
}

.btn_submit:hover {
    background: #005080;
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.3);
    transform: translateY(-1px);
}

.btn_submit:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 98, 160, 0.2);
}

.btn_submit i {
    font-size: 14px;
}

.btn_submit.loading {
    opacity: 0.7;
    cursor: not-allowed;
    pointer-events: none;
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
    
    .form_row_3col {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

.btn_submit.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}

/* Make datetime input wrapper clickable */
#thoi_han_wrapper {
    cursor: pointer;
}
</style>

<script>
    $(function () {
        // Datetime picker
        // Thiết lập giá trị min là thời điểm hiện tại
function setMinDateTime() {
    const now = new Date();
    // Format thành yyyy-MM-ddTHH:mm cho datetime-local
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('thoi_han').setAttribute('min', minDateTime);
}

// Gọi hàm khi trang load
setMinDateTime();

// Giữ nguyên code click của bạn
$('#thoi_han_wrapper').on('click', function () {
    const i = document.getElementById('thoi_han');
    i.showPicker ? i.showPicker() : i.click();
});

        
        // File upload handler
        const $fileInput = $('#tep_dinh_kem');
        const $fileList = $('#file_list');
        const $fileSelectedText = $('#file_selected_text');
        let selectedFiles = [];
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
        
        function getFileIcon(fileName) {
            const ext = fileName.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) return 'fa-image';
            if (['doc', 'docx'].includes(ext)) return 'fa-file-word';
            if (['xls', 'xlsx'].includes(ext)) return 'fa-file-excel';
            if (ext === 'pdf') return 'fa-file-pdf';
            return 'fa-file';
        }
        
        function updateFileList() {
            $fileList.empty();
            if (selectedFiles.length === 0) {
                $fileSelectedText.text('Không có tệp nào được chọn');
                return;
            }
            
            $fileSelectedText.text(`${selectedFiles.length} tệp đã chọn`);
            
            selectedFiles.forEach((file, index) => {
                const $item = $('<div class="file_item"></div>');
                const $name = $('<div class="file_item_name"></div>');
                $name.append(`<i class="fa ${getFileIcon(file.name)}"></i>`);
                $name.append(`<span title="${file.name}">${file.name}</span>`);
                $name.append(`<span style="color: #718096; font-size: 12px; margin-left: 8px;">(${formatFileSize(file.size)})</span>`);
                
                const $remove = $('<button type="button" class="file_item_remove" data-index="' + index + '"><i class="fa fa-times"></i></button>');
                $remove.on('click', function() {
                    const idx = $(this).data('index');
                    selectedFiles.splice(idx, 1);
                    updateFileInput();
                    updateFileList();
                });
                
                $item.append($name).append($remove);
                $fileList.append($item);
            });
        }
        
        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            $fileInput[0].files = dt.files;
        }
        
        $fileInput.on('change', function(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                if (file.size > 10 * 1024 * 1024) {
                    alert(`Tệp "${file.name}" vượt quá 10MB. Vui lòng chọn tệp khác.`);
                    return;
                }
                if (!selectedFiles.find(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                }
            });
            updateFileInput();
            updateFileList();
        });
    });
</script>

    
