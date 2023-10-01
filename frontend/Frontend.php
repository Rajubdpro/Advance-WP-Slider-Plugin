<?php
if (!defined('ABSPATH')) exit;

/**
 * Class Wp_Simple_Frontend
 */
class Awp_Slider_Frontend
{

    private static $instance = null;

    /**
     * Make instance of the admin class.
     */
    public static function get_instance()
    {
        if (!self::$instance)
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * Initialize global hooks.
     */
    public function init()
    {
        // Color Customize action
        add_action('wp_head', [$this, 'awp_theme_color_cus']);

        // Color Customize action
        add_action('customize_register', [$this, 'awp_slider_theme_color_cus']);

        // Add style Action
        add_action("wp_enqueue_scripts", [$this, 'awp_slider_load_css_and_js']);

        // Add Slider Custom post action
        add_action('init', [$this, 'awp_slider_custom_post_type']);

        // Add Slider ShortCode action
        add_action('init', [$this, 'awp_slider_shortcode']);

    }


    // Including css
    function awp_slider_load_css_and_js()
    {
        // Add Slider Css
        wp_enqueue_style('awp-slider-style', (AWPSLIDER_PLUGIN_URL . 'assets/css/awp-slider.css'), array(), AWPSLIDER_PLUGIN_VERSION);
        // Add Slider Css
        wp_enqueue_style('awp-slider-animate', (AWPSLIDER_PLUGIN_URL . 'assets/css/awp-slider-animate.min.css'), array(), AWPSLIDER_PLUGIN_VERSION);
        // Add Slider Css
        wp_enqueue_style('awp-slider-bootstrap', (AWPSLIDER_PLUGIN_URL . 'assets/css/awp-slider-bootstrap.min.css'), array(), AWPSLIDER_PLUGIN_VERSION);
        // Add Slider Css
        wp_enqueue_style('awp-slider-fontawesome', (AWPSLIDER_PLUGIN_URL . 'assets/css/awp-slider-fontawesome.min.css'), array(), AWPSLIDER_PLUGIN_VERSION);

        wp_enqueue_style('awp-slider-carousel', (AWPSLIDER_PLUGIN_URL . 'assets/css/awp-slider-owl.carousel.min.css'), array(), AWPSLIDER_PLUGIN_VERSION);


        // Add Slider jquery
        wp_enqueue_script('jquery');
        // Add Slider jquery min
        wp_enqueue_script('awp-min-slider-script', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.min.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        wp_enqueue_script('awp-slider-appear', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.jquery.appear.min.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        wp_enqueue_script('awp-slider-hero', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.jquery.hero.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        wp_enqueue_script('awp-slider-mixitup', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.jquery.mixitup.min.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        wp_enqueue_script('awp-slider-carouse-js', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider-carousel.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        wp_enqueue_script('awp-slider-wow', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.wow.min.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
        // Add Slider custom js
        wp_enqueue_script('awp-slider-script', (AWPSLIDER_PLUGIN_URL . 'assets/js/awp-slider.js'), array('jquery'), AWPSLIDER_PLUGIN_VERSION, true);
    }


    /**
     * Register Custom Post Type
     */

    function awp_slider_custom_post_type()
    {

        $labels = array(
            'name' => _x('AWP Sliders', 'Post Type General Name', 'advance-wp-slider'),
            'singular_name' => _x('AWP Slider', 'Post Type Singular Name', 'advance-wp-slider'),
            'menu_name' => __('AWP Sliders', 'advance-wp-slider'),
            'name_admin_bar' => __('AWP Slider', 'advance-wp-slider'),
            'archives' => __('Item Archives', 'advance-wp-slider'),
            'attributes' => __('Item Attributes', 'advance-wp-slider'),
            'parent_item_colon' => __('Parent Item:', 'advance-wp-slider'),
            'all_items' => __('All Items', 'advance-wp-slider'),
            'add_new_item' => __('Add New Item', 'advance-wp-slider'),
            'add_new' => __('Add New', 'advance-wp-slider'),
            'new_item' => __('New Item', 'advance-wp-slider'),
            'edit_item' => __('Edit Item', 'advance-wp-slider'),
            'update_item' => __('Update Item', 'advance-wp-slider'),
            'view_item' => __('View Item', 'advance-wp-slider'),
            'view_items' => __('View Items', 'advance-wp-slider'),
            'search_items' => __('Search Item', 'advance-wp-slider'),
            'not_found' => __('Not found', 'advance-wp-slider'),
            'not_found_in_trash' => __('Not found in Trash', 'advance-wp-slider'),
            'featured_image' => __('Featured Image', 'advance-wp-slider'),
            'set_featured_image' => __('Set featured image', 'advance-wp-slider'),
            'remove_featured_image' => __('Remove featured image', 'advance-wp-slider'),
            'use_featured_image' => __('Use as featured image', 'advance-wp-slider'),
            'insert_into_item' => __('Insert into item', 'advance-wp-slider'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'advance-wp-slider'),
            'items_list' => __('Items list', 'advance-wp-slider', 'Setting'),
            'items_list_navigation' => __('Items list navigation', 'advance-wp-slider'),
            'filter_items_list' => __('Filter items list', 'advance-wp-slider'),
        );
        $args = array(
            'label' => __('AWP Slider', 'advance-wp-slider'),
            'description' => __('AWP Slider Description', 'advance-wp-slider'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );
        register_post_type('awp-slider', $args);
    }


    /**
     * Show Slider Post Data
     */

    function awp_slider_post_loop()
    {

        ob_start();
        ?>
        <section id="awp-slider">
            <div class="hero-full owl-carousel owl-theme mt-5 " data-items="2">
                <?php
                // WP_Query arguments
                $args = array(
                    'post_type' => array('awp-slider'),
                    'order' => 'asc',
                );

                // The Query
                $awp_slider_query = new WP_Query($args);

                // The Loop slider item

                if ($awp_slider_query->have_posts()) {
                    while ($awp_slider_query->have_posts()) {
                        $awp_slider_query->the_post();
                        // do something
                        ?>

                        <!----------- Single ----------->
                        <div class="awp-slider-item"
                             style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                             alt="<?php the_title(); ?>); width: 100%;">
                            <div class="awp-slider">
                                <div class="awp-slider-caption">
                                    <h2><?php the_title(); ?></h2>
                                    <p><?php echo wp_trim_words(get_the_content(), 40, ''); ?></p>
                                    <div class="awp-slider-btn">
                                        <button class="default-btn-one btn slider-button">
                                            <a href="<?php echo get_post_meta(get_the_ID(), 'slider_button_link', true); ?>"> <span
                                                        class="circle" aria-hidden="true">
                                    <span class="icon arrow"></span>
                                 </span>
                                                <span class="button-text">  <?php echo get_post_meta(get_the_ID(), 'slider_button_text', true); ?></span></a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    // no posts found
                }

                // Restore original Post Data
                wp_reset_postdata();
                ?>
            </div>
        </section>
        <?php

        return ob_get_clean();
    }

    /*
     * Add plugin script jquery
     */


    /**
     * Wp Slider shortcode.
     *
     * @return void
     */
    function awp_slider_shortcode()
    {
        add_shortcode('AWP-SLIDER', [$this, 'awp_slider_post_loop']);
    }


    // Add section
    function awp_slider_theme_color_cus($wp_customize)
    {
        $wp_customize->add_section('awp_slider_theme_color_cus', array(
            'title' => __('Awp Slider Customize', 'advance-wp-slider'),

        ));

        //Add navigator color setting
        $wp_customize->add_setting('awp_slider_default_color', array(
            'default' => '#CF4628',
        ));
        //Add navigator color control
        $wp_customize->add_control('awp_slider_default_color', array(
            'label' => __('Bullet & Navigator Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add navigator hover color setting
        $wp_customize->add_setting('awp_slider_navigator_hover_color', array(
            'default' => '#ffffff',
        ));
        //Add navigator color control
        $wp_customize->add_control('awp_slider_navigator_hover_color', array(
            'label' => __('Bullet & Navigator Hover Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));


        /**
         * Header customize
         */

        //Add Header color setting
        $wp_customize->add_setting('awp_slider_header_default_color', array(
            'default' => '#ffffff',
        ));
        //Add Header color control
        $wp_customize->add_control('awp_slider_header_default_color', array(
            'label' => __('Header Text Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add Header text setting
        $wp_customize->add_setting('awp_slider_header_default_size', array(
            'default' => '35px',
        ));
        //Add Header text control
        $wp_customize->add_control('awp_slider_header_default_size', array(
            'label' => __('Header Text Size', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'size',
        ));

        /**
         * Title Customize
         */

        //Add title color setting
        $wp_customize->add_setting('awp_slider_default_title_color', array(
            'default' => '#ffffff',
        ));
        //Add title color control
        $wp_customize->add_control('awp_slider_default_title_color', array(
            'label' => __('Title Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add title size setting
        $wp_customize->add_setting('awp_slider_default_title_size', array(
            'default' => '20px',
        ));
        //Add title size control
        $wp_customize->add_control('awp_slider_default_title_size', array(
            'label' => __('Title Size', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'size',
        ));

        /**
         * Button Customize
         */

        //Add Button size setting
        $wp_customize->add_setting('awp_slider_default_button_width', array(
            'default' => '220px',
        ));
        //Add Button size setting
        $wp_customize->add_control('awp_slider_default_button_width', array(
            'label' => __('Button Width', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'size',
        ));
        //Add Button text color setting
        $wp_customize->add_setting('awp_slider_default_button_text_color', array(
            'default' => '#ffffff',
        ));
        //Add Button text color setting
        $wp_customize->add_control('awp_slider_default_button_text_color', array(
            'label' => __('Button Text Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add Button text hover color setting
        $wp_customize->add_setting('awp_slider_default_button_text_hover_color', array(
            'default' => '#fffff',
        ));

        //Add Button text hover color setting
        $wp_customize->add_control('awp_slider_default_button_text_hover_color', array(
            'label' => __('Button Text hover Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add Button color setting
        $wp_customize->add_setting('awp_slider_default_button_color', array(
            'default' => '#ffffff',
        ));
        //Add Button color setting
        $wp_customize->add_control('awp_slider_default_button_color', array(
            'label' => __('Button Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));

        //Add Button hover color setting
        $wp_customize->add_setting('awp_slider_default_button_icon_color', array(
            'default' => '#333333',
        ));
        //Add Button hover color setting
        $wp_customize->add_control('awp_slider_default_button_icon_color', array(
            'label' => __('Button hover Color', 'advance-wp-slider'),
            'section' => 'awp_slider_theme_color_cus',
            'type' => 'color',
        ));
    }


    // Theme color customize
    function awp_theme_color_cus()
    {
        ?>

        <style>
            :root {
                --slider-navigator-color: <?php echo esc_attr(get_theme_mod('awp_slider_default_color', '#c61343')); ?>;
                --slider-navigator-hover-color: <?php echo esc_attr(get_theme_mod('awp_slider_navigator_hover_color', '#8224e3')); ?>;
                --slider-heading-color: <?php echo esc_attr( get_theme_mod('awp_slider_header_default_color', '#ffffff')); ?>;
                --slider-title-color: <?php echo esc_attr( get_theme_mod('awp_slider_default_title_color', '#ffffff'))?>;
                --slider-button-text-color: <?php echo esc_attr( get_theme_mod('awp_slider_default_button_text_color', '#ffffff')); ?>;
                --slider-button-text-hover-color: <?php echo esc_attr( get_theme_mod('awp_slider_default_button_text_hover_color', '#333333')); ?>;
                --slider-button-color: <?php echo esc_attr( get_theme_mod('awp_slider_default_button_color', '#ffffff')); ?>;
                --slider-button-icon-color: <?php echo esc_attr( get_theme_mod('awp_slider_default_button_icon_color', '#333333')); ?>;
                --slider-heading-size: <?php echo esc_attr( get_theme_mod('awp_slider_header_default_size', '35px')); ?>;
                --slider-title-size: <?php echo esc_attr( get_theme_mod('awp_slider_default_title_size', '20px')); ?>;
                --slider-button-width: <?php echo esc_attr( get_theme_mod('awp_slider_default_button_width', '220px')); ?>;
            }
        </style>

        <?php
    }
}

Awp_Slider_Frontend::get_instance()->init();