<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amnesty
 */
$classes = [];
$img =  get_thumbnail();
if($img) {
  $classes[] = 'header';
  $data = wp_prepare_attachment_for_js( get_post_thumbnail_id( $post->ID ) );
} else {
  $classes[] = 'noheader';
}

$content = get_post_field('post_content', get_the_ID());
$content_parts = get_extended($content);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <figure class="<?php echo implode(' ', $classes) ?>">
        <span class="icons"><?php icons(true, true); ?></span>
        <img alt="<?php echo get_post(get_post_thumbnail_id($post->ID))->post_title ?>" src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <figcaption>

            <h1 class="entry-title ">
                <?php echo get_the_title() ?>
            </h1>
        </figcaption>
          <?php
          if ($img && !empty($data['caption'])) {
            echo '<small>';
              echo __('Copyright: ', 'amnesty');
              echo $data['caption'] . '</small>';
            echo '</small>';
          } ?>
        </small>
    </figure>

    <div class="wrap">
        <div class="content-wrapper">

            <div class="entry-content">

                <?php
                the_content(sprintf(
                    wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'amnesty'), array('span' => array('class' => array()))),
                    the_title('<span class="screen-reader-text">"', '"</span>', false)
                ));

                // echo $content_parts['extended'];

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                    'after' => '</div>',
                ));
                ?>
                <?php
                if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php amnesty_posted_on(); ?>
                    </div><!-- .entry-meta -->
                    <?php
                endif; ?>
            </div><!-- .entry-content -->
            <footer class="entry-footer">
                <?php amnesty_entry_footer(); ?>
            </footer><!-- .entry-footer -->

        </div>


        <?php if (is_single()) { ?>
            <section class="sidebar">
              <aside>
                  <h2>Letzte Beiträge</h2>

                  <?php
                  $args = array(
                    'post_status' => 'publish',
                    'post__not_in' => array($post->ID),
                    'showposts' => 5,
                    'ignore_sticky_posts' => 1
                  );

                  $recent_posts = new WP_Query($args);

                  while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                        <a title="<?php the_title() ?>" href="<?php the_permalink() ?>" class="entry-title">
                          <?php
                          echo get_the_title();
                        ?>
                        </a>
                    <?php
                  endwhile;
                  wp_reset_query(); ?>
              </aside>
              <aside>
                <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
              </aside>
            </section>
        <?php } ?>
    </div>
    <div class="wrap">
      <h1 class="entry-title"> Mehr? </h1>
    </div>



</article>

  <div class="grid">
    <?php // switch WP to page for posts
    // Get categories
       $categories = wp_get_post_terms( get_the_ID(), 'category');

       // Check if there are any categories
       if( ! empty( $categories ) ) :

           // Get all posts within current category, but exclude current post
           $category_posts = new WP_Query( array(
               'cat'          => $categories[0]->term_id,
               'post__not_in' => array( get_the_ID() ),
           ) );

           // Check if there are any posts
           if( $category_posts->have_posts() ) :
               // Loop trough them
               while( $category_posts->have_posts() ) : $category_posts->the_post();
                   // Display posts
                   get_template_part('template-parts/content', '');

               endwhile;
           endif;
       endif;



    // loop through posts
    wp_reset_query();
    ?>
</div>


<!-- content-post.php -->
