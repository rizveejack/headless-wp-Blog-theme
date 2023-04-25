<?PHP 



function wds_set_headless_preview_link( string $link, WP_Post $post ) {
	

	$base_url = !empty(get_option( 'feurl' ))? rtrim(get_option( 'feurl' ), '/') : "http://localhost:3000";
	

	// Get GraphQL single name.
	$post_type = get_post_type_object( $post->post_type )->graphql_single_name ?? $post->post_type;

	// Preview link will have format: <domain>/api/preview?name=<slug>&id=<post-id>&post_type=<postType>&token=<preview-token>.
	return add_query_arg(
		[
			
			'id'        => $post->ID,
			
		],
		"{$base_url}/preview"
	);
}
add_filter( 'preview_post_link', 'wds_set_headless_preview_link', 10, 2 );




function change_post_URL(string $permalink, WP_Post $post) {

	$new_link = !empty(get_option( 'feurl' ))? rtrim(get_option( 'feurl' ), '/')."/".$post->post_name : "http://localhost:3000/".$post->post_name;
	return $new_link;
}




function change_page_URL ($link) {
	
	$new_link = !empty(get_option( 'feurl' ))? str_replace(get_site_url(),rtrim(get_option( 'feurl' ), '/'),$link) : str_replace(get_site_url(),"http://localhost:3000",$link);

	return $new_link;
}





function change_category_URL ($link) {
	
	$new_link = !empty(get_option( 'feurl' ))? str_replace(get_site_url(),rtrim(get_option( 'feurl' ), '/'),$link) : str_replace(get_site_url(),"http://localhost:3000",$link);

	return $new_link;
}


function change_site_URL ($url) {
	
	$new_link = !empty(get_option( 'feurl' ))? str_replace(get_site_url(),rtrim(get_option( 'feurl' ), '/'),$url) : str_replace(get_site_url(),"http://localhost:3000",$url);

	return $new_link;
}

add_filter( 'home_url', 'change_site_URL', 10, 1);
add_filter( 'post_link', 'change_post_URL', 10, 2);
add_filter( 'page_link', 'change_page_URL', 10, 1);
add_filter( 'category_link', 'change_category_URL', 10, 1);


// workaround script until there's an official solution for https://github.com/WordPress/gutenberg/issues/13998
function fix_preview_link_on_draft() {
	echo '<script type="text/javascript">
	jQuery(document).ready(function () {
		const checkPreviewInterval = setInterval(checkPreview, 1000);
		function checkPreview() {
			const editorPreviewButton = jQuery(".edit-post-header-preview__button-external");

			if (editorPreviewButton.length && editorPreviewButton.attr("href") !== "' . get_preview_post_link() . '" ) {
				editorPreviewButton.attr("href", "' . get_preview_post_link() . '");
				editorPreviewButton.off();
				editorPreviewButton.click(false);
				editorPreviewButton.on("click", function(e) {
					const editorPostSaveDraft = jQuery(".editor-post-save-draft");

					if(editorPostSaveDraft.length > 0) {
						editorPostSaveDraft.click();
					}
					const intervalId = setInterval(function() {
						// find out when the post is saved
						let saved = document.querySelector(".is-saved");
						if(saved) {
							clearInterval(intervalId);
							const win = window.open("' . get_preview_post_link() . '", "_blank");
							if (win) {
								win.focus();
							}
						}
					}, 50);
				});
			}
		}
	});
	</script>';
}
add_action( 'admin_footer-edit.php', 'fix_preview_link_on_draft' ); // Fired on the page with the posts table
add_action( 'admin_footer-post.php', 'fix_preview_link_on_draft' ); // Fired on post edit page
add_action( 'admin_footer-post-new.php', 'fix_preview_link_on_draft' ); // Fired on add new post page