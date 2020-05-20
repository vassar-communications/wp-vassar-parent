jQuery(document).ready(function(){


	/*	Browser detection
		=================
		Yes yes yes you don't want to rely too heavily on this
	*/
	//	http://jsfiddle.net/jlubean/dL5cLjxt/
	var is_safari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
	var is_ios = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStr
	var is_firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;				
					
	if(is_safari) jQuery( 'html' ).addClass( 'is-safari' );
	if(is_ios) { jQuery( 'html' ).addClass( 'is-ios' ); }
	if(is_firefox) { jQuery('html').addClass('is-ff'); }

});