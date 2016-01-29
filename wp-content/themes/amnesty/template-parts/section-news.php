<section id="section-<?php the_ID(); ?>" data-url="<?php the_permalink(); ?>"
         tabindex="<?php echo $post->menu_order; ?>" rel="<?php echo $post->post_title; ?>">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <figure>
            <figcaption>
                <h1 class="entry-title"><?php the_title() ?></h1>
            </figcaption>
        </figure>
        <div class="wrap">

            <div class="grid">
                <?php // switch WP to page for posts
                $blog = new WP_Query('posts_per_page=6, page_id=' . get_option('page_for_posts'));

                // loop through posts
                while ($blog->have_posts()) : $blog->the_post();
                    get_template_part('template-parts/content', '');
                endwhile; ?>
            </div>

            <?php wp_reset_postdata(); ?>
            <footer class="entry-footer">
                <a class="more-link" href="<?php echo get_permalink(get_page_by_path('alle-news')) ?>">Mehr News ...</a>
            </footer>
        </div>
    </article>
</section>
<!-- #section-news.php-## -->
