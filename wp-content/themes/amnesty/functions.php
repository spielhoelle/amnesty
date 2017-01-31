<?php
/**
 * amnesty functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package amnesty
 */

if (!function_exists('amnesty_setup')) :
    function amnesty_setup() {
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
function amnesty_content_width() {
    $GLOBALS['content_width'] = apply_filters('amnesty_content_width', 640);
}


add_action('after_setup_theme', 'amnesty_content_width', 0);
function amnesty_widgets_init() {
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

function amnesty_scripts() {
    wp_enqueue_style('amnesty-style', get_stylesheet_uri());

    wp_enqueue_style('dashicons');

    wp_enqueue_style('font-awesome', get_bloginfo('stylesheet_directory') . '/sass/font-awesome.min.css');

    wp_enqueue_script("jquery");

    wp_enqueue_script('bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array(), '', true);

    wp_enqueue_script('newsletter_popup', get_template_directory_uri() . '/js/newsletter_popup.js', array(), '', true);
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
require get_template_directory() . '/inc/tinymce.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/page.color.php';

add_filter('admin_title', 'my_admin_title', 10, 2);
function my_admin_title($admin_title, $title) {
    $currentScreen = get_current_screen();
    if ($currentScreen->id === 'page' || $currentScreen->id === 'post' || $currentScreen->id === 'project' || $currentScreen->id === 'product') {
        return '*' . get_the_title();
    } else {
        return $admin_title;
    }
}

add_action('admin_enqueue_scripts', 'custom_load_admin_style');
function custom_load_admin_style() {
    //@TODO checken
    wp_enqueue_style('custom_admin_css', get_stylesheet_directory_uri() . '/sass/custom-admin-style.css', true);
}

function my_theme_add_editor_styles()
{
    add_editor_style('editor.css');
}

add_action('admin_init', 'my_theme_add_editor_styles');

function icons($link = true, $title = false) {
  global $post;
  $categories = get_parent_cats();

  //all categorys
  foreach($categories as $category){
    if ($category->category_description !== '' && $category->category_description) {
      echo ($link) ? '<a title="'. $category->name .'" href="' . get_category_link(get_cat_ID($category->name)) . '">' : '';
      echo ($title) ? $category->name :  '';

      echo '<i title="' . $category->name . '" class="fa ' . $category->category_description . '"></i>';
      echo ($link) ? '</a>' : '';
    } else {
        echo (!$link) ? file_get_contents("wp-content/themes/amnesty/img/amensty.svg") : '';
    }
  }
}



/**
 * get parent category
 */

function get_parent_cats() {
  $categories = get_the_category();
  $parents = [];

  foreach ($categories as $cat) {
      if ($cat->category_parent !== 0) {
          $parent = get_category($cat->category_parent);
          if ($parent->category_parent !== 0) {
              $parent = get_category($parent->category_parent);
              if ($parent->category_parent !== 0) {
                  $parent = get_category($parent->category_parent);
              }
          }
      } else {
        $parent = $cat;
      }
      $parents[$parent->term_id] = $parent;
  }
  return $parents;
}

add_image_size('grid', 500, 500, true); // Hard Crop Mode



/**
 * get thumbnail, get attachment, get category image
 */

//@todo for fallback images choose right sizes
function get_thumbnail($size = '') {

    $directory = 'wp-content/themes/amnesty/img/';
    $files = array_slice(scandir('wp-content/themes/amnesty/img/fallback/full'), 2);

    $img = '';
    if (get_post_type() == 'page') {
        $rand = rand(1, 4);
        $img = get_template_directory_uri() . '/img/fallback/full/thumbnail-full-' . $rand . '.jpg';
    } else {
        if (has_post_thumbnail()) {
            $img = wp_get_attachment_image_src(get_post_thumbnail_id(), $size)[0];
        } else if (function_exists('z_taxonomy_image_url')) {
            $parents = get_parent_cats();
            $img = z_taxonomy_image_url(array_values($parents)[0]->term_id);
        }
        if ($img == '') {
            $fallbacks = explode(", ", get_option('fallback_img'));
            $amount_of_fallbacks = count($fallbacks);
            $last_digit_of_id = substr(get_the_ID(), -1);
            $closest = null;
            foreach ($fallbacks as $fallback) {
              $last_digit_of_fallback = substr($fallback, -1);
              if ($closest === null || abs($last_digit_of_id - $closest) > abs($last_digit_of_fallback - $last_digit_of_id)) {
                 $closest = $last_digit_of_fallback;
                 $choosen = $fallback;
              }
            }
            $img = wp_get_attachment_image_src($choosen, 'full' )[0];
        }
    }
    return $img;
}


//add search button at the end of navi
add_filter( 'wp_nav_menu_items', 'append_search_field_to_nav', 10, 2 );
function append_search_field_to_nav( $items, $args ) {
    if ($args->theme_location == 'primary' ) {
      $items .= '<li id="menu-search"><i class="fa fa-search"></i>';
      $items .=  get_search_form(false);
      $items .= '</li>';
    }
    return $items;
}


/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address.
 */
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}
add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );



add_filter('widget_text', 'do_shortcode');


function archiveHeader(){

  $img = '';
  $classes = [];

  $parents = get_parent_cats();

  if (function_exists('z_taxonomy_image_url') && is_archive() && !is_tag()) {
    $img = z_taxonomy_image_url(array_values($parents)[0]->term_id);
      if($img) {
       $classes[] = 'header';
       }
     }

  ?>
  <figure class="archiveheader <?php echo implode(' ', $classes) ?>">
      <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
      <figcaption>
      <div class="overview">

          <?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>
          <ul class="category_structure">
            <?php
            $args = array(
            'child_of'           => (get_query_var('cat')) ? get_query_var('cat') : 1,
            'title_li'           => '',
            'show_option_none'  => ''
               );

               wp_list_categories( $args );
               ?>
          </ul>

      </div>


        <?php get_search_form(); ?>

      </figcaption>
        <?php
        if ($img && !empty($data['caption'])) {
          echo '<small>';
            echo __('Copyright: ', 'amnesty');
            echo $data['caption'] . '</small>';
          echo '</small>';
        } ?>
      </small>
  </figure>
  <?php
}







// remove admin menu entrys for roles other than admin
function remove_menus(){
  $user = wp_get_current_user();
  if ( !in_array( 'administrator', (array) $user->roles ) ) {
      // remove_menu_page( 'index.php' );                  //Dashboard
      // remove_menu_page( 'upload.php' );                 //Media
      // remove_menu_page( 'edit.php?post_type=page' );    //Pages
      // remove_menu_page( 'edit-comments.php' );          //Comments
      // remove_menu_page( 'themes.php' );                 //Appearance
      // remove_menu_page( 'plugins.php' );                //Plugins
      // remove_menu_page( 'users.php' );                  //Users
      remove_menu_page( 'tools.php' );                  //Tools
      // remove_menu_page( 'options-general.php' );        //Settings

    };
}

// add_action( 'admin_menu', 'remove_menus' );


/* Remove Contact Form 7 Links from dashboard menu items if not admin */
if (!(current_user_can('administrator'))) {
  function remove_wpcf7() {
      remove_menu_page( 'wpcf7' );
  }

  add_action('admin_menu', 'remove_wpcf7');
}
add_action('admin_init', 'my_general_section');
function my_general_section() {
    add_settings_section(
        'my_settings_section', // Section ID
        'Fallback Bilder', // Section Title
        'my_section_options_callback', // Callback
        'media' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'fallback_img', // Option ID
        'IDs', // Label
        'my_textbox_callback', // !important - This is where the args go!
        'media', // Page it will be displayed (General Settings)
        'my_settings_section', // Name of our section
        array( // The $args
            'fallback_img' // Should match Option ID
        )
    );

    register_setting('media','fallback_img', 'esc_attr');
}

function my_section_options_callback() { // Section Callback
    echo '<p>Kommagetrennte IDs der Fallback Bilder eintragen</p>';
}

function my_textbox_callback($args) {  // Textbox Callback
    $option = get_option($args[0]);
    echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}
