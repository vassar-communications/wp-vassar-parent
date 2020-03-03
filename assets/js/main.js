jQuery(document).ready(function(){


	/*	Browser detection
		=================
		Yes yes yes you don't want to rely too heavily on this
	*/
	//	http://jsfiddle.net/jlubean/dL5cLjxt/
	var is_safari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
	var is_ios = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStr
	
	if(is_safari) jQuery( 'html' ).addClass( 'is-safari' );
	if(is_ios) { alert("yes"); jQuery( 'html' ).addClass( 'is-ios' ); }
});