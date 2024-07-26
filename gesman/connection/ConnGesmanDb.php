<?php
//$hostname = '192.168.40.8';
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "bdgesman";

try {
    $conmy = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	//$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo 'Conectado a ';
}
catch (PDOException $ex) {
	echo 'Error de conexión. '.$ex->getMessage();
}
?>