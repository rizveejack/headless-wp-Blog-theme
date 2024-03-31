<?php 
 require_once "inc/tmg/tmg-active.php";
 require_once "inc/block_settings.php";
 require_once "inc/extra-settings.php";
 
 if ( ! function_exists( 'headless_blog_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various
	 * WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme
	 * hook, which runs before the init hook. The init hook is too late
	 * for some features, such as indicating support post thumbnails.
	 */

	 function my_theme_enqueue_block_editor_assets() {
		wp_enqueue_script(
			'fun',
			get_template_directory_uri() . '/js/block.js', // Adjust the path to where your JS file is located
			array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
			filemtime( get_template_directory() . '/js/block.js' )
		);
	}
	add_action( 'enqueue_block_editor_assets', 'my_theme_enqueue_block_editor_assets' );
	// end filter sub block
	
	function headless_blog_theme_setup() {

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'caption', 'style', 'script' ) );
	

		/**
		 * Add support for two custom navigation menus.
		 */
		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'headless_blog' ),
			'secondary' => __( 'Footer Menu', 'headless_blog' ),
			'mobile' => __( 'Mobile Menu', 'headless_blog' ),
		) );

		/**
		 * Enable support for the following post formats:
		 * aside, gallery, quote, image, and video
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video' ) );
	}
endif; // myfirsttheme_setup
add_action( 'after_setup_theme', 'headless_blog_theme_setup' );

//change rest url
add_filter('rest_url', function($url) {
    $url = str_replace(home_url(), site_url(), $url);
    return $url;
});


//site redirect
add_action('template_redirect', 'redirect_to_home');
function redirect_to_home() {
		wp_redirect(home_url());
		exit;	
}






