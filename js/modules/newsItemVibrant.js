function newsItemVibrant() {
  $("#news-items .news-item .cover-container > img").each(function(){

    if($(this).hasClass('vibrant')) {
      return;
    }

    if (!this.complete) {
  		$(this).load(function(){
  			getVibrant($(this)[0], $(this).parent());
  		});
	  } else {
		  getVibrant($(this)[0], $(this).parent());
	  }

    function getVibrant(img, parent) {
      var vibrant = new Vibrant(img);
      var swatch = vibrant.swatches();
      var color = swatch['Vibrant'].getHex();
      $(parent).css('background', color);
    }


  });
}
