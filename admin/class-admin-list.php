<?php
namespace FireIncidentLog\Admin;

class AdminList {
    public function __construct() {
        add_filter( 'manage_incident_posts_columns', [ $this, 'set_columns' ] );
        add_action( 'manage_incident_posts_custom_column', [ $this, 'fill_columns' ], 10, 2 );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_css' ] );
    }

    public function set_columns( $columns ) {
        $new_columns = [
            'cb' => $columns['cb'],
            'title' => 'Název zásahu',
            'incident_status' => 'Typ události',
            'incident_location' => 'Místo',
            'incident_date' => 'Datum',
            'date' => 'Vytvořeno',
        ];
        return $new_columns;
    }

    public function fill_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'incident_location':
                echo esc_html( get_post_meta( $post_id, '_fil_location', true ) );
                break;

            case 'incident_date':
                $date = get_post_meta( $post_id, '_fil_date', true );
                echo $date ? date_i18n( 'd.m.Y H:i', strtotime( $date ) ) : '—';
                break;

            case 'incident_status':
                $terms = get_the_terms( $post_id, 'incident_type' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        echo '<span class="fil-badge fil-badge-' . esc_attr($term->slug) . '">' . esc_html( $term->name ) . '</span>';
                    }
                } else {
                    echo '<span class="fil-badge">Neurčeno</span>';
                }
                break;
        }
    }

    public function enqueue_admin_css() {
        wp_enqueue_style( 'fil-admin-style', FIL_URL . 'admin/admin-style.css' );
    }
}