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
class EE_MB_Stretch_Column extends Extension_Base {

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
	 * The description of the current extension
	 *
	 * @since 1.8.0
	 **/
	public static function get_description() {

		$message = '<div class="notice notice-warning inline"><p>';

		$message .= __( 'Adds an option to strecth the column to left or right. Can be found under Advanced &rarr; Advanced &rarr; Stretch Column.', 'elementor-extensions' );
		
		$message .= '</p></div>';

		return $message;
	}

	/**
	 * Add common sections
	 *
	 * @since 1.8.0
	 *
	 * @access protected
	 */
	protected function add_common_sections_actions() {
		
		add_action( 'elementor/element/column/section_advanced/after_section_end', function( $element, $args ) {

			$this->add_common_sections( $element, $args );

		}, 10, 2 );

	}

	/**
	 * Add Controls
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function add_controls( $element, $args ) {

		$element->add_control( 'stretch_column', [
			'label'					=> __( 'Stretch Column', 'elementor-extensions' ),
			'description'			=> '',
			'type'					=> Controls_Manager::SWITCHER,
			'default'				=> '',
			'label_on'				=> __( 'Yes', 'elementor-extensions' ),
			'label_off'				=> __( 'No', 'elementor-extensions' ),
			'return_value'			=> 'yes',
		]);

		$element->add_control(
			'stretch_column_direction', [
				'label'				=> __( 'Stretch Direction', 'elementor-extensions' ),
				'type'				=> Controls_Manager::SELECT,
				'default'			=> '',
				'options'			=> [
					''		=> __( 'None', 'elementor-extensions' ),
					'left'	=> __( 'Left', 'elementor-extensions' ),
					'right'	=> __( 'Right', 'elementor-extensions' ),
				],
				'prefix_class'		=> 'elementor-stretch-column-',
				'render_type'		=> 'template',
				'condition'			=> [
					'stretch_column!' => '',
				],
			]
		);

		$element->add_control(
			'stretch_column_info', [
				'label'				=> '',
				'type'				=> Controls_Manager::RAW_HTML,
				'raw'				=> __( 'Please refresh the page to check the effect.', 'elementor-extensions' ),
				'content_classes'	=> 'elementor-sc-info',
				'condition'			=> [
					'stretch_column!' => '',
					'stretch_column_direction!' => '',
				],
			]
		);

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
		add_action( 'elementor/element/column/section_column_stretch_elementor_controls/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );

		}, 10, 2 );
	}
}