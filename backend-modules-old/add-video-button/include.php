<?php

function add_video_button() {
  global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
  ?>
  <button href="#" id="add-a-video" class="button" type="button">Add a video</button>
  <?php
}

add_action('media_buttons', 'add_video_button');


//ADD SCRIPT
function add_video_script($hook) {
  global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
    if ( !('post.php' == $hook || 'post-new.php' == $hook) ) {
        return;
    }


    wp_enqueue_script( 'add_video_script', get_bloginfo('template_url').'/backend-modules/add-video-button/add-video-script.js' );

}
add_action( 'admin_enqueue_scripts', 'add_video_script' );

?>
<?php
//BOTTOM CONTENT

add_action('admin_footer', 'video_modal_content');
function video_modal_content() {
	global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
  ?>
  <div class="little-modal" id="add-video-modal" style="display:none;">
    <div class="inner">

      <div class="content">
        <label>Vimeo or Youtube URL</label>
        <input type="text" id="video-url" />
        <label>Video Display Title</label>
        <input type="text" id="video-display-name" />



      </div>
    <div class="footer" id="plugin-information-footer">
      <button class="cancel button ">Cancel</button>
      <button class="add-video button button-primary" disabled>Add Video</button>
    </div>

    </div>

  </div>



  <?php
}

?>
