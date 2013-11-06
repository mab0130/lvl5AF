<?php
function survey_custom_init() {
  $labels = array(
    'name' => 'Questions',
    'singular_name' => 'Question',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Question Category',
    'edit_item' => 'Edit Question Category',
    'new_item' => 'New Question Category',
    'all_items' => 'All Questions',
    'view_item' => 'View Question Category',
    'search_items' => 'Search Questions Category',
    'not_found' =>  'No questions found',
    'not_found_in_trash' => 'No questions found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Online Survey'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
	'menu_icon' => ONLILE_SURVEY_URL.'/images/icon.png',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'question' ),
    'capability_type' => 'page',
    'has_archive' => true, 
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array( 'title', 'page-attributes' )
  ); 

  register_post_type( 'question', $args );
}

//add filter to ensure the text Question, or question, is displayed when user updates a question 

function survey_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['question'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Question updated. <a href="%s">View question</a>', 'online_survey'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'online_survey'),
    3 => __('Custom field deleted.', 'online_survey'),
    4 => __('Question updated.', 'online_survey'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Question restored to revision from %s', 'online_survey'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Question published. <a href="%s">View question</a>', 'online_survey'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Question saved.', 'online_survey'),
    8 => sprintf( __('Question submitted. <a target="_blank" href="%s">Preview question</a>', 'online_survey'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Question scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview question</a>', 'online_survey'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Question draft updated. <a target="_blank" href="%s">Preview question</a>', 'online_survey'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Questions

function survey_add_help_text( $contextual_help, $screen_id, $screen ) { 
  //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'question' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a question:', 'online_survey') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.', 'online_survey') . '</li>' .
      '<li>' . __('Specify the correct writer of the question.  Remember that the Author module refers to you, the author of this question review.', 'online_survey') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the question review to be published in the future:', 'online_survey') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.', 'online_survey') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.', 'online_survey') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:', 'online_survey') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', 'online_survey') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'online_survey') . '</p>' ;
  } elseif ( 'edit-question' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of questions blah blah blah.', 'online_survey') . '</p>' ;
  }
  return $contextual_help;
}


/* Adds a box to the main column on the Post and Page edit screens */
function online_survey_add_custom_box() {
    $screens = array( 'question' );
    foreach ($screens as $screen) {
        add_meta_box(
            'online_survey_sectionid',
            __( 'Questions Settings', 'online_survey' ),
            'online_survey_inner_custom_box',
            $screen
        );
    }
}

/* Prints the box content */
function online_survey_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'online_survey_noncename' );

  // The actual fields for data entry
  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
  $value = get_post_meta( $post->ID, 'category_subtitle', true );
  echo '<p class="misc-pub-section"><label for="question">';
       _e("<strong>Category Subtitle:</strong> ", 'online_survey' );
  echo '</label> ';
  echo '<input type="text" style="width:100%" class="regular-text" name="category_subtitle" value="'.esc_attr($value).'" /></p>';
  $questions = get_post_meta( $post->ID, 'all_questions', true );
  if($questions == '') {$questions = array(); $count = 0;}
  else $count = count($questions)-1;
  ?>
    <ul id="questionList">
       <?php for( $i=0; $i <= $count; $i++): ?>
        <li>
            <p>
            	<strong>Question:</strong>
                <?php if(!empty($questions)) echo '<a class="delete">Delete</a>'; ?>
            	<input type="text" class="regular-text" name="data[<?php echo $i; ?>][question]" value="<?php echo $questions[$i]['question'] ?>" />
            </p>
            <p>
                <strong>Answer Type: </strong>
                <?php $style = (($questions[$i]['a_type'] == 'qty') || ($questions[$i]['a_type'] == 'scale'))? ' style="display:block;"' : ''; ?>
                <input type="radio" <?php echo ($questions[$i]['a_type'] == 'qty')? 'checked="checked"': '' ?>  name="data[<?php echo $i; ?>][a_type]" class="qty" value="qty" /> Quantity &nbsp;&nbsp;
                <input type="radio" <?php echo ($questions[$i]['a_type'] == 'scale')? 'checked="checked"': '' ?> name="data[<?php echo $i; ?>][a_type]" class="scale" value="scale" /> Scale &nbsp;&nbsp;
                <input type="radio" <?php echo ($questions[$i]['a_type'] == 'yes_no')? 'checked="checked"': '' ?> name="data[<?php echo $i; ?>][a_type]" class="yes_no" value="yes_no" /> Yes/No &nbsp;&nbsp;
                <input type="radio" <?php echo ($questions[$i]['a_type'] == 'text_box')? 'checked="checked"': '' ?> name="data[<?php echo $i; ?>][a_type]" class="text_box" value="text_box" /> Text box 
            </p>
            <p class="info_qty info"<?php echo $style; ?>>
            Min: <input class="min" type="text" name="data[<?php echo $i; ?>][min]" value="<?php echo ($questions[$i]['min'])? $questions[$i]['min'] : 1; ?>" /> 
            Max: <input class="max" type="text" name="data[<?php echo $i; ?>][max]" value="<?php echo ($questions[$i]['max'])? $questions[$i]['max'] : 10; ?>" />
            </p>
           
        </li>
        <?php endfor; ?>
    </ul>
    Add New Question: <button id="addQuestion">+</button>
    <script>
		jQuery(document).ready(function ($) {
			var i = <?php echo $count+1; ?>;
			$('#addQuestion').click(function(){
				 var html = '<li><p><strong>Question:</strong><a class="close">Close</a><input type="text" value="" name="data['+i+'][question]" class="regular-text"></p><p> <strong>Answer Type: </strong><input type="radio" value="qty" class="qty" name="data['+i+'][a_type]"> Quantity <input type="radio" value="scale" class="scale" name="data['+i+'][a_type]"> Scale<input type="radio" value="yes_no" class="yes_no" name="data['+i+'][a_type]"> Yes/No <input type="radio" value="text_box" class="text_box" name="data['+i+'][a_type]"> Text box </p><p class="info_qty info">Min: <input class="min new" type="text" value="1" name="data['+i+'][min]"> Max: <input type="text" class="max new" value="10" name="data['+i+'][max]"></p></li>';
				 $('#questionList').append(html);
				i++;
				return false;
			})
		});
	</script>
  <?php
}

/* When the post is saved, saves our custom data */
function online_survey_save_postdata( $post_id ) {

  // First we need to check if the current user is authorised to do this action. 
  if ( 'question' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return;
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // Secondly we need to check if the user intended to change this value.
  if ( ! isset( $_POST['online_survey_noncename'] ) || ! wp_verify_nonce( $_POST['online_survey_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  // Thirdly we can save the value to the database

  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $data = sanitize_text_field( $_POST['category_subtitle'] );
  add_post_meta($post_ID, 'category_subtitle', $data, true) or
  update_post_meta($post_ID, 'category_subtitle', $data);

  $data = $_POST['data'];
  $ques = array();
  $i = 0;
  foreach($data as $info){
		if($info['question'] != ''){
			$ques[$i]['question'] = $info['question'];
			$ques[$i]['a_type'] = $info['a_type'];
			$ques[$i]['min'] = $info['min'];
			$ques[$i]['max'] = $info['max'];
			$i++;
		}
	}
  // Do something with $mydata 
  // either using 
  add_post_meta($post_ID, 'all_questions', $ques, true) or
  update_post_meta($post_ID, 'all_questions', $ques);
  // or a custom table (see Further Reading section below)
}

?>