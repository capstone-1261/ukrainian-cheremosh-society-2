<?php
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/content-types.php';

function cheremosh_add_woocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'cheremosh_add_woocommerce_support');