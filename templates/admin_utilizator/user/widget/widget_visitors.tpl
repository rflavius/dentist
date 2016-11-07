<!-- linechart for last 3 months activity-->
<div style="height:300px;" id="visitorsStats"></div>

<script type="text/javascript">   
$(function () { 
    $('#visitorsStats').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistica vizitatori: {MONTHS_TITLE}'
        },
        xAxis: {
            title:{text: "Lunile de referinta"},
            categories: [{MONTHS_LIST}]
        },
        yAxis: {
            title: {text: 'Numar vizitatori'},
            min: 0
        },
        plotOptions: {
            column: {
                pointPadding: 0.3,
                borderWidth: 0
            }
        },
        series: [{name: 'Vizitatori', data: [{MONTH_VISITORS}]}]
    });
});
	
</script>