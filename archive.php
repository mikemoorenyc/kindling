<?php include 'header.php'; ?>
  <div id="main-content-container" class="clearfix content-container ">
    <?php include 'news-header.php';?>
    <div id="news-items" class="container-style clearfix">
      <?php
while ( have_posts() ) : the_post();
?>
<?php newsItemMaker(get_the_ID());?>
<?php endwhile;?>

    </div>




  </div>



<?php include 'footer.php';?>
