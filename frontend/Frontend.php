<?php

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

        // Add style Action
        add_action("wp_enqueue_scripts", [$this, 'awp_slider_load_css_and_js']);

        // Add Slider Custom post action
        add_action('init', [$this, 'awp_slider_custom_post_type']);

        // Add Slider ShortCode action
        add_action('init', [$this, 'awp_slider_shortcode']);

        // Add Jquery Action
        add_action('wp_footer', [$this, 'awp_slider_script_jquery'], 100);
    }


    // Including css
    function awp_slider_load_css_and_js()
    {
        // Add Slider Css
        wp_enqueue_style('awp-slider-style', (AWP_SLIDER_PLUGIN_URL . 'assets/css/awp-slider.css'));
        // Add Slider jquery
        wp_enqueue_script('jquery');
        // Add Slider jquery min
        wp_enqueue_script('awp-min-slider-script', (AWP_SLIDER_PLUGIN_URL . 'assets/js/awp-slider-min.js'), array('jquery'), '1.0.0', true);
        // Add Slider custom js
        wp_enqueue_script('awp-slider-script', (AWP_SLIDER_PLUGIN_URL . 'assets/js/awp-slider.js'), array('jquery'), '1.0.0', true);
    }





    /**
     * Register Custom Post Type
     */

    function awp_slider_custom_post_type()
    {

        $labels = array(
            'name'                  => _x('AWP Sliders', 'Post Type General Name', 'awpslider'),
            'singular_name'         => _x('AWP Slider', 'Post Type Singular Name', 'awpslider'),
            'menu_name'             => __('AWP Sliders', 'awpslider'),
            'name_admin_bar'        => __('AWP Slider', 'awpslider'),
            'archives'              => __('Item Archives', 'awpslider'),
            'attributes'            => __('Item Attributes', 'awpslider'),
            'parent_item_colon'     => __('Parent Item:', 'awpslider'),
            'all_items'             => __('All Items', 'awpslider'),
            'add_new_item'          => __('Add New Item', 'awpslider'),
            'add_new'               => __('Add New', 'awpslider'),
            'new_item'              => __('New Item', 'awpslider'),
            'edit_item'             => __('Edit Item', 'awpslider'),
            'update_item'           => __('Update Item', 'awpslider'),
            'view_item'             => __('View Item', 'awpslider'),
            'view_items'            => __('View Items', 'awpslider'),
            'search_items'          => __('Search Item', 'awpslider'),
            'not_found'             => __('Not found', 'awpslider'),
            'not_found_in_trash'    => __('Not found in Trash', 'awpslider'),
            'featured_image'        => __('Featured Image', 'awpslider'),
            'set_featured_image'    => __('Set featured image', 'awpslider'),
            'remove_featured_image' => __('Remove featured image', 'awpslider'),
            'use_featured_image'    => __('Use as featured image', 'awpslider'),
            'insert_into_item'      => __('Insert into item', 'awpslider'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'awpslider'),
            'items_list'            => __('Items list', 'awpslider'),
            'items_list_navigation' => __('Items list navigation', 'awpslider'),
            'filter_items_list'     => __('Filter items list', 'awpslider'),
        );
        $args = array(
            'label'                 => __('AWP Slider', 'awpslider'),
            'description'           => __('AWP Slider Description', 'awpslider'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
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
        <div id="jssor_1">
            <div class="slider" data-u="slides">
                <?php
                // WP_Query arguments
                $args = array(
                    'post_type'              => array('awp-slider'),
                    'order' =>'asc'
                );

                // The Query
                $awp_slider_query = new WP_Query($args);

                // The Loop slider item

                if ($awp_slider_query->have_posts()) {
                    while ($awp_slider_query->have_posts()) {
                        $awp_slider_query->the_post();
                        // do something
                ?>

                        <!-----------Slider item--------------->
                        <div class="slider-item">
                            <div class="slider-overlay">
                                <img data-u="image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>" />
                                <div class="slider-content">
                                    <h2><?php the_title(); ?></h2>
                                    <p><?php echo wp_trim_words(get_the_content(), 40, ''); ?></p>
                                    <div class="btn"><a href="<?php echo get_post_meta(get_the_ID(), 'slider_button_link', true); ?>">
                                            <?php echo get_post_meta(get_the_ID(), 'slider_button_text', true); ?></a></div>
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


            <!-- Bullet Navigator -->
            <div data-u="navigator" class="jssorb053" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i">
                    <svg viewBox="0 0 16000 16000">
                        <path class="b" d="M11400,13800H4600c-1320,0-2400-1080-2400-2400V4600c0-1320,1080-2400,2400-2400h6800 
                    c1320,0,2400,1080,2400,2400v6800C13800,12720,12720,13800,11400,13800z"></path>
                    </svg>
                </div>
            </div>
            <!-- Arrow Navigator -->
            <div data-u="arrowleft" id="arrow-left" class="jssora093" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewBox="0 0 16000 16000">
                    <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                    <polyline class="a" points="7777.8,6080 5857.8,8000 7777.8,9920 "></polyline>
                    <line class="a" x1="10142.2" y1="8000" x2="5857.8" y2="8000"></line>
                </svg>
            </div>
            <div data-u="arrowright" id="arrow-right" class="jssora093" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewBox="0 0 16000 16000">
                    <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                    <polyline class="a" points="8222.2,6080 10142.2,8000 8222.2,9920 "></polyline>
                    <line class="a" x1="5857.8" y1="8000" x2="10142.2" y2="8000"></line>
                </svg>
            </div>
        </div>
    <?php

        return ob_get_clean();
    }

    /*
     * Add plugin script jquery
     */

    function awp_slider_script_jquery()
    { ?>
        <script type="text/javascript">
            jssor_1_slider_init();
        </script><?php
                }


                /**
                 * Wp Slider shortcode.
                 *
                 * @return void
                 */
                function awp_slider_shortcode()
                {
                    add_shortcode('AWP-SLIDER', [$this, 'awp_slider_post_loop']);
                }
            }


            Awp_Slider_Frontend::get_instance()->init();
