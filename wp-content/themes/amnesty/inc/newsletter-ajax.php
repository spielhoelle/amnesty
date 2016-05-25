<?php
add_shortcode('newsletter-form', 'newsletter');

function newsletter() {
  $form = form();
  return $form;
}



function form() {
    // just need to change these 2 variables if using a different account or list id in mailchimp
  $u = '8ac0f4fea764ddd861b79c60b3228da8-us13';
  $list_id = '124865';

  $concat_1 = "http://floatapp.us1.list-manage.com/subscribe/post-json?u=" . $u . "&amp;id=" . $list_id;
  $concat_2 = "b_" . $u . "_" . $list_id;

  $html .= '<form action='. $concat_1 .' method="post" id="mc-embedded-subscribe-form-small" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';
  $html .= '  <input type="email" value="" name="EMAIL" class="email_input" id="mce-EMAIL" placeholder="Email address" required>';
  $html .= '  <span style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name='. $concat_2 .' tabindex="-1" value=""></span>';
  $html .= '  <span class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="submit_button"></span>';
  $html .= '</form>';
  return $html;
}
