<?php

function pullquote_shortcode( $atts, $content = null ) {
	return '<div class="pullquote '.$atts['side'].'"><div class="inner">&ldquo;' . trim($content) . '&rdquo;</div></div>';
}
add_shortcode( 'pullquote', 'pullquote_shortcode' );


function add_pull_quote_button() {

  ?>
  <button id="add-a-video" class="button mike-modal-popper" type="button" data-modal-title="Add a Pull Quote" data-modal-button-copy="Add Pull Quote" data-content="pull-quote-modal" >Add Pull Quote</button>
  <?php
}

add_action('media_buttons', 'add_pull_quote_button');

//BOTTOM
add_action('admin_footer-post.php', 'blockquote_html');
add_action('admin_footer-post-new.php', 'blockquote_html');

function blockquote_html() {
  add_mike_modal();
  ?>
  <div id="pull-quote-modal" style="display:none;">
      <textarea id="pull-quote-textarea" style="display:block; width: 100%; height: 150px;"></textarea>
      <br/>
      <label style="display:block;">Pull Quote Side</label>
      <select id="pull-quote-side" style="display:block; width:100%">
        <option value="left" selected>Left</option>
        <option value="right">Right</option>
      </select>
  </div>

  <script>
    jQuery(document).ready(function($){

      $(globalModal).on('primary-click', function(){
        var side = 'left';
        var quote = $("#mike-modal #pull-quote-textarea").val();
        wp.media.editor.insert('[pullquote side="'+$('#pull-quote-side').val()+'"]'+quote+'[/pullquote]');
      });

    });


  </script>

  <?php
}

 ?>
