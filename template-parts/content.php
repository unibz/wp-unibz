<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unibz
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); /* @TODO add new custom class to change background color to white */ ?>>
	<div class="row">
		<?php
			if(has_post_thumbnail()) :
		?>
		<div class="col-md-6">
			<a class="post-thumbnail" href="" aria-hidden="true"><img src="<?php the_post_thumbnail_url(); ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" style="width:100%; height:100%"></a>
		</div>
		<div class="col-md-6">
		<?php
			else:
				echo "<div class='col-xs-12'>";
			endif;
		?>

			<header class="entry-header">
				<?php
					if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php unibz_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
					endif;

					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					}

				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php unibz_entry_footer(); ?>
			</footer><!-- .entry-footer -->
</article><!-- #post-## -->
