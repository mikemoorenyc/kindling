<?php

if($_GET["getfull"] == 'yes') {
  $amount = -1;
}
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' 		=> 'members',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => $amount,
    'paged' => $paged
  );
query_posts($args);
$older = get_next_posts_link();
$newer = get_previous_posts_link();
if(!empty($older)) {
$makeMore = 'data-is-more="true"';
$moreUrl = 'data-postfetch="'.$homeURL.'/about/?getfull=yes"';
$skipData = 'data-skip="'.$amount.'"';
}
echo '<div id="member-blocks" '.$makeMore.' '.$moreUrl.' '.$skipData.' class="content-container item-block-container">';
while ( have_posts() ) : the_post();
$title = '';
$title =  get_cfc_field('member-title', 'title', $post->ID );
var_dump(get_the_ID());
item_block_maker('', '','',$post->ID,$title,'bw');
endwhile;



 ?>


</div>
