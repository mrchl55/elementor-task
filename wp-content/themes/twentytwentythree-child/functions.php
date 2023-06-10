<?php
/* enqueue scripts and style from parent theme */

function twentytwentythree_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array('twenty-twenty-three-style'), wp_get_theme()->
        get('Version'));
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