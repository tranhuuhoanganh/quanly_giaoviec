<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile modern_dashboard" style="width: 100%; padding: 30px; background: #f8f9fa; min-height: 100vh;">
  		
  		<!-- THỐNG KÊ TỔNG QUAN -->
  		<div class="thongke_overview" style="margin-bottom: 40px;">
  			
  			<div class="overview_cards" style="display: flex; flex-wrap: nowrap; gap: 20px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 10px;">
  				<div class="stat_card card_primary" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #667eea; transition: all 0.3s ease;">
  					<div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tổng số công việc đã giao</div>
  					<div class="card_value" style="font-size: 30px; font-weight: 700; color: #667eea; margin-bottom: 8px;">{tong_congviec_giao}</div>
  				</div>
                  <div class="stat_card card_primary" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #667eea; transition: all 0.3s ease;">
                    <div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Tổng số công việc đã nhận</div>
                    <div class="card_value" style="font-size: 30px; font-weight: 700; color: #667eea; margin-bottom: 8px;">{tong_congviec_nhan}</div>
                </div>
  				<div class="stat_card card_warning" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #f6ad55; transition: all 0.3s ease;">
  					<div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Chờ xử lý</div>
  					<div class="card_value" style="font-size: 30px; font-weight: 700; color: #f6ad55; margin-bottom: 8px;">{trangthai_cho_xuly}</div>
  					<div style="color: #a0aec0; font-size: 12px;"><i class="fa fa-clock-o" style="margin-right: 5px;"></i> Đang chờ</div>
  				</div>
  				<div class="stat_card card_info" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #4299e1; transition: all 0.3s ease;">
  					<div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Đang thực hiện</div>
  					<div class="card_value" style="font-size: 30px; font-weight: 700; color: #4299e1; margin-bottom: 8px;">{trangthai_dang_thuchien}</div>
  					<div style="color: #a0aec0; font-size: 12px;"><i class="fa fa-spinner" style="margin-right: 5px;"></i> Đang làm</div>
  				</div>
  				<div class="stat_card card_success" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #48bb78; transition: all 0.3s ease;">
  					<div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Đã hoàn thành</div>
  					<div class="card_value" style="font-size: 30px; font-weight: 700; color: #48bb78; margin-bottom: 8px;">{trangthai_da_hoanthanh}</div>
  					<div style="color: #a0aec0; font-size: 12px;"><i class="fa fa-check-circle" style="margin-right: 5px;"></i> Hoàn tất</div>
  				</div>
  				<div class="stat_card card_danger" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); flex: 1; min-width: 150px; border-left: 4px solid #f56565; transition: all 0.3s ease;">
  					<div class="card_title" style="color: #718096; font-size: 12px; margin-bottom: 15px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">Quá hạn</div>
  					<div class="card_value" style="font-size: 30px; font-weight: 700; color: #f56565; margin-bottom: 8px;">{trangthai_miss_deadline}</div>
  					<div style="color: #a0aec0; font-size: 12px;"><i class="fa fa-exclamation-triangle" style="margin-right: 5px;"></i> Quá hạn hoàn thành</div>
  				</div>
  			</div>
  		</div>
        <div id="filter_trangthai" style="display: block; margin-bottom: 15px;">
            <form method="get" style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
                <input type="date" name="tu_ngay" 
                       style="padding: 6px 10px; border-radius: 999px; border: 1px solid #cbd5e0; font-size: 13px; outline: none;">
                <span style="font-size: 13px; color: #4a5568;">đến</span>
                <input type="date" name="den_ngay" 
                       style="padding: 6px 10px; border-radius: 999px; border: 1px solid #cbd5e0; font-size: 13px; outline: none;">
                <span style="font-size: 13px; color: #4a5568;">Năm:</span>
                <input type="number" name="nam_thang" min="2000" max="2100" value="{nam}"
                        style="width: 80px; padding: 4px 8px; border-radius: 999px; border: 1px solid #cbd5e0; font-size: 13px; outline: none; text-align: center;">
                <button type="submit" class ="filter_trangthai"
                        style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border-radius: 999px; border: none; background: #667eea; color: #fff; font-size: 12px; font-weight: 500; cursor: pointer;">
                    <i class="fa fa-search"></i>
                    Lọc
                </button>
            </form>
        </div>
  		<!-- BIỂU ĐỒ CHIA THÀNH CÁC CARD -->
  		<div class="charts_grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 25px; margin-top: 30px;">
  			
  			<!-- CARD 1: Trạng thái công việc -->
  			<div class="chart_card modern_chart_card" style="background: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #e2e8f0;">
  				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
  					<div style="display: flex; align-items: center;">
  						<div style="background: #edf2f7; padding: 10px; border-radius: 10px; margin-right: 15px;">
  							<i class="fa fa-pie-chart" style="color: #667eea; font-size: 16px;"></i>
  						</div>
  						<h2 style="margin: 0; font-size: 16px; color: #2d3748; font-weight: 600;">Trạng thái công việc</h2>
  					</div>
  				</div>
  				<div class="chart" style="height: 350px;">
  					<figure class="highcharts-figure" style="margin: 0;">
  						<div id="container_chart_trangthai" style="height: 350px;"></div>
  					</figure>
  				</div>
  			</div>


  			<!-- CARD 3: Công việc theo tháng -->
  			<div class="chart_card modern_chart_card" style="background: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid #e2e8f0;">
  				<div style="display: flex; align-items: center; margin-bottom: 20px;">
  					<div style="background: #edf2f7; padding: 10px; border-radius: 10px; margin-right: 15px;">
  						<i class="fa fa-calendar" style="color: #4299e1; font-size: 16px;"></i>
  					</div>
  					<h2 style="margin: 0; font-size: 16px; color: #2d3748; font-weight: 600;">Công việc theo tháng năm {nam}</h2>
                    
  				</div>
  				<div class="chart" style="height: 350px;">
  					<figure class="highcharts-figure" style="margin: 0;">
  						<div id="container_chart_thang" style="height: 350px;"></div>
  					</figure>
  				</div>
  			</div>

  		</div>

  	</div>
  </div>
</div>

<style type="text/css">
.modern_dashboard {
    background: #f8f9fa !important;
    min-height: 100vh;
    padding: 30px !important;
}

/* Stat Cards Hover Effect */
.stat_card {
    cursor: pointer;
}

.stat_card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
}

/* Scrollbar cho overview cards */
.overview_cards::-webkit-scrollbar {
    height: 8px;
}

.overview_cards::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
}

.overview_cards::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 10px;
}

.overview_cards::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

.charts_grid {
    margin-top: 30px;
}

.modern_chart_card {
    backdrop-filter: blur(10px);
}

.modern_chart_card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.12) !important;
    border-color: #cbd5e0 !important;
}

/* Highcharts styling */
.highcharts-container {
    border-radius: 15px;
}

#container_chart {
    height: 400px; 
}
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 100%;
    margin: 0;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: calc(100% - 20px);
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>

<script src="/js/highcharts.js"></script>
<script src="/js/exporting.js"></script>
<script src="/js/export-data.js"></script>
<script src="/js/accessibility.js"></script>
<script type="text/javascript">
// Biểu đồ trạng thái
Highcharts.chart('container_chart_trangthai', {
    chart: {
        type: 'pie',
        height: 350
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b> ({point.percentage:.1f}%)'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: [{
        name: 'Số lượng',
        colorByPoint: true,
        data: [{
            name: 'Chờ xử lý',
            y: {trangthai_cho_xuly},
            color: '#f5576c'
        }, {
            name: 'Đang thực hiện',
            y: {trangthai_dang_thuchien},
            color: '#4facfe'
        }, {
            name: 'Chờ duyệt',
            y: {trangthai_cho_duyet},
            color: '#764ba2'
        }, {
            name: 'Từ chối',
            y: {trangthai_tuchoi},
            color: '#667eea'
        }, {
            name: 'Xin gia hạn',
            y: {trangthai_xin_giahan},
            color: '#fa709a'
        }, {
            name: 'Đã hoàn thành',
            y: {trangthai_da_hoanthanh},
            color: '#43e97b'
        }, {
            name: 'Quá hạn',
            y: {trangthai_miss_deadline},
            color: '#f093fb'
        }]
    }]
});



// Biểu đồ công việc theo tháng
Highcharts.chart('container_chart_thang', {
    chart: {
        type: 'column',
        height: 350
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Số lượng công việc'
        }
    },
    tooltip: {
        valueSuffix: ' công việc'
    },
    plotOptions: {
        column: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Đã tạo',
        data: [{data_thang_tao}],
        color: '#4299e1'
    }, {
        name: 'Đã nhận',
        data: [{data_thang_nhanviec}],
        color: '#f6ad55'
    }, {
        name: 'Hoàn thành',
        data: [{data_thang_hoanthanh}],
        color: '#48bb78'
    }]
});

// Kết thúc biểu đồ
</script>

<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function() {
            total_height += $(this).outerHeight();
            if ($(this).attr('id') == 'thong_ke_congviec') {
                $(this).find('span i').removeClass('fa-plus-circle');
                $(this).find('span i').addClass('fa-minus-circle');
              vitri = total_height - 90;
              $('.menu_li.menu_thong_ke_congviec').show();
            }else{
              if($(this).find('span i').length>0){
                $(this).find('span i').removeClass('fa-minus-circle');
                $(this).find('span i').addClass('fa-plus-circle');
                $('.menu_li.'+$(this).attr('id')).hide();
              }
            }
        });
        if(typeof vitri !== 'undefined'){
            $('.box_menu_left').animate({scrollTop: vitri}, 1000);
        }
    });
</script>

