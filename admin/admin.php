<?php

/**
 * Class Awp_slider_Admin
 */
class Awp_slider_Admin
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

        // Add Slider Mata Action
        add_action('add_meta_boxes', [$this, 'awp_add_slider_meta']);

        // Add Button Text mata box Action
        add_action('save_post',  [$this, 'save_slider_button_text_meta_box_data']);
    }




    /**
     * Create New Meta Box.
     *
     * @return void
     */
    function awp_add_slider_meta()
    {

        // Slider button text meta box
        add_meta_box(
            'slider-button-text',
            __('Slider Button Text', 'sitepoint'),
            [$this, 'button_text_meta_box_callback'],
            'awp-slider'
        );

        // Slider button link meta box
        add_meta_box(
            'slider-button-link',
            __('Slider Button Link', 'sitepoint'),
            [$this, 'button_link_meta_box_callback'],
            'awp-slider'
        );
    }

    /**
     * Callback function for slider button text
     *
     * @param [type] $post
     * @return void
     */

    function button_text_meta_box_callback($post)
    {

        // Add a nonce field so we can check for it later.
        wp_nonce_field('slider_button_text_nonce', 'slider_button_text_nonce');

        $value = get_post_meta($post->ID, 'slider_button_text', true);

        echo '<textarea style="width:100%" id="slider_button_text" name="slider_button_text">' . esc_attr($value) . '</textarea>';
    }

    /**
     * Callback function for slider button link
     *
     * @param [type] $post
     * @return void
     */

    function button_link_meta_box_callback($post)
    {

        // Add a nonce field so we can check for it later.
        wp_nonce_field('slider_button_link_nonce', 'slider_button_link_nonce');

        $value = get_post_meta($post->ID, 'slider_button_link', true);

        echo '<textarea style="width:100%" id="slider_button_link" name="slider_button_link">' . esc_attr($value) . '</textarea>';
    }




    /**
     * When the post is saved, saves our custom data.
     *
     * @param int $post_id
     */

    function save_slider_button_text_meta_box_data($post_id)
    {
        //Slider button text
        $this->save_slider_button_text($post_id);
        //Slider button link
        $this->save_slider_button_link($post_id);
    }


    /**
     * Save slider button data.
     *
     * @param int $post_id
     * @return void
     */

    function save_slider_button_text($post_id)
    {
        // Check if our nonce is set.
        if (!isset($_POST['slider_button_text_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['slider_button_text_nonce'], 'slider_button_text_nonce')) {
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
        if (!isset($_POST['slider_button_text'])) {
            return;
        }

        // Sanitize user input.
        $my_data = sanitize_text_field($_POST['slider_button_text']);

        // Update the meta field in the database.
        update_post_meta($post_id, 'slider_button_text', $my_data);
    }


    /**
     * Save slider button Link data.
     *
     * @param int $post_id
     * @return void
     */

    function save_slider_button_link($post_id)
    {
        // Check if our nonce is set.
        if (!isset($_POST['slider_button_link_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['slider_button_link_nonce'], 'slider_button_link_nonce')) {
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
        if (!isset($_POST['slider_button_link'])) {
            return;
        }
        // Sanitize user input.
        $my_data = sanitize_text_field($_POST['slider_button_link']);

        // Update the meta field in the database.
        update_post_meta($post_id, 'slider_button_link', $my_data);
    }
}


Awp_slider_Admin::get_instance()->init();
