<?php
/*
 * This is a sample of what you might add to your functions.php file
 */

//add the new section called 'Global Settings'
add_filter( 'wb_customiser_sections', 'smpl_custom_theme_settings_areas', 1 ); //set the third `order` parameter to adjust the position of the section (we're setting 1 so that we can unset the default settings area)
function smpl_custom_theme_settings_areas( $sections ){

	unset($sections[ 'wb_global_colours' ]); //this is an optional line that can be used to disable the default section
	$sections[ 'global_settings' ] = 'Global Settings';
	
	return $sections;
}

add_filter( 'wb_customiser_fields', 'lrgc_custom_theme_settings' );
function lrgc_custom_theme_settings( $fields ){
	
	//a simple example, just setting some text.
	$fields[] = array(
		'title' => 'Down Button Text', //The label for the field
		'id' => 'down_button_text', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'text', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'default' => 'Find Out More', //The default value
	);
	//we can retrieve this in our theme with get_theme_mod( 'down_button_text', 'Find Out More <i class="fa fa-angle-double-down"></i>' );
	
	//The same simple example, with a live preview.
	$fields[] = array(
		'title' => 'Down Button Text', //The label for the field
		'id' => 'down_button_text', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'text', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'default' => 'Find Out More', //The default value
		'live' => array(
			'type' => 'text', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
			'hook' => '#more_button', //the html hook used to target the element (add 'html' in front to strengthen the selector for css)
			'prepend' => '', //(optional) prepend a string
			'units' => '' //(optional) append a string
		)
	);
	//we can retrieve this in our theme with get_theme_mod( 'down_button_text', 'Find Out More' );
	
	//a complex example used to set up the primary colour classes of a theme.
	$fields[] = array(
		'title' => 'Primary Colour', //The label for the field
		'id' => 'custom_primary_colour', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'alpha_colour', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'default' => '#428bca', //The default value
		'live' => array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
			//we can make this an array of arrays to set multiple css properties with the one value.
			array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
				'type' => 'css', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
				'hook' => 'html .primary_background', //the css hook to target the element (add html in front to strengthen the css selector)
				'variable' => 'background-color', //the css variable to change (only required for 'type' => 'css')
				'prepend' => '',
				'units' => '' //(optional) append a value (such as 'px') to the value
			),
			array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
				'type' => 'css', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
				'hook' => 'html .primary_colour, html a.primary_colour', //the css hook to target the element (add html in front to strengthen the css selector)
				'variable' => 'color', //the css variable to change (only required for 'type' => 'css')
				'prepend' => '',
				'units' => '' //(optional) append a value (such as 'px') to the value
			),
			array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
				'type' => 'css', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
				'hook' => 'html .primary_border', //the css hook to target the element (add html in front to strengthen the css selector)
				'variable' => 'border-color', //the css variable to change (only required for 'type' => 'css')
				'prepend' => '',
				'units' => '' //(optional) append a value (such as 'px') to the value
			)
		)
	);
	
	//a class setting with a drop down list
	$fields[] = array(
		'title' => 'Display Type', //The label for the field
		'id' => 'gallery_display_type', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'select', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'options' => array( //only required for 'radio or 'select' types
			'vertical_display' => 'Vertical', //add as many options as you want
			'horizontal_display' => 'Horizontal', //add as many options as you want
		),
		'default' => 'horizontal_display', //The default value
		'live' => array( //(optional) add this 'live' array to perform a live preview. css changes will be automatically set on the front-end of the site, classes and text will still need to be coded in to your template.
			'type' => 'class', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
			'hook' => '.gallery_area' //the html hook to target the element (used as a jquery selector)
		)
	);
	
	//add more fields by repeating the above code template as many times as you need
	
	return $fields;
}