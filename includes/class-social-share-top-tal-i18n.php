<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 * @author     Darko Lukic <lukic.pa@gmail.com>
 */
class Social_Share_Top_Tal_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'social-share-top-tal',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
