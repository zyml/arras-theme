<?php
/* Arras.Theme 1.2.2 - Alternate Styles & Layouts Registration */
global $arras_registered_alt_layouts;

function register_alternate_layout($id, $name) {
	global $arras_registered_alt_layouts;
	$arras_registered_alt_layouts[$id] = $name;
}

function is_valid_arras_style($file) {
	return (bool)( !preg_match('/^\.+$/', $file) && preg_match('/^[A-Za-z][A-Za-z0-9\-]*.css$/', $file) );
}

/* End of file styles.php */
/* Location: ./library/styles.php */
