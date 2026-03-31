<div class="box_pop_nhanviec_quahan">
  <div class="box_pop_nhanviec_quahan_dialog">
    <div class="box_pop_nhanviec_quahan_content">

      <div class="box_pop_nhanviec_quahan_header">
        <h5 class="box_pop_nhanviec_quahan_title">Nhận việc quá hạn</h5>
        <button type="button" class="box_pop_nhanviec_quahan_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_nhanviec_quahan_body">
        <form id="form_nhanviec_quahan" autocomplete="off">
          <input type="hidden" name="id" value="{id}">
          <div class="form_group">
            <label class="form_label">
              <i class="fa fa-exclamation-triangle"></i>
              Lý do nhận việc muộn <span class="required">*</span>
            </label>
            <div class="textarea_wrapper">
              <textarea 
                class="form_textarea" 
                name="ly_do_nhan_muon" 
                id="ly_do_nhan_muon" 
                rows="3" 
                placeholder="Vui lòng nhập lý do tại sao bạn nhận việc muộn..."
                required></textarea>
            </div>
            <div class="form_hint">
              <i class="fa fa-info-circle"></i>
              Vui lòng giải thích rõ lý do bạn không thể nhận việc đúng thời hạn.
            </div>
          </div>

          <div class="form_actions">
            <button type="button" class="btn_cancel" name="close_box_pop_nhanviec_quahan">
              <i class="fa fa-times"></i>
              Hủy
            </button>
            <button type="submit" class="btn_submit" name="{nhanviec_quahan}">
              <i class="fa fa-check"></i>
              Xác nhận nhận việc
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_nhanviec_quahan,
  .box_pop_nhanviec_quahan * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_nhanviec_quahan {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_nhanviec_quahan {
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
  .box_pop_nhanviec_quahan_dialog {
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
  .box_pop_nhanviec_quahan_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_nhanviec_quahan_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_nhanviec_quahan_title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #0062A0;
    letter-spacing: 0.2px;
  }

  .box_pop_nhanviec_quahan_close {
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

  .box_pop_nhanviec_quahan_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_nhanviec_quahan_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_nhanviec_quahan_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_nhanviec_quahan_body {
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

  .required {
    color: #0062A0;
    margin-left: 4px;
  }

  /* Textarea wrapper */
  .textarea_wrapper {
    position: relative;
  }

  .form_textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    font-family: inherit;
    color: #111827;
    background: #ffffff;
    resize: vertical;
    transition: all 0.2s ease;
    line-height: 1.5;
    min-height: 60px;
  }

  .form_textarea:focus {
    outline: none;
    border-color: #0062A0;
    box-shadow: 0 0 0 3px rgba(0, 98, 160, 0.1);
  }

  .form_textarea::placeholder {
    color: #9ca3af;
  }

  /* Form hint */
  .form_hint {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
  }

  .form_hint i {
    font-family: "FontAwesome" !important;
    font-size: 12px;
    color: #0062A0;
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
    .box_pop_nhanviec_quahan_dialog {
      max-width: 100%;
    }

    .box_pop_nhanviec_quahan_body {
      padding: 16px;
    }

    .box_pop_nhanviec_quahan_header {
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
