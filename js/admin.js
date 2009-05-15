var j = jQuery.noConflict();

j(document).ready(function() {
	j('#arras-settings-form').tabs();
	
	j('#add-new-hook').click( function() {
		j('#hook-template .arras-hook').clone().prependTo('#hooks-placeholder');
	});
	
	j('.remove-hook a').live('click', function() {
		j(this).parents('.arras-hook').remove();
	});
	
	j('.hook-condition-links .button-secondary').live('click', function() {
		j(this).parents('.arras-hook').children('ul').children().remove();
		j( j(this).attr('href') ).clone().prependTo( j(this).parents('.arras-hook').children('ul') );
		return false;
	});
	
	j('.remove-hook-condition').live('click', function() {
		var ul = j(this).parents('ul');
		j(this).parents('li').remove();
		if( j(this).parents('ul').children().length == 0 ) {
			ul.prepend('<li style="display: none"><input type="hidden" name="arras-hook-filter[]" value="" /></li>');
		}
	});
	
	j('.arras-background-node').click( function() {
		j('.arras-background-node').removeClass('background-selected');
		j(this).toggleClass('background-selected');
		
		j('#arras-background').val( j(this).children('a').attr('href').substr(1) );
		
		if (j(this).hasClass('arras-background-custom')) {
			j('.background-extras').show();
			j('#arras-background-type').val('custom');
		} else {
			j('.background-extras').hide();
			j('#arras-background-type').val('original');
		}
		
		return false;
	});
	
	j('#colorpicker').farbtastic('#arras-background-color');
	j('#colorpicker').hide();
	
	j('#arras-background-color').focus( function() {
		j('#colorpicker').show('fast');
	});
	
	j('#arras-background-color').blur( function() {
		j('#colorpicker').hide('fast');
	});
	
});