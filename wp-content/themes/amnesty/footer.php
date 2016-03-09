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
                    <p>Privacy Policy | Cookie Statement | Permissions © 2016 AMNESTY INTERNATIONAL</p>
                </div>
                <ul>
                    <li><a href="http://facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="http://linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="http://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="http://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>

            <div class="tommy">
                &copy; 2016 with <i class="fa fa-heart"></i>
                by <a target="_blank" href="http://www.thomaskuhnert.com">Thomas Kuhnert</a>

            </div>

        </div>
    </div>

    <div id="nlpopup">
        <div class="badge">

            <?php echo do_shortcode('[contact-form-7 id="2202" title="Newsletter Formular"]') ?>

            <span class="close closex fa fa-times fa-2"></span>
        </div>
    </div>

</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
