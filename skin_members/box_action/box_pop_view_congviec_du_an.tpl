<div class="box_pop_view_congviec_du_an">
    <div class="box_pop_view_congviec_du_an_dialog">
        <div class="box_pop_view_congviec_du_an_content">

            <div class="box_pop_view_congviec_du_an_header">
                <div class="box_pop_view_congviec_du_an_title_wrapper">
                    <h5 class="box_pop_view_congviec_du_an_title">Chi tiết công việc dự án</h5>
                </div>
                <button type="button" class="box_pop_view_congviec_du_an_close" aria-label="Đóng">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="box_pop_view_congviec_du_an_body">
                <div class="box_pop_view_congviec_du_an_content_wrapper">

                    <!-- Thông tin công việc -->
                    <div class="box_pop_view_congviec_du_an_main">
                        <div class="box_pop_view_congviec_du_an_section">
                            <div class="section_header">
                                <h6 class="section_title">Thông tin công việc</h6>
                            </div>

                            <div class="section_fields">
                                <div class="field field_full">
                                    <label class="field_label">Tên công việc:</label>
                                    <div class="field_value field_value_highlight">{ten_congviec}</div>
                                </div>

                                <div class="field field_full">
                                    <label class="field_label">Mô tả công việc:</label>
                                    <div class="field_value field_value_textarea">{mo_ta_congviec}</div>
                                </div>

                                <div class="field field_full">
                                    <label class="field_label">Ghi chú:</label>
                                    <div class="field_value field_value_textarea">{ghi_chu}</div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Mức độ ưu tiên:</label>
                                    <div class="field_value">
                                        <span
                                            class="priority_badge priority_{mucdo_uutien_raw}">{mucdo_uutien_text}</span>
                                    </div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Trạng thái:</label>
                                    <div class="field_value" id="status_trang_thai">
                                        {trang_thai_text}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin người thực hiện -->
                        <div class="box_pop_view_congviec_du_an_section">
                            <div class="section_header">
                                <h6 class="section_title">Thông tin người thực hiện</h6>
                            </div>

                            <div class="section_fields">
                                <div class="field field_half">
                                    <label class="field_label">Người giao việc:</label>
                                    <div class="field_value">
                                        <div class="user_info_display">
                                            <div class="user_name">{ten_nguoi_giao}</div>
                                            <div class="user_department">{ten_phongban_giao}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Người nhận việc:</label>
                                    <div class="field_value">
                                        <div class="user_info_display">
                                            <div class="user_name">{ten_nguoi_nhan}</div>
                                            <div class="user_department">{ten_phongban_nhan}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin thời gian -->
                        <div class="box_pop_view_congviec_du_an_section">
                            <div class="section_header">
                                <h6 class="section_title">Thông tin thời gian</h6>
                            </div>

                            <div class="section_fields">
                                <div class="field field_half">
                                    <label class="field_label">Thời gian nhận việc:</label>
                                    <div class="field_value">{thoigian_nhanviec_text}</div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Hạn hoàn thành:</label>
                                    <div class="field_value {deadline_class}">
                                        <div class="deadline_display" id="han_hoan_thanh">
                                            <div class=" han_hoan_thanh_value">{han_hoanthanh_text}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Ngày tạo:</label>
                                    <div class="field_value">{ngay_tao}</div>
                                </div>

                                <div class="field field_half">
                                    <label class="field_label">Ngày cập nhật:</label>
                                    <div class="field_value">{ngay_cap_nhat}</div>
                                </div>
                            </div>
                        </div>

                        <!-- File đính kèm -->
                        {file_section}

                        <div class="box_pop_view_congviec_du_an_section">
                            <div class="section_header">
                                <h6 class="section_title">Công việc đã giao</h6>
                                <button type="button" class="btn btn-primary btn-sm" id="btn_add_giaoviec_giaopho" data-id="{id}">
                                    <i class="fa fa-plus"></i>
                                    Thêm việc
                                </button>
                            </div>

                            <div class="section_fields">
                                <div class="field field_full">
                                    <div class="giaoviec_list">
                                        <div class="table_wrapper">
                                            <table class="table_giaoviec_giaopho">
                                                <thead>
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên công việc</th>
                                                        <th style="text-align: center;">Mức độ ưu tiên</th>
                                                        <th style="text-align: center;">Hạn hoàn thành</th>
                                                        <th style="text-align: center;">Trạng thái</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {list_giaopho}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="box_pop_view_congviec_du_an_footer">
                    <div class="box_pop_view_congviec_du_an_actions">
                        <div class="box_pop_view_congviec_du_an_actions_left">
                            <button type="button" class="btn btn-primary" id="box_pop_lichsu_baocao_congviec_du_an" data-id="{id}">
                                <i class="fa fa-history"></i>
                                báo cáo
                            </button>
                            <button type="button" class="btn btn-secondary" id="box_pop_lichsu_giahan_congviec_du_an" data-id="{id}">
                                <i class="fa fa-history"></i>
                                gia hạn
                            </button>
                        </div>
                        <div class="box_pop_view_congviec_du_an_actions_right">
                            {footer_action}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<div class="box_pop_lichsu" style="display: none;"></div>
<style>
    /* Reset và base styles */
    .box_pop_view_congviec_du_an,
    .box_pop_view_congviec_du_an * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .box_pop_view_congviec_du_an {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Overlay modal */
    .box_pop_view_congviec_du_an {
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
    .box_pop_view_congviec_du_an_dialog {
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
    .box_pop_view_congviec_du_an_content {
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }

    /* Header */
    .box_pop_view_congviec_du_an_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: #ffffff;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
    }

    .box_pop_view_congviec_du_an_title_wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .box_pop_view_congviec_du_an_title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        letter-spacing: 0.2px;
    }

    .box_pop_view_congviec_du_an_close {
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

    .box_pop_view_congviec_du_an_close i {
        font-size: 16px;
        font-family: "FontAwesome" !important;
    }

    .box_pop_view_congviec_du_an_close:hover {
        background: #e5e7eb;
        color: #374151;
        transform: scale(1.05);
    }

    .box_pop_view_congviec_du_an_close:active {
        transform: scale(0.95);
    }

    /* Body */
    .box_pop_view_congviec_du_an_body {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
    }

    /* Content wrapper */
    .box_pop_view_congviec_du_an_content_wrapper {
        display: flex;
        flex-direction: column;
        gap: 24px;
        width: 100%;
    }

    /* Main content */
    .box_pop_view_congviec_du_an_main {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Section */
    .box_pop_view_congviec_du_an_section {
        background: #ffffff;
        border: none;
        border-radius: 0;
        padding: 0;
        padding-bottom: 24px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
    }

    .box_pop_view_congviec_du_an_section:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .section_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        padding-bottom: 0;
        border-bottom: none;
    }

    .section_header .section_title {
        margin: 0;
        margin-bottom: 16px;
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        display: inline-block;
        padding-bottom: 8px;
        border-bottom: 2px solid #0062A0;
    }

    .section_header .btn {
        margin-bottom: 16px;
        flex-shrink: 0;
    }

    .section_header .btn.btn-sm {
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
    }

    .section_header .section_title i {
        display: none;
    }

    /* Fields */
    .section_fields {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .section_fields .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .section_fields .field_full {
        width: 100%;
    }

    .section_fields .field_half {
        width: calc(50% - 8px);
    }

    @media (max-width: 768px) {
        .section_fields .field_half {
            width: 100%;
        }
    }

    .section_fields .field_label {
        font-size: 12px;
        font-weight: 500;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .section_fields .field_value {
        font-size: 15px;
        color: #111827;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        min-height: 42px;
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .section_fields .field_value:empty::before {
        content: "-";
        color: #9ca3af;
    }

    .section_fields .field_value_highlight {
        font-weight: 600;
        font-size: 16px;
        color: #0062A0;
        background: #f8fafc;
        border-color: #0062A0;
    }

    .section_fields .field_value_textarea {
        min-height: 100px;
        white-space: pre-wrap;
        word-wrap: break-word;
        align-items: flex-start;
        padding-top: 12px;
        line-height: 1.6;
    }

    /* Status badge - Đồng bộ với tr_giaoviec_giaopho.tpl */
    .status_badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status_badge.status_0 {
        background: #feebc8;
        color: #c05621;
    }

    .status_badge.status_1 {
        background: #feebc8;
        color: #c05621;
    }

    .status_badge.status_2 {
        background: #bee3f8;
        color: #2c5282;
    }

    .status_badge.status_3 {
        background: #f5c2c7;
        color: #842029;
    }

    .status_badge.status_4 {
        background: #f8d7da;
        color: #842029;
    }

    .status_badge.status_5 {
        background: #fff3cd;
        color: #856404;
    }

    .status_badge.status_6 {
        background: #c6f6d5;
        color: #22543d;
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

    /* Progress bar */
    .progress_wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
    }

    .progress_bar {
        flex: 1;
        height: 8px;
        background: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress_fill {
        height: 100%;
        background: linear-gradient(90deg, #0062A0 0%, #005085 100%);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .progress_text {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
        min-width: 45px;
        text-align: right;
    }

    /* User info display */
    .user_info_display {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .user_name {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .user_department {
        font-size: 12px;
        color: #6b7280;
    }

    /* Deadline warning */
    .field_value.deadline_warning {
        color: #dc3545;
        font-weight: 600;
    }

    .field_value.deadline_overdue {
        color: #991b1b;
        font-weight: 600;
    }

    /* Project info sidebar */
    .project_info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .project_info_item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .project_info_label {
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
    }

    .project_info_value {
        font-size: 14px;
        color: #111827;
        font-weight: 500;
    }

    /* File list */
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

    /* Giao việc list */
    .giaoviec_list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
    }

    .giaoviec_item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .giaoviec_item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .giaoviec_item_left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .giaoviec_item_icon {
        font-family: "FontAwesome" !important;
        color: #0062A0;
        font-size: 18px;
        flex-shrink: 0;
    }

    .giaoviec_item_info {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        min-width: 0;
    }

    .giaoviec_item_name {
        color: #111827;
        font-weight: 600;
        font-size: 14px;
        word-break: break-word;
    }

    .giaoviec_item_meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .giaoviec_item_meta_item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: #6b7280;
    }

    .giaoviec_item_meta_item i {
        font-family: "FontAwesome" !important;
        font-size: 11px;
    }

    .giaoviec_item_right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .giaoviec_item_status {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .giaoviec_item_action {
        padding: 6px 12px;
        background: #0062A0;
        color: #ffffff;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .giaoviec_item_action:hover {
        background: #005085;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 98, 160, 0.2);
        text-decoration: none;
        color: #ffffff;
    }

    .giaoviec_empty {
        padding: 24px;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px dashed #e2e8f0;
    }

    .giaoviec_empty i {
        font-family: "FontAwesome" !important;
        font-size: 24px;
        margin-bottom: 8px;
        display: block;
        color: #cbd5e1;
    }

    /* Footer Actions */
    .box_pop_view_congviec_du_an_footer {
        padding: 24px 24px 0 !important;
        background: #ffffff;
        border-top: 1px solid #e5e7eb;
        margin-top: 24px;
    }

    .box_pop_view_congviec_du_an_actions {
        display: flex;
        gap: 12px;
        justify-content: space-between;
        align-items: center;
    }

    .box_pop_view_congviec_du_an_actions_left {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .box_pop_view_congviec_du_an_actions_right {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-left: auto;
    }

    .box_pop_view_congviec_du_an_actions .btn {
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
    }

    .box_pop_view_congviec_du_an_actions .btn.btn-primary {
        background: #0062A0;
        color: #ffffff;
    }

    .box_pop_view_congviec_du_an_actions .btn.btn-primary:hover:not(:disabled) {
        background: #005085;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
    }

    .box_pop_view_congviec_du_an_actions .btn.btn-secondary {
        background: #f8f9fa;
        color: #373b3f;
        border: 1.5px solid #dee2e6;
    }

    .box_pop_view_congviec_du_an_actions .btn.btn-secondary:hover:not(:disabled) {
        background: #e9ecef;
        border-color: #adb5bd;
        transform: translateY(-1px);
    }
    .box_pop_view_congviec_du_an_actions .btn.btn-danger {
    background: #dc3545;
    color: #ffffff;
    }
    .box_pop_view_congviec_du_an_actions .btn.btn-danger:hover:not(:disabled) {
    background: #c82333;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }
    .box_pop_view_congviec_du_an_actions .btn.btn-draft {
    background: #0062A0;
    color: #ffffff;
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-draft:hover:not(:disabled) {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-draft:disabled {
    background: #9ca3af;
    color: #ffffff;
    cursor: not-allowed;
    opacity: 0.6;
  }
  .box_pop_view_congviec_du_an_actions .btn.btn-giahan {
    background: #ff9800;
    color: #ffffff;
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-giahan:hover:not(:disabled) {
    background: #f57c00;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-success {
    background: #28a745;
    color: #ffffff;
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-success:hover:not(:disabled) {
    background: #218838;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
  }

  /* Nút Primary - Gia hạn (xanh đậm) */
  .box_pop_view_congviec_du_an_actions .btn.btn-primary {
    background: #0062A0;
    color: #ffffff;
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-primary:hover:not(:disabled) {
    background: #005085;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
  }

  /* Nút Secondary - Báo cáo (xanh nhạt/xám/viền) */
  .box_pop_view_congviec_du_an_actions .btn.btn-secondary {
    background: #f8f9fa;
    color: #373b3f;
    border: 1.5px solid #dee2e6;
  }

  .box_pop_view_congviec_du_an_actions .btn.btn-secondary:hover:not(:disabled) {
    background: #e9ecef;
    color: #495057;
    border-color: #adb5bd;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .box_pop_view_congviec_du_an_actions .btn:active:not(:disabled) {
    transform: translateY(0);
  }

  /* Table công việc giao phó */
  .table_wrapper {
    width: 100%;
    overflow: hidden;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    max-height: calc(3 * 60px + 50px); /* 3 dòng + header */
    display: flex;
    flex-direction: column;
  }

  .table_giaoviec_giaopho {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    font-size: 14px;
    table-layout: fixed;
  }

  .table_giaoviec_giaopho thead {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    display: table-header-group;
  }

  .table_giaoviec_giaopho thead th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #374151;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
  }

  .table_giaoviec_giaopho thead th:first-child {
    text-align: center;
    width: 60px;
  }

  .table_giaoviec_giaopho thead th:nth-child(2) {
    width: auto;
  }

  .table_giaoviec_giaopho thead th:nth-child(3),
  .table_giaoviec_giaopho thead th:nth-child(4),
  .table_giaoviec_giaopho thead th:nth-child(5) {
    text-align: center;
    width: 150px;
  }

  .table_giaoviec_giaopho thead th:last-child {
    text-align: center;
    width: 150px;
  }

  .table_giaoviec_giaopho tbody {
    display: block;
    max-height: calc(3 * 60px); /* Chỉ hiển thị 3 dòng */
    overflow-y: auto;
    overflow-x: hidden;
  }

  .table_giaoviec_giaopho tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
    border-bottom: 1px solid #e2e8f0;
    transition: background-color 0.2s ease;
  }

  /* Đảm bảo các cột trong tbody có cùng width với header */
  .table_giaoviec_giaopho thead,
  .table_giaoviec_giaopho tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }

  .table_giaoviec_giaopho tbody tr:hover {
    background-color: #f8fafc;
  }

  .table_giaoviec_giaopho tbody tr:last-child {
    border-bottom: none;
  }

  .table_giaoviec_giaopho tbody td {
    padding: 14px 16px;
    color: #111827;
    vertical-align: middle;
    word-wrap: break-word;
  }

  .table_giaoviec_giaopho tbody td:first-child {
    text-align: center;
    font-weight: 500;
    color: #6b7280;
    width: 60px;
  }

  .table_giaoviec_giaopho tbody td:nth-child(3),
  .table_giaoviec_giaopho tbody td:nth-child(4),
  .table_giaoviec_giaopho tbody td:nth-child(5) {
    text-align: center;
    width: 150px;
  }

  .table_giaoviec_giaopho tbody td:last-child {
    text-align: center;
    width: 150px;
  }

  /* Custom scrollbar cho tbody */
  .table_giaoviec_giaopho tbody::-webkit-scrollbar {
    width: 6px;
  }

  .table_giaoviec_giaopho tbody::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
  }

  .table_giaoviec_giaopho tbody::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
  }

  .table_giaoviec_giaopho tbody::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }

  .table_giaoviec_giaopho tbody td:first-child {
    text-align: center;
    font-weight: 500;
    color: #6b7280;
  }

  .table_giaoviec_giaopho tbody td:last-child {
    text-align: center;
  }
 
  /* Responsive cho table */
  @media (max-width: 768px) {
    .table_wrapper {
      overflow-x: scroll;
    }

    .table_giaoviec_giaopho {
      min-width: 600px;
    }

    .table_giaoviec_giaopho thead th,
    .table_giaoviec_giaopho tbody td {
      padding: 10px 12px;
      font-size: 13px;
    }
  }
  .deadline_display{
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
</style>

<script>
    // Close button
    $(document).on('click', '.box_pop_view_congviec_du_an_close', function () {
        $('.box_pop_congviec_du_an').hide();
        $('.box_pop_congviec_du_an').html('');
    });

    // Click outside to close
    $(document).on('click', '.box_pop_view_congviec_du_an', function (e) {
        if ($(e.target).hasClass('box_pop_view_congviec_du_an')) {
            $('.box_pop_congviec_du_an').hide();
            $('.box_pop_congviec_du_an').html('');
        }
    });

</script>