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

			<?php
				$my_theme_settings = get_option( 'my_theme_settings' );
			?>

			<div id="pittogramma" style="background-image:url('<?php echo $my_theme_settings['pictogram']; ?>');"></div>

			<footer id="colophon" class="site-footer unibrand" role="contentinfo">
				<div class="site-info container">
					<?php
						// extract the map URL out of the HTML code provided by Google Maps "embed map" feature
						$mapHTML = $my_theme_settings['google_map'];
						preg_match('/src="[^"]+"/i', $mapHTML, $mapURL);

						if (!empty($mapURL)):
					?>
					<div class="row">
							<div class="col-md-5">
								<strong><?php echo $my_theme_settings['google_map_title'];?></strong>
								<address class="u-margin-btm-none"><?php echo $my_theme_settings['google_map_address'];?></address>
								<address class="email"><?php echo unibz_getObfuscatedEmailLink($my_theme_settings['google_map_email']);?></address>
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
							<a href="<?php bloginfo('template_directory');?>/privacy.pdf">Privacy and Cookie Policy</a>
							<a href="<?php bloginfo('template_directory');?>/legal.html">Legal</a>
							<a href="https://github.com/unibz/wp-unibz/tree/unibz2">About</a>
						</div>
					</div>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
		</div><!-- .site -->
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
