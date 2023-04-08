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


class Awp_slider_main
{
    function __construct()
    {
        // Add style Action
        add_action("wp_enqueue_scripts", [$this, 'awp_slider_enqueue_style']);
        // Add script Action
        add_action("wp_enqueue_scripts", [$this, 'awp__enqueue_scripts']);
        add_action('init', [$this, 'awp_slider_custom_post_type']);


        add_action('add_meta_boxes', [$this, 'global_notice_meta_box']);



        add_action('save_post',  [$this, 'save_global_notice_meta_box_data']);
    }


    // Including css
    function awp_slider_enqueue_style()
    {
        wp_enqueue_style('awp-slider-style', plugins_url('css/awp-slider.css',  __FILE__));
    }

    // Including Javascript

    function awp__enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('awp-min-slider-script', plugins_url('js/awp-slider-min.js',  __FILE__), array(), '1.0.0', 'true');
        wp_enqueue_script('awp-slider-script', plugins_url('js/awp-slider.js',  __FILE__), array(), '1.0.0', 'true');
    }



    // Register Custom Post Type
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
     * Create New Meta Box.
     *
     * @return void
     */
    function global_notice_meta_box()
    {

        add_meta_box(
            'global-notice',
            __('Slider Button Text', 'sitepoint'),
            [$this, 'global_notice_meta_box_callback'],
            'awp-slider'
        );
    }


    function global_notice_meta_box_callback($post)
    {

        // Add a nonce field so we can check for it later.
        wp_nonce_field('global_notice_nonce', 'global_notice_nonce');

        $value = get_post_meta($post->ID, '_global_notice', true);

        echo '<textarea style="width:100%" id="global_notice" name="global_notice">' . esc_attr($value) . '</textarea>';
    }




    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id
     */
    function save_global_notice_meta_box_data($post_id)
    {

        // Check if our nonce is set.
        if (!isset($_POST['global_notice_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['global_notice_nonce'], 'global_notice_nonce')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {

            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Make sure that it is set.
        if (!isset($_POST['global_notice'])) {
            return;
        }

        // Sanitize user input.
        $my_data = sanitize_text_field($_POST['global_notice']);

        // Update the meta field in the database.
        update_post_meta($post_id, '_global_notice', $my_data);
    }




}





/*
* Show Slider Post
*/
function awp_slider_post_loop(){
    // WP_Query arguments
    $args = array(
        'post_type'              => array( 'awp-slider' ),
    );
    
    // The Query
    $awp_slider_query = new WP_Query( $args );
    
    // The Loop
    if ( $awp_slider_query->have_posts() ) {
        while ( $awp_slider_query->have_posts() ) {
            $awp_slider_query->the_post();
            // do something
            ?>
    
    <div id="jssor_1">
            <div class="slider" data-u="slides">
    
    
                    <div class="slider-item">
                        <div class="slider-overlay">
                            <img data-u="image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full');?>" />
                            <div class="slider-content">
                                <h2> Create this slider and
                                    Look like you website </h2>
                                 <p>Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua, magna aliqua. ipsum is simply dummy text of the printing.
                                 </p>
                                 <div class="btn"><a href="#">Learn More</a></div>
                            </div>
                        </div>
                    </div>
    
            </div>
    
    
    
    
    
    
    
    
         <!-- Bullet Navigator -->
         <div data-u="navigator" class="jssorb053" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i">
                <svg viewBox="0 0 16000 16000">
                    <path class="b" d="M11400,13800H4600c-1320,0-2400-1080-2400-2400V4600c0-1320,1080-2400,2400-2400h6800 c1320,0,2400,1080,2400,2400v6800C13800,12720,12720,13800,11400,13800z"></path>
                </svg>
            </div>
        </div>
            <!-- Arrow Navigator -->
            <div data-u="arrowleft" id="arrow-left" class="jssora093" data-autocenter="2"
                data-scale="0.75" data-scale-left="0.75">
                <svg viewBox="0 0 16000 16000">
                    <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                    <polyline class="a" points="7777.8,6080 5857.8,8000 7777.8,9920 "></polyline>
                    <line class="a" x1="10142.2" y1="8000" x2="5857.8" y2="8000"></line>
                </svg>
            </div>
            <div data-u="arrowright" id="arrow-right" class="jssora093"
                data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewBox="0 0 16000 16000">
                    <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                    <polyline class="a" points="8222.2,6080 10142.2,8000 8222.2,9920 "></polyline>
                    <line class="a" x1="5857.8" y1="8000" x2="10142.2" y2="8000"></line>
                </svg>
            </div>
        </div>
       
            <?php
        }
    } else {
        // no posts found
    }
    
    // Restore original Post Data
    wp_reset_postdata();
    }









// Class int
new Awp_slider_main;
