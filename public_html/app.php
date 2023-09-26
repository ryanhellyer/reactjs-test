<?php

header( 'Content-Type: application/javascript' );

echo file_get_contents( '../build/app.js' );
die;
