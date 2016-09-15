<?php
/**
 * Template Name: About Template Page
 */
?>


<?php include 'header.php'; ?>
  <div id="main-content-container" class="clearfix content-container ">

    <?php foreach( get_cfc_meta( 'about-blocks', $post->ID ) as $key => $value ){ ?>
      <?php
      $type = get_cfc_field( 'about-blocks','media-type', $post->ID, $key );
      $size = get_cfc_field( 'about-blocks','media-size', $post->ID, $key );
      $side = get_cfc_field( 'about-blocks','media-side', $post->ID, $key );

       ?>

       <div class="about-block container-style <?php echo $type;?> <?php echo $size;?> <?php echo $side;?> clearfix">
         <hr class="structural" />
         <?php
         if($type == 'image') {
           $image = get_cfc_field( 'about-blocks','image', $post->ID, $key );
           $url = $image['sizes']['large'];

           ?>
           <div class="img-placeholder" style="background-image:url('<?php echo $url;?>')">

           </div>
           <?php
         }

          ?>
          <?php
          if($type === 'quote' && $side == 'left') {
            ?>
            <div class="quote">
              <?php echo get_cfc_field( 'about-blocks','quote', $post->ID, $key );?>

            </div>
            <?php
          }
           ?>
         <div class="copy-block">
           <h1><?php echo get_cfc_field( 'about-blocks','title', $post->ID, $key );?></h1>
           <div class="copy">
             <?php echo wpautop(get_cfc_field( 'about-blocks','copy', $post->ID, $key ));?>

           </div>

         </div>
         <?php
         if($type === 'quote' && $side == 'right') {
           ?>
           <div class="quote">
             <?php echo get_cfc_field( 'about-blocks','quote', $post->ID, $key );?>

           </div>
           <?php
         }
          ?>
       </div>
    <?php }  ?>

  </div>
<?php
$amount =2;
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
}
echo '<div id="member-blocks" '.$makeMore.' '.$moreUrl.' class="content-container item-block-container">';
while ( have_posts() ) : the_post();
$title = '';
$title =  get_cfc_field('member-title', 'title', $post->ID );
item_block_maker('', '','',$post->ID,$title,'bw');
endwhile;
?>
</div>


<?php include 'footer.php';?>
