var j = jQuery.noConflict();

j(document).ready(function() {
	j('#arras-settings-form').tabs();
	j('select[name|=arras-layout-col]').change( function() {
		checkRegenThumbsField();
	} );
});

function checkRegenThumbsField() {
	j('.arras-regen-thumbs-field').css('backgroundColor', 'yellow');
	j('.arras-regen-thumbs-field').animate({ backgroundColor: 'white' }, 1500);
	j('#arras-regen-thumbs').attr('checked', 'checked');
}