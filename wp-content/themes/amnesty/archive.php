<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            if (have_posts()) : ?>


            <figure class="header">
                <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                <figcaption>
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="taxonomy-description">', '</div>');
                    ?>

                </figcaption>
            </figure>

            <header class="page-header">
            </header><!-- .page-header -->

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
