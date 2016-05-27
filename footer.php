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
            
            <a class="small underline" href="http://www.unibz.it/en/organisation/organisation/privacy/default.html">Privacy</a>
            <a class="small underline" href="<?php echo wp_login_url(); ?>">Log in</a>
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
