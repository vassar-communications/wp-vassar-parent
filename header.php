<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Vassar
 */

?>
<!doctype html>

<?php

//	Here's where we set up the HTML classes.

$additional_classes = 'no-js ';

//	First of all: to subnav or not to subnav?

if(has_subpage()) $additional_classes .= ' has-subnav';
else $additional_classes .= ' no-subnav';

//	Now then; do we have a sidebar or not?

$no_sidebar = get_post_meta($post->ID, 'vpress__no-sidebar', true);

if($no_sidebar) $additional_classes .= ' no-sidebar';
else $additional_classes .= ' has-sidebar';

//	On Offices, the blog feature is being used for announcements. Since it's a list of
//	announcements, we want a more compact layout for each post similar to the standard Vassar news page.

if(!is_singular() && cfg('BLOG__USE_MINIPOST')) $additional_classes .= ' minimal-post-on-frontpage';

if(has_post_thumbnail()) $additional_classes .= ' has-post-thumbnail';

//	Get the root parent for this page

$this_post_parent = get_root_parent($post);
$parent_slug = $this_post_parent->post_name;

$additional_classes .= ' rootParent-'.$parent_slug;

?>

<html <?php language_attributes(); ?> <?php body_class($additional_classes); ?>>
<head>
	
	
	
<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-301357-5"></script>
<script>
 window.dataLayer = window.dataLayer || [];
 function gtag(){dataLayer.push(arguments);}
 gtag('js', new Date());
 gtag('config', 'UA-301357-5');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WCS4M7');</script>
<!-- End Google Tag Manager -->
	
	
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">


	<?php vassar_socialcard(); ?>

	<?php wp_head(); ?>
	
	<?php if(cfg('SITE__TYPEKIT_ID')) { ?>
		<script src="https://use.typekit.net/<?php echo cfg('SITE__TYPEKIT_ID', true); ?>.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<?php } ?>
	
	<style type="text/css">
	:root {
	    <?php if ( get_header_image() ) : ?>
	        /*  https://developer.wordpress.org/themes/functionality/custom-headers/ */
	        --site-header-image: url(<?php header_image(); ?>);
	    <?php endif; ?>
	    <?php if ( has_post_thumbnail( $post->ID )) : ?>
	        --page-header-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>);
	    <?php endif; ?>
	}

	.ac-hidden {
		/*	This needs to be available everywhere - can't rely
			on having this styling in child themes. */	
		border: 0 !important;
		clip: rect(1px, 1px, 1px, 1px);
		height: 1px !important;
		padding: 0 !important;
		overflow: hidden;
		position: absolute !important;
		width: 1px !important;
		z-index: 110;
	}
	.ac-revealOnTab:active,
	.ac-revealOnTab:focus {
	    color: #000;
	    clip: auto;
	    height: auto !important;
	    overflow: visible;
	    position: static !important;
	    width: auto !important;
	    position: absolute !important;
	    line-height: 1;
	    left: 0;
	    top: 0;
	    width: 50% !important;
	    
	    padding: 0.4em !important;
	    background: #fff !important;
	    display: inline-block !important;
	    box-shadow: 0 0.4em 0.4em rgba(0,0,0,0.4);
	}

	</style>

	
</head>

<body>

	<a class="ac-hidden ac-revealOnTab" href="#content">Skip to content</a>
	<a class="ac-hidden ac-revealOnTab" href="#site-navigation">Skip to navigation</a>

	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WCS4M7"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	

	<?php wp_body_open(); ?>

<?php 
    global $site_header;
    
    if(file_exists($site_header)) {
        include($site_header);
    }
?>

<?php
	/*
		Apr 15 - I moved the Google Tag Manager code from here to right
		after the opening body tag, since I realized it should come immediately
		after the tag. This shouldn't cause problems, but I'm making a
		note of it here.	
	*/
?>



<?php 
//  The _config file for this parent theme, not the child theme. Normally, all config variables should go in the child's _config.php file, since they determine the behavior of the site and should be considered part of the design. I'm including a _config for the parent as well, just in case it's needed.
include(get_template_directory()."/_config.php"); 
?>
	
<div class="PageContent">
	<div class="PageContentInner">

	<header class="u-lHeader">
		<div id="masthead" class="u-Masthead">
			<?php
			the_custom_logo();

			echo site_title();

			if (cfg('SITE__HIDE_TAGLINE') !== true) {
				$vassar_description = get_bloginfo( 'description', 'display' );
				if ( $vassar_description || is_customize_preview() ) :
					?>
			
					<p class="site-description"><?php echo $vassar_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; 
				}
			?>



		</div><!-- .site-branding -->
        <?php
	        if ( get_the_post_thumbnail_caption() !== '' ) {
		        echo '<div class="u-Masthead__caption"><b class="hide-accessible">Banner image: </b> ' . get_the_post_thumbnail_caption() . '</div>';
	        }
	    ?>
	</header><!-- #masthead -->

	<div id="content" class="u-lMain">
