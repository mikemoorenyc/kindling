function memberBlocks() {
  var mb = $('#member-blocks');
  if($(mb).data('is-more') !== true) {
    return false;
  }
  var url = $(mb).data('postfetch');
  var skip = $(mb).data('skip');
  var item = 'item-block';

  $(mb).after(`
    <div class="pagination-container content-container container-style clearfix">
    <button class="load-more-link">
      <span class="control-text">View All Members</span>
      <svg>
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#left-arrow"></use>
      </svg>
    </button>
    <svg class="loader">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#loading-stripes"></use>
    <svg>

    </div>
    `);

    $('.load-more-link').click(function(e){
      e.preventDefault();

      $(this).parent().addClass('loading');

      $.ajax({
          method: 'GET',
          url: url,
          dataType: 'html'
        })

        .success(function(data){

          $(data).find('.item-block').each(function(i,e){
            var theID = $(this).data('id');

            if($('.item-block[data-id="'+theID+'"]').length) {

              return ;
            }
            $('#member-blocks').append($(this));
            $('.pagination-container').remove();

          });
        });
    });
}
