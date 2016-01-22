<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package amnesty
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'amnesty'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="top">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </h1>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu"
                        aria-expanded="false"><?php esc_html_e('Primary Menu', 'amnesty'); ?></button>
                <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu')); ?>
            </nav><!-- #site-navigation -->
        </div>

        <ul>
            <?php
            $args = array('numberposts' => '5');
            $recent_posts = wp_get_recent_posts($args);
            foreach ($recent_posts as $recent) {

                $output = '';
                if (has_post_thumbnail($recent['ID'])) :
                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($recent['ID']), 'full');
                    $output = ' style="background-image: url(' . $thumb[0] . ')"';
                endif;
                echo '<li' . $output . '><a href="' . get_permalink($recent["ID"]) . '">' . $recent["post_title"] . '</a> </li>            ';
            }
            ?>
        </ul>
        <?php if (($header_images = get_uploaded_header_images())): ?>
            <div id="slideshow">
                <?php foreach ($header_images as $header_image): ?>

                    <figure class="pattern">
                        <?php $data = wp_prepare_attachment_for_js($header_image['attachment_id']); ?>
                        <img src="/wp-includes/images/blank.gif"
                             style="background-image: url(<?php echo esc_url($header_image['url']); ?>)"/>
                        <figcaption>
                            <h1 class="entry-title"><?php echo $data['title'] ?></h1>

                            <h2><?php echo $data['caption'] ?></h2>

                            <h3><?php echo $data['alt'] ?></h3>

                            <p><?php echo $data['description'] ?></p>


                        </figcaption>
                    </figure>

                <?php endforeach; ?>
            </div>
        <?php endif; ?> <!-- slider -->


    </header><!-- #masthead -->

    <div id="content" class="site-content">
