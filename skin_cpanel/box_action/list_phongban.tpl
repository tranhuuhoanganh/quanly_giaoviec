<div class="hierarchy-content" data-id="{id}" data-parent-id="{parent_id}" data-level="{level}">
    <div class="hierarchy-icon">
        <i class="fa fa-building"></i>
    </div>
    <div class="hierarchy-info">
        <div class="hierarchy-title">
            <span class="title-text">{title}</span>
            <span class="title-count">({children_count})</span>
            <i class="fa fa-pencil edit-title-icon" data-id="{id}" title="Sửa tiêu đề"></i>
        </div>
    </div>
    <div class="hierarchy-actions">
        <button class="btn-action btn-add" name = "box_pop_add_user" data-id="{id}" title="Thêm nhân sự">
            <i class="fa fa-cog"></i> Thêm nhân sự
        </button>
        <button class="btn-action btn-nhan_su" name="box_pop_list_user" title="Nhân sự trong phòng" data-id="{id}">
            <i class="fa fa-users"></i> Nhân sự trong phòng
        </button>
        <button class="btn-action btn-delete" name="box_pop_delete_phongban" title="Xóa" data-id="{id}">
            <i class="fa fa-trash"></i> Xóa phòng
        </button>
    </div>
</div>