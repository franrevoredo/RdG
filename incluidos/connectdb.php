<?php   

include_once('./incluidos/funciones.php');

function connect_db()
{
    try
    {
        $connection = new PDO('mysql:host=localhost;dbname=rdg;mysql:charset=utf8mb4', 'root', '');
        $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_PERSISTENT, true);
        $connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
    }
    catch (PDOException $e)
    {
        // Proccess error
	    $msg = $e->getMessage();
	    $timestamp = date("Y-m-d H:i:s");
	    $line = $e->getLine();
	    $code = $e->getCode();

	    handle_error($msg, $timestamp, $line, $code);
	    die("oops! It's look like we got an error here! Try Again!");
    }

    return $connection;
}

?>