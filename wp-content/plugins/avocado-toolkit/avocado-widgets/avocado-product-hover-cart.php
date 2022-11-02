<?php
class avocado_product_hover_cart_widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'avocado_product_hover_cart';
    }
    public function get_title() {
        return __( 'Hover Cart', 'avocado-toolkit' );
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
                'label' => __( 'Count', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default'  => 5,
            ]
        );
        $this->add_control(
            'select_options',
            [
                'label' => __( 'Select Options', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'select_product'  => __( 'Select Product', 'avocado-toolkit' ),
                    'select_categorise' => __( 'Select Categorise', 'avocado-toolkit' ),
                    'product_type' => __( 'Product Type', 'avocado-toolkit' ),
                ],
                'label_block' => true,
                'multiple' => true,
            ]
        );
        $this->add_control(
            'select_category',
            [
                'label' => __( 'Select Categorise', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => avocado_product_categorise_list(),
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'select_options' => ['select_categorise'],
                ],
            ]
        );
        $this->add_control(
            'product_list',
            [
                'label' => __( 'Select Product', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => avocado_product_list(),
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'select_options' => ['select_product'],
                ],
            ]
        );
        $this->add_control(
            'product_type',
            [
                'label' => __( 'Select Product Type', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'recent_product'  => __( 'Recent Product', 'avocado-toolkit' ),
                    'feature_product' => __( 'Feature Product', 'avocado-toolkit' ),
                    'top_rating' => __( 'Top Rating Product', 'avocado-toolkit' ),
                    'sell_product' => __( 'Sell  Product', 'avocado-toolkit' ),
                    'best_selling_product' => __( 'Best Selling Product', 'avocado-toolkit' ),
                ],
                'label_block' => true,
                'multiple' => true,
                'default' =>'sell_product',
                'condition' => [
                    'select_options' => ['product_type'],
                ],
            ]
        );
        $this->add_control(
            'enable_title',
            [
                'label' => __( 'Show Title', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'avocado-toolkit' ),
                'label_off' => __( 'No', 'avocado-toolkit' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __( 'Product Top Title', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Today Deal', 'avocado-toolkit' ),
                'label_block' => true,
                'condition' => [
                    'enable_title' => ['yes'],
                ],
            ]
        );
        $this->add_control(
            'enable_count_down',
            [
                'label' => __( 'Enable Count Down', 'avocado-toolkit' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'EW-toolkit' ),
                'label_off' => __( 'No', 'EW-toolkit' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
      

    }
    protected function render() {

        $settings = $this->get_settings_for_display();
         if(!empty($settings['select_options']) && $settings['select_options'] == 'product_type'){
            if($settings['product_type'] == 'recent_product'){
                $args = array(
                    'post_type'=> 'product',
                    'post_status' => 'publish',
                    'order'=>'DESC',
                    'orderby'=>'ID',
                    'posts_per_page' => $settings['count'],
                );
            }elseif($settings['product_type'] == 'feature_product'){
                $meta_query  = WC()->query->get_meta_query();
                $tax_query   = WC()->query->get_tax_query();
                $tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );

                $args = array(
                    'post_type'           => 'product',

                    'posts_per_page' => $settings['count'],
                    'meta_query'          => $meta_query,
                    'tax_query'           => $tax_query,
                );
            }elseif($settings['product_type'] == 'top_rating'){
                $args = array(
                    'posts_per_page' => $settings['count'],
                    'post_status'    => 'publish',
                    'post_type'      => 'product',
                    'meta_key'       => '_wc_average_rating',
                    'orderby'        => 'meta_value_num',
                    'meta_query'     => WC()->query->get_meta_query(),
                    'tax_query'      => WC()->query->get_tax_query(),
                );
            }elseif($settings['product_type'] == 'sell_product'){
                $args = array(
                    'post_type' => 'product',
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array( // Variable products type
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        )
                    ),
                    'posts_per_page' => $settings['count'],
                );
            }elseif($settings['product_type'] == 'best_selling_product'){
                $args =array(
                    'post_type' => 'product',
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'posts_per_page' => $settings['count'],
                );
            }else {
                $args = array(
                    'post_type'=> 'product',
                );
            }
        }elseif($settings['select_options'] == 'select_categorise'){
            $args =array(
                'post_type' => 'product',
                'posts_per_page' => $settings['count'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $settings['select_category'],
                        'operator' => 'IN'
                    )	)
            );
        }elseif($settings['select_options'] == 'select_product'){
            $args =array(
                'post_type' => 'product',
                'posts_per_page' => $settings['count'],
                'post__in' => $settings['product_list'],

            );
        }else{
            $args =array(
                    'post_type' => 'product',
                    'orderby' => 'menu_order',
                    'posts_per_page' => 6,
                );
        }
          $loop = new WP_Query( $args );
        $html = '<div id="app" class="container ch-product-area"><div class="product-close" @click="productClose()"></div>';
        while ( $loop->have_posts() ) : $loop->the_post();
       global $product;
        if(!empty(get_field('perper'))){
                $pount_per = '<div class="pount"><span>/</span>'.get_field('perper').'</div>';
            }else{
                $pount_per = '';
            }
         $product_id = get_the_ID();

          $html .= '<div class="ch-product">
             <div @click="productOpen('.$product_id.')" class="single-ch-product">
                '.get_the_post_thumbnail(get_the_ID(),'thumbnail').'
                <button>
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                   </svg>
                </button>
             </div>
             <div v-if="modal && id == '.$product_id.'" class="ch-product-card-details">
             '.do_shortcode("[yith_wcwl_add_to_wishlist label ='<i class=\"far fa-heart\"></i>' product_added_text='' browse_wishlist_text='' already_in_wishslist_text='']").'
                '.get_the_post_thumbnail( get_the_ID(),'ch_product_size').'
                <h3>'.get_the_title().'</h3>';
    $html .='<div>';
            if( $product->is_type( 'variable' ) ){
                $html   .= '<div class="variable-product-price">'.$product->get_price_html().'</div>';
            }else{
                if($product->is_on_sale()){
				$html   .= '<span class="avocado-sale-price"><span class="avocado-currencysymbol">'.get_woocommerce_currency_symbol().'</span><span>'.$product->get_sale_price().'</span></span>
								<del aria-hidden="true">
									<span class="raular-price"><span class="avocado-currencysymbol">'.get_woocommerce_currency_symbol().'</span><span>'.$product->get_regular_price().'</span></span>
							</del>'.$pount_per.'';
                }else{
                    $html  .= '<span class="avocado-get-price"><span class="avocado-currencysymbol">'.get_woocommerce_currency_symbol().'</span>'.$product->get_price().'</span>'.$pount_per.'';
                }
            }
    $html   .='</div>';
                  if( $product->is_type( 'variable' ) ){
                $html      .= '<a href="'.get_the_permalink().'" data-quantity="1" class="button product_type_variable add_to_cart_button" data-product_id="'.get_the_ID().'" data-product_sku="" aria-label="Select options for “”" rel="nofollow">Purchase Now</a>';
            }else {
                $html      .= '<a href="?add-to-cart='.get_the_ID().'" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="'.get_the_ID().'" aria-label="Add “" rel="nofollow">Add To Cart</a>';
            }
            $html .='
               <button class="circle-box" @click="productClose()">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                   </svg>
               </button>
             </div>
          </div>
            ';
            endwhile;
        $html .= '</div>';
          $html .=' <script>
            Vue.createApp({
                 data(){
                    return{
                    modal : false,
                    id    :"",
    
                    }
                },
                methods:{
                    productOpen(id){
                        this.modal = true;
                        this.id = id;
                    },
                    productClose(){
                        this.modal = false;
                   },
                },
                

            }).mount("#app")
            </script>';
        wp_reset_query();
        echo $html;

    }

}

















