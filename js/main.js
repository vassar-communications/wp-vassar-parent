jQuery(document).ready(function(){

	var link = jQuery('.u-NavSite__main a').filter(function(index) { return jQuery(this).text() === "About"; });
	if(link.attr('href') != undefined) {
		jQuery( "body" ).append("<div class='red-alert'><div class='red-box'><h2>About page detected</h2>You don't need an About page! Put that content on the homepage instead.</div></div>");
	}


	jQuery( ".red-alert" ).click(function() {
		jQuery(this).remove();
	});
	
	
	/*	randomize banner */
	
	var banner = Math.floor((Math.random() * 5) + 1);
	banner = 'url(/wp-content/themes/vassar/assets/images/banners/' + banner + '.jpg)';
	document.documentElement.style.setProperty('--banner', banner);



	/*	flickity */
	
	jQuery('.wp-block-gallery').flickity({
	  // options
	  cellAlign: 'left',
	  contain: true
	});

});