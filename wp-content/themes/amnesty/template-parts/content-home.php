<?php // get the last 6 posts
$the_query = new WP_Query('posts_per_page=6'); ?>

    <article class="slider-wrap">
      <div class="slider" data-navigation="hidden">

          <?php

           while ($the_query->have_posts()) : $the_query->the_post();

              $img = get_thumbnail($size = 'full');
              $data = wp_prepare_attachment_for_js( get_post_thumbnail_id( $post->ID ) );

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
                        $bla = get_the_excerpt();
                        echo wp_strip_all_tags($bla);?>
                      </h2>
                      
                      <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
                  </figcaption>
                  <?php
                  if ($data['caption'] !== '' && $data['caption']) { ?>
                    <small>Quelle: <?php echo $data['caption'];?></small>
                  <?php } ?>
              </figure>

            <?php endwhile; ?>

      </article>
    <!--content-home.php-->
<?php wp_reset_postdata();
