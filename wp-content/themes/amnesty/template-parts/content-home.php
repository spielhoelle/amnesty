<?php // get the last 6 posts
$the_query = new WP_Query('posts_per_page=6'); ?>

    <div class="slider-wrap">
      <div class="slider" data-navigation="hidden">

          <?php while ($the_query->have_posts()) : $the_query->the_post();
              if (get_post_status(get_the_ID()) !== "private") {

              $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'header')[0] : '';
              $content = get_post_field('post_content', get_the_ID());
              $content_parts = get_extended($content);
              ?>

              <figure class="header">
                  <a href="<?php the_permalink() ?>">
                      <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                  </a>

                  <figcaption>
                      <h1 class="entry-title">
                          <?php icons();
                          echo get_the_title() ?>
                      </h1>
                      <h2><?php echo $content_parts['main'] ?></h2>
                      <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
                  </figcaption>
              </figure>

          <?php
          }
         endwhile; ?>

      </div>
      <div class='custom-pager'>
        <?php $i = 0;
        while ($the_query->have_posts()) : $the_query->the_post();
        if (get_post_status(get_the_ID()) !== "private") { ?>
          <a data-slide-index="<?php echo $i ?>" href="<?php the_permalink() ?>" class="entry-title">
            <?php icons(false); ?>
          </a>
          <?php $i++;
        }
      endwhile;
      ?>
    </div>
  </div>
    <!-- <div class="subslider">
      <h1>We campaign for a world where human rights are enjoyed by all</h1>
      <p>Amnesty International is a global movement of more than 7 million people in over 150 countries and territories who campaign to end abuses of human rights.</p>
    </div> -->

    <!--content-home.php-->
<?php wp_reset_postdata();
