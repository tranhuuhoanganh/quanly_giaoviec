<div class="box_pop_chuyen_user">
  <div class="box_pop_chuyen_user_dialog">
    <div class="box_pop_chuyen_user_content">

      <div class="box_pop_chuyen_user_header">
        <div class="box_pop_chuyen_user_title_wrapper">
          <h5 class="box_pop_chuyen_user_title">Chuyển phòng ban</h5>
        </div>
        <button type="button" class="box_pop_chuyen_user_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_chuyen_user_body">
        <form class="box_pop_chuyen_user_form" autocomplete="off">
          
          <div class="box_pop_chuyen_user_info">
            <div class="info_item">
              <span class="info_label">Nhân viên:</span>
              <span class="info_value">{name}</span>
            </div>
            <div class="info_item">
              <span class="info_label">Phòng ban hiện tại:</span>
              <span class="info_value">{phong_ban_hien_tai}</span>
            </div>
          </div>

          <div class="field">
            <label class="field_label">Chọn phòng ban mới (*)</label>
            <select class="field_select" name="phong_ban_moi" id="phong_ban_moi" required>
              {list_phongban}
            </select>
          </div>
        </form>
      </div>

      <div class="box_pop_chuyen_user_footer">
        <button type="button" class="btn-cancel" name="cancel">Hủy</button>
        <button type="button" class="btn-submit" name="chuyen_user" data-user_id="{user_id}">Chuyển phòng ban</button>
      </div>

    </div>
  </div>
</div>

<style>
  .box_pop_chuyen_user,
  .box_pop_chuyen_user * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_chuyen_user {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  .box_pop_chuyen_user {
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
    z-index: 9999;
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

  .box_pop_chuyen_user_dialog {
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

  .box_pop_chuyen_user_content {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
  }

  .box_pop_chuyen_user_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_chuyen_user_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_chuyen_user_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
  }

  .box_pop_chuyen_user_close {
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

  .box_pop_chuyen_user_close i {
    font-size: 14px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_chuyen_user_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_chuyen_user_close:active {
    transform: scale(0.95);
  }

  .box_pop_chuyen_user_body {
    padding: 24px;
    background: #ffffff;
  }

  .box_pop_chuyen_user_info {
    background: #f8fafc;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 24px;
    border: 1px solid #e5e7eb;
  }

  .info_item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
  }

  .info_item:last-child {
    margin-bottom: 0;
  }

  .info_label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    min-width: 140px;
  }

  .info_value {
    color: #111827;
    font-size: 14px;
    font-weight: 500;
  }

  .field {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .field_label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
  }

  .field_select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    color: #111827;
    background: #ffffff;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .field_select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
  }

  .field_select:hover {
    border-color: #9ca3af;
  }

  .box_pop_chuyen_user_footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 20px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
  }

  .btn-cancel,
  .btn-submit {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-cancel {
    background: #f3f4f6;
    color: #374151;
  }

  .btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
  }

  .btn-submit {
    background: #2563eb;
    color: #ffffff;
  }

  .btn-submit:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
  }

  .btn-submit:active {
    transform: translateY(0);
  }

  @media (max-width: 768px) {
    .box_pop_chuyen_user {
      padding: 8px;
    }

    .box_pop_chuyen_user_dialog {
      max-width: 100%;
    }

    .box_pop_chuyen_user_header {
      padding: 8px 12px;
    }

    .box_pop_chuyen_user_title {
      font-size: 15px;
    }

    .box_pop_chuyen_user_body {
      padding: 20px;
    }

    .box_pop_chuyen_user_footer {
      padding: 12px 16px;
      flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-submit {
      width: 100%;
    }

    .info_item {
      flex-direction: column;
      align-items: flex-start;
      gap: 4px;
    }

    .info_label {
      min-width: auto;
    }
  }
</style>
