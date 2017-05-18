<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 18.05.2017
 * Time: 10:46
 */

const POST_PARAM_KEY = 'key';
const CONFIG_KEY     = 'key';
const CONFIG_COMMAND = 'command';

// Get ENV-Vars
$configFile = getenv( 'CONFIG_FILE' );

// Read config file
$configContent = file_get_contents( $configFile );
$configJson    = json_decode( $configContent, true );

// Check post-param
if ( ! isset( $_POST[ POST_PARAM_KEY ] ) || trim( $_POST[ POST_PARAM_KEY ] ) === '' ) {
	http_response_code( 400 );
	die( 'ONLY POST PARAM: "key"' );
}

// Find task
$taskKey = trim( $_POST[ POST_PARAM_KEY ] );
$command = null;
foreach ( $configJson as $task ) {
	if ( $task[ CONFIG_KEY ] === $taskKey ) {
		$command = $task[ CONFIG_COMMAND ];
	}
}

// Key not found in config
if ( $command === null ) {
	http_response_code( 401 );
	die( 'WRONG KEY' );
}

// Execute command
shell_exec( $command );
