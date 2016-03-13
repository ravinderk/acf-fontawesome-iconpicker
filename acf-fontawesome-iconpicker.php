<?php
/*
Plugin Name: Advanced Custom Fields: FontAwesome IconPicker
Plugin URI: http://ravinder.me
Description: A simple font awesome icons picker for ACF
Version: 0.1.0
Author: Ravinder Kumar
Author URI: http://ravinder.me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class ACF_FontAwesome_IconPicker {
	/**
	 * @var ACF_FontAwesome_IconPicker The reference to *ACF_FontAwesome_IconPicker* instance of this class
	 */
	private static $instance;

	/**
	 * Returns the *ACF_FontAwesome_IconPicker* instance of this class.
	 *
	 * @return ACF_FontAwesome_IconPicker The *ACF_FontAwesome_IconPicker* instance.
	 */
	public static function getInstance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *ACF_FontAwesome_IconPicker* via the `new` operator from outside of this class.
	 */
	protected function __construct() {}


	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *ACF_FontAwesome_IconPicker* instance.
	 *
	 * @return void
	 */
	private function __clone() {}


	/**
	 * Private unserialize method to prevent unserializing of the *ACF_FontAwesome_IconPicker*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup() {}


	/**
	 * Run features
	 */
	public function run() {
		// Version 4
		add_action('acf/register_fields', array($this, 'register_fields'));

		// Version 5
		add_action('acf/include_field_types',  array($this, 'include_field_types'));
	}

	/**
	 *  register_fields()
	 *
	 *  @since: 0.1.0
	 */
	function register_fields() {
		include_once 'fontawesome-iconpicker-v4.php';
	}

	/**
	 *  include_field_types()
	 *
	 *  @since: 0.1.0
	 */
	function include_field_types( $version ) {
		include_once 'fontawesome-iconpicker-v5.php';
	}
}

/**
 * Initiate functionality
 */
ACF_FontAwesome_IconPicker::getInstance()->run();