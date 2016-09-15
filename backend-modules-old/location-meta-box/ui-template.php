<div id="map-holder">
  <?php
  $value = get_post_meta( $post->ID, '_coordinates', true );

  ?>
  <input type="hidden" id="google_coordinates" name="google_coordinates" value="<?php echo $value;?>" size="25" />
  <div id="selector-map" style="position:relative; width: 100%; height: 500px;"></div>

  <div id="search-holder">
    <input type="text" id="search-input" placeholder="Search for an address..." onkeydown="if (event.keyCode == 13) return false"/>

    <a href="#" class="search-btn"></a>

  </div>

</div>
<?php
if ($value == '') {
  $value = '40.767851, -73.982080';
}
?>

<script>



function initialize() {
  //center = new google.maps.LatLng(40.802391,-73.179438);
  center = new google.maps.LatLng(<?php echo $value;?>);
  var mapOptions = {
    zoom: 15,
    center: center,
    disableDefaultUI: true,
    zoomControl: true
  };

  map = new google.maps.Map(document.getElementById('selector-map'),
  mapOptions);

  geocoder = new google.maps.Geocoder();

  mapMarker = new google.maps.Marker({
    position: center,
    map: map,
  });


  // SET LOCATION ON CLICK

  google.maps.event.addListener(map, 'click', function(event) {
      placeUpdater(event.latLng);
  });




}

//PLACE UPDATER
function placeUpdater(location, mover) {
  mapMarker.setPosition(location);
  var elem = document.getElementById("google_coordinates");
  var realValue = String(location);
  realValue = realValue.replace('(','');
  realValue = realValue.replace(')','');
  elem.value = realValue;
  if(mover == true) {
    map.setCenter(location);
  }
}


function loadMap() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?sensor=true&v=3.exp&' +
  'callback=initialize';
  document.body.appendChild(script);
}

window.onload = loadMap;

//SEARCH FUNCTIONALITY

jQuery(document).ready(function( $ ) {

$('#search-holder .search-btn').click(function(){
  searchFetcher();

  return false;
});

function searchFetcher(location) {
  var location = $('#search-input').val();
  if(location == '') {
    return false
  }
  $('#search-holder').addClass('__page-loading');
  geocoder.geocode({'address': location}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      theLocation = results[0].geometry.location;
      placeUpdater(theLocation, true);
      $('#search-holder').removeClass('__page-loading');

    } else {
      $('#search-holder').removeClass('__page-loading');
      alert('We were unable to locate your address.');
    }
  });

}


});






</script>


<style>
#map-holder {
  position:relative;
}
#map-holder #search-holder {
  background:white;
  position: absolute;
  right: 10px;
  top: 10px;
  left: 10px;
  box-shadow: 0 2px 2px rgba(0,0,0,.1);
}
#map-holder #search-holder #search-input {
  display:block;
  margin: 0;
  padding: 0;
  border: 0;
  box-shadow: none;
  height: 50px;
  background:none;
  width: 100%;
  padding: 0 75px 0 10px;
  font-size: 25px;
}
#map-holder #search-holder .search-btn {
  display: block;
  position: absolute;
  right: 0;
  top: 0;
  width: 50px;
  height: 50px;
  background: red;
  box-shadow: none !Important;
}
</style>
