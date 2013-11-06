<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("Online_Survey_Options")) :

class Online_Survey_Options {
	var $page = '';
	var $message = 0;
	
	function __construct() {
		add_action( 'admin_menu', array( $this, 'init' ) );
	}

	function init() {
		if ( ! current_user_can('update_plugins') )
			return;

	
		// Add a new submenu
		/*$this->page = $page =  add_options_page(	
			__('Online Survey', 'online_survey'), __('Online Survey', 'online_survey'), 
			'administrator', 'online_survey', array($this,'survey_page') );*/
			

//		add_action("load-$page", array($this, 'on_load'));
//		add_action("admin_print_scripts-$page", array($this, 'js_includes'));
//		add_action("admin_print_styles-$page", array($this, 'css_includes'));
//		add_action("admin_head-$page", array($this, 'admin_head') );
	}
	
	function survey_page() {

		$messages[1] = __('Online Survey action taken.', 'online_survey');
		
		if ( isset($_GET['message']) && (int) $_GET['message'] ) {
			$message = $messages[$_GET['message']];
			$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
		}
		
		$title = __('Online Survey', 'online_survey');
		?>
		<div class="wrap">   
			<?php screen_icon(); ?>
			<h2><?php echo esc_html( $title ); ?></h2>
		
			<?php
				if ( !empty($message) ) : 
				?>
				<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
				<?php 
				endif; 
				
			?>		
			<form method="post" action="options.php">
				<?php 
					settings_fields('online_survey_options'); 
					do_settings_sections('survey_settings_page'); 
				?>		
				<p>
				<input type="submit" class="button button-primary" name="save_options" value="<?php esc_attr_e('Save Options'); ?>" />
				
				</p>
			</form>
            
		
		</div>
	<?php }

} // end Online_Survey_Options class
endif; 

?>