<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class AwpSlider_Loader
{
    // Autoload dependency.
    public function __construct() {
        $this->load_dependency();
    }

    /**
     * Load all Plugin FIle.
     */
    public function load_dependency() {
        include_once(AWPSLIDER_PLUGIN_PATH . 'admin/Admin.php');
        include_once(AWPSLIDER_PLUGIN_PATH . 'frontend/Frontend.php');
    }
}


/**
 * Initialize load class .
 */
function awpslider_loader() {
    if ( class_exists('AwpSlider_Loader') ) {
        new AwpSlider_Loader();
    }
}
