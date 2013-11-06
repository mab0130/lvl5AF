<?php
	$arr = array();
	$i=1;

	$width = 330;
	$height = 220;

	$width_small = 72;
	$height_small = 72;

	$featured_cat = get_option('thecorporation_feat_cat');
	$featured_num = (int) get_option('thecorporation_featured_num');

	if (get_option('thecorporation_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;

		if (get_option('thecorporation_feat_pages') <> '') $featured_num = count(get_option('thecorporation_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'thecorporation_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'thecorporation_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(50,false);
		$arr[$i]["title_small"] = truncate_title(25,false);

		$arr[$i]["fulltitle"] = truncate_title(250,false);

		$arr[$i]["excerpt"] = truncate_post(470,false);
		$arr[$i]["excerpt_small"] = truncate_post(80,false);

		$arr[$i]["tagline"] = get_post_meta(get_the_ID(), 'Tagline', $single = true);
		$arr[$i]["permalink"] = get_permalink();

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'thumb',$arr[$i]["fulltitle"],$arr[$i]["tagline"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["thumbnail_small"] = get_thumbnail($width_small,$height_small,'',$arr[$i]["fulltitle"],$arr[$i]["tagline"]);
		$arr[$i]["thumb_small"] = $arr[$i]["thumbnail_small"]["thumb"];

		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>


<div id="featured-area">
	<div class="container clearfix">
		<div id="featured-slider">

			<?php for ($i = 1; $i <= $featured_num; $i++) { ?>

				<div class="featitem clearfix">
					<h2 class="feat-heading"><?php echo esc_html($arr[$i]["title"]); ?></h2>
					<p class="tagline"><?php echo($arr[$i]["tagline"]); ?></p>
					<div class="excerpt">
						<p><?php echo($arr[$i]["excerpt"]); ?></p>
						<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'TheCorporation'), $arr[$i]["fulltitle"]) ?>" class="readmore"><span><?php esc_html_e('read more','TheCorporation'); ?></span></a>
					</div> <!-- end .excerpt -->

					<a href="<?php echo esc_url($arr[$i]["permalink"]); ?>" title="<?php printf(esc_attr__('Permanent Link to %s', 'TheCorporation'), $arr[$i]["fulltitle"]) ?>">
					<?php
						print_thumbnail( array(
							'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
							'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
							'alttext'		=> $arr[$i]["fulltitle"],
							'width'			=> (int) $width,
							'height'		=> (int) $height,
							'class'			=> 'thumb',
							'et_post_id'	=> $arr[$i]['post_id'],
						) );
					?>
					</a>
				</div> <!-- end .featitem -->

			<?php }; ?>

		</div> <!-- div #featured-slider -->

		<a id="prevlink" href="#"><?php esc_html_e('Previous','TheCorporation'); ?></a>
		<a id="nextlink" href="#"><?php esc_html_e('Next','TheCorporation'); ?></a>
	</div> <!-- end .container -->
</div> <!-- end #featured-area -->


<div id="featured-thumbs">
	<div class="container clearfix">

		<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
			<div class="et_thumb_small">
			<?php
				print_thumbnail( array(
					'thumbnail' 	=> $arr[$i]["thumb_small"],
					'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
					'alttext'		=> $arr[$i]["fulltitle"],
					'width'			=> (int) $width_small,
					'height'		=> (int) $height_small,
					'et_post_id'	=> $arr[$i]['post_id'],
				) );
			?>

				<div class="thumb_popup">
					<p class="heading"><?php echo($arr[$i]["title_small"]); ?></p>
					<p>"<?php echo($arr[$i]["excerpt_small"]); ?></p>
				</div> <!-- end .thumb_popup -->
			</div> <!-- .et_thumb_small -->
		<?php }; ?>

		<div id="active_item"></div>

	</div> <!-- end .container -->
</div> <!-- end #featured-thumbs -->