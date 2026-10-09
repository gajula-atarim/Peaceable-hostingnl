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

// Contact form (Contact page): posts to admin-post.php and mails the site owner.
add_action( 'admin_post_nopriv_vt_contact', 'vt_handle_contact' );
add_action( 'admin_post_vt_contact', 'vt_handle_contact' );
function vt_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );
	$back = remove_query_arg( 'vt_sent', $back );
	$done = function ( $ok ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'vt_sent', $ok ? '1' : '0', $back ) . '#contact-form' );
		exit;
	};
	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['vt_website'] ) ) {
		$done( true );
	}
	$name    = sanitize_text_field( wp_unslash( $_POST['vt_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['vt_email'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['vt_message'] ?? '' ) );
	if ( '' === $name || ! is_email( $email ) ) {
		$done( false );
	}
	$to   = apply_filters( 'vt_contact_recipient', 'info@vthullenaar.nl' );
	$body = "From: {$name} <{$email}>\n\n{$message}\n\n-- \nVerzonden via het contactformulier op " . home_url( '/' );
	$ok   = wp_mail( $to, 'Websiteaanvraag van ' . $name, $body, [ 'Reply-To: ' . $name . ' <' . $email . '>' ] );
	$done( $ok );
}

/**
 * Old English page URLs now 301-redirect to their Dutch slugs.
 */
add_action( 'template_redirect', function () {
	if ( ! is_404() ) {
		return;
	}
	$map  = [ 'services' => 'diensten', 'projects' => 'projecten', 'about-us' => 'over-ons', 'terms' => 'algemene-voorwaarden' ];
	$path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( '/' . $map[ $path ] . '/' ), 301 );
		exit;
	}
} );
