<?php

/**
 * Plugin Name: Avoacado
 * Description: Custom avocado extension.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Rasel Ahmed
 * Author URI:  https://elementor.com/
 * Text Domain: avocado-toolkit
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
final class Avocado_Toolkit_Extension
{
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function __construct()
	{

		add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
	}

	public function i18n()
	{

		load_plugin_textdomain('avocado-toolkit');
	}
	public function on_plugins_loaded()
	{

		if ($this->is_compatible()) {
			add_action('elementor/init', [$this, 'init']);
		}
	}

	public function is_compatible()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
			return false;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			return false;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
			return false;
		}

		return true;
	}
	public function init()
	{

		$this->i18n();

		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
	}

	public function admin_notice_missing_main_plugin()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'avocado-toolkit'),
			'<strong>' . esc_html__('Elementor Test Extension', 'avocado-toolkit') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'avocado-toolkit') . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
	public function admin_notice_minimum_elementor_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'avocado-toolkit'),
			'<strong>' . esc_html__('Elementor Test Extension', 'avocado-toolkit') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'avocado-toolkit') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	public function admin_notice_minimum_php_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'avocado-toolkit'),
			'<strong>' . esc_html__('Elementor Test Extension', 'avocado-toolkit') . '</strong>',
			'<strong>' . esc_html__('PHP', 'avocado-toolkit') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
	public function init_widgets($wigets_meneger)
	{

		// Include Widget files
		require_once(__DIR__ . '/avocado-widgets/avocado-hero-widget.php');
		// Register widget
		$wigets_meneger->register(new \avocado_hero_widget());
		//Woocommerce
		if (class_exists('Woocommerce')) {
			require_once(__DIR__ . '/avocado-widgets/product-category-widget.php');
			require_once(__DIR__ . '/avocado-widgets/product-carousel-widget.php');
			require_once(__DIR__ . '/avocado-widgets/product-content.php');
			require_once(__DIR__ . '/avocado-widgets/section-title-widgets.php');
			require_once(__DIR__ . '/avocado-widgets/avocado-product-hover-cart.php');
			require_once(__DIR__ . '/avocado-widgets/avocado-title-widgets.php');
			require_once(__DIR__ . '/avocado-widgets/ajax-product-widget.php');
			require_once(__DIR__ . '/avocado-widgets/blog-post-widgets.php');
			require_once(__DIR__ . '/avocado-widgets/woocommerce_product_review.php');

			//Register Widgets
			$wigets_meneger->register(new product_categorise_widget());
			$wigets_meneger->register(new product_carousel_widget());
			$wigets_meneger->register(new product_content_widget());
			$wigets_meneger->register(new section_title_widget());
			$wigets_meneger->register(new avocado_product_hover_cart_widget());
			$wigets_meneger->register(new avocado_avocado_title_widgets());
			$wigets_meneger->register(new ajax_product_widget());
			$wigets_meneger->register(new blog_post_widget());
			$wigets_meneger->register(new Woocommerce_product_review());
		}
	}
}
Avocado_Toolkit_Extension::instance();

function avocado_toolkit_plugin_scripts()
{
	wp_enqueue_style('avocado-toolkit', plugins_url('/assets/css/avocado-toolkit.css', __FILE__), array(), '1.0', 'all');
	wp_enqueue_style('slick', plugins_url('/assets/css/slick.css', __FILE__), array(), '1.0', 'all');
	wp_enqueue_style('slick-theme', plugins_url('/assets/css/slick-theme.css', __FILE__), array(), '1.0', 'all');


	wp_enqueue_script('slick', plugins_url('/assets/js/slick.min.js', __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('count-down', plugins_url('/assets/js/jquery.countdown.min.js', __FILE__), array('jquery'), '1.0', true);
	wp_enqueue_script('vue', 'https://unpkg.com/vue@3', array('jquery'), true);
	//wp_enqueue_script( 'vude', 'https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js',array('jquery'),true);
}
add_action('wp_enqueue_scripts', 'avocado_toolkit_plugin_scripts');

//Category List
function product_categorise_list()
{
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		)
	);
	$cat_array = array();
	if (!empty($terms)) {
		foreach ($terms as $elements) {
			$terms_info = get_term($elements, 'product_cat');
			$cat_array[$terms_info->term_id] = $terms_info->name;
		}
	}
	return $cat_array;
}

//Custom product thumnail size
add_image_size('ch_product_size', 189, 189);
//Product Tap Ajax
add_action('wp_ajax_get_product_data', 'my_product_ajax');
add_action('wp_ajax_nopriv_get_product_data', 'my_product_ajax');


function my_product_ajax()
{
	if (wp_verify_nonce($_POST['get_nonce'], 'get_product_data')) {

		$args = array(
			'posts_per_page' => $_POST['count'],
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $_POST['dataid'],
				),
			),
		);

		$thumbnail_id = get_term_meta($_POST['dataid'], 'thumbnail_id', true);
		$category_imgae = wp_get_attachment_image_url($thumbnail_id, 'medium');
		$html = '';

		$html .= '<div class="col-lg-6  maring-b-20"><div class="ajax-category-img" style="background-image:url(' . $category_imgae . ')"></div></div>';
		$loop = new WP_Query($args);
		while ($loop->have_posts()) : $loop->the_post();
			global $product;
			$product_image = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()), 'medium');
			$html .= '<a href="' . get_the_permalink(get_the_ID()) . '" class="single-product col-lg-2  maring-b-20">
				  		   <div style="background-image:url(' . $product_image . ')" class="product-featured"></div>  
						   <h4>' . get_the_title() . '</h4>
		                   <div class="product-price">' . $product->get_price_html() . '</div>
				   </a>';
		endwhile;
		wp_reset_query();
	} else {
		$html = '<p class="alert alert-danger">Error!<p>';
	}
	echo $html;
	die();
}
//Blog Post Thumnail Image size
add_image_size('blog_image', 390, 278, true);
//Category List
function avocado_product_categorise_list(){
    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        )
    );

    $cat_array = array();
    foreach($terms as $term){
        $cat_info = get_term($term ,'product_cat');
        $cat_array[$cat_info->term_id] = $cat_info->name;
    }
    return $cat_array;
}

//Product List
function avocado_product_list() {
    $args = wp_parse_args(array(
        'post_type'  => 'product',
        'numberposts' => -1,
    ));
    $posts = get_posts($args);

    $post_options = array();

    if($posts){
        foreach($posts as $post){
            $post_options[ $post ->ID] = $post ->post_title;
        }
    }

    return $post_options;
}