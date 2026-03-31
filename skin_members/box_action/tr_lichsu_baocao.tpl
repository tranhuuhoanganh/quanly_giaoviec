<tr id="tr_lichsu_baocao_{id}" class="tr_lichsu_baocao_row">
    <td class="text-center stt_cell">{i}</td>
    <td class="date_cell">{date_post}</td>
    <td class="text-center progress_cell">
        <span class="progress_badge {tiendo_class}">{tiendo_hoanthanh}</span>
    </td>
    <td class="text-center status_cell">
        {trang_thai_text}
    </td>
    <td class="text-center action_cell">
        <div class="action_buttons">
            <button class="btn_action btn_view" name="box_pop_view_baocao" data-id="{id}" data-action="{action}" title="Xem chi tiết">
                <i class="fa fa-eye"></i>
            </button>
            {action_buttons}
        </div>
    </td>
</tr>

<style>
.tr_lichsu_baocao_row {
    transition: background-color 0.2s ease;
}

.tr_lichsu_baocao_row:hover {
    background-color: #f8f9fa;
}

.tr_lichsu_baocao_row td {
    padding: 16px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #e5e7eb;
}

.stt_cell {
    font-weight: 600;
    color: #6b7280;
    width: 50px;
}

.date_cell {
    font-size: 13px;
    color: #374151;
    white-space: nowrap;
    min-width: 80px;
    max-width: 90px;
}

.progress_cell {
    min-width: 70px;
    max-width: 80px;
    width: 70px;
}

.progress_badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.2px;
}

/* 0-49%: Đỏ (Thấp) */
.progress_badge.progress_low {
    background: #fee2e2;
    color: #dc2626;
}

/* 50-69%: Vàng (Trung bình) */
.progress_badge.progress_medium {
    background: #fef3c7;
    color: #d97706;
}

/* 70-89%: Xanh dương (Tốt) */
.progress_badge.progress_good {
    background: #dbeafe;
    color: #2563eb;
}

/* 90-100%: Xanh lá (Hoàn thành) */
.progress_badge.progress_complete {
    background: #d1fae5;
    color: #059669;
}

.status_cell {
    min-width: 100px;
    max-width: 120px;
    width: 100px;
}

.status_badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.2px;
}

.status_badge.status_pending {
    background: #fef3c7;
    color: #d97706;
}

.status_badge.status_approved {
    background: #d1fae5;
    color: #059669;
}

.status_badge.status_rejected {
    background: #fee2e2;
    color: #dc2626;
}

.status_badge.status_comment {
    background: #dbeafe;
    color: #2563eb;
}

.status_badge.status_commented {
    background: #e0e7ff;
    color: #6366f1;
}

.action_cell {
    width: 100px;
    min-width: 100px;
}

.action_buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    flex-wrap: nowrap;
}

.btn_action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
}

/* Nút Xem - chỉ có icon */
.btn_action.btn_view {
    width: 32px;
    height: 32px;
    padding: 0;
    background: #ffffff;
    color: #0062A0;
    border: 1.5px solid #0062A0;
    box-shadow: 0 1px 3px rgba(0, 98, 160, 0.1);
}

.btn_action.btn_view:hover {
    background: #f0f7ff;
    color: #005085;
    border-color: #005085;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0, 98, 160, 0.2);
}

.btn_action.btn_view:active {
    transform: translateY(0);
}


/* Nút Nhận xét - chỉ có icon */
.btn_action.btn_nhanxet {
    width: 32px;
    height: 32px;
    padding: 0;
    background: #ffffff;
    color: #0062A0;
    border: 1.5px solid #0062A0;
    box-shadow: 0 1px 3px rgba(0, 98, 160, 0.1);
}

.btn_action.btn_nhanxet:hover {
    background: #f0f7ff;
    color: #005085;
    border-color: #005085;
    transform: translateY(-1px);
    box-shadow: 0 3px 6px rgba(0, 98, 160, 0.2);
}

.btn_action.btn_nhanxet:active {
    transform: translateY(0);
}

.btn_action i {
    font-size: 13px;
    font-family: "FontAwesome" !important;
}

.text-center {
    text-align: center;
}
</style>

