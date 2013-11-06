<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("Online_Survey_Settings")) :

class Online_Survey_Settings {
	
	// Settings API tutorials
	// http://codex.wordpress.org/Settings_API
	// http://ottopress.com/2009/wordpress-settings-api-tutorial/
	
	function __construct() {	
		add_action('admin_init', array($this,'admin_init'), 20 );
	}
	
	function admin_init() {
		register_setting( 'online_survey_options', 'os_options', array($this, 'sanitize_theme_options') );
		add_settings_section('survey_main', 'Online Survey Settings', 
			array($this, 'main_section_text'), 'survey_settings_page');

		add_settings_field('top_title', 'Top Title', 
			array($this, 'render_top_title'), 'survey_settings_page', 'survey_main');
		add_settings_field('top_desc', 'Top Description', 
			array($this, 'render_top_desc'), 'survey_settings_page', 'survey_main');	
		
		add_settings_field('step_title', 'Step Title', 
			array($this, 'render_step_title'), 'survey_settings_page', 'survey_main');	
			
		add_settings_field('msg_title', 'Message Box Title', 
			array($this, 'render_msg_title'), 'survey_settings_page', 'survey_main');
		add_settings_field('msg_desc', 'Message Box Description', 
			array($this, 'render_msg_desc'), 'survey_settings_page', 'survey_main');	
			
		add_settings_field('footer_info', 'Footer Info', 
			array($this, 'render_footer_info'), 'survey_settings_page', 'survey_main');	

		/*add_settings_field('survey_checkbox1', 'Example Checkboxes', 
			array($this, 'render_survey_checkbox'), 'survey_settings_page', 'survey_main', 
			array('id' => 'survey_checkbox1', 'value' => 'apples', 'text' => 'Apples') );
		add_settings_field('survey_checkbox2', '', 
			array($this, 'render_survey_checkbox'), 'survey_settings_page', 'survey_main',
			array('id' => 'survey_checkbox2', 'value' => 'oranges', 'text' => 'Oranges') );*/
	}

	function main_section_text() {
		//echo '<p>Some example inputs.</p>';
	}
	
	function render_top_title() { 
		$options = get_option('os_options');
		echo '<input id="top_title" style="width:50%;"  type="text" name="os_options[top_title]" value="'.$options['top_title'].'" />	';
	}
	
	function render_top_desc() { 
		$options = get_option('os_options');
        echo '<textarea id="top_desc" rows="5" name="os_options[top_desc]"  style="width:100%;" >'.$options['top_desc'].'</textarea>';	
	}
	
	function render_step_title() { 
		$options = get_option('os_options');
		echo 'Step 1: <input id="step_1" style="width:45%;"  type="text" name="os_options[step_1]" value="'.$options['step_1'].'" /><br />';
		echo 'Step 2: <input id="step_2" style="width:45%;"  type="text" name="os_options[step_2]" value="'.$options['step_2'].'" /><br />';
		echo 'Step 3: <input id="step_3" style="width:45%;"  type="text" name="os_options[step_3]" value="'.$options['step_3'].'" /><br />';
		echo 'Step 4: <input id="step_4" style="width:45%;"  type="text" name="os_options[step_4]" value="'.$options['step_4'].'" /><br />';
	}
	
	function render_msg_title() { 
		$options = get_option('os_options');
		echo '<input id="msg_title" style="width:50%;"  type="text" name="os_options[msg_title]" value="'.$options['msg_title'].'" />	';
	}
	
	function render_msg_desc() { 
		$options = get_option('os_options');
        echo '<textarea id="msg_desc" rows="5" name="os_options[msg_desc]"  style="width:100%;" >'.$options['msg_desc'].'</textarea>';	
	}
	
	function render_footer_info() { 
		$options = get_option('os_options');
		echo 'Column 1 Title:<br /> <input id="col_1_title" style="width:50%;"  type="text" name="os_options[col_1_title]" value="'.$options['col_1_title'].'" /><br />';
		echo 'Description:<br /> <textarea rows="5" id="col_1_desc" style="width:100%;" name="os_options[col_1_desc]">'.$options['col_1_desc'].'</textarea><br /><br />';
		
		echo 'Column 2 Title:<br /> <input id="col_2_title" style="width:50%;"  type="text" name="os_options[col_2_title]" value="'.$options['col_2_title'].'" /><br />';
		echo 'Column 2 Description:<br /> <textarea rows="5" id="col_2_desc" style="width:100%;" name="os_options[col_2_desc]">'.$options['col_2_desc'].'</textarea><br /><br />';
		
		echo 'Column 3 Title: <br /><input id="col_3_title" style="width:50%;"  type="text" name="os_options[col_3_title]" value="'.$options['col_3_title'].'" /><br />';
		echo 'Column 3 Description: <br /><textarea rows="5" id="col_3_desc" style="width:100%;" name="os_options[col_3_desc]">'.$options['col_3_desc'].'</textarea><br />';
		
	}
	
	
	function render_survey_checkbox($args) {
		$options = get_option('os_options');
		$id = 'os_options['.$args['id'].']';
		?>
  		<input name="<?php echo $id;?>" type="checkbox" value="<?php echo $args['value'];?>" <?php echo isset($options[$args['id']]) ? 'checked' : '';?> /> <?php echo " {$args['text']}"; ?> <br/>
		<?php 
	}
	
	function sanitize_theme_options($options) {
		$options['survey_text'] = stripcslashes($options['survey_text']);

		return $options;
	}


} // end class
endif;

include('survey-list-table.php');
?>
