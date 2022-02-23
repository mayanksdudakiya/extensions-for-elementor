<?php
namespace ElementorExtensions\Includes;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use ElementorExtensions\Base\Extension_Base;

class EE_MB_Extensions_Manager {

	private $_extensions = null;
	private static $_instance;

	public function __construct() {
		$this->require_files();
		$this->register_extensions();
        //add_action( 'elementor/controls/controls_registered', array( $this, 'register_extensions' ), 10 );
    }


	/**
	 * Loops though available extensions and registers them
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 * @return void
	 */
	public function register_extensions() {

		$this->_extensions = [];

		$extensionsList = array(
            'ee-mb-stretch-column' => 'EE_MB_Stretch_Column',
            'ee-mb-clickable-column' => 'EE_MB_Clickable_Column',
        );

        foreach ( $extensionsList as $control_id => $class_name ) {
        	if ( $this->include_extensions( $class_name ) ) {
	            $class_name = 'ElementorExtensions\Extensions\\'.$class_name;
	            $this->register_extension( $control_id, new $class_name() );
	        }
        }
	}

	public function include_extensions( $class_name ) {

        $create_filename = str_replace('_','-',strtolower($class_name));
        $filename = 'extensions/'.$create_filename.'.php';

        if ( ! file_exists( ELEMENTOR_EXTENSIONS_PATH.$filename )) {
            return false;
        }

        require_once ELEMENTOR_EXTENSIONS_PATH.$filename;

        return true;
    }

	/**
	 * @since 0.1.0
	 *
	 * @param $extension_id
	 * @param Extension_Base $extension_instance
	 */
	public function register_extension( $extension_id, Extension_Base $extension_instance ) {
		$this->_extensions[ $extension_id ] = $extension_instance;
	}

	/**
	 * @since 0.1.0
	 *
	 * @param $extension_id
	 * @return bool
	 */
	public function unregister_extension( $extension_id ) {
		if ( ! isset( $this->_extensions[ $extension_id ] ) ) {
			return false;
		}

		unset( $this->_extensions[ $extension_id ] );

		return true;
	}

	/**
	 * @since 0.1.0
	 *
	 * @return Extension_Base[]
	 */
	public function get_extensions() {
		if ( null === $this->_extensions ) {
			$this->register_extensions();
		}

		return $this->_extensions;
	}

	/**
	 * @since 0.1.0
	 *
	 * @param $extension_id
	 * @return bool|\ElementorStretchColumn\Extension_Base
	 */
	public function get_extension( $extension_id ) {
		$extensions = $this->get_extensions();

		return isset( $extensions[ $extension_id ] ) ? $extensions[ $extension_id ] : false;
	}

	private function require_files() {
		require_once ELEMENTOR_EXTENSIONS_PATH . 'base/extension-base.php';
	}

	public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}