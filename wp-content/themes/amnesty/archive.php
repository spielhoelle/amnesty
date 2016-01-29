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

            <?php
            if (have_posts()) : ?>


            <figure class="<?php echo implode(' ', $classes) ?>">
                <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                <figcaption>
                    <h1 class="page-title">
                        <?php if (!is_author()) {
                            icons();
                        }
                        the_archive_title(); ?></h1>

                </figcaption>
            </figure>


            <div class="grid">
                <?php
                /* Start the Loop */
                while (have_posts()) : the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part('template-parts/content', '');
                endwhile;

                the_posts_navigation();

                else :

                    get_template_part('template-parts/content', 'none');

                endif; ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
