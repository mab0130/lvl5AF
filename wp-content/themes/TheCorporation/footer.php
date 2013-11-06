		</div> <!-- end .container -->
	</div> <!-- end #content -->

	<div id="footer">
		<div class="container clearfix">

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
			<?php endif; ?>

		</div> <!-- end .container -->
	</div> <!-- end #footer -->

	<div id="copyright">
		<div class="container clearfix">
			
		</div> <!-- end #container -->
	</div> <!-- end #copyright -->

	<?php get_template_part('includes/scripts'); ?>

	<?php wp_footer(); ?>
</body>
</html>