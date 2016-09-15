<?php
add_action('admin_footer-post.php', 'remove_media_script');
add_action('admin_footer-post-new.php', 'remove_media_script');


function remove_media_script() {
  ?>
<script>

jQuery(document).ready(function($){
  $("#insert-media-button").hide();
});
</script>

  <?php
}


 ?>
