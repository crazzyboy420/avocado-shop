<?php
class blog_post_widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'blog_post_carousel';
    }
    public function get_title()
    {
        return __('Blog Post Carousel', 'avocado-toolkit');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'avocado-toolkit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'count',
            [
                'label' => __('Count', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default'  => 5,
            ]
        );
        $this->add_control(
            'select_options',
            [
                'label' => __('Select Options', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'select_product'  => __('Select Product', 'avocado-toolkit'),
                    'select_categorise' => __('Select Categorise', 'avocado-toolkit'),
                    'product_type' => __('Product Type', 'avocado-toolkit'),
                ],
                'label_block' => true,
                'multiple' => true,
            ]
        );
        $this->add_control(
            'select_category',
            [
                'label' => __('Select Categorise', 'avocado-toolkit'),
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
                'label' => __('Select Product', 'avocado-toolkit'),
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
                'label' => __('Select Product Type', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'recent_product'  => __('Recent Product', 'avocado-toolkit'),
                    'feature_product' => __('Feature Product', 'avocado-toolkit'),
                    'top_rating' => __('Top Rating Product', 'avocado-toolkit'),
                    'sell_product' => __('Sell  Product', 'avocado-toolkit'),
                    'best_selling_product' => __('Best Selling Product', 'avocado-toolkit'),
                ],
                'label_block' => true,
                'multiple' => true,
                'default' => 'sell_product',
                'condition' => [
                    'select_options' => ['product_type'],
                ],
            ]
        );
        $this->add_control(
            'enable_title',
            [
                'label' => __('Show Title', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'avocado-toolkit'),
                'label_off' => __('No', 'avocado-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Product Top Title', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Today Deal', 'avocado-toolkit'),
                'label_block' => true,
                'condition' => [
                    'enable_title' => ['yes'],
                ],
            ]
        );
        $this->add_control(
            'enable_count_down',
            [
                'label' => __('Enable Count Down', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'EW-toolkit'),
                'label_off' => __('No', 'EW-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'count_down',
            [
                'label' => __('Count Down Timer', 'avocado-toolkit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('2021/11/29', 'avocado-toolkit'),
                'label_block' => true,
                'condition' => [
                    'enable_count_down' => ['yes'],
                ],
                'description' => 'farmat:year/month/date Hour:M:S'
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'sldie_settings',
            [
                'label' => __('Slider Settings', 'EW-toolkit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'enable_loop',
            [
                'label' => __('Enable Loop?', 'EW-toolkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'EW-toolkit'),
                'label_off' => __('No', 'EW-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]

        );
        $this->add_control(
            'enable_fade',
            [
                'label' => __('Enable Fade Effect?', 'EW-toolkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'EW-toolkit'),
                'label_off' => __('No', 'EW-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]

        );
        $this->add_control(
            'enable_nav',
            [
                'label' => __('Enable Nav?', 'EW-toolkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'EW-toolkit'),
                'label_off' => __('No', 'EW-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]

        );
        $this->add_control(
            'enable_autoplay',
            [
                'label' => __('Enable Autoplay', 'EW-toolkit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'EW-toolkit'),
                'label_off' => __('No', 'EW-toolkit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]

        );
        $this->add_control(
            'autoplayspeed',
            [
                'label' => __('Autoplay Speed', 'EW-toolkit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5000',
                'condition' => [
                    'enable_autoplay' => 'yes'
                ],
                'options' => [
                    '1000'  => __('1 Secound', 'EW-toolkit'),
                    '2000' => __('2 Secound', 'EW-toolkit'),
                    '3000' => __('3 Secound', 'EW-toolkit'),
                    '4000' => __('4 Secound', 'EW-toolkit'),
                    '5000' => __('5 Secound', 'EW-toolkit'),
                    '6000' => __('6 Secound', 'EW-toolkit'),
                    '7000' => __('7 Secound', 'EW-toolkit'),
                    '8000' => __('8 Secound', 'EW-toolkit'),
                    '9000' => __('9 Secound', 'EW-toolkit'),
                    '10000' => __('10 Secound', 'EW-toolkit'),
                    '11000' => __('11 Secound', 'EW-toolkit'),
                    '12000' => __('12 Secound', 'EW-toolkit'),
                    '13000' => __('13 Secound', 'EW-toolkit'),
                    '14000' => __('14 Secound', 'EW-toolkit'),
                    '15000' => __('15 Secound', 'EW-toolkit'),
                ],
            ]
        );
        $this->end_controls_section();
    }
    protected function render()
    {

        $settings = $this->get_settings_for_display();
        // if (!empty($settings['select_options']) && $settings['select_options'] == 'product_type') {
        //     if ($settings['product_type'] == 'recent_product') {

        //     } elseif ($settings['product_type'] == 'feature_product') {
        //         $meta_query  = WC()->query->get_meta_query();
        //         $tax_query   = WC()->query->get_tax_query();
        //         $tax_query[] = array(
        //             'taxonomy' => 'product_visibility',
        //             'field'    => 'name',
        //             'terms'    => 'featured',
        //             'operator' => 'IN',
        //         );

        //         $args = array(
        //             'post_type'           => 'post',

        //             'posts_per_page' => $settings['count'],
        //             'meta_query'          => $meta_query,
        //             'tax_query'           => $tax_query,
        //         );
        //     } elseif ($settings['product_type'] == 'top_rating') {
        //         $args = array(
        //             'posts_per_page' => $settings['count'],
        //             'post_status'    => 'publish',
        //             'post_type'      => 'post',
        //             'meta_key'       => '_wc_average_rating',
        //             'orderby'        => 'meta_value_num',
        //             'meta_query'     => WC()->query->get_meta_query(),
        //             'tax_query'      => WC()->query->get_tax_query(),
        //         );
        //     } elseif ($settings['product_type'] == 'sell_product') {
        //         $args = array(
        //             'post_type' => 'post',
        //             'meta_query'     => array(
        //                 'relation' => 'OR',
        //                 array( // Simple products type
        //                     'key'           => '_sale_price',
        //                     'value'         => 0,
        //                     'compare'       => '>',
        //                     'type'          => 'numeric'
        //                 ),
        //                 array( // Variable products type
        //                     'key'           => '_min_variation_sale_price',
        //                     'value'         => 0,
        //                     'compare'       => '>',
        //                     'type'          => 'numeric'
        //                 )
        //             ),
        //             'posts_per_page' => $settings['count'],
        //         );
        //     } elseif ($settings['product_type'] == 'best_selling_product') {
        //         $args = array(
        //             'post_type' => 'post',
        //             'meta_key' => 'total_sales',
        //             'orderby' => 'meta_value_num',
        //             'posts_per_page' => $settings['count'],
        //         );
        //     } else {
        //         $args = array(
        //             'post_type' => 'post',
        //         );
        //     }
        // } elseif ($settings['select_options'] == 'select_categorise') {
        //     $args = array(
        //         'post_type' => 'post',
        //         'posts_per_page' => $settings['count'],
        //         'tax_query' => array(
        //             array(
        //                 'taxonomy' => 'product_cat',
        //                 'field' => 'term_id',
        //                 'terms' => $settings['select_category'],
        //                 'operator' => 'IN'
        //             )
        //         )
        //     );
        // } elseif ($settings['select_options'] == 'select_product') {
        //     $args = array(
        //         'post_type' => 'post',
        //         'posts_per_page' => $settings['count'],
        //         'post__in' => $settings['product_list'],

        //     );
        // }
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'order' => 'DESC',
            'orderby' => 'ID',
            'posts_per_page' => 10,
        );
        if ($settings['enable_loop'] == 'yes') {
            $loops = 'true';
        } else {
            $loops = 'false';
        }
        if ($settings['enable_fade'] == 'yes') {
            $fade = 'true';
        } else {
            $fade = 'false';
        }
        if ($settings['enable_nav'] == 'yes') {
            $nav = 'true';
        } else {
            $nav = 'false';
        }
        if ($settings['enable_autoplay'] == 'yes') {
            $autoplay = 'true';
        } else {
            $autoplay = 'false';
        }
        $loop = new WP_Query($args);

        $html = '<script>
	  jQuery(document).ready(function($) {
		  $(".blog-post").slick({
            slidesToShow: 4,
  slidesToScroll: 1,
			infinite: ' . $loops . ',
			speed: 300,
			nextArrow:"<button class=\'arrow-next\'><i class=\'fas fa-angle-right\'></i></button>",
			prevArrow:"<button class=\'arrow-prev\'><i class=\'fas fa-angle-left\'></i></button>",
			arrows:' . $nav . ',
			fade:' . $fade . ',
			autoplay:' . $autoplay . ',';
        if ($autoplay == 'true') {
            $html .= 'autoplaySpeed: ' . $settings['autoplayspeed'] . ',';
        }
        $html .= '
         });
      });
     </script>';
        $html .= '<div class="blog-post">';
        while ($loop->have_posts()) : $loop->the_post();
            $html .= '
          <div class="single-blog-post">
            <a class="single-post-link" href="' . get_the_permalink() . '"></a>
             <div class="blog-post-bg">' . get_the_post_thumbnail(get_the_ID(), 'blog_image', 'class=blog-height') . '</div>
              <h3>' . get_the_title() . '</h3>
              <span>' . get_the_date('d.m.y') . '</span>
          </div>';
        endwhile;
        $html .= '</div>';
        wp_reset_query();
        echo $html;
    }
}
