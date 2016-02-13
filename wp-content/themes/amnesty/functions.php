<?php
/**
 * amnesty functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package amnesty
 */

if (!function_exists('amnesty_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function amnesty_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on amnesty, use a find and replace
         * to change 'amnesty' to the name of your theme in all the template files.
         */
        load_theme_textdomain('amnesty', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'amnesty'),
            'footer' => esc_html__('Footer Menu', 'amnesty'),

        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('amnesty_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }
endif;
add_action('after_setup_theme', 'amnesty_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function amnesty_content_width()
{
    $GLOBALS['content_width'] = apply_filters('amnesty_content_width', 640);
}

add_action('after_setup_theme', 'amnesty_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function amnesty_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Footer', 'amnesty'),
        'id' => 'footer',
        'description' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'amnesty_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function amnesty_scripts()
{
    wp_enqueue_style('amnesty-style', get_stylesheet_uri());

    wp_enqueue_style('dashicons');

    wp_enqueue_style('font-awesome', get_bloginfo('stylesheet_directory') . '/sass/font-awesome.min.css');

    wp_enqueue_script("jquery");

    wp_enqueue_script('bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array(), '', true);

    wp_enqueue_script('functions', get_template_directory_uri() . '/js/functions.js', array(), '', true);

    wp_enqueue_script('amnesty-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);

    wp_enqueue_script('amnesty-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'amnesty_scripts');

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
require get_template_directory() . '/inc/tinymce.php';
require get_template_directory() . '/inc/remove.comments.php';


/**
 * show page name in <title> to see which page is currently edited.
 */
add_filter('admin_title', 'my_admin_title', 10, 2);

function my_admin_title($admin_title, $title)
{
    $currentScreen = get_current_screen();
    if ($currentScreen->id === 'page' || $currentScreen->id === 'post' || $currentScreen->id === 'project' || $currentScreen->id === 'product') {
        return 'e-' . get_the_title();
    } else {
        return $admin_title;
    }
}


/**
 * add style to admin
 */

add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style()
{
    //@TODO checken
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/sass/admin-style.css', false, '1.0.0');
}


function my_theme_add_editor_styles()
{
    add_editor_style('editor.css');
}

add_action('admin_init', 'my_theme_add_editor_styles');

function icons($link = true)
{
    global $post;
    $category = get_parent_cat();
    if ($category->category_description !== '' && $category->category_description) {
        echo ($link) ? '<a href="' . get_category_link(get_cat_ID($category->name)) . '">' : '';
        echo '<i title="' . $category->name . '" class="fa ' . $category->category_description . '"></i>';
        echo ($link) ? '</a>' : '';
    } else {
        echo (!$link) ? file_get_contents("wp-content/themes/amnesty/img/amensty.svg") : '';

    }


}


/**
 * get header pic function for fallback images in posts
 */


function headerPic()
{
    if (wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]) {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    } else {
        $rand = rand(1, 4);
        $img = get_template_directory_uri() . '/img/thumbnail-' . $rand . '.jpg';
    } ?>

    <figure class="header">
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <figcaption>

            <h1 class="entry-title ">
                <?php icons();
                echo get_the_title() ?>
            </h1>
        </figcaption>
    </figure>
    <?php
    return $img;
}

/**
 * get thumbnail, get attachment, get category image
 */

/**
 * get parent category
 */


function get_parent_cat()
{
    $categories = get_the_category();
    foreach ($categories as $cat) {
        if ($cat->category_parent !== 0) {
            $parent = $cat->category_parent;
        } else {
            $parent = $cat;
        }
    }
    return $parent;
}

function get_thumbnail()
{
    $img = '';
    if (get_post_type() == 'page') {
        $rand = rand(1, 4);
        $img = get_template_directory_uri() . '/img/thumbnail-' . $rand . '.jpg';
    } else {
        if (has_post_thumbnail()) {
            $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
        } else if (function_exists('z_taxonomy_image_url')) {
            $parent = get_parent_cat();
            $img = z_taxonomy_image_url($parent->term_id);
        }
        if ($img == '') {
            $rand = rand(1, 4);
            $img = get_template_directory_uri() . '/img/thumbnail-' . $rand . '.jpg';

        }
    }
    return $img;

}


function dump($param)
{
    echo "<pre style='position:absolute; z-index: 999999; background: rgba(255, 255, 255, 0.31)'>";
    var_dump($param);
    echo "</pre>";

}