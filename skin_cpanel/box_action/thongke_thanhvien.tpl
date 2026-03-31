<div class="box_right">
  <div class="box_right_content">
  	<div class="box_profile" style="width: 100%;padding: 10px;">
  		<h1>Thống kê năm {nam}</h1>
        <div class="chart">
            <!-- Chart wrapper -->
            <figure class="highcharts-figure">
              <div id="container_chart_nam"></div>
              <p class="highcharts-description"></p>
            </figure>
        </div>
        <h1>Thống kê tháng {thang}/{nam}</h1>
        <div class="chart">
            <figure class="highcharts-figure">
              <div id="container_chart_thang"></div>
              <p class="highcharts-description"></p>
            </figure>
        </div>
        <h1>Thống kê tuần thứ {tuan}({ngay_dau_tuan} - {ngay_cuoi_tuan})</h1>
        <div class="chart">
            <figure class="highcharts-figure">
              <div id="container_chart_tuan"></div>
              <p class="highcharts-description"></p>
            </figure>
        </div>
  	</div>
  </div>
</div>
<style type="text/css">
#container_chart {
    height: 400px; 
}
.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 100%;
    margin: 1em auto;
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
Highcharts.chart('container_chart_nam', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12'],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Thành viên',
            enabled: false
        },
        labels: {
            formatter: function () {
                return this.value/1;
            }
        }
    },
    tooltip: {
        split: true,
        valueSuffix: ' thành viên'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    series: [{
        name: 'Số thành viên',
        data: [{data_nam}]
    }]
});
Highcharts.chart('container_chart_thang', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [{list_ngay}],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Thống kê thành viên'
        },
        labels: {
            formatter: function () {
                return this.value/1;
            }
        }
    },
    tooltip: {
        split: true,
        valueSuffix: ' thành viên'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    series: [{
        name: 'Số thành viên',
        data: [{data_thang}]
    }]
});
Highcharts.chart('container_chart_tuan', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: 'Thống kê thành viên'
        },
        labels: {
            formatter: function () {
                return this.value/1;
            }
        }
    },
    tooltip: {
        split: true,
        valueSuffix: ' thành viên'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    series: [{
        name: 'Số thành viên',
        data: [{data_tuan}]
    }]
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        total_height=0;
        $('.box_menu_left .menu_li, .box_menu_left .menu_header').each(function(){
            total_height+=$(this).outerHeight();
            if($(this).attr('id')=='menu_thongke'){
                vitri=total_height - 90;
            }
        });
        $('.box_menu_left').animate({scrollTop: vitri}, 1000);
    });
</script>