<?php

//GET POST SLUG
global $post;
$slug = $post->post_name;

//GET POST PARENT
$parentID = $post->post_parent;
$parentslug = get_post($parentID)->post_name;

//GET THEME DIRECTORY
global $siteDir;
$siteDir = get_bloginfo('template_url');

//GET HOME URL
global $homeURL;
$homeURL = esc_url( home_url( ) );

//DECLARE THE SITE TITLE, SAVE A DB QUERY
global $siteTitle;
$siteTitle = get_bloginfo('name');

//DECLARE THE PAGE EXCERPT
global $siteDesc;
$siteDesc = get_bloginfo('description');


include 'item-block-maker.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

<!-- ABOVE THE FOLD CSS -->


<link href="<?php echo $siteDir;?>/css/main.css?v=<?php echo time();?>" rel="stylesheet" />


<?php
if ( is_front_page() ) {
  $pageTitle = $siteTitle;
  ?>
  <title><?php echo $siteTitle;?></title>
  <?php
} else {
  $pageTitle = get_the_title();
  if(is_date()) {
    $pageTitle = 'News from '.get_query_var('year');
  }
  if(is_category()) {
    $pageTitle = 'News marked: '.get_category(get_query_var('cat'))->name;
  }
  ?>

  <title><?php echo $pageTitle;?> | <?php echo $siteTitle;?></title>
  <?php
}
?>

<!-- HERE'S WHERE WE GET THE SITE DESCRIPTION -->
<?php
if ( have_posts() && is_single() OR is_page()):while(have_posts()):the_post();
  if (get_the_excerpt()) {
    $out_excerpt = str_replace(array("\r\n", "\r", "\n", "[&hellip;]"), "", get_the_excerpt());
    //echo apply_filters('the_excerpt_rss', $out_excerpt);
    $siteDesc = $out_excerpt;
  } else {
    $siteDesc =  get_bloginfo('description');
  }
  if($siteDesc == '') {
    $siteDesc =  get_bloginfo('description');
  }
endwhile;
else: ?>

<?php endif; ?>
<meta name="description" content="<?php echo $siteDesc;?>" />

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">



<?php wp_site_icon();?>




<!-- FACEBOOK TAGS REMOVED ON COMPILATION UNLESS YOU UNCOMMENT-->
<!--
<meta property="og:site_name" content="<?php echo $siteTitle;?>" />
<meta property="og:title" content="<?php echo get_bloginfo('description');?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $homeURL;?>" />
<meta property="og:image" content="<?php echo $siteDir;?>/assets/blue-pin.jpg" />
<meta property="og:description" content="<?php echo $siteDesc;?>" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $pageTitle;?> | <?php echo $siteTitle;?>">
<meta name="twitter:description" content="<?php echo $siteDesc;?>">
<meta name="twitter:image" content="<?php echo $siteDir;?>/assets/imgs/social-poster.jpg">
-->
<link rel="canonical" href="<?php echo get_permalink($post);?>" />
</head>

<body id="top">

<div id="css-checker"></div>
<?php
$bgURL = '';
$tid = $post->ID;
if(is_archive()) {
  $tid = get_page_by_title("News")->ID;
}
if(has_post_thumbnail($tid)) {
      $thumbid = get_post_thumbnail_id($tid);
      $thumbURL =  wp_get_attachment_image_src($thumbid, 'full');
      $thumbURL = $thumbURL[0];
    //  $bgURL = 'style="background-image:url('.$thumbURL.');"';

      $smURL = wp_get_attachment_image_src($thumbid, 'thumbnail');
      $smURL = $smURL[0];
} else {
  $thumbURL= $siteDir.'/assets/imgs/backup-full.jpg';
}

 ?>
<div id="poster-container" <?php echo $bgURL;?> style="background-image:url('<?php echo $thumbURL;?>')">
  <img data-src="<?php echo $smURL;?>" />




</div>


<header class="content-container">
  <div class="top-poster">
    <?php
      $sub = get_cfc_field('subtitle', 'subtitle', $post->ID );
      $title = get_the_title();
      if ( get_post_type( get_the_ID() ) == 'post' || is_archive()) {
        $nid = get_page_by_title( "News");
        $sub = get_cfc_field('subtitle', 'subtitle', $nid->ID );
        $title = get_the_title($nid->ID);
      }
      if(get_post_type( get_the_ID() ) == 'members') {
        $sub = get_cfc_field('member-title', 'title', get_the_ID() );
      }
      if(!empty($sub)) {
        $sClass ="has-sub";
      }


     ?>
    <div class="content <?php echo $sClass;?>">

       <h1 class="<?php echo $sClass;?>"><?php echo $title;?></h1>
       <?php
       if(!empty($sub)) {
         ?>
         <h2><?php echo $sub;?></h2>
         <?php
       }
       ?>
    </div>
  </div>

  <nav class="clearfix">
    <a href="<?php echo $homeURL;?>" id="logo">
      <img src="<?php echo $siteDir;?>/assets/imgs/logo-white.png" alt="<?php echo $siteTitle;?>" />
    </a>

    <?php wp_nav_menu( array('menu' => 'Main Navigation', 'container'=>false, 'menu_class' => 'no-style clearfix') );?>
  </nav>
</header>
