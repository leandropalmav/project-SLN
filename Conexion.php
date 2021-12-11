<?php
define('USER', 'id18101069_sln');
define('PASSWORD', 'g4cd\UBwIYM|ON+1');
define('HOST', 'localhost');
define('DATABASE', 'id18101069_proyecto');


//$conexion a base de datos con PDO Y mysqli
 
try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    $con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());

}
?>