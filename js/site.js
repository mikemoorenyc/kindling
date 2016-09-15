function siteInit() {
  //DECLARE GLOBAL APP HERE
    var myApp = {
      siteDir: phpvars_siteDir,
      ww: $(window).width(),
      wh: $(window).height(),
      dt: 801,
      tab: 401,
      ts: 500,
      widescreen: false,
      orientation : function() {
        function decider(w,x) {
          if (w >= x) {
          $('html').addClass('_orientation-landscape').removeClass('_orientation-portrait');
          }else {
           $('html').removeClass('_orientation-landscape').addClass('_orientation-portrait');
          }
        }
        decider(this.ww,this.wh);

        $(window).resize(function(){
          this.ww = $(window).width();
          this.wh = $(window).height();
          decider(this.ww,this.wh);
        }.bind(this));

      }
    };
    myApp.orientation();
  //theHistory();


  $.ajax({
      method: 'GET',
      url: myApp.siteDir+'/assets/svgs.svg',
      dataType: 'html'
    })
    .done(function(data){

      $('body').prepend('<div class="hide">'+data+'</div>');
    });











  function dateMaker() {

    $('.clock-thing').each(function(){
      var theDiff = $(this).data('diff');
      var date = new Date();
      date.setHours(date.getUTCHours() + theDiff);
      var hour = date.getHours();
      var minute = date.getUTCMinutes();
      var angle = (hour * 30) + (minute / 2);
      $(this).find('.hours').css(
        {
          'transform' : 'rotate('+angle+'deg)'
        }
      )
      $(this).find('.minutes').css('transform', 'rotate('+(minute * 6)+'deg)');
    });
  }
  dateMaker();



  //CHECK IF CSS IS LOADED
  var thechecker = setInterval(function(){
    var ztest = $('#css-checker').css('height');

    if(ztest == '1px') {
      var cssLoaded = true;
      clearInterval(thechecker);
      console.log('css loaded');
    }
  }, 10);







  pageLoader();

  $('html').addClass('_page-loaded');
  console.log('scripts loaded');
}









//DON'T TOUCH
var siteScriptsLoaded = true;
siteInit();
