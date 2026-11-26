<?php
/**
 * Camps page fields (ACF Free)
 *
 * Registers the fields the client edits on the Camps page. page-camps.php
 * reads them with get_field(). When a field is empty, the existing text and
 * image stay as the fallback.
 *
 * Uses only text, textarea, image and url fields, so ACF Pro isn't needed.
 *
 * @package cheremosh-theme
 */

/**
 * Get a text field's value, or the fallback when it is empty.
 *
 * @param string $name    ACF field name.
 * @param string $default Fallback text from the template.
 * @return string
 */
function cheremosh_camps_text( $name, $default ) {
	$value = get_field( $name );

	return ( is_string( $value ) && '' !== trim( $value ) ) ? $value : $default;
}

/**
 * Get an image field's URL and alt text, or the fallbacks when it is empty.
 *
 * @param string $name        ACF field name.
 * @param string $default_url Fallback image URL from the theme.
 * @param string $default_alt Fallback alt text.
 * @return array Array with 'url' and 'alt' keys.
 */
function cheremosh_camps_image( $name, $default_url, $default_alt = '' ) {
	$image = get_field( $name );

	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return array(
			'url' => $image['url'],
			'alt' => ! empty( $image['alt'] ) ? $image['alt'] : $default_alt,
		);
	}

	return array(
		'url' => $default_url,
		'alt' => $default_alt,
	);
}

/**
 * Build one field definition for the Camps group.
 *
 * @param string $name  Field name, used in get_field().
 * @param string $label Label shown in wp-admin.
 * @param string $type  ACF field type: text, textarea, image or url.
 * @return array
 */
function cheremosh_camps_field( $name, $label, $type = 'text' ) {
	$field = array(
		'key'   => 'field_' . $name,
		'label' => $label,
		'name'  => $name,
		'type'  => $type,
	);

	if ( 'image' === $type ) {
		$field['return_format'] = 'array';
		$field['preview_size']  = 'medium';
	}

	if ( 'textarea' === $type ) {
		$field['rows'] = 4;
	}

	return $field;
}

/**
 * Register the Camps page field group.
 */
function cheremosh_camps_register_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = array(
		// Hero.
		cheremosh_camps_field( 'camps_hero_image', 'Hero image', 'image' ),
		cheremosh_camps_field( 'camps_hero_tagline', 'Hero tagline' ),
		cheremosh_camps_field( 'camps_hero_title', 'Hero title' ),
		cheremosh_camps_field( 'camps_hero_text_1', 'Hero text (first paragraph)', 'textarea' ),
		cheremosh_camps_field( 'camps_hero_text_2', 'Hero text (second paragraph)', 'textarea' ),
		cheremosh_camps_field( 'camps_hero_button_text', 'Hero button text' ),

		// Overview heading and intro.
		cheremosh_camps_field( 'camps_overview_tagline', 'Overview tagline' ),
		cheremosh_camps_field( 'camps_overview_heading', 'Overview heading' ),
		cheremosh_camps_field( 'camps_overview_intro', 'Overview intro (may include a link)', 'textarea' ),
	);

	// Five camp cards, each with its own fields.
	for ( $n = 1; $n <= 5; $n++ ) {
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_title", "Camp {$n}: name" );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_age", "Camp {$n}: age group" );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_dates", "Camp {$n}: dates" );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_times", "Camp {$n}: times" );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_note", "Camp {$n}: extra note (optional)" );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_image", "Camp {$n}: card image", 'image' );
		$fields[] = cheremosh_camps_field( "camps_camp_{$n}_link", "Camp {$n}: registration link", 'url' );
	}

	// Directors section: two directors.
	$fields[] = cheremosh_camps_field( 'camps_directors_tagline', 'Directors tagline' );
	$fields[] = cheremosh_camps_field( 'camps_directors_heading', 'Directors heading' );

	for ( $n = 1; $n <= 2; $n++ ) {
		$fields[] = cheremosh_camps_field( "camps_director_{$n}_photo", "Director {$n}: photo", 'image' );
		$fields[] = cheremosh_camps_field( "camps_director_{$n}_name", "Director {$n}: name" );
		$fields[] = cheremosh_camps_field( "camps_director_{$n}_bio", "Director {$n}: biography", 'textarea' );
	}

	// FAQ: heading, intro, four questions and answers, and the contact block.
	$fields[] = cheremosh_camps_field( 'camps_faq_tagline', 'FAQ tagline' );
	$fields[] = cheremosh_camps_field( 'camps_faq_heading', 'FAQ heading' );
	$fields[] = cheremosh_camps_field( 'camps_faq_intro', 'FAQ intro', 'textarea' );

	for ( $n = 1; $n <= 4; $n++ ) {
		$fields[] = cheremosh_camps_field( "camps_faq_{$n}_question", "FAQ {$n}: question" );
		$fields[] = cheremosh_camps_field( "camps_faq_{$n}_answer", "FAQ {$n}: answer", 'textarea' );
	}

	$fields[] = cheremosh_camps_field( 'camps_faq_contact_title', 'Contact block: title' );
	$fields[] = cheremosh_camps_field( 'camps_faq_contact_text', 'Contact block: text', 'textarea' );
	$fields[] = cheremosh_camps_field( 'camps_faq_button_text', 'Contact block: button text' );
	$fields[] = cheremosh_camps_field( 'camps_faq_button_url', 'Contact block: button link', 'url' );

	acf_add_local_field_group(
		array(
			'key'        => 'group_camps_page',
			'title'      => 'Camps page content',
			'fields'     => $fields,
			'location'   => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-camps.php',
					),
				),
			),
			'menu_order' => 0,
			'position'   => 'normal',
			'style'      => 'default',
			'active'     => true,
		)
	);
}
add_action( 'acf/init', 'cheremosh_camps_register_fields' );