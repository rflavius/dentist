<!-- linechart for last months activity-->
<legend>Statistica anunturi</legend>
<div style="height:300px" id="addsStatsChart"></div>

<script type="text/javascript">   
	$(function () {
	    $('#addsStatsChart').highcharts({
	    	title: {
	            text: 'Statistici anunturi'
	        },
	        subtitle: {
	            text: 'Aici sunt prezentate diverse statistici pentru fiecare anunt adaugat de dvs in RomaniaUE.com.'
	        },
	        chart: {
	            type: 'column'
	        },
	        legend: {
	            enabled: false
	        },
	        credits: {
	            enabled: false
	        },
	        xAxis: {
	            categories: [{ADDS_TITLE}],
	            title:{text: 'Anunturile dvs'}
	        },
	        yAxis:{
		        title: {text: 'Cifra referinta'}
		    },
	        series: [{
		        data: [{VIEWS_DATA}],
		        name: 'Numar vizualizari anunt'
	        }]
	    });
	});
</script>