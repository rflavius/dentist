<!-- linechart for last 3 months activity-->
<div style="height:300px;" id="phoneStats"></div>

<script type="text/javascript">   
$(function () { 
    $('#phoneStats').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistica cereri telefon: {MONTHS_TITLE}'
        },
        xAxis: {
            title:{text: "Lunile de referinta"},
            categories: [{MONTHS_LIST}]
        },
        yAxis: {
            title: {text: 'Numar accesari'},
            min: 0
        },
        plotOptions: {
            column: {
                pointPadding: 0.3,
                borderWidth: 0
            }
        },
        series: [{name: 'Accesari', data: [{MONTH_VISITORS}]}]
    });
});
	
</script>