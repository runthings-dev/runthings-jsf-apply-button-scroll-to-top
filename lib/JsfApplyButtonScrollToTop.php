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
	 * Track if any widget has scroll-to-top enabled
	 *
	 * @var bool
	 */
	private $should_enqueue_script = false;

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

		// Enqueue script in footer if needed
		add_action(
			'wp_enqueue_scripts',
			[ $this, 'enqueue_scripts' ],
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
	 * Check widget settings and mark if script should be enqueued
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

		// If any widget has scroll-to-top enabled, mark for script enqueue
		if ( 'yes' === $scroll_to_top ) {
			$this->should_enqueue_script = true;
		}
	}

	/**
	 * Enqueue scripts if needed
	 */
	public function enqueue_scripts() {
		// Only enqueue if at least one widget has scroll-to-top enabled
		if ( ! $this->should_enqueue_script ) {
			return;
		}

		wp_enqueue_script(
			'runthings-jsf-scroll-to-top',
			RUNTHINGS_JSF_SCROLL_PLUGIN_URL . 'assets/js/scroll-to-top.js',
			[],
			RUNTHINGS_JSF_SCROLL_VERSION,
			true
		);
	}
}

