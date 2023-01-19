<?php


$routesArray = explode("/", $_SERVER['REQUEST_URI']); /* obtener el dato que se envia en el indice  */
$routesArray = array_filter($routesArray); /* Filtro para obtener un indice*/

/*===== Cuando no se hace ninguna petición a la API =====*/
if (count($routesArray) == 0) {
    $json = array(
        'status' => 404,
		'results' => 'Not Found'
    );

	echo json_encode($json, http_response_code($json["status"]));

    return;
}

