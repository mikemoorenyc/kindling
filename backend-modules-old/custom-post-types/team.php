<?php
function team_init() {

//TEAM
$team = array(
  'label' => 'Team',
  'public' => true,
  'labels' => array(
    'add_new_item' => 'Add New Team Member',
    'name' => 'Team',
    'edit_item' => 'Edit Team Member',
    'search_items' => 'Search Team',
    'not_found' => 'No team members found.',
    'all_items' => 'All Team Members'
  ),
  'show_ui' => true,
  'capability_type' => 'page',
  'hierarchical' => true,
  'has_archive' => false,
  'rewrite' => array('slug' => 'portfolio'),
  'query_var' => true,
  'menu_icon' => 'dashicons-groups',
  'supports' => array(
      'title',
      'revisions',
      'thumbnail',
      'editor'
    )
  );
register_post_type( 'team', $team );



}

add_action( 'init', 'team_init' );
?>
