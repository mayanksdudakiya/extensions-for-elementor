<?php

namespace ElementorExtensions\Extensions;

use ElementorExtensions\Base\Extension_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Sticky Extension
 *
 * Adds sticky on scroll capability to widgets and sections
 *
 * @since 0.1.0
 */
class EE_MB_Clickable_Column extends Extension_Base {

	/**
	 * Is Common Extension
	 *
	 * Defines if the current extension is common for all element types or not
	 *
	 * @since 1.8.0
	 * @access protected
	 *
	 * @var bool
	 */
	protected $is_common = true;

	/**
	 * A list of scripts that the widgets is depended in
	 *
	 * @since 1.8.0
	 **/
	public function get_script_depends() {
		return [
			'ee-mb-extension-js',
		];
	}

	/**
	 * Add Controls
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	public function add_controls( $element, $args ) {

		$element->add_control( 'column_link', [
        	'label'       => __( 'Column Link', 'elementor-extensions' ),
			'type'        => Controls_Manager::URL,
			'dynamic'     => [
				'active' => true,
			],
			'placeholder' => __( 'https://your-link.com', 'elementor-extensions' ),
			'selectors' => [ ],
		]);

	}

	public function before_render_options( $element ) {
      
		$settings  = $element->get_settings_for_display();

		if ( isset( $settings['column_link'], $settings['column_link']['url'] ) && ! empty( $settings['column_link']['url'] ) ) {

			wp_enqueue_script( 'make-column-clickable-elementor' );

			$element->add_render_attribute( '_wrapper', 'class', 'make-column-clickable-elementor' );

			$element->add_render_attribute( '_wrapper', 'style', 'cursor: pointer;' );

			$element->add_render_attribute( '_wrapper', 'data-column-clickable', $settings['column_link']['url'] );

			$element->add_render_attribute( '_wrapper', 'data-column-clickable-blank', $settings['column_link']['is_external'] ? '_blank' : '_self' );
		}
    }

	/**
	 * Add Actions
	 *
	 * @since 0.1.0
	 *
	 * @access protected
	 */
	protected function add_actions() {

		// Activate controls for columns
		add_action( 'elementor/element/column/layout/before_section_end', [ $this, 'add_controls'] , 10, 2 );

		add_action( 'elementor/frontend/column/before_render', array( $this, 'before_render_options' ), 10, 2 );
	}

}