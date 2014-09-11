<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?sensor=false">
</script>
<script type="text/javascript">
    function initialize() {

        var myLatlng = new google.maps.LatLng(<?php echo $this->model->get_lat() . "," . $this->model->get_lng(); ?>);

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
            title: "<?php echo $this->model->get_citta(); ?>"
        });

        var fumetto = '<div id="content">' +
                '<div id="siteNotice">' +
                '</div>' +
                '<h1 id="firstHeading" class="firstHeading"><?php echo $this->model->get_citta(); ?></h1>' +
                '<div id="bodyContent">' +
                '<?php echo $this->model->get_tutto(); ?>' +
                '</div>' +
                '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: fumetto
        });


        google.maps.event.addListener(marker, 'click', function () {
            infowindow.open(map, marker);
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>

<?php
require_once('model/user.php');
$autore = new user($this->db, $this->model->get_uid());
?>
<div class="page-header">
    <h1><?php echo $this->model->get_citta(); ?>, <small><?php echo $this->model->get_indirizzo(); ?>, <?php echo $this->model->get_stato(); ?></small></h1>
</div>

<div id="map-canvas"></div>


<a href="#" onclick="comment_form(<?php echo $this->model->get_id(); ?>, 'luogo', true);
        return false;"> <img src="<?php echo config::icons; ?>scrivi.png" class="icon" /> Commenta</a>
<div id="contenuto_commento_header_<?php echo $this->model->get_id(); ?>"></div>

<?php
require_once('model/commento.php');
foreach ($this->model->get_commenti() as $id_com) {
    $c = new view('commenti', 'vedi');
    $c->set_message($id_com);
    $c->set_db($this->db);
    $c->set_user($this->user);
    $c->render(false);
}
?>

<br />
<br />
<br />
<br />


