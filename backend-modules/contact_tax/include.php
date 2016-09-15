<?php
function contacts_init() {

//PROPERTY
$args = array(
  'label' => 'Contacts',
  'public' => false,
  'labels' => array(
    'add_new_item' => 'Add New Contact',
    'name' => 'Contacts',
    'edit_item' => 'Edit Contact',
    'search_items' => 'Search Contacts',
    'not_found' => 'No Contacts found.',
    'all_items' => 'All Contacts'
  ),
  'show_ui' => true,
  'capability_type' => 'page',
  'hierarchical' => true,
  'has_archive' => false,
  'rewrite' => array('slug' => 'contacts'),
  'query_var' => true,
  'menu_icon' =>'dashicons-id',
  'supports' => array(
      'title',
      'revisions',
      'thumbnail',
    )
  );
register_post_type( 'contacts', $args );



}

add_action( 'init', 'contacts_init' );


//CUSTOM TAX
$contactregion_labels = array(
    'name' => _x( 'Location', 'taxonomy general name' ),
    'singular_name' => _x( 'Location', 'taxonomy singular name' ),

    'search_items' =>  __( 'Search Locations' ),
    'all_items' => __( 'All Locations' ),
    'parent_item' => __( 'Parent Location' ),
    'parent_item_colon' => __( 'Parent Location:' ),
    'edit_item' => __( 'Edit Location' ),
    'update_item' => __( 'Update Location' ),
    'add_new_item' => __( 'Add New Location' ),
    'new_item_name' => __( 'New Location Name' ),
    'menu_name' => __( 'Locations' ),
  );

  register_taxonomy('contactregions',array('contacts', 'post'), array(
    'hierarchical' => true,
    'labels' => $contactregion_labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'contactregions' ),
  ));

?>
