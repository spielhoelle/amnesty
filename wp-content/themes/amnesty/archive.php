<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$img = '';
$classes = [];
if (z_taxonomy_image_url($cat->term_id)) {
    $img = z_taxonomy_image_url($cat->term_id);
    $classes[] = 'header';
}
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php // news page is page
            if (have_posts()) : ?>

                <header class="entry-header">

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


                  <div>
                      <?php get_search_form(); ?>
                  </div>


                </header>
                <div id="infinite-scroll" class="grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', ''); ?>
                    <?php endwhile; ?>
                </div>
                <!-- index -->

            <?php else : ?>

                <?php get_template_part('template-parts/content', 'none'); ?>

            <?php endif; ?>


        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
