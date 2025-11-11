<?php

/**
 * Main Plugin Class
 *
 * Initializes the plugin and checks for required dependencies.
 *
 * @package RunthingsJsfScrollToTop
 */

namespace RunthingsJsfScrollToTop;

/**
 * Class Plugin
 *
 * Main plugin initialization class that handles dependency checks.
 */
class Plugin {
	/**
	 * Plugin instance
	 *
	 * @var Plugin
	 */
	private static $instance = null;

	/**
	 * Get plugin instance
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Initialize the plugin
	 */
	private function init() {
		// Check for required dependencies
		if (!$this->check_dependencies()) {
			add_action('admin_notices', [$this, 'show_dependency_notice']);
			return;
		}

		// Load the main feature class
		require_once RUNTHINGS_JSF_SCROLL_PLUGIN_DIR . 'lib/JetSmartFiltersScrollToTop.php';
		new JetSmartFiltersScrollToTop();
	}

	/**
	 * Check if required dependencies are active
	 *
	 * @return bool
	 */
	private function check_dependencies() {
		// Check for Elementor
		if (!did_action('elementor/loaded')) {
			return false;
		}

		// Check for JetSmartFilters
		if (!class_exists('Jet_Smart_Filters')) {
			return false;
		}

		return true;
	}

	/**
	 * Show admin notice when dependencies are missing
	 */
	public function show_dependency_notice() {
		$missing = [];

		if (!did_action('elementor/loaded')) {
			$missing[] = 'Elementor';
		}

		if (!class_exists('Jet_Smart_Filters')) {
			$missing[] = 'JetSmartFilters';
		}

		if (empty($missing)) {
			return;
		}

		$message = sprintf(
			/* translators: %s: comma-separated list of missing plugins */
			__('JSF Apply Button Scroll to Top requires the following plugin(s) to be installed and activated: %s', 'runthings-jsf-apply-button-scroll-to-top'),
			implode(', ', $missing)
		);

		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			esc_html($message)
		);
	}
}

