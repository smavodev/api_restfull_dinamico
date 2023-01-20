
<?php

require_once "controllers/get.controller.php";

$table = explode("?",$routesArray[1])[0]; /* me trae el primer indice (nombre de la tabla) */

$select = $_GET["select"] ?? "*";

$response = new GetController();


/*===== Peticiones GET con filtro =====*/
if(isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {

    $response -> getDataFilter($table, $select, $_GET["linkTo"], $_GET["equalTo"]);

} else {

    /*===== Peticiones GET sin filtro =====*/
    $response -> getData($table, $select);

}

