<?php
namespace ElementorExtensions\Includes;

if ( ! defined( 'ABSPATH' ) ) exit;

class EE_MB_Custom_Form {

    private static $_instance;

	public function __construct()
	{
		add_action( 'elementor/element/form/section_form_fields/before_section_end', [ $this, 'add_controls' ], 10, 2 );	
		add_action( 'elementor_pro/forms/validation', [ $this, 'show_validations_above_the_form' ], 10, 2 );	
	}

	public function add_controls( $form, $args )
	{
		$form->add_control(
			'validation_above_form',
			[
				'label' => __( 'Validation Above Form', 'elementor-extension' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-extension' ),
				'label_off' => __( 'No', 'elementor-extension' ),
				'return_value' => 'yes',
				'default' => 'no',
				'label_block' => false
			]
		);
	}

	public function show_validations_above_the_form($record, $ajax_handler)
	{
		if (!empty($ajax_handler->errors) && $record->get_form_settings( 'validation_above_form' ) === 'yes') :

			$replaceErrors = '';

			foreach ($ajax_handler->errors as $key => $error) :

				$fieldName = str_replace('_', ' ', $key);

				$fieldName = ucfirst($fieldName);

				$error = str_replace('This', $fieldName, $error);

				$replaceErrors .= $error.'<br/><br/>';
				
				$ajax_handler->add_error($key, '');
				
			endforeach;

			$ajax_handler->add_error( 'validation', $replaceErrors );

		endif;
	}

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}
