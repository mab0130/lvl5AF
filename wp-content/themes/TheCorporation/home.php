<?php get_header(); ?>

<?php if (get_option('thecorporation_services') == 'on') { ?>
	<div id="services" class="clearfix">

		<div class="one-third">
			<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('thecorporation_service_1')))); while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/service_content'); ?>
			<?php endwhile; wp_reset_query(); ?>
		</div> <!-- end .one-third -->

		<div class="one-third">
			<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('thecorporation_service_2')))); while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/service_content'); ?>
			<?php endwhile; wp_reset_query(); ?>
		</div> <!-- end .one-third -->

		<div class="one-third">
			<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('thecorporation_service_3')))); while (have_posts()) : the_post(); ?>
				<?php get_template_part('includes/service_content'); ?>
			<?php endwhile; wp_reset_query(); ?>
		</div> <!-- end .one-third -->

	</div> <!-- end #services -->
<?php }; ?>

<?php get_template_part('includes/default'); ?> 

<?php get_footer(); ?>