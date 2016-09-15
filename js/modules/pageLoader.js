//PAGE LOADER FUNCTION
function pageLoader() {
  // BASE STUFF

  //NAV ACTIVE CLASSES
//  $('nav ul li, nav ul li a').removeClass('__active');
//  $('nav ul li.'+theSlug).addClass('__active');
//  $('nav ul li.'+theSlug).find('a').addClass('__active');
  /*
  $('#poster-container > img').load(function(){
    console.log('loaded');
    var vibrant = new Vibrant($(this)[0]);
    var swatch = vibrant.swatches();
    var color = swatch['DarkMuted'].getHex();

    $('footer').css('background-color', color);
  });
  $('#poster-container > img').attr('src', $('#poster-container > img').data('src'));
  */
  if ( $( "#news-items" ).length ) {

  //  newsItemVibrant();
  }
  if($('#news-header').length ) {

    newsHeader();
  }
  if($('#member-blocks').length) {
    memberBlocks();
  }
  //MAKE INTERNAL LINKS
  var siteURL = "http://" + top.location.host.toString();
  var internalLinks = $("a[href^='"+siteURL+"'], a[href^='/'], a[href^='./'], a[href^='../']");
  $(internalLinks).addClass('internal');
  $('a.internal').each(function(){
    var linkstr = $(this).attr('href');
    if($(this).attr('target') == "_blank" || linkstr.indexOf('.pdf') >= 0 || linkstr.indexOf('.jpg') >= 0 || linkstr.indexOf('.png') >= 0) {
      $(this).removeClass('internal');
    }
  });

  //RUN PAGE SPECIFIC FUNCTIONS

  /*
  if (typeof window['runner'+theSlug] == 'function') {

    window['runner'+theSlug]();
  } else {

  }
*/


}
