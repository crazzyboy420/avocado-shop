<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://shopitpress.com
 * @since      1.0.9
 *
 * @package    Sip_Reviews_Shortcode_Woocommerce
 * @subpackage Sip_Reviews_Shortcode_Woocommerce/public/partials
 */

function sip_get_review_count( $product_id = '' ) {
	return get_post_meta( $product_id, '_wc_review_count', true );
}

function sip_get_avg_rating( $product_id = '' ) {
	return get_post_meta( $product_id, '_wc_average_rating', true );	
}

function sip_get_rating_count( $product_id = '' ) {
	return get_post_meta( $product_id, '_wc_rating_count', true );	
}

function sip_get_price( $product_id = '' ) {
	return get_post_meta( $product_id, '_price', true );	
}

add_action( 'wp_head', function() {

	$options = get_option( 'color_options' );
	$star_color = ( isset( $options['star_color'] ) ) ? sanitize_text_field( $options['star_color'] ) : '#d1c51d';
	echo '<style> .star-rating:before, .woocommerce-page .star-rating:before, .star-rating span:before, .br-theme-fontawesome-stars .br-widget a.br-selected:after { color: '.$star_color.'; }</style>';

}, 10 );