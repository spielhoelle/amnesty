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
    <meta name="description" content="<?php if(get_post_meta($post->ID, "description", true) !='' ) echo get_post_meta($post->ID, "description", true); else bloginfo('description');?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site page-hidden">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'amnesty'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="top">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </h1>
            </div><!-- .site-branding -->
            <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu"
                        aria-expanded="false"><?php esc_html_e('Primary Menu', 'amnesty'); ?></button>
                <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu')); ?>
            </nav><!-- #site-navigation -->
        </div>


    </header><!-- #masthead -->

    <div id="content" class="site-content">
