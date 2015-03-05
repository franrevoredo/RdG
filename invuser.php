<?php
require_once('incluidos/funciones.php');
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}

require_once('incluidos/connectdb.php');

$id_grupo = filter_input(INPUT_GET, 'id');

$userid = $_SESSION['userid'];

$db = connect_db();

try {
    $q = "SELECT `nombre` FROM `rdg`.`grupos` WHERE (`id_grupo` = ? AND `owner` = ?);";

    $stm = $db->prepare($q);

    $stm->bindParam(1, $id_grupo);

    $stm->bindParam(2, $userid);

    $status = $stm->execute();

    if ($stm->rowCount() == 1) {

	$row = $stm->fetch();

	$nom_grupo = $row['nombre'];

	echo "<h3>Sitema de invitación para el grupo $nom_grupo.</h3>";
	?>






	<form accept-charset="UTF-8" id="form" action="go_inv.php" method="post" >
	    <label for="Usuario">Usuario:</label>
	    <select name="usuario" required>
		<?php



		    $q = "SELECT `id_user`, `mail` FROM `usuarios` WHERE `estado` = 1";

		    $stm = $db->prepare($q);

		    $status = $stm->execute();

		    if ($stm->rowCount() > 0) {

			while ($row = $stm->fetch()) {

			    $id_user = $row['id_user'];
			    $mail = $row['mail'];
			    echo "<option value='$id_user'>$mail</option>";
			}
		    }
		
		?>

	    </select>
	    <input type="hidden" id="idgrupo" name="idgrupo" value="<?php echo $id_grupo ?>">
	    <input id="gobutton" type="submit" value="Go!"> 
	</form>


	<?php
    } else {
	echo "<script>alert('Usted no es dueño del grupo, no puede realizar invitaciones.');window.location.assign('groupdetail.php?id=$id_grupo');</script>";
	die();
    }
    echo "<br><a href='groupdetail.php?id=$id_grupo'>Volver</a>";
} catch (Exception $e) {
    // Proccess error
    $msg = $e->getMessage();
    $timestamp = date("Y-m-d H:i:s");
    $line = $e->getLine();
    $code = $e->getCode();

    handle_error($msg, $timestamp, $line, $code);
    die("oops! Parece que tenemos un error! Intente nuevamente!");
}
