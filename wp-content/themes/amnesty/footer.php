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
            <div>
                <p>&copy; 2015 with <i class="fa fa-heart"></i> by
                    <a target="_blank" href="http://www.thomaskuhnert.com">Thomas Kuhnert</a>
                </p>
            </div>
            <div>
                <p>Privacy Policy   |   Cookie Statement   |   Permissions
                © 2016 AMNESTY INTERNATIONAL</p>
                <span class="social-icons">
                    <a href="https://www.facebook.com/amnestyglobal" class="social-list__link--facebook" data-ga="event,Outgoing links,Click,external">Like us on Facebook</a>
                </span>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
