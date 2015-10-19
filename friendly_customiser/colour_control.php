<?php
/**
 * Alpha Color Picker Customizer Control
 *
 * This control adds a second slider for opacity to the stock WordPress color picker,
 * and it includes logic to seamlessly convert between RGBa and Hex color values as
 * opacity is added to or removed from a color.
 * 
 * This is a lightly modified version of Braad Martin's Alpha Color Picker Customizer Control, from: http://braadmartin.com/alpha-color-picker-control-for-the-wordpress-customizer/
 */
if( class_exists('WP_Customize_Control') ){
	class Customize_Alpha_Color_Control extends WP_Customize_Control {
		
		/**
		 * Official control name.
		 */
		public $type = 'alpha-color';
	
		/**
		 * Add support for palettes to be passed in.
		 *
		 * Supported palette values are true, false, or an array of RGBa and Hex colors.
		 */
		public $palette;
	
		/**
		 * Add support for showing the opacity value on the slider handle.
		 */
		public $show_opacity;
	
		/**
		 * Enqueue scripts and styles.
		 *
		 * Ideally these would get registered and given proper paths before this control object
		 * gets initialized, then we could simply enqueue them here, but for completeness as a
		 * stand alone class we'll register and enqueue them here.
		 */
		public function enqueue() {
			global $wb_customiser;
			wp_enqueue_script(
				'alpha-color-picker',
				$wb_customiser->get_container_uri() . ('/js/alpha-color-picker.js'),
				array( 'jquery', 'wp-color-picker' ),
				'1.0.0',
				true
			);
			wp_enqueue_style(
				'alpha-color-picker',
				$wb_customiser->get_container_uri() . ('/css/alpha-color-picker.css'),
				array( 'wp-color-picker' ),
				'1.0.0'
			);
		}
	
		/**
		 * Render the control.
		 */
		public function render_content() {
	
			// Process the palette
			if ( is_array( $this->palette ) ) {
				$palette = implode( '|', $this->palette );
			} else {
				// Default to true.
				$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
			}
	
			// Support passing show_opacity as string or boolean. Default to true.
			$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
	
			// Begin the output. ?>
			<label>
				<?php // Output the label and description if they were passed in.
				if ( isset( $this->label ) && '' !== $this->label ) {
					echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
				}
				if ( isset( $this->description ) && '' !== $this->description ) {
					echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
				} ?>
				<input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
			</label>
			<?php
		}
	}
}