<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Vassar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post__header">
		<?php
			
		if ( is_singular() ) :
			the_title( '<h1 class="page__title u-pageTitle">', '</h1>' );
		else :
			the_title( '<h2 class="post__title"><a class="post__titleLink" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif; ?>
	</header><!-- .entry-header -->

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="post__meta">
			<?php
				
				vassar_posted_on();
				if(cfg('POST__SHOW_AUTHOR')) vassar_posted_by();
				vassar_entry_meta();
			?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<?php vassar_post_thumbnail(); ?>

	<div class="entry__content">
		<?php
			
		$show_summary = cfg('POST__SHOW_SUMMARY');
					
		if ((is_front_page() || is_singular() || is_home()) && !$show_summary) {
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'vassar' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vassar' ),
				'after'  => '</div>',
			) );
		}
		else the_excerpt();
		?>
	</div><!-- .entry-content -->

	<?php
		if(cfg('SITE__ALLOW_COMMENTS')) {
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		}
	?>

</article><!-- #post-<?php the_ID(); ?> -->
