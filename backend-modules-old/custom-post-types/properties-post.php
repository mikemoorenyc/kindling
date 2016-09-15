<?php
function post_types_init() {

//PROPERTY
$propargs = array(
  'label' => 'Portfolio',
  'public' => true,
  'labels' => array(
    'add_new_item' => 'Add New Property',
    'name' => 'Portfolio',
    'edit_item' => 'Edit Property',
    'search_items' => 'Search Portfolio',
    'not_found' => 'No properties found.',
    'all_items' => 'All Properties'
  ),
  'show_ui' => true,
  'capability_type' => 'page',
  'hierarchical' => true,
  'has_archive' => false,
  'rewrite' => array('slug' => 'portfolio'),
  'query_var' => true,
  'menu_icon' => 'dashicons-building',
  'supports' => array(
      'title',
      'revisions',
      'thumbnail',
      'editor'
    )
  );
register_post_type( 'portfolio', $propargs );



}

add_action( 'init', 'post_types_init' );


//CUSTOM TAX
$region_labels = array(
    'name' => _x( 'Regions', 'taxonomy general name' ),
    'singular_name' => _x( 'Region', 'taxonomy singular name' ),

    'search_items' =>  __( 'Search Regions' ),
    'all_items' => __( 'All Region' ),
    'parent_item' => __( 'Parent Region' ),
    'parent_item_colon' => __( 'Parent Region:' ),
    'edit_item' => __( 'Edit Region' ),
    'update_item' => __( 'Update Region' ),
    'add_new_item' => __( 'Add New Region' ),
    'new_item_name' => __( 'New Region Name' ),
    'menu_name' => __( 'Regions' ),
  );

  register_taxonomy('regions',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $region_labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'region' ),
  ));

?>
