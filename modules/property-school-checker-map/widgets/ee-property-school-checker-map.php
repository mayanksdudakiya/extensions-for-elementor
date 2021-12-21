<?php
namespace ElementorExtensions\Modules\PropertySchoolCheckerMap\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class EE_Property_School_Checker_Map extends Base_Widget {

	public function get_name() {
		return $this->widget_name_prefix.'property-school-checker-map';
	}

	public function get_title() {
		return __( 'School Checker Map', 'elementor-extensions' );
	}

	public function get_icon() {
		return 'eicon-welcome';
	}

	public function get_script_depends() {
		return [
			'ee-mb-googlemap-api',
		];
	} 

	public function get_keywords() {
		return [ 'p', 'pro', 'psc', 'checker', 'map', 'property' ];
	}
	
	protected function _register_controls() {
		
		/*@Content Start */
		$this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Location Map', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_CONTENT,
				'show_label' => true,
            ]
		);

		$this->add_control(
			'default_location',
			[
				'label' => __( 'Default Location', 'elementor-extensions' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '23 Park Cottage Dr, Fareham PO15 5JD, UK', 'elementor-extensions' ),
				'placeholder' => __( 'Enter default location for map', 'elementor-extensions' ),
				'description' => __( 'If single property location not defined then this location will be used.', 'elementor-extensions' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'style_section',
            [
                'label' => __( 'School Checker Map Style', 'elementor-extensions' ),
                'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => true,
            ]
		);

		$this->add_responsive_control(
			'location_map_width',
			[
				'label' => __( 'Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} #ee-mb-map' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'location_map_height',
			[
				'label' => __( 'Height', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
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
					'{{WRAPPER}} #ee-mb-map' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'location_map_margin',
			[
				'label' => __( 'Margin', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #ee-mb-school-checker-map-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'location_map_padding',
			[
				'label' => __( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #ee-mb-school-checker-map-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'selector' => '{{WRAPPER}} #ee-mb-school-checker-map-wrapper',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		global $post;

		$post_meta = get_post_meta($post->ID);

		$temp['address'] = $settings['default_location'];

		$address['addresses'] = (!empty($post_meta['location'][0])) ? unserialize($post_meta['location'][0]) : $temp;
    	?>
    	<div id="ee-mb-school-checker-map-wrapper" data-settings='<?php echo json_encode($address); ?>'>
    		<div id="ee-mb-map"></div>
    	</div>
    	<?php
	}

	protected function content_template() {
		
	}	
}
