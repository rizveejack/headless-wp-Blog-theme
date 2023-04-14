<?php 
 require_once "inc/tmg/tmg-active.php";
 require_once "inc/block_perser.php";
 require_once "inc/related_post_wpQuery.php";
 require_once "inc/extend_query_limit.php";

 if ( ! function_exists( 'headless_blog_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various
	 * WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme
	 * hook, which runs before the init hook. The init hook is too late
	 * for some features, such as indicating support post thumbnails.
	 */
	function headless_blog_theme_setup() {

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support( 'post-thumbnails' );

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


add_action( 'admin_init', 'ads_register_setting' );

add_action( 'admin_init', 'ads_register_setting' );

/**
 * Tell WP we use a setting - and where.
 */
function ads_register_setting()
{
    add_settings_section(
        'ads_id',
        'Headless Website Settings',
        'ads_description',
        'general'
    );

    // Register a callback
    register_setting(
        'general',
        'feurl',
        'trim'
    );
    // Register the field for the "End" section.
    add_settings_field(
        'feurl',
        'Front-End URL',
        'ads_show_settings',
        'general',
        'ads_id',
        array ( 'label_for' => 'ads_id' )
    );
}

/**
 * Print the text before our field.
 */
function ads_description()
{
    
}

/**
 * Show our field.
 *
 * @param array $args
 */
function ads_show_settings( $args )
{
    $data = esc_attr( get_option( 'feurl', '' ) );

    printf(
        '<input type="url" name="feurl" value="%1$s" id="%2$s"  placeholder="http://localhost:3000/"/>',
        $data,
        $args['label_for']
    );
}



// Redirect website to frontend
function redirect_website(){
	
$frontend_url = !empty(get_option( 'feurl')) ? get_option( 'feurl') : "http://localhost:3000/";
    if ( $frontend_url ) {
        wp_redirect( $frontend_url );
        die();
    }
}


add_action( 'template_redirect','redirect_website');
