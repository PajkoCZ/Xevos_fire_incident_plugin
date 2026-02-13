<?php
namespace FireIncidentLog\Admin;

class CPT {
    public function __construct() {
        add_action( 'init', [ $this, 'register' ] );
    }

    public function register() {
        register_post_type( 'incident', [
            'labels' => [
                'name' => 'Zásahy',
                'singular_name' => 'Zásah',
                'add_new' => 'Nový zásah',
                'add_new_item' => 'Přidat nový zásah (Detaily)',
            ],
            'public' => true,
            'menu_icon' => 'dashicons-shield',
            'supports' => [ 'title' ], 
            'rewrite' => [ 'slug' => 'zasahy' ],
        ]);

        register_taxonomy( 'incident_type', 'incident', [
            'labels' => [ 'name' => 'Typ události' ],
            'hierarchical' => true,
            'show_admin_column' => true,
        ]);
    }
}