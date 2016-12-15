<!--
	comments.php
-->
<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package unibz
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'unibz' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'unibz' ); ?></h2>
			<ul class="nav-links pager">

				<li class="nav-previous previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'unibz' ) ); ?></li>
				<li class="nav-next next"><?php next_comments_link( esc_html__( 'Newer Comments', 'unibz' ) ); ?></li>

			</ul><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
				$commentsHTML = wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'echo' => false
				));

				// add bootstrap classes
				$commentsHTML = preg_replace( '/comment-reply-link/', 'comment-reply-link btn btn-button unibrand', $commentsHTML);
				$commentsHTML = preg_replace( '/comment-edit-link/', 'comment-edit-link btn btn-button btn-sm btn-default', $commentsHTML);

				echo $commentsHTML;
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'unibz' ); ?></h2>
			<ul class="nav-links pager">

				<li class="nav-previous previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'unibz' ) ); ?></li>
				<li class="nav-next next"><?php next_comments_link( esc_html__( 'Newer Comments', 'unibz' ) ); ?></li>

			</ul><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php 
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'unibz' ); ?></p>
	<?php
	endif;

	comment_form(
		array(
			'class_submit' => 'btn btn-button unibrand',
			'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" class="form-control"></textarea></p>',
		)
	);
	?>
</div><!-- #comments -->