<?php
include_once '../include_login/DBController.php';

class DBOversikt {

    function stemmestedOversikt() {
        $pdo = new DBController();
        $query = "SELECT * FROM stemmesteder";
        $stemmeSted = $pdo->runBaseQuery($query);

        return $stemmeSted;
    }

    function ansattOversikt() {
        $pdo = new DBController();
        $query = "SELECT * FROM ansatt";
        $ansatt = $pdo->runBaseQuery($query);

        return $ansatt;
    }
}