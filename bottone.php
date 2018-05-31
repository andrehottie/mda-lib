<?php
include 'library_insert.php';

$newURL = 'http://localhost:8888/Test%20PHP/library_json.php';

$con = new database(HOST, DBN, USER, PWD);
$con->inserisci($_POST['title'],$_POST['category']);

header("Location: ". $newURL);
exit;


?>