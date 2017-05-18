<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 18.05.2017
 * Time: 10:46
 */

// Constants
const POST_PARAM_KEY = 'key';
const CONFIG_KEY     = 'key';
const CONFIG_COMMAND = 'command';
const ENV_CONF_FILE  = 'CONFIG_FILE';

// Get ENV-Vars
$configFile = getenv( ENV_CONF_FILE );

// Read config file
$configContent = file_get_contents( $configFile );
$configJson    = json_decode( $configContent, true );

// Check if config file was loaded successfully
if ( ! $configFile || ! $configContent || $configJson === NULL) {
	http_response_code( 500 );
	die( 'CONFIG_FILE_NOT_FOUND' );
}

// Check config
$tasks = [];
foreach ( $configJson['config'] as $task ) {
	if ( array_key_exists( $task[ CONFIG_KEY ], $tasks ) ) {
		// Check if no duplicate keys exist
		http_response_code( 500 );
		die( 'DUPLICATE_KEY_ERROR' );
	} elseif ( strlen( $task[ CONFIG_KEY ] ) < 10 ) {
		// Check if the key is long enough
		http_response_code( 500 );
		die( 'KEY_TOO_SHORT_ERROR' );
	}
	$tasks[ $task[ CONFIG_KEY ] ] = $task[ CONFIG_COMMAND ];
}

// Check post-param
if ( ! isset( $_POST[ POST_PARAM_KEY ] ) || $_POST[ POST_PARAM_KEY ] === '' ) {
	http_response_code( 400 );
	die( 'PARAMETER_KEY_NOT_FOUND' );
}
$taskKey = $_POST[ POST_PARAM_KEY ];

// Key not found in config
if ( ! key_exists( $taskKey, $tasks ) ) {
	http_response_code( 401 );
	die( 'WRONG KEY' );
}

// Execute command
echo shell_exec( $tasks[ $taskKey ] );
