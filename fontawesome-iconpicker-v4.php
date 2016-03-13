<?php

class FontAwesome_IconPicker extends acf_field {

	// Vars
	var $settings, 		// Will hold info such as dir / path
		$defaults,		// Will hold default field options
		$json_content; 	// Hold the content of icons JSON config file

	/**
	 *  __construct
	 *
	 *  @since	0.1.0
	 */
	function __construct() {
		
		// Vars
		$this->name = 'fonticonpicker';
		$this->label = __('Icon Picker');
		$this->category = __( 'jQuery', 'acf' );

    	parent::__construct();

    	// Settings
		$this->settings = array(
			'dir' 		=> 	apply_filters('acf/helpers/get_dir', __FILE__),
			'path'		=>	apply_filters('acf/helpers/get_path', __FILE__),
			'config' 	=> 	apply_filters('acf/helpers/get_path', __FILE__) . 'lib/fontawesome-config.json',
			'icons'		=>	apply_filters('acf/helpers/get_dir', __FILE__) . 'lib/Font-Awesome/css/font-awesome.min.css',
			'version' 	=> 	'0.1.0'
		);
		
		// Apply a filter so that you can load icon set from theme
		$this->settings = apply_filters( 'acf/FontAwesome_IconPicker()/settings', $this->settings );
		
		// Enqueue icons style in the frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

		// Load icons list from the icons JSON file
		if ( is_admin() ){
			$json_file = @file_get_contents( $this->settings['config'] );
			$this->json_content = @json_decode( $json_file, true );
		}

	}
	
	/**
	 *  frontend_enqueue()
	 *
	 *  @since	1.0.0
	 */
	function frontend_enqueue() {
		// Register icons style
		wp_register_style( 'fontawesome', $this->settings['icons'], array(), '4.5.0' );
		wp_enqueue_style( 'fontawesome' );
	}

	/**
	 *  create_field()
	 *
	 *  @param	$field - An array holding all the field's data
	 *
	 *  @since	1.0.0
	 */
	function create_field( $field ) {
		
		if ( !isset( $this->json_content['glyphs'] ) ){
			_e('No icons found');
			return;
		}

		// icons SELECT input
		echo '<select name="'. $field['name'] .'" id="'. $field['name'] .'" class="acf-iconpicker">';
		echo '<option value="">'. __('None').'</option>';
		foreach ( $this->json_content['glyphs'] as $glyph ) {
			$glyph_full = $this->json_content['css_prefix_text'] . $glyph['id'];
			echo '<option value="'. $glyph_full .'" '. selected( $field['value'], $glyph_full, false ) .'>'. $glyph['id'] .'</option>';
		}
		echo '</select>';
		
	}


	/**
	 *  input_admin_enqueue_scripts()
	 *
	 *  @since	1.0.0
	 */
	function input_admin_enqueue_scripts() {
	
		// Register Scripts.
		wp_register_script( 'acf-fonticonpicker', $this->settings['dir'] . 'lib/fontIconPicker/jquery.fonticonpicker.min.js', array('jquery'), $this->settings['version'] );
		wp_register_script( 'acf-fonticonpicker-input', $this->settings['dir'] . 'js/input.js', array('acf-fonticonpicker'), $this->settings['version'] );

		// Enqueue scripts
		wp_enqueue_script( 'acf-fonticonpicker-input' );
		
		// Register styles.
		wp_register_style( 'acf-fonticonpicker-style', $this->settings['dir'] . 'lib/fontIconPicker/css/jquery.fonticonpicker.min.css', false, $this->settings['version'] );
		wp_register_style( 'acf-fonticonpicker-grey-theme-style', $this->settings['dir'] . 'lib/fontIconPicker/themes/grey-theme/jquery.fonticonpicker.grey.min.css', false, $this->settings['version'] );
		wp_register_style( 'fontawesome', $this->settings['icons'], array(), '4.5.0' );

		// Enqueue styles.
		wp_enqueue_style(
			array(
				'acf-fonticonpicker-style',
				'acf-fonticonpicker-grey-theme-style',
				'fontawesome'
			)
		);
	}

} // Class FontAwesome_IconPicker()

// create field
new FontAwesome_IconPicker();