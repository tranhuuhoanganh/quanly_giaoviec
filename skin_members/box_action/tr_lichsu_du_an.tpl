<tr id="tr_lichsu_du_an_{id}" class="tr_lichsu_du_an_row">
    <td class="text-center stt_cell">{i}</td>
    <td class="name_cell">{ten_congviec}</td>
    <td class="text-center">{ten_nguoi_giao}</td>
    <td class="text-center"><span class="priority_badge priority_{mucdo_uutien}">{mucdo_uutien_text}</span></td>
    <td class="text-center date_cell">{ngay_hoanthanh}</td>
    <td class="text-center status_cell">{trang_thai_text}</td>
    <td class="text-center action_cell">
        <div class="action_buttons">
            <button class="btn_action btn_view" name="box_pop_view_lichsu_du_an" data-id="{id}" title="Xem chi tiết">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </td>
</tr>

<style>
.tr_lichsu_du_an_row {
    transition: background-color 0.2s ease;
}

.tr_lichsu_du_an_row:hover {
    background-color: #f8f9fa;
}

.tr_lichsu_du_an_row td {
    padding: 16px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #e5e7eb;
}

.name_cell {
    font-size: 14px;
    color: #111827;
    font-weight: 500;
    max-width: 250px;
    word-break: break-word;
}

.date_cell {
    font-size: 13px;
    color: #374151;
    white-space: nowrap;
    min-width: 120px;
}

.status_cell {
    min-width: 100px;
    max-width: 120px;
    width: 100px;
}

.status_badge {
    display: inline-block;
    padding: 6px 14px;
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
    background: #bee3f8;
    color: #2c5282;
}

.status_badge.status_2 {
    background: #c6f6d5;
    color: #22543d;
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
.stt_cell {
    font-weight: 600;
    color: #6b7280;
    width: 50px;
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

.btn_action i {
    font-size: 13px;
    font-family: "FontAwesome" !important;
}

.text-center {
    text-align: center;
}
</style>
