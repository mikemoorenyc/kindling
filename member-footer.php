
<div class="main-header-style content-container container-style">
  <h1>View Other Members</h1>

</div>
<?php
$currentGuy = $post->ID;
$args = array(
    'post_type' 		=> 'members',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => -1
  );
$files_in_cat_query = new WP_Query($args);
if ( $files_in_cat_query->have_posts() ) {
  $bottomMen = 0;
  $men = $files_in_cat_query->get_posts();
  if(count($men)>3) {
    $makeMore = 'true';
    $moreUrl = $homeURL.'/about/?getfull=yes';
  }
  ?>
  <div id="member-blocks" data-postfetch="<?php echo $moreUrl;?>" data-is-more="<?php echo $makeMore;?>" class="content-container item-block-container">
  <?php
  foreach($men as $m) {

    if($bottomMen < 2 && $m->ID !== $currentGuy) {
      $title = '';
      $title =  get_cfc_field('member-title', 'title', $m->ID );
      item_block_maker('', '','',$m->ID,$title,'bw');
      $bottomMen++;
    }

  }
  ?>
</div>
  <?php
}


?>
