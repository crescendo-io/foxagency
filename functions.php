<?php

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );
function wpm_enqueue_styles(){
    //wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/styles/theme.css' );
    wp_enqueue_style('theme', get_stylesheet_directory_uri() . '/styles/theme.css', array(), filemtime(get_template_directory() . '/styles/theme.css'));
}


