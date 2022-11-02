<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Avocado
 */

?>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'avocado' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-top">
			<div class="container">
				<div class="row">
					 <ul>
						 <li><a href="tel:+88 (0) 145 2589 000">+88 (0) 145 2589 000</a></li>
						 <li><a href="tel:+88 (0) 145 2589 000">+88 (0) 145 2589 000</a></li>
					 </ul>
				</div>
			</div>
		</div>
		<div class="main-header-area">
			<div class="container">
				<div class="row flex-display">
					<div class="col-lg-4">
						<ul class="social-area">
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
						</ul>
					</div>
					<div class="col-lg-4 text-center">
						<?php if(!empty(get_theme_mod( 'custom_logo'))){
							the_custom_logo();
						}else{
							?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						}
						?>
						<p class="header-text">the food that is cooked with love</p>
					</div>
					<div class="col-lg-4">
						<div class="header-right-area">
							<ul>
								<li><a href="#"><i class="far fa-user"></i></a></li>

								<li><a href="#"><i class="fas fa-shopping-cart"></i><span class="count">12</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="header-bottom-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">
					<div class="main-menu">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
						?>
						<a href="#" class="search-taggle"><i class="fas fa-search"></i></a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
	<div class="container">
