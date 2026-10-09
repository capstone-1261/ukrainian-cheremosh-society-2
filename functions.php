<?php
function cptui_register_my_cpts_instructors() {

	/**
	 * Post Type: Instructors.
	 */

	$labels = [
		"name" => esc_html__( "Instructors", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Instructor", "twentytwentyfive" ),
		"menu_name" => esc_html__( "Instructor Posts", "twentytwentyfive" ),
		"all_items" => esc_html__( "All Instructors", "twentytwentyfive" ),
		"add_new" => esc_html__( "Add New", "twentytwentyfive" ),
		"add_new_item" => esc_html__( "Add New Instructor Post", "twentytwentyfive" ),
		"edit_item" => esc_html__( "Edit Instructor Post", "twentytwentyfive" ),
		"new_item" => esc_html__( "New Instructor Post", "twentytwentyfive" ),
		"view_item" => esc_html__( "View Instructor Post", "twentytwentyfive" ),
		"view_items" => esc_html__( "View Instructor Posts", "twentytwentyfive" ),
		"search_items" => esc_html__( "Search Instructor Posts", "twentytwentyfive" ),
		"not_found" => esc_html__( "No Instructor Posts found", "twentytwentyfive" ),
		"not_found_in_trash" => esc_html__( "No Instructor Posts found in Trash", "twentytwentyfive" ),
		"parent" => esc_html__( "Parent Instructor Post:", "twentytwentyfive" ),
		"featured_image" => esc_html__( "Featured image for this instructor post", "twentytwentyfive" ),
		"set_featured_image" => esc_html__( "Set featured image for this instructor post", "twentytwentyfive" ),
		"remove_featured_image" => esc_html__( "Remove featured image for this instructor post", "twentytwentyfive" ),
		"use_featured_image" => esc_html__( "Use as featured image for this instructor post", "twentytwentyfive" ),
		"archives" => esc_html__( "Instructor Post archives", "twentytwentyfive" ),
		"insert_into_item" => esc_html__( "Insert into instructor", "twentytwentyfive" ),
		"uploaded_to_this_item" => esc_html__( "Uploaded to this instructor post", "twentytwentyfive" ),
		"filter_items_list" => esc_html__( "Filter instructor post list", "twentytwentyfive" ),
		"filter_by_date" => esc_html__( "Filter instructor posts by date", "twentytwentyfive" ),
		"items_list_navigation" => esc_html__( "Instructor post list navigation", "twentytwentyfive" ),
		"items_list" => esc_html__( "Instructor post list", "twentytwentyfive" ),
		"attributes" => esc_html__( "Instructor post Attributes", "twentytwentyfive" ),
		"name_admin_bar" => esc_html__( "Instructor Post", "twentytwentyfive" ),
		"item_published" => esc_html__( "Instructor Post published", "twentytwentyfive" ),
		"item_published_privately" => esc_html__( "Instructor Post published privately", "twentytwentyfive" ),
		"item_reverted_to_draft" => esc_html__( "Instructor Post reverted to draft", "twentytwentyfive" ),
		"item_trashed" => esc_html__( "Instructor Post trashed.", "twentytwentyfive" ),
		"item_scheduled" => esc_html__( "Instructor Post scheduled", "twentytwentyfive" ),
		"item_updated" => esc_html__( "Instructor Post updated", "twentytwentyfive" ),
		"template_name" => esc_html__( "Single item: Instructor Post", "twentytwentyfive" ),
		"parent_item_colon" => esc_html__( "Parent Instructor Post:", "twentytwentyfive" ),
	];

	$args = [
		"label" => esc_html__( "Instructors", "twentytwentyfive" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "instructors", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-users",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "author", "page-attributes" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "instructors", $args );
}

add_action( 'init', 'cptui_register_my_cpts_instructors' );

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Instructor Names.
	 */

	$labels = [
		"name" => esc_html__( "Instructor Names", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Instructor Name", "twentytwentyfive" ),
		"menu_name" => esc_html__( "Instructor Names", "twentytwentyfive" ),
		"all_items" => esc_html__( "All Instructors", "twentytwentyfive" ),
		"edit_item" => esc_html__( "Edit Instructor", "twentytwentyfive" ),
		"view_item" => esc_html__( "View Instructor", "twentytwentyfive" ),
		"update_item" => esc_html__( "Update Instructor Name", "twentytwentyfive" ),
		"add_new_item" => esc_html__( "Add New Instructor", "twentytwentyfive" ),
		"new_item_name" => esc_html__( "New Instructor Name", "twentytwentyfive" ),
		"parent_item" => esc_html__( "Parent Instructor", "twentytwentyfive" ),
		"parent_item_colon" => esc_html__( "Parent Instructor:", "twentytwentyfive" ),
		"search_items" => esc_html__( "Search Instructors", "twentytwentyfive" ),
		"popular_items" => esc_html__( "Popular Instructors", "twentytwentyfive" ),
		"separate_items_with_commas" => esc_html__( "Separate Instructors with commas", "twentytwentyfive" ),
		"add_or_remove_items" => esc_html__( "Add or remove Instructors", "twentytwentyfive" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Instructors", "twentytwentyfive" ),
		"not_found" => esc_html__( "No Instructors found", "twentytwentyfive" ),
		"no_terms" => esc_html__( "No Instructors", "twentytwentyfive" ),
		"filter_by_item" => esc_html__( "Filter by Instructor", "twentytwentyfive" ),
		"items_list_navigation" => esc_html__( "Instructor list Navigation", "twentytwentyfive" ),
		"items_list" => esc_html__( "Instructor list", "twentytwentyfive" ),
		"back_to_items" => esc_html__( "Back to Instructors", "twentytwentyfive" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "twentytwentyfive" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "twentytwentyfive" ),
		"slug_field_description" => esc_html__( "The << slug >> is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers and hyphens.", "twentytwentyfive" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it'", "twentytwentyfive" ),
		"template_name" => esc_html__( "Instructor Archives", "twentytwentyfive" ),
	];

	
	$args = [
		"label" => esc_html__( "Instructor Names", "twentytwentyfive" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'instructor_name', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "instructor_name",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "instructor_name", [ "programs" ], $args );

	/**
	 * Taxonomy: Age Ranges.
	 */

	$labels = [
		"name" => esc_html__( "Age Ranges", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Age Range", "twentytwentyfive" ),
		"menu_name" => esc_html__( "Age Ranges", "twentytwentyfive" ),
		"all_items" => esc_html__( "All Age Ranges", "twentytwentyfive" ),
		"edit_item" => esc_html__( "Edit Age Range", "twentytwentyfive" ),
		"view_item" => esc_html__( "View Age Ranges", "twentytwentyfive" ),
		"update_item" => esc_html__( "Update Age Range name", "twentytwentyfive" ),
		"add_new_item" => esc_html__( "Add New Age Range", "twentytwentyfive" ),
		"new_item_name" => esc_html__( "New Age Ranges", "twentytwentyfive" ),
		"parent_item" => esc_html__( "Parent Age Range", "twentytwentyfive" ),
		"parent_item_colon" => esc_html__( "Parent Age Range:", "twentytwentyfive" ),
		"search_items" => esc_html__( "Search Age Range", "twentytwentyfive" ),
		"popular_items" => esc_html__( "Popular Age Ranges", "twentytwentyfive" ),
		"separate_items_with_commas" => esc_html__( "Separate Age Ranges with commas", "twentytwentyfive" ),
		"add_or_remove_items" => esc_html__( "Add or remove Age Ranges", "twentytwentyfive" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Age Ranges", "twentytwentyfive" ),
		"not_found" => esc_html__( "No Age Ranges found", "twentytwentyfive" ),
		"no_terms" => esc_html__( "No Age Ranges", "twentytwentyfive" ),
		"filter_by_item" => esc_html__( "Filter by Age Ranges", "twentytwentyfive" ),
		"items_list_navigation" => esc_html__( "Age Range list Navigation", "twentytwentyfive" ),
		"items_list" => esc_html__( "Age Range list", "twentytwentyfive" ),
		"back_to_items" => esc_html__( "Back to Age Ranges", "twentytwentyfive" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "twentytwentyfive" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "twentytwentyfive" ),
		"slug_field_description" => esc_html__( "The << slug >> is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers and hyphens.", "twentytwentyfive" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it'", "twentytwentyfive" ),
		"template_name" => esc_html__( "Age Range Archives", "twentytwentyfive" ),
	];

	
	$args = [
		"label" => esc_html__( "Age Ranges", "twentytwentyfive" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'age_range', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "age_range",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "age_range", [ "programs" ], $args );

	/**
	 * Taxonomy: Schedules.
	 */

	$labels = [
		"name" => esc_html__( "Schedules", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Schedule", "twentytwentyfive" ),
		"menu_name" => esc_html__( "Schedules", "twentytwentyfive" ),
		"all_items" => esc_html__( "All Schedules", "twentytwentyfive" ),
		"edit_item" => esc_html__( "Edit Schedule", "twentytwentyfive" ),
		"view_item" => esc_html__( "View Schedule", "twentytwentyfive" ),
		"update_item" => esc_html__( "Update Schedule Date", "twentytwentyfive" ),
		"add_new_item" => esc_html__( "Add New Schedule", "twentytwentyfive" ),
		"new_item_name" => esc_html__( "New Schedule Date", "twentytwentyfive" ),
		"parent_item" => esc_html__( "Parent Schedule", "twentytwentyfive" ),
		"parent_item_colon" => esc_html__( "Parent Schedule:", "twentytwentyfive" ),
		"search_items" => esc_html__( "Search Schedules", "twentytwentyfive" ),
		"popular_items" => esc_html__( "Popular Schedules", "twentytwentyfive" ),
		"separate_items_with_commas" => esc_html__( "Separate Schedules with commas", "twentytwentyfive" ),
		"add_or_remove_items" => esc_html__( "Add or remove Schedules", "twentytwentyfive" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Schedules", "twentytwentyfive" ),
		"not_found" => esc_html__( "No Schedules found", "twentytwentyfive" ),
		"no_terms" => esc_html__( "No Schedules", "twentytwentyfive" ),
		"filter_by_item" => esc_html__( "Filter by Schedule", "twentytwentyfive" ),
		"items_list_navigation" => esc_html__( "Schedule list Navigation", "twentytwentyfive" ),
		"items_list" => esc_html__( "Schedule list", "twentytwentyfive" ),
		"back_to_items" => esc_html__( "Back to Schedules", "twentytwentyfive" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "twentytwentyfive" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "twentytwentyfive" ),
		"slug_field_description" => esc_html__( "The << slug >> is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers and hyphens.", "twentytwentyfive" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it", "twentytwentyfive" ),
		"template_name" => esc_html__( "Schedule Archives", "twentytwentyfive" ),
	];

	
	$args = [
		"label" => esc_html__( "Schedules", "twentytwentyfive" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'schedule_dates', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "schedule_dates",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "schedule_dates", [ "programs" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );


?>