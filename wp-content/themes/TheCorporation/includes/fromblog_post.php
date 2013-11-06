<h4><a href="<?php the_permalink() ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'TheCorporation'), get_the_title()) ?>"><?php the_title(); ?></a></h4>

<p class="meta-info">
	<?php if (get_option('thecorporation_postinfo_fromblog') ) { ?>
		<?php esc_html_e('Posted ','TheCorporation'); ?>
		<?php if (in_array('author', get_option('thecorporation_postinfo_fromblog'))) { esc_html_e(' by ','TheCorporation'); the_author_posts_link(); };
			  if (in_array('date', get_option('thecorporation_postinfo_fromblog'))) { esc_html_e(' on ','TheCorporation'); the_time(get_option('thecorporation_date_format')); }; ?>
	<?php }; ?>
</p>