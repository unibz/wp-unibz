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

	<div id="pittogramma" style="background-image:url('<?php echo get_option( 'my_theme_settings' )['pictogram']; ?>');"></div>

	<footer id="colophon" class="site-footer unibrand" role="contentinfo">
		<div class="site-info container">
			<?php
				// extract the map URL out of the HTML code provided by Google Maps "embed map" feature
				$mapHTML = get_option( 'my_theme_settings' )['google_map'];
				preg_match('/src="[^"]+"/i', $mapHTML, $mapURL);

				if (!empty($mapURL)):
			?>
			<div class="row">
					<div class="col-md-5">
						<strong><?php echo get_option( 'my_theme_settings' )['google_map_title'];?></strong>
						<address><?php echo get_option( 'my_theme_settings' )['google_map_address'];?></address>
					</div>
					<div class="col-md-7">
						<iframe id="footer-map" <?php echo $mapURL[0]; ?>></iframe>
					</div>
			</div>
			<?php
				endif;
			?>
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