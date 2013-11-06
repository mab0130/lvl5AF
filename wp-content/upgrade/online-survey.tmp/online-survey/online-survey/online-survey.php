<?php
/*
Plugin Name: Online Survey Plugin
Plugin URI: http://coolwebsolutions.wordpress.com/
Description: Once prospect fills the form and submit, Client will get the form in email with the answers and will be a link in the admin panel to view the survey.
Version: 1.0
Author: Habibur Rahman Razib
Author URI: http://coolwebsolutions.wordpress.com/
*/

// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );


define( 'ONLILE_SURVEY_DIR', WP_PLUGIN_DIR . '/online-survey' );
define( 'ONLILE_SURVEY_URL', WP_PLUGIN_URL . '/online-survey' );


if (!class_exists("Online_Survey")) :

class Online_Survey {
	var $settings, $options_page;
	
	function __construct() {	

		if (is_admin()) {
			if (!class_exists("Online_Survey_Settings"))
				require(ONLILE_SURVEY_DIR . '/inc/survey-settings.php');
			$this->settings = new Online_Survey_Settings();	
			
			if (!class_exists("Online_Survey_Options"))
				require(ONLILE_SURVEY_DIR . '/inc/survey-options.php');
			$this->options_page = new Online_Survey_Options();	
		}
		
		add_action( 'wp_print_scripts', array($this,'os_inline_js') );
		add_action('init', array($this,'init') );
		add_action('admin_init', array($this,'admin_init') );
		add_action('admin_menu', array($this,'admin_menu') );
		
		/*----Post Type---*/
		add_action( 'init', 'survey_custom_init' );
		add_filter( 'post_updated_messages', 'survey_updated_messages' );
		add_action( 'add_meta_boxes', 'online_survey_add_custom_box' );
		add_action( 'save_post', 'online_survey_save_postdata' );
		
		register_activation_hook( __FILE__, array($this,'activate') );
		register_deactivation_hook( __FILE__, array($this,'deactivate') );
	}

	function network_propagate($pfunction, $networkwide) {
		global $wpdb;

		if (function_exists('is_multisite') && is_multisite()) {
			// check if it is a network activation - if so, run the activation function 
			// for each blog id
			if ($networkwide) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					call_user_func($pfunction, $networkwide);
				}
				switch_to_blog($old_blog);
				return;
			}	
		} 
		call_user_func($pfunction, $networkwide);
	}

	function activate($networkwide) {
		$this->network_propagate(array($this, '_activate'), $networkwide);
	  	 global $wpdb;
	
	   $table_name = $wpdb->prefix . "online_servey";
		  
	   $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
				  `ID` int(10) NOT NULL AUTO_INCREMENT,
				  `name` varchar(200) NOT NULL,
				  `position` varchar(200) NOT NULL,
				  `email` varchar(200) NOT NULL,				  
				  `website` varchar(200) NOT NULL,
				  `message` text NOT NULL,
				  `answers` longtext NOT NULL,
				  `reply` text NOT NULL,
				  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`ID`)
				);";
	
	   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	   dbDelta( $sql );
	}

	function deactivate($networkwide) {
		$this->network_propagate(array($this, '_deactivate'), $networkwide);
	}

	
	function _activate() {}
	
	function _deactivate() {}
	

	function init() {
		load_plugin_textdomain( 'online_survey', ONLILE_SURVEY_DIR . '/lang', 
							   basename( dirname( __FILE__ ) ) . '/lang' );
		if(!is_admin()){
			wp_enqueue_style( 'online-survey-css', ONLILE_SURVEY_URL . '/templates/css/style.css');
			wp_enqueue_style( 'online-survey-ui-css', ONLILE_SURVEY_URL . '/templates/css/jquery-ui-1.10.2.custom.css');	
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-slider');
			
			wp_enqueue_script('online-survey-js', ONLILE_SURVEY_URL . '/templates/js/js.js', array( 'jquery', 'jquery-ui-slider'));
		}					   
							   
	}
	function os_inline_js(){
		echo "<script type='text/javascript'>\n";
		echo "var ONLILE_SURVEY_URL = '".ONLILE_SURVEY_URL."'; \n";
		echo "var ONLILE_SURVEY_DIR = '".ONLILE_SURVEY_DIR."';\n";
		echo "var ajaxurl = '".admin_url('admin-ajax.php')."'; \n";
		echo "\n</script>";
	}
	function admin_init() {
			wp_enqueue_style( 'online-survey-css', ONLILE_SURVEY_URL . '/css/style.css');	
			
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-livequery', ONLILE_SURVEY_URL.'/js/jquery.livequery.js', array('jquery'), '1.0.0');
			wp_enqueue_script('online-survey-js', ONLILE_SURVEY_URL . '/js/js.js', array( 'jquery'));
			
			
	}

	function admin_menu() {
		 add_submenu_page('edit.php?post_type=question', __('Survey List', 'online_survey'), __('Survey List', 'online_survey'), 
			'manage_options', 'survey_list', array($this,'survey_list') );
			
		$option = new Online_Survey_Options();
		add_submenu_page( 'edit.php?post_type=question',	
			__('Settings', 'online_survey'), __('Settings', 'online_survey'), 
			'manage_options', 'online_survey', array($option,'survey_page') );	

	}

	function print_example($str, $print_info=TRUE) {
		if (!$print_info) return;
		__($str . "<br/><br/>\n", 'online_survey' );
	}

	function javascript_redirect($location) {
		// redirect after header here can't use wp_redirect($location);
		?>
		  <script type="text/javascript">
		  <!--
		  window.location= <?php echo "'" . $location . "'"; ?>;
		  //-->
		  </script>
		<?php
		exit;
	}
	
	function survey_list(){
		global $wpdb;
		echo '<div class="wrap">
		<div class="icon32 icon32-posts-question" id="icon-edit"><br></div><h2>Online Survey List </h2>';
		if( $_GET['action']== 'delete' ){
			$wpdb->query($wpdb->prepare( "DELETE FROM {$wpdb->prefix}online_servey  WHERE ID = %d",	$_GET['link_id'] ));
		}
		$wp_list_table = new Survey_List_Table();
		$wp_list_table->prepare_items();
		$wp_list_table->display();
		echo '</wrap>';
	}

} // end class
endif;
require_once( 'inc/post-type.php' );
require_once( 'templates/functions.php' );
require_once( 'templates/shortcode.php' );

global $online_survey;
if (class_exists("Online_Survey") && !$online_survey) {
    $online_survey = new Online_Survey();	
}	

?>