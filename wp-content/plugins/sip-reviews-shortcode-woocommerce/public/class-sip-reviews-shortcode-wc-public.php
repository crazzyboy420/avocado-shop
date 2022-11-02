<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://shopitpress.com
 * @since      1.0.0
 *
 * @package    SIP_Reviews_Shortcode
 * @subpackage SIP_Reviews_Shortcode/public
 */


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SIP_Reviews_Shortcode
 * @subpackage SIP_Reviews_Shortcode/public
 * @author     shopitpress <hello@shopitpress.com>
 */
class SIP_Reviews_Shortcode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'admin_init',  	array( $this, 'sip_rswc_settings_init' ) );
		add_action( 'admin_footer',	array( $this, 'sip_rswc_media_button_popup' ) );
		add_action( 'admin_footer',	array( $this, 'sip_rswc_add_shortcode_to_editor' ) );
		add_action( 'media_buttons_context', array( $this, 'sip_rswc_tinymce_media_button' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'sip_rswc_add_styles_scripts' ) );
	}

	/**
	 * Display our color field as a text input field.
	 *
	 * @since    	1.0.0
	 */
	private function color_input() {
		$options 					= get_option( 'color_options' );
		$star_color 				= ( $options['star_color'] != "" ) ? sanitize_text_field( $options['star_color'] ) : '';
		$bar_color 					= ( $options['bar_color'] != "" ) ? sanitize_text_field( $options['bar_color'] ) : '#AD74A2';
		$review_background_color 	= ( $options['review_background_color'] != "" ) ? sanitize_text_field( $options['review_background_color'] ) : '';
		$review_body_text_color 	= ( $options['review_body_text_color'] != "" ) ? sanitize_text_field( $options['review_body_text_color'] ) : '';
		$review_title_color 		= ( $options['review_title_color'] != "" ) ? sanitize_text_field( $options['review_title_color'] ) : '';
		$load_more_button 			= ( $options['load_more_button'] != "" ) ? sanitize_text_field( $options['load_more_button'] ) : '';
		$load_more_text 			= ( $options['load_more_text'] != "" ) ? sanitize_text_field( $options['load_more_text'] ) : '';
		?>
		<table>
			<tr>
				<td width="250"><strong><?php _e('Review stars', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="star-color" name="color_options[star_color]" type="text" value="<?php echo $star_color ?>" />
					<div id="star-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Reviews bar summary', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="bar-color" name="color_options[bar_color]" type="text" value="<?php echo $bar_color ?>" />
					<div id="bar-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Review background', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="review-background-color" name="color_options[review_background_color]" type="text" value="<?php echo $review_background_color ?>" />
					<div id="review-background-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Review body text', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="review-body-text-color" name="color_options[review_body_text_color]" type="text" value="<?php echo $review_body_text_color ?>" />
					<div id="review-body-text-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Review title', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="review-title-color" name="color_options[review_title_color]" type="text" value="<?php echo $review_title_color ?>" />
					<div id="review-title-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Load more button background', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="load-more-button-color" name="color_options[load_more_button]" type="text" value="<?php echo $load_more_button ?>" />
					<div id="load-more-button-colorpicker"></div>
				</td>
			</tr>
			<tr>
				<td><strong><?php _e('Load more button text', 'sip-reviews-shortcode' ); ?></strong></td>
				<td>
					<input id="load-more-button-text-color" name="color_options[load_more_text]" type="text" value="<?php echo $load_more_text ?>" />
					<div id="load-more-button-text-colorpicker"></div>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Generate inline content for the popup window when the "shortcode" button is clicked
	 *
	 * @since    	1.0.0
	 */
	public function sip_rswc_media_button_popup() { ?>
		<div id="shortcode_popup" style="display:none;">
			<div class="wrap">
				<div>
					<h2><?php _e('Insert Product Reviews', 'sip-reviews-shortcode' ); ?></h2>
					<div class="shortcode_add">
						<table>
							<tr>
								<th><label for="woocommerce_review_id"><?php _e('Product :', 'sip-reviews-shortcode' ); ?></label></th>
								<td>
								<?php
									$args = array(
										'post_type' => 'product',
										'posts_per_page' => -1
									);
									$res = '';
									foreach( get_posts($args) as $val ) {
										$post_title = str_replace( "'", "", $val->post_title );
										$res .= '<option value="'.$val->ID.'">'.$post_title.'</options>';
									}
									echo '<select id="woocommerce_review_id" name="woocommerce_review_id" class="sip-value">'.$res.'</select>';
								?>
								<br />
								</td>
							</tr>
							<tr>
								<th><label for="woocommerce_review_title"><?php _e('Custom Product Title :', 'sip-reviews-shortcode' ); ?></label></th>
								<td><input type="text" id="woocommerce_review_title"><br /></td>
							</tr>
							<tr>
								<th><label for="woocommerce_review_comments"><?php _e('No. of Reviews :', 'sip-reviews-shortcode' ); ?></label></th>
								<td>
									<input type="number" id="woocommerce_review_comments" min="1" value="5">
									<button class="button-primary" id="id_of_button_clicked"><?php _e('Insert Reviews', 'sip-reviews-shortcode' ); ?></button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * javascript code needed to make shortcode appear in TinyMCE edtor
	 *
	 * @since    	1.0.0
	 */
	public function sip_rswc_add_shortcode_to_editor() { ?>
		<script>
			jQuery('#id_of_button_clicked ').on('click',function(){
				var shortcode_id = jQuery('select[name="woocommerce_review_id"]').val();
				var shortcode_title = jQuery('#woocommerce_review_title').val();
				var shortcode_comments = jQuery('#woocommerce_review_comments').val();
				var shortcode = '[woocommerce_reviews id="'+shortcode_id+'"  product_title="'+shortcode_title+'"  no_of_reviews="'+shortcode_comments+'" ]';

				if( !tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
					jQuery('textarea#content').val(shortcode);
				} else {
					tinyMCE.execCommand('mceInsertContent', false, shortcode);
				}
				//close the thickbox after adding shortcode to editor
				self.parent.tb_remove();
			});
		</script>
		<?php
	}

	/**
	 * Add the script file.
	 *
	 * @since    	1.0.0
	 */
	public function sip_rswc_add_styles_scripts() {
		//Access the global $wp_version variable to see which version of WordPress is installed.
		global $wp_version;

		//If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
		if ( 3.5 <= $wp_version ){
			//Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
		//If the WordPress version is less than 3.5 load the older farbtasic color picker.
		else {
			//As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_script( 'farbtastic' );
		}

		//Load our custom Javascript file
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/settings.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Register settings, add a settings section, and add our color fields.
	 *
	 * @since    	1.0.0
	 */
	public function sip_rswc_settings_init(){

		register_setting(
			'wp_color_picker_options',
			'color_options',
			'validate_options'
		);
	}

	/**
	 * add the button to the tinymce editor
	 *
	 * @since    	1.0.0
	 */
	public function sip_rswc_tinymce_media_button( $context ) {
		return $context .= '<a href="#TB_inline?width=180&inlineId=shortcode_popup&width=540&height=153" class="button thickbox" id="shortcode_popup_button" title="Product Reviews">'.__('Product Reviews', 'sip-reviews-shortcode').'</a>';
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( "font-awesome", plugin_dir_url( __FILE__ ) . 'css/all.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . "-main", plugin_dir_url( __FILE__ ) . 'css/main.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . "-barrating", plugin_dir_url( __FILE__ ) . 'js/jquery.barrating.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . "-plugin", plugin_dir_url( __FILE__ ) . 'js/plugins.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name . "-main", plugin_dir_url( __FILE__ ) . 'js/main.min.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name . "-main", 'sip_rswc_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
}