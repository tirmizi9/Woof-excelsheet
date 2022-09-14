<?php
/**
 * The template for displaying the default page
 * 
 */

?>

<?php get_header() ; ?>


 <div class="content-full-width site-content">
	<div class="starterblog-container">
    <!-- Example row of columns -->
		<div class="starterblog-grid">
			<main class="content-area starterblog-col-12">
				  <div class="content-inner">
				  <?php while ( have_posts() ) : the_post(); ?>
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>
					<?php endwhile; // end of the loop. ?>
				  </div>
			 </main>
		 </div>
	</div>
</div>	  

<?php get_footer() ; ?>