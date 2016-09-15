<?php
add_theme_support( 'post-formats', array( 'link') );
//ADD SCRIPT
function add_post_switch_script($hook) {
  global $post;
  if($post->post_type != 'post') {
    return;
  }
    if ( !('post.php' == $hook || 'post-new.php' == $hook) ) {
        return;
    }


    wp_enqueue_script( 'add_post_switch_script', get_bloginfo('template_url').'/backend-modules/post-type-switcher/state-switcher.js' );

}
add_action( 'admin_enqueue_scripts', 'add_post_switch_script' );


/*
Field Title: File
Slug:file (Note:changing the slug when you already have a lot of existing entries may result in unexpected behavior.)
Field Type: upload
Description:
Required: false
Default Value:
Attach upload to post: yes


Field Title: File Type
Slug:file-type (Note:changing the slug when you already have a lot of existing entries may result in unexpected behavior.)
Field Type: text
Description:
Required: false
Default Value: PDF

*/
 ?>
