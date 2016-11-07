<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
function initialize()
{
	var myLatlng = new google.maps.LatLng({LAT},{LNG});
	var mapOptions = {zoom: 10,center: myLatlng}
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);

	var marker = new google.maps.Marker({position: myLatlng,map: map,title: '{CAB_NUME}'});
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>


<div id="map" style="width: 440px; height: 300px"></div>