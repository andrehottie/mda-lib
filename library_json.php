<?php
include 'library_insert.php';

header("Content-Type: application/json");


$con = new database(HOST, DBN, USER, PWD);


if(!isset($_GET['mycategory'])){
	$get = null;
} else {
	$get = $_GET['mycategory'];
}

$con->creaJson($get, JSON_PRETTY_PRINT);




?>