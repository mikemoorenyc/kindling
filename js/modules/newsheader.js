function newsHeader() {
  if($('#news-header').hasClass('activated') === false) {
    var controlBtn = (`
      <button class="news-control open">
        <svg>
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#controls"></use>
        </svg>
      </button>
      `);


    $('#news-controls .selector select').each(function(){
      var parent = $(this).closest('.selector');
      var voptions = [];

      $(this).find('option').each(function(){
        var selection = {
          'name': $(this).text(),
          'link' : $(this).attr('value')
        }
        var total = voptions.push(selection);
      });

      var html = (`
        <div class="drop-down-holder">
          <ul class="drop-down no-style">
            ${voptions.map(tag => `<li><a href="${tag.link}">${tag.name}</a></li>`).join('\n      ')}
          </div>
        </div>
        `);
        $(parent).append(html);
        $(this).remove();
    });
    $('#news-header').append(controlBtn).addClass('activated');


  }
  if($('.pagination-container a.right-side').length) {
    var loadMoreUrl = $('.pagination-container a.right-side').attr('href');
    $('.pagination-container').empty();
    $('.pagination-container').append(`
        <a href="${loadMoreUrl}" class="load-more-link">
          <span class="control-text">Load More Posts</span>
          <svg>
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#left-arrow"></use>
          </svg>
        </a>
        <svg class="loader">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#loading-stripes"></use>
        <svg>
      `);
    $('.pagination-container').show();
  } else {
    $('.pagination-container').hide();
  }
  $('#news-header button.news-control').click(function(e){
    e.preventDefault();
    $('#news-controls').toggleClass("open");
    $('#news-header button.open').toggleClass("menu-open");
  });
  $('#news-header button.news-control.close').click(function(){
    $('#news-controls .selector').removeClass('drop-down-activated');
    $('#news-header').removeClass('drop-down-activated');
  });
  $('#news-controls .selector .holder').click(function(){
    var isActive = $(this).closest('.selector').hasClass('drop-down-activated');
    $('#news-controls .selector').removeClass('drop-down-activated');
    $('#news-header').removeClass('drop-down-activated');
    if(!isActive) {
      $(this).closest('.selector').addClass('drop-down-activated');
      $('#news-header').addClass('drop-down-activated');
    }
    return false;
  });
  $('#news-controls .selector .drop-down-holder li a').click(function(){
    var newURL = $(this).attr('href');
    newsAdder(newURL, false);
    $('#news-header button.news-control.close').click();

    return false;
  });
  $('.pagination-container a.load-more-link').click(function(){
    var newURL = $(this).attr('href');
    newsAdder(newURL, true);
    return false;
  });

  function newsAdder(url, appending) {
    if(!$('#news-items .loader-bar').length) {
      $('#news-items').addClass('loading').append('<div class="loader-bar" />');
    }
    if(appending) {
      $('.pagination-container').addClass('loading');
    }
    $.ajax({
        method: 'GET',
        url: url,
        dataType: 'html'
      })
      .done(function(data){
        $('#news-items .loader-bar').remove();
        $('#news-items').removeClass('loading')
        if($(data).find('.pagination-container a.right-side').length) {
          $('.pagination-container .load-more-link').attr('href', $(data).find('.pagination-container a.right-side').attr('href'));
          $('.pagination-container').show();
        } else {
          $('.pagination-container').hide();
        }
      })
      .success(function(data){
        var newHeader = $(data).find("#news-header h1").text();
        var newContent = $(data).find('#news-items').html();
        if(!appending) {
          $('#news-header h1').text(newHeader);
          $('#news-items').empty();
          $('#news-items').html(newContent);
        } else {
          $('#news-items').append(newContent);
          $('.pagination-container').removeClass('loading');

          // WRITE MORE CHECK
        }

      })
      .error(function(){
        $('#news-items .loader-bar').remove();
        $('#news-items').removeClass('loading')
      });
  }

/*
  if($('.year-list .year-item').length < 2) {
    $('.year-list').remove();
    return false;
  }
  var moveSlide = 0;

  $('.year-list .year-item a').wrapInner('<span/>');
  $('.year-list .year-item a').each(function(index, e){
    $(this).attr('data-year', $(this).text());
    if($(this).attr('data-year') == currentYearDate) {
      $(this).addClass('current');
      moveSlide = index;
    }
  });



  if($('#news-header').hasClass('activated') === false) {
    $('.year-list').slick({
      variableWidth: true,
      infinite: false
    })
  }


  $('#news-header').addClass('activated');
*/
}
