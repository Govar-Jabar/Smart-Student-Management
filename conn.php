<?php
$sn = "localhost";
$u = "root";
$p = "";
$db = "student";

$conn = mysqli_connect($sn, $u, $p, $db);
mysqli_set_charset($conn,"utf8");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo password_hash("govar", PASSWORD_BCRYPT);
try{
	$db = new PDO('mysql:host='.$sn.';dbname='.$db.';charset=utf8mb4', $u, $p);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo $e->getMessage();
}

function output($data){
	return trim(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
}

