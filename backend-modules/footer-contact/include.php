<?php
add_filter('admin_init', 'footer_copy_setting');
function footer_copy_setting()
{
    register_setting('general', 'footer_copy', 'esc_attr');
    add_settings_field('footer_copy', '<label for="footer_copy">'.__('Footer Quick Contact Info' , 'footer_copy' ).'</label>' , 'footer_copy_editor', 'general');
}
function footer_copy_editor()
{
    $value = get_option( 'footer_copy', '' );
    wp_editor( htmlspecialchars_decode($value), 'footer_copy', $settings = array(
    ) );

}
///

 ?>
