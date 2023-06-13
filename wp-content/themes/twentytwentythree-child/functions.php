<?php
include __DIR__ . '/product/Product.php';

/* enqueue scripts and style from parent theme */

function twentytwentythree_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array('twenty-twenty-three-style'), wp_get_theme()->
        get('Version'));
    wp_register_script('api-test', get_stylesheet_directory_uri()
        . '/product/js/api-test.js', array('jquery'), '2.0.0', true);
    wp_enqueue_script('api-test');
}

add_action('wp_enqueue_scripts', 'twentytwentythree_styles');

function remove_admin_bar_for_wp_test()
{
    $current_user = wp_get_current_user();
    if ($current_user->user_login === 'wp-test') {
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'remove_admin_bar_for_wp_test');

add_action('wp_head', function () {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

});

function address_mobile_address_bar()
{
    $color = "#444444";
    echo '<meta name="theme-color" content="' . $color . '">';
    echo '<meta name="msapplication-navbutton-color" content="' . $color . '">';
    echo '<meta name="apple-mobile-web-app-capable" content="yes">';
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
}

add_action('wp_head', 'address_mobile_address_bar');