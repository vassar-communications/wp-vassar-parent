<?php

/*
	


*/

function cfg($constant) {
	/*	cfg() checks if a setup constant exists before trying to use it. I need to use this on every setup var I have, because if I don't, there's going to be a lot of warnings, and people would need to have every setup var in their file whether they're using it or not. That's cluttery.	
	*/
	if (defined($constant)) 
		return constant($constant);
	else return false;
}

$child_path = get_stylesheet_directory();
$child_path .= "/_config.php";

if (file_exists($child_path)) include($child_path);



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
}
add_action( 'widgets_init', 'vassar_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vassar_scripts() {
	wp_enqueue_style( 'vassar-style', get_stylesheet_uri() );
	wp_register_script( 'flickity', get_template_directory_uri() . '/js/flickity.pkgd.min.js', array('jquery'), '20151215', true );
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151215', true );
    wp_register_script( 'site', get_stylesheet_directory_uri() . '/assets/js/site.js',  array('jquery'), time() ); 
    
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

//	http://www.seanbehan.com/how-to-slugify-a-string-in-php/
function slugify($string){
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
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
	
	$pattern = '/\(?(\d{3})\)?[-. ](\d{3})[-.](\d{4})/';
	$replacement = '<a href="tel:+1$1$2$3">($1) $2-$3</a>';
	$content = preg_replace($pattern, $replacement, $content);
	
	if ( is_singular() && in_the_loop() && is_main_query() ) {
		global $post;
		$post_id = $post->ID;
		$page_title = get_the_title($post_id);
	
		/*	Only do this if the page is an FAQs page. */
	
		if(strpos($page_title, "FAQs") !== false) {
	
			$dom_document = new DOMDocument();
			@$dom_document->loadHTML($content);
			$headers = $dom_document->getElementsByTagName('h3');
		
			foreach ($headers as $header) {
				$header->setAttribute("align", "left");
				$table_of_contents[] = trim($header->nodeValue);
			}
			
			foreach ($table_of_contents as &$value) {
				
				$slug = slugify($value);
				
				/*	Generate the table of contents */
				
			    $faq_toc .= '<li><a href="#'.$slug.'">'.$value.'</a></li>';
		
				/*	Add IDs to each h2 tag. This feels like a clumsy way of doing it, and if I knew more about DOMDoc, I might be able to have it assign attributes to specific nodes. That method is taking longer than I wanted, though, so I'll go with ireplace for now. 
				*/
		
			    $the_tag = '<h3>'.$value.'</h3>';
			    $the_tag_with_id = '<h2 id="'.$slug.'">'.$value.'</h2>';
			    	    
			    $content = str_ireplace($the_tag, $the_tag_with_id, $content);
			}
		
		    $content = '<ul id="index" class="faq__index">'.$faq_toc.'</ul>'.$content.'<a href="#index">Top</a>';
		 
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










