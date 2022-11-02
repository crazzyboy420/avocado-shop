<?php
class product_categorise_widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'product_category_widgets';
	}
	public function get_title() {
		return __( 'Product Category', 'avocado-toolkit' );
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
			'category',
			[
				'label' => __( 'Select Category', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
                'multiple' => true,
                'options' => product_categorise_list(),
			]
		);
        $this->add_control(
			'coloums',
			[
				'label' => __( 'Select Coloums', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => __( 'Healthy food', 'avocado-toolkit' ),
				'label_block' => true,
                'options' => [
					'col'  => __( '1 Coloums', 'avocado-toolkit' ),
					'col-lg-6' => __( '2 coloums', 'avocado-toolkit' ),
					'col-lg-4' => __( '3 Colums', 'avocado-toolkit' ),
					'col-lg-3' => __( '4 Colums', 'avocado-toolkit' ),
				],
			]
		);
        $this->add_control(
			'background_img',
			[
				'label' => __( 'Image as Background?', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'avocado-toolkit' ),
				'label_off' => __( 'No', 'avocado-toolkit' ),
				'return_value' => 'yes',
				'default' => 'No',
			]
		);
		$this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();
        $html = '<div class="row">';
        if(!empty($settings['category'])){
            foreach($settings['category'] as $single_cat ){
              $category = get_term_by( 'term_id', $single_cat, 'product_cat' );
              $thumbnail_id = get_term_meta($single_cat,'thumbnail_id',true);
              $category_imgae = wp_get_attachment_image_url($thumbnail_id,'medium');
              $html .= '<div class="'.$settings['coloums'].' single-cat"><a href="'.get_term_link($category->slug, 'product_cat').'">';
              if(!empty($thumbnail_id)){
                  if($settings['background_img']=='yes'){
                   $html .='<div class="col cat-background" style="background-image:url('.$category_imgae.')"></div>';
                  }else{
                   $html .='
                     <div class="row">
                        <div class="col cat-thumb">
                          <img src="'.$category_imgae.'" alt=""/>
                        </div>
                    </div>';
                  }
              }else{
                  $html .='<div class="no-thum"><p>No Thumbnail</p></div>';
              }
              $html .='
                 <h3>'.$category->name.'</h3>
                 '.wpautop($category->description).'
                 </a></div>';
            }
        }else{
            $html = '<div class="alert alert-warning">Please Select Categorise</div>';
        }
        $html .='
        </div>';
		echo $html;

	}

}