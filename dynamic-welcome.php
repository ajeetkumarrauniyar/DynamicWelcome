<?php

/**
 * Plugin Name: Dynamic Welcome
 * Plugin URI: https://github.com/ajeetkumarrauniyar/DynamicWelcome
 * Description: Displays a personalized greeting message based on user and time.
 * Version: 1.0
 * Author: Ajeet Kumar
 * License: GPLv2 or later
 * Text Domain: dynamic-welcome
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Registers the shortcode.
 */
function dwp_register_greeting_shortcode()
{
  add_shortcode('dynamic_welcome', 'dwp_display_greeting_message');
}

add_action('init', 'dwp_register_greeting_shortcode');

/**
 * Displays the personalized greeting message based on user and time.
 *
 * @return string The greeting message.
 */
function dwp_display_greeting_message()
{
  $current_time = current_time('H:i');

  // Check if user is logged in using a WordPress core function
  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $greeting = 'Good ';

    if ($current_time >= '05:00' && $current_time < '12:00') {
      $greeting .= 'Morning, ';
    } elseif ($current_time >= '12:00' && $current_time < '17:00') {
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

