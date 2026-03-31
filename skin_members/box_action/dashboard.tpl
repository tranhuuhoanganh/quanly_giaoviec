<style>
    .custom-div {
        background: rgb(255, 0, 0);
        padding: 5px;
        color: aliceblue;
        border-radius: 17px;
        position: absolute;
        z-index: 999;
        font-size: 17px;
    }
    .dashboard-statistics {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    .stat-card {
        flex: 1;
        min-width: 150px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }
    .stat-card .stat-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }
    .stat-card .stat-value {
        font-size: 32px;
        font-weight: bold;
        color: #333;
    }
    .stat-card.tong-congviec .stat-value { color: #2196F3; }
    .stat-card.congviec-tructiep .stat-value { color: #4CAF50; }
    .stat-card.congviec-duan .stat-value { color: #FF9800; }
    .dashboard-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .dashboard-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .dashboard-box .box-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #2196F3;
        padding-bottom: 10px;
    }
    .congviec-item {
        padding: 12px;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-left: 4px solid #FF9800;
        border-radius: 4px;
    }
    .congviec-item:hover {
        background: #e9ecef;
    }
    .congviec-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        font-size: 15px;
    }
    .congviec-meta {
        font-size: 13px;
        color: #666;
    }
    .congviec-type {
        color: #2196F3;
        font-weight: 500;
    }
    .congviec-deadline {
        color: #FF9800;
        font-weight: 500;
    }
    .congviec-empty {
        text-align: center;
        padding: 30px;
        color: #999;
        font-style: italic;
    }
    .congviec-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .congviec-list::-webkit-scrollbar {
        width: 6px;
    }
    .congviec-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .congviec-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }
    .congviec-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<div class="box_right">
    <div class="box_right_content" style="margin:10px">
        <!-- Hàng 1 - Thống kê -->
        <div class="dashboard-statistics">
            <div class="stat-card tong-congviec">
                <div class="stat-label">Tổng công việc</div>
                <div class="stat-value">{tong_congviec}</div>
            </div>
            <div class="stat-card congviec-tructiep">
                <div class="stat-label">Công việc trực tiếp</div>
                <div class="stat-value">{tong_congviec_tructiep}</div>
            </div>
            <div class="stat-card congviec-duan">
                <div class="stat-label">Công việc dự án</div>
                <div class="stat-value">{tong_congviec_duan}</div>
            </div>
        </div>
        
        <!-- Hàng 2 - Công việc hôm nay và sắp đến hạn -->
        <div class="dashboard-row-2">
            <div class="dashboard-box">
                <div class="box-title">Công việc hôm nay</div>
                <div class="congviec-list">
                    {list_congviec_hom_nay}
                </div>
            </div>
            <div class="dashboard-box">
                <div class="box-title">Công việc sắp đến hạn</div>
                <div class="congviec-list">
                    {list_congviec_sap_den_han}
                </div>
            </div>
        </div>
    </div>
</div>
