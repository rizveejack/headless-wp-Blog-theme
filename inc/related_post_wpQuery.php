<?php 



add_action( 'graphql_register_types', 'register_my_custom_graphql_connection', 99 );

function register_my_custom_graphql_connection() {

  $catId = [];
  
  $config = [
    'fromType' => 'Post',
    'toType' => 'Post',
    'fromFieldName' => 'relatedPost',
    'connectionTypeName' => 'PostsFromThisWeekConnection',
    'resolve' => function( $post, $args, $context, $info ) {

      $categories = get_the_category($post->ID);

      foreach ($categories as $key => $value) {
         $catId[]=$value->term_id;
      }

      $resolver   = new \WPGraphQL\Data\Connection\PostObjectConnectionResolver( $post, $args, $context, $info, 'post' );
      $resolver->set_query_arg( 'orderby', 'DATE' );
      $resolver->set_query_arg( 'order', 'DESC' );
      $resolver->set_query_arg( 'category__in', $catId );
    $resolver->set_query_arg( 'post__not_in', [$post->ID] );
      $connection = $resolver->get_connection();

     
      return $connection;

    },
    
  ];
  
  register_graphql_connection( $config );

};