<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Vassar
 */

?>

<?php

if(cfg('POST__THUMB_URL_INLINE')) {
	$article_data_attr = 'data-image-url="'.get_the_post_thumbnail_url().'"';
}	
	
?>


<?php
	if(cfg('POST__THUMB_URL_CSSVAR')) {
		echo '<style>#post-'.get_the_ID().' { --article-featured-img: url('.get_the_post_thumbnail_url().'); }</style>';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php echo $article_data_attr; post_class(); ?>>

	<header class="post__header">
		<?php
			/*
				A post's permalink can be one of two things:
				-	The usual link to the post
				-	A manually specified link to somewhere else. This is because we're using
					the blog for the site's news system, and in our current system, some items
					link to other sites.
			*/
			
			//  Is there an offsite link specified?
			$offsite_link = get_post_meta( get_the_ID(), 'offsite-link', true );
			
			//  Nope. Link to the blog post as usual.
			if ( $offsite_link == '' ) {
				$linkTo = get_permalink();
			}
			//  Why yes, there is! Link to that instead.
			else {
			    $linkTo = $offsite_link;
			}
		if ( is_singular() ) :
			the_title( '<h1 class="page__title u-pageTitle">', '</h1>' );
		else :
			the_title( '<h2 class="post__title"><a class="post__titleLink" href="' . esc_url( $linkTo ) . '" rel="bookmark">', '</a></h2>' );
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

	<?php
		if(is_page() && !cfg('PAGE__HIDE_FEATURED_IMG'))
			vassar_post_thumbnail();
		else if(is_single() && !cfg('POST__HIDE_FEATURED_IMG'))
			vassar_post_thumbnail();
	?>
	
	<div class="entry__content">
		<?php
			
		$show_summary = cfg('POST__SHOW_SUMMARY');

		if ((is_front_page()) || (is_archive()) || (is_search()) || (is_home()) && $show_summary )  {

			the_excerpt();

			if(cfg('POST__SHOW_READMORE_AFTER_EXCERPT')) {
			    $readmore_text = cfg('POST__READMORE_AFTER_EXCERPT_TEXT', true, 'Read more');
//			    $readmore_link = get_permalink();
				echo '<div class="readmore-link__container"><a class="readmore-link" href="'.$linkTo.'">'.$readmore_text.'</a></div>';
			}
		} else {
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

		?>
	</div><!-- .entry-content -->

	<?php do_action('vassarparent__after_entryContent'); ?>

	<?php
		if(cfg('SITE__ALLOW_COMMENTS')) {
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		}
	?>

</article><!-- #post-<?php the_ID(); ?> -->
