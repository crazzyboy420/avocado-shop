<?php
class avocado_avocado_title_widgets extends \Elementor\Widget_Base {
    public function get_name() {
        return 'avocado_avocado_title_widgets';
    }
    public function get_title() {
        return __( 'Hover Cart Title', 'avocado-toolkit' );
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
				'default' => __( 'Choose Your Product', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
        $this->add_control(
			'content',
			[
				'label' => __( 'Content', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Excellent quality and fast delivery. Just choose the needed products </br> and make an order.', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
        $this->add_control(
			'buy_text',
			[
				'label' => __( 'Buy text', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Or buy juste one', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'avocado-toolkit' ),
			]
		);
		$this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		
		$html = '<div class="section-title text-center">
            <h2>'.$settings['title'].'</h2>
            <p>'.$settings['content'].'</p>

            <a href="'.$settings['button_link']['url'].'" target="'.$settings['button_link']['is_external'].'" class="hover-title-button">Add to Cart all set</a>

            <p>'.$settings['buy_text'].'</p>
            <img src="'.$settings['icon']['url'].'" alt="title Icon">
        </div>';
		echo $html;

	}

}

















