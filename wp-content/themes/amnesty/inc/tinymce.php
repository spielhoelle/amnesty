<?php
function wpb_mce_buttons_2($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');



# Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {
    // Define the style_formats array
    $style_formats = array(
        // Each array child is a format with it's own settings
        array(
            'title' => 'Button (nur auf links anwendbar)',
            'selector' => 'a',
            'classes' => 'content-button'
        ),
        array(
            'title' => 'Super Headline',
            'selector' => 'h1',
            'classes' => 'entry-title content'
        )
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );




function remove_tinymce_at_line1($buttons)
{
    $remove = array('forecolor', 'underline', 'forecolor', 'charmap', 'indent', 'outdent'); //Add other button names to this array
    # Find the array key and then unset
    return array_diff($buttons,$remove);
}
add_filter('mce_buttons_2', 'remove_tinymce_at_line1');



function remove_tinymce_at_line2($buttons)
{
    # Remove the text color selector
    $remove = array('strikethrough'); //Add other button names to this array
    # Find the array key and then unset
    return array_diff($buttons,$remove);
}
add_filter('mce_buttons', 'remove_tinymce_at_line2');



# Remove media buttons
function emersonthis_remove_add_media(){
    # do this conditionally if you want to be more selective
    remove_action( 'media_buttons', 'media_buttons' );
}
add_action('admin_head', 'emersonthis_remove_add_media');




# Adds instruction text after the post title input
function emersonthis_edit_form_after_title() {
    $tip = '<code>Eingabetaste ↵: harter Zeilenumbruch. SHIFT + Eingabetaste ↵ : weicher Zeilenumbruch.</code>';
    echo '<p style="margin-bottom:0;">'.$tip.'</p>';
}
add_action('edit_form_after_title', 'emersonthis_edit_form_after_title');
