<?php global $shortname; ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/superfish.js"></script>

	<script type="text/javascript">
	//<![CDATA[

		jQuery.noConflict();

		jQuery('.thumb_popup').css('bottom','106px')

		jQuery('ul.superfish').superfish({
			delay:       300,                            // one second delay on mouseout
			animation:   {'marginLeft':'0px',opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  true,                           // disable generation of arrow mark-up
			onBeforeShow: function(){ this.css('marginLeft','20px'); },
			dropShadows: false                            // disable drop shadows
		});

		jQuery('ul.nav > li > a.sf-with-ul').parent('li').addClass('sf-ul');

		<?php if (get_option($shortname.'_disable_toptier') == 'on') echo('jQuery("ul.nav > li > ul").prev("a").attr("href","#");'); ?>

		/* search form */

		var $searchform = jQuery('#header div#search-form');
		var $searchinput = $searchform.find("input#searchinput");
		var $searchvalue = $searchinput.val();

		$searchform.css("right","25px");

		jQuery("#header a#search-icon").click(function(){
			if ($searchform.filter(':hidden').length == 1)
				$searchform.animate({"right": "-1", "opacity": "toggle"}, "slow")
			else
				$searchform.animate({"right": "25", "opacity": "toggle"}, "slow");
			return false;
		});

		$searchinput.focus(function(){
			if (jQuery(this).val() == $searchvalue) jQuery(this).val("");
		}).blur(function(){
			if (jQuery(this).val() == "") jQuery(this).val($searchvalue);
		});


		/* footer widgets improvements */

		var $footer_widget = jQuery("#footer .widget");

		if (!($footer_widget.length == 0)) {
			$footer_widget.each(function (index, domEle) {
				// domEle == this
				if ((index+1)%3 == 0) jQuery(domEle).addClass("last").after("<div class='clear'></div>");
			});
		};


		<?php if (is_front_page() && get_option($shortname.'_featured')=='on') { ?>
			jQuery(window).load( function(){
				/* featured slider */

				var $featured_area = jQuery('#featured-slider'),
					$feature_thumb = jQuery('#featured-thumbs img'),
					$active_arrow = jQuery('div#active_item');
					ordernum = 1,
					$slider_control = jQuery('#featured-thumbs'), //div#featured-thumbs
					$slider_control_tab = jQuery('.et_thumb_small');

				if ( $featured_area.length ) {
					et_featured_options = {
						timeout: 0,
						speed: 300,
						cleartypeNoBg: true,
						prev:   '#featured-area a#prevlink',
						next:   '#featured-area a#nextlink',
						before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
							var $et_active_slide = jQuery(nextSlideElement),
								et_active_order = $et_active_slide.prevAll().length,
								$this_element = $slider_control.find('.et_thumb_small').eq(et_active_order);

							$active_arrow.animate({"left": $this_element.position().left+55}, "slow");
						},
						fx: '<?php echo esc_js(get_option($shortname.'_slider_effect')); ?>'
					}

					<?php if (get_option($shortname.'_pause_hover') == 'on') { ?>
						et_featured_options.pause = 1;
					<?php } ?>

					<?php if (get_option($shortname.'_slider_auto') == 'on') { ?>
						et_featured_options.timeout = <?php echo esc_js(get_option($shortname.'_slider_autospeed')); ?>;
					<?php } ?>

					$featured_area.css( 'backgroundImage', 'none' ).cycle(et_featured_options);

					if ( $featured_area.find('.featitem').length == 1 ){
						$featured_area.find('.featitem').css({'position':'absolute','top':'0','left':'0'}).show();
						jQuery('#featured-area a#prevlink, #featured-area a#nextlink').hide();
					}

					$slider_control.find('.container').css( 'visibility', 'visible' );
				}

				$feature_thumb.hover(function(){
					// $next_div = jQuery(this).next('.thumb_popup');

					$next_div.css('bottom','96px')
					$next_div.css({'left':jQuery(this).position().left-10});

					jQuery(this).parent().addClass('hover').find('img').fadeTo('fast',0.5);
					$next_div.css('display','block').stop(true,true).animate({"bottom": "82px", "opacity": "0"}, "fast");
				},function(){
					jQuery(this).parent().removeClass('hover').find('img').fadeTo('fast',1);
					$next_div.stop(true,true).animate({"bottom": "96px", "opacity": "0"}, "fast",function(){
						jQuery(this).css('display','none');
					});
				});

				$slider_control_tab.click(function() {
					var et_ordernumber = jQuery(this).prevAll('.et_thumb_small').length;
					$featured_area.cycle(et_ordernumber);
					return false;
				});
			} );
		<?php } ?>
	//]]>
	</script>