<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php $thumb = '';

		$width = (int) get_option('thecorporation_thumbnail_width_usual');
		$height = (int) get_option('thecorporation_thumbnail_height_usual');
		$classtext = 'thumbnail-post alignleft';
		$titletext = get_the_title();

		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
		$thumb = $thumbnail["thumb"];
	?>

	<div class="entry clearfix">

		<h2 class="title"><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'TheCorporation'), $titletext) ?>"><?php the_title(); ?></a></h2>

		<?php if (get_option('thecorporation_postinfo1') ) { ?>
			<p class="post-meta"><span class="inner"><?php esc_html_e('Posted','TheCorporation'); ?> <?php if (in_array('author', get_option('thecorporation_postinfo1'))) { ?> <?php esc_html_e('by','TheCorporation'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('date', get_option('thecorporation_postinfo1'))) { ?> <?php esc_html_e('on','TheCorporation'); ?> <?php the_time(get_option('thecorporation_date_format')) ?><?php }; ?><?php if (in_array('categories', get_option('thecorporation_postinfo1'))) { ?> <?php esc_html_e('in','TheCorporation'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('comments', get_option('thecorporation_postinfo1'))) { ?> | <?php comments_popup_link(esc_html__('0 comments','TheCorporation'), esc_html__('1 comment','TheCorporation'), '% '.esc_html__('comments','TheCorporation')); ?><?php }; ?></span></p>
		<?php }; ?>

		<?php if($thumb <> '' && get_option('thecorporation_thumbnails_index') == 'on') { ?>
			<a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__ ('Permanent Link to %s', 'TheCorporation'), $titletext) ?>">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
			</a>
		<?php }; ?>

		<?php if (get_option('thecorporation_blog_style') == 'on') the_content(""); else { ?>
			<p><?php truncate_post(400); ?></p>
		<?php }; ?>
		<a class="readmore" href="<?php the_permalink(); ?>"><span><?php esc_html_e('Read More','TheCorporation'); ?></span></a>

	</div> <!-- end .entry -->
<?php endwhile; ?>
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
	else { ?>
		<?php get_template_part('includes/navigation'); ?>
	<?php } ?>

<?php else : ?>
	<?php get_template_part('includes/no-results'); ?>
<?php endif; ?>