<?php
/**
 * Festival video tutorial fields (ACF Free)
 *
 * Adds one "video link" box for each of the seven tutorials to the Festival
 * Registration Video Tutorials page in wp-admin. The client pastes a link
 * (YouTube, for example) into a box and saves. No developer needed.
 *
 * page-festival-software-instructional-videos.php reads these with
 * get_field(). While a box is empty, that card shows "Video coming soon".
 *
 * Uses only URL fields, so ACF Pro isn't needed.
 *
 * @package cheremosh-theme
 */

/**
 * The seven tutorials, in the order they appear on the page.
 * The template and the fields both use this list, so the names always match.
 *
 * @return string[] Tutorial titles.
 */
function cheremosh_festival_video_titles() {
	return array(
		'Returning Dance Schools',
		'New Dance Schools',
		'Adding Dance Entries',
		'Adding Instructors',
		'Uploading Music',
		'Adding or Editing a Dancer',
		'Checking Invoices & Submitting Payment',
	);
}

/**
 * Register the field group (the boxes the client sees in wp-admin).
 */
function cheremosh_festival_videos_register_fields() {
	// Do nothing if the ACF plugin isn't active.
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = array();

	// One URL field per tutorial: festival_video_1_link ... festival_video_7_link.
	foreach ( cheremosh_festival_video_titles() as $index => $title ) {
		$n = $index + 1;

		$fields[] = array(
			'key'          => "field_festival_video_{$n}_link", // ACF needs a unique key per field.
			'label'        => "Video {$n}: {$title}",           // What the client sees.
			'name'         => "festival_video_{$n}_link",       // What get_field() asks for.
			'type'         => 'url',
			'instructions' => 'Paste the video link (for example from YouTube). Leave empty to show "Video coming soon".',
		);
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_festival_videos_page',
			'title'    => 'Festival video tutorial links',
			'fields'   => $fields,
			// Show these boxes only on pages that use the "Festival Video Tutorials" template.
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-festival-software-instructional-videos.php',
					),
				),
			),
			'active'   => true,
		)
	);
}
add_action( 'acf/init', 'cheremosh_festival_videos_register_fields' );