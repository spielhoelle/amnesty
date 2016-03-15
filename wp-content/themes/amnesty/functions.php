<?php
/**
 * amnesty functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package amnesty
 */

if (!function_exists('amnesty_setup')) :
    function amnesty_setup()
    {
        load_theme_textdomain('amnesty', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'amnesty'),
            'footer' => esc_html__('Footer Menu', 'amnesty'),

        ));
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        add_theme_support('custom-background', apply_filters('amnesty_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }
endif;
add_action('after_setup_theme', 'amnesty_setup');
function amnesty_content_width()
{
    $GLOBALS['content_width'] = apply_filters('amnesty_content_width', 640);
}


add_action('after_setup_theme', 'amnesty_content_width', 0);
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
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/inc/tinymce.php';
require get_template_directory() . '/inc/remove.comments.php';
require get_template_directory() . '/inc/breadcrumbs.php';

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
 * get thumbnail, get attachment, get category image
 */

/**
 * get parent category
 */


function get_parent_cat()
{
    $categories = get_the_category();
    $parent = 0;
    foreach ($categories as $cat) {
        if ($cat->category_parent !== 0) {
            $parent = $cat->category_parent;
        } else {
            $parent = $cat;
        }
    }
    return $parent;
}

add_image_size('grid', 500, 500, true); // Hard Crop Mode
add_image_size('header', 1600, 700, true); // Hard Crop Mode

//@todo for fallback images choose right sizes
function get_thumbnail($size = '')
{
    $img = '';
    if (get_post_type() == 'page') {
        $rand = rand(1, 4);
        $img = get_template_directory_uri() . '/img/thumbnail-full-' . $rand . '.jpg';
        echo '<!--is_page-->';
    } else {
        if (has_post_thumbnail()) {
            $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $size)[0];
            echo '<!--has_post_thumb-->';

        } else if (function_exists('z_taxonomy_image_url')) {
            $parent = get_parent_cat();
            $img = z_taxonomy_image_url($parent->term_id);
            echo '<!--get cat image-->';

        }
        if ($img == '') {
            $rand = rand(1, 4);
            if ($size === 'header') {
                $size === 'full';
            }
            $img = get_template_directory_uri() . '/img/thumbnail-full-' . $rand . '.jpg';
            echo '<!--random fallback-->';

        }
    }
    return $img;

}

/**
 * debug helper
 */

function dump($param)
{
    echo "<pre style='position:absolute; z-index: 999999; background: rgba(255, 255, 255, 0.31)'>";
    var_dump($param);
    echo "</pre>";

}



//add search button at the end of navi
add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if ($args->theme_location == 'primary') {
      $items .= '<li id="menu-search"><i class="fa fa-search"></i>';
      $items .=  get_search_form(false);
      $items .= '</li>';
    }
    return $items;
}
