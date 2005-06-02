<?
include('conf/stats.php');


		$queryDel = "DELETE FROM F_poczta WHERE id_do='$id'"; 
	    mysql_query($queryDel); 
		$newsy = "<font>Skrzynka zostala oprozniona.</font>";


	
$dane=array(
	'lokacja'=> TloLokacji(poczta), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>