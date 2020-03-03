jQuery(document).ready(function(){
	/*	randomize banner */
	
	var banner = Math.floor((Math.random() * 5) + 1);
	banner = 'url(/wp-content/themes/vassar/assets/images/banners/' + banner + '.jpg)';
	document.documentElement.style.setProperty('--banner', banner);
});