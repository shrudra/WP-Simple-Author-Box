<?php
/*
Plugin Name: WP Simple Author Box
Description: Adds a custom author box to your WordPress posts.
Author: Sakhawat Hossain Rudra 
Repo: https://github.com/shrudra/WP-Simple-Author-Box/
Licence: GPL-3.0 license
*/

// Enqueue styles for the author box
function custom_author_box_styles() {
    wp_enqueue_style('custom-author-box-style', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'custom_author_box_styles');

// Display the author box after post content
function display_custom_author_box($content) {
    if (is_single()) {
        $author_id = get_the_author_meta('ID');
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_description = get_the_author_meta('description', $author_id);
        $author_avatar = get_avatar_url($author_id);

        if ($author_avatar && $author_name) {
            $author_box = '<div class="author-box">';
            $author_box .= '<div class="author-avatar"><img src="' . esc_url($author_avatar) . '" alt="' . esc_attr($author_name) . '"></div>';
            $author_box .= '<div class="author-info"><h3><strong>' . esc_html($author_name) . '</strong></h3>';
            if ($author_description) {
                $author_box .= '<p>' . esc_html($author_description) . '</p>';
            }
            $author_box .= '</div></div>';

            // Append the author box after post content
            $content .= $author_box;
        }
    }

    return $content;
}
add_filter('the_content', 'display_custom_author_box');
