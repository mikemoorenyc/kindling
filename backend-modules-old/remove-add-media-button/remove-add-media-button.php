<?php
function remove_enqueue($hook) {
  global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
    if ( !('post.php' == $hook || 'post-new.php' == $hook) ) {
        return;
    }


    wp_enqueue_script( 'my_custom_script', get_bloginfo('template_url').'/backend-modules/remove-add-media-button/script.js' );

}
add_action( 'admin_enqueue_scripts', 'remove_enqueue' );
?>
