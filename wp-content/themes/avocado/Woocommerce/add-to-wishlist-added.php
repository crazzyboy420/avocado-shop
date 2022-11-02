<?php
/**
 * Add to wishlist button template - Added to list
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

<!-- ADDED TO WISHLIST MESSAGE -->
<div class="yith-wcwl-wishlistaddedbrowse" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-original-product-id="<?php echo esc_attr( $parent_product_id ); ?>">
	<span class="feedback">
		<?php echo wp_kses_post( $product_added_text ); ?>
	</span>
	<a href="<?php echo esc_url( $wishlist_url ); ?>" rel="nofollow" data-title="<?php echo esc_attr( $browse_wishlist_text ); ?>">
		<?php echo ( ! $is_single && 'before_image' === $loop_position ) ? yith_wcwl_kses_icon( $icon ) : false; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php echo wp_kses_post( apply_filters( 'yith_wcwl_browse_wishlist_label', $browse_wishlist_text, $product_id, $icon ) ); ?>
	</a>
</div>
