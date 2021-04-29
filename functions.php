<?php

$child_path = get_stylesheet_directory();

$child_theme_include_path = $child_path.'/assets/includes/';

$site_header = $child_theme_include_path.'header_markup.php';
$site_footer = $child_theme_include_path.'footer_markup.php';


$child_cfg_file = $child_path."/_config.php";
if (file_exists($child_cfg_file)) include($child_cfg_file);



/*
	
This whole thing needs to be organized with an index at the front.

	* Basic Utilities
	
	* Sitewide
	
	* Functionalities
		* Post types

	* WordPress overrides
		* Excerpt length
	
	* Admin

*/

/*	BASIC UTILITIES
	=============== */

/*	Config
	------

	These handle settings the theme designer has specified in the _config.php file.
	
	Note that _config.php sits in the *child* theme, not the parent theme. That's because the intention is for all site-specific stuff - design, local functionality, etc - to be contained in the child theme. The parent theme should contain no functionality specific to any particular site. */


/* Use cfg() to check/retrieve config settings. If $get_value is false, cfg() only returns "true" if a setting exists. If $get_value is true, cfg() returns the actual value of that setting. If a setting doesn't exist, cfg() returns false.
	
	$constant - string. The name of the setting you're checking.
	$get_value - boolean, optional.

*/

function cfg($setting, $get_value = false, $default = '') {
	
	//	First: Is the setting even defined - that is, present in the config file?
	if (defined($setting)) {
		
		//	Okay, it's in settings, but is it true?
		if(constant($setting)) {

			//	And finally, do we need to know what its value actually is - say, if it's a string?			
			if($get_value) {
				return constant($setting);
			}
			else {
				return true;
			}
		}
		else return false;
	}
	//  If the setting isn't present, but a default value was provided,
	//  return that default value.
	else if ($default !== '') {
		return $default;
	}
	//  No setting is defined, and no default value is specified
	else {
		return false;
	}
}

function gw__get_site_title() {
	if (cfg('SITE__CUSTOM_TITLE')) {
		return SITE__CUSTOM_TITLE; 
	}
	else return get_bloginfo( 'name' ); 
}



/*	SITEWIDE
	======== */

if (cfg('SITE__NO_TAGLINE_IN_TITLE')) {
	//	Removes the tagline from the title tag on homepage
	//  https://wordpress.stackexchange.com/questions/218980/remove-description-from-title-on-home
	add_filter( 'pre_get_document_title', function ( $title ) {
	        $title = get_bloginfo();

	    if(is_front_page()){
	        // $title = get_bloginfo();
    	    return $title.' - Vassar College';
	    }
	    else {
	        $the_page_title = get_the_title();
	        return $the_page_title . ' - ' . $title . ' - Vassar College';
	    }
	});
}

function get_root_parent($post) {
	if ($post->post_parent)	{
		$ancestors=get_post_ancestors($post->ID);
		$root=count($ancestors)-1;
		$this_post_parent_id = $ancestors[$root];
		$this_post_parent = get_post($this_post_parent_id);
	} else {
		$this_post_parent = get_post($post->ID);
	}
	return $this_post_parent;
}



function socialcard($arr) {
	
	/*	This function is used by vassar_socialcard() in inc/template-tags.php
	
	*/
	
	foreach ($arr as $key => $value) {
		$markup .= PHP_EOL;
		
		//	Some values appear in both Facebook and Twitter tags
		//	Let's deal with those first
		if (strpos($key, 'image') !== false) {
			/* "The provided 'og:image' properties are not yet available because new images are processed asynchronously. To ensure shares of new URLs include an image, specify the dimensions using 'og:image:width' and 'og:image:height' tags." */
				
			$local_image_url = wp_make_link_relative($value);
			$local_image_url = $_SERVER['DOCUMENT_ROOT'].$local_image_url;
			if(file_exists($local_image_url))

				list($image_width, $image_height, $image_type, $image_attr) = getimagesize($local_image_url);
			$markup .= '<meta name="og:image:width" content="'.$image_width.'">';
			$markup .= '<meta name="og:image:height" content="'.$image_height.'">';

			
			$markup .= '<meta name="twitter:card" content="summary_large_image">';
			$markup .= '<meta name="twitter:image" content="'.$value.'">'.PHP_EOL.'<meta property="og:image" content="'.$value.'">';
		}
		if (strpos($key, 'title') !== false) {
			$value = strip_tags($value);
			$markup .= '<meta name="twitter:title" content="'.$value.'">'.PHP_EOL.'<meta property="og:title" content="'.$value.'">';
		}
		if (strpos($key, 'description') !== false) 
			$markup .= '<meta name="twitter:description" content="'.$value.'">'.PHP_EOL.'<meta property="og:description" content="'.$value.'">';


		//	Network-specific stuff here
		if (strpos($key, 'twitter') !== false)
			$markup .= '<meta name="'.$key.'" content="@'.$value.'">';
		else if (strpos($key, 'og:') !== false)
			$markup .= '<meta property="'.$key.'" content="'.$value.'">';
	}
    return $markup;
}




/*	FUNCTIONALITIES
	=============== */

    /*  Image sizes
        -----------
        These are sizes that should be available in addition to the standard
        sizes that come with Wordpress.
    */

add_action( 'after_setup_theme', 'wpdocs_theme_setup' );

function wpdocs_theme_setup() {
    
    //  This image size would be displayed in blog post listings; say, on the News section of an Offices site. It's referenced by the function vassar_post_thumbnail(), defined in vassar-parent/inc/template-tags.php. That function is called in vassar-parent/template-parts/content.php (content.php is the file containing the template code for blog posts).
    
    //  If you need a different sized thumbnail to be displayed for posts, you could override the default blog template by creating a /template-parts folder in your child theme and setting up a copy of content.php in that folder. Then defining a new image size in your child theme's functions.php file, and reference it in the new content.php override file.
    
   add_image_size( 'news-thumbnail-size', 220, 220, true );
}    
 
	/*	Post types */


if(cfg('BLOG__POST_FORMATS')) {
	function childtheme_formats(){
	     add_theme_support( 'post-formats', cfg('BLOG__POST_FORMATS', true));
	}
	add_action( 'after_setup_theme', 'childtheme_formats', 11 );
}





/**
 * Vassar functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Vassar
 */

if ( ! function_exists( 'vassar_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vassar_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Vassar, use a find and replace
		 * to change 'vassar' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vassar', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'vassar' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'vassar_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'vassar_setup' );



/*	WORDPRESS OVERRIDES
	=================== */

if(cfg('POST__EXCERPT_LENGTH')) {
	function mytheme_custom_excerpt_length( $length ) {
	    return cfg('POST__EXCERPT_LENGTH', true);
	}
	add_filter( 'excerpt_length', 'mytheme_custom_excerpt_length', 999 );
}

function modify_read_more_link() {
 return '<a class="more-link" href="' . get_permalink() . '">'.cfg('BLOG__READMORE_TEXT', true, 'Read more').'</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vassar_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'vassar_content_width', 640 );
}
add_action( 'after_setup_theme', 'vassar_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vassar_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'vassar' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'vassar' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	if( cfg('SITE__FOOTER_HAS_WIDGET_AREA', true) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'vassar' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'vassar' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'vassar_widgets_init' );

//	https://colorlib.com/wp/load-wordpress-jquery-from-google-library/
function replace_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri() . '/assets/js/libraries/jquery.min.js', false, '3.4.1');
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'replace_jquery');

/**
 * Enqueue scripts and styles.
 */
 
/*	Register early */

function register_vassar_scripts() {
	wp_register_script( 'flickity', get_template_directory_uri() . '/assets/js/libraries/flickity/flickity.pkgd.min.js', array('jquery'), '20151215', true );
	wp_register_style( 'flickity-style', get_template_directory_uri() . '/assets/js/libraries/flickity/flickity.css');
	wp_register_script( 'waypoints', get_template_directory_uri() . '/assets/js/libraries/jquery.waypoints.min.js', array('jquery'), '20151215', true );
	wp_register_script( 'pivot', 'https://cdn.rawgit.com/wnda/pivot/master/pivot.js', array('jquery'), '20151215', true );
	wp_register_script( 'wordify', get_template_directory_uri() . '/assets/js/libraries/wordify.js', array('jquery'), '20151215', true );
}
add_action( 'wp_loaded', 'register_vassar_scripts' );

function vassar_scripts() {
	wp_enqueue_style( 'basic-style', get_template_directory_uri() . '/assets/css/basics.css' );
	wp_enqueue_style( 'vassar-style', get_stylesheet_uri() );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'site-js', get_stylesheet_directory_uri() . '/assets/js/site.js',  array('jquery'), time() );
	wp_dequeue_style( 'wp-block-library' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vassar_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/*	Gutenberg overrides
	=================== */
	
/*	Replacing the four ludicrously large font sizes with a tasteful "intro" size */
add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( 'Normal', 'gutenberg-test' ),
			'shortName' => __( 'N', 'gutenberg-test' ),
			'size' => 16,
			'slug' => 'normal'
		),
		array(
			'name' => __( 'Intro', 'gutenberg-test' ),
			'shortName' => __( 'N', 'gutenberg-test' ),
			'size' => 20,
			'slug' => 'intro'
		),
	) );
add_theme_support('disable-custom-font-sizes');


/*	remove wp-admin-bar styling. Problem is that the !important margin-top is overriding the margin-top for the unibar. */

add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}


/*	FILTERS
	=======

	The following functions modify default WordPress content.
*/

/*	Remove the "Category:" prefix from archive pages */

function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );





/*	Widgetry
	======== */
//	https://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/
// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('WPBeginner Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo __( 'Hello, World!', 'wpb_widget_domain' );
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here


/*	Add a menu that defines whether a note widget is a regular note or an important alert */


//	https://wordpress.stackexchange.com/questions/134539/how-to-add-custom-fields-to-settings-in-widget-options-for-all-registered-widget

function kk_in_widget_form($t,$return,$instance) {
	/*	kk_in_widget_form() is a function invoked by the WP action "in_widget_form" (https://developer.wordpress.org/reference/hooks/in_widget_form/). That hook has three parameters: $this (the current widget instance), $return, and $instance. In this case, $instance is the set of options we want to add to the widget.
	
	*/
	
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'float' => 'none') );
    if ( !isset($instance['float']) )
        $instance['float'] = null;
    if ( !isset($instance['texttest']) )
        $instance['texttest'] = null;
    ?>
    <p>
        <input id="<?php echo $t->get_field_id('width'); ?>" name="<?php echo $t->get_field_name('width'); ?>" type="checkbox" <?php checked(isset($instance['width']) ? $instance['width'] : 0); ?> />
        <label for="<?php echo $t->get_field_id('width'); ?>"><?php _e('halbe Breite'); ?></label>
    </p>
    <p>
        <label for="<?php echo $t->get_field_id('float'); ?>">Float:</label>
        <select id="<?php echo $t->get_field_id('float'); ?>" name="<?php echo $t->get_field_name('float'); ?>">
            <option <?php selected($instance['float'], 'none');?> value="none">none</option>
            <option <?php selected($instance['float'], 'left');?>value="left">left</option>
            <option <?php selected($instance['float'], 'right');?> value="right">right</option>
        </select>
    </p>
    <input type="text" name="<?php echo $t->get_field_name('texttest'); ?>" id="<?php echo $t->get_field_id('texttest'); ?>" value="<?php echo $instance['texttest'];?>" />
    <?php
    $retrun = null;
    return array($t,$return,$instance);
}

function kk_in_widget_form_update($instance, $new_instance, $old_instance){
    $instance['width'] = isset($new_instance['width']);
    $instance['float'] = $new_instance['float'];
    $instance['texttest'] = strip_tags($new_instance['texttest']);
    return $instance;
}

function kk_dynamic_sidebar_params($params){
    global $wp_registered_widgets;
    $widget_id = $params[0]['widget_id'];
    $widget_obj = $wp_registered_widgets[$widget_id];
    $widget_opt = get_option($widget_obj['callback'][0]->option_name);
    $widget_num = $widget_obj['params'][0]['number'];
    if (isset($widget_opt[$widget_num]['width'])){
            if(isset($widget_opt[$widget_num]['float']))
                    $float = $widget_opt[$widget_num]['float'];
            else
                $float = '';
            $params[0]['before_widget'] = preg_replace('/class="/', 'class="'.$float.' half ',  $params[0]['before_widget'], 1);
    }
    return $params;
}

//Add input fields(priority 5, 3 parameters)
add_action('in_widget_form', 'kk_in_widget_form',5,3);
//Callback function for options update (priorität 5, 3 parameters)
add_filter('widget_update_callback', 'kk_in_widget_form_update',5,3);
//add class names (default priority, one parameter)
add_filter('dynamic_sidebar_params', 'kk_dynamic_sidebar_params');

function slugify($string){
	// /[^A-Za-z0-9-]+/
	//     $final_string = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
	
	//	Get rid of multiple spaces
	$final_string = str_ireplace('  ', ' ', $string);

	//	target all alphanumerics
	//	https://stackoverflow.com/a/17947853/6784304
	$replace_pattern = '/\W|_/';
    $final_string = strtolower(trim(preg_replace($replace_pattern, '-', $final_string), '-'));

	//	get rid of multiple hyphens because I'm OCD about this sort of thing
	//	https://stackoverflow.com/a/29865564/6784304	
    $final_string = preg_replace('/-+/', '-', $final_string);
    
    return $final_string;
}

function my_gallery_shortcode( $output = '', $atts = null, $instance = null ) {
	$return = $output; // fallback

	// retrieve content of your own gallery function
	$my_result = get_my_gallery_content( $atts );

	// boolean false = empty, see http://php.net/empty
	if( !empty( $my_result ) ) {
		$return = $my_result;
	}

	return "XXXX".$return;
}

add_filter( 'post_gallery', 'my_gallery_shortcode', 10, 3 );




/*	FAQs
	==== 
	https://developer.wordpress.org/reference/hooks/the_content/
	https://stackoverflow.com/questions/1445506/get-content-between-two-strings-php/1445528
	https://randomdrake.com/2010/04/27/creating-a-table-of-contents-from-html-in-php-with-domdocument-and-no-regex/
*/


add_filter( 'the_content', 'filter_the_content_in_the_main_loop' );



function filter_the_content_in_the_main_loop( $content ) {
	
	/*	Link phone numbers */
	
	$pattern = '/\(?(\d{3})\)?[-. ](\d{3})[-.\x{2013}\x{2014}](\d{4})/u';
	$replacement = '<a href="tel:+1$1$2$3">($1) $2-$3</a>';
	$content = preg_replace($pattern, $replacement, $content);
	

	/*	Strip out target=new */

//	$content = preg_replace("_<a href=\"(.+?)\"((\w+=\".+?\")|\s*)*>_si", "<a href=\"$1\">", $content);

    //  When WordPress corrects a straight quote, it replaces it with an HTML entity. This was causing problems on FAQs, because I was searching for strings with ’ in them, since we enter curly quotes directly; we don't use the entities. That inconsistency meant that some FAQ titles weren't being converted to h2s with their own identities. The following str_replace turns everything into the regular characters.
    
    $content = str_replace("&#8217;", "’", $content);
    $content = str_replace("'", "’", $content);


	/*	FAQ formatting */
		
	if ( is_singular() && in_the_loop() && is_main_query() ) {
		global $post;
		$post_id = $post->ID;
		$page_title = get_the_title($post_id);
	
		/*	Only do this if the page is an FAQs page and isn't already designated as having a table of contents. This is to avoid conflicts between the following code and the PageTOC plugin. */
	
		if( ( strpos($page_title, "FAQ") !== false) && ( !get_post_meta( $post_id, 'has-index', true ) ) ) {
		    
//		    echo 'true';
	
			$dom_document = new DOMDocument();
			@$dom_document->loadHTML('<?xml encoding="utf-8" ?>' . $content);
			$headers = $dom_document->getElementsByTagName('h3');
		
			foreach ($headers as $header) {
			    
				$header->setAttribute("align", "left");
				$header_sanitized = trim($header->nodeValue);
				
				$header_sanitized = str_replace("'", "’", $header_sanitized);

                $value = $header_sanitized;
                
//                echo $value;

				$slug = slugify($value);

				/*	Generate the table of contents */
				
			    $faq_toc .= '<li><a href="#'.$slug.'">'.$value.'</a></li>';
		
				/*	Add IDs to each h2 tag. This feels like a clumsy way of doing it, and if I knew more about DOMDoc, I might be able to have it assign attributes to specific nodes. That method is taking longer than I wanted, though, so I'll go with ireplace for now. 
				*/
		
			    $the_tag = '<h3>'.$value.'</h3>';
			    
//			    echo $the_tag;

			    $the_tag_with_id = '<h2 id="'.$slug.'">'.$value.'</h2>';
			    	    
			    $content = str_replace($the_tag, $the_tag_with_id, $content);
			    
//			    echo '<div style="background: #eee">'.$content.'</div>';

			}
		
		    $content = '<ul id="index" class="faq__index">'.$faq_toc.'</ul>'.$content.'<a class="faq__link-to-top" href="#index">Top</a>';

		}
	}

    return $content;
}



/*	LAZYBLOCKS 
	==========
	
	LazyBlocks exports PHP to define blocks created via the plugin - all you need is the plugin to be active.
*/


if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 24,
        'title' => 'Linked List',
        'icon' => 'dashicons dashicons-format-aside',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/linked-list',
        'description' => '',
        'category' => 'specialmodules',
        'category_label' => 'Special Modules',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_0edb1a4ec6' => array(
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'child_of' => '',
                'default' => '',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                ),
                'checked' => 'false',
                'allow_null' => 'false',
                'multiple' => 'false',
                'allowed_mime_types' => array(
                ),
                'alpha' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
            ),
            'control_334af44e1f' => array(
                'label' => 'Content',
                'name' => 'content',
                'type' => 'repeater',
                'child_of' => '',
                'default' => '',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                ),
                'checked' => 'false',
                'allow_null' => 'false',
                'multiple' => 'false',
                'allowed_mime_types' => array(
                ),
                'alpha' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
            ),
            'control_29c87c4442' => array(
                'label' => 'List item',
                'name' => 'item_text',
                'type' => 'text',
                'child_of' => 'control_334af44e1f',
                'default' => '',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                ),
                'checked' => 'false',
                'allow_null' => 'false',
                'multiple' => 'false',
                'allowed_mime_types' => array(
                ),
                'alpha' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
            ),
            'control_ab5b804026' => array(
                'label' => 'item_link',
                'name' => 'item_link',
                'type' => 'text',
                'child_of' => 'control_334af44e1f',
                'default' => '',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'hide_if_not_selected' => 'false',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                ),
                'checked' => 'false',
                'allow_null' => 'false',
                'multiple' => 'false',
                'allowed_mime_types' => array(
                ),
                'alpha' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
            ),
            'control_8f7b6f46d9' => array(
                'label' => 'Description',
                'name' => 'item_description',
                'type' => 'textarea',
                'child_of' => 'control_334af44e1f',
                'default' => '',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'hide_if_not_selected' => 'true',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
                'required' => 'false',
                'choices' => array(
                ),
                'checked' => 'false',
                'allow_null' => 'false',
                'multiple' => 'false',
                'allowed_mime_types' => array(
                ),
                'alpha' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
            ),
        ),
        'code' => array(
            'editor_html' => '<div class="module">
        <div class="content">
            <ol>
    {{#each content}}
        <li>{{item_text}}</li>
    {{/each}}
    </ol>
        </div>
    </div>',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="module">
        <h2>{{title}}</h2>
        <div class="content">
            <ul>
    {{#each content}}
        <li><a href="{{item_link}}">{{item_text}}</a>
            {{#if item_description}}<div class=\'item__desc\'>{{item_description}}</div>{{/if}}
    </li>
    {{/each}}
    </ul>
        </div>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
            'show_preview' => 'always',
            'single_output' => false,
        ),
        'condition' => array(
        ),
    ) );
    
endif;

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_template( array(
        'id' => 22,
        'title' => 'Pages',
        'data' => array(
            'post_type' => 'page',
            'post_label' => 'Pages',
            'template_lock' => '',
            'blocks' => array(
                array(
                    'name' => 'core/paragraph',
                ),
                array(
                    'name' => 'core/heading',
                ),
            ),
        ),
    ) );
    
endif;


add_filter( 'pre_get_document_title', 'filter_document_title' );

function filter_document_title( $title ) {
	global $wp_query;
	$content_id = $wp_query->post->ID;

	$page_title = get_post_meta($content_id, 'page_longtitle', true);
	if ($page_title) {
		$site_name = get_bloginfo('name');
		return $page_title.' – '.$site_name;
	} else { 
		return $title; 
	}
}


/*	submenu stuff 
	https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
*/

// add hook
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );

// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
  if ( isset( $args->sub_menu ) ) {
    $root_id = 0;
    
    // find the current menu item
    foreach ( $sorted_menu_items as $menu_item ) {
      if ( $menu_item->current ) {
        // set the root id based on whether the current menu item has a parent or not
        $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
        break;
      }
    }
    
    // find the top level parent
    if ( ! isset( $args->direct_parent ) ) {
      $prev_root_id = $root_id;
      while ( $prev_root_id != 0 ) {
        foreach ( $sorted_menu_items as $menu_item ) {
          if ( $menu_item->ID == $prev_root_id ) {
            $prev_root_id = $menu_item->menu_item_parent;
            // don't set the root_id to 0 if we've reached the top of the menu
            if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
            break;
          } 
        }
      }
    }

    $menu_item_parents = array();
    foreach ( $sorted_menu_items as $key => $item ) {
      // init menu_item_parents
      if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

      if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
        // part of sub-tree: keep!
        $menu_item_parents[] = $item->ID;
      } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
        // not part of sub-tree: away with it!
        unset( $sorted_menu_items[$key] );
      }
    }
    
    return $sorted_menu_items;
  } else {
    return $sorted_menu_items;
  }
}

// https://clicknathan.com/web-design/wordpress-has_subpage-function/
function has_subpage() {
        global $post;
	if($post->post_parent){
		$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
	} else {
		$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
	} if ($children) {
		return true;
	} else {
		return false;
	}
}


/*	Admin
	===== */

if (cfg('SITE__HAS_ADMIN_CSS')) {
	function admin_style() {
	  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/admin.css');
	}
	add_action('admin_enqueue_scripts', 'admin_style');
}


