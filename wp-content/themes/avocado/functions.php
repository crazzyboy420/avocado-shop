<?php
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'avocado_setup' ) ) :
	function avocado_setup() {
		load_theme_textdomain( 'avocado', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'avocado' ),
			)
		);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		add_theme_support(
			'custom-background',
			apply_filters(
				'avocado_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'avocado_setup' );

function avocado_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'avocado_content_width', 640 );
}
add_action( 'after_setup_theme', 'avocado_content_width', 0 );

function avocado_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'avocado' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'avocado' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Subscribe form', 'avocado' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'avocado' ),
			'before_widget' => '<section id="%1$s" class="widget Subscribe %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer section one', 'avocado' ),
			'id'            => 'footer-one',
			'description'   => esc_html__( 'Add footer section here.', 'avocado' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title footer-wiget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer section two', 'avocado' ),
			'id'            => 'footer-two',
			'description'   => esc_html__( 'Add footer section here.', 'avocado' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title footer-wiget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer section three', 'avocado' ),
			'id'            => 'footer-three',
			'description'   => esc_html__( 'Add footer section here.', 'avocado' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title footer-wiget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer section four', 'avocado' ),
			'id'            => 'footer-four',
			'description'   => esc_html__( 'Add footer section here.', 'avocado' ),
			'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title footer-wiget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Woocommerce Sidebar', 'avocado' ),
			'id'            => 'avocado_woocommerce',
			'description'   => esc_html__( 'Add woocommerce sidebar here.', 'avocado' ),
			'before_widget' => '<div id="%1$s" class="woocommerce-sidebar %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	
}
add_action( 'widgets_init', 'avocado_widgets_init' );
function avocado_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css', array(),'5.0.2','all' );
	wp_enqueue_style( 'font-awasome', get_template_directory_uri().'/assets/css/font-awesome.min.css', array(),'5.15.4','all' );
	wp_enqueue_style( 'default', get_template_directory_uri().'/assets/css/default.css', array(),'5.15.4','all' );
	wp_enqueue_style( 'avocado-style', get_stylesheet_uri(), array(), '1.0' );
	wp_style_add_data( 'avocado-style', 'rtl', 'replace' );
    
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/assets/js/bootstrap.bundle.min.js', array(),'5.0.2', true );
	wp_enqueue_script( 'font-awesome', get_template_directory_uri().'/assets/js/font-awesome.min.js', array(),'5.0.2', true );
	wp_enqueue_script( 'avocado-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
		wp_enqueue_script( 'avocado-avctive-js', get_template_directory_uri() . '/assets/js/active.js', array(),'1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'avocado_scripts' );

//Google Fonts
function avocado_google_fonts(){
	wp_enqueue_style( 'avocado_font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700&display=swap',false);
}
add_action( 'wp_enqueue_scripts','avocado_google_fonts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	add_action('customize_register','my_customize_register');
	function my_customize_register( $wp_customize ) {
		$wp_customize->add_section( 'woocomerce_shop_image',
			  array(
			    'title'      => __( 'Shop page image'),
			    'panel'      => 'woocommerce',
			    'capability' => '',
			    'priority'   => 200,
			  )
		);
	$wp_customize->add_setting('shop_feature_image',array(
		'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
	));
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'image_control', array(
		  'label' => __( 'Featured Shop Page Image', 'avocado' ),
		  'section' => 'woocomerce_shop_image',
		  'settings' => 'shop_feature_image'
		) ) );
	}
}