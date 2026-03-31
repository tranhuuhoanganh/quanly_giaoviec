<div class="box_pop_edit_congviec_giaopho">
  <div class="box_pop_edit_congviec_giaopho_dialog">
    <div class="box_pop_edit_congviec_giaopho_content">

      <div class="box_pop_edit_congviec_giaopho_header">
        <h5 class="box_pop_edit_congviec_giaopho_title">Chỉnh sửa công việc</h5>
        <button type="button" class="box_pop_edit_congviec_giaopho_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_edit_congviec_giaopho_body">
        <form id="form_edit_congviec_giaopho" autocomplete="off">
          <input type="hidden" name="id" value="{id}">
          
          <!-- Section: Task Details -->
          <div class="form_section">
            <div class="section_header">
              <h3 class="section_title">Chi tiết công việc</h3>
            </div>
            <div class="section_content">
              <!-- Row 1: Task Name and Department -->
              <div class="form_row form_row_2col">
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-heading"></i>
                    Tên công việc <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <input type="text" class="form_input" name="ten_cong_viec" id="ten_cong_viec_edit_giaopho" value="{ten_congviec}" placeholder="Nhập tiêu đề công việc..." autocomplete="off">
                  </div>
                </div>
                
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-building"></i>
                    Chọn phòng ban <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <select class="form_select" name="phong_ban_congviec" id="phong_ban_edit_giaopho">
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
                    Chọn nhân viên <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <select class="form_select" name="nhan_vien_congviec" id="nhan_vien_edit_giaopho">
                      {option_nhan_vien}
                    </select>
                    <i class="fa fa-chevron-down input_icon"></i>
                  </div>
                </div>
              </div>

              <!-- Row 3: Deadline, Time to receive, and Priority -->
              <div class="form_row form_row_3col">
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-calendar-check"></i>
                    Hạn hoàn thành <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <input type="datetime-local" class="form_input" name="han_hoan_thanh" id="han_hoan_thanh_edit_giaopho" value="{han_hoan_thanh_value}" autocomplete="off">
                  </div>
                </div>

                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-clock"></i>
                    Thời gian nhận việc (Phút) <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <input type="number" class="form_input" name="thoi_gian_nhan_viec" id="thoi_gian_nhan_viec_edit_giaopho" value="{thoi_gian_nhan_viec}" min="1" autocomplete="off">
                  </div>
                </div>
                
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-flag"></i>
                    Mức độ ưu tiên <span class="required">*</span>
                  </label>
                  <div class="input_wrapper">
                    <select class="form_select" name="mucdo_uutien" id="muc_do_uu_tien_edit_giaopho">
                      <option value="thap" {selected_thap}>Thấp</option>
                      <option value="binh_thuong" {selected_binh_thuong}>Bình thường</option>
                      <option value="cao" {selected_cao}>Cao</option>
                      <option value="rat_cao" {selected_rat_cao}>Rất cao</option>
                    </select>
                    <i class="fa fa-chevron-down input_icon"></i>
                  </div>
                </div>
              </div>
              
              <!-- Row 4: Task Description -->
              <div class="form_row">
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-align-left"></i>
                    Mô tả công việc <span class="required">*</span>
                  </label>
                  <div class="textarea_wrapper">
                    <textarea class="form_textarea" name="mo_ta_cong_viec" id="mo_ta_cong_viec_edit_giaopho" rows="6" placeholder="Nhập mô tả chi tiết về công việc cần thực hiện...">{mo_ta_congviec}</textarea>
                  </div>
                </div>
              </div>
              
              <!-- Row 5: Notes -->
              <div class="form_row">
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-sticky-note"></i>
                    Ghi chú
                  </label>
                  <div class="textarea_wrapper">
                    <textarea class="form_textarea" name="ghi_chu" id="ghi_chu_edit_giaopho" rows="4" placeholder="Nhập ghi chú bổ sung...">{ghi_chu}</textarea>
                  </div>
                </div>
              </div>
              
              <div class="form_row">
                <div class="form_group">
                  <label class="form_label">
                    <i class="fa fa-paperclip"></i>
                    Tệp đính kèm (Ảnh, Word, Excel, PDF)
                  </label>
                  {file_list_existing}
                  <div class="file_upload_area" id="file_upload_area_edit_giaopho">
                    <input type="file" class="form_file_input" name="tep_dinh_kem[]" id="tep_dinh_kem_edit_giaopho" multiple accept=".jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx,.pdf">
                    <div class="file_upload_content" onclick="document.getElementById('tep_dinh_kem_edit_giaopho').click()">
                      <div class="file_upload_icon">
                        <i class="fa fa-cloud-upload-alt"></i>
                      </div>
                      <div class="file_upload_text">
                        <span class="file_upload_main">Kéo thả tệp vào đây hoặc <span class="file_upload_link">chọn tệp</span></span>
                        <span class="file_selected_text" id="file_selected_text_edit_giaopho">Không có tệp nào được chọn</span>
                      </div>
                    </div>
                  </div>
                  <div class="file_info">
                    <i class="fa fa-info-circle"></i>
                    Chỉ chấp nhận: JPG, PNG, GIF, DOC, DOCX, XLS, XLSX, PDF (tối đa 10MB/file)
                  </div>
                  <div class="file_list" id="file_list_edit_giaopho"></div>
                </div>
              </div>
            </div>
          </div>


          <!-- Submit Button -->
          <div class="form_actions">
            <button type="button" class="btn-cancel" name="close_box_pop_edit_congviec_giaopho">Hủy</button>
            <button type="submit" class="btn_submit" name="update_congviec_giaopho">
              <i class="fa fa-save"></i>
              <span>Cập nhật</span>
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
  .box_pop_edit_congviec_giaopho,
  .box_pop_edit_congviec_giaopho * {
    box-sizing: border-box;
  }
  
  .box_pop_edit_congviec_giaopho {
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }
  
  /* Đảm bảo icon Font Awesome không bị override */
  .box_pop_edit_congviec_giaopho .fa,
  .box_pop_edit_congviec_giaopho i[class*="fa-"] {
    font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "FontAwesome" !important;
  }

  .box_pop_edit_congviec_giaopho {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: rgba(10, 10, 10, 0.45);
    z-index: 99999;
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

  .box_pop_edit_congviec_giaopho_dialog {
    width: 100%;
    max-width: 900px;
    background: transparent;
    animation: slideUp 0.3s ease;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
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

  .box_pop_edit_congviec_giaopho_content {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(12, 15, 30, 0.18);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_edit_congviec_giaopho_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
    position: relative;
    flex-shrink: 0;
  }

  .box_pop_edit_congviec_giaopho_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    flex: 1;
    letter-spacing: 0.2px;
  }

  .box_pop_edit_congviec_giaopho_close {
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
    margin-left: 12px;
  }

  .box_pop_edit_congviec_giaopho_close i {
    font-size: 16px;
  }

  .box_pop_edit_congviec_giaopho_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_edit_congviec_giaopho_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_edit_congviec_giaopho_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
  }

  /* Form Section Styles */
  .form_section {
    margin-bottom: 20px;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #e5e7eb;
  }

  .form_section:last-of-type {
    margin-bottom: 0;
  }

  .section_header {
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #0062A0;
  }

  .section_title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
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
    padding: 40px 20px;
    text-align: center;
    background: linear-gradient(to bottom, #f7fafc 0%, #edf2f7 100%);
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .file_upload_content:hover {
    border-color: #0062a0;
    background: linear-gradient(to bottom, #fff 0%, #f0f0f5 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 98, 160, 0.15);
  }

  .file_upload_icon {
    font-size: 48px;
    color: #0062a0;
    margin-bottom: 15px;
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

  .file_item_existing {
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
    margin-bottom: 16px;    
  }
  .file_item_existing:hover {
    border-color: #0062a0;
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.15);
}

  .file_item_existing_name {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    overflow: hidden;
  }

  .file_item_existing_name i {
    color: #0062a0;
    font-size: 16px;
  }

  .file_item_existing_name span {
    color: #111827;
    font-weight: 500;
    word-break: break-all;
  }

  .file_item_existing_actions {
    display: flex;
    gap: 8px;
    align-items: center;
  }

  .file_item_existing_download {
    color: #0062a0;
    text-decoration: none;
  }

  .file_item_existing_remove {
    background: none;
    border: none;
    color: #e53e3e;
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
  }

  /* Submit Button */
  .form_actions {
    margin-top: 32px;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
  }

  .btn-cancel {
    padding: 10px 20px;
    background: #f3f4f6;
    color: #374151;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
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

  /* Responsive Design */
  @media (max-width: 768px) {
    .box_pop_edit_congviec_giaopho_dialog {
      max-width: 100%;
    }

    .box_pop_edit_congviec_giaopho_body {
      padding: 20px;
    }

    .form_section {
      padding: 16px;
    }

    .form_row_2col,
    .form_row_3col {
      grid-template-columns: 1fr;
      gap: 16px;
    }

    .form_actions {
      flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn_submit {
      width: 100%;
    }
  }
</style>

<script>
  $(function () {
    // File upload handler
    const $fileInput = $('#tep_dinh_kem_edit_giaopho');
    const $fileList = $('#file_list_edit_giaopho');
    const $fileSelectedText = $('#file_selected_text_edit_giaopho');
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

