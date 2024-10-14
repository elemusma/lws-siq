<?php
/**
 * Plugin Name:       Content Testimonials
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       content-testimonials
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_content_testimonials_block_init() {
	// wp_enqueue_style('owl-carousel', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl-carousel.css');
	// wp_enqueue_style('owl-carousel-min', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl.carousel.min.css');
	// wp_enqueue_style('owl-carousel-theme-default-min', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl.theme.default.min.css');
	if ( ! wp_style_is( 'custom-owl.carousel.min', 'enqueued' ) ) {
		wp_enqueue_style('custom-owl.carousel.min', get_theme_file_uri('/owl-carousel/owl.carousel.min.css'));
	}
	if ( ! wp_style_is( 'custom-owl.theme.default', 'enqueued' ) ) {
		wp_enqueue_style('custom-owl.theme.default', get_theme_file_uri('/owl-carousel/owl.theme.default.min.css'));
	}
	register_block_type( __DIR__ . '/build' );
	if ( ! wp_script_is( 'owl-carousel-jquery-min-custom', 'enqueued' ) ) {
		wp_enqueue_script('owl-carousel-jquery-min-custom', get_theme_file_uri('/owl-carousel/jquery.min.js'));
	}
	if ( ! wp_script_is( 'owl-carousel-min-js', 'enqueued' ) ) {
		wp_enqueue_script('owl-carousel-min-js', get_theme_file_uri('/owl-carousel/owl.carousel.min.js'));
	}
	if ( ! wp_script_is( 'owl-carousel-custom', 'enqueued' ) ) {
		wp_enqueue_script('owl-carousel-custom', get_theme_file_uri('/owl-carousel/owl-carousels.js'));
	}
	// wp_enqueue_script('owl-carousel-jquery-min', plugin_dir_url( __FILE__ ) . 'owl-carousel/jquery.min.js');
	// wp_enqueue_script('owl-carousel-min', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl.carousel.min.js');
	// wp_enqueue_script('owl-carousel', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl-carousels.js');
}
add_action( 'init', 'create_block_content_testimonials_block_init' );
