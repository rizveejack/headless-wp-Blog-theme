<?php 


add_filter( 'allowed_block_types_all', 'misha_allowed_block_types', 25, 2 );
 
function misha_allowed_block_types( $allowed_blocks, $editor_context ) {
 
	return array(
		'core/image',
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/table',
		'core/buttons',
		'core/quote',
		'core/media-text',
		'yoast/faq-block',
		'yoast/how-to-block'
	);
 
}