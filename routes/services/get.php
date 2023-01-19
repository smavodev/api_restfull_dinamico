
<?php

require_once "controllers/get.controller.php";

/*===== Peticiones GET =====*/
$table = $routesArray[1];
$response = new GetController();
$response -> getData($table);

