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

        <?php if (have_posts()) : ?>

            <header class="page-header">
                <h2 class="entry-title"><?php printf(esc_html__('Search Results for: %s', 'telamo_new'), '<span>' . get_search_query() . '</span>'); ?></h2>
            </header>
            <?php
            global $wp_query;
            echo '<span class="results">' . $wp_query->found_posts . ' Ergebnisse gefunden.</span>'; ?>
            <?php get_search_form(); ?>

            <!-- .page-header -->

            <div class="grid">

                <?php while (have_posts()) : the_post(); ?>

                    <?php
                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('template-parts/content', 'post');
                    ?>

                <?php endwhile; ?>
            </div>

            <?php if ($wp_query->max_num_pages > 1) { ?>
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
                </nav> <?php } ?>
        <?php else : ?>

            <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>

    </main>
    <!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
