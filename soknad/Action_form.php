<?php
require_once'DBInserter.php';


$pdo = new DBInserter();

$navn = $_POST['navn'];
$fodsel = $_POST['fodsel'];
$adresse = $_POST['adresse'];
$city = $_POST['city'];
$postkode = $_POST['postkode'];
$telefon = $_POST['telefon'];
$email = $_POST['email'];
$bil = $_POST['bil'];
$norskferd = $_POST['norskferd'];
$dataferd = $_POST['dataferd'];

$insertSuccess = $pdo->insertFornavn($navn,$fodsel,$adresse,$city,$postkode,$telefon,$email,$bil,$norskferd,$dataferd);

if ($insertSuccess) {
    setcookie("message", 'Søknaden er sendt.', time()+10, '/');
    header('Location: soknad.php');
} else {
    setcookie("message", 'Noe gikk galt med søknaden.', time()+10, '/');
    header('Location: ../');
}