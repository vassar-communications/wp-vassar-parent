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

//	Does this page have sidenav?

if ($post->post_parent)	{
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent = $ancestors[$root];
} else {
	$parent = $post->ID;
}

$subnav = wp_list_pages(array('child_of' => $parent, 'title_li' => '', 'echo' => false));
if($subnav) $subnav = '<ul class="nav-menu--secondary">'.$subnav.'</ul>';

/*	Why is this global? Because I want to perform this operation only once, but I need access to the output in two places: here (to determine whether or not the page has subnav and should output a 'has-subnav' class) and in index, where the subnav will actually be displayed.
*/

define('SUBNAV', $subnav);



//	Here's where we set up the HTML classes.

$additional_classes = '';

//	First of all: to subnav or not to subnav?

if(SUBNAV) $additional_classes .= ' has-subnav';
else $additional_classes .= ' no-subnav';

//	Now then; do we have a sidebar or not?

$no_sidebar = get_post_meta($post->ID, 'vpress__no-sidebar', true);

if($no_sidebar) $additional_classes .= ' no-sidebar';
else $additional_classes .= ' has-sidebar';


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
