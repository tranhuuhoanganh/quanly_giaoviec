<tr id="row_{id}">
    <td class="text-center">
        <input type="checkbox" class="row_checkbox" value="{id}" data-id="{id}">
    </td>
    <td>
        <div class="congviec_name">{ten_congviec}</div>
    </td>
    <td>
        <div class="nguoi_nhan_info">
            <div class="nguoi_nhan_name">{ten_nguoi_nhan}</div>
            <div class="nguoi_nhan_department">{ten_phongban_nhan}</div>
        </div>
    </td>
    <td class="text-center">
        <div class="deadline_display">
            <div class="deadline_date">{han_hoan_thanh}</div>
        </div>
    </td>
    <td class="text-center">
        <span class="status_badge status_{trang_thai}">{trang_thai_text}</span>
    </td>
    <td class="text-center">
        <div class="action_icons">
            <button class="action_icon copy" title="Sao chép" data-id="{id}" name="copy_congviec">
                <i class="fa fa-copy"></i>
            </button>
            <button class="action_icon edit" title="Sửa" data-id="{id}" name="edit_congviec">
                <i class="fa fa-pencil"></i>
            </button>
        </div>
    </td>
</tr>

<style>
.congviec_name {
    font-weight: 500;
    color: #2d3748;
    font-size: 14px;
    line-height: 1.4;
}

.nguoi_nhan_info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nguoi_nhan_name {
    font-weight: 500;
    color: #2d3748;
    font-size: 14px;
    line-height: 1.4;
}

.nguoi_nhan_department {
    font-size: 12px;
    color: #718096;
    line-height: 1.3;
}

.deadline_display {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.deadline_date {
    font-weight: 500;
    font-size: 14px;
    color: #374151;
    line-height: 1.4;
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

.text-center {
    text-align: center;
}
</style>

