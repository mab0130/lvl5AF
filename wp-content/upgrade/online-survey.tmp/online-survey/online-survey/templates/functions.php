<?php
function all_questions($param=array()){
	$args = array('post_type' => 'question', 'showposts' => -1, 'order_by' => 'menu_order');
	$args = $args + $param;
	// The Query
	$query = new WP_Query( $args );
	
	$questions = array();
	// The Loop
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<li>' . get_the_title() . '</li>';
		}
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();
}

add_action('wp_ajax_survey_form_submit', 'survey_form_submit');
add_action('wp_ajax_nopriv_survey_form_submit', 'survey_form_submit');
function survey_form_submit(){
	global $wpdb;
	$result = array();	
	
	parse_str($_POST['info'], $all_data);
	$msg = '';	
	foreach($all_data['data'] as $data){
			$msg .= "<strong>{$data['category']}</strong><br />";
			
			if(!empty($data['survey'])){
				$msg .= "<table cellpadding='5' border='1'><tr><th>Questions</th><th>Answer</th></tr>";
				foreach( $data['survey'] as $data )
					$msg .= "<tr><td>{$data['question']}</td><td>{$data['answer']}</td></tr>";
				
				$msg .= "</table><br /><br />";
			}else
			$msg .= "No Answer for this Category<br /><br />";
		}
	
	
	//$to = 	$all_data['info']['email'];
	$to = 	get_option('admin_email');
	$subject = "Online Survey";
	$body = "===========================================================<br />";
	$body .= "<strong>Name:</strong> {$all_data['info']['name']}<br />";
	$body .= "<strong>Position:</strong> {$all_data['info']['position']}<br />";
	$body .= "<strong>Email:</strong> {$all_data['info']['email']}<br />";
	$body .= "<strong>Restaurant Name:</strong> {$all_data['info']['restaurant_name']}<br />";
	$body .= "<strong>Website:</strong> {$all_data['info']['website']}<br />";	
	$body .= "===================Survey==================================\n";
	$body .= "{$msg}<br />";
	$body .= "===========================================================<br />";
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$all_data['info']['name'].' <'.$all_data['info']['email'].'>' . "\r\n";
	
	
	$table_name = $wpdb->prefix.'online_servey';
	$table_data = $all_data['info'];
	$table_data['message'] = $msg;
	
	
	$wpdb->insert( $table_name, $table_data );
	if(isset($wpdb->insert_id)){
				
		if(wp_mail( $to, $subject, $body, $headers ))
			$result = array('id' => 1, 'msg' => 'Thank You. Message is sent successfully.' );
		else	
			$result = array('id' => 1, 'msg' => 'Thank You. Data inserted but Message Sending Failed.' );
	}else
		$result = array('id' => 0, 'msg' => 'Data inserting error??' );	
	
	echo json_encode($result);
	exit;	
}

?>