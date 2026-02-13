<?php
/**
 * Plugin Name: Fire Incident Log - Pavel Mančík
 * Description: Evidence hasičských výjezdů.
 * Version: 1.0.0
 * Author: Pavel Mančík
 */

if ( ! defined( 'ABSPATH' ) ) exit;


define( 'FIL_PATH', plugin_dir_path( __FILE__ ) );
define( 'FIL_URL', plugin_dir_url( __FILE__ ) );


require_once FIL_PATH . 'admin/class-cpt.php';
require_once FIL_PATH . 'admin/class-meta-boxes.php';
require_once FIL_PATH . 'admin/class-admin-list.php'; 
require_once FIL_PATH . 'public/class-shortcode.php';


function fil_init() {
    new \FireIncidentLog\Admin\CPT();
    new \FireIncidentLog\Admin\MetaBoxes();
    new \FireIncidentLog\Admin\AdminList();
    new \FireIncidentLog\PublicSide\Shortcode(); 
}
add_action( 'plugins_loaded', 'fil_init' );