<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;">
                <!-- Header -->
                <div class="list_header">
                    <div class="header_title">
                        <h2><i class="fa fa-check-circle"></i> Lịch sử dự án đã hoàn thành</h2>
                        <span class="total_count">Tổng: <strong>{total}</strong> công việc</span>
                    </div>
                </div>

                <!-- List -->
                <div class="list_giaoviec_du_an">
                    <table class="table_du_an" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="60" class="text-center">STT</th>
                                <th>Tên dự án</th>
                                <th width="180" class="text-center">Người nhận</th>
                                <th width="180" class="text-center">Mức độ ưu tiên</th>
                                <th width="140" class="text-center">Ngày hoàn thành</th>
                                <th width="130" class="text-center">Trạng thái</th>
                                <th width="110" class="text-center sticky-column">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="list_lichsu_du_an">
                            {list_lichsu_du_an}
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="list_phantrang" id="phantrang_lichsu_du_an">
                    {phantrang}
                </div>

                <!-- Empty State -->
                <div class="empty_state" id="empty_state" style="display: none;">
                    <div class="empty_icon">
                        <i class="fa fa-clipboard-check"></i>
                    </div>
                    <div class="empty_text">
                        <h3>Chưa có dự án nào đã hoàn thành</h3>
                        <p>Danh sách các dự án đã hoàn thành sẽ hiển thị ở đây</p>
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

.header_title h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 10px;
}

.header_title h2 i {
    color: #059669;
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

/* List Items */
.list_giaoviec_du_an {
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
    margin: 0;
    color: #718096;
    font-size: 14px;
}

.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .list_header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .table_du_an {
        font-size: 12px;
    }

    .table_du_an th,
    .table_du_an td {
        padding: 10px 8px;
    }
}

</style>
