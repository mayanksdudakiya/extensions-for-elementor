<?php
namespace ElementorExtensions\Modules\PropertySlider;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Module_Base;

class Module extends Module_Base {

	public function get_name() {
		return 'ee-mb-property-slider';
	}

	public function get_widgets() {
		return [
			'Property_Slider',
		];
	}
} 
 