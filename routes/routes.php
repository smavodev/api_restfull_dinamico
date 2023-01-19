<?php


$routesArray = explode("/", $_SERVER['REQUEST_URI']); /* obtener el dato que se envia en el indice  */
$routesArray = array_filter($routesArray); /* Filtro para obtener el indice*/

/*===== Cuando no se hace ninguna petición a la API =====*/
if (count($routesArray) == 0) {
    $json = array(
        'status' => 404,
		'results' => 'Not Found'
    );

	echo json_encode($json, http_response_code($json["status"]));

    return;
}


/*===== Cuando Si se hace ninguna petición a la API =====*/
if(count($routesArray) == 1 && isset($_SERVER['REQUEST_METHOD'])){

    /*===== Peticiones GET =====*/
	if($_SERVER['REQUEST_METHOD'] == "GET"){
        
        include "services/get.php";

	}

	/*===== Peticiones POST =====*/
	if($_SERVER['REQUEST_METHOD'] == "POST"){

        $json = array(
            'status' => 200,
            'results' => 'Solicitud POST'
        );

        echo json_encode($json, http_response_code($json["status"]));
	}

	/*===== Peticiones PUT =====*/
	if($_SERVER['REQUEST_METHOD'] == "PUT"){

        $json = array(
            'status' => 200,
            'results' => 'Solicitud PUT'
        );

		echo json_encode($json, http_response_code($json["status"]));
	}

	/*===== Peticiones DELETE =====*/
	if($_SERVER['REQUEST_METHOD'] == "DELETE"){

        $json = array(
            'status' => 200,
            'results' => 'Solicitud DELETE'
        );

		echo json_encode($json, http_response_code($json["status"]));
	}

}