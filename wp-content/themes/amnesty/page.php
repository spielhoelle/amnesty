<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package phytocomm
 */


get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main"
    <?php while (have_posts()) : the_post(); ?>

        <?php if ($post->post_content !== '') {
            get_template_part('template-parts/section', $post->post_name);
        } ?>

    <?php endwhile; ?>

    <?php // get sub pages
    $subPages = get_pages(array(
        'child_of' => get_the_ID(),
        'sort_column' => 'menu_order,post_title',
        'post_type' => 'page',
        'post_status' => 'publish',
        'echo' => 0,
    ));

    foreach ($subPages as $subPage) {

        $subPage = new WP_Query('page_id=' . $subPage->ID);
        if ($subPage->have_posts()) :
            //check if on page_for_posts (news)
            //annoying
            echo ($subPage->query['page_id'] == get_option('page_for_posts'))
                ? '<section rel="News" id="section-' . get_the_ID() . '" data-url="' . get_the_permalink() . '" tabindex="' . $post->menu_order . '"> <header class="entry-header"><h2 class="entry-title">KÃ¼nstler</h2></header>'
                : '';

            while ($subPage->have_posts()) : $subPage->the_post();

                //annoying
                if ($subPage->query['page_id'] == get_option('page_for_posts')) {
                    get_template_part('template-parts/content', '');
                } else {
                    get_template_part('template-parts/section', $post->post_name);
                }
            endwhile; // End of the loop.

            //annoying
            echo ($subPage->query['page_id'] == get_option('page_for_posts')) ? '</section>' : '';

        endif;
    }

    // restore original post data
    wp_reset_postdata();

    if ($post->post_parent) :

        // get parent's sub pages
        $subPages = get_pages(array(
            'child_of' => $post->post_parent,
            'exclude' => get_the_ID(),
            'sort_column' => 'menu_order,post_title',
            'post_type' => 'page',
            'post_status' => 'publish',
            'echo' => 0,
        ));

        // display parent page
        $parentPage = new WP_Query('page_id=' . $post->post_parent);

        while ($parentPage->have_posts()) : $parentPage->the_post();
            get_template_part('template-parts/section', $post->post_name);
        endwhile; // End of the loop.

        // display parent's sub pages
        foreach ($subPages as $subPage) {

            //subpages containes all sites on front. Label, Video, News. So
            $subPage = new WP_Query('page_id=' . $subPage->ID);
            if ($subPage->have_posts()) :
                //annoying
                echo ($subPage->query['page_id'] == get_option('page_for_posts'))

                    ? '<section rel="News" id="section-' . get_the_ID() . '" data-url="' . get_the_permalink() . '" tabindex="' . $post->menu_order . '"> <header class="entry-header"><h2 class="entry-title">KÃ¼nstler</h2></header>'

                    : '';

                while ($subPage->have_posts()) : $subPage->the_post();

                    //annoying
                    if ($subPage->query['page_id'] == get_option('page_for_posts')) {
                        get_template_part('template-parts/content', '');
                    } else {
                        get_template_part('template-parts/section', $post->post_name);
                    }

                endwhile; // End of the loop.

                //annoying
                echo ($subPage->query['page_id'] == get_option('page_for_posts')) ? '</section>' : '';

            endif;
        }

        // restore original post data
        wp_reset_postdata(); ?>
    <?php endif; ?>

    </main>
    <!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

