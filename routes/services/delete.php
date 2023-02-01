<?php

require_once "models/connection.php";
require_once "controllers/delete.controller.php";

if(isset($_GET["id"]) && isset($_GET["nameId"])){

    $columns = array($_GET["nameId"]);

	/*====== Validar la tabla y las columnas =====*/
	if(empty(Connection::getColumnsData($table, $columns))){

		$json = array(
		 	'status' => 400,
		 	'results' => "Error: Fields in the form do not match the database"
		);

		echo json_encode($json, http_response_code($json["status"]));

		return;

	}

    $response = new DeleteController();
    $response -> deleteData($table,$_GET["id"],$_GET["nameId"]);


}