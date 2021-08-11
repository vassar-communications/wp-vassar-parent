<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Vassar
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Sorry, that page can’t be found.', 'vassar' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'To find what you’re looking for, use search or navigation.', 'vassar' ); ?></p>

<form action="//www.vassar.edu/search/" class="g-Search__form" method="get" role="search"> <input class="g-Search__field" id="g-Search" name="q" placeholder="Search" type="search"> <button class="icon icon-search g-Search__submit" name="submit" tabindex="0" type="submit"> <svg aria-labelledby="search-title" role="img" viewBox="0 0 32 32" width="16" height="16"><title id="search-title">Search button</title> <path d="M31 27.2l-7.6-6.4c-.8-.7-1.6-1-2.3-1 1.8-2.1 2.9-4.8 2.9-7.8 0-6.6-5.4-12-12-12s-12 5.4-12 12 5.4 12 12 12c3 0 5.7-1.1 7.8-2.9 0 .7.3 1.5 1 2.3l6.4 7.6c1.1 1.2 2.9 1.3 4 .2s1-2.9-.2-4zm-19-7.2c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8z"></path> <image alt="Search" src="/assets/images/icons/search.gif" width="32" height="32" xlink:href=""></image> </svg> </button> </form>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
