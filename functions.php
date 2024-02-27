<?php

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );
function wpm_enqueue_styles(){
    //wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/styles/theme.css' );
    wp_enqueue_style('theme', get_stylesheet_directory_uri() . '/styles/theme.css', array(), filemtime(get_template_directory() . '/styles/theme.css'));
}


function wpm_custom_post_type() {

    // On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
    $labels = array(
        'name'                => _x( 'Demande de contact', ''),
    );

    // On peut définir ici d'autres options pour notre custom post type

    $args = array(
        'label'               => __( 'Contact'),
        'description'         => __( 'Contact'),
        'labels'              => $labels,

        'show_in_rest' => false,
        'hierarchical'        => false,
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => false
        //'rewrite'			  => array( 'slug' => 'contact'),

    );

    // On enregistre notre custom post type qu'on nomme ici "serietv" et ses arguments
    register_post_type( 'contact', $args );

}

add_action( 'init', 'wpm_custom_post_type', 0 );