<?php
include 'post-type.php';




function add_map_meta_box() {

	$screens = array( 'maps' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'map_point_maker',
			"Points Of Interest Map",
			'map_meta_box_callback',
			$screen,
      'normal'
		);
	}
}
add_action( 'add_meta_boxes', 'add_map_meta_box' );

function map_meta_box_callback( $post ) {

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'map_save_meta_box_data', 'map_meta_box_nonce' );

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
function map_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['map_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['map_meta_box_nonce'], 'map_save_meta_box_data' ) ) {
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
	} else {
    // Sanitize user input.
  	$my_data = sanitize_text_field( $_POST['google_coordinates'] );
    // Update the meta field in the database.
  	update_post_meta( $post_id, '_centerCoordinates', $my_data );
  }

  if ( ! isset( $_POST['zoom_level'] ) ) {
		return;
	} else {
    // Sanitize user input.
  	$my_data = sanitize_text_field( $_POST['zoom_level'] );
    // Update the meta field in the database.
  	update_post_meta( $post_id, '_zoomLevel', $my_data );
  }

	if ( ! isset( $_POST['point_array'] ) ) {
		return;
	} else {
    // Sanitize user input.
  	$my_data = sanitize_text_field( $_POST['point_array'] );
    // Update the meta field in the database.
  	update_post_meta( $post_id, '_pointArray', $my_data );
  }





}
add_action( 'save_post', 'map_save_meta_box_data' );


///test
?>
