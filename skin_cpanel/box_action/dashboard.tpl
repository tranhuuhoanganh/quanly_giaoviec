<style>
    /* Dashboard — giao diện tổng quan admin */
    .dashboard-page {
        --dash-radius: 14px;
        --dash-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(15, 23, 42, 0.06);
        --dash-border: 1px solid rgba(148, 163, 184, 0.35);
        font-family: inherit;
        margin: 10px;
        padding: 8px 12px 28px;
        background: linear-gradient(165deg, #f1f5f9 0%, #f8fafc 45%, #fff 100%);
        border-radius: var(--dash-radius);
    }
    .dashboard-section { margin-bottom: 22px; }
    .dashboard-section:last-of-type { margin-bottom: 0; }
    .dashboard-section-title {
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 700;
        margin: 0 0 12px 6px;
    }
    .dashboard-statistics {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .stat-card {
        flex: 1;
        min-width: 148px;
        position: relative;
        background: #fff;
        border: var(--dash-border);
        border-radius: var(--dash-radius);
        padding: 18px 18px 20px;
        box-shadow: var(--dash-shadow);
        text-align: left;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: var(--dash-radius) 0 0 var(--dash-radius);
        background: var(--accent, #94a3b8);
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(15, 23, 42, 0.05), 0 12px 24px rgba(15, 23, 42, 0.08);
    }
    .stat-card .stat-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 500;
        line-height: 1.35;
    }
    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        font-variant-numeric: tabular-nums;
        line-height: 1.15;
    }
    .stat-card.tong-phongban { --accent: #0d9488; }
    .stat-card.tong-phongban .stat-value { color: #0f766e; }
    .stat-card.tong-congviec { --accent: #2563eb; }
    .stat-card.tong-congviec .stat-value { color: #1d4ed8; }
    .stat-card.congviec-tructiep { --accent: #16a34a; }
    .stat-card.congviec-tructiep .stat-value { color: #15803d; }
    .stat-card.congviec-duan { --accent: #ea580c; }
    .stat-card.congviec-duan .stat-value { color: #c2410c; }

    .dashboard-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .dashboard-box {
        background: #fff;
        border: var(--dash-border);
        border-radius: var(--dash-radius);
        padding: 0;
        box-shadow: var(--dash-shadow);
        display: flex;
        flex-direction: column;
        min-height: 100%;
        overflow: hidden;
    }
    .dashboard-box-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        background: linear-gradient(180deg, #fff 0%, #fafbfc 100%);
    }
    .dashboard-box .box-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .dashboard-box .box-desc {
        font-size: 12px;
        color: #64748b;
        margin: 6px 0 0;
        line-height: 1.45;
    }
    .dashboard-box-body {
        padding: 18px 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .chart-deadline-wrap {
        max-width: 100%;
        margin: 0 auto;
        position: relative;
        min-height: 240px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-deadline-wrap canvas { max-height: 280px; }
    .chart-deadline-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px 16px;
        margin-top: 16px;
        padding-top: 4px;
    }
    .chart-deadline-legend span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        background: #f1f5f9;
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 500;
    }
    .chart-deadline-legend span strong {
        color: #0f172a;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .chart-deadline-legend i {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    .leg-dung { background: linear-gradient(135deg, #22c55e, #16a34a); box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.25); }
    .leg-tre { background: linear-gradient(135deg, #f87171, #dc2626); box-shadow: 0 0 0 2px rgba(248, 113, 113, 0.3); }

    .congviec-item {
        padding: 12px;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-left: 4px solid #FF9800;
        border-radius: 4px;
    }
    .congviec-item:hover { background: #e9ecef; }
    .congviec-title { font-weight: bold; color: #333; margin-bottom: 5px; font-size: 15px; }
    .congviec-meta { font-size: 13px; color: #666; }
    .congviec-type { color: #2196F3; font-weight: 500; }
    .congviec-deadline { color: #FF9800; font-weight: 500; }
    .congviec-empty,
    .dashboard-empty {
        text-align: center;
        padding: 36px 20px;
        color: #94a3b8;
        font-size: 14px;
        line-height: 1.5;
    }
    .congviec-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .congviec-list::-webkit-scrollbar { width: 6px; }
    .congviec-list::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
    .congviec-list::-webkit-scrollbar-thumb { background: #888; border-radius: 3px; }
    .congviec-list::-webkit-scrollbar-thumb:hover { background: #555; }

    @media (max-width: 992px) {
        .dashboard-row-charts { grid-template-columns: 1fr !important; }
        .stat-card { min-width: calc(50% - 8px); }
    }
    @media (max-width: 520px) {
        .stat-card { min-width: 100%; }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<div class="box_right">
    <div class="box_right_content dashboard-page">
        <div class="dashboard-section">
            <div class="dashboard-section-title">Tổ chức</div>
            <div class="dashboard-statistics">
                <div class="stat-card tong-phongban">
                    <div class="stat-label">Số phòng ban</div>
                    <div class="stat-value">{tong_phongban}</div>
                </div>
                <div class="stat-card tong-phongban">
                    <div class="stat-label">Tổng số nhân sự</div>
                    <div class="stat-value">{tong_nhansu}</div>
                </div>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-section-title">Công việc &amp; dự án</div>
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
                    <div class="stat-label">Tổng dự án</div>
                    <div class="stat-value">{tong_duan}</div>
                </div>
                <div class="stat-card congviec-duan">
                    <div class="stat-label">Tổng công việc dự án</div>
                    <div class="stat-value">{tong_congviec_duan}</div>
                </div>
            </div>
        </div>
        <div class="dashboard-section">
            <div class="dashboard-section-title">Biểu đồ</div>
            <div class="dashboard-row-2 dashboard-row-charts">
                <div class="dashboard-box">
                    <div class="dashboard-box-header">
                        <div class="box-title">Đúng hạn &amp; trễ hạn</div>
                        <p class="box-desc">Trễ hạn khi miss_deadline = 1; đúng hạn là các trường hợp còn lại.</p>
                    </div>
                    <div class="dashboard-box-body">
                        <div class="chart-deadline-wrap">
                            <canvas id="chartDeadlineCongviec"></canvas>
                        </div>
                        <div class="chart-deadline-legend">
                            <span><i class="leg-dung"></i> Đúng hạn <strong>{cv_dung_han}</strong></span>
                            <span><i class="leg-tre"></i> Trễ hạn <strong>{cv_tre_han}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="dashboard-box">
                    <div class="dashboard-box-header">
                        <div class="box-title">Tỷ lệ trạng thái công việc</div>
                        <p class="box-desc">Gộp giao việc trực tiếp và công việc trong dự án.</p>
                    </div>
                    <div class="dashboard-box-body">
                        <div class="chart-deadline-wrap">
                            <canvas id="chartTrangthaiCongviec"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="application/json" id="deadline-chart-data">{chart_deadline_json}</script>
        <script type="application/json" id="trangthai-chart-data">{chart_trangthai_json}</script>
        <script>
        (function() {
            var el = document.getElementById('deadline-chart-data');
            var raw = el ? el.textContent : '{}';
            var data;
            try { data = JSON.parse(raw); } catch (e) { data = { dung_han: 0, tre_han: 0 }; }
            var d = parseInt(data.dung_han, 10) || 0;
            var t = parseInt(data.tre_han, 10) || 0;
            var ctx = document.getElementById('chartDeadlineCongviec');
            if (!ctx || typeof Chart === 'undefined') return;
            if (d === 0 && t === 0) {
                ctx.parentNode.innerHTML = '<p class="dashboard-empty">Chưa có công việc để thống kê.</p>';
                return;
            }
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Đúng hạn', 'Trễ hạn'],
                    datasets: [{
                        data: [d, t],
                        backgroundColor: ['#22c55e', '#ef4444'],
                        hoverBackgroundColor: ['#16a34a', '#dc2626'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.15,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 14, font: { size: 12, weight: '500' }, usePointStyle: true, pointStyle: 'circle' } },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    var v = ctx.raw || 0;
                                    var sum = d + t;
                                    var pct = sum ? Math.round((v / sum) * 100) : 0;
                                    return ' ' + ctx.label + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    cutout: '58%'
                }
            });
        })();
        </script>
        <script>
        (function() {
            var el = document.getElementById('trangthai-chart-data');
            var raw = el ? el.textContent : '{}';
            var payload;
            try { payload = JSON.parse(raw); } catch (e) { payload = { labels: [], values: [], colors: [] }; }
            var labels = payload.labels || [];
            var values = payload.values || [];
            var colors = payload.colors || [];
            var ctx = document.getElementById('chartTrangthaiCongviec');
            if (!ctx || typeof Chart === 'undefined') return;
            var sum = 0;
            for (var i = 0; i < values.length; i++) sum += parseInt(values[i], 10) || 0;
            if (sum === 0) {
                ctx.parentNode.innerHTML = '<p class="dashboard-empty">Chưa có công việc để thống kê.</p>';
                return;
            }
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.length ? colors : ['#3b82f6', '#22c55e', '#f59e0b', '#a855f7', '#ec4899', '#06b6d4', '#78716c'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1.15,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 8, font: { size: 10, weight: '500' }, boxWidth: 10, usePointStyle: true, pointStyle: 'circle' } },
                        tooltip: {
                            callbacks: {
                                label: function(c) {
                                    var v = parseInt(c.raw, 10) || 0;
                                    var pct = sum ? Math.round((v / sum) * 100) : 0;
                                    return ' ' + (c.label || '') + ': ' + v + ' (' + pct + '%)';
                                }
                            }
                        }
                    },
                    cutout: '52%'
                }
            });
        })();
        </script>
    </div>
</div>
