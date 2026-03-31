<div class="box_pop_list_user">
  <div class="box_pop_list_user_dialog">
    <div class="box_pop_list_user_content">

      <div class="box_pop_list_user_header">
        <div class="box_pop_list_user_title_wrapper">
          <h5 class="box_pop_list_user_title">Nhân sự phòng ban</h5>
        </div>
        <button type="button" class="box_pop_list_user_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_list_user_body">
        <div class="box_pop_list_user_table_wrapper">
          <table class="box_pop_list_user_table">
            <thead>
              <tr>
                <th>STT</th>
                <th>NHÂN VIÊN</th>
                <th>SỐ ĐIỆN THOẠI</th>
                <th>EMAIL</th>
                <th>HẠN HỢP ĐỒNG</th>
                <th>HÀNH ĐỘNG</th>
              </tr>
            </thead>
            <tbody>
              {list_user}
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="box_pop_delete" style="display: none;"></div>
<style>
  /* Reset và base styles */
  .box_pop_list_user,
  .box_pop_list_user * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_list_user {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_list_user {
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
  .box_pop_list_user_dialog {
    width: 100%;
    max-width: 1400px;
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
  .box_pop_list_user_content {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_list_user_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_list_user_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_list_user_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
  }

  .box_pop_list_user_close {
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

  .box_pop_list_user_close i {
    font-size: 14px;
  }

  .box_pop_list_user_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_list_user_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_list_user_body {
    padding: 0;
    overflow: hidden;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #ffffff;
  }

  /* Table wrapper với scroll */
  .box_pop_list_user_table_wrapper {
    overflow-x: hidden;
    overflow-y: auto;
    max-height: calc(90vh - 60px);
  }

  /* Table */
  .box_pop_list_user_table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    table-layout: fixed;
  }

  /* Table header */
  .box_pop_list_user_table thead {
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .box_pop_list_user_table thead tr {
    background: linear-gradient(135deg, #006bb3 0%, #005a9e 100%);
  }

  .box_pop_list_user_table thead th {
    padding: 10px 10px;
    text-align: left;
    font-weight: 600;
    font-size: 12px;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: normal;
    border: none;
    position: relative;
    word-wrap: break-word;
  }

  .box_pop_list_user_table thead th:first-child {
    padding-left: 16px;
    text-align: center;
    width: 70px;
  }

  .box_pop_list_user_table thead th:nth-child(2) {
    width: 18%;
    padding-left: 16px;
  }

  .box_pop_list_user_table thead th:nth-child(3) {
    width: 13%;
    padding-left: 12px;
  }

  .box_pop_list_user_table thead th:nth-child(4) {
    width: 22%;
    padding-left: 12px;
  }

  .box_pop_list_user_table thead th:nth-child(5) {
    width: 16%;
    text-align: center;
    padding-left: 12px;
  }

  .box_pop_list_user_table thead th:nth-child(6) {
    width: 31%;
    text-align: center;
    padding-right: 16px;
  }

  /* Table body */
  .box_pop_list_user_table tbody tr {
    border-bottom: 1px solid #e5e7eb;
    transition: background-color 0.15s ease;
    background: #ffffff;
  }

  .box_pop_list_user_table tbody tr:hover {
    background-color: #f8fafc;
  }

  .box_pop_list_user_table tbody tr:last-child {
    border-bottom: none;
  }

  .box_pop_list_user_table tbody td {
    padding: 12px 10px;
    font-size: 14px;
    color: #1f2937;
    vertical-align: middle;
    border: none;
    line-height: 1.5;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .box_pop_list_user_table tbody td:first-child {
    text-align: center;
    font-weight: 500;
    color: #6b7280;
    padding-left: 16px;
    width: 70px;
  }

  .box_pop_list_user_table tbody td:nth-child(2) {
    padding-left: 16px;
  }

  .box_pop_list_user_table tbody td:nth-child(3) {
    padding-left: 12px;
  }

  .box_pop_list_user_table tbody td:nth-child(4) {
    padding-left: 12px;
  }

  .box_pop_list_user_table tbody td:nth-child(5) {
    padding-left: 12px;
  }

  .box_pop_list_user_table tbody td:nth-child(6) {
    padding-right: 16px;
  }

  /* Employee cell */
  .box_pop_list_user_employee {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .box_pop_list_user_avatar,
  .box_pop_list_user_avatar_placeholder {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #e5e7eb;
  }

  .box_pop_list_user_avatar_placeholder {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6366f1;
    font-weight: 600;
    font-size: 18px;
    border: 2px solid #e5e7eb;
  }

  .box_pop_list_user_employee_info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
    flex: 1;
  }

  .box_pop_list_user_employee_name {
    font-weight: 600;
    color: #111827;
    font-size: 15px;
    line-height: 1.4;
    word-break: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  .box_pop_list_user_employee_code {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
  }

  /* Date display */
  .box_pop_list_user_status {
    display: inline-block;
    padding: 0;
    font-size: 14px;
    color: #374151;
    text-align: center;
    white-space: normal;
    font-weight: 500;
  }

  .box_pop_list_user_status.active {
    color: #059669;
    font-weight: 600;
  }

  .box_pop_list_user_status.expired {
    color: #dc2626;
    font-weight: 600;
  }

  /* Action buttons */
  .box_pop_list_user_actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    flex-wrap: wrap;
  }

  .box_pop_list_user_btn {
    padding: 6px 10px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    min-width: auto;
    flex-shrink: 0;
    justify-content: center;
    height: 32px;
  }

  .box_pop_list_user_btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }

  .box_pop_list_user_btn:active {
    transform: translateY(0);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  }

  .box_pop_list_user_btn.view {
    background: #2563eb;
    color: #ffffff;
  }

  .box_pop_list_user_btn.view:hover {
    background: #1d4ed8;
  }

  .box_pop_list_user_btn.edit {
    background: #f59e0b;
    color: #ffffff;
  }

  .box_pop_list_user_btn.edit:hover {
    background: #d97706;
  }

  .box_pop_list_user_btn.move {
    background: #10b981;
    color: #ffffff;
  }

  .box_pop_list_user_btn.move:hover {
    background: #059669;
  }
  .box_pop_list_user_btn.delete {
    background: #ef4444;
    color: #ffffff;
  }

  .box_pop_list_user_btn.delete:hover {
    background: #dc2626;
  }

  .box_pop_list_user_btn i {
    font-size: 11px;
  }

  /* Empty cells */
  .box_pop_list_user_table tbody td:empty::before {
    content: "-";
    color: #d1d5db;
  }

  /* Empty state */
  .box_pop_list_user_empty {
    padding: 60px 20px !important;
    text-align: center;
  }

  .box_pop_list_user_empty_content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    color: #9ca3af;
  }

  .box_pop_list_user_empty_content i {
    font-size: 48px;
    color: #d1d5db;
  }

  .box_pop_list_user_empty_content p {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
    color: #6b7280;
  }

  /* Responsive */
  @media (max-width: 1024px) {
    .box_pop_list_user_dialog {
      max-width: 95%;
    }
  }

  @media (max-width: 768px) {
    .box_pop_list_user {
      padding: 8px;
    }

    .box_pop_list_user_dialog {
      max-width: 100%;
    }

    .box_pop_list_user_header {
      padding: 8px 14px;
    }

    .box_pop_list_user_title {
      font-size: 16px;
    }

    .box_pop_list_user_table thead th,
    .box_pop_list_user_table tbody td {
      padding: 10px 8px;
      font-size: 13px;
    }

    .box_pop_list_user_table thead th:first-child,
    .box_pop_list_user_table tbody td:first-child {
      padding-left: 16px;
    }

    .box_pop_list_user_actions {
      flex-wrap: nowrap;
      gap: 4px;
    }

    .box_pop_list_user_btn {
      padding: 6px 10px;
      font-size: 12px;
      min-width: auto;
      flex: 1;
      height: 32px;
    }

    .box_pop_list_user_employee {
      gap: 10px;
    }

    .box_pop_list_user_avatar,
    .box_pop_list_user_avatar_placeholder {
      width: 40px;
      height: 40px;
    }
  }

  /* Scrollbar styling */
  .box_pop_list_user_table_wrapper::-webkit-scrollbar {
    width: 10px;
    height: 10px;
  }

  .box_pop_list_user_table_wrapper::-webkit-scrollbar-track {
    background: #f1f5f9;
  }

  .box_pop_list_user_table_wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 5px;
  }

  .box_pop_list_user_table_wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
</style>


