<?php

/**
 * Dynamic Welcome
 * 
 * @package           DynamicWelcome
 * @link             https://github.com/ajeetkumarrauniyar/DynamicWelcome
 * @author            Ajeet Kumar
 * @since             1.0.0
 * @copyright         2023 Ajeet Kumar
 * @license           GPL-2.0-or-later
 * 
 * @wordpress-plugin
 * Plugin Name: Dynamic Welcome
 * Plugin URI: https://github.com/ajeetkumarrauniyar/DynamicWelcome
 * Description: Displays a personalized greeting message based on user and time.
 * Version: 1.0.2
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Author: Ajeet Kumar
 * Author URI: https://github.com/ajeetkumarrauniyar
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dynamic-welcome
 * Domain Path: /languages  
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
  exit;
}

/**
 * Current plugin version.
 */
define('DYNAMIC_WELCOME_VERSION', '1.0.3');

/**
 * Main plugin class.
 */
class Dynamic_Welcome
{

  /**
   * Instance of the plugin.
   *
   * @var Dynamic_Welcome
   */
  private static $instance;

  /**
   * Initialize the plugin.
   */
  public function __construct()
  {
    $this->load_dependencies();
    $this->define_admin_hooks();
  }

  /**
   * Load the required dependencies.
   */
  private function load_dependencies()
  {
    require_once plugin_dir_path(__FILE__) . 'includes/class-dynamic-welcome-loader.php';
    require_once plugin_dir_path(__FILE__) . 'admin/class-dynamic-welcome-admin.php';
  }

  /**
   * Define the admin hooks.
   */
  private function define_admin_hooks()
  {
    $plugin_admin = new Dynamic_Welcome_Admin();

    add_action('admin_menu', array($plugin_admin, 'register_admin_menu'));
    add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_admin_styles'));
  }

  /**
   * Run the plugin.
   */
  public function run()
  {
    $this->register_greeting_shortcode();
  }

  /**
   * Registers the shortcode.
   */
  private function register_greeting_shortcode()
  {
    add_shortcode('greeting_message', array($this, 'display_greeting_message'));
  }

  /**
   * Displays the personalized greeting message based on user and time.
   *
   * @return string The greeting message.
   */
  public function display_greeting_message()
  {
    $current_time = current_time('H:i');

    // Check if user is logged in using a WordPress core function
    if (is_user_logged_in()) {
      $user     = wp_get_current_user();
      $greeting = 'Good ';

      if ('05:00' <= $current_time && $current_time < '12:00') {
        $greeting .= 'Morning, ';
      } elseif ('12:00' <= $current_time && $current_time < '17:00') {
        $greeting .= 'Afternoon, ';
      } else {
        $greeting .= 'Evening, ';
      }

      $greeting .= $user->display_name . '!';
    } else {
      $greeting = 'Welcome, Guest!';
    }

    // Security: Sanitize output before displaying
    $greeting = sanitize_text_field($greeting);

    return $greeting;
  }

  /**
   * Returns the instance of the plugin.
   *
   * @return Dynamic_Welcome
   */
  public static function get_instance()
  {
    if (null === self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }
}

/**
 * Begins execution of the plugin.
 */
function run_dynamic_welcome()
{
  $plugin = new Dynamic_Welcome();
  $plugin->run();
}

// !ERROR: Calling this function breaks the plugin
// run_dynamic_welcome(); 

/**
 * Plugin activation.
 */
function activate_dynamic_welcome()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-dynamic-welcome-activator.php';
  Dynamic_Welcome_Activator::activate();
}

/**
 * Plugin deactivation.
 */
function deactivate_dynamic_welcome()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-dynamic-welcome-deactivator.php';
  Dynamic_Welcome_Deactivator::deactivate();
}

// register_activation_hook( __FILE__, 'activate_dynamic_welcome' );
// register_deactivation_hook(__FILE__, 'deactivate_dynamic_welcome');


/**
 * Admin-related functions and hooks.
 */

/**
 * Register the Top-Level Menu and Sub-Menus
 */
function dwp_register_admin_menu()
{
  $top_level_menu = add_menu_page(
    'Dynamic Welcome', // Page title
    'Dynamic Welcome', // Menu title
    'manage_options', // Capability required
    'dynamic-welcome', // Menu slug
    'dwp_display_plugin_page', // Callback function
    'dashicons-universal-access-alt', // Icon URL (or dashicons helper)
    26 // Position in the menu order
  );

  add_submenu_page(
    'dynamic-welcome', // Menu Slug
    'Dynamic Welcome Settings', // Page title
    'Settings', // Menu title
    'manage_options', // Capability required
    'dynamic-welcome-settings',
    'dwp_display_settings_page' // Callback function
  );
}

add_action('admin_menu', 'dwp_register_admin_menu');

/**
 * Enqueue CSS styles for the admin area
 */
function dwp_enqueue_admin_styles($hook)
{
  if ($hook === 'toplevel_page_dynamic-welcome' || $hook === 'dynamic-welcome_page_dynamic-welcome-settings') {
    wp_enqueue_style('dwp-dynamic-welcome-admin', plugin_dir_url(__FILE__) . 'admin/css/dynamic-welcome-admin.css', array(), DYNAMIC_WELCOME_VERSION);
  }
}

add_action('admin_enqueue_scripts', 'dwp_enqueue_admin_styles');

/**
 * Callback function for the top-level menu "Dynamic Welcome"
 */
function dwp_display_plugin_page()
{
  echo '<h1>Dynamic Welcome</h1>';
  echo '<p>This is the main plugin page.</p>';
}

/**
 * Callback function for the Settings sub-menu page
 */
function dwp_display_settings_page()
{
  echo '<h1>Dynamic Welcome Settings</h1>';
  echo '<p>This is the Settings sub-menu page.</p>';
}
