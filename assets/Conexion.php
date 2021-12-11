<?php
define('USER', 'id18034859_sebastian');
define('PASSWORD', 'Zte2HX*k47njuRVt');
define('HOST', 'localhost');
define('DATABASE', 'id18034859_proyecto');


//$conexion = mysqli_connect($USER,$PASSWORD,$DATABASE,$HOST);
 
try {
    $connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    $con = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());

}
?>