<div id="sidebar" class="home">
	<div id="fromblog" class="widget clearfix">
		<a href="<?php echo esc_url(get_category_feed_link(get_catid(get_option('thecorporation_blog_cat')), ''));?>">
			<img src="<?php echo get_template_directory_uri(); ?>/images/rss.png" alt="" id="rss-icon" />
		</a>
		<h3 class="widgettitle"><?php esc_html_e('News & Events','TheCorporation'); ?></h3>

		<?php query_posts("posts_per_page=".get_option('thecorporation_fromblog_recent')."&cat=".get_catid(get_option('thecorporation_blog_cat')));
			if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/fromblog_post'); ?>
			<?php endwhile; endif;
		wp_reset_query(); ?>
	</div> <!-- end .widget -->

</div> <!-- end #sidebar -->