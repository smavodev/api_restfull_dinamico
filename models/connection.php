<?php

class Connection{

    /*===== Información de la base de datos =====*/
	static public function infoDatabase(){
		$infoDB = array(
			"database" => "database-2",
			"user" => "root",
			"pass" => ""
		);
		return $infoDB;
	}

    /*===== Conexión a la base de datos  =====*/
    static public function connect(){
		try{
			$link = new PDO(
				"mysql:host=localhost;dbname=".Connection::infoDatabase()["database"],
				Connection::infoDatabase()["user"], 
				Connection::infoDatabase()["pass"]
			);
			$link->exec("set names utf8");
		}catch(PDOException $e){
			die("Error: ".$e->getMessage());
		}
		return $link;
	}


	/*====== Validar existencia de una tabla en la bd =====*/
	static public function getColumnsData($table, $columns){

		/*====== Traer el nombre de la base de datos =====*/
		$database = Connection::infoDatabase()["database"];

		/*====== Traer todas las columnas de una tabla =====*/
		$validate = Connection::connect()
		->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
		->fetchAll(PDO::FETCH_OBJ);

		/*====== Validamos existencia de la tabla =====*/
		if(empty($validate)){
			return null;
		}else{

			/*====== Ajuste de selección de columnas globales =====*/
			if($columns[0] == "*"){
				array_shift($columns);
			}

			/*====== Validamos existencia de columnas =====*/
			$sum = 0;
				
			foreach ($validate as $key => $value) {
				$sum += in_array($value->item, $columns);			
			}

			return $sum == count($columns) ? $validate : null;

		}

	}

}