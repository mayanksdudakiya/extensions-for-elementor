<?php 

namespace ElementorExtensions\Includes;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Admin\EE_MB_Setting_Common;

class EE_MB_Single_Property_Shortcode { 
	
	private static $_instance;
	private $isSinglePropertyDisabled;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct(){
		$singleSettings = get_option('ee_mb_cpt_single');

		//add_action('wp_enqueue_scripts', [ $this, 'ee_mb_enqueue_script' ] );

		add_shortcode('ee_mb_single_property_slider', [ $this, 'ee_mb_single_property_page_slider' ] );
		add_action('wp_head', [ $this, 'ee_mb_property_search_custom_style'] );
		add_shortcode('ee_mb_single_property_agent_form', [ $this, 'ee_mb_single_property_agent_form' ] );
		add_shortcode('ee_mb_single_property_school_checker', [ $this, 'ee_mb_single_property_school_checker' ] );
		add_shortcode('ee_mb_single_property_location_map', [ $this, 'ee_mb_single_property_location_map' ] );

		if ( !empty($singleSettings) && in_array('property', $singleSettings) ) :
			$this->isSinglePropertyDisabled = true;
		endif;
	}

    public function ee_mb_enqueue_script() {
     
        $gmap_key = EE_MB_Setting_Common::get_settings_key('ee_mb_integration_setting', 'ee_mb_google_map_key');

        $map_url = 'https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places';
        if(!empty($gmap_key)):
            $map_url = 'https://maps.googleapis.com/maps/api/js?key='.$gmap_key.'&libraries=places';
        endif;
    
        wp_enqueue_script(
            'ee-mb-googlemap-api',
            $map_url,
            [ 
                'jquery', 
            ],
            '',
            true 
        );

        wp_enqueue_script(
            'ee-mb-fancybox-jquery',
            ELEMENTOR_EXTENSIONS_URL . 'assets/lib/fancybox/jquery.fancybox.min.js',
            [ 
                'jquery', 
            ],
            '',
            true 
        );

        wp_enqueue_script(
            'ee-mb-slick',
            ELEMENTOR_EXTENSIONS_URL . 'assets/lib/slick/slick.min.js',
            [ 
                'jquery', 
            ],
            '',
            true 
        );

        wp_enqueue_script(
            'ee-mb-property-single',
            ELEMENTOR_EXTENSIONS_URL . 'assets/js/property-single-page.js',
            [ 
                'jquery', 
            ],
            '',
            true 
        );

        wp_enqueue_style(
            'ee-mb-property-single',
            ELEMENTOR_EXTENSIONS_URL . 'assets/css/property-single.min.css',
            []
        );

        wp_localize_script(
            'ee-mb-googlemap-api',
            'ElementorExtensionsFrontendConfig',
            [
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'elementor-extensions-js' ),
                'ee_mb_path' => ELEMENTOR_EXTENSIONS_URL,
            ]
        );
     
    }

	public function ee_mb_property_search_custom_style(){

	    $agent = EE_MB_Setting_Common::get_settings_key( 'ee_mb_single_page' );

	    if(!empty($agent)):

	      echo '<style type="text/css">';

	      if(!empty($agent->color_scheme)):
	        $color_scheme = $agent->color_scheme;

	        echo '.single_property_page .bg-purple,.single_property_page .slick-prev,.single_property_page .slick-next{background:'.$color_scheme.';}
	        .single_property_page .price-info-wrap h2,.single_property_page .agent-info p a{color:'.$color_scheme.';}
	        .single_property_page .share-links li a{color:'.$color_scheme.';border-color:'.$color_scheme.';}
	        .single_property_page .share-links li a:hover{background-color: '.$color_scheme.';color:#FFF;}
	        .single_property_page .button.btn-submit{background:'.$color_scheme.';border-color:'.$color_scheme.';}
	        .single_property_page .button.btn-submit:focus,.single_property_page .button.btn-submit:hover,.single_property_page .button.btn-submit:active {color: '.$color_scheme.';background:#FFF;}
	        .single_property_page ul.tabs li.current,.single_property_page ul.tabs li:hover{border-color:'.$color_scheme.';}
	        .single_property_page .sold_stc{background-color:'.$color_scheme.';}';
	      endif;

	      if(!empty($agent->font_color_scheme)):
	        $lfc_s = $agent->font_color_scheme;
	        echo '.single_property_page .f-left.banner-name h4,
	        .single_property_page .search-sec h4,
	        .single_property_page .slideCount,
	        .single_property_page .sold_stc,
	        .single_property_page .share-links li a:hover,
	        .single_property_page .button.btn-submit,
	        .single_property_page .slick-prev::before, .single_property_page .slick-next::before
	        {color:'.$lfc_s.'}';
	      endif;

	      echo '</style>';
	    endif;
  	}
  	
    public function ee_mb_single_property_page_slider() {

    	global $post;

    	ob_start();

	    if ( is_single() ) :

    		$post_meta = get_post_meta($post->ID);
    		$property_gallery = (!empty($post_meta['gallery'][0])) ? explode(',',$post_meta['gallery'][0]) : '';

    		if ( !empty($property_gallery) ) :
    		?>
    		<div class="content single_property_page" data-settings='<?php echo $this->ee_mb_settings_for_custom_js(); ?>'>
			    <section class="slider-section">
			        <div class="container slider-container slider-wrp">
			            <div class="slider slider-for">
			            	<div class="slideCount"></div>
				              <?php foreach($property_gallery as $key=>$property_image): 
				               $image = wp_get_attachment_image_src($property_image, 'full');
				               $image = $image[0];

				               $image_metadata = get_post($property_image);
				               $image_caption = '';
				               if(!empty($image_metadata)):
				                $image_caption = (!empty($image_metadata->post_excerpt)) ? $image_metadata->post_excerpt : $image_metadata->post_title ;
				              endif;
			              ?>
				              <div class="slider_item" data-image-caption="<?php echo $image_caption; ?>">
				                <img src="<?php echo esc_url($image); ?>" alt="<?php echo basename($image); ?>"/>
				              </div>
				            <?php endforeach; ?>
				          </div>
			          
			          <div class="bg-purple info-section">
			            <div class="f-left banner-name">
			              <h4 id="slider_caption_text"></h4>
			            </div>
			            <div class="f-right search-sec btn_enlarge" id="btn_enlarge">
			              <h4><i class="fa fa-search"></i> Enlarge </h4>
			            </div>
			          </div> 

			          <div class="slider slider-nav" style="width: 100%;">
			            <?php 
			            foreach($property_gallery as $key=>$property_image): 
			              $image = wp_get_attachment_image_src($property_image, 'full');
			              $image = $image[0];
			              ?>
			              <div>
			                <img src="<?php echo esc_url($image); ?>" alt="<?php echo basename($image); ?>"/>
			              </div>
			            <?php endforeach; ?>
			          </div>
			        </div>
			    </section>
			</div>
		    <?php
			endif;

    	else:
    		echo 'Please use this shortcode in single property page template';
    	endif;

    	return ob_get_clean();
    }

    public function ee_mb_single_property_agent_form() {

    	global $post;

    	if ( is_single() ) :

    	 $post_meta = get_post_meta($post->ID);

    	 $ee_mb_agent = EE_MB_Setting_Common::get_settings_key( 'ee_mb_agent' );

  		 $default_agent = (isset($ee_mb_agent->default_agent)) ? $ee_mb_agent->default_agent : '';

    	 $property_agent = (!empty($post_meta['agent'][0])) ? $post_meta['agent'][0] : $default_agent;

          $agent_meta = get_post_meta($property_agent);

          $agent_name = $agent_email = $agent_phone = $agent_profile = '';
          
          if(!empty($agent_meta['email'][0])):
            $agent_email = $agent_meta['email'][0];
          endif;
          ?>
          <div class="content single_property_page" data-settings='<?php echo $this->ee_mb_settings_for_custom_js(); ?>'>
	          <div class="w-25 f-left bg-gray res-w-100">
	            <?php  if(!empty($agent_meta['profile_picture'][0])):
	              $agent_profile =  $agent_meta['profile_picture'][0];
	              $pro_pic_arr = wp_get_attachment_image_src($agent_profile, 'full');
	              $agent_pro_pic = $pro_pic_arr[0];
	              ?>
	              <div class="profile-wrap">
	                <img src="<?php echo $agent_pro_pic; ?>" alt="<?php echo basename($agent_pro_pic); ?>"/>
	              </div>
	            <?php endif; ?>
	            <div class="agent-info">
	              <?php if(!empty($agent_meta['name'][0])):
	                $agent_name = $agent_meta['name'][0];
	                ?>
	                <p>Your agent for this property is:
	                  <a href="<?php echo (!empty($agent_meta['email'][0])) ? 'mailto:'.$agent_meta['email'][0] : 'javascript:void(0);' ?>"><?php echo $agent_name; ?></a>
	                </p>
	              <?php endif; 
	              if(!empty($agent_meta['phone_number'][0])):
	                $agent_phone = $agent_meta['phone_number'][0];
	                ?>
	                <p>For more information on this property please call:
	                  <a href="tel:<?php echo $agent_phone; ?>"><?php echo $agent_phone; ?></a>
	                </p>
	              <?php endif; ?>
	              <p>Or fill in the form below and  the agent will contact you:
	              </p>
	            </div>

	            <div class="contact-from-wrap">
	              <fieldset>
	                <form action="" method="post" id="agent_contact_form">
	                  <div class="form-group">
	                    <input type="text" id="name" name="txt_name" value="" placeholder="Name" class="input-field form-control ccm-input-text" required=""/>
	                  </div>
	                  <div class="form-group">
	                    <input type="email" id="email" placeholder="Email" name="txt_email" value="" class="input-field form-control ccm-input-email" required=""/>
	                  </div>
	                  <div class="form-group">
	                    <input type="tel" id="telephone" placeholder="Phone Number" name="txt_tel" value="" class="input-field form-control ccm-input-tel" required=""/>
	                  </div>
	                  <div class="form-group">
	                    <textarea id="message" name="txt_message" placeholder="Message" rows="5" class="input-field input-field--textarea form-control" required=""></textarea>
	                  </div>
	                  <input type="hidden" id="property_link" name="property_link" value="<?php echo get_the_permalink(); ?>"/>
	                  <div class="form-actions">
	                    <button type="submit" name="Submit" id="btn_send_agent" class="button button--full btn-submit">Send</button>
	                  </div>
	                </form>
	              </fieldset>
	            </div>
	          </div>
	         </div>
          <?php
    	else:
    		echo 'Please use this shortcode in single property page template';
    	endif;
    }

    public function ee_mb_single_property_school_checker() {
    	ob_start();
    	?>
    	<div class="content single_property_page" data-settings='<?php echo $this->ee_mb_settings_for_custom_js(); ?>'>
    		<div id="ee-mb-map" style="width:900px; height:600px;"></div>
    	</div>
    	<?php
    	return ob_get_clean();
    }

     public function ee_mb_single_property_location_map() {
    	
    	ob_start();

    	$post_id = get_the_ID();
		
		$post_meta = get_post_meta($post_id);

    	$property_location_map = (!empty($post_meta['location'][0])) ? unserialize($post_meta['location'][0]) : '';

    	if(!empty($property_location_map['lat']) && !empty($property_location_map['lng'])): 
            $frame_url = 'https://maps.google.com/maps?q='.$property_location_map['lat'].','.$property_location_map['lng'].'&hl=es;z=14&amp;output=embed';
          ?>
            <div class="content single_property_page" data-settings='<?php echo $this->ee_mb_settings_for_custom_js(); ?>'>
          		<div class="map-cont">
	    			<iframe src="<?php echo $frame_url; ?>" frameborder="0" style="border:0;" allowfullscreen></iframe>
	    		</div>
	    	</div>
          <?php 
        endif;

        return ob_get_clean();
    }

    public function ee_mb_settings_for_custom_js() {

    	global $post;

		$post = get_post($post->ID);

		$post_meta = get_post_meta($post->ID);

  		$single_page_settings = EE_MB_Setting_Common::get_settings_key('ee_mb_single_page');
  
  		$ee_mb_agent = EE_MB_Setting_Common::get_settings_key( 'ee_mb_agent' );
 		$default_agent = (isset($ee_mb_agent->default_agent)) ? $ee_mb_agent->default_agent : '';
 
  		$property_agent = (!empty($post_meta['agent'][0])) ? $post_meta['agent'][0] : $default_agent;

		$settings['school_checker_tab'] = $school_checker_tab = (!empty($single_page_settings->school_checker)) ? $single_page_settings->school_checker : '';

		$settings['addresses'] = (!empty($post_meta['location'][0])) ? unserialize($post_meta['location'][0]) : '';

		$agent_meta = get_post_meta($property_agent);

		$agent_email = '';
		if(!empty($agent_meta['email'][0])):
			$settings['agent_email'] = $agent_meta['email'][0];
		endif;

		return $map_settings = json_encode($settings);
    }
    
}



// if ( !function_exists('ee_mb_property_single_page_agent_form') ) :

// 	do_shortcode('ee_mb_property_agent_form', 'ee_mb_property_single_page_agent_form');

// 	function ee_mb_property_single_page_agent_form(){
// 		global $post;
// 	}
// endif;

