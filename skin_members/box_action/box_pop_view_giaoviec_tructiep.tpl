<div class="box_pop_view_giaoviec">
  <div class="box_pop_view_giaoviec_dialog">
    <div class="box_pop_view_giaoviec_content">

      <div class="box_pop_view_giaoviec_header">
        <div class="box_pop_view_giaoviec_title_wrapper">
          <h5 class="box_pop_view_giaoviec_title">Chi tiết công việc</h5>
        </div>
        <button type="button" class="box_pop_view_giaoviec_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_view_giaoviec_body">
        <div class="box_pop_view_giaoviec_grid">
          <div class="box_pop_view_giaoviec_main">

            <!-- Thông tin cơ bản -->
            <div class="box_pop_view_giaoviec_section">
              <h6 class="box_pop_view_giaoviec_section_title">Thông tin cơ bản</h6>
              <div class="box_pop_view_giaoviec_fields">
                <div class="field field_full">
                  <label class="field_label">Tên công việc</label>
                  <div class="field_value field_value_highlight">{ten_congviec}</div>
                </div>

                <div class="field field_full">
                  <label class="field_label">Mô tả công việc</label>
                  <div class="field_value field_value_textarea">{mo_ta_congviec}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Mức độ ưu tiên</label>
                  <div class="field_value">
                    <span class="priority_badge priority_{mucdo_uutien_raw}">{mucdo_uutien_text}</span>
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Trạng thái</label>
                  <div class="field_value" id="status_trang_thai">
                    <span class="status_badge status_{trang_thai_raw}">{trang_thai_text}</span>
                  </div>
                </div>

                
              </div>
            </div>

            <!-- Thông tin người thực hiện -->
            <div class="box_pop_view_giaoviec_section">
              <h6 class="box_pop_view_giaoviec_section_title">Thông tin người thực hiện</h6>
              <div class="box_pop_view_giaoviec_fields">
                <div class="field field_half">
                  <label class="field_label">Người giao việc</label>
                  <div class="field_value">
                    <div class="user_info_display">
                      <div class="user_name">{ten_nguoi_giao}</div>
                      <div class="user_department">{ten_phongban_giao}</div>
                    </div>
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Người nhận việc</label>
                  <div class="field_value">
                    <div class="user_info_display">
                      <div class="user_name">{ten_nguoi_nhan}</div>
                      <div class="user_department">{ten_phongban_nhan}</div>
                    </div>
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Người giám sát</label>
                  <div class="field_value">
                    <div class="user_info_display">
                      <div class="user_name">{ten_nguoi_giamsat}</div>
                      <div class="user_department">{ten_phongban_giamsat}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Thông tin thời gian -->
            <div class="box_pop_view_giaoviec_section">
              <h6 class="box_pop_view_giaoviec_section_title">Thông tin thời gian</h6>
              <div class="box_pop_view_giaoviec_fields">
                <div class="field field_half">
                  <label class="field_label">Ngày bắt đầu</label>
                  <div class="field_value">{ngay_bat_dau}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Hạn hoàn thành</label>
                  <div class="field_value" id="han_hoan_thanh">
                    <div class="deadline_display">
                      <div class="han_hoan_thanh_value">{han_hoan_thanh}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- File đính kèm -->
            {file_section}

          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="box_pop_view_giaoviec_footer">
          <div class="box_pop_view_giaoviec_actions">
            <div class="box_pop_view_giaoviec_actions_left">
              <button type="button" class="btn btn-primary" id="box_pop_lichsu_baocao" data-id="{id}">
                <i class="fa fa-history"></i>
                báo cáo
              </button>
              <button type="button" class="btn btn-secondary" id="box_pop_lichsu_giahan" data-id="{id}">
                <i class="fa fa-history"></i>
                gia hạn
              </button>
            </div>
            <div class="box_pop_view_giaoviec_actions_right">
              {footer_action}
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="box_pop_nhanviec" style="display: none;"></div>
<style>
  /* Reset và base styles */
  .box_pop_view_giaoviec,
  .box_pop_view_giaoviec * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_view_giaoviec {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_view_giaoviec {
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

  /* Dialog container */
  .box_pop_view_giaoviec_dialog {
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
  .box_pop_view_giaoviec_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_view_giaoviec_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_giaoviec_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_view_giaoviec_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
  }

  .box_pop_view_giaoviec_close {
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

  .box_pop_view_giaoviec_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_view_giaoviec_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_view_giaoviec_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_view_giaoviec_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #ffffff;
    display: flex;
    flex-direction: column;
  }

  /* Grid layout */
  .box_pop_view_giaoviec_grid {
    display: flex;
    flex-direction: column;
  }

  /* Main column */
  .box_pop_view_giaoviec_main {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Section */
  .box_pop_view_giaoviec_section {
    padding-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_giaoviec_section:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .box_pop_view_giaoviec_section_title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #0062A0;
    display: inline-block;
  }

  /* Fields wrapper */
  .box_pop_view_giaoviec_fields {
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

  
  
  @keyframes pulse {
    0%, 100% {
      opacity: 1;
    }
    50% {
      opacity: 0.7;
    }
  }

  .field_value_highlight {
    background: #f8fafc;
    border-color: #0062A0;
    font-weight: 600;
    font-size: 16px;
    color: #0062A0;
  }

  .field_value_textarea {
    min-height: 100px;
    align-items: flex-start;
    padding-top: 12px;
    white-space: pre-wrap;
    line-height: 1.6;
  }

  /* User info display */
  .user_info_display {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .user_name {
    font-weight: 600;
    color: #111827;
    font-size: 15px;
  }

  .user_department {
    font-size: 13px;
    color: #6b7280;
  }

  /* Priority badge */
  .priority_badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize; 
    white-space: nowrap;
  }

  .priority_badge.priority_thap {
      background: #e9ecef;
      color: #495057;
  }

  .priority_badge.priority_binh_thuong {
      background: #cfe2ff;
      color: #084298;
  }

  .priority_badge.priority_cao {
      background: #f8d7da;
      color: #842029;
  }

  .priority_badge.priority_rat_cao {
      background: #f5c2c7;
      color: #842029;
  }

  /* Status badge */
  .status_badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
  }

  .status_badge.status_0,
  .status_0 {
    background: #feebc8;
    color: #c05621;
  }

  .status_badge.status_1,
  .status_1 {
    background: #feebc8;
    color: #c05621;
  }

  .status_badge.status_2,
  .status_2 {
    background: #bee3f8;
    color: #2c5282;
  }

  .status_badge.status_3,
  .status_3 {
    background: #f5c2c7;
    color: #842029;
  }

  .status_badge.status_4,
  .status_4 {
    background: #f8d7da;
    color: #991b1b;
  }

  .status_badge.status_5,
  .status_5 {
    background: #fff3cd;
    color: #856404;
  }

  .status_badge.status_6,
  .status_6 {
    background: #c6f6d5;
    color: #22543d;
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

  /* Footer với action buttons */
  .box_pop_view_giaoviec_footer {
    padding: 24px 24px 0;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
    margin-top: 24px;
  }

  .box_pop_view_giaoviec_actions {
    display: flex;
    gap: 12px;
    justify-content: space-between;
    align-items: center;
  }

  /* Nhóm nút bên trái */
  .box_pop_view_giaoviec_actions_left {
    display: flex;
    gap: 12px;
    align-items: center;
  }

  /* Nhóm nút bên phải */
  .box_pop_view_giaoviec_actions_right {
    display: flex;
    gap: 12px;
    align-items: center;
    margin-left: auto;
  }

  /* Class để căn phải khi không có nút bên trái (tương thích ngược) */
  .box_pop_view_giaoviec_actions.actions-right-only {
    justify-content: flex-end;
  }

  /* Nếu không có nhóm trái, các nút sẽ tự động căn phải (cho trình duyệt hỗ trợ :has) */
  @supports selector(:has(*)) {
    .box_pop_view_giaoviec_actions:not(:has(.box_pop_view_giaoviec_actions_left)) {
      justify-content: flex-end;
    }
  }

  .btn_quay_lai,
  .btn_cho_xac_nhan {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .btn_quay_lai {
    background: #f3f4f6;
    color: #374151;
  }

  .btn_quay_lai:hover {
    background: #e5e7eb;
    color: #111827;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .btn_quay_lai:active {
    transform: translateY(0);
  }

  .btn_cho_xac_nhan {
    background: #0062A0;
    color: #ffffff;
  }

  .btn_cho_xac_nhan:hover {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  .btn_cho_xac_nhan:active {
    transform: translateY(0);
  }

  .btn_quay_lai i,
  .btn_cho_xac_nhan i {
    font-family: "FontAwesome" !important;
    font-size: 14px;
  }

  /* Styles cho các nút trong footer action */
  .box_pop_view_giaoviec_actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
  }

  .box_pop_view_giaoviec_actions .btn i {
    font-family: "FontAwesome" !important;
    font-size: 14px;
  }

  .box_pop_view_giaoviec_actions .btn.btn-danger {
    background: #dc3545;
    color: #ffffff;
  }

  .box_pop_view_giaoviec_actions .btn.btn-danger:hover:not(:disabled) {
    background: #c82333;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
  }

  .box_pop_view_giaoviec_actions .btn.btn-draft {
    background: #0062A0;
    color: #ffffff;
  }

  .box_pop_view_giaoviec_actions .btn.btn-draft:hover:not(:disabled) {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  .box_pop_view_giaoviec_actions .btn.btn-draft:disabled {
    background: #9ca3af;
    color: #ffffff;
    cursor: not-allowed;
    opacity: 0.6;
  }

  .box_pop_view_giaoviec_actions .btn.btn-giahan {
    background: #ff9800;
    color: #ffffff;
  }

  .box_pop_view_giaoviec_actions .btn.btn-giahan:hover:not(:disabled) {
    background: #f57c00;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
  }

  .box_pop_view_giaoviec_actions .btn.btn-success {
    background: #28a745;
    color: #ffffff;
  }

  .box_pop_view_giaoviec_actions .btn.btn-success:hover:not(:disabled) {
    background: #218838;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
  }

  /* Nút Primary - Gia hạn (xanh đậm) */
  .box_pop_view_giaoviec_actions .btn.btn-primary {
    background: #0062A0;
    color: #ffffff;
  }

  .box_pop_view_giaoviec_actions .btn.btn-primary:hover:not(:disabled) {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  /* Nút Secondary - Báo cáo (xanh nhạt/xám/viền) */
  .box_pop_view_giaoviec_actions .btn.btn-secondary {
    background: #f8f9fa;
    color: #373b3f;
    border: 1.5px solid #dee2e6;
  }

  .box_pop_view_giaoviec_actions .btn.btn-secondary:hover:not(:disabled) {
    background: #e9ecef;
    color: #495057;
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .box_pop_view_giaoviec_actions .btn:active:not(:disabled) {
    transform: translateY(0);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .box_pop_view_giaoviec_dialog {
      max-width: 100%;
    }

    .box_pop_view_giaoviec_fields {
      grid-template-columns: 1fr;
    }

    .box_pop_view_giaoviec_body {
      padding: 16px;
    }

    .box_pop_view_giaoviec_footer {
      padding: 16px;
    }

    .box_pop_view_giaoviec_actions {
      flex-direction: column-reverse;
      gap: 8px;
    }

    .box_pop_view_giaoviec_actions_left,
    .box_pop_view_giaoviec_actions_right {
      width: 100%;
      flex-direction: column;
    }

    .btn_quay_lai,
    .btn_cho_xac_nhan {
      width: 100%;
      justify-content: center;
    }

    .box_pop_view_giaoviec_actions .btn {
      width: 100%;
      justify-content: center;
    }
  }
</style>
