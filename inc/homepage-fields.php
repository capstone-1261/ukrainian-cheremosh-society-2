<?php
/**
 * Homepage fields
 *
 * Adds an "Homepage content" box to the Home page edit screen in WordPress,
 * so the client can change the homepage text, links and photos without code.
 *
 * Each field has a "name". front-page.php asks for a field by that name with
 * cheremosh_home( 'name', 'fallback' ). If the client leaves a field empty,
 * the fallback is used. If the fallback is empty too, that piece of the page
 * simply isn't shown (so no placeholder text ever appears on the live site).
 */

/**
 * Gets one homepage field.
 *
 * @param string $name     The field name (see the lists further down).
 * @param string $fallback What to use if the client hasn't filled it in.
 * @return string          The text, link, or image address.
 */
function cheremosh_home( $name, $fallback = '' ) {
	// If the ACF plugin is off, just use the fallback so the page still works.
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	// The fields are saved on whichever page is set as the homepage.
	$value = get_field( $name, (int) get_option( 'page_on_front' ) );

	// Empty field = use the fallback.
	return ( null === $value || '' === $value || false === $value ) ? $fallback : $value;
}

/**
 * Builds the field box. Each section is one "tab" on the edit screen.
 * Every field is listed as: name, label, type.
 * Types: text, textarea, url (a link), image (a photo).
 */
function cheremosh_register_homepage_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$sections = array(

		'About cards' => array(
			array( 'company_image', 'Company: photo', 'image' ),
			array( 'company_tagline', 'Company: small title', 'text' ),
			array( 'company_title', 'Company: heading', 'text' ),
			array( 'company_text', 'Company: text', 'textarea' ),
			array( 'company_button_label', 'Company: button words', 'text' ),
			array( 'company_button_url', 'Company: button link', 'url' ),
			array( 'school_image', 'School: photo', 'image' ),
			array( 'school_tagline', 'School: small title', 'text' ),
			array( 'school_title', 'School: heading', 'text' ),
			array( 'school_text', 'School: text', 'textarea' ),
			array( 'school_button_label', 'School: button words', 'text' ),
			array( 'school_button_url', 'School: button link', 'url' ),
		),

		'Program registration' => array(
			array( 'register_label', 'Small title', 'text' ),
			array( 'register_title', 'Heading', 'text' ),
			array( 'register_intro', 'Intro text', 'textarea' ),
			array( 'register_point_1', 'Point 1', 'text' ),
			array( 'register_point_2', 'Point 2', 'text' ),
			array( 'register_point_3', 'Point 3', 'text' ),
			array( 'register_button_label', 'Button words', 'text' ),
			array( 'register_button_url', 'Button link', 'url' ),
		),

		'Dance Festival' => array(
			array( 'festival_image', 'Photo', 'image' ),
			array( 'festival_label', 'Small title', 'text' ),
			array( 'festival_title', 'Heading', 'text' ),
			array( 'festival_1_title', 'Block 1: heading', 'text' ),
			array( 'festival_1_text', 'Block 1: text', 'textarea' ),
			array( 'festival_1_button_label', 'Block 1: button words', 'text' ),
			array( 'festival_1_button_url', 'Block 1: button link', 'url' ),
			array( 'festival_2_title', 'Block 2: heading', 'text' ),
			array( 'festival_2_text', 'Block 2: text', 'textarea' ),
			array( 'festival_2_button_label', 'Block 2: button words', 'text' ),
			array( 'festival_2_button_url', 'Block 2: button link', 'url' ),
			array( 'festival_3_title', 'Block 3: heading', 'text' ),
			array( 'festival_3_text', 'Block 3: text (leave empty to hide this block)', 'textarea' ),
			array( 'festival_3_button_label', 'Block 3: button words', 'text' ),
			array( 'festival_3_button_url', 'Block 3: button link', 'url' ),
			array( 'festival_4_title', 'Block 4: heading', 'text' ),
			array( 'festival_4_text', 'Block 4: text (leave empty to hide this block)', 'textarea' ),
			array( 'festival_4_button_label', 'Block 4: button words', 'text' ),
			array( 'festival_4_button_url', 'Block 4: button link', 'url' ),
		),


		'Events' => array(
			array( 'events_label', 'Small title', 'text' ),
			array( 'events_title', 'Heading', 'text' ),
			array( 'events_intro', 'Intro text (leave empty to hide)', 'textarea' ),
			array( 'events_view_all_label', 'View all: words', 'text' ),
			array( 'events_view_all_url', 'View all: link', 'url' ),
		),


		'Rent our space' => array(
			array( 'rent_image', 'Photo', 'image' ),
			array( 'rent_label', 'Small title', 'text' ),
			array( 'rent_title', 'Heading', 'text' ),
			array( 'rent_1_title', 'Column 1: heading', 'text' ),
			array( 'rent_1_text', 'Column 1: text', 'textarea' ),
			array( 'rent_1_button_label', 'Column 1: button words', 'text' ),
			array( 'rent_1_button_url', 'Column 1: button link', 'url' ),
			array( 'rent_2_title', 'Column 2: heading', 'text' ),
			array( 'rent_2_text', 'Column 2: text', 'textarea' ),
			array( 'rent_2_button_label', 'Column 2: button words', 'text' ),
			array( 'rent_2_button_url', 'Column 2: button link', 'url' ),
			array( 'rent_3_title', 'Column 3: heading', 'text' ),
			array( 'rent_3_text', 'Column 3: text', 'textarea' ),
			array( 'rent_3_button_label', 'Column 3: button words', 'text' ),
			array( 'rent_3_button_url', 'Column 3: button link', 'url' ),
		),


		'Shop slider' => array(
			array( 'shop_label', 'Small title', 'text' ),
			array( 'shop_title', 'Heading', 'text' ),
			array( 'shop_view_all_label', 'View all: words', 'text' ),
			array( 'shop_view_all_url', 'View all: link', 'url' ),
		),


		// FAQ: left side has the heading + "still have questions" box,
		// right side is the list of questions. Leave a question empty to hide it.
		'FAQ' => array(
			array( 'faq_label', 'Small title', 'text' ),
			array( 'faq_title', 'Heading', 'text' ),
			array( 'faq_intro', 'Intro text (leave empty to hide)', 'textarea' ),
			array( 'faq_more_title', 'Still have questions: heading', 'text' ),
			array( 'faq_more_text', 'Still have questions: text', 'textarea' ),
			array( 'faq_button_label', 'Button words', 'text' ),
			array( 'faq_button_url', 'Button link', 'url' ),
			array( 'faq_1_question', 'Question 1', 'text' ),
			array( 'faq_1_answer', 'Answer 1', 'textarea' ),
			array( 'faq_2_question', 'Question 2', 'text' ),
			array( 'faq_2_answer', 'Answer 2', 'textarea' ),
			array( 'faq_3_question', 'Question 3', 'text' ),
			array( 'faq_3_answer', 'Answer 3', 'textarea' ),
			array( 'faq_4_question', 'Question 4 (leave empty to hide)', 'text' ),
			array( 'faq_4_answer', 'Answer 4', 'textarea' ),
			array( 'faq_5_question', 'Question 5 (leave empty to hide)', 'text' ),
			array( 'faq_5_answer', 'Answer 5', 'textarea' ),
		),

		

		// Newsletter: the heading, short text and button words.
		// The Mailchimp address itself is the one set in the Customizer (Footer).
		'Newsletter' => array(
			array( 'newsletter_label', 'Small title', 'text' ),
			array( 'newsletter_title', 'Heading', 'text' ),
			array( 'newsletter_text', 'Short text', 'textarea' ),
			array( 'newsletter_email_label', 'Email box title', 'text' ),
			array( 'newsletter_placeholder', 'Email box example text', 'text' ),
			array( 'newsletter_button_label', 'Button words', 'text' ),
			array( 'newsletter_consent', 'Small print (before the link)', 'text' ),
			array( 'newsletter_terms_label', 'Small print: link words', 'text' ),
			array( 'newsletter_terms_url', 'Small print: link (leave empty for no link)', 'url' ),
		),



		// Supporters: the logo strip. Up to 8 logos. A slot with no photo is skipped.
		// "Name" is read out by screen readers, so type the supporter's name.
		'Supporters' => array(
			array( 'supporters_title', 'Heading', 'text' ),
			array( 'supporter_1_image', 'Logo 1: photo', 'image' ),
			array( 'supporter_1_name', 'Logo 1: name', 'text' ),
			array( 'supporter_2_image', 'Logo 2: photo', 'image' ),
			array( 'supporter_2_name', 'Logo 2: name', 'text' ),
			array( 'supporter_3_image', 'Logo 3: photo', 'image' ),
			array( 'supporter_3_name', 'Logo 3: name', 'text' ),
			array( 'supporter_4_image', 'Logo 4: photo', 'image' ),
			array( 'supporter_4_name', 'Logo 4: name', 'text' ),
			array( 'supporter_5_image', 'Logo 5: photo', 'image' ),
			array( 'supporter_5_name', 'Logo 5: name', 'text' ),
			array( 'supporter_6_image', 'Logo 6: photo', 'image' ),
			array( 'supporter_6_name', 'Logo 6: name', 'text' ),
			array( 'supporter_7_image', 'Logo 7: photo', 'image' ),
			array( 'supporter_7_name', 'Logo 7: name', 'text' ),
			array( 'supporter_8_image', 'Logo 8: photo', 'image' ),
			array( 'supporter_8_name', 'Logo 8: name', 'text' ),
		),

	);

	// Turn the lists above into the field format ACF wants.
	$fields = array();

	foreach ( $sections as $section_name => $section_fields ) {

		// A tab heading for each section.
		$fields[] = array(
			'key'       => 'field_home_tab_' . sanitize_title( $section_name ),
			'label'     => $section_name,
			'name'      => '',
			'type'      => 'tab',
			'placement' => 'top',
		);

		foreach ( $section_fields as $field ) {
			$settings = array(
				'key'   => 'field_home_' . $field[0],
				'label' => $field[1],
				'name'  => $field[0],
				'type'  => $field[2],
			);

			// Photos come back as an image address, shown as a medium preview.
			if ( 'image' === $field[2] ) {
				$settings['return_format'] = 'url';
				$settings['preview_size']  = 'medium';
				$settings['library']       = 'all';
			}

			// Text areas stay small.
			if ( 'textarea' === $field[2] ) {
				$settings['rows']      = 3;
				$settings['new_lines'] = '';
			}

			$fields[] = $settings;
		}
	}

	// Show the box only when editing the page that is set as the homepage.
	acf_add_local_field_group(
		array(
			'key'      => 'group_homepage_content',
			'title'    => 'Homepage content',
			'fields'   => $fields,
			'location' => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'cheremosh_register_homepage_fields' );