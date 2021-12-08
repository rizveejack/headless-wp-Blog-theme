<?php 

define("HEADLESS_URL","http://localhost:3000");

add_action( 'woocommerce_load_cart_from_session', function () {

	// Bail if there isn't any data
	if ( ! isset( $_GET['session_id'] ) ) {
		return;
	}

	$session_id = sanitize_text_field( $_GET['session_id'] );

	try {

		$handler      = new \WC_Session_Handler();
		$session_data = $handler->get_session( $session_id );

    // We were passed a session ID, yet no session was found. Let's log this and bail.
		if ( empty( $session_data ) ) {
			throw new \Exception( 'Could not locate WooCommerce session on checkout' );
		}

    // Go get the session instance (WC_Session) from the Main WC Class
		$session = WC()->session;

    // Set the session variable
		foreach ( $session_data as $key => $value ) {
			$session->set( $key, unserialize( $value ) );
		}

	} catch ( \Exception $exception ) {
		ErrorHandling::capture( $exception );
	}

} );

add_action( 'woocommerce_checkout_after_customer_details', function () {
	// Bail if there isn't any data
	if ( ! isset( $_GET['session_id'] ) ) {
		return;
	} ?>

	<input
		type="hidden"
		name="headless-session"
		value="<?= esc_attr( $_GET['session_id'] ) ?>"
	/>
	<?php
} );


add_action( 'woocommerce_payment_complete', function () {
	// Bail if there isn't any data
	if ( ! isset( $_POST['headless-session'] ) ) {
		return;
	}

	// Delete the headless session we set on POST during the checkout
	WC()->session->delete_session( sanitize_text_field( $_POST['headless-session'] ) );
} );

add_filter( 'woocommerce_persistent_cart_enabled', '__return_false' );

add_action( 'woocommerce_checkout_update_order_meta', function ( $order_id ) {
	// Bail if there isn't any data
	if ( ! isset( $_POST['headless-session'] ) ) {
		return;
	}

	update_post_meta( $order_id, 'headless-session', sanitize_text_field( $_POST['headless-session'] ) );
} );

add_action( 'woocommerce_thankyou_paypal', function ( $order_id ) {
	$headless_session = get_post_meta( $order_id, 'headless-session', true );

	if ( empty( $headless_session ) ) {
		return;
	}

	// Delete the headless session we set on POST during the checkout
	WC()->session->delete_session( sanitize_text_field( $headless_session ) );

  // Tidy things up so our db doesn't get bloated
  delete_post_meta( $order_id, 'headless-session' );
} );


add_action( 'template_redirect', 'woo_custom_redirect_after_purchase' );
function woo_custom_redirect_after_purchase() {
	global $wp;
	if ( is_checkout() && !empty( $wp->query_vars['order-received'] ) ) {
		wp_redirect( 'http://localhost:3000/thankyou?order_id='.$wp->query_vars['order-received'] );
		exit;
	}
}