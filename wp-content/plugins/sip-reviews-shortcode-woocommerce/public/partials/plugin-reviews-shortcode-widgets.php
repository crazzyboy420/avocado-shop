<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://shopitpress.com
 * @since      1.1.4
 *
 * @package    Sip_Reviews_Shortcode_Woocommerce
 * @subpackage Sip_Reviews_Shortcode_Woocommerce/public/partials
 */

class Sip_Reviews_Shortcode_Woocommerce_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'sip_reviews_shortcode_widget',
			__( 'SIP reviews for WooCommerce', 'sip-reviews-shortcode' ),
			array(
				'classname'   => 'sip_reviews_shortcode_widget',
				'description' => __( 'Display product reviews in any post/page with a widget..', 'sip-reviews-shortcode' )
			)
		);
	}

	/**  
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {    
		GLOBAL $wpdb;
		extract( $args );

		if (isset($instance['title'])) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = "";
		}

		if (isset($instance['id'])) {
			$id = $instance['id'];
		} else {
			return;
		}

		if (isset($instance['no_of_reviews'])) {
			$no_of_reviews = $instance['no_of_reviews'];
		} else {
			$no_of_reviews = 5;
		}

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

	  	// if number of review not mention in shor coode then defaul value will be assign
		if( $no_of_reviews == "" ) {
			$no_of_reviews = 5;
		}

		$query 			= "SELECT post_title FROM {$wpdb->prefix}posts p WHERE p.ID = {$id} AND p.post_type = 'product' AND p.post_status = 'publish'";
		$product_title 	= $wpdb->get_var( $query );

		$options 	= get_option( 'color_options' );
	  	$star_color = ( isset( $options['star_color'] ) ) ? sanitize_text_field( $options['star_color'] ) : '#d1c51d';
	  	$bar_color 	= ( isset( $options['bar_color'] ) ) ? sanitize_text_field( $options['bar_color'] ) : '#AD74A2';

	  	?>
	  		<style type="text/css">.star-rating:before, .woocommerce-page .star-rating:before, .star-rating span:before {color: <?php echo $star_color; ?>;}</style>
	  	<?php

	  	if( $star_color != "")
	  		$star_color = "style='color:". $star_color .";'";

	  	if( $bar_color != "")
	  		$bar_color = "background-color:".$bar_color .";";

		// To check that post id is product or not
		if( get_post_type( $id ) == 'product' ) {
			// to get the detail of the comments etc aproved and panding status
			$comments_count = wp_count_comments( $id );
			?>

		<!--Wrapper: Start -->
		<div class="sip-rswc-wrapper"> 
		  	<!--Main Container: Start -->
		  	<div class="main-container">
		    	<aside class="page-wrap" itemscope itemtype="http://schema.org/Product" id="product-<?php echo $id; ?>">
		      		<div class="share-wrap">
			      		<?php //It calculate the rating for each star ?>
						<?php $ratings 	= array( 5, 4, 3, 2, 1 ); ?>
						<?php $result	= 0; ?>
						<?php 
							global $wpdb;
							$comments_approved 	= $wpdb->get_var( $wpdb->prepare("
														SELECT COUNT(comment_ID) FROM $wpdb->comments AS c
														WHERE c.comment_approved = 1
														AND c.comment_parent = 0
														AND c.comment_post_ID = %d
														", $id ) );

							$comments_approved_ = $comments_approved;
						?>
						<?php foreach ( $ratings as $rating ) : ?>
								<?php
								if( $comments_count->approved > 0 ) {
									$count 		= sip_wc_product_reviews_pro_get_product_rating_count( $id, $rating );
									$percentage = $count * $rating / $comments_approved ;
									$result 	= $result + $percentage;
								}
							?>
						<?php endforeach; ?>
						<?php $image = ""; ?>
						<?php if (has_post_thumbnail( $id ) ): ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' ); ?>
						<?php endif; ?>

						<!-- it is not for display it is only to generate schema for goolge search result -->
						<div style="display:none;">
							<a href="<?php echo $image[0]; ?>" itemprop="image"><?php echo $product_title; ?></a>
							<span itemprop="name"><?php echo $product_title; ?></span>
							<meta itemprop="url" content="<?php get_permalink( $id ); ?>">
							<div class="star_container" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
								<span itemprop="ratingValue"><?php echo number_format($result, 2); ?></span>
								<span itemprop="bestRating">5</span>
								<span itemprop="ratingCount"><?php echo $comments_approved_ ?></span>
								<span itemprop="reviewcount" style="display:none;"><?php echo $comments_approved_ ?></span>
							</div>
							<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
								<span itemprop="priceCurrency" content="<?php $currency = get_woocommerce_currency(); echo $currency; ?>"><?php echo get_woocommerce_currency_symbol($currency) ?></span>
								<meta itemprop="priceCurrency" content="<?php echo date('Y'); ?>">
								<meta itemprop="url" content="<?php get_permalink( $id ); ?>">
								<span itemprop="price" content="<?php $get_price = get_post_meta( $id , '_price' ); echo $get_price[0]; ?>"><?php echo get_woocommerce_currency_symbol(); echo $get_price[0]; ?></span>
								<link itemprop="availability" href="http://schema.org/InStock">
							</div>
							<?php
								$content_post = get_post( $id );
								$content = $content_post->post_content;
								$product_ = wc_get_product( $id );
	  							$sku_ = $product_->get_sku();
							?>
							<span style="display:none;" itemprop="sku"><?php echo $sku_; ?></span>
							<span itemprop="description"><?php echo $content ?></span>
						</div><!-- end itemscope -->

		        		<div class="share-left">
		          			<div class="big-text"><?php echo number_format( $result, 2 ); ?> <?php _e('out of 5 stars' , 'sip-reviews-shortcode');?></div>
		          			<div class="sm-text"><?php echo $comments_approved_ ?>
			          			<span class="review-icon-image"><?php _e('reviews' , 'sip-reviews-shortcode'); ?>
									<?php if(get_option('sip-rswc-affiliate-check-box') == "true") { ?>
										<?php $options = get_option('sip-rswc-affiliate-radio'); ?>
										<?php if( 'value1' == $options['option_three'] ) { $url = "https://shopitpress.com/?utm_source=referral&utm_medium=credit&utm_campaign=sip-reviews-shortcode-woocommerce" ; } ?>
										<?php if( 'value2' == $options['option_three'] ) { $url = "https://shopitpress.com/?offer=". esc_attr( get_option('sip-rswc-affiliate-affiliate-username')) ; } ?>
										<a class="sip-rswc-credit" href="<?php echo $url ; ?>" target="_blank" data-tooltip="<?php _e('These reviews were created with SIP Reviews Shortcode Plugin' , 'sip-reviews-shortcode'); ?>"></a>
									<?php } ?>
								</span>
							</div>
		        		</div><!-- .share-left -->

		        		<div class="share-right">
		          			<div class="product-rating-details">
		          				<table>
			            			<tbody>
										<?php $get_rating_count = sip_get_rating_count( $id ); ?>
										<?php for ( $i = 5; $i > 0 ; $i-- ) {
											if ( !isset( $get_rating_count[$i] ) ) {
												$get_rating_count[$i] = 0;
											}
											
											$percentage = 0 ;
											if ( $get_rating_count[$i] > 0 ) {
												$percentage = ($get_rating_count[$i] / $get_review_count) * 100;
											}
											$url = get_permalink(); ?>
											<tr>
												<td class="rating-number sip-stars-rating" data-number="<?php echo $i; ?>">
													<a href="javascript:void(0);" <?php echo $star_color; ?>><?php echo $i; ?> <span class="fas fa-star"></span></a>
												</td>

												<td class="rating-graph sip-stars-rating" data-number="<?php echo $i; ?>">
													<a style="float:left; <?php echo $bar_color; ?> width: <?php echo $percentage; ?>%" class="bar" href="javascript:void(0);" title="<?php printf( '%s%%', $percentage ); ?>"></a>
												</td>

												<td class="rating-count sip-stars-rating" data-number="<?php echo $i; ?>">
													<a href="javascript:void(0);" <?php echo $star_color; ?>><?php echo $count; ?></a>
												</td>

												<td class="rating-count sip-stars-rating" data-number="<?php echo $i; ?>">
													<a href="<?php echo $url; ?>#comments" <?php echo $star_color; ?>></a>
												</td>
											</tr>
										<?php } ?>
		            				</tbody>
	          					</table>
	          				</div>
	        			</div><!-- .share-right -->
      				</div>
					<!--Tabs: Start -->
					<aside class="tabs-wrap">
						<div class="page-wrap">
							<div class="tabs-content">
							<?php woocommerce_print_reviews( $id , $product_title , $no_of_reviews ); ?>
							</div>
						</div>
					</aside><!-- .tabs-wrap -->
					<!--Tabs: Start -->
	    		</aside>
	  		</div><!--Main Container: End --> 
		</div><!--Wrapper: End -->
		<div style="clear:both"></div>
		<?php

		}// end of post id is product or not

		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = ( isset($new_instance['title']) ? strip_tags( $new_instance['title'] ) : "" );
		$instance['id'] = ( isset($new_instance['id']) ? strip_tags( $new_instance['id'] ) : "" );
		$instance['no_of_reviews'] = ( isset($new_instance['no_of_reviews']) ? strip_tags( $new_instance['no_of_reviews'] ) : "" );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$id = "";
		if (isset($instance['id'])) {
			$id = esc_attr( $instance['id'] );
		}

		$title = "";
		if (isset($instance['title'])) {
			$title = esc_attr( $instance['title'] );
		}

		$no_of_reviews = 5;
		if (isset($instance['no_of_reviews'])) {
			$no_of_reviews = esc_attr( $instance['no_of_reviews'] ) ? esc_attr( $instance['no_of_reviews'] ) : 5 ;
		}

		$products_id = array(
			'post_type' => 'product',
			'posts_per_page' => -1
		);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sip-reviews-shortcode' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID:', 'sip-reviews-shortcode' ); ?></label>
			<?php 
				$res='';
				foreach(get_posts($products_id) as $val){
					$selected = "";
					if ( $id == $val->ID ) {
						$selected = 'selected ="selected"';
					}

					$res .= '<option value="'.$val->ID.'" '.$selected.'>'.$val->post_title.'</options>';
				}
				echo '<select id="'.$this->get_field_id('id').'" name="'.$this->get_field_name('id').'" class="sip-value" style="width: 100%;">'.$res.'</select>';
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('no_of_reviews'); ?>"><?php _e('No of reviews:', 'sip-reviews-shortcode' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('no_of_reviews'); ?>" name="<?php echo $this->get_field_name('no_of_reviews'); ?>" type="number" value="<?php echo $no_of_reviews; ?>" />
		</p>
		<?php 
	}
}

/* Register the widget */
add_action( 'widgets_init', function(){
	register_widget( 'Sip_Reviews_Shortcode_Woocommerce_Widget' );
});