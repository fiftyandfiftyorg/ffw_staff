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