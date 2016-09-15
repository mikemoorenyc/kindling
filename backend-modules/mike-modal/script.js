const globalModal={};
jQuery(document).ready(function($){

  $('.mike-modal-popper').on('click',function(e){
    e.preventDefault();
    $('#mike-modal .title').text($(this).data('modal-title'));
    $('#mike-modal .content').html($('#'+$(this).data('content')).html());
    $("#mike-modal button.button-primary").text($(this).data('modal-button-copy'));
    $('#mike-modal .modal .content').css({
        width: $(this).data('width'),
        height: $(this).data('height') - 90
    });
    $('#mike-modal').show();


    $('html').addClass('mike-modal-open');



    return false;
  });

  $('#mike-modal button.cancel').on('click',function(){
    $("#mike-modal").hide();
    $('html').removeClass('mike-modal-open');
    $('#mike-modal .content').empty();
  });

  $("#mike-modal button.button-primary").on('click',function(e){
    e.preventDefault();
    $( globalModal ).trigger( "primary-click" );
    $("#mike-modal").hide();
    $('html').removeClass('mike-modal-open');
    $('#mike-modal .content').empty();

  });

});
