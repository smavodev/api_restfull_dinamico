<?php

require_once "connection.php";

class GetModel {

    /*===== Peticiones GET sin filtro =====*/
    static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){

        /*===== Peticiones GET - Sin Ordenar Datos - Sin Limitar Datos =====*/
        $sql = "SELECT $select FROM $table ";

        /*===== Peticiones GET + Ordenar Datos - Sin Limitar Datos =====*/
        if ($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        /*===== Peticiones GET + Ordenar Datos + Limitar de datos =====*/
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
        }

        /*===== Peticiones GET - Sin Ordenar Datos + Limitar Datos =====*/
        if ($orderBy == null && $orderMode == null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table LIMIT $startAt, $endAt";
        }

        $stmt = Connection::connect()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS); /* para nos mostrar los indices agregar: PDO::FETCH_CLASS */
    }


    /*===== Peticiones GET con filtro =====*/
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode(",", $equalTo);
        $linkToText = "";

        if (count($linkToArray) > 1) {

            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToText .= "AND " . $value . " = :" . $value . " ";
                }
            }
        }

         /*===== Peticiones GET + Filtro - Sin Ordenar Datos - Sin Limitar Datos =====*/
        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ";

        /*===== Peticiones GET + Filtro + Ordenar Datos - Sin Limitar Datos =====*/
        if ($orderBy != null && $orderMode != null && $startAt == null && $endAt == null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }

        /*===== Peticiones GET + Filtro + Ordenar Datos + Limitar de datos =====*/
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
        }

        /*===== Peticiones GET + Filtro - Sin Ordenar Datos + Limitar Datos =====*/
        if ($orderBy != null && $orderMode != null && $startAt != null && $endAt != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt";
        }

        $stmt = Connection::connect()->prepare($sql);

        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /*===== Peticiones GET sin filtro entre tablas relacionadas =====*/
    static public function getRelData($rel, $type, $select, $orderBy,$orderMode,$startAt,$endAt){

		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);
		$innerJoinText = "";


        if(count($relArray)>1){

			foreach ($relArray as $key => $value) {

				if($key > 0){
					$innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
				}

			}

            /*===== Peticiones GET - Sin Ordenar Datos - Sin Limitar Datos =====*/
            $sql = "SELECT $select FROM $relArray[0] $innerJoinText ";

            /*===== Peticiones GET + Ordenar Datos - Sin Limitar Datos =====*/
			if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode";
			}

            /*===== Peticiones GET + Ordenar Datos + Limitar de datos =====*/
			if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
			}

            /*===== Peticiones GET - Sin Ordenar Datos + Limitar Datos =====*/
			if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText LIMIT $startAt, $endAt";
			}


            $stmt = Connection::connect()->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

		} else{

			return null;
		}
    
    }


    /*===== Peticiones GET con filtro entre tablas relacionadas =====*/
	static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy,$orderMode,$startAt,$endAt){

		/*===== Organizamos los filtros =====*/
		$linkToArray = explode(",",$linkTo);
		$equalToArray = explode(",",$equalTo);
		$linkToText = "";

		if(count($linkToArray)>1){

			foreach ($linkToArray as $key => $value) {

				if($key > 0){
					$linkToText .= "AND ".$value." = :".$value." ";
				}
			}

		}

		/*===== Organizamos las relaciones =====*/
		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);
		$innerJoinText = "";

		if(count($relArray)>1){

			foreach ($relArray as $key => $value) {

				if($key > 0){
					$innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
				}
			}

            /*===== Peticiones GET con filtro - Sin Ordenar Datos - Sin Limitar Datos =====*/
			$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";


            /*===== Peticiones GET con filtro + Ordenar Datos - Sin Limitar Datos =====*/
			if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){

				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";

			}

            /*===== Peticiones GET con filtro + Ordenar Datos + Limitar de datos =====*/
			if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){

				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";

			}

            /*===== Peticiones GET con filtro - Sin Ordenar Datos + Limitar Datos =====*/
			if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){

				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt, $endAt";

			}

			$stmt = Connection::connect()->prepare($sql);

			foreach ($linkToArray as $key => $value) {
			
				$stmt -> bindParam(":".$value, $equalToArray[$key], PDO::PARAM_STR);

			}

			try{
				$stmt -> execute();
			}catch(PDOException $Exception){
				return null;
			}

			return $stmt -> fetchAll(PDO::FETCH_CLASS);

		}else{
			return null;
		}
		
	}


    /*===== Peticiones GET para el buscador sin tablas relaciones =====*/
	static public function getDataSearch($table, $select, $linkTo, $search,$orderBy,$orderMode,$startAt,$endAt){
   
		$linkToArray = explode(",",$linkTo);
		$searchArray = explode(",",$search);
        $linkToText= "";
		
        if(count($linkToArray)>1){

			foreach ($linkToArray as $key => $value) {
				
				if($key > 0){

					$linkToText .= "AND ".$value." = :".$value." ";
				}
			}

		}

        /*===== Peticiones GET para el buscador sin filtro - Sin Ordenar Datos - Sin Limitar Datos =====*/
		$sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText";


        /*===== Peticiones GET para el buscador sin filtro + Ordenar Datos - Sin Limitar Datos =====*/
        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
			$sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText ORDER BY $orderBy $orderMode";
		}


        /*===== Peticiones GET para el buscador sin filtro + Ordenar Datos + Limitar de datos =====*/
        if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
			$sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
		}


        /*===== Peticiones GET para el buscador sin filtro - Sin Ordenar Datos + Limitar Datos =====*/
        if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
			$sql = "SELECT $select FROM $table WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText LIMIT $startAt, $endAt";
		}


		$stmt = Connection::connect()->prepare($sql);

		foreach ($linkToArray as $key => $value) {

			if($key > 0){
				$stmt -> bindParam(":".$value, $searchArray[$key], PDO::PARAM_STR);
			}

		}
		try{
			$stmt -> execute();
		}catch(PDOException $Exception){
			return null;
		}

		return $stmt -> fetchAll(PDO::FETCH_CLASS);


    }


    /*===== Peticiones GET para el buscador con tablas relaciones =====*/
	static public function getRelDataSearch($rel, $type, $select, $linkTo, $search, $orderBy,$orderMode,$startAt,$endAt){


		/*===== Organizamos los filtros =====*/
		$linkToArray = explode(",",$linkTo);
		$searchArray = explode(",",$search);
		$linkToText = "";

		if(count($linkToArray)>1){

			foreach ($linkToArray as $key => $value) {
				
				if($key > 0){

					$linkToText .= "AND ".$value." = :".$value." ";
				}
			}

		}
	
		/*===== Organizamos las relaciones =====*/
		$relArray = explode(",", $rel);
		$typeArray = explode(",", $type);
		$innerJoinText = "";

		if(count($relArray)>1){

			foreach ($relArray as $key => $value) {

				if($key > 0){

					$innerJoinText .= "INNER JOIN ".$value." ON ".$relArray[0].".id_".$typeArray[$key]."_".$typeArray[0] ." = ".$value.".id_".$typeArray[$key]." ";
				}
			}


            /*===== Peticiones GET para el buscador con filtro - Sin Ordenar Datos - Sin Limitar Datos =====*/
			$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText";


            /*===== Peticiones GET para el buscador con filtro + Ordenar Datos - Sin Limitar Datos =====*/
			if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText ORDER BY $orderBy $orderMode";
			}


            /*===== Peticiones GET para el buscador con filtro + Ordenar Datos + Limitar de datos =====*/
			if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";
			}


            /*===== Peticiones GET para el buscador con filtro - Sin Ordenar Datos + Limitar Datos =====*/
			if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
				$sql = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] LIKE '%$searchArray[0]%' $linkToText LIMIT $startAt, $endAt";
			}

			$stmt = Connection::connect()->prepare($sql);

			foreach ($linkToArray as $key => $value) {

				if($key > 0){
					$stmt -> bindParam(":".$value, $searchArray[$key], PDO::PARAM_STR);
				}

			}

			try{
				$stmt -> execute();
			}catch(PDOException $Exception){
				return null;
			}

			return $stmt -> fetchAll(PDO::FETCH_CLASS);

		}else{
			return null;
		}
		
	}

    /*===== Peticiones GET para la seleccion de rangos sin tablas relaciones =====*/
	static public function getDataRange($table,$select,$linkTo,$between1,$between2,$orderBy,$orderMode,$startAt,$endAt){
        
         /*===== Peticiones GET para la seleccion de rangos sin filtro - Sin Ordenar Datos - Sin Limitar Datos =====*/
		$sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2' ";

	
        /*===== Peticiones GET para la seleccion de rangos sin filtro + Ordenar Datos - Sin Limitar Datos =====*/
		if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){

			$sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2'  ORDER BY $orderBy $orderMode";

		}

		
        /*===== Peticiones GET para la seleccion de rangos sin filtro + Ordenar Datos + Limitar de datos =====*/
		if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){

			$sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2'  ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt";

		}


        /*===== Peticiones GET para la seleccion de rangos sin filtro - Sin Ordenar Datos + Limitar Datos =====*/
		if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){

			$sql = "SELECT $select FROM $table WHERE $linkTo BETWEEN '$between1' AND '$between2'  LIMIT $startAt, $endAt";

		}


		$stmt = Connection::connect()->prepare($sql);

		try{
			$stmt -> execute();
		}catch(PDOException $Exception){
			return null;
		}

		return $stmt -> fetchAll(PDO::FETCH_CLASS);
    }


}
