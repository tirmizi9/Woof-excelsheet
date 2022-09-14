<?php get_header() ; ?>
   <?php     if ( is_user_logged_in() ) { ?>   
 <div class="content-full-width site-content">
	<div class="starterblog-container">
    <!-- Example row of columns -->
		<div class="starterblog-grid">
			<main class="content-area starterblog-col-12">
				  <div class="content-inner">
				 <?php

					 if ( have_posts() ) :

					while ( have_posts() ) : the_post(); ?>

					<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>

					 <?php the_content() ?>

					 <?php endwhile;

					 else :

					echo '<p>There are no posts!</p>';

					 endif;

					 ?>
				  </div>
			 </main>
		 </div>
	</div>
</div>
   <?php }else{ ?> 
	<div class="s002">
		 <form>
			<fieldset>
			  <legend>WoofPack</legend>
			</fieldset>
		</form>
	</div>
  <?php  } ?> 
 <?php get_footer() ; ?>