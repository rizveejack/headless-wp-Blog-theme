<?PHP


add_filter( 'block_categories_all', 'CTG_disable_block_categories', 10, 2 );

function CTG_disable_block_categories( $categories, $post ) {
    // Empty array to disable categories
    return array();
}

add_filter( 'allowed_block_types_all', 'CTG_allowed_block_types' );

function CTG_allowed_block_types() {
    // Define an array containing all the block types you want to allow
    $allowed_blocks = array(
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/quote',
        'core/embed',
        'core/image',
        'core/latest-posts',
        'rank-math/toc-block',
        'rank-math/faq-block',
        'rank-math/howto-block'
        // Add more block types if needed
    );

    // Return the array of allowed block types
    return $allowed_blocks;
}



// Filter Post type for user



function restrict_editor_access_to_headless_settings() {
    // Check if the current user is an editor
    if (current_user_can('editor')) {
        remove_menu_page( 'edit-comments.php' ); //Comments
        remove_menu_page( 'tools.php' ); //
        remove_menu_page('headless-settings');
        remove_menu_page('rank-math');
        remove_menu_page('upload.php');
        remove_menu_page('edit.php?post_type=page');
    }
}

add_action('admin_init', 'restrict_editor_access_to_headless_settings');





add_action('graphql_register_types', function() {

  // Check that Co-Authors Plus plugin exists
  if (!function_exists('get_multiple_authors')) {
    return;
  }

  // Register the GraphQL connection
  register_graphql_connection([
     'fromType' => 'Post',
     'toType' => 'User',
     'fromFieldName' => 'coAuthors',
     'connectionTypeName' => 'UserToPostConnection',
     'connectionArgs' => \WPGraphQL\Connection\PostObjects::get_connection_args(),
     'resolve' => function($post, $args, $context, $info) {
        
        // Get the co-author info from the plugin 
        $co_authors = get_multiple_authors($post->ID);  


        // Setup resolver 
        $resolver = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver(
          $post, $args, $context, $info
        );

        // Configure resolver to query users
        $co_author_ids = wp_list_pluck($co_authors, 'ID');
        $existing_co_author_ids = array_filter($co_author_ids, 'username_exists');

        // var_dump($co_authors[0]->ID);

        $resolver->set_query_arg('include', $existing_co_author_ids);
        
        return $resolver->get_connection();
     },
  ]);

});
