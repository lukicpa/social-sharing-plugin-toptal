<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 * @author     Darko Lukic <lukic.pa@gmail.com>
 */
class Social_Share_Top_Tal_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//Set default values for sharing options
		add_option( 'sstt_page_sharing', 'on' );
		add_option( 'sstt_post_sharing', 'on' );
		add_option( 'sstt_content_sharing', 'on' );
		add_option( 'sstt_before_content_sharing', 'on' );
		add_option( 'sstt_icon_size', 'small' );
		add_option( 'sstt_color_setting' );

		$sharing_services = Social_Share_Top_Tal::get_sharing_services();

		$position = 1;
		foreach( $sharing_services as $sharing_service => $default_value ) {
			add_option( 'sstt_' . $sharing_service, $default_value );
			add_option( 'sstt_' . $sharing_service . '_position', $position );

			$position ++;
		}
	}

}
