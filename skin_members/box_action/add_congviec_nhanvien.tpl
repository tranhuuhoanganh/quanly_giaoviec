<div class="form_add_nhanvien" data-member-index="{member_index}">
    <div class="member_header">
        <div class="member_number">
            <i class="fa fa-user"></i>
            <span class="member_index_text">Thành viên #{member_index}</span>
        </div>
        <button type="button" class="btn_remove_member" title="Xóa thành viên này">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <form class="form_add_nhanvien_form" autocomplete="off">
        <!-- Row 1: Task Name and Department -->
        <div class="form_row form_row_2col">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-tag"></i>
                    Tên công việc <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <input type="text" class="form_input" name="ten_cong_viec" id="ten_cong_viec" placeholder="Nhập tên công việc..." autocomplete="off">
                </div>
            </div>
            
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-building"></i>
                    Chọn phòng ban <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <select class="form_select" name="add_phong_ban_{member_index}" id="add_phong_ban_{member_index}">
                        {option_phongban}
                    </select>
                    <i class="fa fa-chevron-down input_icon"></i>
                </div>
            </div>
        </div>

        <!-- Row 2: Employee -->
        <div class="form_row">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-user"></i>
                    Chọn nhân viên
                </label>
                <div class="input_wrapper">
                    <select class="form_select" name="add_nhan_vien_{member_index}" id="add_nhan_vien_{member_index}">
                    </select>
                    <i class="fa fa-chevron-down input_icon"></i>
                </div>
            </div>
        </div>

        <!-- Row 3: Time to receive, Deadline and Priority -->
        <div class="form_row form_row_3col">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-calendar-check"></i>
                    Hạn hoàn thành <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <input type="datetime-local" class="form_input" name="han_hoan_thanh" id="han_hoan_thanh" autocomplete="off">
                </div>
            </div>

            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-clock"></i>
                    Thời gian nhận việc (Phút) <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <input type="number" class="form_input" name="thoi_gian_nhan_viec" id="thoi_gian_nhan_viec" value="60" min="1" autocomplete="off">
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

        <!-- Row 5: Task Description -->
        <div class="form_row">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-bars"></i>
                    Mô tả công việc <span class="required">*</span>
                </label>
                <div class="textarea_wrapper">
                    <textarea class="form_textarea" name="mo_ta_cong_viec" id="mo_ta_cong_viec" rows="2" placeholder="Mô tả chi tiết về công việc, yêu cầu, phạm vi..."></textarea>
                </div>
            </div>
        </div>

        <!-- Row 6: Notes -->
        <div class="form_row">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-sticky-note"></i>
                    Ghi chú
                </label>
                <div class="textarea_wrapper">
                    <textarea class="form_textarea" name="ghi_chu" id="ghi_chu" rows="2" placeholder="Ghi chú bổ sung cho công việc..."></textarea>
                </div>
            </div>
        </div>

        <!-- Row 7: File Upload -->
        <div class="form_row">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-paperclip"></i>
                    Tệp đính kèm (Ảnh, Word, Excel, PDF)
                </label>
                <div class="file_upload_area">
                    <input type="file" class="form_file_input" name="file_dinh_kem[]" multiple accept=".jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx,.pdf">
                    <div class="file_upload_content">
                        <div class="file_upload_icon">
                            <i class="fa fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file_upload_text">
                            <span class="file_upload_main">Kéo thả tệp vào đây hoặc <span class="file_upload_link">chọn tệp</span></span>
                            <span class="file_selected_text">Không có tệp nào được chọn</span>
                        </div>
                    </div>
                </div>
                <div class="file_info">
                    <i class="fa fa-info-circle"></i>
                    Chỉ chấp nhận: JPG, PNG, GIF, DOC, DOCX, XLS, XLSX, PDF (tối đa 10MB/file)
                </div>
                <div class="file_list"></div>
            </div>
        </div>
    </form>
</div>

<style>
.form_add_nhanvien {
    margin-bottom: 16px;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.form_add_nhanvien::before {
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

.form_add_nhanvien:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 98, 160, 0.15);
}

.form_add_nhanvien:hover::before {
    opacity: 1;
}

.member_header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e5e7eb;
}

.member_number {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #0062a0;
}

.member_number i {
    font-size: 18px;
    background: #0062a0;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.member_index_text {
    color: #2d3748;
}

.btn_remove_member {
    background: #fee2e2;
    border: none;
    color: #dc2626;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    font-size: 14px;
}

.btn_remove_member:hover {
    background: #fecaca;
    transform: scale(1.1);
}

.btn_remove_member:active {
    transform: scale(0.95);
}

.form_row {
    margin-bottom: 20px;
}

.form_row:last-child {
    margin-bottom: 0;
}

.form_row_2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form_row_3col {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
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

.input_wrapper .input_icon_date {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    pointer-events: none;
    transition: color 0.3s ease;
}

.input_wrapper:focus-within .input_icon,
.input_wrapper:focus-within .input_icon_date {
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

.form_select:disabled {
    background: #e5e7eb;
    cursor: not-allowed;
    opacity: 0.6;
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

/* Responsive */
@media (max-width: 768px) {
    .form_add_nhanvien {
        padding: 16px;
    }

    .form_row_2col,
    .form_row_3col {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>

<script>
$(function () {
    // File upload handler - xử lý cho từng form thành viên riêng biệt
    function initFileUpload($formContainer) {
        const $fileInput = $formContainer.find('input[type="file"]');
        const $fileList = $formContainer.find('.file_list');
        const $fileSelectedText = $formContainer.find('.file_selected_text');
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
        
        $fileInput.off('change').on('change', function(e) {
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
        
        // Click vào file upload area để chọn file
        $formContainer.find('.file_upload_content').off('click').on('click', function(e) {
            $fileInput.click();
        });
        
        // Drag and drop
        const $uploadContent = $formContainer.find('.file_upload_content');
        $uploadContent.off('dragover dragleave drop').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border-color', '#0062a0');
        }).on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border-color', '#cbd5e0');
        }).on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).css('border-color', '#cbd5e0');
            
            const files = Array.from(e.originalEvent.dataTransfer.files);
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
    }
    
    // Khởi tạo file upload cho form mới được thêm vào
    $(document).on('DOMNodeInserted', '.form_add_nhanvien', function() {
        initFileUpload($(this));
    });
    
    // Khởi tạo cho các form đã có sẵn
    $('.form_add_nhanvien').each(function() {
        initFileUpload($(this));
    });
});
</script>

