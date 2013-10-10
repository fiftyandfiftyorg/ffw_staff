<?php
/**
 * Post Type Functions
 *
 * @package     FFW
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers and sets up the Downloads custom post type
 *
 * @since 1.0
 * @return void
 */
function setup_ffw_staff_post_types() {

	$archives = defined( 'FFW_STAFF_DISABLE_ARCHIVE' ) && FFW_STAFF_DISABLE_ARCHIVE ? false : true;
	$slug     = defined( 'FFW_STAFF_SLUG' ) ? FFW_STAFF_SLUG : 'staff';
	$rewrite  = defined( 'FFW_STAFF_DISABLE_REWRITE' ) && FFW_STAFF_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

	$staff_labels =  apply_filters( 'ffw_staff_staff_labels', array(
		'name' 				=> '%2$s',
		'singular_name' 	=> '%1$s',
		'add_new' 			=> __( 'Add New', 'FFW_staff' ),
		'add_new_item' 		=> __( 'Add New %1$s', 'FFW_staff' ),
		'edit_item' 		=> __( 'Edit %1$s', 'FFW_staff' ),
		'new_item' 			=> __( 'New %1$s', 'FFW_staff' ),
		'all_items' 		=> __( 'All %2$s', 'FFW_staff' ),
		'view_item' 		=> __( 'View %1$s', 'FFW_staff' ),
		'search_items' 		=> __( 'Search %2$s', 'FFW_staff' ),
		'not_found' 		=> __( 'No %2$s found', 'FFW_staff' ),
		'not_found_in_trash'=> __( 'No %2$s found in Trash', 'FFW_staff' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( '%2$s', 'FFW_staff' )
	) );

	foreach ( $staff_labels as $key => $value ) {
	   $staff_labels[ $key ] = sprintf( $value, ffw_staff_get_label_singular(), ffw_staff_get_label_plural() );
	}

	$staff_args = array(
		'labels' 			=> $staff_labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'rewrite' 			=> $rewrite,
		'map_meta_cap'      => true,
		'has_archive' 		=> $archives,
		'show_in_nav_menus'	=> true,
		'hierarchical' 		=> false,
		'supports' 			=> apply_filters( 'ffw_staff_supports', array( 'title', 'editor', 'thumbnail', 'excerpt' ) ),
	);
	register_post_type( 'FFW_staff', apply_filters( 'ffw_staff_post_type_args', $staff_args ) );
	
}
add_action( 'init', 'setup_ffw_staff_post_types', 1 );

/**
 * Get Default Labels
 *
 * @since 1.0.8.3
 * @return array $defaults Default labels
 */
function ffw_staff_get_default_labels() {
	$defaults = array(
	   'singular' => __( 'Staff', 'FFW_staff' ),
	   'plural' => __( 'Staff', 'FFW_staff')
	);
	return apply_filters( 'ffw_staff_default_name', $defaults );
}

/**
 * Get Singular Label
 *
 * @since 1.0.8.3
 * @return string $defaults['singular'] Singular label
 */
function ffw_staff_get_label_singular( $lowercase = false ) {
	$defaults = ffw_staff_get_default_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0.8.3
 * @return string $defaults['plural'] Plural label
 */
function ffw_staff_get_label_plural( $lowercase = false ) {
	$defaults = ffw_staff_get_default_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

/**
 * Change default "Enter title here" input
 *
 * @since 1.4.0.2
 * @param string $title Default title placeholder text
 * @return string $title New placeholder text
 */
function ffw_staff_change_default_title( $title ) {
     $screen = get_current_screen();

     if  ( 'ffw_staff' == $screen->post_type ) {
     	$label = ffw_staff_get_label_singular();
        $title = sprintf( __( 'Enter %s title here', 'FFW_staff' ), $label );
     }

     return $title;
}
add_filter( 'enter_title_here', 'ffw_staff_change_default_title' );

/**
 * Registers the custom taxonomies for the downloads custom post type
 *
 * @since 1.0
 * @return void
*/
function ffw_staff_setup_taxonomies() {

	$slug     = defined( 'FFW_STAFF_SLUG' ) ? FFW_STAFF_SLUG : 'staff';

	/** Categories */
	$category_labels = array(
		'name' 				=> sprintf( _x( '%s Categories', 'taxonomy general name', 'FFW_staff' ), ffw_staff_get_label_singular() ),
		'singular_name' 	=> _x( 'Category', 'taxonomy singular name', 'FFW_staff' ),
		'search_items' 		=> __( 'Search Categories', 'FFW_staff'  ),
		'all_items' 		=> __( 'All Categories', 'FFW_staff'  ),
		'parent_item' 		=> __( 'Parent Category', 'FFW_staff'  ),
		'parent_item_colon' => __( 'Parent Category:', 'FFW_staff'  ),
		'edit_item' 		=> __( 'Edit Category', 'FFW_staff'  ),
		'update_item' 		=> __( 'Update Category', 'FFW_staff'  ),
		'add_new_item' 		=> __( 'Add New Category', 'FFW_staff'  ),
		'new_item_name' 	=> __( 'New Category Name', 'FFW_staff'  ),
		'menu_name' 		=> __( 'Categories', 'FFW_staff'  ),
	);

	$category_args = apply_filters( 'ffw_staff_category_args', array(
			'hierarchical' 		=> true,
			'labels' 			=> apply_filters('ffw_staff_category_labels', $category_labels),
			'show_ui' 			=> true,
			'query_var' 		=> 'staff_category',
			'rewrite' 			=> array('slug' => $slug . '/category', 'with_front' => false, 'hierarchical' => true ),
			'capabilities'  	=> array( 'manage_terms','edit_terms', 'assign_terms', 'delete_terms' ),
			'show_admin_column'	=> true
		)
	);
	register_taxonomy( 'staff_category', array('ffw_staff'), $category_args );
	register_taxonomy_for_object_type( 'staff_category', 'ffw_staff' );

}
add_action( 'init', 'ffw_staff_setup_taxonomies', 0 );



/**
 * Updated Messages
 *
 * Returns an array of with all updated messages.
 *
 * @since 1.0
 * @param array $messages Post updated message
 * @return array $messages New post updated messages
 */
function ffw_staff_updated_messages( $messages ) {
	global $post, $post_ID;

	$url1 = '<a href="' . get_permalink( $post_ID ) . '">';
	$url2 = ffw_staff_get_label_singular();
	$url3 = '</a>';

	$messages['FFW_staff'] = array(
		1 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'FFW_staff' ), $url1, $url2, $url3 ),
		4 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'FFW_staff' ), $url1, $url2, $url3 ),
		6 => sprintf( __( '%2$s published. %1$sView %2$s%3$s.', 'FFW_staff' ), $url1, $url2, $url3 ),
		7 => sprintf( __( '%2$s saved. %1$sView %2$s%3$s.', 'FFW_staff' ), $url1, $url2, $url3 ),
		8 => sprintf( __( '%2$s submitted. %1$sView %2$s%3$s.', 'FFW_staff' ), $url1, $url2, $url3 )
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'ffw_staff_updated_messages' );
