<?php

require_once "connection.php";

class GetModel
{

    /*===== Peticiones GET sin filtro =====*/
    static public function getData($table, $select, $orderBy, $orderMode){


        $sql = "SELECT $select FROM $table ";

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        $stmt = Connection::connect()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS); /* para nos mostrar los indices agregar: PDO::FETCH_CLASS */
    }

    /*===== Peticiones GET con filtro =====*/
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode){

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

        $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ";

        if ($orderBy != null && $orderMode != null) {
            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }

        $stmt = Connection::connect()->prepare($sql);

        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}
