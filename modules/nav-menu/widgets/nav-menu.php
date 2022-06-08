<?php
namespace ElementorExtensions\Modules\NavMenu\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; 

class Nav_Menu extends Widget_Base {

	protected $nav_menu_index = 1;

	public function get_name() {
		return 'nav-menu';
	}

	public function get_title() {
		return esc_html__( 'Nav Menu', 'elementor-extensions' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'pro-elements', 'theme-elements', 'elementor-extensions' ];
	}

	public function get_style_depends() {
		return [ 'ee-mb-hamburgers' ];
	}

	public function get_keywords() {
		return [ 'menu', 'nav', 'button', 'navigation menu', 'navigation', 'men', 'nm', 'n', 'm' ];
	}

	public function get_script_depends() {
		return [ 'smartmenus' ];
	}

	public function on_export( $element ) {
		unset( $element['settings']['menu'] );

		return $element;
	}

	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'elementor-extensions' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'   => esc_html__( 'Menu', 'elementor-extensions' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf(
						esc_html__( 'Go to the %1$sMenus screen%2$s to manage your menus.', 'elementor-pro' ),
						sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php' ) ),
						'</a>'
					),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . esc_html__( 'There are no menus in your site.', 'elementor-pro' ) . '</strong><br>' .
							sprintf(
								/* translators: 1: Link open tag, 2: Link closing tag. */
								esc_html__( 'Go to the %1$sMenus screen%2$s to create one.', 'elementor-pro' ),
								sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
								'</a>'
							),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'elementor-extensions' ),
					'vertical' => esc_html__( 'Vertical', 'elementor-extensions' ),
					'dropdown' => esc_html__( 'Dropdown', 'elementor-extensions' ),
					'slideout' => esc_html__( 'Slide Out', 'elementor-extensions' ),
					'scroll_hamburger' => esc_html__( 'Scroll Hamburger', 'elementor-extensions' ),
					'mega_menu' => esc_html__( 'Mega Menu', 'elementor-extensions' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'menu_name',
			[
				'label' => esc_html__( 'Menu Text', 'elementor-extensions' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter menu name', 'elementor-extensions' ),
				'condition' => [
					'layout' => 'slideout',
				],
			]
		);

		$this->add_control(
			'align_items',
			[
				'label' => esc_html__( 'Align', 'elementor-extensions' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Stretch', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'elementor-nav-menu__align-',
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Align', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'elementor-extensions' ),
					'right' => esc_html__( 'Right', 'elementor-extensions' ),
					'top' => esc_html__( 'Top', 'elementor-extensions' ),
					'bottom' => esc_html__( 'Bottom', 'elementor-extensions' ),
				],
				'style_transfer' => true,
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
				],
			]
		);

		$this->add_control(
			'pointer',
			[
				'label' => esc_html__( 'Pointer', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'none' => esc_html__( 'None', 'elementor-extensions' ),
					'underline' => esc_html__( 'Underline', 'elementor-extensions' ),
					'overline' => esc_html__( 'Overline', 'elementor-extensions' ),
					'double-line' => esc_html__( 'Double Line', 'elementor-extensions' ),
					'framed' => esc_html__( 'Framed', 'elementor-extensions' ),
					'background' => esc_html__( 'Background', 'elementor-extensions' ),
					'text' => esc_html__( 'Text', 'elementor-extensions' ),
				],
				'style_transfer' => true,
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
				],
			]
		);

		$this->add_control(
			'animation_line',
			[
				'label' => esc_html__( 'Animation', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'slide' => 'Slide',
					'grow' => 'Grow',
					'drop-in' => 'Drop In',
					'drop-out' => 'Drop Out',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label' => esc_html__( 'Animation', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'draw' => 'Draw',
					'corners' => 'Corners',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_background',
			[
				'label' => esc_html__( 'Animation', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sweep-left' => 'Sweep Left',
					'sweep-right' => 'Sweep Right',
					'sweep-up' => 'Sweep Up',
					'sweep-down' => 'Sweep Down',
					'shutter-in-vertical' => 'Shutter In Vertical',
					'shutter-out-vertical' => 'Shutter Out Vertical',
					'shutter-in-horizontal' => 'Shutter In Horizontal',
					'shutter-out-horizontal' => 'Shutter Out Horizontal',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label' => esc_html__( 'Animation', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grow',
				'options' => [
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sink' => 'Sink',
					'float' => 'Float',
					'skew' => 'Skew',
					'rotate' => 'Rotate',
					'none' => 'None',
				],
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
					'pointer' => 'text',
				],
			]
		);

		$icon_prefix = Icons_Manager::is_migration_allowed() ? 'fas ' : 'fa ';

		$this->add_control(
			'submenu_icon',
			[
				'label' => esc_html__( 'Submenu Indicator', 'elementor-pro' ),
				'type' => Controls_Manager::ICONS,
				'separator' => 'before',
				'default' => [
					'value' => $icon_prefix . 'fa-caret-down',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-down',
						'angle-down',
						'caret-down',
						'plus',
					],
				],
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => [ 'svg' ],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'toggle_align_slideout',
			[
				'label' => esc_html__( 'Toggle Align', 'elementor-extensions' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button' => '{{VALUE}}',
				],
				'condition' => [
					'layout' => 'slideout',
				],
				'label_block' => false,
			]
		);


		$this->add_control(
			'heading_mobile_dropdown',
			[
				'label' => esc_html__( 'Mobile Dropdown', 'elementor-extensions' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);

		// TODO: For Pro 3.6.0, convert this to the breakpoints utility method introduced in core 3.5.0.
		$breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();
		$dropdown_options = [];
		$excluded_breakpoints = [
			'laptop',
			'widescreen',
		];

		foreach ( $breakpoints as $breakpoint_key => $breakpoint_instance ) {
			// Do not include laptop and widscreen in the options since this feature is for mobile devices.
			if ( in_array( $breakpoint_key, $excluded_breakpoints, true ) ) {
				continue;
			}

			$dropdown_options[ $breakpoint_key ] = sprintf(
				/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value */
				esc_html__( '%1$s (%2$s %3$dpx)', 'elementor-pro' ),
				$breakpoint_instance->get_label(),
				'>',
				$breakpoint_instance->get_value()
			);
		}

		$dropdown_options['none'] = esc_html__( 'None', 'elementor-pro' );

		$this->add_control(
			'dropdown',
			[
				'label' => esc_html__( 'Breakpoint', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tablet',
				'options' => $dropdown_options,
				'prefix_class' => 'elementor-nav-menu--dropdown-',
				'condition' => [
					'layout!' => 'dropdown',
				],
				'frontend_available' => true
			]
		);

		$this->add_control(
			'full_width',
			[
				'label' => esc_html__( 'Full Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => esc_html__( 'Stretch the dropdown of the menu to full width.', 'elementor-extensions' ),
				'prefix_class' => 'elementor-nav-menu--',
				'return_value' => 'stretch',
				'frontend_available' => true,
				'condition' => [
					'dropdown!' => 'none',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Align', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'aside',
				'options' => [
					'aside' => esc_html__( 'Aside', 'elementor-extensions' ),
					'center' => esc_html__( 'Center', 'elementor-extensions' ),
				],
				'prefix_class' => 'elementor-nav-menu__text-align-',
				'condition' => [
					'dropdown!' => 'none',
				],
			]
		);

		$this->add_control(
			'toggle',
			[
				'label' => esc_html__( 'Toggle Button', 'elementor-extensions' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'burger',
				'options' => [
					'' => esc_html__( 'None', 'elementor-extensions' ),
					'burger' => esc_html__( 'Hamburger', 'elementor-extensions' ),
				],
				'prefix_class' => 'elementor-nav-menu--toggle elementor-nav-menu--',
				'render_type' => 'template',
				'frontend_available' => true,
				'condition' => [
					'dropdown!' => 'none',
				],
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label' => esc_html__( 'Toggle Align', 'elementor-extensions' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => '{{VALUE}}',
				],
				'condition' => [
					'toggle!' => '',
					'dropdown!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => esc_html__( 'Main Menu', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .elementor-nav-menu--main ul li a.elementor-item, {{WRAPPER}} .elementor-nav-menu--dropdown  .elementor-sub-item, {{WRAPPER}} .elementor-nav-menu .elementor-item, {{WRAPPER}} .elementor-nav-menu--dropdown .elementor-item',

			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_menu_item',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item' => 'color: {{VALUE}}; fill: {{VALUE}};',

					'{{WRAPPER}} .elementor-nav-menu--dropdown-tablet .ee-mb-megamenu-wrapper li:after' => 'border-top-color: {{VALUE}}'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .elementor-nav-menu--dropdown-tablet .ee-mb-megamenu-wrapper li.uparrow:after,
					{{WRAPPER}} .elementor-nav-menu--dropdown-tablet .ee-mb-megamenu-wrapper li.uparrow:after' => 'border-bottom-color: {{VALUE}}'
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'color_menu_item_hover_pointer_bg',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_hover',
			[
				'label' => esc_html__( 'Pointer Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
					{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => esc_html__( 'Active', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_menu_item_active',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_active',
			[
				'label' => esc_html__( 'Pointer Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:before,
					{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$divider_condition = [
			'nav_menu_divider' => 'yes',
			'layout' => 'horizontal',
		];

		$this->add_control(
			'nav_menu_divider',
			[
				'label' => esc_html__( 'Divider', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'elementor-pro' ),
				'label_on' => esc_html__( 'On', 'elementor-pro' ),
				'condition' => [
					'layout' => 'horizontal',
				],
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-divider-content: "";',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nav_menu_divider_style',
			[
				'label' => esc_html__( 'Style', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__( 'Solid', 'elementor-pro' ),
					'double' => esc_html__( 'Double', 'elementor-pro' ),
					'dotted' => esc_html__( 'Dotted', 'elementor-pro' ),
					'dashed' => esc_html__( 'Dashed', 'elementor-pro' ),
				],
				'default' => 'solid',
				'condition' => $divider_condition,
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-divider-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_menu_divider_weight',
			[
				'label' => esc_html__( 'Width', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => $divider_condition,
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-divider-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'nav_menu_divider_height',
			[
				'label' => esc_html__( 'Height', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => $divider_condition,
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-divider-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'nav_menu_divider_color',
			[
				'label' => esc_html__( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => $divider_condition,
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-divider-color: {{VALUE}}',
				],
			]
		);

		/* This control is required to handle with complicated conditions */
		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'pointer_width',
			[
				'label' => esc_html__( 'Pointer Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--pointer-underline .elementor-item:after,
					 {{WRAPPER}} .e--pointer-overline .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label' => esc_html__( 'Horizontal Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label' => esc_html__( 'Vertical Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label' => esc_html__( 'Space Between', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--e-nav-menu-horizontal-menu-item-margin: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .elementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'body:not(.rtl) {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius_menu_item',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shrink_section_style_main_menu',
			[
				'label' => esc_html__( 'Shrink Main Menu', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
					'layout!' => 'slideout',
				],
			]
		);

		$this->start_controls_tabs( 'shrink_tabs_menu_item_style' );

		$this->start_controls_tab(
			'shrink_tab_menu_item_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'shrink_color_menu_item',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item' => 'color: {{VALUE}}!important',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shrink_tab_menu_item_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'shrink_color_menu_item_hover',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item:hover,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item.elementor-item-active,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item.highlighted,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}!important',
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'shrink_color_menu_item_hover_pointer_bg',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item:hover,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item.elementor-item-active,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item.highlighted,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}!important',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'shrink_pointer_color_menu_item_hover',
			[
				'label' => esc_html__( 'Pointer Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed .elementor-item:before,
					.elementor-sticky--effects > .elementor-container .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}!important',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'shrink_tab_menu_item_active',
			[
				'label' => esc_html__( 'Active', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'shrink_color_menu_item_active',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item.elementor-item-active' => 'color: {{VALUE}}!important',
				],
			]
		);

		$this->add_control(
			'shrink_pointer_color_menu_item_active',
			[
				'label' => esc_html__( 'Pointer Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:before,
					.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed .elementor-item.elementor-item-active:before,
					.elementor-sticky--effects > .elementor-container .e--pointer-framed .elementor-item.elementor-item-active:after' => 'border-color: {{VALUE}}!important',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* This control is required to handle with complicated conditions */
		$this->add_control(
			'shrink_hr',
			[
				'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
			]
		);

		$this->add_control(
			'shrink_pointer_width',
			[
				'label' => esc_html__( 'Pointer Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ],
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed.e--animation-draw .elementor-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed.e--animation-draw .elementor-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed.e--animation-corners .elementor-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-framed.e--animation-corners .elementor-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0!important',
					'.elementor-sticky--effects > .elementor-container .e--pointer-underline .elementor-item:after,
					 .elementor-sticky--effects > .elementor-container .e--pointer-overline .elementor-item:before,
					 .elementor-sticky--effects > .elementor-container .e--pointer-double-line .elementor-item:before,
					 .elementor-sticky--effects > .elementor-container .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}!important',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_responsive_control(
			'shrink_padding_horizontal_menu_item',
			[
				'label' => esc_html__( 'Horizontal Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}!important; padding-right: {{SIZE}}{{UNIT}}!important',
				],
			]
		);

		$this->add_responsive_control(
			'shrink_padding_vertical_menu_item',
			[
				'label' => esc_html__( 'Vertical Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}!important; padding-bottom: {{SIZE}}{{UNIT}}!important',
				],
			]
		);

		$this->add_responsive_control(
			'shrink_menu_space_between',
			[
				'label' => esc_html__( 'Space Between', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'body:not(.rtl) .elementor-sticky--effects > .elementor-container .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}!important',
					'body.rtl .elementor-sticky--effects > .elementor-container .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .elementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}!important',
				],
			]
		);

		$this->add_responsive_control(
			'shrink_border_radius_menu_item',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet' ],
				'selectors' => [
					'.elementor-sticky--effects > .elementor-container .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0!important',
					'.elementor-sticky--effects > .elementor-container .e--animation-shutter-in-horizontal .elementor-item:after' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}!important',
					'.elementor-sticky--effects > .elementor-container .e--animation-shutter-in-vertical .elementor-item:before' => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0!important',
					'.elementor-sticky--effects > .elementor-container .e--animation-shutter-in-vertical .elementor-item:after' => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}!important',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => esc_html__( 'Dropdown & Slideout', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dropdown_description',
			[
				'raw' => esc_html__( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'elementor-extensions' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_item_style' );

		$this->start_controls_tab(
			'tab_dropdown_item_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_dropdown_item',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a, {{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-nav-menu--dropdown.ee-mb-megamenu-wrapper li:after' => 'border-top-color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_dropdown_item_hover',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a:hover,
					{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--dropdown a.highlighted,
					{{WRAPPER}} .elementor-menu-toggle:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-nav-menu--dropdown.ee-mb-megamenu-wrapper li.uparrow:after' => 'border-bottom-color: {{VALUE}}; border-top-color:transparent;'
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item_hover',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a:hover,
					{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_active',
			[
				'label' => esc_html__( 'Active', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'color_dropdown_item_active',
			[
				'label' => esc_html__( 'Text Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item_active',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a.elementor-item-active' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dropdown_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'exclude' => [ 'line_height' ],
				'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown .elementor-item, {{WRAPPER}} .elementor-nav-menu--dropdown  .elementor-sub-item',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dropdown_border',
				'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'dropdown_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-nav-menu--main .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown',
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_dropdown_item',
			[
				'label' => esc_html__( 'Horizontal Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',

			]
		);

		$this->add_responsive_control(
			'padding_vertical_dropdown_item',
			[
				'label' => esc_html__( 'Vertical Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_dropdown_divider',
			[
				'label' => esc_html__( 'Divider', 'elementor-extensions' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'dropdown_divider',
				'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child)',
				'exclude' => [ 'width' ],
			]
		);

		$this->add_control(
			'dropdown_divider_width',
			[
				'label' => esc_html__( 'Border Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_divider_border!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_top_distance',
			[
				'label' => esc_html__( 'Distance', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main > .elementor-nav-menu > li > .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_hamburger_on_scroll',
			[
				'label' => esc_html__( 'Hamburger on Scroll', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'scroll_hamburger'
				]
			]
		);

		$this->add_control(
			'hamburger_on_scroll_color',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.hamburger_icon_wrapper .arrow_for_scroll > i' => 'color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'hamburger_on_scroll_background',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.hamburger_icon_wrapper .arrow_for_scroll::after' => 'border-top-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'hamburger_size',
			[
				'label' => esc_html__( 'Hamburger Size', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'.hamburger_icon_wrapper .arrow_for_scroll > i' => 'font-size: {{SIZE}}px',
					'.hamburger_icon_wrapper .arrow_for_scroll::after' => 'border-top-width: calc({{SIZE}}px * 2);border-right-width: calc({{SIZE}}px * 2);border-left-width: calc({{SIZE}}px * 2);'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'style_toggle',
			[
				'label' => esc_html__( 'Toggle Button', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle!' => '',
					'dropdown!' => 'none',
					'layout!' => 'slideout',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'tab_toggle_style_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle' => 'color: {{VALUE}}', // Harder selector to override text color control
					'{{WRAPPER}} div.elementor-menu-toggle svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_background_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_style_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'toggle_color_hover',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle:hover' => 'color: {{VALUE}}', // Harder selector to override text color control
				],
			]
		);

		$this->add_control(
			'toggle_background_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_size',
			[
				'label' => esc_html__( 'Size', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_border_width',
			[
				'label' => esc_html__( 'Border Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'menu_icon_style_toggle',
			[
				'label' => esc_html__( 'Menu Icon', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle!' => '',
					'layout!' => 'slideout',
				],
			]
		);

		/* Tab  */
		$this->start_controls_tabs( 'menu_icon_toggle_style' );

		$this->start_controls_tab(
			'menu_icon_style_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'menu_icon_color',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu > li::before' => 'color: {{VALUE}}', 
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'menu_icon_style_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'menu_icon_color_hover',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu > li:hover::before' => 'color: {{VALUE}}', 
				],
			]
		);		

		$this->end_controls_tab();

		$this->end_controls_tabs();
		/* Tab End */

		$this->add_control(
			'menu_icon_size',
			[
				'label' => esc_html__( 'Size', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu > li::before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_padding_menu_item',
			[
				'label' => esc_html__( 'Spacing', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu__icon-align-left .elementor-nav-menu > li::before' => 'left: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu__icon-align-right .elementor-nav-menu > li::before' => 'right: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu__icon-align-top .elementor-nav-menu > li::before' => 'top: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu__icon-align-bottom .elementor-nav-menu > li::before' => 'bottom: -{{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_paddings_menu_item',
			[
				'label' => esc_html__( 'Padding', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu__icon-align-left .elementor-nav-menu > li::before' => 'padding: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_mobile_spacing_menu_item',
			[
				'label' => esc_html__( 'Mobile Spacing', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile'],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-nav-menu--dropdown.elementor-nav-menu__icon-align-left .elementor-nav-menu > li:before' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();


		/*@Hamburger Toggle Menu Style start*/
		$this->start_controls_section( 'style_toggle_ee_mb',
			[
				'label' => esc_html__( 'Hamburger Button', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'slideout',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style_style' );

		$this->start_controls_tab(
			'tab_toggle_style_normal_ee_mb',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'toggle_color_ee_mb',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.ee-mb-menu-toggle-button .hamburger-inner,{{WRAPPER}} div.ee-mb-menu-toggle-button .hamburger-inner::before,{{WRAPPER}} div.ee-mb-menu-toggle-button .hamburger-inner::after' => 'background: {{VALUE}}', 
					'{{WRAPPER}} div.ee-mb-menu-toggle-button span' => 'color: {{VALUE}}', 
				],
			]
		);

		$this->add_control(
			'toggle_background_color_ee_mb',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_style_hover_ee_mb',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'toggle_color_hover_ee_mb',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.ee-mb-menu-toggle-button:hover' => 'color: {{VALUE}}', 
				],
			]
		);

		$this->add_control(
			'toggle_background_color_hover_ee_mb',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_size_ee_mb',
			[
				'label' => esc_html__( 'Size', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'toggle_border_width_ee_mb',
			[
				'label' => esc_html__( 'Border Width', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'toggle_border_radius_ee_mb',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ee-mb-menu-toggle-button' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 
			'style_mega_menu',
			[
				'label' => esc_html__( 'Megamenu', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'mega_menu',
				],
			]
		);

		$this->add_responsive_control(
			'megamenu_top_spacing',
			[
				'label' => esc_html__( 'Top Spacing', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'#mainNavigation > .ee-mb-nav-shortcode' => 'top: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true
			]
		);  

		$this->add_control(
			'mobile_megamenu_style',
			[
				'label' => esc_html__( 'Mobile Slide-Out', 'elementor-extensions' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_megamenu_backgound',
			[
				'label' => esc_html__( 'Background Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.ee-mb-megamenu-submenu.tablet' => 'background-color: {{VALUE}}!important',
					'.ee-mb-megamenu-submenu.mobile' => 'background-color: {{VALUE}}!important',
				],
			]
		);

		$this->end_controls_section();

		/*@Close button style start*/
		$this->start_controls_section( 'slideout_close_button',
			[
				'label' => esc_html__( 'Close Button', 'elementor-extensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'slideout',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_slideout_close_button' );

		$this->start_controls_tab(
			'tabs_slideout_close_button_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'close_button_color',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn_slideout_close i' => 'color: {{VALUE}}', 
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_slideout_close_button_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-extensions' ),
			]
		);

		$this->add_control(
			'close_button_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor-extensions' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn_slideout_close:hover i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'close_button_size',
			[
				'label' => esc_html__( 'Size', 'elementor-extensions' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .btn_slideout_close i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'close_button_align',
			[
				'label' => esc_html__( 'Align', 'elementor-extensions' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-extensions' ),
						'icon' => 'eicon-h-align-right',
					]
				],
				'selectors' => [
					'{{WRAPPER}} .btn_slideout_close' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	public function get_frontend_settings() {
		$frontend_settings = parent::get_frontend_settings();

		// If the saved value is FA4, but the user has upgraded to FA5, the value needs to be converted to FA5.
		if ( 'fa ' === substr( $frontend_settings['submenu_icon']['value'], 0, 3 ) && Icons_Manager::is_migration_allowed() ) {
			$frontend_settings['submenu_icon']['value'] = str_replace( 'fa ', 'fas ', $frontend_settings['submenu_icon']['value'] );
		}

		// Determine the submenu icon markup.
		if ( Plugin::$instance->experiments->is_feature_active( 'e_font_icon_svg' ) ) {
			$icon_classes = [];

			if ( false !== strpos( $frontend_settings['submenu_icon']['value'], 'chevron-down' ) ) {
				$icon_classes['class'] = 'fa-svg-chevron-down';
			}

			$icon_content = Icons_Manager::render_font_icon( $frontend_settings['submenu_icon'], $icon_classes );
		} else {
			$icon_content = sprintf( '<i class="%s"></i>', $frontend_settings['submenu_icon']['value'] );
		}

		// Passing the entire icon markup to the frontend settings because it can be either <i> or <svg> tag.
		$frontend_settings['submenu_icon']['value'] = $icon_content;

		return $frontend_settings;
	}

	protected function render() {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}

		$settings = $this->get_active_settings();

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'elementor-nav-menu',
			'menu_id' => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container' => '',
			/* 'walker' => new Es_Nav_Extension() */
		];

		if ( 'vertical' === $settings['layout'] ) {
			$args['menu_class'] .= ' sm-vertical';
		}

		/* Add custom filter to handle Nav Menu HTML output. */
		add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
		add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_tabindex' ], 10, 4 );
		add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		add_filter( 'nav_menu_item_id', '__return_empty_string' );

		/* General Menu. */
		$menu_html = wp_nav_menu( $args );

		/* Dropdown Menu. */
		$args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
		$args['menu_type'] = 'dropdown';
		$dropdown_menu_html = wp_nav_menu( $args );

		/* Remove all our custom filters. */
		remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );
		remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_tabindex' ] );
		remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );

		if ( empty( $menu_html ) ) {
			return;
		}

		$this->add_render_attribute( 'menu-toggle', [
			'class' => 'elementor-menu-toggle',
			'role' => 'button',
			'tabindex' => '0',
			'aria-label' => esc_html__( 'Menu Toggle', 'elementor-pro' ),
			'aria-expanded' => 'false',
		] );

		if ( Plugin::instance()->editor->is_edit_mode() ) {
			$this->add_render_attribute( 'menu-toggle', [
				'class' => 'elementor-clickable',
			] );
		}

		$is_migrated = isset( $settings['__fa4_migrated']['submenu_icon'] );

		$this->add_render_attribute( 'main-menu', [
			'migration_allowed' => Icons_Manager::is_migration_allowed() ? '1' : '0',
			'migrated' => $is_migrated ? '1' : '0',
			// Accessibility
			'role' => 'navigation',
		] );

		$settings['mega_menu'] = $megamenuHtml = '';
		if ( 'mega_menu' == $settings['layout']) :
			
			$settings['layout'] = 'horizontal';
			$settings['mega_menu'] = 'ee-mb-megamenu-wrapper';

			/*@ Mega-submenu*/
			$megaMenuItems = wp_get_nav_menu_items($settings['menu']);

			$megamenuHtml = '<div class="ee-mb-megamenu-submenu '.$settings['dropdown'].'" id="templateMainNav" style="display:none;">';

			foreach ($megaMenuItems as $key => $item) {
				$desc = do_shortcode($item->post_content);
				$megamenuHtml .= '<div class="ee-mb-nav-shortcode">' . $desc . '</div>';
			}
			$megamenuHtml .= '</div>';
		endif;

		if ( 'dropdown' !== $settings['layout'] && 'slideout' !== $settings['layout']) :

			$settings['scroll_hamburger'] = '';
			if ( 'scroll_hamburger' == $settings['layout']) :
				$settings['scroll_hamburger'] = 'scroll_hamburger';
				$settings['layout'] = 'horizontal';
			endif;

		
			$this->add_render_attribute( 'main-menu', 'class', [
				'elementor-nav-menu--main',
				'elementor-nav-menu__container',
				'elementor-nav-menu--layout-' . $settings['layout'],
				$settings['scroll_hamburger'],
				$settings['mega_menu'],
				'elementor-nav-menu__icon-align-' . $settings['icon_align'],
			] );

			if ( $settings['pointer'] ) :
				$this->add_render_attribute( 'main-menu', 'class', 'e--pointer-' . $settings['pointer'] );

				foreach ( $settings as $key => $value ) :
					if ( 0 === strpos( $key, 'animation' ) && $value ) :
							$this->add_render_attribute( 'main-menu', 'class', 'e--animation-' . $value );
						break;
					endif;
				endforeach;
			endif; 
			?>
			<nav <?php $this->print_render_attribute_string( 'main-menu' ); ?>>
				<?php
					// PHPCS - escaped by WordPress with "wp_nav_menu"
					echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
			<?php
		endif;

		if ('slideout' === $settings['layout']): ?>
			<div class="hamburger hamburger--3dx ee-mb-menu-toggle-button">
			    <div class="hamburger-box">
			      <div class="hamburger-inner"></div>
			    </div>
			    <?php if (!empty($settings['menu_name'])) : ?>
			    <span><?php echo $settings['menu_name']; ?></span>
			    <?php endif; ?>
  			</div>

  			<div class="ee-mb-sidebar-menu-wrapper">
	  			<div class="elementor-nav-menu--dropdown elementor-nav-menu__container sidebar">

	  				<div class="btn_slideout_close">
						<i class="eicon-close"></i>
		  			</div>

	  				<?php echo $dropdown_menu_html; ?>
	  			</div>
  			</div>
  		<?php
		  else:
		?>
		<div <?php $this->print_render_attribute_string( 'menu-toggle' ); ?>>
			<?php
				Icons_Manager::render_icon(
					[
						'library' => 'eicons',
						'value' => 'eicon-menu-bar',
					],
					[
						'aria-hidden' => 'true',
						'role' => 'presentation',
						'class' => 'elementor-menu-toggle__icon--open',
					]
				);

				Icons_Manager::render_icon(
					[
						'library' => 'eicons',
						'value' => 'eicon-close',
					],
					[
						'aria-hidden' => 'true',
						'role' => 'presentation',
						'class' => 'elementor-menu-toggle__icon--close',
					]
				);
			?>
			<span class="elementor-screen-only"><?php echo esc_html__( 'Menu', 'elementor-pro' ); ?></span>
		</div>
		<nav class="elementor-nav-menu--dropdown elementor-nav-menu__container elementor-nav-menu__icon-align-left <?php echo $settings['mega_menu']; ?>" role="navigation" aria-hidden="true">
			<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $dropdown_menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
		<?php
		echo $megamenuHtml;
		endif;
	}

	public function handle_link_classes( $atts, $item, $args, $depth ) {
		$classes = $depth ? 'elementor-sub-item' : 'elementor-item';
		$is_anchor = false !== strpos( $atts['href'], '#' );

		if ( ! $is_anchor && in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= ' elementor-item-active';
		}

		if ( $is_anchor ) {
			$classes .= ' elementor-item-anchor';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}

	public function handle_link_tabindex( $atts, $item, $args ) {
		$settings = $this->get_active_settings();

		// Add `tabindex = -1` to the links if it's a dropdown, for A11y.
		$is_dropdown = 'dropdown' === $settings['layout'];
		$is_dropdown = $is_dropdown || ( isset( $args->menu_type ) && 'dropdown' === $args->menu_type );

		if ( $is_dropdown ) {
			$atts['tabindex'] = '-1';
		}

		return $atts;
	}

	public function handle_sub_menu_classes( $classes ) {
		$classes[] = 'elementor-nav-menu--dropdown';

		return $classes;
	}

	public function render_plain_content() {}
}
