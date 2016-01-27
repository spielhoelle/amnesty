<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
if (has_post_thumbnail()) : ?><?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
    $output = ' style="background-image: url(' . $thumb[0] . ')"';
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
    $content = get_post_field('post_content', get_the_ID());
    $content_parts = get_extended($content); ?>

    <figure class="header">
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
    </figure>


    <div class="wrap">
        <div class="content-wrapper">

            <div class="entry-content">
                <?php
                if (is_single()) {
                    the_title('<h1 class="entry-title">', '</h1>');
                } else {
                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                }

                if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php amnesty_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                endif; ?>


                <?php
                the_content(sprintf(
                /* translators: %s: Name of current post. */
                    wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'amnesty'), array('span' => array('class' => array()))),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ));

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                    'after'  => '</div>',
                ));
                ?>


            </div><!-- .entry-content -->
            <footer class="entry-footer">
                <?php amnesty_entry_footer(); ?>
            </footer><!-- .entry-footer -->

        </div>

        <aside>
            <h2>Letzte Beiträge</h2>

            <?php $recent_posts = new WP_Query('posts_per_page=5, page_id=' . get_option('page_for_posts'));

            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                $format = (get_post_format()) ? get_post_format() : 'standard'; ?>
                <h3>
                    <a href="<?php the_permalink() ?>"
                       class="entry-title post-format-icon post-format-<?php echo $format ?>"><?php echo get_the_title() ?></a>
                </h3>
                <?php
            endwhile;
            wp_reset_postdata(); ?>

        </aside>
    </div>


</article><!-- content-post.php -->
