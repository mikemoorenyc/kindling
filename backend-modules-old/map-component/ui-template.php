<style>
<?php include 'map-styles.css';?>
</style>

<div id="map-holder">
  <?php
  $center_coordinates = get_post_meta( $post->ID, '_centerCoordinates', true );
  $zoom_level = get_post_meta( $post->ID, '_zoomLevel', true );
  $point_array = preg_replace( "/\r|\n/", "", get_post_meta( $post->ID, '_pointArray', true ) );
  if($center_coordinates == false) {
    $center_coordinates = '40.761731,-73.981816';
  }
  if($zoom_level == false) {
    $zoom_level = '15';
  }
  $pa = json_decode($point_array);
  if(!empty($pa)) {

    $new = '[';
    $looper = 0;
    foreach($pa as $p) {
      if($looper > 0) {
        $new .= ',';
      }
      $new .='{';
      $new .= 'id:'.$p->id.',';
      $new .= 'title:"'.$p->title.'",';
      $new .= 'lat:'.$p->lat.',';
      $new .= 'lng:'.$p->lng.'}';
      $looper++;
    }
    $new .=']';
    $point_array = $new;


  }

  if($point_array == false) {
    $point_array = '[]';
  }

  ?>

  <input type="hidden" id="google_coordinates" name="google_coordinates" value="<?php echo $center_coordinates;?>" />
  <input type="hidden" id="zoom_level" name="zoom_level" value="<?php echo $zoom_level;?>" />
  <input type="hidden" id="point_array" name="point_array" value="<?php echo $point_array;?>" />
  <div id="selector-map" style="position:relative; width: 100%; height: 600px;"></div>
  <div id="top-ui">
    <div id="search-holder">
      <input type="text" id="search-input" placeholder="Search for an address..." />

      <a href="#" class="search-btn"></a>

    </div>
    <div id="map-controls">
      <button type="button" class="button" id="add-a-point">Add a Point of Interest</button>
      <button type="button" class="button" id="set-map-center">Set Map Center<span class="tool-tip">Click here to set the current map center as the published map's center.</span></button>
      <button type="button" class="button" id="set-zoom-level">Set Zoom Level<span class="tool-tip">Click here to set the current map's zoom level as the published map's zoom level.</span></button>
    </div>

  </div>

</div>

<div id="pop-up-template" class="point-pop" style="display:none;">
  <div class="top">
    <label for="point-name">Point Name</label>
    <input type="text" id="point-name" name="point-name" value="***REPLACE***" />
  </div>
  <div class="footer">
    <a href="#" class="remove remove-point" id="">Remove</a>
    <button class="button cancel-point" id="">Cancel</button>
    <button class="button button-primary save-point" id="">Save</button>
    <br class="clear" />
  <div>


</div>

<script>
var centerString = '<?php echo $center_coordinates;?>';
var centerArray = centerString.split(',');
var initialStates = {
  siteDir: '<?php echo get_bloginfo('template_url');?>',
  center: {
    string: centerString,
    lat: parseFloat(centerArray[0]),
    lng: parseFloat(centerArray[1])
  },
  zoom: <?php echo $zoom_level;?>,
  points:<?php echo $point_array;?>
}
/*
var stateChange = false;
jQuery('#publishing-action input').click(function(){
  stateChange = false;
});
*/
//STATE CHANGE
/*
var confirmOnPageExit = function (e)
{
    if(stateChange == false) {
      return null;
    }
    // If we haven't been passed the event get the window.event
    e = e || window.event;



    var message = 'You have unsaved changes to this map. They will be lost.';

    // For IE6-8 and Firefox prior to version 4
    if (e)
    {
        e.returnValue = message;
    }

    // For Chrome, Safari, IE8+ and Opera 12+
    return message;
};
window.onbeforeunload = confirmOnPageExit;
*/

</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=places"></script>
<script><?php include 'infobox.js';?></script>
<script><?php include 'map-scripts.js';?></script>
<!--
<div class="hide" style="display:none;">
<?php
$svg = file_get_contents(get_bloginfo('template_url').'/assets/svgs.svg');
echo $svg;
?>
-->

</div>

<!--
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
-->
