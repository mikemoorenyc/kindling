<?php
add_action('admin_footer-post.php', 'linkui');
add_action('admin_footer-post-new.php', 'linkui');

function linkui() {
  global $post;
  if($post->post_type !== 'post') {
    return;
  }
  ?>
  <script src="<?php echo get_bloginfo('template_url');?>/backend-modules/link-ui/linkui.js"></script>
  <style>
  #postdivrich.disabled {
    position:absolute;
    z-index:9999;
    pointer-events: none;
    visibility: hidden;
  }
  </style>
  <?php
}

 ?>
