jQuery(document).ready(function($){

  function statusCheck() {
    var format = $("input[name='post_format']:checked"). val();
    var type = $("input[name='link_link-type']:checked"). val();
    if(format == 0) {
      $('#wck-link').hide();
      $('#postdivrich').removeClass('disabled');
      $(window).scrollTop($(window).scrollTop()+1);
      $(window).scrollTop($(window).scrollTop()-1);
    } else {
      $('#wck-link').show();
      $('#postdivrich').addClass('disabled');
    }
    if(type == 'url') {
      $('li.row-file-upload').hide();
      $('li.row-url').show();
    } else {
      $('li.row-file-upload').show();
      $('li.row-url').hide();
    }
  }


  $("input[name='post_format'],input[name='link_link-type']").on('change',function(){
    statusCheck();
  });


 statusCheck();
});
