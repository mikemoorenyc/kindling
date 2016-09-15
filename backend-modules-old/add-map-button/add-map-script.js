jQuery(document).ready(function( $ ){

$('button#add-a-map').on('click',function(){
  $('body').addClass('modal-open');
  $('#add-map-modal').show();

  stateChecker();

  return false;
});
$('.little-modal button.close, .little-modal .cancel').on('click',function(){
  $('body').removeClass('modal-open');
  $('#add-map-modal').hide();
  return false;
});
$('#map-selector').on('change',  function(){
  stateChecker()
});
$('#map-display-name').on('keyup',   function(){
  stateChecker()
});
$('#add-map-modal .footer .add-map').on('click',function(){
  var map = $('#map-selector').val();
  var name = $('#map-display-name').val();
  wp.media.editor.insert('[portfoliomap id="'+map+'" title="'+name+'"]');
  $('#map-display-name').val('');
  $('body').removeClass('modal-open');
  $('#add-map-modal').hide();
  return false;
});

function stateChecker() {
  var map = $('#map-selector').val();
  var name = $('#map-display-name').val();
  if(map != false && name != false) {
    $('#add-map-modal .footer .add-map').removeAttr('disabled');
  } else {
    $('#add-map-modal .footer .add-map').attr('disabled', '');
  }
}


});
