<div class="box_pop_duyet_giahan">
  <div class="box_pop_duyet_giahan_dialog">
    <div class="box_pop_duyet_giahan_content">

      <div class="box_pop_duyet_giahan_header">
        <div class="box_pop_duyet_giahan_title_wrapper">
          <h5 class="box_pop_duyet_giahan_title">
            Duyệt yêu cầu gia hạn
          </h5>
        </div>
        <button type="button" class="box_pop_duyet_giahan_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_duyet_giahan_body">
        <form id="form_duyet_giahan" autocomplete="off">
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
                  id="ghichu_cua_sep_giahan" 
                  rows="4" 
                  placeholder="Nhập đánh giá..."></textarea>
              </div>
            </div>
          </div>

          <div class="form_actions">
            <button type="button" class="btn_cancel" name="close_box_pop_duyet_giahan">
              <i class="fa fa-times"></i>
              Hủy
            </button>
            <button type="submit" class="btn_submit" data-id="{id}" name="{tuchoi_giahan}">
              <i class="fa fa-check"></i>
              Từ chối yêu cầu
            </button>
            <button type="submit" class="btn_submit" data-id="{id}" name="{duyet_giahan}">
              <i class="fa fa-check"></i>
              Duyệt yêu cầu
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_duyet_giahan,
  .box_pop_duyet_giahan * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_duyet_giahan {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_duyet_giahan {
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
  .box_pop_duyet_giahan_dialog {
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
  .box_pop_duyet_giahan_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_duyet_giahan_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_duyet_giahan_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_duyet_giahan_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_duyet_giahan_title i {
    font-family: "FontAwesome" !important;
    color: #28a745;
    font-size: 20px;
  }

  .box_pop_duyet_giahan_close {
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

  .box_pop_duyet_giahan_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_duyet_giahan_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_duyet_giahan_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_duyet_giahan_body {
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
    .box_pop_duyet_giahan_dialog {
      max-width: 100%;
    }

    .box_pop_duyet_giahan_body {
      padding: 16px;
    }

    .box_pop_duyet_giahan_header {
      padding: 12px 16px;
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

