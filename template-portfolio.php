<?php
/**
 * Template Name: Portfolio Page
 */
?>
<?php include 'header.php'; ?>
<div id="main-content-container" class="clearfix content-container ">


    <?php foreach( get_cfc_meta( 'about-blocks', $post->ID ) as $key => $value ){ ?>
      <?php
      $type = get_cfc_field( 'about-blocks','media-type', $post->ID, $key );
      $size = get_cfc_field( 'about-blocks','media-size', $post->ID, $key );
      $side = get_cfc_field( 'about-blocks','media-side', $post->ID, $key );
      $color = get_cfc_field( 'about-blocks','quote-background-color', $post->ID, $key );
       ?>

       <div class="about-block container-style <?php echo $type;?> <?php echo $size;?> <?php echo $side;?> clearfix">
         <hr class="structural <?php echo strtolower($color);?>" />
         <?php
         if($type == 'image') {
           $image = get_cfc_field( 'about-blocks','image', $post->ID, $key );
           $url = $image['sizes']['large'];

           ?>
           <div class="img-placeholder" style="background-image:url('<?php echo $url;?>')">

           </div>
           <?php
         }

          ?>
          <?php
          if($type === 'quote' && $side == 'left') {
            ?>
            <div class="quote">
              <?php echo get_cfc_field( 'about-blocks','quote', $post->ID, $key );?>

            </div>
            <?php
          }
           ?>
         <div class="copy-block">
           <?php
           $title = $title = get_cfc_field( 'about-blocks','title', $post->ID, $key );
           if(!strtolower($title) == 'no title') {
             ?>
             <h1><?php echo $title;?></h1>
             <?php
           }
            ?>

           <div class="copy">
             <?php echo wpautop(get_cfc_field( 'about-blocks','copy', $post->ID, $key ));?>

           </div>

         </div>
         <?php
         if($type === 'quote' && $side == 'right') {
           ?>
           <div class="quote">
             <?php echo get_cfc_field( 'about-blocks','quote', $post->ID, $key );?>

           </div>
           <?php
         }
          ?>
       </div>
    <?php }  ?>





</div>



<?php include 'footer.php';?>
