<?php
/**
 * Woocommerce Compare counter shortcode template
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 2.3.2
 */

defined( 'YITH_WOOCOMPARE' ) || exit; // Exit if accessed directly.

global $yith_woocompare;
?>

<div class="yith-woocompare-counter" data-type="<?php echo esc_attr( $type ); ?>" data-text_o="<?php echo esc_attr( $text_o ); ?>">
	<a class="yith-woocompare-open" href="<?php echo esc_url( $yith_woocompare->obj->view_table_url() ); ?>">
		<span class="yith-woocompare-counter">
			<span class="yith-woocompare-count">
				<?php
			
						echo esc_html( $items_count );
		
				?>
			</span>
		</span>
	</a>
</div>
