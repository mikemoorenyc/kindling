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
    'name' => _x( 'City', 'taxonomy general name' ),
    'singular_name' => _x( 'City', 'taxonomy singular name' ),

    'search_items' =>  __( 'Search Cities' ),
    'all_items' => __( 'All Cities' ),
    'parent_item' => __( 'Parent City' ),
    'parent_item_colon' => __( 'Parent City:' ),
    'edit_item' => __( 'Edit City' ),
    'update_item' => __( 'Update City' ),
    'add_new_item' => __( 'Add New City' ),
    'new_item_name' => __( 'New City Name' ),
    'menu_name' => __( 'Cities' ),
  );

  register_taxonomy('contactregions',array('contacts'), array(
    'hierarchical' => true,
    'labels' => $contactregion_labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'contactregions' ),
  ));

?>
