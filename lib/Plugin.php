<?php

/**
 * Main Plugin Class
 *
 * Initializes the plugin and checks for required dependencies.
 *
 * @package RunthingsJsfApplyButtonScrollToTop
 */

namespace RunthingsJsfApplyButtonScrollToTop;

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
		require_once RUNTHINGS_JSF_AB_SCROLL_PLUGIN_DIR . 'lib/JsfApplyButtonScrollToTop.php';
		new JsfApplyButtonScrollToTop();
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
			/* translators: 1: plugin name, 2: comma-separated list of missing plugins */
			__('%1$s requires the following plugin(s) to be installed and activated: %2$s', 'runthings-jsf-apply-button-scroll-to-top'),
			RUNTHINGS_JSF_AB_SCROLL_PLUGIN_NAME,
			implode(', ', $missing)
		);

		printf(
			'<div class="notice notice-error"><p>%s</p></div>',
			esc_html($message)
		);
	}
}

