<?php

/**
 * Plugin Name: JSF Apply Button Scroll to Top
 * Plugin URI: https://runthings.dev
 * Description: Adds scroll-to-top functionality to JetSmartFilters apply button widget
 * Version: 0.1.0
 * Author: runthingsdev
 * Author URI: https://runthings.dev
 * Requires PHP: 8.0
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Text Domain: runthings-jsf-apply-button-scroll-to-top
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('RUNTHINGS_JSF_SCROLL_VERSION', '0.1.0');
define('RUNTHINGS_JSF_SCROLL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RUNTHINGS_JSF_SCROLL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RUNTHINGS_JSF_SCROLL_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Initialize the plugin
function runthings_jsf_scroll_init() {
    require_once RUNTHINGS_JSF_SCROLL_PLUGIN_DIR . 'lib/Plugin.php';
    return \RunthingsJsfApplyButtonScrollToTop\Plugin::instance();
}

// Hook into WordPress
add_action('plugins_loaded', 'runthings_jsf_scroll_init');

