<?php

require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

$user = filter_input(INPUT_POST, 'user');

$nombre = filter_input(INPUT_POST, 'nombre');

$apellido = filter_input(INPUT_POST, 'apellido');

$sexo = filter_input(INPUT_POST, 'sexo');

$mail = filter_input(INPUT_POST, 'mail');

$iduser = $_SESSION['userid'];

try {

    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q = "UPDATE `rdg`.`usuarios` SET `user`=?, `nombre`=?, `apellido`=?, `mail`=?, `sexo`=? WHERE `id_user`= ?;";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $user);

    $stm->bindParam(2, $nombre);

    $stm->bindParam(3, $apellido);

    $stm->bindParam(4, $mail);
    
    $stm->bindParam(5, $sexo);

    $stm->bindParam(6, $iduser);

    $status = $stm->execute();

    if ($status) {
	echo "<script>window.location.assign('perfil.php');</script>";
    } else {
	echo "<script>alert('Ha ocurrido un error, intente nuevamente.');window.location.assign('perfil.php');</script>";
	die();
    }
} catch (Exception $e) {
    // Proccess error
    $msg = $e->getMessage();
    $timestamp = date("Y-m-d H:i:s");
    $line = $e->getLine();
    $code = $e->getCode();

    handle_error($msg, $timestamp, $line, $code);
    die("oops! Parece que tenemos un error! Intente nuevamente!");
}