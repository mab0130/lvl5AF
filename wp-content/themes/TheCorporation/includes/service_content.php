<?php $icon = get_post_meta(get_the_ID(), 'Icon', $single = true); ?>

<?php if ( '' != $icon ) { ?>
	<img src="<?php echo esc_attr( $icon ); ?>" alt="" class="icon" />
<?php } ?>

<h4 class="title"><?php the_title(); ?></h4>
<?php global $more;
	  $more = 0;
	  the_excerpt(""); ?>

<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('Read more','TheCorporation'); ?></span></a>