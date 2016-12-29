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
  $data = wp_prepare_attachment_for_js( get_post_thumbnail_id( $post->ID ) );
} else {
  $classes[] = 'noheader';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <figure class="<?php echo implode(' ', $classes) ?>">
        <span class="icons"><?php icons(true, true); ?></span>
        <?php if($img){ ?>
          <img alt="<?php echo get_post(get_post_thumbnail_id($post->ID))->post_title ?>" src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
        <?php } ?>
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
              if ('post' === get_post_type()) : ?>
                  <div class="entry-meta">
                      <?php amnesty_posted_on(); ?>
                  </div><!-- .entry-meta -->
                  <?php
              endif; ?>


              <?php
              the_content(sprintf(
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



</article>


<?php if ( comments_open() ) { ?>
  <section class="color2">
    <div class="viewport margin--auto">
      <?php comments_template() ?>
    </div>
  </section>
<?php } ?>


<div class="wrap">
  <h1 class="entry-title"> Mehr? </h1>
</div>


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
