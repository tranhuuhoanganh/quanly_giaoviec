<div class="box_pop_duyet">
  <div class="box_pop_duyet_dialog">
    <div class="box_pop_duyet_content">

      <div class="box_pop_duyet_header">
        <div class="box_pop_duyet_title_wrapper">
          <h5 class="box_pop_duyet_title">
            Duyệt báo cáo
          </h5>
        </div>
        <button type="button" class="box_pop_duyet_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_duyet_body">
        <form id="form_duyet" autocomplete="off">
          <!-- Form đánh giá -->
          <div class="form_section">
            
            
            <div class="form_group">
              <label class="form_label">
                <i class="fa fa-sticky-note"></i>
                Ghi chú đánh giá
              </label>
              <div class="textarea_wrapper">
                <textarea 
                  class="form_textarea" 
                  name="ghichu_cua_sep" 
                  id="ghichu_cua_sep" 
                  rows="4" 
                  placeholder="Nhập đánh giá..."></textarea>
              </div>
            </div>
            
            <div class="form_group">
              <label class="form_label">
                <i class="fa fa-paperclip"></i>
                File đính kèm của quản lý
              </label>
              <div class="file_upload_area" id="file_upload_area_duyet">
                <input type="file" class="form_file_input" name="file_congviec_sep[]" id="file_congviec_sep_duyet" multiple accept=".jpg,.jpeg,.png,.gif,.doc,.docx,.xls,.xlsx,.pdf">
                 <div class="file_upload_content" id="file_upload_content_duyet" onclick="document.getElementById('file_congviec_sep_duyet').click()">
                  <div class="file_upload_icon">
                    <i class="fa fa-cloud-upload-alt"></i>
                  </div>
                  <div class="file_upload_text">
                    <span class="file_upload_main">Kéo thả tệp vào đây hoặc <span class="file_upload_link">chọn tệp</span></span>
                    <span class="file_selected_text" id="file_selected_text_duyet">Không có tệp nào được chọn</span>
                  </div>
                </div>
              </div>
              <div class="file_info">
                <i class="fa fa-info-circle"></i>
                Chỉ chấp nhận: JPG, PNG, GIF, DOC, DOCX, XLS, XLSX, PDF (tối đa 10MB/file)
              </div>
              <div class="file_list" id="file_list_duyet"></div>
            </div>
          </div>

          <div class="form_actions">
            <button type="button" class="btn_cancel" name="close_box_pop_duyet">
              <i class="fa fa-times"></i>
              Hủy
            </button>
            <button type="submit" class="btn_tuchoi" data-id="{id}" name="{tuchoi_baocao}">
              <i class="fa fa-times"></i>
              Từ chối duyệt
            </button>
            <button type="submit" class="btn_submit" data-id="{id}" name="{duyet_baocao}">
              <i class="fa fa-check"></i>
              Duyệt báo cáo
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_duyet,
  .box_pop_duyet * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_duyet {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_duyet {
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
  .box_pop_duyet_dialog {
    width: 100%;
    max-width: 700px;
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
  .box_pop_duyet_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_duyet_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_duyet_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_duyet_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_duyet_title i {
    font-family: "FontAwesome" !important;
    color: #28a745;
    font-size: 20px;
  }

  .box_pop_duyet_close {
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

  .box_pop_duyet_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_duyet_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_duyet_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_duyet_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #ffffff;
  }

  /* Section */
  .form_section {
    margin-bottom: 24px;
  }



  /* Form group */
  .form_group {
    margin-bottom: 20px;
  }

  .form_label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 10px;
  }

  .form_label i {
    font-family: "FontAwesome" !important;
    color: #0062A0;
    font-size: 14px;
  }

  /* Textarea wrapper */
  .textarea_wrapper {
    position: relative;
  }

  .form_textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    color: #111827;
    background: #ffffff;
    resize: vertical;
    transition: all 0.2s ease;
    line-height: 1.6;
    min-height: 100px;
  }

  .form_textarea:focus {
    outline: none;
    border-color: #0062A0;
    box-shadow: 0 0 0 3px rgba(0, 98, 160, 0.1);
  }

  .form_textarea::placeholder {
    color: #9ca3af;
  }

  /* File upload area */
  .file_upload_area {
    margin-bottom: 12px;
  }

  .form_file_input {
    display: none;
  }

  .file_upload_content {
    border: 2px dashed #cbd5e0;
    border-radius: 16px;
    padding: 10px 20px;
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

  .file_upload_icon i {
    font-family: "FontAwesome" !important;
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
    font-family: "FontAwesome" !important;
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
    font-family: "FontAwesome" !important;
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

  .file_item_remove i {
    font-family: "FontAwesome" !important;
  }

  /* Form actions */
  .form_actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    align-items: center;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid #e5e7eb;
  }

  .btn_cancel,
  .btn_tuchoi,
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

  .btn_cancel {
    background: #f3f4f6;
    color: #374151;
  }

  .btn_cancel:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .btn_cancel:active {
    transform: translateY(0);
  }

  .btn_tuchoi {
    background: #e53e3e;
    color: #ffffff;
  }

  .btn_tuchoi:hover {
    background: #c53023;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(229, 62, 62, 0.3);
  }

  .btn_submit {
    background: #0062A0;
    color: #ffffff;
  }

  .btn_submit:hover {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  .btn_submit:active {
    transform: translateY(0);
  }

  .btn_cancel i,
  .btn_tuchoi i,
  .btn_submit i {
    font-family: "FontAwesome" !important;
    font-size: 14px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .box_pop_duyet_dialog {
      max-width: 100%;
    }

    .box_pop_duyet_body {
      padding: 16px;
    }

    .box_pop_duyet_header {
      padding: 12px 16px;
    }

    .form_actions {
      flex-direction: column-reverse;
    }

    .btn_cancel,
    .btn_tuchoi,
    .btn_submit {
      width: 100%;
      justify-content: center;
    }
  }
</style>

<script>
  $(function () {
    // File upload handler
    const $fileInput = $('#file_congviec_sep_duyet');
    const $fileList = $('#file_list_duyet');
    const $fileSelectedText = $('#file_selected_text_duyet');
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

