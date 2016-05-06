<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$classes = [];
$img =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
if($img) {
  $classes[] = 'header';
} else {
  $classes[] = 'noheader';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <figure class="<?php echo implode(' ', $classes) ?>">
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <figcaption>

            <h1 class="entry-title ">
                <?php
                icons();
                echo get_the_title() ?>
            </h1>
        </figcaption>
    </figure>

    <div class="wrap">
        <div class="content-wrapper">

            <div class="entry-content">
                <?php
                if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php amnesty_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                endif; ?>


                <?php the_content(sprintf(
                    wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'amnesty'), array('span' => array('class' => array()))),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ));

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                    'after' => '</div>',
                ));
                ?>

            </div><!-- .entry-content -->
            <footer class="entry-footer">
                <?php amnesty_entry_footer(); ?>
            </footer><!-- .entry-footer -->

        </div>


        <?php if (is_single()) { ?>
            <aside>
                <h2>Letzte Beiträge</h2>

                <?php
                $args = array(
                    'post__not_in' => array($post->ID),
                    'showposts' => 5,
                    'caller_get_posts' => 1
                );

                $recent_posts = new WP_Query($args);

                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                  if (get_post_status(get_the_ID()) !== "private") { ?>
                    <h3 class="entry-title">
                      <?php icons(); ?>
                      <a href="<?php the_permalink() ?>" class="entry-title ">
                        <?php
                        echo get_the_title();
                      ?>
                      </a>
                    </h3>
                  <?php }
                endwhile;
                wp_reset_postdata(); ?>
            </aside>

        <?php } ?>

    </div>


</article><!-- content-post.php -->
