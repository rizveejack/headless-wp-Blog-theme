<?php 
function custom_post_type_menu_labels() {
    global $menu, $submenu;

    // Change the default Post menu labels
    $menu[5][0] = 'Opinion';
    $submenu['edit.php'][5][0] = 'All Opinion';
    $submenu['edit.php'][10][0] = 'Add Opinion';
}

add_action('admin_menu', 'custom_post_type_menu_labels');



function custom_post_type_labels() {
    global $wp_post_types;

    // Change the default Post labels
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Opinions';
    $labels->singular_name = 'Opinion';
    $labels->add_new = 'Add Opinion';
    $labels->add_new_item = 'New Opinion';
    $labels->edit_item = 'Edit Opinion';
    $labels->new_item = 'New Opinion';
    $labels->view_item = 'View Opinion';
    $labels->search_items = 'Search Opinion';
    $labels->not_found = 'No Opinion found';
    $labels->not_found_in_trash = 'No Opinion found in Trash';
    $labels->all_items = 'All Opinion';
    $wp_post_types['post']->menu_icon = 'dashicons-star-filled'; 
}

add_action('init', 'custom_post_type_labels');









