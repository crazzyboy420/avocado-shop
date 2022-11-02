<?php
class section_title_widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'section_title_widget';
	}
	public function get_title() {
		return __( 'Section  Title', 'avocado-toolkit' );
	}

	public function get_icon() {
		return 'eicon-code';
	}
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'avocado-toolkit' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Featured Categories', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
        $this->add_control(
			'content',
			[
				'label' => __( 'Content', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Healthy food at an affordable price', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
		$this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		
		$html = '<div class="section-title text-center">
            <h2>'.$settings['title'].'</h2>
            <p>'.$settings['content'].'</p>
        </div>';
		echo $html;

	}

}