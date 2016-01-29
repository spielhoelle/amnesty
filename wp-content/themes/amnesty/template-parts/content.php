<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */
$img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
$content = get_post_field('post_content', get_the_ID());
$content_parts = get_extended($content);
?>
<article data-url="<?php the_permalink(); ?>"
         rel="<?php echo get_the_title() ?>"
         id="post-<?php the_ID(); ?>" <?php post_class((has_post_thumbnail()) ? 'has_post_thumbnail' : ''); ?>>
    <?php
    ?>

    <figure>
        <a href="<?php the_permalink() ?>">
            <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        </a>

        <figcaption>
            <h1 class="entry-title"><?php
                icons();
                echo get_the_title() ?></h1>
            <br>
            <h2><?php echo $content_parts['main'] ?></h2>
            <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
        </figcaption>
    </figure>

</article>
<!-- content.php grid-->

