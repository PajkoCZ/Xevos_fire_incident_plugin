<?php
namespace FireIncidentLog\Admin;

class MetaBoxes {
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'add' ] );
        add_action( 'save_post', [ $this, 'save' ] );
    }

    public function add() {
        add_meta_box( 'fil_details', 'Detaily zásahu', [ $this, 'render' ], 'incident', 'normal', 'high' );
    }

    public function render( $post ) {
        $location = get_post_meta( $post->ID, '_fil_location', true );
        $date = get_post_meta( $post->ID, '_fil_date', true );
        wp_nonce_field( 'fil_save', 'fil_nonce' );
        ?>
        <style>
            .fil-row { margin-bottom: 15px; display: flex; flex-direction: column; }
            .fil-row label { font-weight: bold; margin-bottom: 5px; }
            .fil-row input { width: 100%; max-width: 400px; padding: 8px; }
        </style>
        <div class="fil-row">
            <label>Místo události:</label>
            <input type="text" name="fil_location" value="<?php echo esc_attr($location); ?>" placeholder="Např. Bohumín, Hlavní třída">
        </div>
        <div class="fil-row">
            <label>Datum a čas:</label>
            <input type="datetime-local" name="fil_date" value="<?php echo esc_attr($date); ?>">
        </div>
        <?php
    }

    public function save( $post_id ) {
        if ( ! isset( $_POST['fil_nonce'] ) || ! wp_verify_nonce( $_POST['fil_nonce'], 'fil_save' ) ) return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( isset( $_POST['fil_location'] ) ) update_post_meta( $post_id, '_fil_location', sanitize_text_field( $_POST['fil_location'] ) );
        if ( isset( $_POST['fil_date'] ) ) update_post_meta( $post_id, '_fil_date', sanitize_text_field( $_POST['fil_date'] ) );
    }
}