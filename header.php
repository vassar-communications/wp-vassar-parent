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

?>

<html <?php language_attributes(); ?> <?php body_class($additional_classes); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	
</head>

<body>
	
<?php include(get_template_directory()."/_config.php"); ?>
	
<div class="PageContent">
	<div class="PageContentInner">

	<header class="u-lHeader">
		<div id="masthead" class="u-Masthead">
			<?php
			the_custom_logo();

			echo site_title();

			$vassar_description = get_bloginfo( 'description', 'display' );
			if ( $vassar_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $vassar_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->
	</header><!-- #masthead -->

	<div id="content" class="u-lMain">
