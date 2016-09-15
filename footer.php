<!--

<div class="clock-thing" data-diff="-4">
  <article class="clock">
    <div class="hours-container">
      <div class="hours"></div>
    </div>
    <div class="minutes-container">
      <div class="minutes"></div>
    </div>
    <div class="seconds-container">
      <div class="seconds"></div>
    </div>
  </article>
  NYC
</div>

<div class="clock-thing" data-diff="9">
  <article class="clock">
    <div class="hours-container">
      <div class="hours"></div>
    </div>
    <div class="minutes-container">
      <div class="minutes"></div>
    </div>
    <div class="seconds-container">
      <div class="seconds"></div>
    </div>
  </article>
  TOKYO
</div>

<div class="clock-thing" data-diff="-7">
  <article class="clock">
    <div class="hours-container">
      <div class="hours"></div>
    </div>
    <div class="minutes-container">
      <div class="minutes"></div>
    </div>
    <div class="seconds-container">
      <div class="seconds"></div>
    </div>
  </article>
  LA
</div>
-->

<footer id="footer" class="content-container clearfix">

  <?php
        $value = get_option( 'footer_copy', '' );
        if(!empty($value)) {
          ?>
          <div id="footer-contact">
            <h2>Quick Contact Info</h2>
            <?php echo wpautop(htmlspecialchars_decode($value));?>

          </div>
          <?php

        }
  ?>
<div id="offices">
<h2>Offices</h2>

<?php
/*
$contact_cats = get_categories(
  array(
    'taxonomy' => 'contactregions',
    'hide_empty' => true
  )
);
*/
$args = array(
    'post_type' 		=> 'contacts',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => -1
  );
  $files_in_cat_query = new WP_Query($args);
  $contact_cats = array();
  if ( $files_in_cat_query->have_posts() ) {
    $contacts = $files_in_cat_query->get_posts();
    foreach($contacts as $c) {
      $id = $c->ID;
      $locations = wp_get_post_terms($id, 'contactregions');
      array_push(
      $contact_cats,
      array(
        'id' => $locations[0]->term_id,
        'name' => $locations[0]->name
      )
      );
    }
    //var_dump($contact_cats);


  }


foreach($contact_cats as $c) {
  ?>
  <a href="<?php echo $homeURL;?>/contact/?id=<?php echo $c['id'];?>" data-id="<?php echo $c['name'];?>"><?php echo $c['name'];?></a>

  <?php
}



 ?>
</div>


</footer>

<?php global $siteDir; global $homeURL;?>

  <script id="inline-scripts">
  <?php $inlinejs = file_get_contents($siteDir.'/js/inline-load.js'); dirReplacer($inlinejs);?>

  </script>
  <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script  src="<?php echo $siteDir;?>/js/plugins.js?v=<?php echo time();?>"></script>
  <script  src="<?php echo $siteDir;?>/js/main.js?v=<?php echo time();?>"></script>


  </body>
</html>
