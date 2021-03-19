<?php
namespace ElementorExtensions\Modules\PropertySchoolCheckerMap;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Module_Base;

class Module extends Module_Base {

	public function get_name() {
		return 'ee-mb-property-school-checker-map';
	}

	public function get_widgets() {
		return [
			'Property_School_Checker_Map',
		];
	}
} 
 