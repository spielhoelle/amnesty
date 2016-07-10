<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php // news page is page
        if (have_posts()) : 
  
             archiveHeader();
           ?>

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
                    'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'  => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total'   => $wp_query->max_num_pages
                ));
                ?>
            </nav>
        <?php else : ?>

            <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>


    </main>
    <!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
