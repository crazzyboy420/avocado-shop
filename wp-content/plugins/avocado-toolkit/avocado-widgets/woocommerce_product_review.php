<?php
class Woocommerce_product_review extends \Elementor\Widget_Base
{
	public function get_name()
	{
		return 'woocommerce_product_review_widgets';
	}
	public function get_title()
	{
		return __('Product Review List', 'avocado-toolkit');
	}

	public function get_icon()
	{
		return 'eicon-code';
	}
	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'avocado-toolkit'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __('Title', 'avocado-toolkit'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Featured Categories', 'avocado-toolkit'),
				'label_block' => true,
			]
		);
		$this->add_control(
			'content',
			[
				'label' => __('Content', 'avocado-toolkit'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Healthy food at an affordable price', 'avocado-toolkit'),
				'label_block' => true,
			]
		);
		$this->end_controls_section();
	}
	protected function render()
	{

		$settings = $this->get_settings_for_display();
		$args = array('post_type' => 'product', 'posts_per_page' => '-1');
		$comments = get_comments($args);
		$html = '<script>
	  jQuery(document).ready(function($) {
		  $("#product_review_slider").slick({
			 slidesToShow: 5,
		  });
       });
     </script>';
		$html .= '<div class"woocommerce_product_review" id="product_review_slider">';
		if (!empty($comments)) {
			foreach ($comments as $comment) {
				$html .= '<a href="' . get_the_permalink($comment->comment_post_ID) . '" class="slider-padding">
				     <div class="single-product-review">
                         <div class="product-review-thumbnail" style="background-image:url(' . get_the_post_thumbnail_url($comment->comment_post_ID, 'thumbnail') . ')"></div>
						 <h3 class="review-title">' . get_the_title($comment->comment_post_ID) . '</h3>
						 <p>' . $comment->comment_content . '</p>
                      </div>
				   </a>';
			}
			$html .= '</div>';
		} else {
			$html .= '<p class="not-fount">Comment not fount</p>';
		}
		echo $html;
	}
}
