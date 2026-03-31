<div class="box_pop_lichsu_baocao">
  <div class="box_pop_lichsu_baocao_dialog">
    <div class="box_pop_lichsu_baocao_content">

      <div class="box_pop_lichsu_baocao_header">
        <div class="box_pop_lichsu_baocao_title_wrapper">
          <h5 class="box_pop_lichsu_baocao_title">
            <i class="fa fa-history"></i>
            Lịch sử báo cáo
          </h5>
        </div>
        <button type="button" class="box_pop_lichsu_baocao_close" aria-label="Đóng">
          <i class="fa fa-times"></i>
        </button>
      </div>

      <div class="box_pop_lichsu_baocao_body">
        <div class="lichsu_baocao_list" id="lichsu_baocao_list">
            <div class="table_wrapper">
                <table class="table_lichsu_baocao">
                    <thead>
                        <tr>
                            <th width="10">STT</th>
                            <th width="15">Ngày báo cáo</th>
                            <th width="10">Tiến độ</th>
                            <th width="10">Trạng thái</th>
                            <th width="10">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        {list_lichsu_baocao}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="lichsu_baocao_empty" id="lichsu_baocao_empty" style="display: none;">
          <div class="empty_state">
            <i class="fa fa-inbox"></i>
            <p>Chưa có lịch sử báo cáo nào</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  /* Reset và base styles */
  .box_pop_lichsu_baocao,
  .box_pop_lichsu_baocao * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .box_pop_lichsu_baocao {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Overlay modal */
  .box_pop_lichsu_baocao {
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
  .box_pop_lichsu_baocao_dialog {
    width: 100%;
    max-width: 576px;
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
  .box_pop_lichsu_baocao_content {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
  }

  /* Header */
  .box_pop_lichsu_baocao_header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: #ffffff;
    color: #111827;
    border-bottom: 1px solid #e5e7eb;
  }

  .box_pop_lichsu_baocao_title_wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_lichsu_baocao_title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    letter-spacing: 0.2px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .box_pop_lichsu_baocao_title i {
    font-family: "FontAwesome" !important;
    color: #0062A0;
    font-size: 20px;
  }

  .box_pop_lichsu_baocao_close {
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

  .box_pop_lichsu_baocao_close i {
    font-size: 16px;
    font-family: "FontAwesome" !important;
  }

  .box_pop_lichsu_baocao_close:hover {
    background: #e5e7eb;
    color: #374151;
    transform: scale(1.05);
  }

  .box_pop_lichsu_baocao_close:active {
    transform: scale(0.95);
  }

  /* Body */
  .box_pop_lichsu_baocao_body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
    background: #ffffff;
  }

  /* List container */
  .lichsu_baocao_list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .table_wrapper {
  max-height: calc(90vh - 200px);
  overflow-y: auto;
  overflow-x: auto;
}

.table_lichsu_baocao {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
}

.table_lichsu_baocao thead,
.table_lichsu_baocao tbody {
  display: block;
}

.table_lichsu_baocao thead {
  background: #f9fafb;
  border-bottom: 2px solid #e5e7eb;
}

.table_lichsu_baocao tbody {
  max-height: calc(3 * 60px);
  overflow-y: auto;
  overflow-x: hidden;
}

/* Quan trọng: Set width cho từng cột */
.table_lichsu_baocao thead tr,
.table_lichsu_baocao tbody tr {
  display: table;
  width: 100%;
  table-layout: fixed; /* Quan trọng */
}

/* Set width cho từng th/td theo đúng layout của bạn */
.table_lichsu_baocao th:nth-child(1),
.table_lichsu_baocao td:nth-child(1) {
  width: 10%; /* STT */
}

.table_lichsu_baocao th:nth-child(2),
.table_lichsu_baocao td:nth-child(2) {
  width: 25%; /* Ngày báo cáo */
}

.table_lichsu_baocao th:nth-child(3),
.table_lichsu_baocao td:nth-child(3) {
  width: 15%; /* Tiến độ */
}

.table_lichsu_baocao th:nth-child(4),
.table_lichsu_baocao td:nth-child(4) {
  width: 20%; /* Trạng thái */
}

.table_lichsu_baocao th:nth-child(5),
.table_lichsu_baocao td:nth-child(5) {
  width: 25%; /* Hành động */
}

  .table_lichsu_baocao thead th {
    padding: 14px 12px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
  }

  .table_lichsu_baocao thead th:first-child {
    text-align: center;
  }

  .table_lichsu_baocao thead th:nth-child(3),
  .table_lichsu_baocao thead th:nth-child(4),
  .table_lichsu_baocao thead th:last-child {
    text-align: center;
  }
  
  .table_lichsu_baocao tbody tr:last-child td {
    border-bottom: none;
  }

  /* Empty state */
  .lichsu_baocao_empty {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
  }

  .empty_state {
    text-align: center;
    color: #9ca3af;
  }

  .empty_state i {
    font-family: "FontAwesome" !important;
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 16px;
  }

  .empty_state p {
    font-size: 16px;
    color: #6b7280;
    font-weight: 500;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .box_pop_lichsu_baocao_dialog {
      max-width: 100%;
    }

    .box_pop_lichsu_baocao_body {
      padding: 16px;
    }
  }
</style>
