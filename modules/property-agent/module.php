<?php
namespace ElementorExtensions\Modules\PropertyAgent;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Module_Base;

class Module extends Module_Base {

	public function get_name() {
		return 'ee-mb-property-agent';
	}

	public function get_widgets() {
		return [
			'Property_Agent',
		];
	}
} 
 