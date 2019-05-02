jQuery(document).ready(function() {

	/* Upsells in customizer (Documentation, Reviews and Support links */
	if( !jQuery( ".aberration-info" ).length ) {
		
		jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section aberration-info">');
	
		jQuery('.aberration-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://www.shapedpixels.com/setup-aberration-lite/" class="button" target="_blank">{setup}</a>'.replace('{setup}', aberrationliteCustomizerObject.setup));
		
		jQuery('.aberration-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/view/theme-reviews/aberration-lite" class="button" target="_blank">{review}</a>'.replace('{review}', aberrationliteCustomizerObject.review));
		
		jQuery('.aberration-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/theme/aberration-lite" class="button" target="_blank">{support}</a>'.replace('{support}', aberrationliteCustomizerObject.support));
		
		jQuery('.aberration-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://www.shapedpixels.com/aberration" class="button" target="_blank">{pro}</a>'.replace('{pro}',aberrationliteCustomizerObject.pro));

		jQuery('#customize-theme-controls > ul').prepend('</li>');
	}
	
});