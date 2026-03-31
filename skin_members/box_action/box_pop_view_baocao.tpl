<div class="box_pop_view_baocao">
  <div class="box_pop_view_baocao_dialog">
    <div class="box_pop_view_baocao_content">

      <div class="box_pop_view_baocao_header">
        <div class="box_pop_view_baocao_title_wrapper">
          <h5 class="box_pop_view_baocao_title">
            <i class="fa fa-file-alt"></i>
            Chi tiết báo cáo
          </h5>
        </div>
        <button type="button" class="box_pop_view_baocao_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_view_baocao_body">
        <div class="box_pop_view_baocao_grid">
          <div class="box_pop_view_baocao_main">

            <!-- Thông tin cơ bản -->
            <div class="box_pop_view_baocao_section">
              <h6 class="box_pop_view_baocao_section_title">Thông tin cơ bản</h6>
              <div class="box_pop_view_baocao_fields">
                <div class="field field_half">
                  <label class="field_label">Ngày báo cáo</label>
                  <div class="field_value">{date_post}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Tiến độ hoàn thành</label>
                  <div class="field_value">
                    <span class="progress_badge {tiendo_class}">{tiendo_hoanthanh}%</span>
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Trạng thái</label>
                  <div class="field_value">
                    <span class="status_badge status_{trang_thai_raw}">{trang_thai_text}</span>
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Người báo cáo</label>
                  <div class="field_value">{ten_nguoi_baocao}</div>
                </div>
              </div>
            </div>

            <!-- Nội dung báo cáo -->
            <div class="box_pop_view_baocao_section">
              <h6 class="box_pop_view_baocao_section_title">Nội dung báo cáo</h6>
              <div class="box_pop_view_baocao_fields">
                <div class="field field_full">
                  <label class="field_label">Ghi chú cập nhật</label>
                  <div class="field_value field_value_textarea">{ghi_chu_capnhat}</div>
                </div>
              </div>
            </div>

            <!-- File đính kèm của người báo cáo -->
            {file_section}

            <!-- Phản hồi từ quản lý -->
            {phan_hoi_section}

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_view_baocao,
  .box_pop_view_baocao * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_view_baocao {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_view_baocao {
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
  .box_pop_view_baocao_dialog {
    width: 100%;
    max-width: 900px;
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
  .box_pop_view_baocao_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_view_baocao_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_baocao_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_view_baocao_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_view_baocao_title i {
    font-family: "FontAwesome" !important;
    color: #0062A0;
    font-size: 20px;
  }

  .box_pop_view_baocao_close {
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

  .box_pop_view_baocao_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_view_baocao_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_view_baocao_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_view_baocao_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #ffffff;
    display: flex;
    flex-direction: column;
  }

  /* Grid layout */
  .box_pop_view_baocao_grid {
    display: flex;
    flex-direction: column;
  }

  /* Main column */
  .box_pop_view_baocao_main {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Section */
  .box_pop_view_baocao_section {
    padding-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_baocao_section:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .box_pop_view_baocao_section_title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #0062A0;
    display: inline-block;
  }

  /* Fields wrapper */
  .box_pop_view_baocao_fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
  }

  /* Field */
  .field {
    display: flex;
    flex-direction: column;
  }

  .field_half {
    grid-column: span 1;
  }

  .field_full {
    grid-column: 1 / -1;
  }

  /* Labels */
  .field_label {
    font-size: 12px;
    color: #475569;
    margin-bottom: 6px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* Values */
  .field_value {
    font-size: 15px;
    color: #111827;
    font-weight: 500;
    padding: 10px 14px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    min-height: 42px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    word-break: break-word;
  }

  .field_value:empty::before {
    content: "-";
    color: #9ca3af;
  }

  .field_value_textarea {
    min-height: 100px;
    align-items: flex-start;
    padding-top: 12px;
    white-space: pre-wrap;
    line-height: 1.6;
  }

  /* Progress badge */
  .progress_badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .progress_badge.progress_low {
    background: #fee2e2;
    color: #dc2626;
  }

  .progress_badge.progress_medium {
    background: #fef3c7;
    color: #d97706;
  }

  .progress_badge.progress_good {
    background: #dbeafe;
    color: #2563eb;
  }

  .progress_badge.progress_complete {
    background: #d1fae5;
    color: #059669;
  }

  /* Status badge */
  .status_badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
  }

  .status_badge.status_0 {
    background: #fef3c7;
    color: #92400e;
  }
kk
  .status_badge.status_1 {
    background: #d1fae5;
    color: #065f46;
  }

  .status_badge.status_2 {
    background: #fee2e2;
    color: #991b1b;
  }

  .status_badge.status_3 {
    background: #fef3c7;
    color: #92400e;
  }

  .status_badge.status_4 {
    background: #dbeafe;
    color: #2563eb;
  }

  /* File section */
  .file_list {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .file_item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 10px 14px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
  }

  .file_item_left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    min-width: 0;
  }

  .file_item i {
    font-family: "FontAwesome" !important;
    color: #0062A0;
    font-size: 18px;
    flex-shrink: 0;
  }

  .file_item .file_name {
    color: #111827;
    font-weight: 500;
    word-break: break-all;
    flex: 1;
  }

  .file_item a {
    color: #0062A0;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #0062A0;
    color: #ffffff;
    border-radius: 6px;
    font-size: 13px;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .file_item a:hover {
    background: #005085;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 98, 160, 0.2);
  }

  .file_item a i {
    font-family: "FontAwesome" !important;
    font-size: 12px;
    color: #ffffff;
  }

  /* Phản hồi section */
  .phan_hoi_section {
    background: #f8fafc;
    border-radius: 8px;
    padding: 16px;
    border: 1px solid #e2e8f0;
  }

  .phan_hoi_title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .phan_hoi_title i {
    font-family: "FontAwesome" !important;
    color: #0062A0;
    font-size: 16px;
  }

  .phan_hoi_content {
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    white-space: pre-wrap;
    padding: 12px;
    background: #ffffff;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    min-height: 60px;
  }

  .phan_hoi_content:empty::before {
    content: "Chưa có phản hồi";
    color: #9ca3af;
    font-style: italic;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .box_pop_view_baocao_dialog {
      max-width: 100%;
    }

    .box_pop_view_baocao_fields {
      grid-template-columns: 1fr;
    }

    .box_pop_view_baocao_body {
      padding: 16px;
    }
  }
</style>
