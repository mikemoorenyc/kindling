<?php
function map_type_init() {

//PROPERTY
$propargs = array(
  'label' => 'Maps',
  'public' => false,
  'labels' => array(
    'add_new_item' => 'Add New Map',
    'name' => 'Maps',
    'edit_item' => 'Edit Maps',
    'search_items' => 'Search Maps',
    'not_found' => 'No maps found.',
    'all_items' => 'All Maps'
  ),
  'show_ui' => true,
  'capability_type' => 'page',
  'hierarchical' => false,
  'has_archive' => false,
  'rewrite' => array('slug' => 'maps'),
  'query_var' => true,
  'menu_icon' => 'dashicons-location-alt',
  'supports' => array(
      'title',
      'revisions',
    )
  );
register_post_type( 'maps', $propargs );



}

add_action( 'init', 'map_type_init' );
?>
