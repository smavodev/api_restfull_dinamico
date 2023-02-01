<?php

require_once "models/post.model.php";
require_once "models/connection.php";

class PostController
{

    /*===== Peticion POST para crear datos =====*/
    static public function postData($table, $data)
    {

        $response = PostModel::postData($table, $data);

        $return = new PostController();
        $return->fncResponse($response);
    }


    /*===== Respuestas del controlador =====*/
    public function fncResponse($response)
    {

        if (!empty($response)) {

            $json = array(
                'status' => 200,
                'results' => $response
            );
        } else {


            $json = array(

                'status' => 404,
                'results' => 'Not Found',
                'method' => 'post'

            );
        }

        echo json_encode($json, http_response_code($json["status"]));
    }
}
