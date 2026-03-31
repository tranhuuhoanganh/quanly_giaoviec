<tr id="row_{id}">
    <td class="text-center">
        <div>{i}</div>
    </td>
    <td>
        <div class="du_an_name">{ten_du_an}</div>
    </td>
    <td>
        <div class="nguoi_tao_info">
            <div class="nguoi_tao_name">{ten_nguoi_tao}</div>
            <div class="nguoi_tao_department">{ten_phongban}</div>
        </div>
    </td>
    <td class="text-center">
        <span class="priority_badge priority_{mucdo_uutien}">{mucdo_uutien_text}</span>
    </td>
    <td class="text-center">
        <div class="ngay_tao_display">
            <div class="ngay_tao_date">{ngay_tao}</div>
        </div>
    </td>
    <td class="text-center">
        {trang_thai_text}
    </td>
    <td class="text-center">
        <div class="action_icons">
            <button class="action_icon view" title="Xem" data-id="{id}" name="box_pop_view_lichsu_du_an">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </td>
</tr>

<style>
.du_an_name {
    font-weight: 500;
    color: #2d3748;
    font-size: 14px;
    line-height: 1.4;
}

.nguoi_tao_info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.nguoi_tao_name {
    font-weight: 500;
    color: #2d3748;
    font-size: 14px;
    line-height: 1.4;
}

.nguoi_tao_department {
    font-size: 12px;
    color: #718096;
    line-height: 1.3;
}

.ngay_tao_display {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.ngay_tao_date {
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

.priority_badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
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

.text-center {
    text-align: center;
}
</style>

