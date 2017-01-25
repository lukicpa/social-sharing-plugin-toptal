<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/public
 * @author     Darko Lukic <lukic.pa@gmail.com>
 */
class Social_Share_Top_Tal_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
        wp_enqueue_style( $this->plugin_name . 'font-awesome', plugins_url( $this->plugin_name . '/assets/font-awesome-4.7.0/css/font-awesome.min.css' ), array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/social-share-top-tal-public.css', array(), $this->version, 'all' );

        $color = get_option('sstt_color_setting');
        if( $color != '' ) {
            $custom_css = ".sst_sharing_box .social-share-link a i:before{color: {$color}!important;}";
            wp_add_inline_style( $this->plugin_name, $custom_css );
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/social-share-top-tal-public.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * Add social sharing html below title
     * @param $title
     * @return string
     */
    public function sstt_title_social_share( $title ) {

        if ( is_main_query() && in_the_loop() && !is_admin() && ( is_single() || is_page() ) ) {
//            $sharing_icons = $this->sstt_display_social_helper($title);
//            return $title . '<div class="sst_sharing_box sstt_display_title">' . $sharing_icons . '</div>';
            return $title . "<span style='color: red;'> - text after title</span>";
        }
        else {
            return $title;
        }

    }

    /**
     * Add social sharing html above content
     * @param $content
     * @return string
     */
    public function sstt_before_content_social_share( $content ) {

        $id = get_the_ID();
        $title = get_the_title($id);

        if( in_the_loop() && ( is_single() || is_page() ) ) {

            $sharing_icons = $this->sstt_display_social_helper($title);
            return '<div class="sst_sharing_box sstt_display_content">' . $sharing_icons . '</div>' . $content;
        } else {
            return $content;
        }
    }


    /**
     * Add social sharing html below content
     * @param $content
     * @return string
     */
    public function sstt_content_social_share( $content ) {

        $id = get_the_ID();
        $title = get_the_title($id);

        if( in_the_loop() && ( is_single() || is_page() ) ) {

            $sharing_icons = $this->sstt_display_social_helper($title);
            return $content . '<div class="sst_sharing_box sstt_display_content">' . $sharing_icons . '</div>';
        } else {
            return $content;
        }
    }

    /**
     * Add social sharing html inside floating div
     * @param $content
     * @return string
     */
    public function sstt_floating_social_share( $content ) {

        $id = get_the_ID();
        $title = get_the_title($id);
        if( in_the_loop() && ( is_single() || is_page() ) ) {
            $sharing_icons = $this->sstt_display_social_helper($title);
            return $content . '<div class="sst_sharing_box sstt_display_floating">' . $sharing_icons . '</div>';
        }
        else {
            return $title;
        }
    }

    /**
     * Add social sharing html inside featured image
     * @param $html
     * @return string
     */
    public function sstt_image_social_share( $html ) {

        $id = get_the_ID();
        $title = get_the_title($id);
        if( is_single() || is_page() ) {
            $sharing_icons = $this->sstt_display_social_helper($title);
            return $html . '<div class="sst_sharing_box sstt_display_featured_image">' . $sharing_icons . '</div>';
        }
        else {
            return $html;
        }
    }

    /**
     * Helper function for showing sharing box
     * @param $title
     * @return bool|string
     */
    public function sstt_display_social_helper( $title ) {

        /**
         * Get enabled sharings
         */
        $page_sharing     = get_option( 'sstt_page_sharing' );
        $post_sharing     = get_option( 'sstt_post_sharing' );

        // Get enabled cpts
        $registered_post_types  = get_post_types( array( '_builtin' => false ), 'names' );
        $post_types_array       = array();

        if ( !empty( $registered_post_types ) ) {
            foreach ( $registered_post_types as $registered_post_type ) {
                if ( 'on' == get_option( 'sstt_' . $registered_post_type . '_sharing' ) ) {
                    array_push( $post_types_array, $registered_post_type );
                }
            }
        }

        if ( ( 'post' == get_post_type() && 'on' == $post_sharing && !is_home() && !is_archive() && !is_page() ) || ( 'page' == get_post_type() && 'on' == $page_sharing ) ) { //if post or page sharing is enabled
            $show_sharing_icons = true;
        }
        elseif ( in_array( get_post_type(), $post_types_array ) ) { //if CPT sharing is enabled
            $show_sharing_icons = true;
        }
        else {
            $show_sharing_icons = false;
        }

        if ( $show_sharing_icons ){
            return $this->sstt_social_sharing_html( $title );
        }
        else {
            return false;
        }

    }

    /**
     * Generate social sharing HTML
     * @param $title
     * @return string
     */
    public function sstt_social_sharing_html($title ) {

        $pinterest_image    = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
        $post_url           = get_permalink();
        $title = urlencode( $title );

        $sharing_box = '';
        $sharing_url = '';

        $enabled_services = $this->sstt_get_enabled_sharing_services();

        if ( !empty( $enabled_services ) ) :

            foreach ( $enabled_services as $enabled_service ) :

                // Set URLs
                switch ( $enabled_service ) {
                    case 'facebook':
                        $sharing_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
                        break;
                    case 'twitter':
                        $sharing_url = 'https://twitter.com/home?status=Check%20out%20this%20article:%20' . $title . '%20-%20' . $post_url;
                        break;
                    case 'google-plus':
                        $sharing_url = 'https://plus.google.com/share?url=' . $post_url;
                        break;
                    case 'pinterest':
                        $sharing_url = 'https://pinterest.com/pin/create/button/?url=' .$post_url. '&media=' . $pinterest_image . '&description=' . $title;
                        break;
                    case 'linkedin':
                        $sharing_url = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $post_url;
                        break;
                    case 'whatsapp':
                        $sharing_url = 'whatsapp://send?text=' . $post_url;
                        break;
                }

                if ( 'whatsapp' == $enabled_service && !wp_is_mobile() && !is_admin() ) {

                    continue;

                } else {

                    $icon_size = get_option('sstt_icon_size');
                    $icon_size_class = '';
                    switch ( $icon_size ) {
                        case 'small':
                            $icon_size_class = 'fa-small';
                            break;
                        case 'medium':
                            $icon_size_class = 'fa-lg';
                            break;
                        case 'large':
                            $icon_size_class = 'fa-2x';
                            break;
                        default:
                            $icon_size_class = 'fa-small';
                            break;
                    }


                    /* Display sharing icons */
                    $sharing_box .= '<div class="social-share-link share-' . $enabled_service . ' ">';
                    $sharing_box .= '<a href="' . $sharing_url . '" title="' . __( 'Share on', 'social-share-top-tal' ) . ' ' . ucfirst( $enabled_service ) . '" target="_blank">';

                    $sharing_box .= '<i class="fa fa-' . $enabled_service . ' ' . $icon_size_class . '"></i>';

                    $sharing_box .= '</a>';
                    $sharing_box .= '</div>';

                }

            endforeach;

        endif;
        return $sharing_box;

    }

    public function sstt_sharing_icons_shortcode() {
        $id = get_the_ID();
        $title = get_the_title($id);
        return '<div class="sst_sharing_box sstt_sharing_icon_shortcode">' . $this->sstt_social_sharing_html($title) . '</div>';
    }

    /**
     * Get enabled sharing services
     * @return array|bool
     */
    public function sstt_get_enabled_sharing_services() {

        $sharing_services = Social_Share_Top_Tal::get_sharing_services();

        $enabled_sorted_services = array();

        foreach( $sharing_services as $sharing_service => $default_value ) {
            if ( 'on' == get_option( 'sstt_' . $sharing_service ) ) {
                $position = get_option( 'sstt_' . $sharing_service . '_position' );
                $enabled_services_array[$position] = $sharing_service;
            }
        }

        if ( !empty( $enabled_services_array ) ) {
            ksort($enabled_services_array);

            foreach ($enabled_services_array as $enabled_service) {
                array_push( $enabled_sorted_services, $enabled_service );
            }
            return $enabled_sorted_services;
        }
        else {
            return false;
        }

    }

}
