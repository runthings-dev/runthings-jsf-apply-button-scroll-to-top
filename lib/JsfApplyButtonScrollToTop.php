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

		// Register script
		add_action(
			'wp_enqueue_scripts',
			[ $this, 'register_scripts' ]
		);

		// Hook into widget render to check settings and add script dependency
		add_action(
			'elementor/frontend/widget/before_render',
			[ $this, 'check_widget_settings' ],
			10,
			1
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
			'runthings_scroll_to_top',
			[
				'label' => __( 'Scroll to top on apply', 'runthings-jsf-apply-button-scroll-to-top' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'render_type' => 'template',
			]
		);

		$element->add_control(
			'runthings_scroll_mode',
			[
				'label' => __( 'Scroll mode', 'runthings-jsf-apply-button-scroll-to-top' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => [
					'auto' => __( 'Auto detect', 'runthings-jsf-apply-button-scroll-to-top' ),
					'window' => __( 'Window top', 'runthings-jsf-apply-button-scroll-to-top' ),
					'query_id' => __( 'Query ID', 'runthings-jsf-apply-button-scroll-to-top' ),
					'custom' => __( 'Custom target ID', 'runthings-jsf-apply-button-scroll-to-top' ),
				],
				'condition' => [
					'runthings_scroll_to_top' => 'yes',
				],
			]
		);

		$element->add_control(
			'runthings_scroll_target_id',
			[
				'label' => __( 'Custom target ID', 'runthings-jsf-apply-button-scroll-to-top' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'e.g., results-section', 'runthings-jsf-apply-button-scroll-to-top' ),
				'description' => __( 'Enter a fragment ID to scroll to (without #).', 'runthings-jsf-apply-button-scroll-to-top' ),
				'condition' => [
					'runthings_scroll_to_top' => 'yes',
					'runthings_scroll_mode' => 'custom',
				],
			]
		);
	}

	/**
	 * Register scripts
	 */
	public function register_scripts() {
		wp_register_script(
			'runthings-jsf-ab-scroll-to-top',
			RUNTHINGS_JSF_AB_SCROLL_PLUGIN_URL . 'assets/js/scroll-to-top.js',
			[],
			RUNTHINGS_JSF_AB_SCROLL_VERSION,
			true
		);
	}

	/**
	 * Check widget settings and add script dependency if needed
	 *
	 * @param \Elementor\Element_Base $element The Elementor element.
	 */
	public function check_widget_settings( $element ) {
		// Only process apply button widgets
		if ( 'jet-smart-filters-apply-button' !== $element->get_name() ) {
			return;
		}

		$settings = $element->get_settings();
		$scroll_to_top = isset( $settings['runthings_scroll_to_top'] ) ? $settings['runthings_scroll_to_top'] : 'no';

		// If widget has scroll-to-top enabled, add script dependency
		if ( 'yes' === $scroll_to_top ) {
			// Add script dependency to this widget instance
			$element->add_script_depends( 'runthings-jsf-ab-scroll-to-top' );

			$mode = isset( $settings['runthings_scroll_mode'] ) ? $settings['runthings_scroll_mode'] : 'auto';
			$custom_target = isset( $settings['runthings_scroll_target_id'] ) ? $settings['runthings_scroll_target_id'] : '';
			$query_id = isset( $settings['query_id'] ) ? $settings['query_id'] : '';

			// Determine single scroll target value
			$scroll_target = $this->determine_scroll_target( $mode, $custom_target, $query_id );

			// Add data attribute to widget wrapper
			$element->add_render_attribute( '_wrapper', 'data-runthings-scroll-target', $scroll_target );
		}
	}

	/**
	 * Determine scroll target based on mode and settings
	 *
	 * @param string $mode          Scroll mode (auto, window, query_id, custom).
	 * @param string $custom_target Custom target ID.
	 * @param string $query_id      Query ID from JSF settings.
	 * @return string Scroll target value.
	 */
	private function determine_scroll_target( $mode, $custom_target, $query_id ) {
		// Strip any leading # from custom target (user might include it despite hint)
		$custom_target = ltrim( $custom_target, '#' );

		switch ( $mode ) {
			case 'window':
				// Empty string = explicit window top
				return '';

			case 'query_id':
				// Use query_id or fallback to window top
				return $query_id ? ltrim( $query_id, '#' ) : '';

			case 'custom':
				// Use custom target or fallback to window top
				return $custom_target ?: '';

			case 'auto':
			default:
				// Special marker for auto-detection
				// Using # prefix ensures it won't clash with user input (since we strip # from user input)
				return '#__AUTO__';
		}
	}
}

