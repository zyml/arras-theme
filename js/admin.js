var j = jQuery.noConflict();

j(document).ready(function() {
	j('#arras-settings-form').tabs();
	j('select[name|=arras-layout-col]').change( function() {
		checkRegenThumbsField();
	} );
	j('input[name|=arras-reset-thumbs]').change( function() {
		checkRegenThumbsField();
	} );
	
	j('.enabler input[type=checkbox]').change( function() {
		j(this).parent().parent().next().toggle();
	} );
	
	j('.enabler input[type=checkbox]:checked').parent().parent().next().show();
	j('.enabler input[type=checkbox]:not(:checked)').parent().parent().next().hide();
	
	j('.form-table select.multiple').multiSelect({noneSelectedText: 'All Posts', showHeader: false});
});

function checkRegenThumbsField() {
	j('.arras-regen-thumbs-field').css('backgroundColor', 'yellow');
	j('.arras-regen-thumbs-field').animate({ backgroundColor: 'white' }, 1500);
	j('#arras-regen-thumbs').attr('checked', 'checked');
}