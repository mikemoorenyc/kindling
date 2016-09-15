<?php
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function location_add_meta_box() {

	$screens = array( 'portfolio' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'location_picker',
			"Google Maps Location",
			'location_meta_box_callback',
			$screen,
      'normal'
		);
	}
}
add_action( 'add_meta_boxes', 'location_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function location_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'location_save_meta_box_data', 'location_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */

   /*
	$value = get_post_meta( $post->ID, '_coordinates', true );


	echo '<label for="google_coordinates">';
	echo 'Coordinates';
	echo '</label> ';
	echo '<input type="text" id="google_coordinates" name="google_coordinates" value="' . esc_attr( $value ) . '" size="25" />';

  */
  include 'ui-template.php';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function location_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['location_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['location_meta_box_nonce'], 'location_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['google_coordinates'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['google_coordinates'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_coordinates', $my_data );
}
add_action( 'save_post', 'location_save_meta_box_data' );


///test
?>
