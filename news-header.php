<?php

function newsItemMaker($id) {
  global $siteDir;


  $format = get_post_format($id);

  ?>
  <div class="news-item cta-container">
    <?php
    if(has_post_thumbnail($id)) {
      $thumbid = get_post_thumbnail_id($id);
      $thumbURL =  wp_get_attachment_image_src($thumbid, 'medium');
      $imgURL = $thumbURL[0];
    } else {
      $imgURL = $siteDir.'/assets/imgs/backup.jpg';
    }
    $title = get_the_title($id);
    $postURL = get_permalink($id);
    $bugClass = '';
    $svg = '';
    $externalLink = '';
    if($format == 'link') {
      $externalLink = 'target="_blank"';
      $bugClass = 'svg';
      $ltype = get_cfc_field('link', 'link-type', $id);
      if($ltype == 'url') {
        $postURL = get_cfc_field('link', 'url',$id);
        $svg = '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#unlink"></use></svg>';
      }
      if($ltype == "upload") {
        $file = get_cfc_field('link', 'file-upload',$id);
        $postURL = $file['url'];
        $svg = '<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#file"></use></svg>';
      }
    }
    $category;
    $cs =  get_the_terms($id, 'category');
    if(!empty($cs) && $cs[0]->slug !== 'uncategorized') {
      $category = $cs[0]->name;
    }


      ?>

  <div class="cover-container">
    <img class="poster-cover" src="<?php echo $imgURL;?> "  alt="<?php echo $title;?>"/>
  </div>
  <?php
  if(!empty($category)) {
    ?>
    <div class="cat-bug"><?php echo $category;?></div>
    <?php
  }

   ?>

  <?php
    $location = get_the_terms($id, 'contactregions');
    if($location) {
      $location = $location[0]->name.', ';

    } else {
      $location = '';
    }

   ?>
   <div class="bottom">
     <h2><?php echo $title;?></h2>
     <div class="meta">
       <?php echo $location;?><?php echo get_the_date('F d, Y',$id);?>
     </div>
     <?php
     if(!empty($postURL)) {
       ?>
       <span class="more-bug <?php echo $bugClass;?>"><?php echo $svg;?></span>
       <?php
     }


      ?>


   </div>

   <?php
   if(!empty($postURL)) {
     ?>

     <a <?php echo $externalLink;?> href="<?php echo $postURL;?>" class="link-cover poster-cover"></a>
     <?php
   }

    ?>



  </div>


  <?php
}



 ?>


<?php
  $newsTitle = "News";
  if(is_date()) {
    $newsTitle = 'News from '.get_query_var('year');
  }
  if(is_category()) {
    $newsTitle = "News tagged: ".get_category(get_query_var('cat'))->name;
  }


  $newsCat = get_categories(
    array(
      'taxonomy' => 'category',
      'hide_empty' => true
    )
  );

 ?>
<div id="news-header" class="clearfix container-style">

  <h1><?php echo $newsTitle;?></h1>

  <div id="news-controls" class="clearfix">
    <div class="selector">
    <select id="year-selector">
      <option value="<?php echo $homeURL;?>/news/">Any Year</option>
<?php
wp_get_archives(
  array(
    'type' => 'yearly',
    'format' => 'option'
  )
);
 ?>

    </select>
    <div class="holder text-overflow">View By Year <svg class="down">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#left-arrow"></use>
    </svg></div>

  </div>
    <?php

    $cats = get_categories(
      array(
        'taxonomy' => 'category',
        'hide_empty' => true
      )
    );


     ?>
     <div class="selector">
     <select id="cat-selector">
       <option value="<?php echo $homeURL;?>/news/">Any type</option>
       <?php
       foreach($cats as $c) {
         if($c->slug !== 'uncategorized') {
            ?>
            <option value="<?php echo $homeURL;?>/category/<?php echo $c->slug;?>/"><?php echo $c->name;?></option>
            <?php
         }
       }

        ?>

     </select>
     <div class="holder text-overflow">View By Post Type <svg class="down">
       <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#left-arrow"></use>
     </svg></div>

   </div>

   <button class="news-control close">
     <svg>
       <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross-out"></use>
     </svg>
   </button>
  </div>


  <script>
  currentYearDate = null;
  <?php
  if(is_date()) {
    ?>
    currentYearDate = '<?php echo get_query_var('year');?>'
    <?php
  }
   ?>

  </script>
</div>
