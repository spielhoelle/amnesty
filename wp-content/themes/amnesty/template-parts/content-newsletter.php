<?php
/**
 *	The template for dispalying the content.
 *
 *	@package WordPress
 *	@subpackage clubstiftung
 */
 ?>
 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     <?php if(get_the_title() !== '') { ?>
       <figure class="<?php echo implode(' ', $classes) ?>">
           <img src="/wp-includes/images/blank.gif" style="background-image:url(<?php echo $img ?>)">
           <figcaption>
               <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

           </figcaption>
       </figure>
     <?php } ?>
     <div class="wrap">
         <div class="content-wrapper">
             <?php
             the_content();

             wp_link_pages(array(
                 'before' => '<div class="page-links">' . esc_html__('Pages:', 'amnesty'),
                 'after'  => '</div>',
             ));
             ?>
         </div><!-- .content-wrapper -->
     </div>

 </article><!--content-page.php-->
