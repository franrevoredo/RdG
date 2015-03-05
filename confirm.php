<?php

require_once('incluidos/funciones.php');

$passkey = filter_input(INPUT_GET, 'passkey');

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q2 = "UPDATE usuarios SET com_code=NULL WHERE com_code=?";

    $stm2 = $db->prepare($q2);

    $stm2->bindParam(1, $passkey);

    $status2 = $stm2->execute();
} catch (Exception $e) {
    // Proccess error
    $msg = $e->getMessage();
    $timestamp = date("Y-m-d H:i:s");
    $line = $e->getLine();
    $code = $e->getCode();

    handle_error($msg, $timestamp, $line, $code);
    die("oops! Parece que tenemos un error! Intente nuevamente!");
}

if ($status2) {
    echo '<div>Tu cuenta ahora está activa. Ahora puedes <a href="login.php">Logear</a></div>';
} else {
    echo "Ha ocurrido un error.";
}
?>