<?php // get the last 6 posts
$the_query = new WP_Query('posts_per_page=6'); ?>

    <article class="slider-wrap">
      <div class="slider" data-navigation="hidden">

          <?php

           while ($the_query->have_posts()) : $the_query->the_post();
              if (get_post_status(get_the_ID()) !== "private") {

              $img = get_thumbnail($size = 'full');
              $content = get_post_field('post_content', get_the_ID());
              $content_parts = get_extended($content);
              ?>

              <figure class="header">
                  <a href="<?php the_permalink() ?>">
                      <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                  </a>
                  <span class="icons"><?php icons(); ?></span>
                  <figcaption>
                      <h1 class="entry-title">

                        <?php echo get_the_title() ?>
                      </h1>
                      <h2><?php
                      // if( strpos( $post->post_content, '<!--more-->' ) ) {
                        // echo wp_strip_all_tags( $content_parts['main']);
                        $bla = get_the_excerpt();
                        echo wp_strip_all_tags($bla);
                      // } else {
                      //   echo substr(get_post_field('post_content', get_the_ID()), 0, 50);
                      // }
                      ?></h2>
                      <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
                  </figcaption>
              </figure>

          <?php
          }
         endwhile; ?>

      </article>
    <!--content-home.php-->
<?php wp_reset_postdata();
