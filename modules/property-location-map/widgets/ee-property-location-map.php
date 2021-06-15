<?php
namespace ElementorExtensions\Modules\PropertyLocationMap\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use ElementorExtensions\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
 
class EE_Property_Location_Map extends Base_Widget {

	public function get_name() {
		return $this->widget_name_prefix.'property-location-map';
	}

	public function get_title() {
		return __( 'Property Location Map', 'elementor-extensions' );
	}

	public function get_icon() {
		return 'eicon-welcome';
	}

	public function get_keywords() {
		return [ 'p', 'pro', 'plm', 'location', 'map', 'property' ];
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
			'lat',
			[
				'label' => __( 'Default Lattitude', 'elementor-extensions' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '50.863390', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'lng',
			[
				'label' => __( 'Default Longitude', 'elementor-extensions' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '-1.240890', 'elementor-extensions' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Location Map Style', 'elementor-extensions' ),
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
					'{{WRAPPER}} #ee-mb-location-map iframe' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} #ee-mb-location-map iframe' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} #ee-mb-location-map' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} #ee-mb-location-map' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'elementor-extensions' ),
				'selector' => '{{WRAPPER}} #ee-mb-location-map',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

    	$post_id = get_the_ID();
		
		$post_meta = get_post_meta($post_id);

    	$property_location_map = (!empty($post_meta['location'][0])) ? unserialize($post_meta['location'][0]) : [];

    	if ( empty( $property_location_map['lat'] ) ) :
    		$property_location_map['lat'] = $settings['lat'];
    	endif;

    	if ( empty( $property_location_map['lng'] ) ) :
    		$property_location_map['lng'] = $settings['lng'];
    	endif;

    	if(!empty($property_location_map['lat']) && !empty($property_location_map['lng'])): 
            $frame_url = 'https://maps.google.com/maps?q='.$property_location_map['lat'].','.$property_location_map['lng'].'&hl=es;z=14&amp;output=embed';
          ?>
            <div id="ee-mb-location-map">
	    		<iframe src="<?php echo $frame_url; ?>" frameborder="0" style="border:0;" allowfullscreen></iframe>
	    	</div>
          <?php 
        endif;
	}

	protected function _content_template() {
		
	}	
}
