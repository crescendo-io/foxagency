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
        'publicly_queryable'  => false,
        'with_front'          => false,
        'query_var'           => false,
        'exclude_from_search' => true,

        //'rewrite'			  => array( 'slug' => 'contact'),

    );

    // On enregistre notre custom post type qu'on nomme ici "serietv" et ses arguments
    register_post_type( 'contact', $args );

}

add_action( 'init', 'wpm_custom_post_type', 0 );


function getVisitorIp() {
    $ip = '';

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP passed from a proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP address from the remote address
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Handle multiple IP addresses (when using a proxy)
    $ip = explode(',', $ip)[0];

    return $ip;
}

function isIpFrench($ipAddress) {
    // URL de l'API ipinfo.io pour obtenir des informations sur l'adresse IP
    $url = "https://ipinfo.io/{$ipAddress}/json";

    // Utilisation de file_get_contents pour obtenir la réponse de l'API
    $response = file_get_contents($url);

    // Vérification si la réponse a été obtenue
    if ($response === FALSE) {
        throw new Exception("Unable to fetch IP information");
    }

    // Conversion de la réponse JSON en tableau PHP
    $data = json_decode($response, true);

    // Vérification du pays
    if (isset($data['country']) && $data['country'] === 'FR') {
        return true;
    } else {
        return false;
    }
}
