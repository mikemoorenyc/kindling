<?php
add_theme_support( 'menus' );

//$siteDir = '/wp-content/themes/w25th-build';
add_post_type_support('page', 'excerpt');

remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);  
// Custom functions
//CUSTOM paramenters
function add_custom_query_var( $vars ){
  $vars['1'] = "getfull";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var' );


remove_action('wp_head', 'wp_generator');// Removes the WordPress version as a layer of simple security

add_theme_support('post-thumbnails');
if (function_exists('add_theme_support')) {
    add_theme_support( 'post-formats', array( 'link' ) );
}
function ev_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
    //register_taxonomy('category', array());
}
add_action('init', 'ev_unregister_taxonomy');


add_action( 'admin_init', 'my_theme_add_editor_styles' );
function my_theme_add_editor_styles() {
    add_editor_style( 'css/editor-styles.css' );
}

// DIRECTORY REPLACER

function dirReplacer($string) {
  global $siteDir;
  $time = time();
  $newString = str_replace('***REPLACEWITHTHEMEDIRECTORY***', $siteDir, $string);
  $newString = str_replace('***TIMESTAMP***', $time ,$newString);
  echo $newString;
}
//CONTENT CLEANER
function content_cleaner($content) {

    // Remove inline styling
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

    // Remove font tag
    $content = preg_replace('/<font[^>]+>/', '', $content);

    // Remove empty tags
    $post_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
    $content = strtr($content, $post_cleaners);

    return $content;
}


// add_filter('the_content', 'content_cleaner',20);


//HOOK IN CUSTOM POST TYPES

/*
include 'backend-modules/custom-post-types/properties-post.php';

include 'backend-modules/custom-post-types/team.php';
include 'backend-modules/custom-post-types/contacts.php';
//LOCATION META BOX
include 'backend-modules/location-meta-box/main-include.php';

//REMOVE ADD MEDIA BUTTON
include 'backend-modules/remove-add-media-button/remove-add-media-button.php';

//ADD MAP BUTTON
include 'backend-modules/add-map-button/include.php';
//ADD VIDEO BUTTON
include 'backend-modules/add-video-button/include.php';

//MAP COMPONENT
include 'backend-modules/map-component/entry-point.php';

//RENAME NEWS
include 'backend-modules/rename-news.php';

//POST TYPE SWITCHER
include 'backend-modules/post-type-switcher/include.php';
//SUPER ADMIN
include 'backend-modules/super-admin.php';
*/
//ADD FOOTER COPY SETTING
function add_mike_modal() {
  include 'backend-modules/mike-modal/include.php';
}


include 'backend-modules/footer-contact/include.php';
include 'backend-modules/footer-clocks/include.php';
include 'backend-modules/contact_tax/include.php';
include 'backend-modules/contact-info/include.php';
include 'backend-modules/link-ui/main-include.php';
include 'backend-modules/add-block-quote/include.php';
include 'backend-modules/remove-add-media/include.php';
?>
