<script type="text/javascript"
      src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
    function initialize() {
    	
    	var myLatlng = new google.maps.LatLng(<?php echo $this->model->get_lat().",". $this->model->get_lng(); ?>);
    	
      var mapOptions = {
        center: myLatlng,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.HYBRID
      };
      var map = new google.maps.Map(document.getElementById("map-canvas"),
          mapOptions);
          
      // To add the marker to the map, use the 'map' property
	var marker = new google.maps.Marker({
  		position: myLatlng,
  		map: map,
  		title:"<?php echo $this->model->get_citta(); ?>"
	});
          
      var fumetto = '<div id="content">'+
 				'<div id="siteNotice">'+
    			'</div>'+
   			'<h1 id="firstHeading" class="firstHeading"><?php echo $this->model->get_citta(); ?></h1>'+
    			'<div id="bodyContent">'+
    			'<?php echo $this->model->get_tutto(); ?>'+
    			'</div>'+
    			'</div>';

	var infowindow = new google.maps.InfoWindow({
	      content: fumetto
	});

     
	google.maps.event.addListener(marker, 'click', function() {
  		infowindow.open(map,marker);
		});
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>



<h1><?php echo $this->model->get_citta(); ?></h1>
<h3><?php echo $this->model->get_indirizzo(); ?></h3>
<h2><?php echo $this->model->get_stato(); ?></h2>
<div id="map-canvas"></div>