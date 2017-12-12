<?php
/**
 * unibz functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package unibz
 */

if ( ! function_exists( 'unibz_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function unibz_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on unibz, use a find and replace
	 * to change 'unibz' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'unibz', get_template_directory() . '/languages' );

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
		'primary' => esc_html__( 'Primary', 'unibz' ),
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
	add_theme_support( 'custom-background', apply_filters( 'unibz_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'unibz_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function unibz_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'unibz_content_width', 640 );
}
add_action( 'after_setup_theme', 'unibz_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function unibz_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'unibz' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'unibz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'unibz_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function unibz_scripts() {
	// CSS
	wp_enqueue_style( 'bootstrap-css', 	get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'unibz-style', 	get_stylesheet_uri());

	$my_theme_settings = get_option('my_theme_settings');
	if ($my_theme_settings['faculty_color'] != 'none'){
		wp_enqueue_style( 'faculty', 	get_template_directory_uri() . '/css/faculty-'.$my_theme_settings['faculty_color'].'.css');
	}
	//JS
	wp_enqueue_script( 'jquery-js', 	get_template_directory_uri() . '/js/jquery.js', 	array(), null, true );
	wp_enqueue_script( 'bootstrap-js', 	get_template_directory_uri() . '/js/bootstrap.js', 	array(), null, true );
	wp_enqueue_script( 'submenu-js', 	get_template_directory_uri() . '/js/submenu.js', 	array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'unibz_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// ----------------------------------------------------------------------------------------------

/**
 * Load unibz news widget.
 */
require get_template_directory() . '/inc/unibz-news-widget.php';

/**
 * Redefine default WordPress RSS widget.
 */
require get_template_directory() . '/inc/custom-rss-widget.php';

// replace WordPress default RSS widget with custom
function unregister_default_widgets() {
	unregister_widget('WP_Widget_RSS');
	register_widget( 'unibz_Widget_RSS' );
} add_action('widgets_init', 'unregister_default_widgets', 11);



// Set excerpt length
function my_excerpt_length($length) {
	if(!has_post_thumbnail()) {
		return 100;
	}
	else {
		return 50;
	}
}
add_filter('excerpt_length', 'my_excerpt_length');


/**
 * Register Hero meta box.
 */
function unibz_register_hero_meta_box() { 
    add_meta_box("hero-meta-box", "Hero", "unibz_hero_meta_box_display_callback", array("post", "page"), "side", "high", null);
}
add_action( 'add_meta_boxes', 'unibz_register_hero_meta_box' );
 
/**
 * Hero meta box display callback.
 *
 * @param WP_Post $object Current post object.
 */
function unibz_hero_meta_box_display_callback( $object ) {
    wp_nonce_field(basename(__FILE__), "hero-meta-box-nonce");
    ?>
        <div>
            <input name="hero-meta-box-title" type="text" value="<?php echo get_post_meta($object->ID, "hero-meta-box-title", true); ?>">
            <label for="hero-meta-box-title">Title</label><br>
            <input name="hero-meta-box-subtitle" type="text" value="<?php echo get_post_meta($object->ID, "hero-meta-box-subtitle", true); ?>">
            <label for="hero-meta-box-subtitle">Subtitle</label><br>
            <input name="hero-meta-box-hide" type="checkbox" value="1" <?php echo (get_post_meta($object->ID, "hero-meta-box-hide", true) ? 'checked' : ''); ?>>
            <label for="hero-meta-box-hide">Hide Hero Image?</label><br>
        </div>
    <?php  
}
 
/**
 * Save hero meta box content.
 *
 * @param int $post_id Post ID
 */
function unibz_save_hero_meta_box( $post_id ) {

    if (!isset($_POST["hero-meta-box-nonce"]) || !wp_verify_nonce($_POST["hero-meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $hero_meta_box_title = "";
    $hero_meta_box_subtitle = "";
    $hero_meta_box_hide = true;

    if(isset($_POST["hero-meta-box-title"]))
    {
        $hero_meta_box_title = $_POST["hero-meta-box-title"];
    }   
    update_post_meta($post_id, "hero-meta-box-title", $hero_meta_box_title);

    if(isset($_POST["hero-meta-box-subtitle"]))
    {
        $hero_meta_box_subtitle = $_POST["hero-meta-box-subtitle"];
    }   
    update_post_meta($post_id, "hero-meta-box-subtitle", $hero_meta_box_subtitle);


    $hero_meta_box_hide = $_POST["hero-meta-box-hide"];
    update_post_meta($post_id, "hero-meta-box-hide", $hero_meta_box_hide);

}
add_action( 'save_post', 'unibz_save_hero_meta_box' );


// my walker to build the navigation menu
class MyWalker extends Walker_Nav_Menu {
    var $db_fields = array (
        'parent' => 'menu_item_parent', 
        'id'     => 'db_id'
    );

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "<ul class='dropdown-menu'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "</ul>\n";

	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
		
		if(array_search('menu-item-has-children', $item->classes)) {
			$item->classes[] = 'dropdown-submenu';
			$link = "<a tabindex='0' data-toggle='dropdown' data-submenu=''>{$item->title} <span class='caret'></span></a>\n";
		}
		else {
			$link = "<a href='{$item->url}'>{$item->title}</a>\n";
		}

		$output .= '<li class="' . implode($item->classes, ' ') . '">'.$link;
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}


// style search form
function unibz_search_form_modify( $html ) {
	$html = str_replace( 'class="search-submit"', 'class="search-submit btn btn-default unibrand" style="position:absolute; margin-left:0.2em;"', $html );
	$html = str_replace( 'class="search-field"', 'class="search-field form-control"', $html );
	return $html;
}
add_filter( 'get_search_form', 'unibz_search_form_modify' );


// obfuscate an email address
function unibz_obfuscateEmail($email)
{
    $alwaysEncode = array('.', ':', '@');

    $result = '';

    // Encode string using oct and hex character codes
    for ($i = 0; $i < strlen($email); $i++)
    {
        // Encode 25% of characters including several that always should be encoded
        if (in_array($email[$i], $alwaysEncode) || mt_rand(1, 100) < 25)
        {
            if (mt_rand(0, 1))
            {
                $result .= '&#' . ord($email[$i]) . ';';
            }
            else
            {
                $result .= '&#x' . dechex(ord($email[$i])) . ';';
            }
        }
        else
        {
            $result .= $email[$i];
        }
    }

    return $result;
}

// returns a link with an obfuscated email address
function unibz_getObfuscatedEmailLink($email, $params = array()){
    if (!is_array($params))
    {
        $params = array();
    }

    // Tell search engines to ignore obfuscated uri
    if (!isset($params['rel']))
    {
        $params['rel'] = 'nofollow';
    }

    $neverEncode = array('.', '@', '+'); // Don't encode those as not fully supported by IE & Chrome

    $urlEncodedEmail = '';
    for ($i = 0; $i < strlen($email); $i++)
    {
        // Encode 25% of characters
        if (!in_array($email[$i], $neverEncode) && mt_rand(1, 100) < 25)
        {
            $charCode = ord($email[$i]);
            $urlEncodedEmail .= '%';
            $urlEncodedEmail .= dechex(($charCode >> 4) & 0xF);
            $urlEncodedEmail .= dechex($charCode & 0xF);
        }
        else
        {
            $urlEncodedEmail .= $email[$i];
        }
    }

    $obfuscatedEmail = unibz_obfuscateEmail(strrev($email));
    $obfuscatedEmailUrl = unibz_obfuscateEmail('mailto:' . $urlEncodedEmail);

    $link = '<a href="' . $obfuscatedEmailUrl . '"';
    foreach ($params as $param => $value)
    {
        $link .= ' ' . $param . '="' . htmlspecialchars($value). '"';
    }
    $link .= '>' . $obfuscatedEmail . '</a>';

    return $link;
}
