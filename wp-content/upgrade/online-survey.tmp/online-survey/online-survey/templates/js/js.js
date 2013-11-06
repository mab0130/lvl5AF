/**
* this js file only use for frontend
* @razib
*/
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    return pattern.test(emailAddress);
};

jQuery(document).ready(function($){
	
	<!---- Accordion ---->
	if($('.accordion-top').length > 0){
		$('.accordion-top').click(function(e) {
			e.preventDefault();
			$('.accordion-top').removeClass('btnClose showHide');
			$('ul.accordion-btm').slideUp();
			$(this).toggleClass('btnClose showHide').closest('li').find('ul.accordion-btm').stop(true,true).slideToggle();
		}); 
		$('#accordion li:first .accordion-top').trigger('click');
	}
	
		//range slider
	
	if($(".slider").length > 0){
		$(".slider").slider({
			range: true,
			min: 1,
			max: 100,
			values: [ 20, 70 ],
			slide: function( event, ui ) {
				$(this).closest('li').find( ".amount" ).val(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			},
			create: function() {
				jQuery(".slider > a:last-child").addClass('next_btn');
			}
		});
	}
	
	
	
	if($('input.surveySubmit').length > 0){
		$('input.surveySubmit').click(function(){
			$(this).hide();
			$('span.error').hide();
			$('#survey_results').empty().append('Working....');
			var error = 0;
			
			//---form validation-----------------
			$('form.surveyForm input[type=text] , form.surveyForm textarea.textarea').css('border-color', '#CFCFCF');
			$('form .form-packet input[type=text]').each(function(){
				if($(this).val() == ''){
					$(this).css('border-color', 'red');
					error = 1;
				}else if( $(this).val().length < 5){
					$(this).css('border-color', 'red');				
					$(this).closest('span').find('span.error').empty().text(' Add more than 5 Chars.').fadeIn();
					error = 1;
				}else if( ($(this).hasClass('email')) && ( !isValidEmailAddress($(this).val()) ) ){
					$(this).css('border-color', 'red');
					$(this).closest('span').find('span.error').empty().text('Please Enter a valid Email Address.').fadeIn();
					  error = 1;
					 
				}
							
			});
			if($('form.surveyForm textarea.textarea').val() == '' ){
				$('form.surveyForm textarea.textarea').css('border-color', 'red');
				error = 1;
			}
			//---End validation------------------
			
			//----Submit-------------------------
			if( error== 0 ){		
				var data = {
							info		: $('form.surveyForm').serialize(),
							action	:	'survey_form_submit',
							};
				$.post(ajaxurl, data, function(response) {
									if(response.id == 1){
										alert(response.msg);
										url=window.location.href;
										urlArr=url.split('?');
										window.location.href=urlArr[0];
									}else
									$('#survey_results').empty().append(response.msg);
				}, 'json');	
			}
			
			//----End Submit---------------------
			
			$('#survey_results').empty();
			$(this).show();
			return false;
		});
	
	}// endif
	
	
});


