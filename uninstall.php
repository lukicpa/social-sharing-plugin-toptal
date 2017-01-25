<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//Remove all options
$sharing_services = Social_Share_Top_Tal::get_sharing_services();

foreach( $sharing_services as $sharing_service => $default_value ) {
	delete_option( 'sstt_' . $sharing_service );
	delete_option( 'sstt_' . $sharing_service . '_position' );
}

// General Settings
delete_option( 'sstt_page_sharing' );
delete_option( 'sstt_post_sharing' );

// CPT Sharing options
$registered_post_types = get_post_types( array( '_builtin' => false ), 'names' );

foreach ( $registered_post_types as $registered_post_type ) {
	delete_option( 'sstt_' . $registered_post_type . '_sharing' );
}

// Display Settings
delete_option( 'sstt_title_sharing' );
delete_option( 'sstt_before_content_sharing' );
delete_option( 'sstt_content_sharing' );
delete_option( 'sstt_floating_sharing' );
delete_option( 'sstt_image_sharing' );
delete_option( 'sstt_icon_size' );
delete_option( 'sstt_color_setting' );