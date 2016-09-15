<?php
add_filter('admin_init', 'footer_clocks');
function footer_clocks()
{
    register_setting('general', 'footer_clocks', 'esc_attr');
    add_settings_field('footer_clocks', '<label for="footer_clocks">'.__('Footer Clocks' , 'footer_clocks' ).'</label>' , 'footer_clock_list', 'general');
}
function footer_clock_list()
{
    $value = '[]';
    ?>
    <div id="footer-clock-container">
    <ul id="footer-clock-list">


    </ul>
    <button class="button-primary add">Add +</button>
    </div>
    <input id="footer_clocks" type="hidden" value='<?php echo $value;?>' />
    <script>
    var clockinitial = <?php echo $value;?>;
    </script>
    <script src="<?php echo get_bloginfo('template_url');?>/backend-modules/footer-clocks/clock-maker.js"></script>
    <?php

}


 ?>
