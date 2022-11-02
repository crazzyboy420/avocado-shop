
jQuery(document).ready(function($){
	  var url = window.location;
// Will only work if string in href matches with location
    $('.woocommerce-sidebar ul li a[href="' + url + '"]').parent().addClass('active');
});
