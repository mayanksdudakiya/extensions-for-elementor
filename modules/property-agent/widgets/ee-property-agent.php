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
		
		/*@Content Start */
		$this->start_controls_section(
            'content',
            [
                'label' => __( 'Content', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_CONTENT,
				'show_label' => true,
            ]
		);

		$this->add_control(
			'agent_text',
			[
				'label'       => __( 'Agent Text', 'elementor-extensions' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Your agent for this property is:', 'elementor-extensions' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'more_info_text',
			[
				'label'       => __( 'More Info Text', 'elementor-extensions' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('For more information on this property please call:', 'elementor-extensions' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => __( 'Description', 'elementor-extensions' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __('Or fill in the form below and  the agent will contact you:', 'elementor-extensions' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'elementor-extensions' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Send', 'elementor-extensions' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'form_success_msg',
			[
				'label'       => __( 'Form Success Message', 'elementor-extensions' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __('Your message have been sent successfully.', 'elementor-extensions' ),
				'label_block' => true,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
            'form_style',
            [
                'label' => __( 'Form', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => true,
            ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'form_background',
				'label' => __( 'Background', 'elementor-extensions' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .single_property_page.agent_form .bg-gray',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'show_label' => true,
				'display_block' => true,
				'selector' => '{{WRAPPER}} .single_property_page.agent_form',
			]
		);

		$this->add_control(
			'form_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'inner_border_heading',
			[
				'label' => __( 'Inner Border', 'elementor-extensions' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_inner_border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'show_label' => true,
				'display_block' => true,
				'selector' => '{{WRAPPER}} .single_property_page.agent_form fieldset',
			]
		);

		$this->add_responsive_control(
			'form_padding',
			[
				'label' => __( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_margin',
			[
				'label' => __( 'Margin', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'field_style',
            [
                'label' => __( 'Input', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => true,
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'label' => __( 'Typographpy', 'elementor-extensions' ),
				'selector' => '{{WRAPPER}} .single_property_page.agent_form input, {{WRAPPER}} .single_property_page.agent_form textarea',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'field_background',
				'label' => __( 'Background', 'elementor-extensions' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .single_property_page.agent_form input, {{WRAPPER}} .single_property_page.agent_form textarea',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'field_border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'show_label' => true,
				'selector' => '{{WRAPPER}} .single_property_page.agent_form input, {{WRAPPER}} .single_property_page.agent_form textarea',
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form input' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .single_property_page.agent_form textarea' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label' => __( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .single_property_page.agent_form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_margin',
			[
				'label' => __( 'Margin', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .single_property_page.agent_form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'button_style',
            [
                'label' => __( 'Button', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => true,
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typographpy', 'elementor-extensions' ),
				'selector' => '{{WRAPPER}} .single_property_page.agent_form button',
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'button_bg_hover_color',
			[
				'label' => __( 'Background Hover Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button' => 'color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Hover Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button:hover' => 'color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'show_label' => true,
				'selector' => '{{WRAPPER}} .single_property_page.agent_form button',
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label' => __( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_margin',
			[
				'label' => __( 'Margin', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'error_message_style',
            [
                'label' => __( 'Error Message', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => true,
            ]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'error_message_typography',
				'label' => __( 'Typographpy', 'elementor-extensions' ),
				'selector' => '{{WRAPPER}} .single_property_page.agent_form .form_error',
			]
		);

		$this->add_control(
			'error_message_color',
			[
				'label' => __( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form .form_error' => 'color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_responsive_control(
			'error_message_padding',
			[
				'label' => __( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form .form_error' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'error_message_margin',
			[
				'label' => __( 'Margin', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .single_property_page.agent_form .form_error' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
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
	                <p><?php echo (!empty($settings['agent_text'])) ? $settings['agent_text'] : ''; ?>
	                  <a href="<?php echo (!empty($agent_meta['email'][0])) ? 'mailto:'.$agent_meta['email'][0] : 'javascript:void(0);' ?>"><?php echo $agent_name; ?></a>
	                </p>
	              <?php endif; 
	              if(!empty($agent_meta['phone_number'][0])):
	                $agent_phone = $agent_meta['phone_number'][0];
	                ?>
	                <p><?php echo (!empty($settings['more_info_text'])) ? $settings['more_info_text'] : ''; ?>
	                  <a href="tel:<?php echo $agent_phone; ?>"><?php echo $agent_phone; ?></a>
	                </p>
				  <?php endif; 
						if (!empty($settings['description'])):
							echo '<p>'.$settings['description'].'</p>';
						endif;
				 ?>
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
					  
					  <?php if ( !empty($settings['button_text']) ): ?>
	                  <div class="form-actions">
	                    <button type="submit" name="Submit" id="btn_send_agent" class="button button--full btn-submit"><?php echo $settings['button_text']; ?></button>
					  </div>
					  <?php endif; ?>
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
