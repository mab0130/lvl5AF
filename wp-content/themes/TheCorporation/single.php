<?php get_header(); ?>
	<?php if (get_option('thecorporation_integration_single_top') <> '' && get_option('thecorporation_integrate_singletop_enable') == 'on') echo(get_option('thecorporation_integration_single_top')); ?>

	<div id="content-area" class="clearfix">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="post clearfix">

				<?php if (get_option('thecorporation_thumbnails') == 'on') { ?>

					<?php $width = (int) get_option('thecorporation_thumbnail_width_posts');
						  $height = (int) get_option('thecorporation_thumbnail_height_posts');
					      $classtext = 'thumbnail-post alignleft';
					      $titletext = get_the_title();

					      $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
					      $thumb = $thumbnail["thumb"]; ?>

					<?php if($thumb <> '') print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>

				<?php }; ?>

			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','TheCorporation').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','TheCorporation')); ?>

		</div> <!-- end .post -->

		<?php if (get_option('thecorporation_integration_single_bottom') <> '' && get_option('thecorporation_integrate_singlebottom_enable') == 'on') echo(get_option('thecorporation_integration_single_bottom')); ?>
        <?php if (get_option('thecorporation_468_enable') == 'on') { ?>
			<a href="<?php echo esc_url(get_option('thecorporation_468_url')); ?>"><img src="<?php echo esc_url(get_option('thecorporation_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
        <?php } ?>

		<?php if (get_option('thecorporation_show_postcomments') == 'on') comments_template('', true); ?>
	<?php endwhile; endif; ?>
	</div> <!-- end #content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>