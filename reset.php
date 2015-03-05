<?php
require_once('incluidos/funciones.php');

$resetid = filter_input(INPUT_GET, 'resetid');

$user = filter_input(INPUT_GET, 'user');

try {
    require_once('incluidos/connectdb.php');

    $db = connect_db();

    $q2 = "UPDATE usuarios SET com_code=NULL, password=NULL, estado=0 WHERE com_code=?";

    $stm2 = $db->prepare($q2);

    $stm2->bindParam(1, $resetid);

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
    echo "<div>Se ha reseteado tu contraseña. Ahora puedes definir una nueva contraseña</div><br>";
    ?>
    <link href="css/setpass.css" rel="stylesheet" type="text/css" />
    <form id="formpass" accept-charset="UTF-8" id="form" action="setpass.php" method="post" >
        <li>
    	<label for="pass">Password:</label>
    	<input type="password" name="pass" placeholder="Contraseña" id="pass" size="33" required/>
        </li>				           
        <li>
    	<label for="pass2">Confirmar Password:</label>
    	<input type="password" name="pass2" placeholder="Confirmar Contraseña" id="pass2" size="33" required/>
        </li>
        <li>
    	<input type="hidden" name="user" id="user" value="<?php echo $user; ?>" size="33" />
        </li>
        <li><br>
    	<input id="gobutton" type="submit" value="Go!"> 
        </li>
    </ul>
    </form>
    <?php
} else {
    echo "Ha ocurrido un error.";
}
?>

