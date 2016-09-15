jQuery(document).ready(function( $ ){

$('button#add-a-video').on('click',function(){
  $('body').addClass('modal-open');
  $('#add-video-modal').show();

  stateChecker();

  return false;
});
$("#add-video-modal button.cancel").click(function(){
  $('input#video-url, input#video-display-name').val('');
  $('body').removeClass('modal-open');
  $('#add-video-modal').hide();
});
$('input#video-url, input#video-display-name').on('paste',function(){
  stateChecker();
});
$('input#video-url, input#video-display-name').on('keyup',function(){
  stateChecker();
});

$('#add-video-modal .footer .add-video').on('click',function(){
  var url = $('input#video-url').val();
  var name = $('input#video-display-name').val();
  wp.media.editor.insert('[portfoliovideo url="'+url+'" title="'+name+'"]');
  $('input#video-url, input#video-display-name').val('');
  $('body').removeClass('modal-open');
  $('#add-video-modal').hide();
  return false;
});

function stateChecker() {
  var url = $('input#video-url').val();
  var name = $('input#video-display-name').val();
  if(url != false && name != false) {
    $('#add-video-modal .footer .add-video').removeAttr('disabled');
  } else {
    $('#add-video-modal .footer .add-video').attr('disabled', '');
  }
}


});
