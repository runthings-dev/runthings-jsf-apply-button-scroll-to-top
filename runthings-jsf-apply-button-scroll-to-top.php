<?php

/**
 * Plugin Name: Apply Button Scroll to Top for JetSmartFilters
 * Plugin URI: https://runthings.dev/wordpress-plugins/jsf-apply-button-back-to-top/
 * Description: Adds scroll-to-top functionality to JetSmartFilters apply button widget
 * Version: 1.0.0
 * Author: runthingsdev
 * Author URI: https://runthings.dev
 * Requires PHP: 8.0
 * Requires at least: 6.6
 * Tested up to: 6.8
 * Text Domain: runthings-jsf-apply-button-scroll-to-top
 * Domain Path: /languages
 * License: GPLv3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('RUNTHINGS_JSF_AB_SCROLL_VERSION', '1.0.0');
define('RUNTHINGS_JSF_AB_SCROLL_PLUGIN_NAME', 'Apply Button Scroll to Top for JetSmartFilters');
define('RUNTHINGS_JSF_AB_SCROLL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RUNTHINGS_JSF_AB_SCROLL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RUNTHINGS_JSF_AB_SCROLL_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Initialize the plugin
function runthings_jsf_scroll_init() {
    require_once RUNTHINGS_JSF_AB_SCROLL_PLUGIN_DIR . 'lib/Plugin.php';
    return \RunthingsJsfApplyButtonScrollToTop\Plugin::instance();
}

// Hook into WordPress
add_action('plugins_loaded', 'runthings_jsf_scroll_init');

