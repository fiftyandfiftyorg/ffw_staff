<?php 
/**
 * Plugin Name: Fifty Framework Staff
 * Plugin URI: http://fiftyandfifty.org
 * Description: Build staff pages for your site
 * Version: 1.0
 * Author: Fifty and Fifty
 * Author URI: http://labs.fiftyandfifty.org
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'FFW_STAFF' ) ) :


/**
 * Main FFW_STAFF Class
 *
 * @since 1.0 */
final class FFW_STAFF {

  /**
   * @var FFW_STAFF Instance
   * @since 1.0
   */
  private static $instance;


  /**
   * FFW_STAFF Instance / Constructor
   *
   * Insures only one instance of FFW_STAFF exists in memory at any one
   * time & prevents needing to define globals all over the place. 
   * Inspired by and credit to FFW_STAFF.
   *
   * @since 1.0
   * @static
   * @uses FFW_STAFF::setup_globals() Setup the globals needed
   * @uses FFW_STAFF::includes() Include the required files
   * @uses FFW_STAFF::setup_actions() Setup the hooks and actions
   * @see FFW_STAFF()
   * @return void
   */
  public static function instance() {
    if ( ! isset( self::$instance ) && ! ( self::$instance instanceof FFW_STAFF ) ) {
      self::$instance = new FFW_STAFF;
      self::$instance->setup_constants();
      self::$instance->includes();
      // self::$instance->load_textdomain();
      // use @examples from public vars defined above upon implementation
    }
    return self::$instance;
  }



  /**
   * Setup plugin constants
   * @access private
   * @since 1.0 
   * @return void
   */
  private function setup_constants() {
    // Plugin version
    if ( ! defined( 'FFW_STAFF_VERSION' ) )
      define( 'FFW_STAFF_VERSION', '1.0' );

    // Plugin Folder Path
    if ( ! defined( 'FFW_STAFF_PLUGIN_DIR' ) )
      define( 'FFW_STAFF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

    // Plugin Folder URL
    if ( ! defined( 'FFW_STAFF_PLUGIN_URL' ) )
      define( 'FFW_STAFF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

    // Plugin Root File
    if ( ! defined( 'FFW_STAFF_PLUGIN_FILE' ) )
      define( 'FFW_STAFF_PLUGIN_FILE', __FILE__ );

    if ( ! defined( 'FFW_STAFF_DEBUG' ) )
      define ( 'FFW_STAFF_DEBUG', true );
  }



  /**
   * Include required files
   * @access private
   * @since 1.0
   * @return void
   */
  private function includes() {
    global $ffw_staff_settings, $wp_version;

    require_once FFW_STAFF_PLUGIN_DIR . '/includes/admin/settings/register-settings.php';
    $ffw_staff_settings = ffw_staff_get_settings();

    // Required Plugin Files
    require_once FFW_STAFF_PLUGIN_DIR . '/includes/functions.php';
    require_once FFW_STAFF_PLUGIN_DIR . '/includes/posttypes.php';
    require_once FFW_STAFF_PLUGIN_DIR . '/includes/scripts.php';
    require_once FFW_STAFF_PLUGIN_DIR . '/includes/shortcodes.php';

    if( is_admin() ){
        //Admin Required Plugin Files
        require_once FFW_STAFF_PLUGIN_DIR . '/includes/admin/admin-pages.php';
        require_once FFW_STAFF_PLUGIN_DIR . '/includes/admin/admin-notices.php';
        require_once FFW_STAFF_PLUGIN_DIR . '/includes/admin/settings/display-settings.php';
        require_once FFW_STAFF_PLUGIN_DIR . '/includes/admin/staff/metabox.php';

    }


  }

} /* end FFW_STAFF class */
endif; // End if class_exists check


/**
 * Main function for returning FFW_STAFF Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $sqcash = FFW_STAFF(); ?>
 *
 * @since 1.0
 * @return object The one true FFW_STAFF Instance
 */
function FFW_STAFF() {
  return FFW_STAFF::instance();
}


/**
 * Initiate
 * Run the FFW_STAFF() function, which runs the instance of the FFW_STAFF class.
 */
FFW_STAFF();



/**
 * Debugging
 * @since 1.0
 */
if ( FFW_STAFF_DEBUG ) {
  ini_set('display_errors','On');
  error_reporting(E_ALL);
}


