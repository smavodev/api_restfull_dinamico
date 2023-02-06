<?php

/*===== Mostrar errores =====*/
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log",  "C:/xampp/htdocs/apirest-dinamica-full/php_error_log");



/*======= CORS ======*/
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');


/*===== Requerimientos =====*/
/* require_once "models/conection.php";
echo '<pre>'; print_r(Connection::infoDatabase()); echo '</pre>';
echo '<pre>'; print_r(Connection::infoDatabase()["database"]); echo '</pre>';
echo '<pre>'; print_r(Connection::connect()); echo '</pre>'; */

require_once "controllers/routes.controller.php";

$index = new RoutesController();
$index -> index();