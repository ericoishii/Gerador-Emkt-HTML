$(document).ready(function() 
{	
	$('input[name="bg"], input[name="textcolor"]').colpick({
		layout:'full',
		submit: 0,
		onChange: function(hsb,hex,rgb,el,bySetColor)
		{
			$(el).css('background-color','#'+hex).css('border-color','#'+hex);
			if(!bySetColor) $(el).val('#'+hex);
		}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});
});