<?php
session_start();
if(isset($_SESSION['userid'])){
session_destroy();
setcookie(session_name(), "", time() - 3600, "/");
header("Location: index.php");
} else {
    echo "<script type='text/javascript'>alert('No hay ninguna sesión abierta!'); history.back();</script>";
    die();
}