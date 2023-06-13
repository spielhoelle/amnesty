<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package amnesty
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-wrap">
        <div class="footer-container">
            <div class="footer-top"><?php dynamic_sidebar('footer'); ?></div>
        </div>
        <div class="footer-below">

            <div class="rest">
                <div>
                    <a title="Impressum" href="<?php echo get_permalink( get_page_by_path( 'impressum' ) ) ?>">Impressum</a> |
                    <a title="Datenschutz" href="<?php echo get_permalink( get_page_by_path( 'datenschutz' ) )?>">Datenschutz</a> |
                    © 2023 AMNESTY INTERNATIONAL
                </div>
                <ul class="socialicons">
                    <li><a title="Amnesty International Deutschland" href="https://www.amnesty.de"><i class="fa fa-globe"></i></a></li>
                    <li><a title="Facebook" href="https://www.facebook.com/AmnestyDeutschland"><i class="fa fa-facebook"></i></a></li>
                    <li><a title="Twitter" href="https://twitter.com/amnesty_de"><i class="fa fa-twitter"></i></a></li>
                    <li><a title="Youtube" href="https://www.youtube.com/channel/UC5jDXV8yNFtmJZE_Yo4AFlw"><i class="fa fa-youtube"></i></a></li>
                </ul>
            </div>

            <div class="tommy">
                &copy; 2023 with <i class="fa fa-heart"></i>
                by <a target="_blank" href="http://www.thomaskuhnert.com">Thomas Kuhnert</a>

            </div>

        </div>
    </div>


</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- google analytics -->

</body>
</html>
