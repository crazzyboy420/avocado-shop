<?php
class ajax_product_widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'ajax_product';
	}
	public function get_title() {
		return __( 'Ajax Product Tab', 'avocado-toolkit' );
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
			'section_title',
			[
				'label' => __( 'Section Title', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Featured',
				'label_block' => true,
			]
		);
		 $this->add_control(
			'count',
			[
				'label' => __( 'Count', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => '9',
				'label_block' => true,
				'description' => 'Product count.how many product show you want.if you type -1 all post show if you want'
			]
		);
		 $this->add_control(
			'default_category',
			[
				'label' => __( 'You Want Select Default Categeory?', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'avocado-toolkit' ),
				'label_off' => __( 'No', 'avocado-toolkit' ),
				'return_value' => 'yes',
				'default' => 'No',
			]
		);
		$this->add_control(
			'select_default_category',
			[
				'label' => __( 'Select Default Category', 'avocado-toolkit' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
                'options' => product_categorise_list(),
				'condition' => [
                   'default_category' => 'yes',
				],
					
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
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();

		$html = '
			<script>
				jQuery(document).ready(function($){
					$(".product-ajax-taggle li").on("click",function(){
						$(".product-ajax-taggle li").removeClass("active");
						$(this).addClass("active");
					});
						$(".product-ajax-taggle li button").on("click",function(){
							var data_id = $(this).attr("data-id");
							var ajax_nonce = $(this).attr("data-nonce");
							var get_count = $(this).attr("count-data");
							$.ajax({
								url :  "'.admin_url( 'admin-ajax.php' ).'",
								type : "POST",
								data : {
									action:"get_product_data",
									dataid:data_id,
									get_nonce:ajax_nonce,
									count:get_count,
									},
								beforeSend:function(){
									$(".ajax-append").empty();
									$(".ajax-append").append("Loading....");
								},
								success: function(html) {
									$(".ajax-append").empty();
								$(".ajax-append").append(html); 
								}
							}); 
						});
				});  
			</script>';
        $html .= '<div class="ajax-featured-product"><h3 class="section-title">'.$settings['section_title'].'</h3>';


		$html .= '<ul class="product-ajax-taggle">';
		if(!empty($settings['select_default_category'])){
			 $cat_default = get_term_by( 'term_id', $settings['select_default_category'], 'product_cat' );
			$html .= '<li class="active"><button data-nonce="'.wp_create_nonce('get_product_data').'" data-id="'.$settings['select_default_category'].'" count-data="'.$settings['count'].'">'.$cat_default->name.'</button></li>';
		}
        $i = 0;
        if(!empty($settings['category'])){
            foreach($settings['category'] as $single_cat ){
				if(empty($settings['select_default_category'])){
			    	$i++;
					if($i == 1){
						$ac_class = 'active';
					}else{
						$ac_class = '';
					}

		    	}else{
					$ac_class = '';
				}
             if($settings['select_default_category'] != $single_cat){
				 $category = get_term_by( 'term_id', $single_cat, 'product_cat' );
				 $html .= '<li class="'.$ac_class.'"><button data-nonce="'.wp_create_nonce('get_product_data').'" data-id="'.$single_cat.'" count-data="'.$settings['count'].'">'.$category->name.'</button></li>';
			 }
			}
		$html .= '</ul>';


			if(!empty($settings['select_default_category'])){
				$cat_id = $settings['select_default_category'];
			}else{
				$cat_id = $settings['category'][0];
			}
			 $args=array(
				'posts_per_page' => $settings['count'], 
				'post_type' => 'product',
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => $cat_id,
					),
				),
			);
            $thumbnail_id = get_term_meta($cat_id,'thumbnail_id',true);
			$category_imgae = wp_get_attachment_image_url($thumbnail_id,'medium');
         $html .= '<div class="row ajax-append">';
		  $html .= '<div class="col-lg-6  maring-b-20"><div class="ajax-category-img" style="background-image:url('.$category_imgae.')"></div></div>';
          $loop = new WP_Query( $args );
		   while ( $loop->have_posts() ) : $loop->the_post();
		    global $product;
		   $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()),'medium');
		   $html .= '
		           <a href="'.get_permalink(get_the_ID() ).'" class="single-product col-lg-2  maring-b-20">
				  		<div style="background-image:url('.$product_image.')" class="product-featured"></div>  
						   <h4>'.get_the_title(  ).'</h4>
		                   <div class="product-price">'.$product->get_price_html().'</div>
				   </a>';
		   
		    endwhile;
		 $html .= '</div>';
        }else{
            $html .= '<div class="alert alert-warning">Please Select Categorise</div>';
        }


        $html .='</div>';
        wp_reset_query();
		echo $html;

	}

}
			