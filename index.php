<?php
/**
 * User: Alexander Eimer <github.com/aeimer>
 * Date: 18.05.2017
 */

// Constants
const POST_PARAM_KEY = 'key';
const CONFIG_KEY     = 'key';
const CONFIG_COMMAND = 'command';
const ENV_CONF_FILE  = 'CONFIG_FILE';
const ENV_LOG_FILE   = 'LOG_FILE';

// Print two new lines for prettier output with curl
echo "\xA\xA";

// Get ENV-Vars
$configFile    = getenv( ENV_CONF_FILE );
$configLogFile = getenv( ENV_LOG_FILE );

// Init Logger
$logFile = null;
// Commeting this out, not needed currently
// if ( $configLogFile !== null && is_string( $configLogFile ) && strlen( $configLogFile ) > 0 ) {
//	$logFile = $configLogFile;
// }
$log = new Logger( $logFile );
// $log->log( 'Logger initialised' );
// $ip = getenv( 'HTTP_CLIENT_IP' ) ?:
// 	getenv( 'HTTP_X_FORWARDED_FOR' ) ?:
// 		getenv( 'HTTP_X_FORWARDED' ) ?:
// 			getenv( 'HTTP_FORWARDED_FOR' ) ?:
// 				getenv( 'HTTP_FORWARDED' ) ?:
// 					getenv( 'REMOTE_ADDR' );
// $log->log( '+ Request from IP ' . $ip . ' at ' . date('d.m.Y H:i:s'));

// Read config file
$configContent = file_get_contents( $configFile );
$configJson    = json_decode( $configContent, true );

// Check if config file was loaded successfully
if ( ! $configFile || ! $configContent || $configJson === null ) {
	$log->log( '+ ERR: CONFIG_FILE_NOT_FOUND' );
	http_response_code( 500 );
	die( 'CONFIG_FILE_NOT_FOUND' );
}

// Check config
$tasks = [];
foreach ( $configJson['config'] as $task ) {
	if ( array_key_exists( $task[ CONFIG_KEY ], $tasks ) ) {
		// Check if no duplicate keys exist
		$log->log( '+ ERR: DUPLICATE_KEY_ERROR' );
		http_response_code( 500 );
		die( 'DUPLICATE_KEY_ERROR' );
	} elseif ( strlen( $task[ CONFIG_KEY ] ) < 10 ) {
		// Check if the key is long enough
		$log->log( '+ ERR: KEY_TOO_SHORT_ERROR' );
		http_response_code( 500 );
		die( 'KEY_TOO_SHORT_ERROR' );
	}
	$tasks[ $task[ CONFIG_KEY ] ] = $task[ CONFIG_COMMAND ];
}

// Check post-param
if ( ! isset( $_POST[ POST_PARAM_KEY ] ) || $_POST[ POST_PARAM_KEY ] === '' ) {
	$log->log( '+ ERR: PARAMETER_KEY_NOT_FOUND' );
	http_response_code( 400 );
	die( 'PARAMETER_KEY_NOT_FOUND' );
}
$taskKey = $_POST[ POST_PARAM_KEY ];

// Key not found in config
if ( ! key_exists( $taskKey, $tasks ) ) {
	$log->log( '+ ERR: WRONG KEY' );
	http_response_code( 401 );
	die( 'WRONG KEY' );
}

// Execute command
// The 2>&1 pipes the stderr stream to stdout, so we can see if there's an error
$shellReturn = shell_exec( $tasks[ $taskKey ] . ' 2>&1' );
echo $shellReturn;
$log->log( "+ SHELL RETURN:\n" . $shellReturn );

$log->log( '+ SUCCESSFUL ENDED' );


// Logger class for simpler logging
class Logger {
	private $logFile;

	function __construct( string $logFile = null ) {
		$this->logFile = $logFile;
	}

	public function log( string $msg ) {
		// Write to standard php error log
		error_log( $msg );

		// Write to specific file
		if ( $this->logFile !== null ) {
			error_log( $msg . "\n", 3, $this->logFile );
		}
	}
}
