<?php
namespace FireIncidentLog\PublicSide;

class Shortcode {
    public function __construct() {
        add_shortcode( 'seznam_zasahu', [ $this, 'render' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_css' ] );
    }

    public function enqueue_css() {
        wp_enqueue_style( 'fil-public-style', FIL_URL . 'public/style.css' );
    }

    public function render( $atts ) {
        $query = new \WP_Query([
            'post_type' => 'incident',
            'posts_per_page' => 9,
        ]);

        if ( ! $query->have_posts() ) return 'Žádné zásahy.';

        ob_start();
        ?>
        <div class="fil-grid">
            <?php while ( $query->have_posts() ) : $query->the_post(); 
                $date = get_post_meta( get_the_ID(), '_fil_date', true );
                $location = get_post_meta( get_the_ID(), '_fil_location', true );
                $terms = get_the_terms( get_the_ID(), 'incident_type' );
                $type = $terms ? $terms[0]->name : 'Zásah';
                $type_slug = $terms ? $terms[0]->slug : 'default';
            ?>
            <div class="fil-card type-<?php echo esc_attr($type_slug); ?>">
                <div class="fil-header">
                    <span class="fil-tag"><?php echo esc_html($type); ?></span>
                    <span class="fil-date"><?php echo $date ? date_i18n('d.m.', strtotime($date)) : ''; ?></span>
                </div>
                <h3 class="fil-title"><?php the_title(); ?></h3>
                <div class="fil-footer">
                    📍 <?php echo esc_html($location); ?>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php
        return ob_get_clean();
    }
}