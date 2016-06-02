<?php
add_shortcode('newsletter-form', 'form');

function form() {

$html = '
  <h2>Sei dabei!</h2>
  <p>Seit 50 Jahren leisten gewöhnliche Menschen Außergewöhnliches. <br/>Auch du kannst Großes bewegen. <br/>Mit deiner E-Mail</p>

  <form id="mc_embed_signup" class="sign-up">
  	<label for="mce-EMAIL" class="screen-reader-text">Email Adresse</label>
  	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="E-Mail">
  	<input type="hidden" value="Yes" name="5PURRRFECT">
  	<p>
      <input type="submit" value="Trag mich ein!">
      <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
    </p>
  </form>';

  return $html;
}
