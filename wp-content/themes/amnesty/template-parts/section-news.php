<section class="<?php echo get_post_meta(get_the_ID(), '_page_color', true) ?>" data-url="<?php the_permalink(); ?>"
         tabindex="<?php echo $post->menu_order; ?>" rel="<?php echo $post->post_title; ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <figure>
            <figcaption>
                <h1 class="entry-title"><?php the_title() ?></h1>
            </figcaption>
        </figure>

        

        <footer class="entry-footer">
            <a class="more-link" href="<?php echo get_permalink(get_page_by_path('alle-news')) ?>">Mehr News ...</a>
        </footer>
    </article>
    <div class="grid">
        <?php // switch WP to page for posts
        $args = array(
            'post_status' => 'publish',
            'showposts' => 8,
            'ignore_sticky_posts' => 1
        );

        $blog = new WP_Query($args);
        // loop through posts
        while ($blog->have_posts()) : $blog->the_post();
          get_template_part('template-parts/content', '');
        endwhile;
        wp_reset_query();
         ?>
    </div>

    <?php wp_reset_postdata(); ?>
</section>
<!-- #section-news.php-## -->
