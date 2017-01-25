<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/admin
 * @author     Darko Lukic <lukic.pa@gmail.com>
 */
class Social_Share_Top_Tal_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Social_Share_Top_Tal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Social_Share_Top_Tal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/social-share-top-tal-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . 'font-awesome', plugins_url( $this->plugin_name . '/assets/font-awesome-4.7.0/css/font-awesome.min.css' ), array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Social_Share_Top_Tal_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Social_Share_Top_Tal_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_script( 'jquery-ui-draggable' );
        wp_enqueue_script( 'jquery-ui-droppable' );
        wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/social-share-top-tal-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Settings for social sharing
	 */
	public function sstt_settings() {

		// Social Settings
		$sharing_services = Social_Share_Top_Tal::get_sharing_services();

		foreach( $sharing_services as $sharing_service => $default_value ) {
			register_setting( 'social-share-settings-group', 'sstt_' . $sharing_service );
			register_setting( 'social-share-settings-group', 'sstt_' . $sharing_service . '_position' );
		}

		// General Settings
		register_setting( 'social-share-settings-group', 'sstt_page_sharing' );
		register_setting( 'social-share-settings-group', 'sstt_post_sharing' );

		// CPT Sharing options
		$registered_post_types = get_post_types( array( '_builtin' => false ), 'names' );

		foreach ( $registered_post_types as $registered_post_type ) {
			register_setting( 'social-share-settings-group', 'sstt_' . $registered_post_type . '_sharing' );
		}

		// Display Settings
		register_setting( 'social-share-display-group', 'sstt_title_sharing' );
		register_setting( 'social-share-display-group', 'sstt_before_content_sharing' );
		register_setting( 'social-share-display-group', 'sstt_content_sharing' );
		register_setting( 'social-share-display-group', 'sstt_floating_sharing' );
		register_setting( 'social-share-display-group', 'sstt_image_sharing' );
		register_setting( 'social-share-display-group', 'sstt_icon_size' );
		register_setting( 'social-share-display-group', 'sstt_color_setting' );
	}

	/**
	 * Create menu page for plugin settings
	 */
	public function settings_page_menu() {
		add_menu_page(
			__( 'Social Share Settings', 'social-share-top-tal' ),
            __( 'Social Share', 'social-share-top-tal' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'settings_page_content' ),
			'dashicons-share'
		);

		add_submenu_page(
			$this->plugin_name,
            __( 'Display Settings', 'social-share-top-tal' ),
            __( 'Display Settings', 'social-share-top-tal' ),
			'manage_options',
			$this->plugin_name . "_display",
			array( $this, 'display_page_content' )
		);
	}

	/**
	 * Content of settings page
	 */
	function settings_page_content() {
		include_once 'partials/social-share-top-tal-settings-page.php';
	}

    /**
     * Content of display page
     */
	function display_page_content() {
		include_once 'partials/social-share-top-tal-display-settings.php';
	}

}
