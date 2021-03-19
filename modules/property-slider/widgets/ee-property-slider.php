<?php
namespace ElementorExtensions\Modules\PropertySlider\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use ElementorExtensions\Admin\EE_MB_Setting_Common;
use ElementorExtensions\Classes\Utils;
 
class EE_Property_Slider extends Base_Widget {

	public function get_name() {
		return $this->widget_name_prefix.'property-slider';
	}

	public function get_title() {
		return __( 'Property Slider', 'elementor-extensions' );
	}

	public function get_icon() {
		return 'eicon-welcome';
	}

	public function get_style_depends() {
		return [ 
			'ee-mb-property-single' 
		];
	}

	public function get_script_depends() {
        return [
            'ee-mb-fancybox-jquery',
            'ee-mb-slick',
        ];
    }

	public function get_keywords() {
		return [ 'p', 'pro', 'ps', 'slider', 'property' ];
	}
	
	protected function _register_controls() {
		
		/*@Content Start */
		$this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Property Slider', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_CONTENT,
				'show_label' => true,
            ]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'Height', 'plugin-domain' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .slider.slider-for .slick-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hide_show_image_name',
			[
				'label' => __( 'Image Name', 'elementor-extensions' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-extensions' ),
				'label_off' => __( 'No', 'elementor-extensions' ),
				'return_value' => 'none',
				'selectors' => [
					'{{WRAPPER}} .info-section .banner-name' => 'display: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/*@ Style Section */
		$this->start_controls_section(
            'section_general_style',
            [
                'label' => __( 'General', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'elementor-extensions' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .info-section.bg-purple',
			]
		);

		$this->add_control(
			'alphabet_color',
			[
				'label' => __( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .info-section.bg-purple h4' => 'color: {{VALUE}}',
					'{{WRAPPER}} .info-section.bg-purple .search-sec h4' => 'color: {{VALUE}}',
					'{{WRAPPER}} .slideCount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'navigation_styles' );

		$this->start_controls_tab( 'navigation_normal',
			[
				'label' => __( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'navigation_color',
			[
				'label' => __( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .slick-prev::before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .slick-next::before' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'navigation_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .slick-prev' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .slick-next' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'navigation_hover',
			[
				'label' => __( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'navigation_hover_color',
			[
				'label' => __( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .slick-prev:hover::before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .slick-next:hover::before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .slick-prev:focus::before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .slick-next:focus::before' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'navigation_hover_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .slick-prev:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}}',	
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

    	global $post;

		$post_meta = get_post_meta($post->ID);
		$property_gallery = (!empty($post_meta['gallery'][0])) ? explode(',',$post_meta['gallery'][0]) : '';
 
		if ( !empty($property_gallery) ) :
		?>
		<div class="content single_property_page">
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
			                $image_caption = (!empty($image_metadata->post_title)) ? $image_metadata->post_title : $image_metadata->post_excerpt ;
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
	}

	protected function _content_template() {
		
	}	
}
