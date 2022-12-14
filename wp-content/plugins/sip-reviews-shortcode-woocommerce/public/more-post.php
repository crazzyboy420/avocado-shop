<?php 

add_action( 'wp_ajax_more_post_default_style', 'more_post_default_style_callback' );
add_action( 'wp_ajax_nopriv_more_post_default_style', 'more_post_default_style_callback' );

function more_post_default_style_callback() {
	global $wpdb; // this is how you get access to the database
	check_ajax_referer( 'sip-rswc-more-post-default-style', 'security' );
	$last_id_post	= sanitize_text_field($_POST['last_id_post']);
	$last_id_post 	= explode("-", $last_id_post);
	$limit			= intval( $_POST['limit'] );
	$title 			= sanitize_text_field($_POST['title']);
	$id 			= intval( $_POST['id'] );

	$options = get_option( 'color_options' );
  	$star_color = ( isset( $options['star_color'] ) ) ? sanitize_text_field( $options['star_color'] ) : '';
  	$load_more_button = ( isset( $options['load_more_button'] ) ) ? sanitize_text_field( $options['load_more_button'] ) : '';
	$load_more_text = ( isset( $options['load_more_text'] ) ) ? sanitize_text_field( $options['load_more_text'] ) : '';

	$review_body_text_color = ( isset( $options['review_body_text_color'] ) ) ? sanitize_text_field( $options['review_body_text_color'] ) : '';
	$review_background_color = ( isset( $options['review_background_color'] ) ) ? sanitize_text_field( $options['review_background_color'] ) : '';
	$review_title_color = ( isset( $options['review_title_color'] ) ) ? sanitize_text_field( $options['review_title_color'] ) : '';
			
	$button = 'style="';
	if( $load_more_button != "")
		$button .= 'background-color:'. $load_more_button .';';
	if( $load_more_text != "")
		$button .= 'color:'. $load_more_text .';';
	$button .= '"';

  if( $review_title_color != "")
		$review_title_color = "style='color:". $review_title_color .";'";

	$review_background = 'style="';
	if( $review_background_color != "")
		$review_background .= 'background-color:'. $review_background_color .';';
	if( $review_body_text_color != "")
		$review_background .= 'color:'. $review_body_text_color .';';
	$review_background .= '"';
		
	$query = $wpdb->prepare("SELECT c.* FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = %d AND p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 AND c.comment_ID < %d AND c.comment_parent = 0 ORDER BY c.comment_date DESC limit %d", $id, $last_id_post[3], $limit );
	$comments_products = $wpdb->get_results($query, OBJECT);
		
	$out_reviews = "";
	if ( $comments_products ) {

		foreach ( $comments_products as $comment_product ) {
			$id_ 			= $comment_product->comment_post_ID;
			$name_author 	= $comment_product->comment_author;
			$comment_id  	= $comment_product->comment_ID;
			$comment_parent = $comment_product->comment_parent;
			$comment_date  	= get_comment_date( 'M d, Y', $comment_id );
			$_product 		= wc_get_product( $id_ );
			$rating 		= intval( get_comment_meta( $comment_id, 'rating', true ) );
			$user_id	 	= $comment_product->user_id;
			$votes 			= "";
			$avatar 		= "";
			$comment_chield	= "";

			$args = array(
		    'status' 	=> 'approve', 
		    'number' 	=> '5',
		    'post_id' 	=> $id_,
		    'parent' 	=> $comment_id
			);
			$comments 			= get_comments($args);
			$comments_length 	= count($comments);
			$iteration    		= -1;
			$comment_parent_id  = $comment_id;

			do {

					if( $comment_parent  > 0 ){
						$comment_chield = " show-everthing-sub";
					}

					$out_reviews .= '<li itemprop="review" itemscope="" itemtype="http://schema.org/Review" id="li-comment-'.$id.'-'.$comment_parent_id.'" class="show-everthing ShowEve '.$comment_chield.'"> 
										<div class="comment-borderbox" '.$review_background.'> 
											<div itemprop="itemReviewed" itemscope="" itemtype="http://schema.org/Product" style="display:none;">
												<span itemprop="name">'.$title.'</span>
											</div>';

											if( $comment_parent == 0 ) {
												$out_reviews .=	'<div class="br-wrapper br-theme-fontawesome-stars"><p class="sip-star-rating" style="display:none;">'.$rating.'</p><select class="rating-readonly-'.$rating.'"><option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>';
											}
							$out_reviews .=	'<p class="author" '.$review_title_color.' itemprop="author">
												<strong>'.$name_author.'</strong> ??? <time itemprop="datePublished" datetime="'.$comment_date.'">'.$comment_date.'</time>
											 </p>';

						if ( !get_option('sip-rswc-setting-limit-review-characters') ) {
							
							$out_reviews .= '<div itemprop="description">
												<p style="color:'.$review_body_text_color.'">'.nl2br( get_comment_text( $comment_id ) ).'</p>
											</div>';
						} else {

							$out_reviews .=	'<div itemprop="description">
												<div class="hide-'.$id_."-".$comment_id.'">
													<p style="color:'.$review_body_text_color.'">'.nl2br( get_comment_excerpt_trim( $id_ , $comment_id ) ).'</p>
												</div>
												<p class="comment-'.$id_."-".$comment_id.'-full" style="display:none;color:'.$review_body_text_color.'">'.nl2br( get_comment_text( $comment_id ) ).'</p>
											</div>';
						}

						$out_reviews 	.=	'</div>
									</li>';

					$out_reviews .= '<script>
										jQuery(".comment-'.$id_."-".$comment_id.'").click(function(){
											jQuery(".comment-'.$id_."-".$comment_id.'-full").show();
											jQuery(".hide-'.$id_."-".$comment_id.'").hide();
										});
									</script>';
				++$iteration;
				++$comment_parent;
				if( $comments_length > 0 ) {
					if( !empty($comments[$iteration]->comment_author) ) {
						$name_author = $comments[$iteration]->comment_author;
					}
					if( !empty( $comments[$iteration]->comment_ID ) ) {
						$comment_date = get_comment_date( 'M d, Y', $comments[$iteration]->comment_ID );	
					}
					if( !empty($comments[$iteration]->comment_ID )) {
						$comment_id = $comments[$iteration]->comment_ID;	
					}	
				}

			} while ( $comments_length > $iteration );

		}//end of lop
				?>
	<?php
	// when last record add text "No more posts to load" to button.
	echo $out_reviews;
	}
	wp_die( );
}