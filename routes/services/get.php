
<?php

require_once "controllers/get.controller.php";

$table = explode("?",$routesArray[1])[0]; /* me trae el primer indice (nombre de la tabla) */

$select = $_GET["select"] ?? "*";

/*===== Peticiones GET =====*/
$response = new GetController();
$response -> getData($table, $select);

