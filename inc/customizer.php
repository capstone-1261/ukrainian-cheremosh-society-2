<?php
/**
 * Customizer settings: Announcement bar
 *
 * Adds a section in Appearance > Customize called "Announcement bar"
 * so the client can turn the yellow bar on/off and change its message
 * and link without touching code.
 *
 * The bar itself is printed in header.php (above the site header).
 */

/**
 * Register the section, settings and controls.
 *
 * - A "section" is the panel in the Customizer sidebar.
 * - A "setting" is the saved value (stored in the database).
 * - A "control" is the input field the client types into.
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object WordPress passes in.
 */
function cheremosh_customize_announcement( $wp_customize ) {

	// The panel in the Customizer sidebar.
	$wp_customize->add_section(
		'cheremosh_announcement',
		array(
			'title'       => 'Announcement bar',
			'description' => 'The yellow bar at the very top of every page. Use it for one important message at a time.',
			'priority'    => 30, // Position in the Customizer list (lower = higher up).
		)
	);

	// 1. On/off switch.
	$wp_customize->add_setting(
		'cheremosh_announcement_show',
		array(
			'default'           => false,
			'sanitize_callback' => 'wp_validate_boolean', // Only allow true/false.
		)
	);
	$wp_customize->add_control(
		'cheremosh_announcement_show',
		array(
			'label'   => 'Show the announcement bar',
			'section' => 'cheremosh_announcement',
			'type'    => 'checkbox',
		)
	);

	// 2. The message.
	$wp_customize->add_setting(
		'cheremosh_announcement_text',
		array(
			'default'           => 'The Cheremosh Ukrainian Dance Festival is Coming',
			'sanitize_callback' => 'sanitize_text_field', // Plain text only, no HTML.
		)
	);
	$wp_customize->add_control(
		'cheremosh_announcement_text',
		array(
			'label'   => 'Message',
			'section' => 'cheremosh_announcement',
			'type'    => 'text',
		)
	);

	// 3. Link text (what the link says).
	$wp_customize->add_setting(
		'cheremosh_announcement_link_text',
		array(
			'default'           => 'Explore the Festival',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'cheremosh_announcement_link_text',
		array(
			'label'       => 'Link text',
			'description' => 'Leave empty for no link.',
			'section'     => 'cheremosh_announcement',
			'type'        => 'text',
		)
	);

	// 4. Link address (where the link goes).
	$wp_customize->add_setting(
		'cheremosh_announcement_link_url',
		array(
			'default'           => '/dance-festival/',
			'sanitize_callback' => 'esc_url_raw', // Only allow a valid URL.
		)
	);
	$wp_customize->add_control(
		'cheremosh_announcement_link_url',
		array(
			'label'   => 'Link address',
			'section' => 'cheremosh_announcement',
			'type'    => 'url',
		)
	);
}
add_action( 'customize_register', 'cheremosh_customize_announcement' );