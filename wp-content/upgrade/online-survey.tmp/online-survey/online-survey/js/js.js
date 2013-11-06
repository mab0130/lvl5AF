/**
* @razib
*/
jQuery(document).ready(function ($) {
	$( "#questionList input[type='radio']" ).livequery(function(){
		$( "#questionList input[type='radio']" ).click(function(){  
				$(this).closest('li').find('.info').hide();  		
				if($(this).val() == 'qty'){
					$(this).closest('li').find('.max').val(10);
					$(this).closest('li').find('.info_qty').fadeIn();
				}else if($(this).val() == 'scale'){
					$(this).closest('li').find('.max').val(50);
					$(this).closest('li').find('.info_qty').fadeIn();					
				}
				
		});
	});
	
	$( "#questionList .close" ).livequery(function(){
		$( "#questionList .close" ).click(function(){  
			$(this).closest('li').remove();
			return false;
		});
	});
	
	$('#questionList .delete').click(function(){
		var answer = confirm("Are You Sure to Delete  Item?");
			if (answer){
				$(this).closest('li').remove();
				return false;
			}
			else{
				return false;
			}
	});	
	
	$('a.deletID').click(function(){
		var answer = confirm("Are You Sure to Delete  Item?");
			if (answer){
				return true;
			}
			else{
				return false;
			}
	});
	
});
