<?php

// error reporting on
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// autoload
include("../vendor/autoload.php");

// encoding key
define("ENCODING_KEY", "This is my key");
$session = \ClientSessionState\ClientSession::instance();
$session->setEncodingKey(ENCODING_KEY);