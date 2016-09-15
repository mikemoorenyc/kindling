<?php

function add_map_button() {
  global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
  ?>
  <button id="add-a-map" class="button thickbox" type="button">Add a map</button>
  <?php
}

add_action('media_buttons', 'add_map_button');

//ADD SCRIPT
function add_map_script($hook) {
  global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
    if ( !('post.php' == $hook || 'post-new.php' == $hook) ) {
        return;
    }


    wp_enqueue_script( 'add_map_script', get_bloginfo('template_url').'/backend-modules/add-map-button/add-map-script.js' );

}
add_action( 'admin_enqueue_scripts', 'add_map_script' );

?>
<?php
//BOTTOM CONTENT

add_action('admin_footer', 'map_modal_content');
function map_modal_content() {
	global $post;
  if($post->post_type !== 'portfolio') {
    return;
  }
  ?>
  <div class="little-modal" id="add-map-modal" style="display:none;">
    <div class="inner">

      <div class="content">
        <?php
        $args = array(
            'post_type' 		=> 'maps',
            'orderby' 			=> 'menu_order',
            'order' 			=> 'ASC',
            'posts_per_page' => -1
          );
        $files_in_cat_query = new WP_Query($args);
        if ( $files_in_cat_query->have_posts() ) {
          ?>
          <label>Select a map</label>
          <select id="map-selector">
            <?php
            $maps = $files_in_cat_query->get_posts();
            foreach($maps as $map) {
              ?>
              <option value="<?php echo $map->ID;?>"><?php echo $map->post_title;?></option>
              <?php
            }

            ?>

          </select>
          <label>Map display title</label>
          <input type="input" id="map-display-name" />
          <?php

        } else {
          ?>
          <div class="error">
            There are no maps available.
          </div>
          <?php
        }

        ?>


      </div>
    <div class="footer" id="plugin-information-footer">
      <button class="cancel button ">Cancel</button>
      <button class="add-map button button-primary" disabled>Add Map</button>
    </div>

    </div>

  </div>
  <style>
  <?php include 'add-map-styles.css';?>
  </style>


  <?php
}
?>
