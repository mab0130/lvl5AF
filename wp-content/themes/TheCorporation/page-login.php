<?php
/*
Template Name: Login Page
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

				<div id="et-login">
					<div class='et-protected'>
						<div class='et-protected-form'>
							<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

							<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
								<p><label><span><?php esc_html_e('Username','TheCorporation'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
								<p><label><span><?php esc_html_e('Password','TheCorporation'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
								<input type='submit' name='submit' value='Login' class='etlogin-button' />
							</form>
						</div> <!-- .et-protected-form -->
					</div> <!-- .et-protected -->
				</div> <!-- end #et-login -->

				<div class="clear"></div>

				<?php edit_post_link(esc_html__('Edit this page','TheCorporation')); ?>
				<div class="clear"></div>
			</div> <!-- end .post -->
		<?php endwhile; endif; ?>
		</div> <!-- end #content-area -->

	<?php if (!$fullwidth) get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>