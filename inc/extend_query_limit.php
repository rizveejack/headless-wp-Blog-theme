<?PHP 

/*
 * Increase perPage for product categories. This is needed to build out the sidebar accordion.
 */
add_filter( 'graphql_connection_max_query_amount', function ( int $max_amount, $source, array $args, $context, $info ) {

	// Bail if the fieldName isn't avail
	if ( empty( $info->fieldName ) ) {
		return $max_amount;
	}
	// Bail if we're not dealing with our target fieldName
	if ( 'posts' !== $info->fieldName ) {
		return $max_amount;
	}
	return 1000;
}, 10, 5 );