<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Vassar
 */

if ( ! function_exists( 'vassar_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function vassar_posted_on() {
		$time_string = '<time class="post__date published updated" datetime="%1$s">%2$s</time>';
		
		if(cfg('POST__SHOW_MOD_DATE')) {
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="post__date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
			}
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'<b class="label label--cats">'.cfg('POST__DATE__LABEL', true, 'posted').' %s</b>', $time_string);

		echo '<div class="post__metaItem post__dateContainer">' . $posted_on . '</div>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'vassar_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function vassar_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'vassar' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<div class="post__metaItem byline"> ' . $byline . '</div>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'vassar_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function vassar_entry_meta() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			if(cfg('POST__SHOW_CATEGORIES')) {
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'vassar' ) );
				if ( $categories_list ) {
					/* translators: 1: list of categories. */
					printf( '<div class="post__metaItem post__categories">' . '<b class="label label--cats">'.cfg('POST__CATEGORIES__LABEL', true).'</b> %1$s' . '</div>', $categories_list ); // WPCS: XSS OK.
				}
			}

			if(cfg('POST__SHOW_TAGS')) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'vassar' ) );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<div class="post__metaItem post__tags">' . '<b class="label label--tags">'.cfg('POST__TAGS__LABEL', true).'</b> %1$s' . '</div>', $tags_list ); // WPCS: XSS OK.
				}
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			if(cfg('SITE__ALLOW_COMMENTS')) {
				echo '<div class="post__metaItem post__comments">';
				comments_popup_link(
					sprintf(
						wp_kses(
							/* translators: %s: post title */
							__( 'Leave a Comment<span class="screen-reader-text"></span>', 'vassar' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				echo '</div>';
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit post', 'vassar' ),
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
	}
endif;

if ( ! function_exists( 'vassar_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function vassar_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		?>
		<div class="post__image">
		<?php
		if ( is_singular() ) :
			?>

				<?php the_post_thumbnail(); ?>

		<?php else : ?>

			<a class="post__imageLink" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
			</a>
		</div><!-- .post-thumbnail -->

		<?php
		endif; // End is_singular().
	}
endif;




if ( ! function_exists( 'vassar_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function vassar_entry_footer() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			if(cfg('SITE__ALLOW_COMMENTS')) {
				echo '<span class="comments-link">';
				comments_popup_link(
					sprintf(
						wp_kses(
							/* translators: %s: post title */
							__( 'Leave a Comment', 'vassar' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);
				echo '</span>';
			}
		}

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
	}
endif;


function site_title() {
	$header = '';
	if ( is_front_page() /* && is_home() */ ) {
		$header .= '<h1 class="site-title">'; 

		/* <!--<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">--> */
		
		if(defined('SITE__CUSTOM_HEADER_HOME'))
			$header .= SITE__CUSTOM_HEADER_HOME;
		else if (defined('SITE__CUSTOM_HEADER'))
			$header .= SITE__CUSTOM_HEADER;
		else
			$header .= get_bloginfo( 'name' );

		$header .= '</h1>';
	}
	else {
		$header .= '<span class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'; 

		if (defined('SITE__CUSTOM_HEADER'))
			$header .= SITE__CUSTOM_HEADER;
		else $header .= get_bloginfo( 'name' );

		$header .= '</a></span>';		
	}
	return $header;
}










