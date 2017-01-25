<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.pressmates.net
 * @since      1.0.0
 *
 * @package    Social_Share_Top_Tal
 * @subpackage Social_Share_Top_Tal/admin/partials
 */

$icon_color =  get_option( 'sstt_color_setting' );
?>

<style type="text/css">

    .widgets-holder-wrap .social-service i:before {
        color: <?php echo $icon_color; ?>;
    }

</style>
<div class="wrap social-sharing-settings" id="social-services">

    <h2 class="plugin-heading">
        <?php _e( 'Social Sharing Settings', 'social-share-top-tal' ); ?>
    </h2>
    <p class="description"><?php _e( 'Enable and re-order social sharing services you want by drag-and-drop them in enabled box and re-order them as you like.', 'social-share-top-tal' ); ?></p>
    <br />
    <div class="widget-liquid-left">
        <div id="widgets-left">
            <div class="widgets-holder-wrap">
                <div class="sidebar-name">
                    <h3 align="center"><?php _e( 'Enabled services', 'social-share-top-tal' ); ?></h3>
                </div>
                <div class="sidebar-description">
                    <?php _e( 'Drag and Drop items to re-arrange order of appareance', 'social-share-top-tal' ); ?>
                </div>
                <div id="social-enabled" class="clearfix">
                    <?php
                    // Social Settings
                    $sharing_services = Social_Share_Top_Tal::get_sharing_services();


                    foreach( $sharing_services as $sharing_service => $default_value ) {
                        if ( 'on' == get_option( 'sstt_' . $sharing_service ) ) {
                            $position = get_option( 'sstt_' . $sharing_service . '_position' );
                            $enabled_services_array[$position] = $sharing_service;
                        }
                    }

                    if ( !empty( $enabled_services_array ) ) {
                        ksort($enabled_services_array);

                        foreach ($enabled_services_array as $enabled_service) { ?>
                            <div class="social-service widget" id="<?php echo esc_attr($enabled_service); ?>">
                                <div class="widget-top">
                                    <div class="widget-title">
                                        <i class="fa fa-<?php echo $enabled_service; ?> fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="centered-arrow-rtl">
        <i class="fa fa-angle-double-left fa-3x"></i>
    </div>
    <div class="widget-liquid-right">
        <div class="widgets-holder-wrap">
            <div class="sidebar-name">
                <h3 align="center"><?php _e( 'Inactive services', 'social-share-top-tal' ); ?></h3>
            </div>
            <div class="sidebar-description">
                <?php _e( 'Drag and drop items to "Enabled Services" box to enable them', 'social-share-top-tal' ); ?>
            </div>
            <div id="social-catalog">
                <?php
                // Social Settings
                $sharing_services = Social_Share_Top_Tal::get_sharing_services();


                foreach( $sharing_services as $inactive_sharing_service => $default_value ) {
                    if ( 'on' != get_option( 'sstt_' . $inactive_sharing_service ) ) { ?>
                        <div class="social-service widget" id="<?php echo esc_attr($inactive_sharing_service); ?>">
                            <div class="widget-top">
                                <div class="widget-title">
                                    <i class="fa fa-<?php echo $inactive_sharing_service; ?> fa-2x"></i>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <form method="post" action="options.php">

        <?php settings_fields( 'social-share-settings-group' ); ?>

        <hr />

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e( 'Enable Page Sharing', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_page_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_page_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Enables sharing icons on Pages', 'social-share-top-tal' ); ?></small></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Enable Post Sharing', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_post_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_post_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Enables sharing icons on Posts', 'social-share-top-tal' ); ?></small></td>
            </tr>

            <?php

            $registered_post_types = get_post_types( array( '_builtin' => false ), 'names' );

            if ( !empty( $registered_post_types ) ) { ?>
                <tr valign="top">
                    <th scope="row" colspan="3"><?php _e( 'Enable Sharing on post types:', 'social-share-top-tal' ); ?></th>
                </tr>
                <tr valign="top">
                    <td>
                        <?php foreach ( $registered_post_types as $registered_post_type ) {
                            $checked = '';
                            if ( 'on' == get_option( 'sstt_' . $registered_post_type . '_sharing' ) ) {
                                $checked = 'checked';
                            }
                            echo '<p><input type="checkbox" name="sstt_' . $registered_post_type . '_sharing" value="on" ' . $checked . ' /> ' . $registered_post_type . '</p>';
                        } ?>
                    </td>
                </tr>

                <?php

            }
            ?>
        </table>

        <hr />

        <?php
        //Add hidden element foreach social service
        $sharing_services = Social_Share_Top_Tal::get_sharing_services();

        foreach( $sharing_services as $sharing_service => $default_value ) {
            $value    = get_option( 'sstt_' . $sharing_service );
            $position = get_option( 'sstt_' . $sharing_service . '_position' );
            echo '<input type="hidden" class="' . esc_attr( $sharing_service ) . '" name="sstt_' . esc_attr( $sharing_service ) . '" value="' . esc_attr( $value ) . '">';
            echo '<input type="hidden" class="' . esc_attr( $sharing_service ) . '_pos" name="sstt_' . esc_attr( $sharing_service ) . '_position" value="' . esc_attr( $position ) . '">';
        }
        submit_button( );
        ?>

    </form>
</div>