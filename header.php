<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package unibz
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'unibz' ); ?></a>

		<header id="masthead" class="site-header" role="banner">

			<nav class="navbar">
				<div class="container">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>                        
						</button>

						<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="site-branding">
								<svg id="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65 52" preserveAspectRatio="xMinYMid">
									<title>Free University of Bozen - Bolzano</title>
									<desc></desc>
									<path d="M38.9 0.2h25.7v3.6H38.9V0.2zM12.6 34.5H9v-1.3c-1 1-2.2 1.5-3.6 1.5 -1.4 0-2.6-0.4-3.5-1.3 -1-1-1.5-2.4-1.5-4.1V20h3.7v8.8c0 0.9 0.3 1.6 0.8 2.1 0.4 0.4 1 0.6 1.6 0.6 0.7 0 1.2-0.2 1.6-0.6 0.5-0.5 0.8-1.1 0.8-2.1V20h3.7V34.5M28.2 34.5h-3.7v-8.8c0-0.9-0.3-1.6-0.8-2.1 -0.4-0.4-1-0.6-1.6-0.6 -0.7 0-1.2 0.2-1.6 0.6 -0.5 0.5-0.8 1.2-0.8 2.1v8.8H16V20h3.6v1.3c1-1 2.2-1.5 3.7-1.5 1.4 0 2.6 0.4 3.5 1.3 1 1 1.5 2.4 1.5 4.1V34.5M31.7 14.6h3.7v2.9h-3.7V14.6zM31.7 20h3.7v14.5h-3.7V20zM51.2 27.2c0 1.5-0.1 2.6-0.2 3.3 -0.2 1.2-0.6 2.1-1.3 2.8 -0.9 0.9-2.1 1.3-3.6 1.3 -1.5 0-2.7-0.5-3.6-1.5v1.4h-3.5V14.7h3.7v6.6c0.9-1 2-1.4 3.5-1.4 1.5 0 2.7 0.4 3.5 1.3 0.7 0.6 1.1 1.6 1.3 2.8C51.1 24.7 51.2 25.8 51.2 27.2M47.5 27.2c0-1.3-0.1-2.2-0.3-2.8 -0.4-0.9-1.1-1.4-2.1-1.4 -1.1 0-1.8 0.5-2.1 1.4 -0.2 0.6-0.3 1.5-0.3 2.8 0 1.3 0.1 2.2 0.3 2.8 0.4 0.9 1.1 1.4 2.1 1.4 1.1 0 1.8-0.5 2.1-1.4C47.4 29.4 47.5 28.5 47.5 27.2M64.6 34.5H53.5v-2.7l6.5-8.5h-6.1V20h10.8v2.8L58 31.3h6.6V34.5M38.9 47.4h25.7V51H38.9V47.4z"></path>    
								</svg>
							</div><!-- .site-branding -->
						</a>
					</div><!-- .navbar-header -->


					<!-- @TODO FIX THIS -->
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>


					<?php 
						global $polylang;
						if(isset($polylang)):
					?>
					<ul class="nav navbar-nav navbar-right">
						<!-- this element will be moved to the navigation menu by javascript -->
						<li>
							<button class="btn btn-default" type="button" data-toggle="dropdown" id="bottone"><?php print_r(pll_current_language()); ?> <span class="caret"></span></button>
							<ul class="dropdown-menu">
								<?php
									/* language switcher */
									pll_the_languages(array(
										'display_names_as' => 'slug',
										'show_flags' => 0,
										'hide_current' => 1,
										'hide_if_empty' => 0,
										'hide_if_no_translation' => 0,
									));
								?>
							</ul>
						</li>
					</ul>
					<?php 
						endif;
					?>




				</div>
			</nav>

		</header><!-- #masthead -->

		<div id="content" class="site-content">

			<?php
				if ( has_post_thumbnail() ) :
			?>

			<div class="hero" style="background-image:url('<?php the_post_thumbnail_url(); ?>');">
				<div class="stretchy-wrapper">
					<div>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
						endif; ?>
					</div>
				</div>
			</div>
			<?php
				endif;
			?>

			<div class="container">
				<div class="row">