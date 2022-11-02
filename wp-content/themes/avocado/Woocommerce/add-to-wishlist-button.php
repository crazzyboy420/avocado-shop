<?php
/**
 * Add to wishlist button template
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\AddToWishlist
 * @version 3.0.12
 */

/**
 * Template variables:
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-button">
	<a
		href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'add_to_wishlist', $product_id, $base_url ), 'add_to_wishlist' ) ); ?>"
		class="<?php echo esc_attr( $link_classes ); ?>"
		data-product-id="<?php echo esc_attr( $product_id ); ?>"
		data-product-type="<?php echo esc_attr( $product_type ); ?>"
		data-original-product-id="<?php echo esc_attr( $parent_product_id ); ?>"
		data-title="<?php echo esc_attr( apply_filters( 'yith_wcwl_add_to_wishlist_title', $label ) ); ?>"
		rel="nofollow"
	>
		<span><?php echo wp_kses_post( $label ); ?></span>
	</a>
</div>
