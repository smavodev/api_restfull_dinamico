<?php

require_once "connection.php";

class GetModel {

    /*===== Peticiones GET sin filtro =====*/
    static public function getData($table, $select) {

        $sql = "SELECT $select FROM $table";
        $stmt = Connection::connect()->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS); /* para nos mostrar los indices agregar: PDO::FETCH_CLASS */
    }

    /*===== Peticiones GET con filtro =====*/
    static public function getDataFilter($table, $select, $linkTo, $equalTo){
        $sql = "SELECT $select FROM $table WHERE $linkTo = :$linkTo  ";
        $stmt = Connection::connect()->prepare($sql);
        $stmt -> bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_CLASS);
    }

}
