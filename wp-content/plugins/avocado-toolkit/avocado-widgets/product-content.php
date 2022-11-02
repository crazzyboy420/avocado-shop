<?php
//Post List
function avocado_product_post_list() {
	$args = wp_parse_args(array(
		'post_type'  => 'product',
		'numberposts' => -1,
	));
	 $posts = get_posts($args);
	 if($posts){
		 foreach($posts as $post){
			 $post_options[ $post ->ID] = $post ->post_title;
		 }
	 }
  
	 return $post_options;
 }

//Category list
function avocado_category_list(){
    $term_id = 'product_cat';
    $categorise = get_terms( $term_id );
    foreach($categorise as $cat){
        $cat_info = get_term( $cat, $term_id);
        $category[$cat_info->slug] = $cat_info->name;
    }
    return $category;
}
class product_content_widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'product_content_widget';
	}
	public function get_title() {
		return __( 'Product Widget', 'avocado-toolkit' );
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
			'count',
			[
				'label' => __( 'count', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '4', 'avocado-toolkit' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'product_type',
			[
				'label' => __( 'Product Type', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'show_label' => true,
				'default'   => 'products',
				'options' => [
					'products'   => __('Normal Product','avocado-toolkit'),
					'featured_products'  => __( 'Featured products', 'avocado-toolkit' ),
					'sale_products' => __( 'Sale Product', 'avocado-toolkit' ),
					'best_selling_products' => __( 'Best Selling Products', 'avocado-toolkit' ),
					'recent_products' => __( 'Rcecent Products', 'avocado-toolkit' ),
					'top_rated_products' => __( 'Top rated Products', 'avocado-toolkit' ),
				],
	
			]
			
		);
		$this->add_control(
			'coloums',
			[
				'label' => __( 'Content', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => __( '4', 'avocado-toolkit' ),
				'options' => [
					'3'  => __( 'Three Culoums', 'avocado-toolkit' ),
					'4' => __( 'Four Culoums', 'avocado-toolkit' ),
				],
			]
		);
		$this->add_control(
			'category',
			[
				'label' => __( 'Select Category', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => avocado_category_list(),
				'label_block' => true,
				'multiple'  => true,
			]
			
		);
		$this->add_control(
			'product_list',
			[
				'label' => __( 'Select Category', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => avocado_product_post_list(),
				'label_block' => true,
				'multiple'  => true,
			]
			
		);

		$this->end_controls_section();

	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		if(!empty($settings['category'])){
			$cat_slug = implode(',',$settings['category']);
		}else{
			$cat_slug = '';
		}
		if(!empty($settings['product_list'])){
			$product_id = implode(',',$settings['product_list']);
		}else{
			$product_id = '';
		}
		
		$html = do_shortcode('['.$settings['product_type'].' limit="'.$settings['count'].'" ids="'.$product_id.'" columns="'.$settings['coloums'].'" category="'.$cat_slug.'"]');
		echo $html;

	}

}