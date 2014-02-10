<div id="mappa">
<form name="aggiungi_luogo" action = "<?php echo init::link('luoghi','aggiungi'); ?>" method="post" id="aggiungi-luogo">
Da questa sezione &egrave; possibile aggiungere un luogo: compila i campi e prova a fare il geocode dell&acute; indirizzo.<br />
Se ha successo, clicca su OK per aggiungere il luogo al tuo profilo.<br />
Ricordati di inserire sempre almeno Stato e Citt&agrave; altrimenti il luogo non sar&agrave; inserito.<br />
<input type="hidden" name="location" id="location_place">
<input id="indirizzo" type="text" name="indirizzo" value="Indirizzo" onclick="this.value=''" onblur="codeAddress()" />
<input id="citta" type="text" name="citta" value="Citta" onclick="this.value=''" onblur="codeAddress()" />
<input id="prov" type="text" name="prov" value="Provincia" onclick="this.value=''" onblur="codeAddress()" />
<input id="stato" type="text" name="stato" value="Stato" onclick="this.value=''" onblur="codeAddress()" />
</form>
</div>
 <div id="map-canvas"></div>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

