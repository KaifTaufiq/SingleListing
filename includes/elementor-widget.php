<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( class_exists('\Elementor\Widget_Base')){
class Elementor_Hello_World_Widget_1 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'hello_world_widget_1';
	}

	public function get_title() {
		return esc_html__( 'Hello World 1', 'elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'hello', 'world' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'all_list_id',
			[
				'label' => esc_html__( 'All Listing ID', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'single_list_id',
			[
				'label' => esc_html__( 'Single Listing ID', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
			'no_active',
			[
				'label' => esc_html__( 'No Single Active ID', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'closeBtn',
			[
				'label' => esc_html__( 'Close Button ID', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'activeItemClass',
			[
				'label' => esc_html__( 'Active Item Class', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
		$this->enqueue_widget_scripts($settings);
	}

    public function enqueue_widget_scripts($settings) {
        // Register the JavaScript file
        wp_register_script('SingleListing', plugin_dir_url(__FILE__) . '/script.js', array(), '1.0', true);
        
        // Localize script with widget settings (PHP to JS)
        $localized_data = array(
            'single_list_id' => $settings['single_list_id'],
            'all_list_id'    => $settings['all_list_id'],
            'no_active'      => $settings['no_active'],
            'closeBtn'       => $settings['closeBtn'],
			'activeItemClass'    => $settings['activeItemClass'],
        );
        
        wp_localize_script('SingleListing', 'SingleQuerySettings', $localized_data);
        
        // Enqueue the script
        wp_enqueue_script('SingleListing');
    }
}

}