<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Avocado
 */

?>
    </div>
	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php dynamic_sidebar('footer-one') ?>
				</div>
				<div class="col-lg-3">
					<?php dynamic_sidebar('footer-two') ?>
				</div>
				<div class="col-lg-3">
					<?php dynamic_sidebar('footer-three') ?>
				</div>
				<div class="col-lg-3">
					<?php dynamic_sidebar('footer-four') ?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
	<div class="copyright-text"><p>&copy;Copyrights 2018</p></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
