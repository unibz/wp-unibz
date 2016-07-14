<!--
	header.php
-->
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
	<link rel='shortcut icon' href='<?php echo get_template_directory_uri() . '/img/favicon.ico'; ?>' type='image/x-icon'/ >
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'unibz' ); ?></a>

		<header id="masthead" class="site-header" role="banner">

			<nav class="navbar">
				<div class="container">
					<div class="row">

					<div class="site-branding col-xs-1">
						<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<svg id="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65 52" preserveAspectRatio="xMinYMid">
								<title>Free University of Bozen - Bolzano</title>
								<desc></desc>
								<path d="M38.9 0.2h25.7v3.6H38.9V0.2zM12.6 34.5H9v-1.3c-1 1-2.2 1.5-3.6 1.5 -1.4 0-2.6-0.4-3.5-1.3 -1-1-1.5-2.4-1.5-4.1V20h3.7v8.8c0 0.9 0.3 1.6 0.8 2.1 0.4 0.4 1 0.6 1.6 0.6 0.7 0 1.2-0.2 1.6-0.6 0.5-0.5 0.8-1.1 0.8-2.1V20h3.7V34.5M28.2 34.5h-3.7v-8.8c0-0.9-0.3-1.6-0.8-2.1 -0.4-0.4-1-0.6-1.6-0.6 -0.7 0-1.2 0.2-1.6 0.6 -0.5 0.5-0.8 1.2-0.8 2.1v8.8H16V20h3.6v1.3c1-1 2.2-1.5 3.7-1.5 1.4 0 2.6 0.4 3.5 1.3 1 1 1.5 2.4 1.5 4.1V34.5M31.7 14.6h3.7v2.9h-3.7V14.6zM31.7 20h3.7v14.5h-3.7V20zM51.2 27.2c0 1.5-0.1 2.6-0.2 3.3 -0.2 1.2-0.6 2.1-1.3 2.8 -0.9 0.9-2.1 1.3-3.6 1.3 -1.5 0-2.7-0.5-3.6-1.5v1.4h-3.5V14.7h3.7v6.6c0.9-1 2-1.4 3.5-1.4 1.5 0 2.7 0.4 3.5 1.3 0.7 0.6 1.1 1.6 1.3 2.8C51.1 24.7 51.2 25.8 51.2 27.2M47.5 27.2c0-1.3-0.1-2.2-0.3-2.8 -0.4-0.9-1.1-1.4-2.1-1.4 -1.1 0-1.8 0.5-2.1 1.4 -0.2 0.6-0.3 1.5-0.3 2.8 0 1.3 0.1 2.2 0.3 2.8 0.4 0.9 1.1 1.4 2.1 1.4 1.1 0 1.8-0.5 2.1-1.4C47.4 29.4 47.5 28.5 47.5 27.2M64.6 34.5H53.5v-2.7l6.5-8.5h-6.1V20h10.8v2.8L58 31.3h6.6V34.5M38.9 47.4h25.7V51H38.9V47.4z"></path>    
							</svg>
						</a>
					</div><!-- .site-branding -->






					<div class="navbar-header col-xs-10 col-sm-2 col-sm-push-9">
						<div class="">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary-menu">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>                        
							</button>
						</div>

						<?php global $polylang; if(isset($polylang)): ?>
							<div class="">
								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="language-switch-button"><?php print_r(pll_current_language()); ?> <span class="caret"></span></button>
								<ul class="dropdown-menu unibrand">
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
							</div>
						<?php endif; ?>
					</div><!--  -->




					<!-- navigation menu -->
					<div class="col-xs-12 col-sm-9 col-sm-pull-2 padding-collapse-sm">
						<?php
							wp_nav_menu(
								array(
									'container_id' => 'primary-menu',
									'container_class' => 'collapse navbar-collapse unibrand',
									'menu_class' => 'nav navbar-nav',
									'menu_id' => '',
									'walker' => new MyWalker(),
								)
							);
						?>
					</div>
					<!-- navigation menu -->



					</div><!-- .row -->
				</div><!-- .container -->
			</nav>

		</header><!-- #masthead -->

		<div id="content" class="site-content">

			<?php
				// display the hero if and only if it has to be shown
				if (
					// if the page is single page or single post, and has a featured image, and the hero is set to be shown
					((is_single() || is_page()) && has_post_thumbnail() && get_post_meta( get_the_ID(), 'hero-meta-box-display' )[0])
					|| // or
					// if the page is a blog/archive/search page and the blog has a header image
				    (!is_single() && !is_page() && has_header_image())
				) :

				// get the right values for hero-title and hero-description
				if (is_single() || is_page()) {
					$HeroTitle = get_post_meta( get_the_ID(), 'hero-meta-box-title' )[0];
					$HeroSubtitle = get_post_meta( get_the_ID(), 'hero-meta-box-subtitle' )[0];
				}
				else {
					$HeroTitle = get_bloginfo( 'name', 'display');
					$HeroSubtitle = get_bloginfo( 'description', 'display' );
				}
			?>

			<div class="hero" style="background-image:url('<?php 
				if(has_post_thumbnail() && (is_single() || is_page())) {
					the_post_thumbnail_url();
				}
				else {
					echo get_header_image();
				}
				?>');">
				<div class="stretchy-wrapper">
					<div class="stretchy-wrapper-inner">
						<h1 class="site-title"><?php echo $HeroTitle; ?></h1>
						<?php if ( $HeroSubtitle || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $HeroSubtitle; /* WPCS: xss ok. */ ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
				endif;
				// the code above is executed only if and only if the hero has to be shown
			?>

			<div class="container">
				<div class="row">