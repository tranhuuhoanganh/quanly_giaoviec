<div class="box_pop_view_du_an">
  <div class="box_pop_view_du_an_dialog">
    <div class="box_pop_view_du_an_content">

      <div class="box_pop_view_du_an_header">
        <div class="box_pop_view_du_an_title_wrapper">
          <h5 class="box_pop_view_du_an_title">Chi tiết dự án</h5>
        </div>
        <div class="box_pop_view_cai_dat">
          
          <div class="project-setting" style="display: flex; align-items: center; gap: 10px;">
            {hoatdong_nguoi_tao}
            <div class="setting-menu" style="display: none;">
              <button class="menu-item edit" name="box_pop_edit_du_an" data-id="{id}">
                ✏️ Sửa dự án
              </button>
              <button class="menu-item delete" name="box_pop_delete_du_an" data-id="{id}">
                🗑 Xóa dự án
              </button>
              
            </div>
          </div>
          <button type="button" class="box_pop_view_du_an_close" aria-label="Đóng">
            <i class="fa fa-times"></i>
          </button>
        </div>
      </div>

      <div class="box_pop_view_du_an_body">
        <div class="box_pop_view_du_an_content_wrapper">
          
          <!-- Phần trên: Thông tin dự án và Sidebar -->
          <div class="box_pop_view_du_an_top_section">
            <!-- Cột trái: Thông tin dự án -->
            <div class="box_pop_view_du_an_main">
              <div class="box_pop_view_du_an_section">
                <div class="section_header" >
                  <h6 class="section_title">Thông tin dự án</h6>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <div id="status_trang_thai_du_an"><span class="status_badge {trang_thai_class}" id="status_trang_thai_du_an">{trang_thai_text}</span></div>
                    {miss_deadline_text}
                  </div>
                </div>
                
                <div class="section_fields">
                  <div class="field field_full">
                    <label class="field_label">Tên dự án:</label>
                    <div class="field_value">{ten_du_an}</div>
                  </div>

                  <div class="field field_half">
                    <label class="field_label">Mức độ ưu tiên:</label>
                    <div class="field_value">{mucdo_uutien_text}</div>
                  </div>

                  <div class="field field_half">
                    <label class="field_label">Ngày tạo:</label>
                    <div class="field_value">{ngay_tao}</div>
                  </div>

                  <div class="field field_full">
                    <label class="field_label">Mô tả dự án:</label>
                    <div class="field_value field_value_textarea">{mo_ta}</div>
                  </div>

                  <div class="field field_full">
                    <label class="field_label">Ghi chú dự án:</label>
                    <div class="field_value field_value_textarea">{ghi_chu}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cột phải: Sidebar -->
            <div class="box_pop_view_du_an_sidebar">
              <div class="box_pop_view_du_an_section">
                <div class="section_header">
                  <h6 class="section_title">
                    <i class="fa fa-clock-o"></i>
                    Trạng thái công việc :
                  </h6>
                </div>
                
                <div class="deadline_list">
                  <div class="deadline_list_item"> {list_thanh_vien}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="section_header">
            <h6 class="section_title">
              <i class="fa fa-users"></i>
              Sơ đồ phân công
            </h6>
            
          </div>
          <!-- Phần dưới: Sơ đồ phân công full width -->
          <div class="box_pop_view_du_an_section box_pop_view_du_an_section_fullwidth" id="sodo_phan_cong">
            <div class="org_chart_container">
              {so_do_phan_cong}
            </div>
            <script type="text/javascript">
              var orgChartData = {so_do_phan_cong_json};
            </script>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<div class="box_pop_congviec_du_an" style="display: none;"></div>
<style>
  .setting-menu{
    position: absolute;
    top: 110px;
    right: 212px;
    background: #ffffff;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    z-index: 10000;
 
  }

  /* Reset và base styles */
  .box_pop_view_du_an,
  .box_pop_view_du_an * {
    box-sizing: border-box;
  }

  .box_pop_view_du_an {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_view_du_an {
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
  .box_pop_view_du_an_dialog {
    width: 100%;
    max-width: 1400px;
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
  .box_pop_view_du_an_content {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_view_du_an_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_view_du_an_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_view_du_an_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
  }
  .box_pop_view_cai_dat{
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .box_pop_view_du_an_close,
  .box_cai_dat,
  .box_thongke_du_an {
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

  .box_pop_view_du_an_close i,
  .box_cai_dat i,
  .box_thongke_du_an i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_view_du_an_close:hover,
  .box_cai_dat:hover,
  .box_thongke_du_an:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_view_du_an_close:active,
  .box_cai_dat:active,
  .box_thongke_du_an:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_view_du_an_body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
  }

  /* Content wrapper */
  .box_pop_view_du_an_content_wrapper {
    display: flex;
    flex-direction: column;
    gap: 24px;
    width: 100%;
  }

  /* Top section: Thông tin dự án và Sidebar */
  .box_pop_view_du_an_top_section {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    align-items: stretch;
  }

  @media (max-width: 1200px) {
    .box_pop_view_du_an_top_section {
      grid-template-columns: 1fr;
    }
  }

  /* Main và Sidebar - đảm bảo cùng chiều cao */
  .box_pop_view_du_an_main,
  .box_pop_view_du_an_sidebar {
    display: flex;
    flex-direction: column;
  }

  /* Section full width cho sơ đồ */
  .box_pop_view_du_an_section_fullwidth {
    width: 100%;
    margin-bottom: 0;
  }

  /* Section */
  .box_pop_view_du_an_section {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
  }

  /* Section trong sidebar - có flex để deadline_list có thể scroll */
  .box_pop_view_du_an_sidebar .box_pop_view_du_an_section {
    flex: 1;
    height: 100%;
  }

  .section_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e5e7eb;
  }

  .section_header .section_title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .section_header .section_title i {
    color: #667eea;
    font-size: 18px;
  }

  .section_header .section_actions {
    display: flex;
    gap: 6px;
  }

  .section_header .btn_icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 4px;
    color: #6b7280;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .section_header .btn_icon:hover {
    background: #e5e7eb;
    color: #374151;
  }

  .section_header .btn_icon_primary {
    background: #667eea;
    border-color: #667eea;
    color: #ffffff;
  }

  .section_header .btn_icon_primary:hover {
    background: #5568d3;
    border-color: #5568d3;
  }

  /* Fields */
  .section_fields {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
  }

  .section_fields .field {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .section_fields .field_full {
    width: 100%;
  }

  .section_fields .field_half {
    width: calc(50% - 8px);
  }

  @media (max-width: 768px) {
    .section_fields .field_half {
      width: 100%;
    }
  }

  .section_fields .field_label {
    font-size: 13px;
    font-weight: 500;
    color: #6b7280;
  }

  .section_fields .field_value {
    font-size: 14px;
    color: #111827;
    padding: 8px 12px;
    background: #f9fafb;
    border-radius: 6px;
    min-height: 38px;
    display: flex;
    align-items: center;
  }

  .section_fields .field_value_textarea {
    min-height: 60px;
    white-space: pre-wrap;
    word-wrap: break-word;
  }

  /* Status badge */
  .section_header .status_badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
  }

  .section_header .status_badge.status_0 {
    background: #feebc8;
    color: #c05621;
  }

  .section_header .status_badge.status_1 {
    background: #feebc8;
    color: #c05621;
  }

  .section_header .status_badge.status_2 {
    background: #bee3f8;
    color: #2c5282;
  }

  .section_header .status_badge.status_3 {
    background: #f5c2c7;
    color: #842029;
  }

  .section_header .status_badge.status_4 {
    background: #f8d7da;
    color: #842029;
  }

  .section_header .status_badge.status_5 {
    background: #fff3cd;
    color: #856404;
  }

  .section_header .status_badge.status_6 {
    background: #c6f6d5;
    color: #22543d;
  }

  /* Org chart */
  .org_chart_container {
    min-height: 500px;
    height: 600px;
    background: #f9fafb;
    border-radius: 6px;
    overflow: auto;
    width: 100%;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  #orgchart-container {
    width: 100%;
    min-height: 600px;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    text-align: center;
  }

  /* Custom OrgChart.js styles */
  .orgchart {
    background: transparent !important;
    padding: 40px 60px;
    margin: 0 auto;
    display: inline-block;
    text-align: center;
  }

  .orgchart table {
    margin: 0 auto;
    border-collapse: separate;
    border-spacing: 0;
    width: auto;
  }

  /* Đảm bảo các node cùng cấp thẳng hàng */
  .orgchart td {
    padding: 20px 40px;
    vertical-align: top;
    text-align: center;
  }

  /* Căn giữa node đầu tiên (root) */
  .orgchart > table > tbody > tr:first-child > td {
    text-align: center;
  }

  .orgchart > table > tbody > tr:first-child > td > .node {
    margin: 0 auto;
  }

  /* Đảm bảo căn giữa container */
  #orgchart-container > .orgchart {
    margin-left: auto;
    margin-right: auto;
    display: block;
  }

  /* Căn giữa tất cả các node */
  .orgchart .node {
    margin-left: auto;
    margin-right: auto;
  }

  /* Bỏ đường kẻ caro (grid pattern) */
  .orgchart,
  .orgchart *,
  #orgchart-container,
  #orgchart-container *,
  .orgchart .canvas,
  .orgchart .canvas * {
    background-image: none !important;
    background: transparent !important;
  }

  #orgchart-container {
    background: #f9fafb !important;
    background-image: none !important;
  }

  .org_chart_container {
    background: #f9fafb !important;
    background-image: none !important;
  }

  .orgchart .canvas {
    background: transparent !important;
    background-image: none !important;
  }

  /* Loại bỏ tất cả pattern và grid */
  .orgchart::before,
  .orgchart::after,
  #orgchart-container::before,
  #orgchart-container::after,
  .orgchart .canvas::before,
  .orgchart .canvas::after {
    display: none !important;
    background: none !important;
    background-image: none !important;
  }

  .orgchart .node {
    background: #f5f5dc;
    border: 2px solid #ff8c00;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    padding: 0;
    width: 280px;
    min-width: 280px;
    max-width: 280px;
    height: auto;
    display: inline-block;
    vertical-align: top;
  }

  .orgchart .node.root {
    background: #d1f2eb;
    border: 2px solid #28a745;
  }

  .orgchart .node:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
  }

  .orgchart-node-content {
    padding: 18px;
    text-align: center;
    width: 100%;
    box-sizing: border-box;
  }

  .orgchart-node-avatar {
    width: 48px;
    height: 48px;
    margin: 0 auto 10px;
    background: #2c3e50;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  .orgchart .node.root .orgchart-node-avatar {
    background: #155724;
  }

  .orgchart-node-name {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
    word-wrap: break-word;
    line-height: 1.4;
  }

  .orgchart-node-title {
    font-size: 14px;
    color: #374151;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-weight: 500;
  }

  .orgchart-node-title i {
    color: #2c3e50;
    font-size: 14px;
  }

  .orgchart-node-department {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .orgchart-node-department i {
    font-size: 13px;
    color: #9ca3af;
  }

  .orgchart-node-date {
    font-size: 12px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .orgchart-node-date.ngay-giao {
    color: #0066cc;
  }

  .orgchart-node-date.ngay-giao i {
    color: #0066cc;
    font-size: 12px;
  }

  .orgchart-node-date.deadline {
    color: #dc3545;
  }

  .orgchart-node-date.deadline i {
    color: #dc3545;
    font-size: 12px;
  }

  .orgchart-node-badge {
    margin-top: 8px;
    padding: 4px 12px;
    background: #e5e7eb;
    border: 1px solid #6b7280;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    display: inline-block;
  }

  .orgchart-node-role {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
    font-style: italic;
  }

  /* Đường nối - để tự nhiên theo số node */
  .orgchart .lines .downLine {
    background-color: #1e3a8a;
    border-color: #1e3a8a;
    width: 3px;
  }

  .orgchart .lines .rightLine,
  .orgchart .lines .leftLine {
    border-color: #1e3a8a;
    border-width: 2px;
  }

  .orgchart .lines .topLine {
    border-color: #1e3a8a;
    border-width: 2px;
  }

  /* Đảm bảo các node cùng cấp thẳng hàng ngang */
  .orgchart table tbody tr {
    display: table-row;
  }

  .orgchart table tbody tr td {
    vertical-align: top;
    text-align: center;
  }

  /* Đảm bảo các node con cùng cấp được căn đều */
  .orgchart .nodes {
    display: inline-block;
    text-align: center;
  }

  .org_chart_node {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    margin-bottom: 30px;
  }

  .org_chart_node[data-level="0"] {
    margin-bottom: 40px;
  }

  .org_chart_arrow {
    width: 4px;
    height: 35px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    margin-bottom: 10px;
    position: relative;
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
  }

  .org_chart_arrow::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-top: 12px solid #667eea;
    filter: drop-shadow(0 2px 2px rgba(102, 126, 234, 0.3));
  }

  .org_chart_item {
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    min-width: 220px;
    max-width: 280px;
    width: 100%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
  }

  .org_chart_item:hover {
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.15);
    transform: translateY(-4px);
    border-color: #667eea;
  }

  .org_chart_avatar {
    width: 56px;
    height: 56px;
    margin: 0 auto 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
  }

  .org_chart_name {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 12px;
    word-wrap: break-word;
    line-height: 1.4;
  }

  .org_chart_info {
    text-align: left;
    font-size: 13px;
    color: #6b7280;
    margin-top: 8px;
  }

  .org_chart_person {
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #374151;
    font-weight: 500;
  }

  .org_chart_person i {
    color: #667eea;
    font-size: 13px;
    width: 16px;
    text-align: center;
  }

  .org_chart_department {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #9ca3af;
    font-size: 12px;
  }

  .org_chart_department i {
    font-size: 12px;
    width: 16px;
    text-align: center;
  }

  .org_chart_children {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
    align-items: flex-start;
    margin-top: 15px;
    padding-top: 20px;
    position: relative;
    width: 100%;
  }

  /* Đường kết nối từ cha xuống các con (chỉ hiển thị khi có nhiều hơn 1 con) */
  .org_chart_children::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 20px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
  }

  /* Đường ngang kết nối các node con cùng cấp (chỉ khi có nhiều hơn 1 con) */
  .org_chart_node[data-level="0"] > .org_chart_children::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
  }

  /* Đường dọc từ đường ngang xuống từng node con */
  .org_chart_node[data-level="0"] > .org_chart_children > .org_chart_node::before {
    content: '';
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 20px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
  }

  /* Khi chỉ có 1 con, chỉ hiển thị mũi tên thẳng */
  .org_chart_node[data-level="0"] > .org_chart_children:only-child::after {
    display: none;
  }

  /* Đường kết nối cho các cấp sâu hơn */
  .org_chart_node[data-level="1"] > .org_chart_children::before,
  .org_chart_node[data-level="2"] > .org_chart_children::before,
  .org_chart_node[data-level="3"] > .org_chart_children::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 4px;
    height: 20px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
  }

  .org_chart_empty {
    text-align: center;
    padding: 40px 20px;
    color: #9ca3af;
    font-size: 14px;
  }

  /* Deadline list */
  .deadline_list {
    max-height: 350px;
    overflow-y: auto;
    min-height: 0;
  }

  .deadline_list .member_item {
    padding: 12px;
    background: #f9fafb;
    border-radius: 6px;
    margin-bottom: 8px;
    border-left: 3px solid #667eea;
  }

  .deadline_list .member_name {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 6px;
  }

  .deadline_list .member_info {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
  }

  .deadline_list .member_info_left {
    font-size: 12px;
    flex: 1;
    display: flex;
    align-items: center;
  }

  .deadline_list .member_department {
    font-size: 12px;
    color: #6b7280;
  }

  .deadline_list .member_status {
    font-size: 12px;
    color: #059669;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .deadline_overdue_text{
    color: #dc3545;
    font-weight: bold;
    font-size: 14px;
  }
  /* Ẩn title với background transparent và các mũi tên */
  .orgchart .title[style*="background: transparent"],
  .orgchart .title[style*="background:transparent"] {
    display: none !important;
  }

  .orgchart .edge,
  .orgchart .verticalEdge,
  .orgchart .topEdge,
  .orgchart .oci,
  .orgchart .oci-chevron-down,
  .orgchart .di {
    display: none !important;
  }
</style>

<!-- OrgChart.js Library -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/orgchart@3.8.0/dist/css/jquery.orgchart.min.css">
<script src="https://cdn.jsdelivr.net/npm/orgchart@3.8.0/dist/js/jquery.orgchart.min.js"></script>

<script>
  // Close button
  $(document).on('click', '.box_pop_view_du_an_close', function() {
    $('.box_pop_add').hide();
    $('.box_pop_add').html('');
  });

  // Click outside to close
  $(document).on('click', '.box_pop_view_du_an', function(e) {
    if ($(e.target).hasClass('box_pop_view_du_an')) {
      $('.box_pop_add').hide();
      $('.box_pop_add').html('');
    }
  });

  // Khởi tạo OrgChart khi popup được hiển thị
  var orgChartInitialized = false;
  
  function checkAndInitOrgChart() {
    if (orgChartInitialized) return;
    
    if ($('#orgchart-container').length > 0 && typeof orgChartData !== 'undefined') {
      orgChartInitialized = true;
      setTimeout(function() {
        initOrgChart();
      }, 200);
    }
  }

  // Kiểm tra khi DOM thay đổi
  var observer = new MutationObserver(function(mutations) {
    checkAndInitOrgChart();
  });

  // Quan sát body để phát hiện khi popup được thêm vào
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });

  // Kiểm tra ngay lập tức
  checkAndInitOrgChart();

  // Reset khi popup đóng
  $(document).on('click', '.box_pop_view_du_an_close', function() {
    orgChartInitialized = false;
  });

  function initOrgChart() {
    if (typeof orgChartData === 'undefined' || !orgChartData || orgChartData.length === 0) {
      $('#orgchart-container').html('<div class="org_chart_empty">Chưa có công việc nào trong dự án</div>');
      return;
    }

    // Xóa chart cũ nếu có
    $('#orgchart-container').empty();

    // Lấy node đầu tiên làm root
    // Nếu có nhiều node có parent_id = 0, PHP đã tạo root node ảo chứa tất cả
    var chartData = orgChartData[0];

    if (!chartData) {
      $('#orgchart-container').html('<div class="org_chart_empty">Chưa có công việc nào trong dự án</div>');
      return;
    }
    
    // Đánh dấu node root nếu chưa có
    if (!chartData.isRoot) {
      chartData.isRoot = true;
    }

    // Khởi tạo OrgChart
    $('#orgchart-container').orgchart({
      'data': chartData,

      'pan': true,
      'zoom': true,
      'direction': 't2b',
      'verticalLevel': 80,
      'toggleSiblingsResp': true,
      'siblingSep': 100,
      'subLevels': 4,
      'expandCollapse': true,
      'draggable': false,
      'createNode': function($node, data) {
        
        $node.addClass('box_congviec_du_an');
        // Đánh dấu node root
        if (data.isRoot || data.role === 'Quản lý') {
          $node.addClass('root');
        }
        
        var nodeContent = '<div class="orgchart-node-content">';
        nodeContent += '<div class="orgchart-node-avatar"><i class="fa fa-user"></i></div>';
        nodeContent += '<div class="orgchart-node-name">' + (data.title || '') + '</div>';
        if (data.department) {
          nodeContent += '<div class="orgchart-node-department"><i class="fa fa-building"></i> ' + data.department + '</div>';
        }
        if (data.ngay_giao && data.ngay_giao !== '-') {
          nodeContent += '<div class="orgchart-node-date ngay-giao"><i class="fa fa-calendar"></i> Ngày giao: ' + data.ngay_giao + '</div>';
        }
        if (data.deadline && data.deadline !== '-') {
          nodeContent += '<div class="orgchart-node-date deadline"><i class="fa fa-calendar"></i> Deadline: ' + data.deadline + '</div>';
        }
        if (data.role) {
          nodeContent += '<div class="orgchart-node-role">' + data.role + '</div>';
        }
        nodeContent += '</div>';
        $node.append(nodeContent);
      },
    });
    
    // Loại bỏ grid pattern sau khi khởi tạo và căn giữa
    setTimeout(function() {
      $('.orgchart, .orgchart *, #orgchart-container, #orgchart-container *').css({
        'background-image': 'none',
        'background': 'transparent'
      });
      $('#orgchart-container').css({
        'background': '#f9fafb',
        'display': 'flex',
        'justify-content': 'center',
        'align-items': 'flex-start'
      });
      $('.orgchart').css({
        'margin': '0 auto',
        'display': 'inline-block'
      });
      $('.orgchart table').css({
        'margin': '0 auto',
        'width': 'auto'
      });
      // Căn giữa node đầu tiên
      $('.orgchart > table > tbody > tr:first-child > td').css({
        'text-align': 'center'
      });
      $('.orgchart > table > tbody > tr:first-child > td > .node').css({
        'margin': '0 auto'
      });
      // Căn giữa tất cả các node
      $('.orgchart .node').css({
        'margin-left': '20px',
        'margin-right': '20px'
      });
      
      // Xóa title với background transparent và các mũi tên
      $('.orgchart .title[style*="background: transparent"], .orgchart .title[style*="background:transparent"]').remove();
      $('.orgchart .edge, .orgchart .verticalEdge, .orgchart .topEdge, .orgchart .oci, .orgchart .oci-chevron-down, .orgchart .di').remove();
    }, 100);
  }
</script>

