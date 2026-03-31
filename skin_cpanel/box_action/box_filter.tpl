<div class="box_pop_filter">
    <div class="box_pop_filter_dialog">
        <div class="box_pop_filter_content">
            <div class="box_pop_filter_header">
                <div class="box_pop_filter_title_wrapper">
                    <h5 class="box_pop_filter_title">Lọc {title}</h5>
                </div>
                <button type="button" class="box_pop_filter_close" aria-label="Đóng">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="box_pop_filter_body">
                <form id="form_filter" class="form_filter">
                    <div class="form_group">
                        <label class="form_label" for="ten_congviec">Tên {title}:</label>
                        <input type="text" 
                               class="form_input" 
                               id="search_keyword" 
                               name="search_keyword" 
                               placeholder="Nhập tên {title}...">
                    </div>
                    <div class="form_group">
                        <label class="form_label" for="nguoi_tao">Người tạo:</label>
                        <select name="nguoi_tao" class="form_select">
                            {list_nguoi_tao}
                        </select>
                    </div>
                    <div class="form_group">
                        <label class="form_label" for="nguoi_nhan">Người nhận công việc:</label>
                        <select name="nguoi_nhan" class="form_select">
                            {list_nguoi_tao}
                        </select>
                    </div>
                    <div class="form_group">
                        <label class="form_label" for="trang_thai">Trạng thái:</label>
                        <select name="trang_thai" class="form_select">
                            <option value="">Tất cả</option>
                            <option value="0">Chờ xử lý</option>
                            <option value="1">Đang thực hiện</option>
                            <option value="2">Chờ phê duyệt</option>
                            <option value="3">Miss Deadline</option>
                            <option value="4">Từ chối</option>  
                            <option value="5">Xin gia hạn</option>
                            <option value="6">Hoàn thành</option>
                        </select>
                    </div>
                    <div class="form_group">
                        <label class="form_label" for="ngay_tao">Ngày tạo:</label>
                        <div class="form_group_date">
                            <div>
                                <label class="form_label" for="ngay_tao_tu">Từ ngày:</label>
                                <input type="date" 
                                       class="form_input" 
                                       id="ngay_tao_tu" 
                                       name="ngay_tao_tu">
                            </div>
                            <div>
                                <label class="form_label" for="ngay_tao_den">Đến ngày:</label>
                                <input type="date" 
                                       class="form_input" 
                                       id="ngay_tao_den" 
                                       name="ngay_tao_den">
                            </div>
                        </div>
                        
                    </div>

                    <div class="form_group">
                        <label class="form_label" for="ngay_hoanthanh">Hạn hoàn thành công việc:</label>
                        <div class="form_group_date">
                            <div>
                                <label class="form_label" for="ngay_hoanthanh_tu">Từ ngày:</label>
                                <input type="date" 
                                       class="form_input" 
                                       id="ngay_hoanthanh_tu" 
                                       name="ngay_hoanthanh_tu">
                            </div>
                            <div>
                                <label class="form_label" for="ngay_hoanthanh_den">Đến ngày:</label>
                                <input type="date" 
                                       class="form_input" 
                                       id="ngay_hoanthanh_den" 
                                       name="ngay_hoanthanh_den">
                            </div>
                        </div>
                    </div>

                    <div class="form_actions">
                        <button type="button" class="btn btn_reset" id="btn_reset_filter">
                            <i class="fa fa-refresh"></i> Đặt lại
                        </button>
                        <button type="button" class="btn btn_submit" id="{submit_filter}">
                            <i class="fa fa-filter"></i> Áp dụng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reset và base styles */
    .box_pop_filter,
    .box_pop_filter * {
        box-sizing: border-box;
    }

    .box_pop_filter {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Overlay modal */
    .box_pop_filter {
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
    .box_pop_filter_dialog {
        width: 100%;
        max-width: 500px;
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
    .box_pop_filter_content {
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .box_pop_filter_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: #ffffff;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
    }

    .box_pop_filter_title_wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .box_pop_filter_title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        letter-spacing: 0.2px;
    }

    .box_pop_filter_close {
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

    .box_pop_filter_close i {
        font-size: 16px;
        font-family: "FontAwesome" !important;
    }

    .box_pop_filter_close:hover {
        background: #e5e7eb;
        color: #374151;
        transform: scale(1.05);
    }

    .box_pop_filter_close:active {
        transform: scale(0.95);
    }

    /* Body */
    .box_pop_filter_body {
        padding: 24px;
    }

    /* Form */
    .form_filter {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .form_group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form_label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .form_input,.form_select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        color: #111827;
        background: #ffffff;
        transition: all 0.2s ease;
        outline: none;
    }

    .form_input:focus,.form_select:focus {
        border-color: #0062A0;
        box-shadow: 0 0 0 3px rgba(0, 98, 160, 0.1);
    }

    .form_input::placeholder,.form_select::placeholder {
        color: #9ca3af;
    }

    /* Form Actions */
    .form_actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 8px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .form_actions .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .form_actions .btn_reset {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .form_actions .btn_reset:hover {
        background: #e5e7eb;
        border-color: #9ca3af;
    }

    .form_actions .btn_submit {
        background: #0062A0;
        color: #ffffff;
    }

    .form_actions .btn_submit:hover {
        background: #005085;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 98, 160, 0.3);
    }

    .form_actions .btn:active {
        transform: translateY(0);
    }

    .form_actions .btn i {
        font-size: 14px;
    }
    .form_group_date {
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: space-between;
    }
</style>

<script>
    // Close button
    $(document).on('click', '.box_pop_filter_close', function () {
        $('.box_pop_add').hide();
        $('.box_pop_add').html('');
    });

    // Click outside to close
    $(document).on('click', '.box_pop_filter', function (e) {
        if ($(e.target).hasClass('box_pop_filter')) {
            $('.box_pop_add').hide();
            $('.box_pop_add').html('');
        }
    });

    // Reset button
    $(document).on('click', '#btn_reset_filter', function () {
        $('#form_filter')[0].reset();
    });

    // Submit button
</script>

