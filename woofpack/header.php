<?php
/**
 * The template for displaying the header
 * 
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet" />

	<?php wp_head() ;?>
  </head>
 <body <?php body_class(); ?>>
 
 <header>
	<div class="page-width">
		<div class="topnav">	 
			<div class="logo">
				<img src="<?php echo get_template_directory_uri() ?>/images/logo.png" title="Woofpack" alt="Woofpack">
			</div>
			<?php 
				$page_object = get_queried_object();
				$postID     = get_queried_object_id();
				$title = get_the_title($postID);
				
			?>		
				 
			 <div class="hamberger" style="display:none">
				<span></span>
			  </div>
			<nav id="navbar" class="hamberger-navbar" style="display:none">
				<ul>
					<li><a class="active">Home</a></li>
				  <li><a class="navigation">About Us</a></li>
					<li><a class="navigation">Products</a></li>
					<li><a class="navigation">Header Style</a></li>
					<li><a class="navigation">Blogs</a></li>
					<li><a class="navigation">Contact Us</a></li>
				</ul>
			</nav> 
			  
			  <h1>WoofPack: <?php echo $title ;?></h1>
		</div><!--topnav-->
		<?php

		/* $defaults = array(
			'theme_location'  => 'primary',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		);

		wp_nav_menu( $defaults ); */

		?>
	</div>
  </header>
  
  
  
  