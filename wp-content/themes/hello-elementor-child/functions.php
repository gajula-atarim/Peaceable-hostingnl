<?php
/**
 * Hello Elementor Child – vtHullenaar
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'hello-elementor-child', get_stylesheet_uri(), [ 'hello-elementor' ], $ver );
	$css = get_stylesheet_directory() . '/assets/vt.css';
	if ( file_exists( $css ) ) {
		wp_enqueue_style( 'vt-design', get_stylesheet_directory_uri() . '/assets/vt.css', [ 'hello-elementor-child' ], filemtime( $css ) );
	}
	$js = get_stylesheet_directory() . '/assets/vt.js';
	if ( file_exists( $js ) ) {
		wp_enqueue_script( 'vt-design', get_stylesheet_directory_uri() . '/assets/vt.js', [], filemtime( $js ), true );
	}
}, 20 );

// Load the design CSS inside the Elementor editor preview too.
add_action( 'elementor/preview/enqueue_styles', function () {
	$css = get_stylesheet_directory() . '/assets/vt.css';
	if ( file_exists( $css ) ) {
		wp_enqueue_style( 'vt-design-preview', get_stylesheet_directory_uri() . '/assets/vt.css', [], filemtime( $css ) );
	}
} );

add_action( 'after_setup_theme', function () {
	register_nav_menus( [
		'vt-primary' => __( 'Primary (header)', 'hello-elementor-child' ),
		'vt-footer'  => __( 'Footer pages', 'hello-elementor-child' ),
	] );
} );
