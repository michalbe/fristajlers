<?
include('conf/funkcje.php');

PolaczMysql();
	$data =  date("Y-m-d");
$query = "SELECT * FROM F_wyzwania WHERE akcept='1' AND kiedy='$data' AND pora='2'"; 
	    $wynik = mysql_query($query); 
		while ($rekord = mysql_fetch_array ($wynik)) {
			Walcz($rekord[1], $rekord[2], $rekord['punche1'], $rekord['dynamika1'], $rekord['punche2'], $rekord['dynamika2']);
		$queryDel = "DELETE FROM F_wyzwania WHERE nr='$rekord[0]'"; 
	    mysql_query($queryDel); 
		}
?>