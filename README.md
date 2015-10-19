# wordpress_friendly_customiser
A drop in module for your WordPress theme to simplify the use of WordPress' Theme Customization API. This is done using a few simple filters to allow you to define settings and even generate css. This reduces your code from around 200-500 lines of custom code to around 20 lines which define arrays.

Installation
==============
Just drop in the friendly_customiser folder into your theme's root directory and put the below in your functions.php
	include_once( get_stylesheet_directory() . '/friendly_customiser/friendly_theme_customiser.php' );

Sample Code
==============
Theme integration
--------------
Add the below to your functions.php file
	add_filter( 'wb_customiser_sections', 'register_your_settings_areas', 1 ); //set the third `order` parameter to adjust the position of the section
	function register_your_settings_areas( $sections ){
		
		//you will register your settings areas in here
		
		return $sections;
	}

	add_filter( 'wb_customiser_fields', 'register_your_settings' );
	function register_your_settings( $fields ){
		
		//you will define your settings in here
		
		return $fields;
	}

Creating a settings area
--------------
Create a new settings area (eg. Global Colours) by adding the below to the function hooked to 'wb_customiser_sections'
	add_filter( 'wb_customiser_sections', 'register_your_settings_areas', 1 ); //set the third `order` parameter to adjust the position of the section
	function register_your_settings_areas( $sections ){
		
		$sections[ 'my_global_colours' ] = 'Global Colours';
		
		return $sections;
	}

Creating a basic text area setting (without live previews)
--------------
A simple example, just setting some text as a theme mod.
	$fields[] = array(
		'title' => 'Down Button Text', //The label for the field
		'id' => 'down_button_text', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'text', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'default' => 'Find Out More', //The default value
	);
We can retrieve this in our theme with get_theme_mod( 'down_button_text', 'Find Out More' );

Creating a text area setting with a live preview
--------------
The same simple example, with a live preview.
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
We can retrieve this in our theme with get_theme_mod( 'down_button_text', 'Find Out More' );

Creating a css colour setting with a live preview and auto-generated front end css code
--------------
A simple example used to set up the primary colour of text.
	$fields[] = array(
		'title' => 'Primary Colour', //The label for the field
		'id' => 'custom_primary_colour', //any unique string
		'section' => 'global_settings', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
		'type' => 'alpha_colour', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
		'default' => '#428bca', //The default value
		'live' => array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
			'type' => 'css', //can be 'css', 'class' or 'text'. NOTE: 'css' will be generated for the front end automatically but 'class' and 'text' need to be manually set in your theme.
			'hook' => 'html .primary_colour, html a.primary_colour', //the css hook to target the element (add html in front to strengthen the css selector)
			'variable' => 'color', //the css variable to change (only required for 'type' => 'css')
			'prepend' => '',
			'units' => '' //(optional) append a value (such as 'px') to the value
		)
	);

A more advanced css colour setting with multiple selectors (color, background-color and border-color)
--------------
A complex example used to set up the primary colour classes of a theme.
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


Creating a class setting with a drop down list and live preview
--------------
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

Advanced installation
==============
Parent themes
--------------
By default this extension is set up to work with child themes (or standalone themes), if you are using this in a parent theme use the below hook
	add_filter( 'wb_customiser_theme_type', create_function( null, "return 'parent_theme';" ) );

Installation directory or seamless integration
--------------
If you would like to include this extension in a different directory (instead of yourtheme/friendly_customiser/) you can use the below to customise the directory
	add_filter( 'wb_customiser_directory', create_function( null, "return '/includes/';" ) );
Simply set it to '/' to add the css or js files in your top level yourtheme/css and yourtheme/js folders.
Note: the .php files can be placed anywhere regardless of this setting, but the two must be in the same directory

