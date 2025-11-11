<?php

/**
 * JetSmartFilters Apply Button Scroll to Top Feature
 *
 * Adds a control to the JetSmartFilters apply button widget that enables
 * smooth scrolling to the top of the page when the apply button is clicked.
 *
 * @package RunthingsJsfApplyButtonScrollToTop
 */

namespace RunthingsJsfApplyButtonScrollToTop;

/**
 * Class JsfApplyButtonScrollToTop
 *
 * Adds scroll-to-top functionality to JetSmartFilters apply button.
 */
class JsfApplyButtonScrollToTop {
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		// Add controls to the apply button widget BEFORE section_general ends
		// Using the specific element hook with section ID
		add_action(
			'elementor/element/jet-smart-filters-apply-button/section_general/before_section_end',
			[ $this, 'add_controls' ],
			10,
			2
		);

		// Hook into widget render to check settings
		add_action(
			'elementor/frontend/widget/before_render',
			[ $this, 'check_widget_settings' ],
			10,
			1
		);

		// Output script in footer
		add_action(
			'wp_footer',
			[ $this, 'output_scroll_to_top_script' ],
			99
		);
	}

	/**
	 * Add controls to the apply button widget
	 *
	 * @param \Elementor\Element_Base $element The Elementor element.
	 * @param array                   $args    Section arguments.
	 */
	public function add_controls( $element, $args ) {
		$element->add_control(
			'scroll_to_top',
			[
				'label' => __( 'Scroll to Top on Apply', 'runthings-jsf-apply-button-scroll-to-top' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'render_type' => 'template',
			]
		);

		$element->add_control(
			'scroll_target_id',
			[
				'label' => __( 'Scroll Target ID', 'runthings-jsf-apply-button-scroll-to-top' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'e.g., results-section', 'runthings-jsf-apply-button-scroll-to-top' ),
				'description' => __( 'Optional: Enter a fragment ID to scroll to (without #). Defaults to top of window if left blank.', 'runthings-jsf-apply-button-scroll-to-top' ),
				'condition' => [
					'scroll_to_top' => 'yes',
				],
			]
		);
	}

	/**
	 * Check widget settings and log the switcher value
	 *
	 * @param \Elementor\Element_Base $element The Elementor element.
	 */
	public function check_widget_settings( $element ) {
		// Only process apply button widgets
		if ( 'jet-smart-filters-apply-button' !== $element->get_name() ) {
			return;
		}

		$settings = $element->get_settings();
		$scroll_to_top = isset( $settings['scroll_to_top'] ) ? $settings['scroll_to_top'] : 'no';

		error_log( '[JsfApplyButtonScrollToTop] Widget ID: ' . $element->get_id() . ' | scroll_to_top setting: ' . $scroll_to_top );
	}

	/**
	 * Output scroll-to-top script in footer
	 */
	public function output_scroll_to_top_script() {
		// TEMPORARY: Always output the script for now
		// TODO: Remove this and implement proper setting check
		error_log( '[JsfApplyButtonScrollToTop] Outputting script in footer (temporary - always enabled)' );
		echo '<script>' . $this->get_scroll_to_top_script() . '</script>';
	}

	/**
	 * Get the scroll-to-top JavaScript code
	 *
	 * @return string The JavaScript code.
	 */
	private function get_scroll_to_top_script() {
		return <<<'JS'
(function() {
	console.log('[JsfApplyButtonScrollToTop] Script loaded');

	// Find all apply buttons
	var buttons = document.querySelectorAll('.apply-filters__button');
	console.log('[JsfApplyButtonScrollToTop] Found ' + buttons.length + ' apply buttons');

	buttons.forEach(function(btn) {
		console.log('[JsfApplyButtonScrollToTop] Adding click handler to button');
		btn.addEventListener('click', function() {
			console.log('[JsfApplyButtonScrollToTop] Apply button clicked, scrolling to top');
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	});
})();
JS;
	}
}

