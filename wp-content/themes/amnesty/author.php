<?php get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <!-- This sets the $curauth variable -->

            <?php
            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
            ?>
            <figure>
                <figcaption>
                    <h1 class="page-title">About: <?php echo $curauth->nickname . ' ' . $curauth->last_name; ?></h1>
                </figcaption>
            </figure>

            <div class="wrap">
                <div class="userinfo">
                    <?php if (get_wp_user_avatar_src() !== '') { ?>
                        <img src="/wp-includes/images/blank.gif"
                             style="background-image:url(<?php echo get_wp_user_avatar_src(); ?>)">
                    <?php } ?>

                    <div class="profile">
                        <?php if ($curauth->user_description !== '') { ?>
                            <h2>Über</h2>
                            <p><?php echo $curauth->user_description; ?></p>
                        <?php } ?>
                        <?php echo ($curauth->user_url) ? '<dt>Website</dt><dd><a href="' . $curauth->user_url . '">' . $curauth->user_url . '</a></dd>' : '' ?>
                    </div>
                </div>
                <h2>Beiträge von <span class="author vcard"><?php echo $curauth->nickname; ?></span>:</h2>

            </div>


            <div class="grid">
                <!-- The Loop -->

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    get_template_part('template-parts/content', '');
                endwhile;
                else: ?>
                    <p><?php _e('No posts by this author.'); ?></p>

                <?php endif; ?>

                <!-- End Loop -->

            </div>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>