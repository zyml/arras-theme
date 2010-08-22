<?php
/* Functions based on Codeigniter's Form Helper Class (http://www.codeigniter.com) */

function arras_form_input($data = '', $value = '', $extra = '') {
	$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);
	return "<input "._parse_form_attributes($data, $defaults).$extra." />";
}

function arras_form_textarea($data = '', $value = '', $extra = '') {
	$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'cols' => '90', 'rows' => '12');

	if ( ! is_array($data) OR ! isset($data['value'])) {
		$val = $value;
	} else {
		$val = $data['value']; 
		unset($data['value']); // textareas don't use the value attribute
	}

	return "<textarea "._parse_form_attributes($data, $defaults).$extra.">".$val."</textarea>";
}

function arras_form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {
	if ( ! is_array($selected)) {
		$selected = array($selected);
	}
	
	if ( empty($options) ) {
		return false;
	}

	// If no selected state was submitted we will attempt to set it automatically
	if (count($selected) === 0) {
		// If the form name appears in the $_POST array we have a winner!
		if (isset($_POST[$name])) $selected = array($_POST[$name]);
	}

	if ($extra != '') $extra = ' '.$extra;

	$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';
	$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

	foreach ($options as $key => $val) {
		$key = (string) $key;
		if (is_array($val)) {
			$form .= '<optgroup label="'.$key.'">'."\n";
			foreach ($val as $optgroup_key => $optgroup_val) {
				$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';
				$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
			}
			$form .= '</optgroup>'."\n";
		} else {
			$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';
			$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
		}
	}
	$form .= '</select>';
	return $form;
}

function arras_form_checkbox($data = '', $value = '', $checked = FALSE, $extra = '') {
	$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

	if (is_array($data) AND array_key_exists('checked', $data)) {
		$checked = $data['checked'];
		
		if ($checked == FALSE) unset($data['checked']);
		else $data['checked'] = 'checked';
	}

	if ($checked == TRUE) $defaults['checked'] = 'checked';
	else unset($defaults['checked']);

	return "<input "._parse_form_attributes($data, $defaults).$extra." />";
}

function arras_form_radio($data = '', $value = '', $checked = FALSE, $extra = '') {
	if ( ! is_array($data)) {	
		$data = array('name' => $data);
	}

	$data['type'] = 'radio';
	return arras_form_checkbox($data, $value, $checked, $extra);
}

function arras_set_radio($field = '', $value = '', $default = FALSE) {
	if ( ! isset($_POST[$field])) {
		if (count($_POST) === 0) {
			return ' checked="checked"';
		}
		return '';
	}

	$field = $_POST[$field];
	
	if (is_array($field)) {
		if ( ! in_array($value, $field)) {
			return '';
		}
	} else {
		if (($field == '' OR $value == '') OR ($field != $value)) {
			return '';
		}
	}

	return ' checked="checked"';
}

function _parse_form_attributes($attributes, $default) {
	if (is_array($attributes)) {
		foreach ($default as $key => $val) {
			if (isset($attributes[$key])) {
				$default[$key] = $attributes[$key];
				unset($attributes[$key]);
			}
		}
	
		if (count($attributes) > 0) {
			$default = array_merge($default, $attributes);
		}
	}
	
	$att = '';
	
	foreach ($default as $key => $val) {
		if ($key == 'value') {
			$val = form_prep($val);
		}
	
		$att .= $key . '="' . $val . '" ';
	}
	
	return $att;
}

function form_prep($str = '') {
	// if the field name is an array we do this recursively
	if (is_array($str)) {
		foreach ($str as $key => $val){
			$str[$key] = form_prep($val);
		}
		return $str;
	}

	if ($str === '') return '';

	$temp = '__TEMP_AMPERSANDS__';

	// Replace entities to temporary markers so that 
	// htmlspecialchars won't mess them up
	$str = preg_replace("/&#(\d+);/", "$temp\\1;", $str);
	$str = preg_replace("/&(\w+);/",  "$temp\\1;", $str);

	$str = htmlspecialchars($str);

	// In case htmlspecialchars misses these.
	$str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

	// Decode the temp markers back to entities
	$str = preg_replace("/$temp(\d+);/","&#\\1;",$str);
	$str = preg_replace("/$temp(\w+);/","&\\1;",$str);

	return $str;
}

function arras_get_files_list($path, $include_none) {
	$files = array();
	
	if ($include_none) $files['none'] = 'None';
	
	if ( $handle = @opendir(get_stylesheet_directory() . $path) ) {
		while ( false !== ( $file = @readdir($handle) ) ) {
			if ( $file != '.' && $file != '..' && preg_match('@.(jpg|png|gif)$@', $file) ) {
				$files[$file] = $file;
			}
		}
		closedir($handle);
	}
	return $files;
}

function arras_get_terms_list($taxonomy) {
	$terms = get_terms($taxonomy, 'hide_empty=0');
	$opt = array();
	
	if (!is_wp_error($terms)) {
		foreach ($terms as $term) {
			if ($taxonomy == 'category' || $taxonomy = 'post_tag') {
				$opt[$term->term_id] = $term->name;
			} else {
				$opt[$term->slug] = $term->name;
			}
		}
	}
	
	return array('-5' => __('Stickied Posts', 'arras'), arras_get_taxonomy_name($taxonomy) => $opt);
}

function arras_get_taxonomy_list($object) {
	$taxonomies = get_object_taxonomies($object, 'objects');

	$opt = array();
	
	foreach( $taxonomies as $id => $obj ) {
		if ( !in_array($id, arras_taxonomy_blacklist()) ) {
			$opt[$id] = $obj->labels->name;
		}
	}
	
	return $opt;
}

function arras_get_posttype_name($id) {
	$obj = get_post_type_object($id);
	
	if ($obj) {
		return $obj->labels->name;
	}
}

function arras_get_taxonomy_name($id) {
	$obj = get_taxonomy($id);
	
	if ($obj) {
		return $obj->labels->name;
	} else {
		return __('Taxonomy', 'arras');
	}
}

function arras_cache_is_writable() {
	if (ARRAS_THUMB == 'phpthumb') $cache_path = TEMPLATEPATH . '/library/phpthumb/cache';
	else $cache_path = TEMPLATEPATH . '/library/cache';
	return (boolean)is_writable($cache_path);
}

function arras_gd_is_installed() {
	return (boolean)function_exists('gd_info');
}

function arras_get_tapestries_select() {
	global $arras_tapestries;
	
	$output = array();
	
	foreach($arras_tapestries as $id => $args) {
		$output[$id] = $args->name;
	}
	
	ksort($output);
	return $output;
}

/* End of file functions.php */
/* Location: ./library/admin/templates/functions.php */
