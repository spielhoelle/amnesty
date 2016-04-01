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
        if (have_posts()) : ?>

        <header class="entry-header">

            <div class="overview">
              <h1><?php esc_html_e( 'Most Used Categories', 'amnesty' ); ?></h1>
              <?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>

              <ul class="category_structure">
                <?php
                $args = array(
                'depth'              => 1,
                'title_li'           => '',
                'show_option_none'   => '',
                'exclude'            => 1
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


    </main>
    <!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
