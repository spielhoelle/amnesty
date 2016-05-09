<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package telamo_new
 */


$img = get_thumbnail('grid');

$content = get_post_field('post_content', get_the_ID());
$content_parts = get_extended($content);
?>
<article data-url="<?php the_permalink(); ?>" rel="<?php echo get_the_title() ?>"
         id="post-<?php the_ID(); ?>" <?php post_class((has_post_thumbnail()) ? 'has_post_thumbnail' : ''); ?>>

    <figure>
        <a href="<?php the_permalink() ?>">
            <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        </a>

        <span class="icons"><?php icons(); ?></span>
        <figcaption>
          <div>
            <h1 class="entry-title">
              <?php echo get_the_title() ?></h1>
          </div>
            <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
        </figcaption>
    </figure>

</article>
<!-- content.php grid-->
