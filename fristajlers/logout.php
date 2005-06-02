<?
session_start();
$id=$_SESSION['id'];
include('conf/funkcje.php');

PolaczMysql();
	 	$queryDel = "DELETE FROM Online WHERE id = '$id'"; 
	    mysql_query($queryDel);

session_destroy();
header("Location: http://fristajlers.net");

?>
