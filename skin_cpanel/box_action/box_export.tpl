<div class="box_pop_export">
    <div class="box_pop_export_dialog">
        <div class="box_pop_export_content">
            <div class="box_pop_export_header">
                <div class="box_pop_export_title_wrapper">
                    <h5 class="box_pop_export_title">Xuất dữ liệu {title}</h5>
                </div>
                <button type="button" class="box_pop_export_close" aria-label="Đóng">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <div class="box_pop_export_body">
                <form id="form_export" class="form_export">
                    <div class="form_group">
                        <label class="form_label" for="nguoi_dung">Người dùng:</label>
                        <select name="nguoi_dung" class="form_select">
                            {list_nguoi_tao}
                        </select>
                    </div>
                    </div>

                    <div class="form_actions">
                        <button type="button" class="btn btn_submit" id="{submit_export}">
                            <i class="fa fa-file-excel-o"></i> Xuất dữ liệu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reset và base styles */
    .box_pop_export,
    .box_pop_export * {
        box-sizing: border-box;
    }

    .box_pop_export {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Overlay modal */
    .box_pop_export {
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
        backdrop-export: blur(4px);
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
    .box_pop_export_dialog {
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
    .box_pop_export_content {
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
    }

    /* Header */
    .box_pop_export_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: #ffffff;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
    }

    .box_pop_export_title_wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .box_pop_export_title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        letter-spacing: 0.2px;
    }

    .box_pop_export_close {
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

    .box_pop_export_close i {
        font-size: 16px;
        font-family: "FontAwesome" !important;
    }

    .box_pop_export_close:hover {
        background: #e5e7eb;
        color: #374151;
        transform: scale(1.05);
    }

    .box_pop_export_close:active {
        transform: scale(0.95);
    }

    /* Body */
    .box_pop_export_body {
        padding: 24px 24px 0 24px;
    }

    /* Form */
    .form_export {
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
        margin: 24px;
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

