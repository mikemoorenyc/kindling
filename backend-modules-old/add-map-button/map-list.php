<?php
require_once("../../../../../wp-load.php");

?>

<?php
$args = array(
    'post_type' 		=> 'maps',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => -1
  );
$files_in_cat_query = new WP_Query($args);
if ( $files_in_cat_query->have_posts() ) {
  $maps = $files_in_cat_query->get_posts();
  $mapArray = array();
  foreach($maps as $map) {
    $item = array(
      'id' => $map->ID,
      'title' => $map->post_title
    );
    array_push($mapArray,$item);
  }
  echo json_encode($mapArray);
}


?>
