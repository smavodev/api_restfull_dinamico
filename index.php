<?php

/*===== Mostrar errores =====*/
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "C:/xampp/htdocs/apirest-dinamica-full/php_error_log");


/*===== Requerimientos =====*/
require_once "controllers/routes.controller.php";

$index = new RoutesController();
$index -> index();