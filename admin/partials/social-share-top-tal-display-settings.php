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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
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
?>
<div class="wrap social-sharing-display">

    <h2 class="plugin-heading">
        <?php _e( 'Social Sharing Display Settings', 'social-share-top-tal' ); ?>
    </h2>
    <p class="description">
        <?php _e( 'Adjust social sharing icons position, size and color.', 'social-share-top-tal' ); ?>
    </p>

    <h3><?php _e( 'Sharing Icons Shortcode', 'social-share-top-tal' ); ?> </h3>
    <span style="color: #F00;">[sstt_sharing_icons]</span><br/>
    <small><?php _e( 'Copy and paste this shortcode inside post or page to show sharing icons', 'social-share-top-tal' ); ?></small>

    <form method="post" action="options.php">

        <?php settings_fields( 'social-share-display-group' ); ?>

        <hr />

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e( 'Display icons after title', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_title_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_title_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Displays social share box below title', 'social-share-top-tal' ); ?></small></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Display icons before content', 'social-share-top-tal' ); ?><br /><small style="font-weight: normal;">This is additional icon placement because placing icons below title depends on the theme</small></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_before_content_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_before_content_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Displays social share box above content', 'social-share-top-tal' ); ?></small></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Display icons after content', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_content_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_content_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Displays social share box below content', 'social-share-top-tal' ); ?></small></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Display floating on left', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_floating_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_floating_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Displays social share box floating on left side', 'social-share-top-tal' ); ?></small></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php _e( 'Display over featured image', 'social-share-top-tal' ); ?></th>
                <?php
                $checked = '';
                if ( 'on' == get_option( 'sstt_image_sharing' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-checkbox"><input type="checkbox" name="sstt_image_sharing" value="on" <?php echo $checked; ?> /></td>
                <td><small><?php _e( 'Displays social share box over featured image', 'social-share-top-tal' ); ?></small></td>
            </tr>
        </table>

        <hr />

        <h3><?php _e( 'Sharing Icons Size', 'social-share-top-tal' ); ?></h3>
        <small><?php _e( 'Select size for sharing icons', 'social-share-top-tal' ); ?></small>
        <hr />

        <?php
        $icon_color =  get_option( 'sstt_color_setting' );
        if( $icon_color != '' ) {
            ?>

            <style type="text/css">

                .sharing-icon-size-table i:before {
                    color: <?php echo $icon_color; ?>!important;
                }

            </style>

            <?php
        }
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
        }
        ?>

        <table class="form-table sharing-icon-size-table">
            <tr valign="top">
                <?php
                $checked = '';
                if ( 'small' == get_option( 'sstt_icon_size' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-radio">
                    <input type="radio" name="sstt_icon_size" value="small" <?php echo $checked; ?> />
                </td>
                <td>
                    <?php
                    if ( !empty( $enabled_services_array ) ) {
                        foreach ($enabled_services_array as $enabled_service) { ?>
                            <i class="fa fa-<?php echo $enabled_service; ?> fa-lg"></i>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <?php
                $checked = '';
                if ( 'medium' == get_option( 'sstt_icon_size' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-radio">
                    <input type="radio" name="sstt_icon_size" value="medium" <?php echo $checked; ?> />
                </td>
                <td>
                    <?php
                    if ( !empty( $enabled_services_array ) ) {
                        foreach ($enabled_services_array as $enabled_service) { ?>
                            <i class="fa fa-<?php echo $enabled_service; ?> fa-2x"></i>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <?php
                $checked = '';
                if ( 'large' == get_option( 'sstt_icon_size' ) ) {
                    $checked = 'checked';
                }
                ?>
                <td class="input-radio">
                    <input type="radio" name="sstt_icon_size" value="large" <?php echo $checked; ?> />
                </td>
                <td>
                    <?php
                    if ( !empty( $enabled_services_array ) ) {
                        foreach ($enabled_services_array as $enabled_service) { ?>
                            <i class="fa fa-<?php echo $enabled_service; ?> fa-3x"></i>
                            <?php
                        }
                    }
                    ?>
                </td>
            </tr>

        </table>

        <br />

        <hr />

        <h3><?php _e( 'Sharing Icons Color', 'social-share-top-tal' ); ?></h3>
        <small><?php _e( 'Select color for all sharing icons if you don\'t want default', 'social-share-top-tal' ); ?></small>

        <hr />

        <table class="form-table">
            <tr valign="top">
                <td class="input-checkbox">
                    <input name="sstt_color_setting" type="text"  class="icon-color" value="<?php echo $icon_color; ?>" size="30" />
                </td>
            </tr>
        </table>

        <hr>

        <?php submit_button( ); ?>

    </form>
</div>