<?php
declare( strict_types=1 );

$files = glob( '/var/www/dev-react.com/build/static/js/main.*.js' );
if ( count( $files ) > 0 ) {
	$file = $files[0];

	$js = file_get_contents( $file );
	$js = explode( '//# sourceMappingURL=', $js );
	$js = $js[0];
	echo $js;
}
