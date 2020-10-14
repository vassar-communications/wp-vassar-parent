<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Vassar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article--page'); ?>>
	<header class="header page__header">
		<?php $page_title = get_post_meta($post->ID, 'page_longtitle', true);
		if ($page_title) {
			echo '<h1 class="page__title u-pageTitle">'.$page_title.'</h1>';
		} else { 
			the_title( '<h1 class="page__title u-pageTitle">', '</h1>' );		 
		}
		?>


		<?php // the_title( '<h1 class="page__title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php
		if(!cfg('PAGE__HIDE_FEATURED_IMG')) vassar_post_thumbnail();
	?>


	<div class="entry__content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vassar' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'vassar' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
