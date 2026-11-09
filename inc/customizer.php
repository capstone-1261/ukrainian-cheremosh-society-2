<?php
/**
 * Customizer settings
 *
 * Adds sections in Appearance > Customize so the client can change
 * site-wide content without touching code:
 *
 * 1. "Announcement bar": the yellow bar at the top (printed in header.php).
 * 2. "Footer: contact and social": address, phone, email and social links
 *    (printed in footer.php).
 *
 * How the Customizer works:
 * - A "section" is the panel in the Customizer sidebar.
 * - A "setting" is the saved value (stored in the database).
 * - A "control" is the input field the client types into.
 * In templates we read a saved value with get_theme_mod( 'setting_name' ).
 */

/**
 * 1. Announcement bar
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

	// On/off switch.
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

	// The message.
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

	// Link text (what the link says).
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

	// Link address (where the link goes).
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

/**
 * 2. Footer: contact and social
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object WordPress passes in.
 */
function cheremosh_customize_footer( $wp_customize ) {

	// The panel in the Customizer sidebar.
	$wp_customize->add_section(
		'cheremosh_footer',
		array(
			'title'       => 'Footer: contact and social',
			'description' => 'Contact details and social media links shown in the footer on every page. Leave a field empty to hide it.',
			'priority'    => 31, // Right under the Announcement bar.
		)
	);

	// --- Contact details ---
	// Each array item: setting name => array( label, default, input type, sanitize function ).
	$contact_fields = array(
		'cheremosh_contact_address' => array( 'Address', '4005 - 115 Avenue, Edmonton AB', 'text', 'sanitize_text_field' ),
		'cheremosh_contact_phone'   => array( 'Phone', '780-466-0089', 'text', 'sanitize_text_field' ),
		'cheremosh_contact_email'   => array( 'Email', 'contact@cheremosh.ca', 'email', 'sanitize_email' ), // sanitize_email() only allows a valid email.
	);

	// --- Social links ---
	// Defaults are empty, so a link only shows once the client adds the real URL.
	$social_fields = array(
		'cheremosh_social_facebook'  => array( 'Facebook URL', '', 'url', 'esc_url_raw' ),
		'cheremosh_social_instagram' => array( 'Instagram URL', '', 'url', 'esc_url_raw' ),
		'cheremosh_social_linkedin'  => array( 'LinkedIn URL', '', 'url', 'esc_url_raw' ),
		'cheremosh_social_x'         => array( 'X (Twitter) URL', '', 'url', 'esc_url_raw' ),
		'cheremosh_social_youtube'   => array( 'YouTube URL', '', 'url', 'esc_url_raw' ),
	);

	// array_merge() joins both lists so one loop can add every field.
	// The loop saves typing the same add_setting / add_control code 8 times.
	foreach ( array_merge( $contact_fields, $social_fields ) as $setting => $field ) {

		// list() unpacks the 4 values in each array item into named variables.
		list( $label, $default, $type, $sanitize ) = $field;

		$wp_customize->add_setting(
			$setting,
			array(
				'default'           => $default,
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			$setting,
			array(
				'label'   => $label,
				'section' => 'cheremosh_footer',
				'type'    => $type,
			)
		);
	}
}
add_action( 'customize_register', 'cheremosh_customize_footer' );