

<script type="text/javascript"
      src="http://maps.google.com/maps/api/js?sensor=false">
</script>

<script type="text/javascript">
    function initialize_anteprima(lat,lng,id) {
    	
    	var myLatlng = new google.maps.LatLng(lat,lng);
    	
      var mapOptions = {
        center: myLatlng,
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.HYBRID
      };
      var map = new google.maps.Map(document.getElementById("map-canvas-"+id),
          mapOptions);
    }
</script>

<script type="text/javascript">
initialize_anteprima(<?php echo $this->model->get_lat(); ?>,<?php echo $this->model->get_lng(); ?>,'map-canvas');
</script>

<div id="map-canvas"></div>
