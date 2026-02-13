<?php
/** 
 * Plugin Name: Výjezdy hasičů
 * Descrtiption: Plugin pro zaznamování výjezdů hasičů
 * Version: 1.0
 * Autor: Pavel Mančík
*/

if (!defined('ABSPATH')) exit;

define( 'FIL_PATH', plugin_dir_patch(__FILE__) );
define( 'FIL_URL', plugin_dir_url(__FILE__) );

require_once FIL_PATH . 'admin/class-cpt.php';
require_once FIL_PATH . 'admin/class-meta-boxes.php';

function fil_init() {
    new \FireIncidentLog\Admin\CPT();
    new \FireIncidentLog\Admin\MetaBoxes();
}
add_action( 'plugins_loaded', 'fil_init' );

?>