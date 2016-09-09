<!--
	content.php
-->
<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unibz
 */

?>

<article class="row post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header col-xs-12">
		<div class="entry-meta">
			<?php unibz_posted_on(); ?>
		</div><!-- .entry-meta -->
		
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
	</header><!-- .entry-header -->

	<?php
		if(has_post_thumbnail() && !is_single()) :
	?>
	<div class="col-sm-4">
		<a class="post-thumbnail" href="<?php echo esc_url(get_permalink()) ?>" aria-hidden="true"><img src="<?php the_post_thumbnail_url(); ?>" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" style="width:100%; height:100%"></a>
	</div>

	<div class="entry-content col-sm-8">
	<?php
		else:
	?>
	<div class="entry-content col-xs-12">
	<?php
		endif;
	?>
		<?php 
			if ( is_single() ) {
				the_content();
			}
			else {
				the_excerpt();
			}
		?>
		<footer class="entry-footer">
			<?php unibz_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .entry-content -->

</article><!-- #post-## -->