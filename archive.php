<?php
	
	
/*	
	NOTE
	====
	
	It may be tempting to replace this entire file with an include that just brings
	in index.php. Do not do that; archive.php has specific functionalities - like the 
	archive description - that other sites use.	I might do that eventually.

*/
	
if(cfg('SITE__REDIRECT_ARCHIVES_TO_HOME')) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".get_bloginfo('url'));
    exit();
}
?>

<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Vassar
 */

get_header();
?>

	<div id="primary" class="u-lContent">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php do_action('vassarparent__before_header'); ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page__title u-pageTitle">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

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

<?php include(get_template_directory() . '/inc/navigation.php'); ?>

<?php
get_footer();