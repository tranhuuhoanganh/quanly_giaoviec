<div class="box_pop_giahan">
    <div class="box_pop_giahan_dialog">
      <div class="box_pop_giahan_content">
  
        <div class="box_pop_giahan_header">
          <h5 class="box_pop_giahan_title">Chi tiết báo cáo</h5>
          <button type="button" class="box_pop_giahan_close" aria-label="Đóng">
            <i class="fa fa-times"></i>
          </button>
        </div>
  
        <div class="box_pop_giahan_body">
          <form id="form_giahan" autocomplete="off">
            <input type="hidden" name="id" value="{id}">
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-clock"></i>
                    Hạn hiện tại <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <input type="datetime-local" class="form_input" name="han_hientai" id="han_hientai" value="{han_hientai}" readonly autocomplete="off">
                </div>
            </div>
            <div class="form_group">
                <label class="form_label">
                    <i class="fa fa-clock"></i>
                    Hạn sau gia hạn <span class="required">*</span>
                </label>
                <div class="input_wrapper">
                    <input type="datetime-local" class="form_input" name="han_sau_giahan" id="han_sau_giahan" autocomplete="off">
                </div>
            </div>
            <div class="form_group">
              <label class="form_label">
                <i class="fa fa-sticky-note"></i>
                Ghi chú gia hạn
              </label>
              <div class="textarea_wrapper">
                <textarea 
                  class="form_textarea" 
                  name="ghi_chu" 
                  id="ghi_chu" 
                  rows="3" 
                  placeholder="Nhập lý do gia hạn..."></textarea>
              </div>
            </div>
  
           
  
            <div class="form_actions">
              <button type="button" class="btn_cancel" name="close_box_pop_giahan">
                <i class="fa fa-times"></i>
                Hủy
              </button>
              <button type="submit" class="btn_submit" name="{giahan_congviec}">
                <i class="fa fa-clock"></i>
                Xin gia hạn
              </button>
            </div>
          </form>
        </div>
  
      </div>
    </div>
  </div>
  
  <style>
    /* Reset và base styles */
    .box_pop_giahan,
    .box_pop_giahan * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
  
    .box_pop_giahan {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
  
    /* Overlay modal */
    .box_pop_giahan {
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
  
    /* Dialog container */
    .box_pop_giahan_dialog {
      width: 100%;
      max-width: 600px;
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
    .box_pop_giahan_content {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      max-height: 90vh;
    }
  
    /* Header */
    .box_pop_giahan_header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 14px;
      background: #ffffff;
      color: #111827;
      border-bottom: 1px solid #e5e7eb;
    }
  
    .box_pop_giahan_title {
      margin: 0;
      font-size: 16px;
      font-weight: 600;
      color: #111827;
    }
  
    .box_pop_giahan_close {
      width: 28px;
      height: 28px;
      background: #f3f4f6;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }
  
    .box_pop_giahan_close i {
      font-size: 16px;
      font-family: "FontAwesome" !important;
    }
  
    .box_pop_giahan_close:hover {
      background: #e5e7eb;
      color: #374151;
      transform: scale(1.05);
    }
  
    .box_pop_giahan_close:active {
      transform: scale(0.95);
    }
  
    .box_pop_giahan_close:active {
      transform: scale(0.95);
    }
  
    /* Body */
    .box_pop_giahan_body {
      padding: 24px;
      overflow-y: auto;
      flex: 1;
      background: #ffffff;
    }
  
    /* Form group */
    .form_group {
      margin-bottom: 24px;
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
  
    /* Input wrapper */
    .input_wrapper {
      position: relative;
    }
  
    .form_input {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      font-size: 14px;
      font-family: inherit;
      color: #111827;
      background: #ffffff;
      transition: all 0.2s ease;
      line-height: 1.5;
    }
  
    .form_input:focus {
      outline: none;
      border-color: #0062A0;
      box-shadow: 0 0 0 3px rgba(0, 98, 160, 0.1);
    }
  
    .form_input:read-only,
    .form_input_readonly {
      background: #f3f4f6;
      cursor: not-allowed;
      border-color: #d1d5db;
      color: #6b7280;
    }
  
    .form_input::placeholder {
      color: #9ca3af;
    }
  
    /* Progress slider wrapper */
    .progress_slider_wrapper {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
  
    .progress_slider_container {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
  
    .progress_slider {
      width: 100%;
      height: 6px;
      border-radius: 3px;
      background: #e5e7eb;
      outline: none;
      -webkit-appearance: none;
      appearance: none;
      cursor: pointer;
    }
  
    /* Màu xanh cho phần track phía trước thumb */
    .progress_slider::-webkit-slider-runnable-track {
      height: 6px;
      border-radius: 3px;
      background: linear-gradient(to right, #0062A0 0%, #0062A0 var(--slider-progress, 0%), #e5e7eb var(--slider-progress, 0%), #e5e7eb 100%);
    }
  
    .progress_slider::-moz-range-track {
      height: 6px;
      border-radius: 3px;
      background: #e5e7eb;
    }
  
    .progress_slider::-moz-range-progress {
      height: 6px;
      border-radius: 3px;
      background: #0062A0;
    }
  
    .progress_slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #0062A0;
      cursor: pointer;
      box-shadow: 0 2px 4px rgba(0, 98, 160, 0.3);
      transition: all 0.2s ease;
      margin-top: -6px;
    }
  
    .progress_slider::-webkit-slider-thumb:hover {
      background: #005085;
      transform: scale(1.1);
    }
  
    .progress_slider::-moz-range-thumb {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #0062A0;
      cursor: pointer;
      border: none;
      box-shadow: 0 2px 4px rgba(0, 98, 160, 0.3);
      transition: all 0.2s ease;
    }
  
    .progress_slider::-moz-range-thumb:hover {
      background: #005085;
      transform: scale(1.1);
    }
  
    .progress_slider_labels {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: #6b7280;
    }
  
    /* Progress input wrapper */
    .progress_input_wrapper {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
    }
  
    .progress_input {
      flex: 1;
      border: none;
      background: transparent;
      padding: 0;
      font-size: 14px;
      font-weight: 600;
      color: #111827;
    }
  
    .progress_input:focus {
      outline: none;
      box-shadow: none;
    }
  
    .progress_percent {
      font-size: 14px;
      font-weight: 600;
      color: #6b7280;
      flex-shrink: 0;
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
      min-height: 130px;
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
      margin-bottom: 8px;
      border: 1px solid #e3e8ef;
      border-radius: 8px;
      padding: 12px;
      background: #ffffff;
    }
  
    .form_file_input {
      display: none;
    }
  
    .file_upload_content {
      border: 2px dashed #e3e8ef;
      border-radius: 6px;
      padding: 16px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
      background: #f9fafb;
    }
  
    .file_upload_content:hover {
      border-color: #0062A0;
      background: #f0f9ff;
    }
  
    .file_upload_icon {
      margin-bottom: 12px;
    }
  
    .file_upload_icon i {
      font-family: "FontAwesome" !important;
      font-size: 32px;
      color: #9ca3af;
    }
  
    .file_upload_text {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
  
    .file_upload_main {
      font-size: 14px;
      color: #6b7280;
    }
  
    .file_upload_link {
      color: #0062A0;
      font-weight: 600;
    }
  
    .file_selected_text {
      font-size: 12px;
      color: #9ca3af;
    }
  
    .file_info {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 8px;
      font-size: 12px;
      color: #6b7280;
    }
  
    .file_info i {
      font-family: "FontAwesome" !important;
      font-size: 12px;
      color: #0062A0;
    }
  
    .file_list {
      margin-top: 12px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
  
    .file_list_item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      background: #f9fafb;
      border: 1px solid #e3e8ef;
      border-radius: 6px;
      transition: all 0.2s ease;
    }
  
    .file_list_item:hover {
      background: #f3f4f6;
      border-color: #d1d5db;
    }
  
    .file_list_item_icon {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #e0f2fe;
      border-radius: 4px;
      flex-shrink: 0;
    }
  
    .file_list_item_icon i {
      font-family: "FontAwesome" !important;
      font-size: 16px;
      color: #0062A0;
    }
  
    .file_list_item_name {
      flex: 1;
      font-size: 14px;
      color: #374151;
      word-break: break-word;
    }
  
    .file_list_item_remove {
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      color: #6b7280;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }
  
    .file_list_item_remove:hover {
      background: #fee2e2;
      color: #dc2626;
    }
  
    .file_list_item_remove i {
      font-family: "FontAwesome" !important;
      font-size: 14px;
    }
  
    /* File item styles (tương tự add công việc) */
    .file_item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      background: #f9fafb;
      border: 1px solid #e3e8ef;
      border-radius: 8px;
      font-size: 14px;
      color: #374151;
      transition: all 0.2s ease;
      margin-bottom: 8px;
    }
  
    .file_item:hover {
      border-color: #0062A0;
      background: #f3f4f6;
      transform: translateX(2px);
      box-shadow: 0 2px 8px rgba(0, 98, 160, 0.1);
    }
  
    .file_item_name {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
      overflow: hidden;
    }
  
    .file_item_name i {
      color: #0062A0;
      font-size: 16px;
      font-family: "FontAwesome" !important;
      flex-shrink: 0;
    }
  
    .file_item_name span {
      word-break: break-word;
      flex: 1;
    }
  
    .file_item_remove {
      background: transparent;
      border: none;
      color: #6b7280;
      cursor: pointer;
      padding: 6px 10px;
      border-radius: 6px;
      transition: all 0.2s ease;
      font-size: 14px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  
    .file_item_remove:hover {
      background: #fee2e2;
      color: #dc2626;
      transform: scale(1.1);
    }
  
    .file_item_remove i {
      font-family: "FontAwesome" !important;
      font-size: 14px;
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
    .btn_submit i {
      font-family: "FontAwesome" !important;
      font-size: 14px;
    }
  
    /* Responsive */
    @media (max-width: 768px) {
      .box_pop_giahan_dialog {
        max-width: 100%;
      }
  
      .box_pop_giahan_body {
        padding: 16px;
      }
  
      .box_pop_giahan_header {
        padding: 16px;
      }
  
      .form_actions {
        flex-direction: column-reverse;
      }
  
      .btn_cancel,
      .btn_submit {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
  
  
  