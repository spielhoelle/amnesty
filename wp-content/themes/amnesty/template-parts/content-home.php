<?php // get the last 6 posts
$the_query = new WP_Query('posts_per_page=6'); ?>

    <div class="slider" data-navigation="hidden">

        <?php while ($the_query->have_posts()) : $the_query->the_post();
            $img = (has_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] : '';
            $content = get_post_field('post_content', get_the_ID());
            $content_parts = get_extended($content);
            $format = (get_post_format()) ? get_post_format() : 'standard';
            ?>

            <figure>
                <a href="<?php the_permalink() ?>">
                    <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
                </a>

                <figcaption class="bubble">
                    <h1 class="entry-title post-format-icon post-format-<?php echo $format ?>"><?php echo get_the_title() ?></h1>
                    <h2><?php echo $content_parts['main'] ?></h2>
                    <a class="more-link" href="<?php the_permalink() ?>"> Mehr... </a>
                </figcaption>
            </figure>

        <?php endwhile; ?>
    </div>
    <div class='custom-pager'>
        <?php
        $i = 0 ;
        while ($the_query->have_posts()) : $the_query->the_post();
            $format = (get_post_format()) ? get_post_format() : 'standard'; ?>
            <a data-slide-index="<?php echo $i ?>" href="<?php the_permalink() ?>"
               class="entry-title post-format-icon post-format-<?php echo $format ?>"></a>
        <?php $i++; endwhile; ?>
    </div>
    <span class="arrowdown"></span>
    <!--content-home.php-->
<?php wp_reset_postdata();
