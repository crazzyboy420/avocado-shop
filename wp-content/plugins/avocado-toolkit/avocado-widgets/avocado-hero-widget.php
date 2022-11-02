<?php
class avocado_hero_widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'avocado_hero_widget';
	}
	public function get_title() {
		return __( 'Avocado Hero Widget', 'avocado-toolkit' );
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
				'default' => __( 'Healthy food', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'hero_content',
			[
				'label' => __( 'Content', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'the food that is cooked with love', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'background_image',
			[
				'label' => __( 'Background Image', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);
		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'label_block' => true,
				'default'     => '#1f1c23',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Button Link', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'avocado-toolkit' ),
			]
		);

		$this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();

		$html = '
		<div class="avoacado-hero-area">
		<div class="avocado-hero-background" style="background-image:url('.$settings['background_image']['url'].');background-color:'.$settings['background_color'].'">
		 <div class="corerd"></div>
		</div>
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 text-center">
						<div class="avocado-content-area">
							<h2>'.$settings['title'].'</h2>
							'.wpautop($settings['hero_content']).'
							<a href="#" class="box-btn">shop Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>';
		echo $html;

	}

}