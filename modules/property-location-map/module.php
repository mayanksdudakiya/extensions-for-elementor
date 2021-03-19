<?php
namespace ElementorExtensions\Modules\PropertyLocationMap;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Module_Base;

class Module extends Module_Base {

	public function get_name() {
		return 'ee-mb-property-location-map';
	}

	public function get_widgets() {
		return [
			'Property_Location_Map',
		];
	}
} 
 