<!-- here starts the gmap plugin MLS search -->
<style>
#gmap_window_info{width: 400px;height:220px;background-color:#8dd1ec;font-size:12px;}
.the_gmap_left{display:inline-block;width:200px;float:left;}
.the_gmap_left b{color:#13536c;font-size:14px;margin-bottom:20px;}
.the_gmap_left p{color:white;font-size:12px;}
#gmap_window_info a.the_gmap_search_more_btn{display:block;width:200px;background: #3e9cc2;height:24px;line-height:24px;text-align:center;text-decoration:none;color: white;font-size:18px;}
.the_gmap_right{display:inline-block;width:160px;float:right;color:white;}
.the_gmap_right img{width:100px;text-align:left;}
#loading_map{background: url('images/BG.png') repeat;position:absolute;top:0px;left:0px;z-index:10;}
.gmap_container{position:relative;}
.gmap_loading{background:#DCE7F2;padding:50px 80px;margin-top:200px;font-size:16px;color:#4F769B;text-align:center;}
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
      var script = '<script type="text/javascript" src="http://google-maps-' +
          'utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble';
      if (document.location.search.indexOf('compiled') !== -1) {
        script += '-compiled';
      }
      script += '.js"><' + '/script>';
      document.write(script);
</script>

<script>
var last_info_bubble;
var coords_lat;
var coords_lng;
//here we set the icons
var customIcons = {
establishment: {
	        icon: '{SITE_BASE}/images/gmap_marker.png'
	      }
	    };



$(document).ready(function(){
	
	var map = new google.maps.Map(document.getElementById("map"), {
	    center: new google.maps.LatLng(45.629149,25.639343),
	    zoom: 7,
	    mapTypeId: 'roadmap'
	  });
	// set up the map markers
	var geocoder = new google.maps.Geocoder();
	load();
	var last_info_bubble;

	google.maps.event.addListenerOnce(map, 'click', function(){
	    alert(event.latLng);
	});
	
	function load() {
		var infoBubble = [];
		
		var infoWindow = new google.maps.InfoWindow;
	  // Change this depending on the name of your PHP file
	  downloadUrl("{SITE_BASE}/gmap.xml", function(data) {
	    var xml = data.responseXML;
	    var markers = xml.documentElement.getElementsByTagName("marker");
	    var center = new google.maps.LatLng(markers[0].getAttribute('center_lat'), markers[0].getAttribute('center_lng'));
	    map.setCenter(center);
	    
	    for (var i = 0; i < markers.length; i++) {
			//here we get all the variables
			//var point;
	      var name = markers[i].getAttribute("name");
	      var address = markers[i].getAttribute("address");
	      var date = markers[i].getAttribute("date");
	      var judet = markers[i].getAttribute("judet");
	      var localitate = markers[i].getAttribute("localitate");
	      var level = markers[i].getAttribute("level");
	      var phone = markers[i].getAttribute("phone");
	      var image = markers[i].getAttribute("img");
	      var description = markers[i].getAttribute("description");
	      var cabID = markers[i].getAttribute("cabID");
	      var type = markers[i].getAttribute("type");

	      var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lng")));

	      var html = "<div id='gmap_window_info'><span class='the_gmap_left'><b>" + name + "</b><p>"+description+"</p><a href='' target='_blank' class='the_gmap_search_more_btn'>detalii</a></span><span class='the_gmap_right'><img src='"+image+"' width='90'><b>Tel: "+phone+"</b><p>"+address+"</p></span></div>";
			// we generate dinamyc the bubble name

	      infoBubble[i] = new InfoBubble({
	          maxWidth: 400
	        });
	      infoBubble[i].addTab('DETALII', html);
	      
	      
	      
	      var icon = customIcons[type] || {};
	      var marker = new google.maps.Marker({
	        map: map,
	        position: point,
	        icon: icon.icon,
	      });
	      //validateGmapAddress(name);
	      bindInfoWindow(marker, map, infoBubble[i]);
	    }
	  });
	}
	
	function bindInfoWindow(marker, map, infoBubble) {
		
	  //google.maps.event.addListener(marker, 'click', function() {
	    //infoWindow.setContent(html);
	    //infoWindow.open(map, marker);
	  //});
	    google.maps.event.addListener(marker, 'click', function() {
	        if (!infoBubble.isOpen()) {
	        if(last_info_bubble)
	        {
	        	last_info_bubble.close(map, marker);
	        }
	          infoBubble.open(map, marker);
	          last_info_bubble = infoBubble;
	        }
	   });
	}
});



function downloadUrl(url, callback) {
	  var request = window.ActiveXObject ?
	      new ActiveXObject('Microsoft.XMLHTTP') :
	      new XMLHttpRequest;
	
	  request.onreadystatechange = function() {
	    if (request.readyState == 4) {
	    document.getElementById('loading_map').style.display = 'none';
	      request.onreadystatechange = doNothing;
	      callback(request, request.status);
	    }
	  };
	
	  request.open('GET', url, true);
	  request.send(null);
	}
	
	function doNothing() {}


</script>



<div class='gmap_container'>
	<div id="loading_map" style="width: 1014px; height: 500px">
		<div class='gmap_loading'>Se incarca harta, va rugam sa asteptati ...</div>
	</div>
	<div id="map" style="width: 1014px; height: 600px"></div>
</div>