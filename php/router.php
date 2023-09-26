<?php
declare( strict_types=1 );

/**
 * Get current path and list of possible routes.
 */
$uri      = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );
$uri_path = parse_url($uri, PHP_URL_PATH);
$routes   = [
	'/'       => 'home.php',
	'/app.js' => 'app.php',
];


// Simple routing logic
if ( array_key_exists( $uri_path, $routes ) ) {
	$path = dirname( __FILE__ ) . '/' . $routes[ $uri_path ];
	if ( file_exists( $path ) ) {
		$extension = pathinfo( $uri_path, PATHINFO_EXTENSION );
		if ( 'js' === $extension ) {
			header( 'Content-Type: application/javascript' );
		} else if ( 'css' === $extension ) {
			header( 'Content-Type: text/css' );
		} else {
			header( 'HTTP/1.1 200 OK' );
		}

		require( $path );
	}
} else {
	// Trigger 404.
	header( 'HTTP/1.0 404 Not Found' );
	echo 'Error: Not found';
}
