<?php
declare( strict_types=1 );

/**
 * Sanitise and retrieve the current URI from server globals.
 */
$uri      = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL );
$uri_path = parse_url($uri, PHP_URL_PATH);

/**
 * Define possible routes and their corresponding files.
 */
$routes   = [
	'/'       => 'home.php',
	'/app.js' => 'app.php',
];

/**
 * Define MIME types for supported file extensions.
 */
$mime_types = [
	'js'    => 'application/javascript',
	'css'   => 'text/css',
	'html'  => 'text/html',
];

/**
 * Initialise the $path variable for use later.
 */
$path = '';

/**
 * Main Routing Logic
 */
if ( array_key_exists( $uri_path, $routes ) ) {

	// Construct the full path to the file.
	$path = dirname( __FILE__ ) . '/' . $routes[ $uri_path ];

	// Check if the file exists.
	if ( file_exists( $path ) ) {

		// Extract file extension to determine MIME type.
		$extension = pathinfo( $uri_path, PATHINFO_EXTENSION );

		// Set Content-Type header based on MIME type or default to HTML.
        header( 'Content-Type: ' . $mime_types[$extension] ?? $mime_types['html'] );

		// Set HTTP status.
		header( 'HTTP/1.1 200 OK' );
	}
}

/**
 * Handle 404 Not Found Case.
 */
if ( empty( $path ) ) {
	// Build the full path to the 404 script.
	$path = dirname( __FILE__ ) . '/404.php';

	// Set HTTP status.
	header( 'HTTP/1.0 404 Not Found' );	
}

/**
 * Include the PHP file.
 */
require $path;
