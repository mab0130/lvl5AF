<?php $fullWidthPage = is_page_template('page-full.php'); ?>
<div id="content-area" class="clearfix<?php if ( $fullWidthPage ) echo(' fullwidth_home');?>">

	<div class="entry<?php if (get_option('thecorporation_blog_style') == 'false') echo(' page'); ?>">
		<?php if (is_page()) { //if static homepage
				 if (have_posts()) : while (have_posts()) : the_post();
					get_template_part('includes/homepage_content');
				 endwhile; endif;
			  } else {
				 if (get_option('thecorporation_blog_style') == 'on') get_template_part( 'includes/blogstyle_home');
					else {
					  query_posts('page_id=' . get_pageId(html_entity_decode(get_option('thecorporation_home_page_1'))) ); while (have_posts()) : the_post();
						get_template_part('includes/homepage_content');
					  endwhile; wp_reset_query();
					};
			  }; ?>
	</div> <!-- end .entry -->

</div> <!-- end #content-area -->

<?php if ( !$fullWidthPage ) { ?>
	<?php if (get_option('thecorporation_blog_style') == 'false' && get_option('thecorporation_homepage_widgets') == 'false') get_template_part('includes/fromblog'); else get_sidebar(); ?>
<?php }; ?>