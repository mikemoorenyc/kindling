<?php
/**
 * Template Name: News Template Page
 */
?>


<?php include 'header.php'; ?>
  <div id="main-content-container" class="clearfix content-container ">
    <?php include 'news-header.php';?>
    <div id="news-items" class="container-style clearfix">
      <?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' 		=> 'post',
    'posts_per_page' => 24,
    'paged' => $paged
  );
query_posts($args);
while ( have_posts() ) : the_post();
?>
<?php newsItemMaker(get_the_ID());?>
<?php endwhile;?>

    </div>

    <?php
    $older = get_next_posts_link();
    $newer = get_previous_posts_link();

    if(!empty($older) || !empty($newer)) {
      ?>
      <div class="pagination-container container-style clearfix">
        <?php
        if(!empty($newer)) {
          ?>
          <a href="<?php echo $homeURL.'/'.$slug.'/page/'.($paged-1).'/';?>" class="pager left-side">View Newer Posts</a>
          <?php
        }

         ?>

         <?php
         if(!empty($older)) {
           ?>
           <a href="<?php echo $homeURL.'/'.$slug.'/page/'.($paged+1).'/';?>" class="pager right-side">View Older Posts</a>
           <?php
         }

          ?>

      </div>

      <?php
    }


     ?>


  </div>



<?php include 'footer.php';?>
