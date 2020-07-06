<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Vassar
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			if(cfg('BLOG__PREVNEXT_REVERSE_ORDER')) $prevnext_title_prev = "Next";
			else $prevnext_title_prev = "Previous";
			
			if(cfg('BLOG__PREVNEXT_REVERSE_ORDER')) $prevnext_title_next = "Previous";
			else $prevnext_title_next = "Next";


            $args = array(
            'prev_text' => '<span class="prevnext__title">'.$prevnext_title_prev.'</span> <span class="prevnext__name">%title</span>',
            'next_text' => '<span class="prevnext__title">'.$prevnext_title_next.'</span> <span class="prevnext__name">%title</span>',
            );

			echo get_the_post_navigation($args);
						
    		if(cfg('SITE__ALLOW_COMMENTS')) {
    			// If comments are open or we have at least one comment, load up the     comment template.
    			if ( comments_open() || get_comments_number() ) :
    				comments_template();
    			endif;
    		}
		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
	</div>

<?php
get_sidebar();
get_footer();
