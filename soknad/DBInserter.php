<?php
include_once '../include_login/DBController.php';
class DBInserter {

    function insertFornavn($navn,$fodsel,$adresse,$city,$postkode,$telefon,$email, $bil,$norskferd,$dataferd) {
        $pdo = new DBController();
        try {
            $query = "INSERT INTO soknad(navn, fodselnr, adresse, city, postkode, telefon, email, bil, norskferd, dataferd)
                  VALUES(:navn, :fodsel, :adresse,:city, :postkode, :telefon, :email, :bil, :norskferd, :dataferd)";

            $param_value_array = array(':navn'=> $navn, ':fodsel'=> $fodsel , ':adresse'=> $adresse,':city'=>$city, ':postkode' => $postkode, ':telefon' => $telefon,
                ':email' => $email,':bil'=>$bil, ':norskferd' => $norskferd, ':dataferd' => $dataferd);
            $pdo->insert($query, $param_value_array);

            return true;
        } catch(PDOException $exception) {
            return false;
        }
    }
}
