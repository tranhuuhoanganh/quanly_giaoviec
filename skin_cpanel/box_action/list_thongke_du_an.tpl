<div class="box_right">
    <div class="box_right_content">
        <div class="box_container">
            <div class="box_container_left" style="width: 100%;">
                <!-- Search and Filter Section -->
                <div class="thongke_du_an_search_filter">
                    <div class="search_input_wrapper">
                        <input type="text" name="search_keyword" class="search_input" 
                            placeholder="Tìm kiếm dự án..." id="search_du_an">
                        <button type="button" class="btn_search" id="btn_search_du_an">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <button type="button" class="btn_filter" id="btn_filter_du_an">
                        <i class="fa fa-filter"></i> Lọc
                    </button>
                    <button type="button" class="btn_export" id="btn_export_du_an">
                        <i class="fa fa-file-excel-o"></i> Xuất dữ liệu
                    </button>
                </div>

                <!-- Table -->
                <div class="thongke_du_an_table_wrapper">
                    <table class="table_thongke_du_an" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">
                                    <div>STT</div>
                                </th>
                                <th>
                                    <span>Tên dự án</span>
                                </th>
                                <th width="200">
                                    <span>Người tạo</span>
                                </th>
                                <th width="150" class="text-center">
                                    <span>Mức độ ưu tiên</span>
                                </th>
                                <th width="180" class="text-center">
                                    <span>Ngày tạo</span>
                                </th>
                                <th width="150" class="text-center">
                                    <span>Trạng thái</span>
                                </th>
                                <th width="120" class="text-center">Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody id="list_thongke_du_an">
                            {list_thongke_du_an}
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="list_phantrang" id="phantrang_thongke_du_an">
                    {phantrang}
                </div>

                <!-- Empty State -->
                <div class="empty_state" id="empty_state_du_an" style="display: none;">
                    <div class="empty_icon">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div class="empty_text">
                        <h3>Chưa có dự án nào</h3>
                        <p>Bắt đầu bằng cách tạo dự án mới</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Search and Filter Section */
    .thongke_du_an_search_filter {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .search_input_wrapper {
        display: flex;
        align-items: center;
        gap: 0;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        width: 100%;
    }

    .search_input {
        width: 100%;
        padding: 8px 12px;
        border: none;
        background: transparent;
        font-size: 14px;
        color: #2d3748;
        outline: none;
    }

    .search_input::placeholder {
        color: #a0aec0;
    }

    .btn_search {
        width: 40px;
        height: 40px;
        background: #0062a0;
        border: none;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }

    .btn_search:hover {
        background: #005080;
    }

    .btn_search i {
        font-size: 14px;
    }

    .btn_filter {
        padding: 8px 16px;
        height: 40px;
        background: #2563EB;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .btn_filter:hover {
        background: #2556c0;
    }

    .btn_filter i {
        font-size: 13px;
    }
    .btn_export {
        padding: 8px 16px;
        height: 40px;
        background: #22C55E;
        border: none;
        border-radius: 4px;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    .btn_export:hover {
        background: #1b9648;
    }

    .btn_export i {
        font-size: 13px;
    }



    /* Table */
    .thongke_du_an_table_wrapper {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .table_thongke_du_an {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .table_thongke_du_an thead {
        background: #f8f9fa;
    }

    .table_thongke_du_an th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: #2d3748;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .table_thongke_du_an th.text-center {
        text-align: center;
    }

    .table_thongke_du_an th span {
        display: inline-flex;
        align-items: center;
    }

    .sort-icon {
        color: #a0aec0;
        font-size: 12px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .sort-icon:hover {
        color: #0062a0;
    }

    .table_thongke_du_an td {
        padding: 14px 16px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
        font-size: 14px;
        color: #2d3748;
    }

    .table_thongke_du_an tbody tr {
        transition: background-color 0.15s ease;
    }

    .table_thongke_du_an tbody tr:hover {
        background: #f8f9fa;
    }

    .table_thongke_du_an tbody tr:last-child td {
        border-bottom: none;
    }

    /* Checkbox */
    .table_thongke_du_an input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #0062a0;
    }

    /* Action Icons */
    .action_icons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .action_icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
        border: none;
    }

    .action_icon.view {
        width: 32px;
        height: 32px;
        padding: 0;
        background: #ffffff;
        color: #0062A0;
        border: 1.5px solid #0062A0;
        box-shadow: 0 1px 3px rgba(0, 98, 160, 0.1);
    }

    .action_icon.view:hover {
        background: #f0f7ff;
        color: #005085;
        border-color: #005085;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 98, 160, 0.2);
    }

    .action_icon i {
        font-size: 16px;
    }

    /* Empty State */
    .empty_state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .empty_icon {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 16px;
    }

    .empty_text h3 {
        margin: 0 0 8px 0;
        font-size: 18px;
        color: #2d3748;
        font-weight: 600;
    }

    .empty_text p {
        margin: 0;
        color: #718096;
        font-size: 14px;
    }

    /* Pagination */
    .list_phantrang {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .thongke_du_an_search_filter {
            flex-wrap: wrap;
        }

        .search_input_wrapper {
            width: 100%;
        }

        .btn_filter {
            flex: 1;
        }

        .table_thongke_du_an {
            font-size: 12px;
        }

        .table_thongke_du_an th,
        .table_thongke_du_an td {
            padding: 10px 8px;
        }
    }
</style>

<script>
$(document).ready(function () {
    $('#select_all_du_an').on('change', function () {
        let isChecked = $(this).is(':checked');
        $('.row_checkbox').prop('checked', isChecked);
    });
});
</script>

