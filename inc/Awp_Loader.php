<?php

class awp_Loader {
    // Autoload dependency.
    public function __construct(){
        $this->load_dependency();
    }

    /**
     * Load all Plugin FIle.
     */
    public function load_dependency(){
          include_once(AWP_PLUGIN_PATH . 'admin/Admin.php');
          include_once(AWP_PLUGIN_PATH . 'frontend/Frontend.php');
    }
}



/**
 * Initialize load class .
 */
function awp_slider(){
    if ( class_exists( 'awp_Loader' ) ) {
        new awp_Loader();
    }
}
