<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package unibz_s
 */

get_header(); ?>

	<div id="primary" class="content-area page-sized">
		<main id="main" class="site-main" role="main">
            <h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'unibz_s' ); ?></h1>
            <p><?php esc_html_e( 'It looks like nothing was found at this location.', 'unibz_s' ); ?></p>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
