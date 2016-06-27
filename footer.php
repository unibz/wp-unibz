<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package unibz
 */

?>
			</div>
		</div>
	</div><!-- .site-content -->

	<div id="pittogramma" style="background-image:url('<?php echo get_template_directory_uri() . '/img/pittogramma.jpg'; ?>');"></div>

	<footer id="colophon" class="site-footer unibrand" role="contentinfo">
		<div class="site-info container">
					<!--<a href="https://wordpress.org/">Proudly powered by WordPress</a>
					<span class="sep"> | </span>
					Theme: unibz by <a href="http://underscores.me/" rel="designer">Underscores.me</a>.-->
					<a href="#">Contacts</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<script>
		/**
		 *	Hide the widget area if there are no widgets by expanding the primary div
		 *
		 */
		 var widgetArea = document.getElementsByClassName('widget-area');
		 if (widgetArea.length == 0) {
		 	$('#primary').removeClass('col-md-9');
		 }
		</script>
		<?php wp_footer(); ?>
	</body>
</html>