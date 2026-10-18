<?php


/* ACF Field Groups */

function cheremosh_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_6ad297a534374',
	'title' => 'Related Instructors',
	'fields' => array(
		array(
			'key' => 'field_6ad28cf75b1bf',
			'label' => 'Related Instructor',
			'name' => 'related_instructor',
			'aria-label' => '',
			'type' => 'relationship',
			'instructions' => 'To link posts with each other',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'instructors',
			),
			'post_status' => '',
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'return_format' => 'object',
			'min' => '',
			'max' => '',
			'allow_in_bindings' => 0,
			'elements' => '',
			'bidirectional' => 1,
			'bidirectional_target' => array(
				0 => 'field_6ad289947f424',
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'programs',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );

	acf_add_local_field_group( array(
	'key' => 'group_6ad28993f2357',
	'title' => 'Related Programs',
	'fields' => array(
		array(
			'key' => 'field_6ad289947f424',
			'label' => 'Related Program',
			'name' => 'related_program',
			'aria-label' => '',
			'type' => 'relationship',
			'instructions' => 'To link posts with each other',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'programs',
			),
			'post_status' => '',
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'return_format' => 'object',
			'min' => '',
			'max' => '',
			'allow_in_bindings' => 0,
			'elements' => '',
			'bidirectional' => 1,
			'bidirectional_target' => array(
				0 => 'field_6ad28cf75b1bf',
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'instructors',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );

	acf_add_local_field_group( array(
	'key' => 'group_6ad284e82d032',
	'title' => 'Schedules',
	'fields' => array(
		array(
			'key' => 'field_6ad284ea87857',
			'label' => 'Date of Season Start',
			'name' => 'date_of_season_start',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'Input the date of the start of the season here',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
			'default_to_current_date' => 0,
			'allow_in_bindings' => 0,
		),
		array(
			'key' => 'field_6ad426546d046',
			'label' => 'Date of Season End',
			'name' => 'date_of_season_end',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'Input the date of the end of the season here',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'F j, Y',
			'return_format' => 'F j, Y',
			'first_day' => 1,
			'default_to_current_date' => 0,
			'allow_in_bindings' => 0,
		),
		array(
			'key' => 'field_6ad2870b511a8',
			'label' => 'Start Time',
			'name' => 'start_time',
			'aria-label' => '',
			'type' => 'time_picker',
			'instructions' => 'Input the starting time here',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'g:i a',
			'return_format' => 'g:i a',
			'allow_in_bindings' => 0,
		),
		array(
			'key' => 'field_6ad2874c511aa',
			'label' => 'End Time',
			'name' => 'end_time',
			'aria-label' => '',
			'type' => 'time_picker',
			'instructions' => 'Input the ending time here',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'g:i a',
			'return_format' => 'g:i a',
			'allow_in_bindings' => 0,
		),
		array(
			'key' => 'field_6ad2862287858',
			'label' => 'Day of the Week',
			'name' => 'day_of_the_week',
			'aria-label' => '',
			'type' => 'checkbox',
			'instructions' => 'Click on the checkboxes for the day of the week here',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'monday' => 'Monday',
				'tuesday' => 'Tuesday',
				'wednesday' => 'Wednesday',
				'thursday' => 'Thursday',
				'friday' => 'Friday',
				'saturday' => 'Saturday',
				'sunday' => 'Sunday',
			),
			'default_value' => array(
			),
			'return_format' => 'label',
			'allow_custom' => 0,
			'allow_in_bindings' => 0,
			'layout' => 'vertical',
			'toggle' => 0,
			'save_custom' => 0,
			'custom_choice_button_text' => 'Add new choice',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'programs',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	'display_title' => '',
	'allow_ai_access' => false,
	'ai_description' => '',
) );
} 
add_action( 'acf/include_fields', 'cheremosh_register_acf_field_groups' );

/* Taxonomies */

function cheremosh_register_taxonomies() {
	register_taxonomy( 'age_range', array(
	0 => 'programs',
), array(
	'labels' => array(
		'name' => 'Age Ranges',
		'singular_name' => 'Age Range',
		'menu_name' => 'Age Ranges',
		'all_items' => 'All Age Ranges',
		'edit_item' => 'Edit Age Range',
		'view_item' => 'View Age Ranges',
		'update_item' => 'Update Age Range name',
		'add_new_item' => 'Add New Age Range',
		'new_item_name' => 'New Age Ranges',
		'parent_item' => 'Parent Age Range',
		'parent_item_colon' => 'Parent Age Range:',
		'search_items' => 'Search Age Range',
		'not_found' => 'No Age Ranges found',
		'no_terms' => 'No Age Ranges',
		'name_field_description' => 'The name is how it appears on your site.',
		'slug_field_description' => 'The &lt;&lt; slug &gt;&gt; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers and hyphens.',
		'parent_field_description' => 'Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.',
		'desc_field_description' => 'The description is not prominent by default; however, some themes may show it&#039;',
		'filter_by_item' => 'Filter by Age Ranges',
		'items_list_navigation' => 'Age Range list Navigation',
		'items_list' => 'Age Range list',
		'back_to_items' => 'Back to Age Ranges',
	),
	'description' => 'Age range displayed on program post types',
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
	'show_tagcloud' => false,
	'show_in_quick_edit' => false,
) );
}
add_action( 'init', 'cheremosh_register_taxonomies' );

/* Post Types */

function cheremosh_register_post_types() {
	register_post_type( 'instructors', array(
	'labels' => array(
		'name' => 'Instructors',
		'singular_name' => 'Instructor',
		'menu_name' => 'Instructors',
		'all_items' => 'All Instructors',
		'edit_item' => 'Edit Instructor Post',
		'view_item' => 'View Instructor Post',
		'view_items' => 'View Instructor Posts',
		'add_new_item' => 'Add New Instructor Post',
		'add_new' => 'Add New',
		'new_item' => 'New Instructor Post',
		'parent_item_colon' => 'Parent Instructor Post:',
		'search_items' => 'Search Instructor Posts',
		'not_found' => 'No Instructor Posts found',
		'not_found_in_trash' => 'No Instructor Posts found in Trash',
		'archives' => 'Instructor Post archives',
		'attributes' => 'Instructor post Attributes',
		'featured_image' => 'Featured image for this instructor post',
		'set_featured_image' => 'Set featured image for this instructor post',
		'remove_featured_image' => 'Remove featured image for this instructor post',
		'use_featured_image' => 'Use as featured image for this instructor post',
		'insert_into_item' => 'Insert into instructor',
		'uploaded_to_this_item' => 'Uploaded to this instructor post',
		'filter_items_list' => 'Filter instructor post list',
		'filter_by_date' => 'Filter instructor posts by date',
		'items_list_navigation' => 'Instructor post list navigation',
		'items_list' => 'Instructor post list',
		'item_published' => 'Instructor Post published',
		'item_published_privately' => 'Instructor Post published privately',
		'item_reverted_to_draft' => 'Instructor Post reverted to draft',
		'item_scheduled' => 'Instructor Post scheduled',
		'item_updated' => 'Instructor Post updated',
	),
	'public' => true,
	'show_in_rest' => true,
	'menu_icon' => 'dashicons-admin-users',
	'supports' => array(
		0 => 'title',
		1 => 'editor',
		2 => 'thumbnail',
		3 => 'author',
		4 => 'custom-fields',
		5 => 'excerpt',
		6 => 'page-attributes',
	),
	'taxonomies' => array(
		0 => 'category',
		1 => 'post_tag',
	),
	'can_export' => true,
	'delete_with_user' => false,
) );

	register_post_type( 'programs', array(
	'labels' => array(
		'name' => 'Programs',
		'singular_name' => 'Program',
		'menu_name' => 'Programs',
		'all_items' => 'All Programs',
		'edit_item' => 'Edit Program',
		'view_item' => 'View Program',
		'view_items' => 'View Programs',
		'add_new_item' => 'Add New Program',
		'add_new' => 'Add New',
		'new_item' => 'New Program',
		'parent_item_colon' => 'Parent Programs',
		'search_items' => 'Search Programs',
		'not_found' => 'No Programs Found',
		'not_found_in_trash' => 'No Programs found in Trash',
		'archives' => 'Program archives',
		'attributes' => 'Programs Attributes',
		'featured_image' => 'Featured Image for this Program',
		'set_featured_image' => 'Set Featured Image for this Program',
		'remove_featured_image' => 'Remove Featured Image for this Program',
		'use_featured_image' => 'Use as Featured Image for this Program',
		'insert_into_item' => 'Insert into Program',
		'uploaded_to_this_item' => 'Uploaded to this Program',
		'filter_items_list' => 'Filter Programs list',
		'filter_by_date' => 'Filter Programs by date',
		'items_list_navigation' => 'Programs list Navigation',
		'items_list' => 'Programs List',
		'item_published' => 'Program Published',
		'item_published_privately' => 'Program published privately',
		'item_reverted_to_draft' => 'Program reverted to draft',
		'item_scheduled' => 'Program Scheduled',
		'item_updated' => 'Program Updated',
	),
	'public' => true,
	'show_in_rest' => true,
	'menu_icon' => 'dashicons-admin-post',
	'supports' => array(
		0 => 'title',
		1 => 'editor',
		2 => 'thumbnail',
		3 => 'author',
		4 => 'custom-fields',
		5 => 'excerpt',
		6 => 'page-attributes',
	),
	'taxonomies' => array(
		0 => 'category',
		1 => 'post_tag',
	),
	'can_export' => true,
	'delete_with_user' => false,
) );
} 
add_action( 'init', 'cheremosh_register_post_types' );

/* Titles */

function cheremosh_enter_title_here( $default, $post ) {
	switch ( $post->post_type ) {
		case 'instructors':
			return 'Add Post Instructor';
		case 'programs':
			return 'Add Program';
	}
	return $default;
}
add_filter( 'enter_title_here', 'cheremosh_enter_title_here', 10, 2 );