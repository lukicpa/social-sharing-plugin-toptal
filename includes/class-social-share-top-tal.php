<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/includes
 * @author     Darko Lukic <lukic.pa@gmail.com>
 */
class Social_Share_Top_Tal {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Social_Share_Top_Tal_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Array of available social sharing services
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var     array   $sharing_services
	 */
	protected static $sharing_services;

	protected static $the_title_count = 0;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'social-share-top-tal';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();



	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Social_Share_Top_Tal_Loader. Orchestrates the hooks of the plugin.
	 * - Social_Share_Top_Tal_i18n. Defines internationalization functionality.
	 * - Social_Share_Top_Tal_Admin. Defines all hooks for the admin area.
	 * - Social_Share_Top_Tal_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-social-share-top-tal-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-social-share-top-tal-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-social-share-top-tal-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-social-share-top-tal-public.php';

		$this->loader = new Social_Share_Top_Tal_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Social_Share_Top_Tal_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Social_Share_Top_Tal_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Social_Share_Top_Tal_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//Hooks settings page menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'settings_page_menu' );

		//Register settings for social sharing
		$this->loader->add_action( 'admin_init', $plugin_admin, 'sstt_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Social_Share_Top_Tal_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		/*
		 * Show social sharing services only on single page
		 */

		//After title
		if ( 'on' == get_option( 'sstt_title_sharing' )) {
			//Sometimes we can't hook on the title because it affects all the_title hooks in post
            add_filter('the_title', array($plugin_public, 'sstt_title_social_share'), 10, 2);
		}

		// Before Content
		if ( 'on' == get_option( 'sstt_before_content_sharing' ) ) {
			add_filter( 'the_content', array( $plugin_public, 'sstt_before_content_social_share' ) );
		}

		// After Content
		if ( 'on' == get_option( 'sstt_content_sharing' ) ) {
			add_filter( 'the_content', array( $plugin_public, 'sstt_content_social_share' ) );
		}

		// Floating
		if ( 'on' == get_option( 'sstt_floating_sharing' ) ) {
			add_filter( 'the_content', array( $plugin_public, 'sstt_floating_social_share' ) );
		}

		// Over featured image
		if ( 'on' == get_option( 'sstt_image_sharing' ) ) {
			add_filter( 'post_thumbnail_html', array( $plugin_public, 'sstt_image_social_share' ) );
		}

        add_shortcode( 'sstt_sharing_icons', array( $plugin_public, 'sstt_sharing_icons_shortcode' ) );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Social_Share_Top_Tal_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Available social sharing services
	 *
	 * @since     1.0.0
	 * @return array
	 */
	public static function get_sharing_services() {
		//Return Social Service and default value
		return self::$sharing_services = array(
			'facebook'      => 'on',
			'twitter'       => 'on',
			'google-plus'   => 'on',
			'pinterest'     => 'off',
			'linkedin'      => 'off',
			'whatsapp'      => 'off'
		);
	}

}
