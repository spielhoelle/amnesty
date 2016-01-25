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
    $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
    $content = get_post_field('post_content', get_the_ID());
    $content_parts = get_extended($content);
    ?>

    <figure>
        <a href="<?php the_permalink() ?>">
            <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        </a>

        <figcaption class="bubble">
            <h1 class="entry-title"><?php echo get_the_title() ?></h1>';
            <h2><?php echo $content_parts['main'] ?></h2>
            <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
        </figcaption>
    </figure>

    <header class="entry-header">
        <?php
        echo '<h1>' . get_the_date() . '</h1>';
        echo '<p>' . get_the_title() . '</p>';


        echo '<a href="' . get_the_permalink() . '" class="more-link show">Mehr…</a>';
        ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
        <a href="<?php the_permalink() ?>">
            <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        </a>
    </div>
    <!-- .entry-content -->
</article>
<!-- content-post.php frontsite -->
