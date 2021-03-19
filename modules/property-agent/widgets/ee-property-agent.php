<?php
namespace ElementorExtensions\Modules\PropertyAgent\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use ElementorExtensions\Admin\EE_MB_Setting_Common;
use ElementorExtensions\Classes\Utils;

class EE_Property_Agent extends Base_Widget {

	public function get_name() {
		return $this->widget_name_prefix.'property-agent';
	}

	public function get_title() {
		return __( 'Property Agent', 'elementor-extensions' );
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_keywords() {
		return [ 'p', 'pro', 'pa', 'agent', 'property' ];
	}
	
	protected function _register_controls() {
		
		
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		global $post;

    	 $post_meta = get_post_meta($post->ID);

    	 $ee_mb_agent = EE_MB_Setting_Common::get_settings_key( 'ee_mb_agent' );

  		 $default_agent = (isset($ee_mb_agent->default_agent)) ? $ee_mb_agent->default_agent : '';

    	 $property_agent = (!empty($post_meta['agent'][0])) ? $post_meta['agent'][0] : $default_agent;

          $agent_meta = get_post_meta($property_agent);

          $agent_name = $agent_email = $agent_phone = $agent_profile = '';
          
          $agent_settings = [];
          if(!empty($agent_meta['email'][0])):
            $agent_settings['agent_email'] = $agent_email = $agent_meta['email'][0];
          endif;
          ?>
          <div class="content single_property_page agent_form" data-settings='<?php echo json_encode($agent_settings); ?>'>
	          <div class="f-left bg-gray res-w-100">
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
	}

	protected function _content_template() {
		
	}	
}
