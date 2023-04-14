<?php
require_once 'class-tgm-plugin-activation.php';
/**
 * List of required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/
 * @author DAP
 * @since 1.0
 */
function wds_register_required_plugins() {

	$plugins = [

		// Plugins only available on Github.
		
		[
			'name'     => 'WPGraphQL Content Blocks',
			'slug'     => 'wp-graphql-content-blocks',
			'source'   => 'https://github.com/wpengine/wp-graphql-content-blocks/releases/latest/download/wp-graphql-content-blocks.zip',
			'required' => true,
		],
		

		// Plugins from the WordPress Plugin Repository.
		[
			'name'        => 'WPGraphQL',
			'slug'        => 'wp-graphql',
			'required'    => true,
		],
		
		[
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
			'required'    => true,
		],
		
		[
			'name'     => 'WPGraphQL Yoast SEO Addon',
			'slug'     => 'add-wpgraphql-seo',
			'required' => true,
		],
		
	];

	// Configuration settings.
	$config = [
		'id'           => 'wds',                   // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	];

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'wds_register_required_plugins' );