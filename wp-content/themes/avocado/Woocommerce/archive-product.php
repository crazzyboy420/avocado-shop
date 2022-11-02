<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
if(is_active_sidebar( 'avocado_woocommerce' )){
	$culum = 'col-lg-8';
}else{
	$culum = 'col';
}


?>
<div class="row mt-4">
	<?php if(is_active_sidebar( 'avocado_woocommerce' )){?>
	<div class="col-lg-4">
		<?php dynamic_sidebar('avocado_woocommerce');?>
	</div>
    <?php } ?>
	<div class="<?php echo esc_attr($culum) ?> woocommerce-category">
		<?php 
		  if (is_product_category()) {
		  	  $thumb_id = get_term_meta(get_queried_object_id(),'thumbnail_id',true);

		  	  $thumb_image_url = wp_get_attachment_image_url($thumb_id,'large');
		  }
		  if (is_shop()) {
			  $custom_logo_id = get_theme_mod( 'shop_feature_image' );
			  $shop_thumb_img = wp_get_attachment_image_url($custom_logo_id,'large');?>
			  <div class="cat-image" style="background-image: url(<?php echo esc_url($shop_thumb_img) ?>);"></div>
         <?php
		  }
          if (!empty($thumb_image_url)) {?>
          	<div class="cat-image" style="background-image: url(<?php echo esc_url($thumb_image_url) ?>);"></div>
          	<?php
          }

		?>
		<header class="woocommerce-products-header">

			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>

			<?php
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			//do_action( 'woocommerce_archive_description' );
			?>
		</header>
		<?php
		$product_cat_object = get_term_children( get_queried_object_id(), 'product_cat' ); ?>
        <div class="row">
		<?php
		if (!empty($product_cat_object)) {
			foreach($product_cat_object as $product_cat){
				$chid_cat_id = get_term_meta($product_cat,'thumbnail_id',true);
		  	    $child_cat_image_url = wp_get_attachment_image_url($chid_cat_id,'thumbnail');
		  	    $child_tarm_info = get_term($product_cat,'product_cat');
		  	    $child_cat_link = get_term_link($product_cat,'product_cat');
		  	    ?>
		  	    
		  	   <div class="col-lg-4 mb-5">
		  	    <a class="child-cat d-flex" href="<?php echo esc_url($child_cat_link) ?>">
		  	    	 <?php if (!empty($chid_cat_id)) : ?>
		  	   	    <img src="<?php echo esc_url($child_cat_image_url) ?>" alt="">
		  	     	 <?php endif; ?>
		  	   	   <h3 class="d-inline-block"><?php echo esc_html($child_tarm_info->name) ?></h3>
		  	    </a>
		  	   </div>
		
		  	    <?php
			}
		}
		?>
		</div>
		<?php
		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
		  // do_action( 'woocommerce_before_shop_loop' );

			$grid_mode = $list_mode = $_GET;
			$grid_mode['mode'] = 'grid';
			$list_mode['mode'] = 'list';
            if (!empty($_GET['mode'])) {
            	if ($_GET['mode'] == 'list') {
            		$class1 = 'active';
            		$class2 = '';
            	}else{
            		$class1 = '';
            		$class2 = 'active';
            	}
            }else{
            	$class1 = '';
            	$class2 = 'active';
            }
			?> 

			<div class="woocommerce-before-shop-content">
				<div class="grid-list">
					<a class="<?php echo esc_attr($class2) ?> product-change-icon" href="?<?php echo http_build_query($grid_mode); ?>"><i class="fa fa-th" aria-hidden="true"></i></a>
			        <a class="<?php echo esc_attr($class1) ?> product-change-icon" href="?<?php echo http_build_query($list_mode); ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
				</div>
				<div class="product-before-content">
					<?php 
					echo do_shortcode("[yith_woocompare_counter]");
				    add_action('woocomer_categlo','woocommerce_catalog_ordering',30);
				    do_action('woocomer_categlo');
					?>
				</div>
			</div>
			<?php
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

get_footer( 'shop' );
