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

                    <div>
                      <!-- <?php the_archive_title('<h1 class="entry-title">', '</h1>'); ?> -->
                      <?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>
                      <?php get_search_form(); ?>
                      <h1>Ähnliches zu diesem Thema:</h1>
                      <ul>
                        <?php
                        $cat_object = $wp_query->get_queried_object();
                        $parentcat = ($cat_object->category_parent) ? $cat_object->category_parent : $cat;
                        wp_list_categories("child_of=$parentcat&title_li");
                        ?>
                      </ul>
                      
                  </div>

                </header>
                <div class="grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/content', ''); ?>
                    <?php endwhile; ?>
                </div>
                <!-- index -->
                <nav class="pagination">
                    <?php
                    global $wp_query;

                    $big = 999999999; // need an unlikely integer

                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages
                    ));
                    ?>
                </nav>

            <?php else : ?>

                <?php get_template_part('template-parts/content', 'none'); ?>

            <?php endif; ?>


        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
