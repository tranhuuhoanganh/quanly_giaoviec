<tr id="{id}">
    <td class="text-center">{i}</td>
    <td>
        <div class="creator_info">
            <div class="creator_name">{ten_nhanvien}</div>
            <div class="creator_role">{ten_phongban_nhan}</div>
        </div>
    </td>
   
    <td class="text-center">{so_congviec}</td>
    <td class="text-center">{so_congviec_cho_xuly}</td>
    <td class="text-center">{so_congviec_dang_thuchien}</td>
    <td class="text-center">{so_congviec_da_hoanthanh}</td>
    <td class="text-center">{so_congviec_quahangthanh}</td>
    <td class="text-center">{tien_do_hoanthanh}</td>
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
