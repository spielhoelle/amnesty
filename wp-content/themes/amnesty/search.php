<?php
/**
 * The template for displaying search results pages.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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

        <?php else : ?>

            <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>
        <nav class="pagination">
                <?php
                global $wp_query;

                $big = 999999999; // need an unlikely integer

                echo paginate_links(array(
                    'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'  => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total'   => $wp_query->max_num_pages
                ));?>

            </nav>
    </main>
    <!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
