<?php
/**
 * Scripts
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_staff_load_admin_scripts( $hook ) 
{
    global $post,
    $ffw_staff_settings,
    $ffw_staff_settings_page,
    $wp_version;

    $js_dir  = FFW_STAFF_PLUGIN_URL . 'assets/js/';
    $css_dir = FFW_STAFF_PLUGIN_URL . 'assets/css/';

    wp_register_script( 'staff-admin-scripts', $js_dir . 'admin-scripts.js', array('jquery'), '1.0', true );
    //wp_register_style( 'ffw-port-datepicker-style', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', false, FFW_STAFF_VERSION, false );
    //wp_register_style( 'etm-admin-styles', $css_dir . 'etm-admin.css', false, ETM_VERSION, false );

    //wp_enqueue_script( 'jquery-ui-datepicker');
    wp_enqueue_script( 'staff-admin-scripts' );
    wp_localize_script( 'staff-admin-scripts', 'ffw_staff_vars', array(
        'new_media_ui'            => apply_filters( 'ffw_staff_use_35_media_ui', 1 ),
        ) 
    );

    if ( $hook == $ffw_staff_settings_page ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'colorbox', $css_dir . 'colorbox.css', array(), '1.3.20' );
        wp_enqueue_script( 'colorbox', $js_dir . 'jquery.colorbox-min.js', array( 'jquery' ), '1.3.20' );
        if( function_exists( 'wp_enqueue_media' ) && version_compare( $wp_version, '3.5', '>=' ) ) {
            //call for new media manager
            wp_enqueue_media();
        }
    }
    
    //wp_enqueue_style( 'ffw-port-datepicker-style' );
    // wp_enqueue_style( 'etm-admin-styles' );
}
add_action( 'admin_enqueue_scripts', 'ffw_staff_load_admin_scripts', 100 );