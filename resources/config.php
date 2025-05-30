<?php

ob_start();
session_start();
//session_destroy();

defined("DS") ? null : define("DS",DIRECTORY_SEPARATOR);

defined("Template_frontend") ? null : define("Template_frontend", __DIR__ . DS . "templates/frontend");
defined("Template_backend") ? null : define("Template_backend", __DIR__ . DS . "templates/backend");
//echo __DIR__;

defined("DB_HOST") ? null : define("DB_HOST","localhost");
defined("DB_USER") ? null : define("DB_USER","root");
defined("DB_PASS") ? null : define("DB_PASS","");
defined("DB_NAME") ? null : define("DB_NAME","ecom_db");

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
require_once("functions.php");
require_once("cart.php");


?>