<?php
define("DB_SERVER", "adminstock");
define("DB_USER", "adminstock");
define("DB_PASSWORD", "Projetopi2019");
define("DB_DATABASE", "adminstock");

$mysqli = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
if(!$mysqli){
	echo "Error: Unable to connect to MySQL." . PHP_EOL;
	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	exit;
}
?>
