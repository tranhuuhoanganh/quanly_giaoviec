<tr id="{id}">
    <td class="text-center">{i}</td>
    <td>
        <div class="project_name">{ten_congviec}</div>
    </td>
    <td>
        <div class="creator_info">
            <div class="creator_name">{ten_nguoi_giao}</div>
            <div class="creator_role">{ten_phongban_giao}</div>
        </div>
    </td>
    <td>
        <div class="creator_info">
            <div class="creator_name">{ten_nguoi_nhan}</div>
            <div class="creator_role">{ten_phongban_nhan}</div>
        </div>
    </td>
    <td class="text-center">{han_hoanthanh}</td>
</tr>

<style>
.project_name {
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
}

.creator_info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.creator_name {
    font-weight: 600;
    color: #2d3748;
    font-size: 14px;
    line-height: 1.4;
}

.creator_role {
    font-size: 12px;
    color: #0062a0;
    font-weight: 500;
    line-height: 1.3;
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

.action_buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
    align-items: center;
}

.btn_action {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.btn_action.btn_view {
    background: #ffffff;
    color: #0062A0;
    border: 1px solid #e2e8f0;
}

.btn_action.btn_view:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.2);
    border-color: #0062A0;
}

.btn_action.btn_edit {
    background: #ffffff;
    color: #0062A0;
    border: 1px solid #e2e8f0;
}

.btn_action.btn_edit:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 98, 160, 0.2);
    border-color: #0062A0;
}

.btn_action.btn_delete {
    background: #ffffff;
    color: #D32F2F;
    border: 1px solid #e2e8f0;
}

.btn_action.btn_delete:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(211, 47, 47, 0.2);
    border-color: #D32F2F;
}

.btn_action i {
    font-size: 14px;
}

.text-center {
    text-align: center;
}
/* Deadline countdown styles */

  
  .deadline_date {
    font-weight: 600;
    font-size: 14px;
    color: #374151;
    line-height: 1.4;
  }
  
  .deadline_countdown {
    font-size: 13px;
  }
  
  .deadline_countdown_text {
    color: #059669;
    font-weight: 500;
  }
  
  .deadline_countdown_text.deadline_soon_text {
    color: #f59e0b;
  }
  
  .deadline_countdown_text.deadline_warning_text {
    color: #dc2626;
    font-weight: 600;
    animation: pulse 1s infinite;
  }
  
  .deadline_overdue_text {
    color: #dc2626;
    font-weight: 500;
  }
  
  .deadline_no_date {
    color: #9ca3af;
    font-style: italic;
  }
</style>
