<div class="box_pop_view_user">
  <div class="box_pop_view_user_dialog">
    <div class="box_pop_view_user_content">

      <div class="box_pop_view_user_header">
        <div class="box_pop_view_user_title_wrapper">
          <h5 class="box_pop_view_user_title">Chi tiết nhân viên</h5>
        </div>
        <button type="button" class="box_pop_view_user_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_view_user_body">
        <div class="box_pop_view_user_grid">
          <div class="box_pop_view_user_main">

            <div class="box_pop_view_user_section">
              <h6 class="box_pop_view_user_section_title">Thông tin cơ bản</h6>
              <div class="box_pop_view_user_fields">
                <div class="field field_half">
                  <label class="field_label">Tên đăng nhập</label>
                  <div class="field_value">{username}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Họ tên</label>
                  <div class="field_value">{name}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Email</label>
                  <div class="field_value">{email}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Số điện thoại</label>
                  <div class="field_value">{mobile}</div>
                </div>

                <div class="field field_full">
                  <label class="field_label">Địa chỉ</label>
                  <div class="field_value">{dia_chi}</div>
                </div>
              </div>
            </div>

            <div class="box_pop_view_user_section">
              <h6 class="box_pop_view_user_section_title">Thông tin hợp đồng</h6>
              <div class="box_pop_view_user_fields">
                <div class="field field_half">
                  <label class="field_label">Loại hình hợp đồng</label>
                  <div class="field_value">
                    {loai_hopdong_text}
                  </div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Thời hạn hợp đồng</label>
                  <div class="field_value">{time_hopdong}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Số hợp đồng lao động</label>
                  <div class="field_value">
                    {so_hopdong_file}
                  </div>
                </div>
              </div>
            </div>

            <div class="box_pop_view_user_section">
              <h6 class="box_pop_view_user_section_title">Thông tin CCCD</h6>
              <div class="box_pop_view_user_fields">
                <div class="field field_half">
                  <label class="field_label">Số CCCD</label>
                  <div class="field_value">{so_cccd}</div>
                </div>

                <div class="field field_half">
                  <label class="field_label">Ngày cấp</label>
                  <div class="field_value">{ngay_cap_cccd}</div>
                </div>
              </div>
            </div>

          </div>

          <aside class="box_pop_view_user_aside">
            <div class="avatar-container">
              {avatar_image}
              <div class="avatar-placeholder" role="img" aria-label="Avatar người dùng" style="{avatar_style}">
                <svg width="48" height="48" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 14s1-4 6-4 6 4 6 4-1 0-6 0-6 0-6 0z" />
                </svg>
              </div>
            </div>
          </aside>

        </div>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_view_user,
  .box_pop_view_user * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_view_user {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_view_user {
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
  .box_pop_view_user_dialog {
    width: 100%;
    max-width: 1200px;
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
  .box_pop_view_user_content {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_view_user_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_user_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_view_user_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
  }

  .box_pop_view_user_close {
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

  .box_pop_view_user_close i {
    font-size: 14px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_view_user_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_view_user_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_view_user_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #ffffff;
  }

  /* Grid layout */
  .box_pop_view_user_grid {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 30px;
    align-items: start;
  }

  /* Main column */
  .box_pop_view_user_main {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* Section */
  .box_pop_view_user_section {
    padding-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_user_section:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .box_pop_view_user_section_title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #2563eb;
    display: inline-block;
  }

  /* Fields wrapper */
  .box_pop_view_user_fields {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
  }

  /* Field */
  .field {
    display: flex;
    flex-direction: column;
  }

  .field_full {
    grid-column: 1 / -1;
  }

  /* Labels */
  .field_label {
    font-size: 13px;
    color: #6b7280;
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
    padding: 10px 12px;
    background: #f9fafb;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
    min-height: 42px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    word-break: break-word;
    justify-content: space-between;
  }

  .field_value:empty::before {
    content: "-";
    color: #9ca3af;
  }

  .field_value .file-link {
    color: #2563eb;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .field_value .file-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
  }

  .field_value .file-link i {
    font-family: "FontAwesome" !important;
  }

  .field_value .file-name {
    color: #374151;
    font-weight: 500;
    margin-right: 12px;
    word-break: break-all;
  }

  /* Aside (avatar) */
  .box_pop_view_user_aside {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    position: sticky;
    top: 24px;
  }

  .avatar-container {
    width: 100%;
    display: flex;
    justify-content: center;
  }

  .avatar-placeholder {
    width: 200px !important;
    height: 200px !important;
    border-radius: 50%;
    background: #f3f3f3;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    border: 3px solid #e5e7eb;
  }

  .avatar-placeholder img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .avatar-placeholder svg {
    width: 80px;
    height: 80px;
    color: #9ca3af;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .box_pop_view_user_dialog {
      max-width: 95%;
    }

    .box_pop_view_user_grid {
      grid-template-columns: 1fr;
      gap: 24px;
    }

    .box_pop_view_user_aside {
      position: static;
    }
  }

  @media (max-width: 768px) {
    .box_pop_view_user {
      padding: 10px;
    }

    .box_pop_view_user_body {
      padding: 16px;
    }

    .box_pop_view_user_fields {
      grid-template-columns: 1fr;
      gap: 12px;
    }

    .box_pop_view_user_section {
      padding-bottom: 16px;
    }
  }

  /* Scrollbar styling */
  .box_pop_view_user_body::-webkit-scrollbar {
    width: 8px;
  }

  .box_pop_view_user_body::-webkit-scrollbar-track {
    background: #f1f5f9;
  }

  .box_pop_view_user_body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }

  .box_pop_view_user_body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
</style>
