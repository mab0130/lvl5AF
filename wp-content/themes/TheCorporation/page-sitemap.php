<?php
/*
Template Name: Sitemap Page
*/
?>
<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
	<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
	?>

	<?php get_header(); ?>

		<div id="content-area" class="clearfix<?php if($fullwidth) echo(' fullwidth');?>">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="post clearfix">
				<?php $width = (int) get_option('thecorporation_thumbnail_width_pages');
					  $height = (int) get_option('thecorporation_thumbnail_height_pages');
					  $classtext = 'thumbnail-post alignleft';
					  $titletext = get_the_title();

					  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					  $thumb = $thumbnail["thumb"]; ?>

				<?php if($thumb <> '' && get_option('thecorporation_page_thumbnails') == 'on') { ?>
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
				<?php }; ?>
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

				<div id="sitemap">
					<div class="sitemap-col">
						<h2><?php esc_html_e('Pages','TheCorporation'); ?></h2>
						<ul id="sitemap-pages"><?php wp_list_pages('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->

					<div class="sitemap-col">
						<h2><?php esc_html_e('Categories','TheCorporation'); ?></h2>
						<ul id="sitemap-categories"><?php wp_list_categories('title_li='); ?></ul>
					</div> <!-- end .sitemap-col -->

					<div class="sitemap-col">
						<h2><?php esc_html_e('Tags','TheCorporation'); ?></h2>
						<ul id="sitemap-tags">
							<?php $tags = get_tags();
							if ($tags) {
								foreach ($tags as $tag) {
									echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a></li> ';
								}
							} ?>
						</ul>
					</div> <!-- end .sitemap-col -->

					<div class="sitemap-col<?php echo ' last'; ?>">
						<h2><?php esc_html_e('Authors','TheCorporation'); ?></h2>
						<ul id="sitemap-authors" ><?php wp_list_authors('show_fullname=1&optioncount=1&exclude_admin=0'); ?></ul>
					</div> <!-- end .sitemap-col -->
				</div> <!-- end #sitemap -->

				<div class="clear"></div>

				<?php edit_post_link(esc_html__('Edit this page','TheCorporation')); ?>
				<div class="clear"></div>
			</div> <!-- end .post -->
		<?php endwhile; endif; ?>
		</div> <!-- end #content-area -->

	<?php if (!$fullwidth) get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>