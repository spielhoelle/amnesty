
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

    <?php

    $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
    $content = get_post_field('post_content', get_the_ID());
    $content_parts = get_extended($content);
    ?>

    <figure>
        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
    </figure>

    <header class="entry-header">
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
    </header><!-- .entry-header -->

    <div class="content-wrapper">
        <div class="entry-content">

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
        <?php dynamic_sidebar('sidebar'); ?>
    </div>

    <footer class="entry-footer">
        <?php amnesty_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- content-post.php -->
