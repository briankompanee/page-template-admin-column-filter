<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://thekompanee.com
 * @since      1.0.0
 *
 * @package    Bb_Page_Template_Column
 * @subpackage Bb_Page_Template_Column/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Bb_Page_Template_Column
 * @subpackage Bb_Page_Template_Column/includes
 * @author     Brian Brown <brian@thekompanee.com>
 */
class Bb_Page_Template_Column_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bb-page-template-column',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
