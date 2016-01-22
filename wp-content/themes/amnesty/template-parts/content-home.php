<?php // get the last 5 posts
$the_query = new WP_Query('posts_per_page=6'); ?>

    <div class="slider" data-navigation="hidden">
        <div>
            <?php while ($the_query->have_posts()) : $the_query->the_post();
                $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : catch_that_image();
                $content = get_post_field('post_content', get_the_ID());
                $content_parts = get_extended($content);
                ?>

                <figure>
                    <a href="<?php the_permalink() ?>">
                        <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                    </a>

                    <figcaption class="bubble">
                        <?php // Output part before <!--more--> tag
                        echo '<h1>aktuelle News</h1>';
                        echo get_the_date() . '<br/><br/>';
                        echo '<p>' . the_title() . '</p>'; ?>
                        <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
                    </figcaption>
                </figure>

            <?php endwhile; ?>
        </div>
    </div>
    <span class="arrowdown"></span>
    <!--content-home.php-->
<?php wp_reset_postdata();
