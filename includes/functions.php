<?php
/**
 * Functions
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_staff_disable_link()
{
    global $ffw_staff_settings;

   $ffw_staff_disable = isset( $ffw_staff_settings['staff_disable_link_to_single'] ) ? true : false;

   return $ffw_staff_disable;
    
}


function ffw_staff_adjust_posts_per_page( $query ) {
    
    global $ffw_staff_settings;

    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_post_type_archive( 'ffw_staff' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        
        $ffw_staff_posts_per_page = isset( $ffw_staff_settings['staff_posts_per_page'] ) ? $ffw_staff_settings['staff_posts_per_page'] : 100;
        
        $query->set( 'posts_per_page', $ffw_staff_posts_per_page );
        
        return;
    }
}
add_action( 'pre_get_posts', 'ffw_staff_adjust_posts_per_page', 1 );