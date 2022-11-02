<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $woocommerce;

if (!empty($_GET['mode'])) {
	$mode = $_GET['mode'];
}else{
	$mode = '';
}


// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
   <?php if($mode == 'list'): ?>
   	<?php add_action('product_reating','woocommerce_template_loop_rating',5); ?>
    <div class="avocado_single_product_list">
        <div style="background-image:url(<?php echo the_post_thumbnail_url( 'medium' ) ?>)" class="avocado_product_thumb_list"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>"></a></div>
        <div class="avocado-product-info_list">
            <a class="product-heading" href="<?php echo get_the_permalink( get_the_ID() ); ?>"><?php echo the_title(); ?></a>
             <?php if($product->is_on_sale()): ?>
			      <div class="variable-product-price"><?php echo $product->get_price_html(); ?></div>
			 <?php else:?>
			      <div class="product-price"><?php echo $product->get_price_html(); ?></div>
			 <?php endif;?>
			  <?php do_action('product_reating') ?> 
			 <?php if (!empty(get_the_excerpt( get_the_ID() ))) {?>
			 	<p><?php echo get_the_excerpt( get_the_ID()); ?></p>
			 <?php } ?>
			 <div class="list-view-add-details avocado_single_product">
				<!--Add To Cart-->
				 <?php if( $product->is_type( 'simple' ) ):?>
					<?php echo "<a class='add_to_cart button' href='".$product->add_to_cart_url()."'>add to cart</a>"; ?>
					<?php else: ?>
					   <?php echo "<a class='add_to_cart button' href='".$product->add_to_cart_url()."'>Select Options</a>"; ?>
				<?php endif; ?>
				<!--Add to wishlist-->
				<?php echo do_shortcode("[yith_wcwl_add_to_wishlist label ='<i class=\"far fa-heart\"></i>' product_added_text='' browse_wishlist_text='' already_in_wishslist_text='']")?>
				<!--Compare--->
				<a href="<?php echo site_url() ?>?action=yith-woocompare-add-product&amp;id=<?php echo get_the_ID(); ?>" class="compare button" data-product_id="<?php echo get_the_ID(); ?>" rel="nofollow"></i></a>
           </div>
	    </div>
    </div> 
<?php else: ?>
	<div class="avocado_product">
    <div class="avocado_single_product">
        <div style="background-image:url(<?php echo the_post_thumbnail_url( 'medium' ) ?>)" class="avocado_product_thumb">
		<?php echo do_shortcode("[yith_wcwl_add_to_wishlist label ='<i class=\"far fa-heart\"></i>' product_added_text='' browse_wishlist_text='' already_in_wishslist_text='']")?>
		<a href="<?php echo site_url() ?>?action=yith-woocompare-add-product&amp;id=<?php echo get_the_ID(); ?>" class="compare button" data-product_id="<?php echo get_the_ID(); ?>" rel="nofollow"></i></a>
        </div>
        <div class="avocado-product-info price">
            <h4><?php echo the_title(); ?></h4>
            <?php if($product->is_on_sale()): ?>
             <div class="variable-product-price"><?php echo $product->get_price_html(); ?></div>
             <?php else:?>
              <div class="product-price"><?php echo $product->get_price_html(); ?></div>
              <?php endif;?>
			  <?php if( $product->is_type( 'simple' ) ):?>
				<?php echo "<a class='add_to_cart button' href='".$product->add_to_cart_url()."'>add to cart</a>"; ?>
			 <?php else: ?>
				<?php echo "<a class='add_to_cart button' href='".$product->add_to_cart_url()."'>Select Options</a>"; ?>
			<?php endif; ?>
        </div>
    </div> 
</div>
<?php endif; ?>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	//do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	//do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
