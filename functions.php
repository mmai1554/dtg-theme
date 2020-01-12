<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'fl_head', 'FLChildTheme::stylesheet' );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// ------------
/**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
function themeblvd_disable_admin_bar() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}

add_action( 'after_setup_theme', 'themeblvd_disable_admin_bar' );

/**
 * Redirect back to homepage and not allow access to
 * WP admin for Subscribers.
 */
function themeblvd_redirect_admin() {
	if ( ! defined( 'DOING_AJAX' ) && ! current_user_can( 'edit_posts' ) ) {
		wp_redirect( site_url() );
		exit;
	}
}

add_action( 'admin_init', 'themeblvd_redirect_admin' );

add_shortcode( 'mm_backlink', function () {
	return '
		<div class="mm-post-backlink">
			<h4 class="uabb-cl-heading">
				<a href="javascript:javascript:history.go(-1)" target="" data-hover="Zurück zu den Beiträgen">Zurück zu den Beiträgen</a>
			</h4>
</div>';
} );

add_shortcode('mm_currency', function() {
	return '<div style="text-align: center;">
	<iframe style="border:0px solid #C0C0C0;width:100%;height:300px;" scrolling="no" marginwidth="0" marginheight="0"
	        frameborder="0" src="http://de.loobiz.com/EUR-vs-TND.htm"><a href="http://de.loobiz.com/EUR-vs-TND.htm">EUR
			TND</a>
		<div style="text-align: center;">
	</iframe>
	<br/><a href="http://de.loobiz.com/wahrungsrechner/">Währungsrechner</a><br/><a
		href="http://de.loobiz.com/wahrungsrechner/euro+tunesischer-dinar">EUR / TND</a></div>
</div>';
});

add_action( 'wp_enqueue_scripts', function () {
	$load_scripts = false;
	if ( is_singular() ) {
		$post = get_post();
		if ( $post->ID == 86 ) {
			$load_scripts = true;
		}
	}
	if ( ! $load_scripts ) {
		wp_dequeue_script( 'contact-form-7' );
		wp_dequeue_script( 'google-recaptcha' );
		wp_dequeue_style( 'contact-form-7' );
	}
}, 99 );