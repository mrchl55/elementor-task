<?php
/* enqueue scripts and style from parent theme */

function twentytwentythree_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array('twenty-twenty-three-style'), wp_get_theme()->
        get('Version'));
}

add_action('wp_enqueue_scripts', 'twentytwentythree_styles');