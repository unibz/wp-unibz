<!--
	footer.php
-->
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
			<div class="row">
					<div class="col-md-5">
						<strong><?php echo get_option( 'my_theme_settings' )['google_map_title'];?></strong>
						<address><?php echo get_option( 'my_theme_settings' )['google_map_address'];?></address>
					</div>
					<div class="col-md-7">
						<iframe src="<?php echo get_option( 'my_theme_settings' )['google_map'];?>" id="footer-map"></iframe>
					</div>
			</div>
			<div class="row" style="margin-top:50px;">
				<div class="col-xs-12">
					&copy; 2016 Free University of Bozen-Bolzano 
				</div>
			</div>
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