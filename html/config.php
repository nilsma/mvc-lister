<?php

/**
 * PHP configuration
 * Enable error reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Charset settings
 * specifically used for html() function in the utils class
 */
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | 'UTF-8');

?>
