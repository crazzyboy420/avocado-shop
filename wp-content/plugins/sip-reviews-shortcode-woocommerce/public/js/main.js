(function( $ ) {
	'use strict';

	//****** DOCUMENT READY FUNCTION ******//
	$(document).ready(function(){

		// Rating
		$(function() {
		    $('.example').barrating({theme: 'fontawesome-stars'});
		});
		//End

		jQuery(document).ready(function($) {
			$('.sip-star-rating').each(function () {
				//alert($(this).text());
				var value = $(this).text();
			 	$('.rating-readonly-'+value).barrating({theme: 'fontawesome-stars', readonly:true, initialRating: value });
		  	});
		});

		$('.example').barrating('show', {
		    onSelect:function(value, text) {
		        //your code goes here.
		        $('#div-to-be-revealed').toggleClass('invisible')
		        $('.show').slideDown();
		    }
		});

	});

})( jQuery );