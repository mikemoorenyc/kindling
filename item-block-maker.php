<?php

function item_block_maker($format,$ltype, $category, $id,$metaString = false, $style="zoom") {
  global $siteDir;


  $format = get_post_format($id);

  ?>

  <div class="item-block <?php echo $style;?> cta-container" data-id="<?php echo $id;?>">
    <div class="inner">
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


   <div class="bottom">
     <h2><?php echo $title;?></h2>
     <?php
     if(!empty($metaString)) {
       ?>
       <div class="meta">
         <?php echo $metaString;?>
       </div>
       <?php
     }

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
  </div>


  <?php
}

 ?>
