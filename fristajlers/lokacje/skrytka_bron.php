<?
include('conf/stats.php');

	if (isset($bron)) {

$query = "SELECT * FROM F_skrytkaBron WHERE id_kto='$id' AND typTowaru='$bron'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR.<br>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
##### ZMIENIC NA SPRAWDZANIE CZY MAgazynek czy bron i doladowywac

$stats = PrzekazStatsyBazowe($id);
if ($stats[0]==$stats[7]) {
	$newsy = $newsy .'<font class=rapy> Jestes pelny, nie mzoesz jesc wiecej!<br></font>';
} else {
	$energia2=Bron($bron);
	$energia2=$energia2[3];

		if (($stats[0]+$energia2)>$stats[7]) {
			$energia2=$stats[7];
		} else {
			$energia2=$stats[0]+$energia2;
		}
		$query = "UPDATE F_stats SET energia_aktualna='$energia2' WHERE id='$id'"; 
			mysql_query($query); 
        $query = "DELETE FROM `F_skrytkaBron` WHERE `id_kto` = '$id' AND `typTowaru` = '$bron' LIMIT 1";
		mysql_query($query); 
$newsy = $newsy .'<font class=rapy> Zjadles szame.</font><br>';


}
}
}
$query = "SELECT typTowaru FROM F_skrytkaBron WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Skrytka jest pusta.</font>';
		} else {

###  WYSWIETLANIE PRODUKTOW

			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
				$bron=bron($rekord['typTowaru']);
				$newsy = $newsy .'<td valign=top height=80 width=90><a href="main.php?lokacja=skrytkaBron&bron=' .$bron[0] .'"><img src="gfx/ikony/bron/' .$bron[0] .'.jpg" title="' .$bron['nazwa'] .'"><br><font class=rapy><b>' .$bron['atrybuty'] .'</b></font></a></td>';
			if ($konter == 5) { $newsy = $newsy .'</tr><tr>'; $konter = 0; }

			}
			$newsy = $newsy .'</tr></table>';
		}


	

$dane=array(
	'lokacja'=> TloLokacji('bron'), 
	'przyciski'=> '<TD><a href="?lokacja=szafa"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

?>