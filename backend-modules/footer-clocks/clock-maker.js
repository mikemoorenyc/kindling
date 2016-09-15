jQuery(document).ready(function( $ ) {

  const emptyState = (
    `<div class="empty-state disabled">
      You have not added any clocks yet.
    </div>
    `
  );

  const addForm = (
    `
    <div class="add-form">
    <label>Initials</label>
    <input type="text" name="initials" />

    </div>
    `
  );

  var listCount = 0;

  function stateUpdate() {

    var updateList = [];
    $('#footer-clock-list li').each(function(){
      var item = {
        "name": $(this).find('.name').text(),
        "offset" : $(this).find('.offset').text()
      }
      updateList.push(item);
    });

    $('input#footer_clocks').val(JSON.stringify(updateList));
    console.log(updateList);
    listCount = updateList.length;
    if(listCount < 1) {
      $('#footer-clock-list').before(emptyState);
    } else {
      $('.empty-state').remove();
    }
    if(listCount >= 1) {
      $("#footer-clock-container button.add").hide();
      $('$footer-clock-container ').append((
        `
          <div class="too-much">
            You have add the maximum amount of clocks.
          </div>
        `
      ));
    } else {
      $("#footer-clock-container button.add").show();
      $("#footer-clock-container .too-much").remove();
    }
  }

	$(clockinitial).each(function(index,e){


    let temp = (
      `
      <li>
        <div class="name">${e.name}</div>
        <div class="offset">${e.offset}</div>
        <button>Delete</button>
      </li>
      `
    );
    $('#footer-clock-list').append(temp);
  });
  stateUpdate();

  //
  $('#footer-clock-container button.add').click(function(e){
    e.preventDefault();
    if(listCount >= 1) {
      return false;
    }
    console.log('click');
  });

});
