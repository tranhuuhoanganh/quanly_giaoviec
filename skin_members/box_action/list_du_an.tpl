<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;">
                <!-- Header -->
                <div class="list_header">
                    <div class="header_title_du_an">
                        <h2><i class="fa fa-project-diagram"></i> Danh sách dự án</h2>
                        <span class="total_count">Tổng: <strong>{total}</strong> dự án</span>
                    </div>
                </div>

                <!-- Filter -->
                <div class="list_filter">
                    <div class="filter_header">
                            <h3>Quản lý dự án</h3>
                    </div>
                    <div class="filter_content">
                            <div class="filter_group">
                                <label class="filter_label">Tìm kiếm</label>
                                <input type="text" name="search_keyword" class="filter_input" placeholder="Tìm kiếm theo tên dự án...">
                            </div>
                            <div class="filter_group">
                                <label class="filter_label">Người quản lý</label>
                                <select name="search_nguoi_quan_ly" class="filter_select">
                                    <option value="">Tất cả</option>
                                    {list_nguoi_quan_ly}
                                </select>
                            </div>
                        <div class="filter_group">
                            <label class="filter_label">Trạng thái</label>
                            <select name="filter_trang_thai" class="filter_select">
                                <option value="">Tất cả</option>
                                <option value="0">Chờ xử lý</option>
                                <option value="1">Đang thực hiện</option>
                                <option value="2">Chờ phê duyệt</option>
                                <option value="3">Miss Deadline</option>
                                <option value="4">Từ chối</option>
                                <option value="5">Xin gia hạn</option>
                            </select>
                        </div>
                        <div class="filter_group">
                            <label class="filter_label">Ngày bắt đầu</label>
                            <input type="date" name="filter_ngay_bat_dau" class="filter_input filter_date" placeholder="Ngày bắt đầu">
                        </div>
                        <div class="filter_group filter_group_button">
                            <label class="filter_label">&nbsp;</label>
                                {search_list}
                        </div>
                    </div>
                </div>

                <!-- List -->
                <div class="list_du_an_wrapper">
                    <table class="table_du_an" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">STT</th>
                                <th>Tên dự án</th>
                                <th width="180">Người tạo dự án</th>
                                <th width="120" class="text-center">Mức độ ưu tiên</th>
                                <th width="120" class="text-center">Ngày tạo</th>
                                <th width="150" class="text-center">Trạng thái</th>
                                <th width="140" class="text-center sticky-column">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="list_du_an">
                            {list_du_an}
                        </tbody>
                    </table>
                </div>
                <div class="list_phantrang" id="phantrang_list_du_an">
                    {phantrang}
                </div>
                <!-- Empty State -->
                <div class="empty_state" id="empty_state" style="display: none;">
                    <div class="empty_icon">
                        <i class="fa fa-project-diagram"></i>
                    </div>
                    <div class="empty_text">
                        <h3>Chưa có dự án nào</h3>
                        <p>Bắt đầu bằng cách tạo dự án mới</p>
                        <a href="/members/add-du-an" class="btn_add_empty">
                            <i class="fa fa-plus"></i> Thêm dự án mới
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Header */
.list_header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: #fff;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.header_title_du_an h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header_title_du_an h2 i {
    color: #0062a0;
}

.total_count {
    font-size: 14px;
    color: #718096;
    margin-left: 15px;
}

.total_count strong {
    color: #0062a0;
    font-weight: 600;
}

.btn_add {
    padding: 10px 20px;
    background: #0062a0;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
}

.btn_add:hover {
    background: #005080;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.3);
}

/* Filter */
.list_filter {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.filter_header {
    height: 55px;
    display: flex;
    align-items: center;
    padding: 0 16px;
    background: #f7fafc;
    border-bottom: 1px solid #e2e8f0;
}

.filter_header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter_header h3 i {
    color: #0062a0;
    font-size: 14px;
}

.filter_content {
    display: flex;
    gap: 8px;
    padding: 12px;
    flex-wrap: wrap;
}

.filter_group {
    flex: 1;
    min-width: 180px;
    display: flex;
    flex-direction: column;
    min-height: 55px;
}

.filter_label {
    font-size: 13px;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    line-height: 1.4;
    height: 20px;
    display: flex;
    align-items: center;
}

.filter_select,
.filter_input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 13px;
    color: #2d3748;
    background: #f7fafc;
    transition: all 0.2s ease;
}

.filter_select:focus,
.filter_input:focus {
    outline: none;
    border-color: #0062a0;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(0, 98, 160, 0.1);
}

.filter_date {
    cursor: pointer;
}

.filter_date::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s ease;
}

.filter_date::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

.filter_group_button {
    display: flex;
    align-items: flex-end;
}

.filter_group_button .btn_filter {
    width: 100%;
    justify-content: center;
}

.btn_filter {
    padding: 8px 16px;
    background: #0062a0;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn_filter:hover {
    background: #005080;
}

/* List Items */
.list_du_an_wrapper {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 12px;
}

.table_du_an {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
}

.table_du_an thead {
    background: #f8f9fa;
}

.table_du_an th {
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 13px;
    color: #2d3748;
    border-bottom: 2px solid #dee2e6;
    white-space: nowrap;
}

.table_du_an th.text-center {
    text-align: center;
}

.table_du_an td {
    padding: 14px 16px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    font-size: 14px;
}

.table_du_an tbody tr {
    transition: background-color 0.15s ease;
}

.table_du_an tbody tr:hover {
    background: #f8f9fa;
}

.table_du_an tbody tr:last-child td {
    border-bottom: none;
}

.sticky-column {
    position: sticky;
    right: 0;
    background: #fff;
    z-index: 10;
    box-shadow: -2px 0 4px rgba(0, 0, 0, 0.05);
}

.table_du_an tbody tr:hover .sticky-column {
    background: #f8f9fa;
}

.du_an_item {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.du_an_item:hover {
    box-shadow: 0 8px 24px rgba(0, 98, 160, 0.12);
    transform: translateY(-2px);
}

.du_an_item.priority_cao {
    border-left-color: #e53e3e;
}

.du_an_item.priority_rat_cao {
    border-left-color: #c53030;
}

.du_an_item.priority_binh_thuong {
    border-left-color: #0062a0;
}

.du_an_item.priority_thap {
    border-left-color: #a0aec0;
}

.item_header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.item_title {
    flex: 1;
}

.item_title h3 {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    line-height: 1.4;
}

.item_meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: #718096;
}

.item_meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.item_meta i {
    color: #0062a0;
    font-size: 12px;
}

.item_badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.badge_priority {
    background: #edf2f7;
    color: #2d3748;
}

.badge_priority.priority_cao {
    background: #fed7d7;
    color: #c53030;
}

.badge_priority.priority_rat_cao {
    background: #fc8181;
    color: #fff;
}

.badge_status {
    background: #e6fffa;
    color: #234e52;
}

.badge_status.status_chua_nhan {
    background: #fed7d7;
    color: #c53030;
}

.badge_status.status_da_nhan {
    background: #feebc8;
    color: #c05621;
}

.badge_status.status_dang_lam {
    background: #bee3f8;
    color: #2c5282;
}

.badge_status.status_hoan_thanh {
    background: #c6f6d5;
    color: #22543d;
}

.item_content {
    margin-bottom: 16px;
}

.item_description {
    font-size: 14px;
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 12px;
}

.item_files {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.file_tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    color: #4a5568;
    text-decoration: none;
    transition: all 0.2s ease;
}

.file_tag:hover {
    background: #edf2f7;
    border-color: #0062a0;
    color: #0062a0;
}

.item_footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #e2e8f0;
}

.item_date {
    font-size: 12px;
    color: #a0aec0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.item_actions {
    display: flex;
    gap: 8px;
}

.btn_action {
    padding: 6px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    background: #fff;
    color: #4a5568;
}

.btn_action:hover {
    border-color: #0062a0;
    color: #0062a0;
    background: #f7fafc;
}

.btn_action.btn_view {
    color: #0062a0;
}

.btn_action.btn_edit {
    color: #d69e2e;
}

.btn_action.btn_delete {
    color: #e53e3e;
}

/* Empty State */
.empty_state {
    text-align: center;
    padding: 40px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.empty_icon {
    font-size: 48px;
    color: #cbd5e0;
    margin-bottom: 16px;
}

.empty_text h3 {
    margin: 0 0 8px 0;
    font-size: 18px;
    color: #2d3748;
}

.empty_text p {
    margin: 0 0 20px 0;
    color: #718096;
    font-size: 14px;
}

.btn_add_empty {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #0062a0;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn_add_empty:hover {
    background: #005080;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 98, 160, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .list_header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .filter_content {
        flex-direction: column;
    }

    .filter_group {
        min-width: 100%;
    }

    .item_header {
        flex-direction: column;
        gap: 12px;
    }

    .item_footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>

