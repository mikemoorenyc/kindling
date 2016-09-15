jQuery(document).ready(function( $ ) {

  var points = [];

  var center = new google.maps.LatLng(initialStates.center.lat,initialStates.center.lng);
  var mapOptions = {
    zoom: initialStates.zoom,
    center: center,
    disableDefaultUI: true,
    zoomControl: true
  };



  map = new google.maps.Map(document.getElementById('selector-map'),
  mapOptions);

  //ADD IN THE CENTER PIN

    var centerMarker = new google.maps.Marker({
      position: center,
      map: map,
      draggable:false,
      clickable: false,
      opacity: .75,
      icon: {
        url: initialStates.siteDir+'/assets/imgs/map-center.png',
        scaledSize: new google.maps.Size(25, 25),
        anchor: new google.maps.Point((25/2), (25/2))
      }
    });

  var baseID = 0;
  //ADD IN THE INITIAL PINS
  $(initialStates.points).each(function(index,e){
    if(e.id > baseID) {
      baseID = e.id;
    }
    pointAdder(new google.maps.LatLng(e.lat,e.lng),e.title,false)
  });
  saveUpdate();


  function idGenerator() {
    var newID = baseID + 1;
    baseID = newID;
    return newID;
  }


  //CHANGE CENTER PIN
  $('#set-map-center').click(function(){
    var center = map.getCenter(),
        lat = center.lat(),
        lng = center.lng(),
        latlng = lat+','+lng;

    $('input#google_coordinates').val(latlng);
    stateChange = true;
    centerMarker.setPosition(center);


    return false;
  });
  //SET UP SEARCH BOX
  var input = document.getElementById('search-input');
  var searchBox = new google.maps.places.SearchBox(input);
  //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  searchBox.setBounds(map.getBounds());
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });
  //CHANGE ZOOM LEVEL
  $('#set-zoom-level').click(function(){
    var zoom = map.getZoom();


    $('input#zoom_level').val(zoom);
    stateChange = true;



    return false;
  });

  //SEARCH FUNCTIONALITY
  geocoder = new google.maps.Geocoder();

  $('#search-holder .search-btn').click(function(){
    //searchFetcher();

    return false;
  });
  function enterKeyDown() {
    return false;
  }
  $( "#search-input" ).keydown(function(event){
    if (event.keyCode == 13) {
    //  searchFetcher();
      return false;
    }

  });
  searchBox.addListener('places_changed', function() {
    if($('#map-holder').hasClass('pop-open')) {
      return false;
    }

    var location = searchBox.getPlaces()[0].geometry.location;
    map.setCenter(location);
    //https://developers.google.com/maps/documentation/javascript/examples/places-searchbox
    if($('#map-holder').hasClass('adding-a-point')) {
      pointAdder(location,searchBox.getPlaces()[0].name,true)
    }
    $( "#search-input" ).val('');

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
        map.setCenter(theLocation);
        $('#search-holder').removeClass('__page-loading');


      } else {
        $('#search-holder').removeClass('__page-loading');
        alert('We were unable to locate your address.');
      }
    });

  }

  //CANCEL ADD
  function cancelAddPoint() {
    $('#map-holder').removeClass('adding-a-point').removeClass('pop-open');
    map.setOptions({
      zoomControl: true,
      draggable: true
    });
    $('#add-a-point').text('Add a point of interest');
  }

  //ADDDING A MAP POINT
  $('#add-a-point').click(function(){
    if($('#map-holder').hasClass('adding-a-point')) {
        cancelAddPoint();
    } else {
      $('#map-holder').addClass('adding-a-point');
      map.setOptions({
        zoomControl: false
      });
      $(this).text('Cancel');
    }

    return false;
  });


  map.addListener('click', function(event) {
    if(!$('#map-holder').hasClass('adding-a-point') || $('#map-holder').hasClass('pop-open') ) {
      return false;
    }
    pointAdder(event.latLng,'',true)
  });

  function pointAdder(position, title, addingPoint) {
    var id = idGenerator();
    var newPoint= new google.maps.Marker({
      position: position,
      map: map,
      id: id,
      draggable: true,
      title: title
    });
    points.push(newPoint);
    //FIND THE INDEX
    var keyVal = 879687;
    $(points).each(function(index,e){
      if(e.id == id) {
        keyVal = index;
      }
    });
    points[keyVal].addListener('click', function(){
      popMaker(points[keyVal], keyVal, false);
    });

    points[keyVal].addListener('dragend',function(){
      saveUpdate();
    });
    if(addingPoint == true) {
      popMaker(points[keyVal], keyVal, true);
    }

  }
  function popMaker(marker, keyVal, newPoint) {

    $('#map-holder').addClass('pop-open');
    var newClass = '';
    if (newPoint==true) {
      newClass = 'new-point'
    }
    var id = keyVal;
    var title = marker.title;
    //REPLACE IN TEMPLATE
    var template = $('#pop-up-template').html();
    template = template.replace("***REPLACE***", title);
    var boxOptions = {
      closeBoxURL: '',
      content : '<div class="point-wrap" data-id="'+id+'" data-new="'+newClass+'">'+template+'</div>',
      boxClass : 'point-pop '+newClass,
      infoBoxClearance : new google.maps.Size(20, 200),
      alignBottom: true,
      pixelOffset: new google.maps.Size(-150, -50)
    }
    points[id].infoBox = new InfoBox(boxOptions);
    points[id].infoBox.addListener('domready',function(){
      //SET THE INPUT


      $('.point-wrap[data-id="'+id+'"] button.cancel-point').on('click',function(){
        var pDom = $(this).closest('.point-wrap')
        var id = parseInt($(pDom).attr('data-id')),
            np = $(pDom).attr('data-new');
        if(np === 'new-point') {
          $(pDom).remove();
          points[keyVal].infoBox.close();
          points[keyVal].setMap(null);
          points.pop();
          saveUpdate();
          cancelAddPoint();

          return false;
        } else {
          $(pDom).remove();
          points[id].infoBox.close();
          cancelAddPoint();
          return false;
        }

      });
      //REMOVE NUTTON
      $('.point-wrap[data-id="'+id+'"] a.remove').on('click',function(){
        var pDom = $(this).closest('.point-wrap')
        var id = parseInt($(pDom).attr('data-id')),
            np = $(pDom).attr('data-new');
        var confirmed = confirm('Permanently remove point?');
        if(confirmed) {
          $(pDom).remove();
          points[id].infoBox.close();
          points[id].setMap(null);
          points[id].deleted = true;
          saveUpdate();
          cancelAddPoint();
        }
        return false;
      });
      //SAVE BUTTON
      $('.point-wrap[data-id="'+id+'"] button.save-point').on('click',function(){
        var pDom = $(this).closest('.point-wrap')
        var id = parseInt($(pDom).attr('data-id')),
            np = $(pDom).attr('data-new'),
            name = $(pDom).find('input#point-name').val();

            if(name.length < 1) {
              alert('This point needs a name');
              return false;
            } else {
              //SET NAME
              points[id].setTitle(name);
              points[id].title = name;
              $(pDom).remove();
              points[id].infoBox.close();
              saveUpdate();
              cancelAddPoint();
            }

      });

    });
    points[id].infoBox.open(map, points[id]);


  }

  function saveUpdate() {
    $('input#point_array').val('');
    var pString = [];

    $(points).each(function(index,e){



      var point = {
        id: e.id,
        title:e.title,
        lat: e.position.lat(),
        lng: e.position.lng()
      }

      if(e.deleted != true) {
        pString.push(point);
      }


    });


    $('input#point_array').val(JSON.stringify(pString));
  }



});
