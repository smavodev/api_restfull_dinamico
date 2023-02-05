<?php

require_once "models/post.model.php";
require_once "models/connection.php";

class PostController
{

    /*===== Peticion POST para crear datos =====*/
    static public function postData($table, $data) {

        $response = PostModel::postData($table, $data);

        $return = new PostController();
        $return->fncResponse($response, null);
    }

    /*====== Peticion POST para registrar usuario =====*/
    static public function postRegister($table, $data, $suffix){

        if(isset($data["password_".$suffix]) && $data["password_".$suffix] != null){

            $crypt = crypt($data["password_".$suffix], '$2a$07$azybxcags23425sdg231nd1sm4rt$');

			$data["password_".$suffix] = $crypt;

            $response = PostModel::postData($table, $data);

            $return = new PostController();
            $return -> fncResponse($response, null);

        } 

    }

    /*===== Peticion POST para login de usuario =====*/
	static public function postLogin($table, $data, $suffix){

        /*===== Validar que el usuario exista en BD =====*/
		$response = GetModel::getDataFilter($table, "*", "email_".$suffix, $data["email_".$suffix], null,null,null,null);
		
        if(!empty($response)){

            /*====== Encriptamos la contraseña ======*/
            $crypt = crypt($data["password_".$suffix], '$2a$07$azybxcags23425sdg231nd1sm4rt$');
            
            if($response[0]->{"password_".$suffix} == $crypt){

                /* Creacion del Token de Seguridad */

            } else {
                $response = null;
                $return = new PostController();
                $return -> fncResponse($response, "Wrong password",$suffix);
            }

        } else {
            $response = null;
			$return = new PostController();
			$return -> fncResponse($response, "Wrong email",$suffix);
        }


    }


    /*===== Respuestas del controlador =====*/
    public function fncResponse($response, $error) {

        if (!empty($response)) {

            $json = array(
                'status' => 200,
                'results' => $response
            );

		}else{

			if($error != null){
				$json = array(
					'status' => 400,
					"results" => $error
				);
			}else{

				$json = array(
					'status' => 404,
					'results' => 'Not Found',
					'method' => 'post'
				);
			}

        }

        echo json_encode($json, http_response_code($json["status"]));
    }
}
