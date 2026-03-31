<div class="box_pop_delete_phongban">
  <div class="box_pop_delete_phongban_dialog">
    <div class="box_pop_delete_phongban_content">

      <div class="box_pop_delete_phongban_header">
        <h5 class="box_pop_delete_phongban_title">Xác nhận xóa phòng ban</h5>
        <button type="button" class="box_pop_delete_phongban_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_delete_phongban_body">
        <div class="box_pop_delete_phongban_message">
          <p class="message_text">
            Bạn có chắc chắn muốn xóa phòng ban <strong>"{tieu_de}"</strong> không?
          </p>
          {has_children_warning}
          <p class="message_warning">
            <i class="fa fa-info-circle"></i>
            Hành động này không thể hoàn tác. Tất cả nhân sự trong phòng ban này sẽ bị ảnh hưởng.
          </p>
        </div>
      </div>

      <div class="box_pop_delete_phongban_footer">
        <button type="button" class="btn-cancel" name="close_box_pop_delete_phongban" aria-label="Hủy">Hủy</button>
        <button type="button" class="btn-delete-confirm" name="delete_phongban" data-id="{phongban_id}" aria-label="Xóa">
          <i class="fa fa-trash"></i> Xóa phòng ban
        </button>
      </div>

    </div>
  </div>
</div>

<style>
  /* box_pop_delete_phongban.css - CSS cho modal xác nhận xóa phòng ban */

  .box_pop_delete_phongban,
  .box_pop_delete_phongban * {
    box-sizing: border-box;
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay / modal container */
  .box_pop_delete_phongban {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: rgba(10, 10, 10, 0.45);
    z-index: 9999;
  }

  /* Dialog */
  .box_pop_delete_phongban_dialog {
    width: 100%;
    max-width: 570px;
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

  /* Card nội dung */
  .box_pop_delete_phongban_content {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(12, 15, 30, 0.18);
    display: flex;
    flex-direction: column;
  }

  /* Header */
  .box_pop_delete_phongban_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    border-bottom: 1px solid #e5e7eb;
    background: #ffffff;
    position: relative;
  }

  .box_pop_delete_phongban_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    flex: 1;
  }

  .box_pop_delete_phongban_close {
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
    margin-left: 12px;
  }

  .box_pop_delete_phongban_close i {
    font-size: 14px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_delete_phongban_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_delete_phongban_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_delete_phongban_body {
    padding: 24px;
  }

  .box_pop_delete_phongban_message {
    text-align: center;
  }

  .message_text {
    font-size: 16px;
    color: #374151;
    margin: 0 0 16px 0;
    line-height: 1.6;
  }

  .message_text strong {
    color: #dc2626;
    font-weight: 600;
    text-transform: capitalize;
  }

  .message_warning {
    font-size: 14px;
    color: #6b7280;
    margin: 16px 0 0 0;
    padding: 12px;
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-align: left;
  }

  .message_warning i {
    font-size: 16px;
    color: #f59e0b;
    font-family: "FontAwesome" !important;
    flex-shrink: 0;
  }

  .message_warning_danger {
    font-size: 15px;
    color: #7f1d1d;
    margin: 16px 0 0 0;
    padding: 14px;
    background: #fee2e2;
    border-left: 4px solid #dc2626;
    border-radius: 6px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    text-align: left;
    font-weight: 500;
    line-height: 1.6;
    white-space: pre-line;
  }

  .message_warning_danger i {
    font-size: 18px;
    color: #dc2626;
    font-family: "FontAwesome" !important;
    flex-shrink: 0;
    margin-top: 2px;
    opacity: 0.85;
  }

  .message_warning_danger strong {
    color: #991b1b;
    font-weight: 700;
  }

  /* Footer */
  .box_pop_delete_phongban_footer {
    padding: 16px 24px;
    border-top: 1px solid #eef0f2;
    display: flex;
    justify-content: space-between;
    gap: 12px;
    background: #fff;
  }

  /* Buttons */
  .btn-cancel,
  .btn-delete-confirm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    min-width: 120px;
  }

  .btn-cancel {
    background: #f3f4f6;
    color: #374151;
  }

  .btn-cancel:hover {
    background: #e5e7eb;
    color: #111827;
  }

  .btn-delete-confirm {
    background: #dc2626;
    color: #fff;
  }

  .btn-delete-confirm:hover {
    background: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
  }

  .btn-delete-confirm:active {
    transform: translateY(0);
  }

  .btn-delete-confirm i {
    font-size: 14px;
    font-family: "FontAwesome" !important;
  }

  /* Focus states */
  .box_pop_delete_phongban_close:focus,
  .btn-cancel:focus,
  .btn-delete-confirm:focus {
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
    outline: none;
  }

  /* Responsive */
  @media (max-width: 600px) {
    .box_pop_delete_phongban {
      padding: 8px;
    }

    .box_pop_delete_phongban_dialog {
      max-width: 100%;
    }

    .box_pop_delete_phongban_header {
      padding: 8px 12px;
    }

    .box_pop_delete_phongban_title {
      font-size: 15px;
    }

    .box_pop_delete_phongban_footer {
      flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-delete-confirm {
      width: 100%;
    }
  }
</style>

<script>
  // Đóng popup khi click nút đóng hoặc nút hủy
  document.querySelector('.box_pop_delete_phongban_close')?.addEventListener('click', function() {
    document.querySelector('.box_pop_delete_phongban').style.display = 'none';
  });

  document.querySelector('.btn-cancel')?.addEventListener('click', function() {
    document.querySelector('.box_pop_delete_phongban').style.display = 'none';
  });

  // Đóng popup khi click ra ngoài
  document.querySelector('.box_pop_delete_phongban')?.addEventListener('click', function(e) {
    if (e.target === this) {
      this.style.display = 'none';
    }
  });
</script>
