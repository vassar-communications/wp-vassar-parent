<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Vassar
 * 
 */

get_header();
?>

	<div id="primary" class="u-lContent">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :
				?>
				<header>
					<?php if (is_archive()) {
						the_archive_title( '<h1 class="page__title u-pageTitle">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					}
					if ( is_home() && ! is_front_page() ) : 
						echo '<h1 class="page__title u-pageTitle">';
						single_post_title();
						echo '</h1>';
					endif; ?>
				</header>
				<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				
				/*
					The following is currently specific to only one site - Summer Immersions, which is a child theme - but I'm adding support for post formats in the parent theme in case anyone wants to use it. Basically, instead of just using the content template-part, WP checks to see if the post has a specified format; if so, it looks for that post's associated format template-part instead. For Immersions, I have these template parts stored in the child theme.
					
					Note that post formats need to be specifically turned on. You won't see the formats menu in the admin area unless you're using a theme that declares support for them. Since the formats are specific to a particular site design, and the design is contained in the child theme, I've declared format support in the Summer Immersions child theme. The logic below only checks to see if there's a format associated with a post; there is nothing in the Vassar parent theme that turns on post formats.
					
					Should probably add this to Groundwork at some point. 
					
				*/
				
				$format = get_post_format();
				
				if( $format ) {
					get_template_part( 'template-parts/format', $format );
				}
				else {
					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );
				}
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
?>

</div>

<nav id="site-navigation" class="u-NavSite u-NavSite__main">
	<a class="menu-toggle" href="#primary-menu" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'vassar' ); ?></a>
	<?php
	wp_nav_menu( array(
		'theme_location' => 'menu-1',
		'menu_id'        => 'primary-menu',
	) );
	?>
</nav><!-- #site-navigation -->

<nav class="u-NavSite u-NavSite__secondary" id="s-navigation" tabindex="-1" aria-hidden="true">

<?php

wp_nav_menu( array(
  'menu'     => 'Main Navigation',
  'sub_menu' => true,
  'container_class' => 'menu-subnav-container',
  'menu_id' => '',
  'menu_class' => 'u-NavSite__level--2',
) );

?>

</nav>


<?php
get_footer();
