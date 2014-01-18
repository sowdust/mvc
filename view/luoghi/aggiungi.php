<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Geocoding service</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -280px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var geocoder;
var map;
function initialize() {
	geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(45.0703987, 7.6849268);
  //var latlng = new google.maps.LatLng(-34.397, 150.644);
  var mapOptions = {
    zoom: 8,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

function codeAddress() {
	var address = document.getElementById('indirizzo').value;
	address += ', ' + document.getElementById('citta').value;
	address += ', ' + document.getElementById('prov').value;
	address += ', ' + document.getElementById('stato').value;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	document.getElementById('location_place').setAttribute('value',results[0].geometry.location);
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
</head>
<body>
<div id="panel">
<form name="aggiungi_luogo" action = "<?php echo init::link('luoghi','aggiungi'); ?>" method="post">
<input type="hidden" name="location" id="location_place">
<input id="indirizzo" type="text" name="indirizzo" value="Indirizzo" onclick="this.value=''">
<input id="citta" type="text" name="citta" value="Citta'" onclick="this.value=''">
<input id="prov" type="text" name="prov" value="Provincia" onclick="this.value=''">
<input id="stato" type="text" name="stato" value="Stato" onclick="this.value=''">
<!--      <input id="address" type="textbox" value="Sydney, NSW"> -->
<input type="button" value="Geocode" onclick="codeAddress()"><br />
<label for="conferma">Quando il luogo ti soddisfa, clicca su ok:</label>
<input type="submit" name="conferma" value="Ok!">
<a href="index.php">Home</a>
<!--<button onclick="goBack(2)">Torna indietro</button>-->
</form>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>
