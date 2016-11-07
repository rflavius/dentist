<!-- linechart for last 3 months activity-->
<div style="height:300px;" id="emailsStats"></div>

<script type="text/javascript">   
$(function () { 
    $('#emailsStats').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Statistica programari online,mesaje: {MONTHS_TITLE}'
        },
        xAxis: {
            title:{text: "Lunile de referinta"},
            categories: [{MONTHS_LIST}]
        },
        yAxis: {
            title: {text: 'Numar programari'},
            min: 0
        },
        plotOptions: {
            column: {
                pointPadding: 0.3,
                borderWidth: 0
            }
        },
        series: [{name: 'Programari', data: [{MONTH_VISITORS}]}]
    });
});
	
</script>