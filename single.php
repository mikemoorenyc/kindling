<?php include 'header.php'; ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php /* How to display standard posts and search results */ ?>

	<div id="main-content-container" class=" content-container container-style">
		<?php
		if($post->post_type == 'post') {
			$location = get_the_terms( $post->ID,'contactregions');
	    if($location) {
	      $location = $location[0]->name.', ';

	    } else {
	      $location = '';
	    }
	    ?>
			<h1 class="single-post-title"><?php the_title();?>
				<span class="meta">
					<?php echo $location;?><?php echo get_the_date('F d, Y',$post->ID);?>
				</span>
			</h1>
			<?php

	  }

		 ?>
		<div class="main-text-block clearfix">
			<?php the_content(); ?>
			<?php

if($post->post_type == 'post') {
	$category;
	$cs =  get_the_terms($id, 'category');
	if(!empty($cs) && $cs[0]->slug !== 'uncategorized') {

		$category = $cs[0]->name;
		?>
		<p class="category">
			Filed under: <a href="<?php echo $homeURL;?>/category/<?php echo $cs[0]->slug;?>/"><?php echo $cs[0]->name;?></a>
		</p>
		<?php
	}
}
				 ?>
		</div>





<?php endwhile; // End the loop. Whew. ?>
</div>
<?php
if($post->post_type == 'members') {
	include 'member-footer.php';
}

 ?>


<?php include 'footer.php';?>
