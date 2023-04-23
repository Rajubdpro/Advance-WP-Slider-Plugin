<?php
/*
 * Plugin Name:       Animation Slider
 * Plugin URI:        https://wordpress.org/plugins/search/animation-slider/
 * Description:       This is a best wordpress slider plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rajubdpro
 * Author URI:        https://codepopular.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       awp-slider
 * Domain Path:       /languages
 */


define('AWP_PLUGIN_VERSION', '1.0.0');
define('AWP_SLIDER_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
define('AWP_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));

/**----------------------------------------------------------------*/
/* Include all file
/*-----------------------------------------------------------------*/

/**
 * Include Awp Loader file
 */

include_once(dirname(__FILE__) . '/inc/Awp_Loader.php');

if (function_exists('awp_slider')) {
    awp_slider();
}
