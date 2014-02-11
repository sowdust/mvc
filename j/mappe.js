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
   var darimuovere = document.getElementById('tastino');
   if(darimuovere)
       {
           darimuovere.parentNode.removeChild(darimuovere);
       }
  var f = document.createElement('input');
  f.setAttribute('type','submit');
  f.setAttribute('name','conferma');
  f.setAttribute('value','Ok!');
  f.setAttribute('id','tastino');
  document.getElementById('aggiungi-luogo').appendChild(f);
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      /*alert('Geocode was not successful for the following reason: ' + status);*/
    }
  });
}

