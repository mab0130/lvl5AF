<?php
add_shortcode( 'ONLINE_SURVEY' , 'online_survey_template' );
function online_survey_template(){ 
		global $post;
		$options = get_option('os_options');
		$out = '<div class="survey-content">';
		
	   if(($options['step_1'] != '') || ($options['step_2'] != '') || ($options['step_3'] != '') || ($options['step_4'] != ''))
	   $out .= '<ul class="circle">
			<li><a href="#">'.$options['step_1'].'</a></li>
			<li><a href="#">'.$options['step_1'].'</a></li>
			<li><a href="#">'.$options['step_1'].'</a></li>
			<li><a href="#">'.$options['step_1'].'</a></li>
		</ul>';
		$out .= '<div class="aboutCOn topCon">';		
			$out .= '<h2>'.$options['top_title'].'</h2>';
			$out .= '<p>'.nl2br($options['top_desc']).'</p>';
        $out .= '</div><!-- End of .aboutCOn -->';
                
         $out .= '<form action="#" class="form surveyForm" method="post">';
                
						    $args = array('post_type' => 'question', 'showposts' => -1, 'orderby' => 'menu_order', 'order' => 'DESC');
                            $query = new WP_Query( $args );
                            $questions = array();
                            // The Loop
                            if ( $query->have_posts() ) :
                                $count = 0; 
								$out .= '<ul id="accordion">';
								while ( $query->have_posts() ) : $query->the_post();
									$questions = get_post_meta( $post->ID, 'all_questions', true );								
									$out .= '<li>
												<input type="hidden" name="data['.$count.'][category]" value="'. get_the_title() .'" />                          						<div class="accordion-top">
												   <h3>'. get_the_title() .'</h3>
												   <small>'. get_post_meta( $post->ID, 'category_subtitle', true ) .'</small>
												   <a href="#">&nbsp;</a>
												 </div><!-- end of .accordion-top -->';   
												                          
											if(!empty($questions)){
											$out .= '<ul class="accordion-btm">';							 
											$j = 0; 
											foreach( $questions as $question){
												   $out .= '<li>';                                   
													$out .= '<input type="hidden" name="data['.$count.'][survey]['.$j.'][question]" value="'.$question['question'].'" />';
													$out .= '<div class="accordion-btm-left">
																  <strong>'.$question['question'].'</strong>
															  </div>';
													  
													if($question['a_type']==  'scale')
													$out .= '<div class="accordion-btm-right">
																  <div class="proSearch">
																	  <p>
																		  <input type="text" class="amount" name="data['.$count.'][survey]['.$j.'][answer]" style="border: 0; color: #000;" value="'.$question['min'].' - '.$question['max'].'" /><em>Choose</em>
																	  </p>
											  
																	  <div class="slider"></div>
																  </div><!-- End of proSearch -->
															  </div><!-- end of .accordion-btm-right -->';
															  
													if($question['a_type']==  'qty'){	  
														
													$out .= '<div class="formInput">
																  <select id="country" class="inputSelect" name="data['.$count.'][survey]['.$j.'][answer]">';
																	$out .= ' <option>Qty</option>';
																	for( $i = $question['min']; $i <= $question['max']; $i++ )
																	$out .= ' <option value="'.$i.'">'.$i.'</option>';
																$out .= ' </select>
															  </div> ';	
													}
															  
													if($question['a_type']==  'yes_no')		  
													$out .= '<div class="formInput">
																  <select id="country" class="inputSelect" name="data['.$count.'][survey]['.$j.'][answer]" >
																	  <option value="yes">Yes</option>
																	  <option  value="no">No</option>
																  </select>
															  </div> ';	
															  
													if($question['a_type']==  'text_box')		  
													$out .= '<div class="formInput">
																  <input class="text" type="text" name="data['.$count.'][survey]['.$j.'][answer]" size="5">
															  </div> ';			  		  	  
															  
													$out .= '</li> '; 
													$j++;                                 
												}
											$out .= '</ul><!-- end of .accordion-btm -->';
											}
										$out .= '</li>';  								
								$count++;
							 endwhile; 
							$out .= '</ul><!-- end of #accordion -->'; 
							endif;
								/* Restore original Post Data */
							wp_reset_postdata();
							                       
            	 
                
                
               $out .= '<div class="content-btm">
                   <div class="content-btm-mid">                   
                        <div class="aboutCOn">
                            <h2>'.$options['msg_title'].'</h2>
                            <p>'.nl2br($options['msg_desc']).'</p>
                        </div>                       
                            <div class="form-packet">
                                <span><input type="text" class="text" value="" name="info[name]" placeholder="Name" /><span class="error"></span></span>
                                <span><input type="text" class="text" value="" name="info[position]" placeholder="Position" /><span class="error"></span>
                                <span><input type="text" class="text email" value="" name="info[email]" placeholder="Email" /><span class="error"></span></span>
                                
                                <span><input type="text" class="text" value="" name="info[website]" placeholder="Website" /><span class="error"></span></span>
                            </div> 
                            <textarea class="textarea" cols="5" rows="4" name="" name="info[message]" placeholder="Message"></textarea><div id="survey_results"></div>
							<input value="submit" type="submit" class="submit surveySubmit"/>                     
                   </div>
               </div><!-- end of content-btm-->
               </form><!-- end of .form-->';
        $out .= '</div>';
		
		$out .= '<div class="footer-top">';
                    
        	if( ($options['col_1_title'] != '') || ($options['col_1_desc'] != ''))
			$out .= '<div class="ftr-about">
                        	<h5>'.$options['col_1_title'].'</h5>
                            <p>'.nl2br($options['col_1_desc']).'</p>
                        </div><!-- End of .ftr-about -->';
                        
         	 if( ($options['col_2_title'] != '') || ($options['col_2_desc'] != ''))
			 $out .= '<div class="ftr-info">
                        	<h5>'.$options['col_2_title'].'</h5>
                            <div class="ftr-info-in">
                            	'.nl2br($options['col_2_desc']).' </div><!-- End of .ftr-info-in -->
                        </div><!-- End of .ftr-info -->';
                        
        	 if( ($options['col_3_title'] != '') || ($options['col_3_desc'] != ''))
			 $out .= '<div class="testimonials">
                        	<h5>'.$options['col_3_title'].'</h5>
                            <div class="testimonials-top">
                            	<span>&nbsp;</span>
                                '.nl2br($options['col_3_desc']).'
                            </div><!-- End of .testimonials-top -->                            
                        </div><!-- End of .testimonials -->';
                        
         $out .= '</div>';

		return $out;
 }