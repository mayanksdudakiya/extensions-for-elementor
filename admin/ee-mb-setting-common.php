<?php 
namespace ElementorExtensions\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EE_MB_Setting_Common{

	public static function get_settings_key($key, $child_key = null){
		
		$ee_get_key = get_option( $key );
		
	    if( !empty($ee_get_key) ):
	    	
	    	$all_keys = $ee_get_key;
	    	if(!empty($child_key)):
	    		return (isset($all_keys[$child_key])) ? $all_keys[$child_key] : '';
			endif;

			if ( !is_array($all_keys)) :
				$all_keys = json_decode($all_keys);
			endif;

	    	return (array)$all_keys;
	    endif;
	    
	    return new \stdClass();
	}

	/*@ Sanitize whole array */
	public static function sanitize( $input ) {
		// Initialize the new array that will hold the sanitize values
		$new_input = array();
		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) :

			if( $key === 'message' || $key === 'mail_template' || $key === 'overlay_message' || $key === 'script'):
				$new_input[ $key ] = htmlentities($val);
			elseif( $key === 'sender_email' ):
				$new_input[ $key ] = sanitize_email($val);
			else:
				$new_input[ $key ] = sanitize_text_field( $val );	
			endif;

		endforeach;

		return $new_input;
	}
}