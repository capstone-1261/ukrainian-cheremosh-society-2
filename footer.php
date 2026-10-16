<?php
/**
 * Site footer: footer menu, copyright, and closes the page.
 */
?>

<footer class="site-footer">
	<?php if ( has_nav_menu( 'footer' ) ) : ?>
		<nav class="site-footer__nav" aria-label="Footer menu">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	<?php endif; ?>

	<p class="site-footer__copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>

<?php wp_footer(); ?>
</body>
</html>