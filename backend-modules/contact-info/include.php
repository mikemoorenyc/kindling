<?php
function contactBoxes() {

  function boxAdd($id, $title, $callback) {
    add_meta_box(
      $id,
      $title,
      $callback,
      'contacts',
      'normal'
    );
  }
  $contactMeta = array(
    array(
      'id' => 'contact_address',
      'title' => 'Address',
      'callback' => 'address_box_callback'
    ),
    array(
      'id' => 'contact_telephone',
      'title' => 'Telephone',
      'callback' => 'telephone_box_callback'
    ),
    array(
      'id' => 'contact_email',
      'title' => 'Email',
      'callback' => 'email_box_callback'
    )
  );
  foreach($contactMeta as $cm) {
    boxAdd($cm['id'], $cm['title'], $cm['callback']);
  }


}
add_action( 'add_meta_boxes', 'contactBoxes' );
function address_box_callback( $post ) {
	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'contact_address', 'contact_address_nonce' );
  ?>
  <textarea id="contact_address" style="display:block; width: 100%; height: 200px;"><?php echo get_post_meta($post->ID, 'contact_address', true);?></textarea>
  <?php
}
function telephone_box_callback( $post ) {
	wp_nonce_field( 'contact_telephone', 'contact_telephone_nonce' );
  ?>
  <input type="tel" id="contact_telephone" style="display:block; width:100%;"/>
  <?php
}
function email_box_callback( $post ) {
	wp_nonce_field( 'contact_email', 'contact_email_nonce' );
  ?>
  <input type="email" id="contact_email" style="display:block; width:100%;"/>
  <?php
}
?>
<?php
///SAVE FUNCTIONS

function save_contact_data( $post_id ) {
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */
	// Check if our nonce is set.
  $toSave = array('address', 'telephone', 'email');
  if(!function_exists('contact_saver')) {
    function contact_saver($section) {
      if ( ! isset( $_POST['contact_'.$section.'_nonce'] ) ) {
    		return;
    	}
      if ( ! wp_verify_nonce( $_POST['contact_'.$section.'_nonce'], 'contact_'.$section ) ) {
    		return;
    	}
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    		return;
    	}
      if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    		if ( ! current_user_can( 'edit_page', $post_id ) ) {
    			return;
    		}
    	} else {
    		if ( ! current_user_can( 'edit_post', $post_id ) ) {
    			return;
    		}
    	}
      if ( ! isset( $_POST['contact_'.$section] ) ) {
    		return;
    	} else {
        // Sanitize user input.
      	$my_data = sanitize_text_field( $_POST['contact_'.$section] );
        // Update the meta field in the database.
      	update_post_meta( $post_id, 'contact_'.$section, $my_data );
      }
    }
  }

  foreach($toSave as $ts) {
    contact_saver($ts);
  }


	// Verify that the nonce is valid.

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.

	// Check the user's permissions.

  //SAVE FILE INFO

}
add_action( 'save_post', 'save_contact_data' );

 ?>
