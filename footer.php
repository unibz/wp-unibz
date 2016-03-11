<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package unibz_s
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div class="page-sized">
            
            <a class="small underline" href="https://www.unibz.it/en/legal/imprint/">Imprint</a>
            <a class="small underline" href="https://www.unibz.it/en/legal/privacy/">Privacy</a>
            <a class="small underline" href="<?php echo wp_login_url(); ?>">Log in</a>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
