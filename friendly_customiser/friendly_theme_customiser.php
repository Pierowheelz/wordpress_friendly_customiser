<?php
/*
 * this file handles all the colours and tweaks for the theme customiser.
 
To add a new section to the theme customiser call:
	add_filter( 'wb_customiser_sections', 'your_sections_function' ); //set the third `order` parameter to adjust the position of the section (a lower number will appear earlier)
	function your_sections_function( $sections ){
		$sections[ 'your_section_slug' ] = 'New Section Title';
		return $sections;
	}
	
To add fields to this new section call:
	add_filter( 'wb_customiser_fields', 'your_fields_function' );
	function your_fields_function( $fields ){
		$fields[] = array(
			'title' => 'Custom field', //The label for the field
			'id' => 'custom_field_id', //any unique string
			'section' => 'your_section_slug', //the ID of the section to display this field in (the one you just set with 'wb_customiser_sections')
			'type' => 'alpha_colour', //possible options are: 'colour', 'alpha_colour', 'radio', 'select', 'textarea', 'checkbox', 'image', 'file', 'text'
			'options' => array( //only required for 'radio or 'select' types
				'option_slug' => 'Option Title', //add as many options as you want
			),
			'default' => 'rgba(0,0,0,0)', //The default value
			'live' => array( //(optional) add this 'live' array to change css or classes in real-time. css changes will be automatically set on the front-end of the site, classes will still need to be coded in to your template.
				'type' => 'css', //can be 'css' or 'class'
				'hook' => 'html .page', //the css hook to target the element (add html in front to strengthen the selector)
				'variable' => 'background-color', //the css variable to change (only required for 'type' => 'css')
				'units' => '' //(optional) append a value (such as 'px') to the value
			)
		);
		
		//add more fields by repeating the above code template as many times as you need
		
		return $fields;
	}
 
 
 */

require_once( dirname(__FILE__) . '/colour_control.php' );

class wb_friendly_customiser{
	//set to either: 'child_theme' or 'parent_theme' depending on usage
	private $mode = 'child_theme';
	
	//set this to the directory that you are storing the css and js files in relative to the theme's root directory (eg. if css files are in 'your_theme/inc/css' then set this to '/inc/') .
	private $dir = '/vendor/friendly_customiser/';
	
	// Add your global settings here, a few default settings are set below
	private $settings = array(
		array(
			'title' => 'Page Background Colour',
			'id' => 'wb_page_background_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#ffffff',
			'live' => array(
				'type' => 'css',
				'hook' => 'html body',
				'variable' => 'background-color',
				'units' => ''
			)
		),
		array(
			'title' => 'Text Colour',
			'id' => 'wb_text_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#111',
			'live' => array(
				'type' => 'css',
				'hook' => 'html body',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'Link Colour (a tag)',
			'id' => 'wb_a_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#454545',
			'live' => array(
				'type' => 'css',
				'hook' => 'html a, html a:visited',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'H1 Colour',
			'id' => 'wb_h1_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#333333',
			'live' => array(
				'type' => 'css',
				'hook' => 'html h1',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'H2 Colour',
			'id' => 'wb_h2_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#2d4257',
			'live' => array(
				'type' => 'css',
				'hook' => 'html h2',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'H3 Colour',
			'id' => 'wb_h3_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#3a99d9',
			'live' => array(
				'type' => 'css',
				'hook' => 'html h3',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'H4 Colour',
			'id' => 'wb_h4_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#000',
			'live' => array(
				'type' => 'css',
				'hook' => 'html h4',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'H5 Colour',
			'id' => 'wb_h5_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#000',
			'live' => array(
				'type' => 'css',
				'hook' => 'html h5',
				'variable' => 'color',
				'units' => ''
			)
		),
		array(
			'title' => 'Button Background Colour',
			'id' => 'wb_button_bak_colour',
			'section' => 'wb_global_colours',
			'type' => 'alpha_colour',
			'default' => '#333',
			'live' => array(
				'type' => 'css',
				'hook' => 'html .button, html button, html input[type="submit"], html input[type="reset"], html .btn, html .vfbp-form .btn-primary',
				'variable' => 'background-color',
				'units' => ''
			)
		),
		array(
			'title' => 'Button Colour',
			'id' => 'wb_button_colour',
			'section' => 'wb_global_colours',
			'type' => 'colour',
			'default' => '#fff',
			'live' => array(
				'type' => 'css',
				'hook' => 'html .button, html button, html input[type="submit"], html input[type="reset"], html .btn, html .vfbp-form .btn-primary',
				'variable' => 'color',
				'units' => ''
			)
		)
	);
	
	private $sections = array(
		'wb_global_colours' => 'Global Colours',
	);
	
	function __construct(){
		add_action( 'customize_register', array( $this, 'auto_sections'), 10 );
		add_action( 'customize_register', array( $this, 'auto_controls'), 11 );
		add_action( 'customize_preview_init', array( $this, 'customizer_live_preview' ) );
		add_action( 'wp_print_styles', array( $this, 'print_auto_styles' ) );
		add_action( 'customize_controls_print_styles', array($this, 'customiser_styles'));
	}
	
	function auto_sections( $wp_customize ){
		$this->sections = apply_filters( 'wb_customiser_sections', $this->sections ); //allow plugins&extensions to add more sections
		$priority = 30;
		foreach( $this->sections as $section_id => $section_title ){
			$wp_customize->add_section( $section_id, array(
			    'title'      => __( $section_title, 'wb' ),
			    'priority'   => $priority++,
			) );
		}
	}
	
	/*
	 * does the automatic theme mod registrations
	 */
	function auto_controls( $wp_customize ){
		$this->settings = apply_filters( 'wb_customiser_fields', $this->settings ); //allow plugins&extensions to add more settings
		$priority = 10;
		foreach( $this->settings as $setting ){
			$transport = 'refresh';
			if( isset($setting['live']) ){
				if( !empty($setting['live']) ){
					if(! isset($setting['live']['nojs']) ){
						$transport = 'postMessage';
					}
				}
			}
			$wp_customize->add_setting( $setting['id'] , array(
			    'default'     => $setting['default'],
			    'transport'   => $transport,
			) );
			
			switch( $setting['type'] ){
				case 'colour':
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting['id'], array(
						'label'        => __( $setting['title'], 'wb' ),
						'section'    => $setting['section'],
						'settings'   => $setting['id'],
						'priority'   => $priority
					) ) );
					break;
				case 'alpha_colour':
					$wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, $setting['id'], array(
						'label'        => __( $setting['title'], 'wb' ),
						'section'    => $setting['section'],
						'settings'   => $setting['id'],
						'show_opacity'  => true,
						'palette'   => array(
		                    'rgb(150, 50, 220)', // RGB, RGBa, and hex values supported
		                    'rgba(50,50,50,0.8)',
		                    'rgba( 255, 255, 255, 0.2 )', // Different spacing = no problem
		                    '#00CC99' // Mix of color types = no problem
		                ),
						'priority'   => $priority
					) ) );
					break;
				case 'radio':
				case 'select':
					$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting['id'], array(
			            'label'          => __( $setting['title'], 'wb' ),
			            'section'        => $setting['section'],
			            'settings'       => $setting['id'],
			            'type'           => $setting['type'],
			            'choices'        => $setting['options'],
						'priority'       => $priority
					) ) );
					break;
				case 'textarea':
				case 'checkbox':
					$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting['id'], array(
			            'label'          => __( $setting['title'], 'wb' ),
			            'section'        => $setting['section'],
			            'settings'       => $setting['id'],
			            'type'           => $setting['type'],
						'priority'       => $priority
					) ) );
					break;
				case 'image':
				case 'file':
					$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $setting['id'], array(
			            'label'          => __( $setting['title'], 'wb' ),
			            'section'        => $setting['section'],
			            'settings'       => $setting['id'],
						'priority'       => $priority
					) ) );
					break;
				default: /* text */
					$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $setting['id'], array(
			            'label'          => __( $setting['title'], 'wb' ),
			            'section'        => $setting['section'],
			            'settings'       => $setting['id'],
			            'type'           => 'text',
						'priority'       => $priority
					) ) );
					break;
			}
			$priority++;
		}
	}
	
	/*
	 * handles the live js in the customiser
	 */
	function customizer_live_preview(){
		$url_vars = array();
		foreach( $this->settings as $setting ){
			if( isset($setting['live']) ){
				if( !empty($setting['live']) ){
					$pass_to_js = isset($setting['live']['nojs'])?false:true;
					if( $pass_to_js ){
						if( $setting['live']['type'] == 'class' && isset($setting['options']) ){
							$setting['live']['variations'] = array();
							foreach( $setting['options'] as $opt_class => $opt_val ){
								$setting['live']['variations'][] = $opt_class;
							}
						}
						$url_vars[ $setting['id'] ] = $setting['live'];
					}
				}
			}
		}
		
		wp_enqueue_script( 'wb_theme_customizser', $this->get_container_uri() . 'js/theme-customiser.js', array( 'jquery','customize-preview' ), '1.0.0', true );
		wp_localize_script( "wb_theme_customizser", 'previews', $url_vars );
	}
	
	public function customiser_styles(){
		wp_register_style( 'customizer-alpha-colour', $this->get_container_uri() . 'css/alpha_colour_control.css' );
	}
	
	/*
	 * loops through the settings and makes a css rule
	 */
	function print_auto_styles(){
		if( !is_admin() ){
			$this->settings = apply_filters( 'wb_customiser_fields', $this->settings ); //allow plugins&extensions to add more settings
			$styles = '';
			foreach( $this->settings as $setting ){
				if( isset($setting['live']) ){
					if( !empty($setting['live']) ){
						if( isset($setting['live']['type']) ){
							if( $setting['live']['type'] == 'css' ){
								$prepend = isset($setting['live']['prepend'])?$setting['live']['prepend']:'';
								$append = isset($setting['live']['units'])?$setting['live']['units']:'';
								$styles .= $setting['live']['hook'] . '{';
								$styles .= 	$setting['live']['variable'] . ': ';
								$styles .= 	$prepend . get_theme_mod( $setting['id'], $setting['default'] ) . $append . ';';
								$styles .= '}' . "\r\n";
							}
						} else {
							foreach( $setting['live'] as $live ){
								if( isset($live['type']) ){
									if( $live['type'] == 'css' ){
										$prepend = isset($live['prepend'])?$live['prepend']:'';
										$append = isset($live['units'])?$live['units']:'';
										$styles .= $live['hook'] . '{';
										$styles .= 	$live['variable'] . ': ';
										$styles .= 	$prepend . get_theme_mod( $setting['id'], $setting['default'] ) . $append . ';';
										$styles .= '}' . "\r\n";
									}
								} else {
									if( WP_DEBUG ){
										'Cannot parse css rule';
									}
								}
							}
						}
					}
				}
			}
			
			/*echo '<pre>';
			echo $styles;
			echo '</pre>';*/
			
			?>
			<style>
				<?php echo $styles; ?>
			</style>
			<?php
		}
	}
	
	function get_container_uri(){
		if( function_exists('get_home_path') ){
			$ret_dir = dirname(str_replace( str_replace('\\','/',get_home_path()), home_url(), str_replace('\\','/',__FILE__) ));
		} else {
			$ret_dir = '/';
		}
		switch( $this->mode ){
			case 'parent_theme':
				$ret_dir = get_template_directory_uri();
				break;
			case 'child_theme':
				$ret_dir = get_stylesheet_directory_uri();
				break;
		}
		
		return apply_filters( 'fc_container_dir', $ret_dir . $this->dir );
	}
}

$wb_customiser = new wb_friendly_customiser;
