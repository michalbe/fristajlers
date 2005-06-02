<?
include('conf/stats.php');

	if (isset($szama)) {

$query = "SELECT * FROM F_lodowka WHERE id_kto='$id' AND typTowaru='$szama'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR.<br>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {

$stats = PrzekazStatsyBazowe($id);
if ($stats[0]==$stats[7]) {
	$newsy = $newsy .'<font class=rapy> Jestes pelny, nie mzoesz jesc wiecej!<br></font>';
} else {
	$energia2=Szama($szama);
	$energia2=$energia2[3];

		if (($stats[0]+$energia2)>$stats[7]) {
			$energia2=$stats[7];
		} else {
			$energia2=$stats[0]+$energia2;
		}
		$query = "UPDATE F_stats SET energia_aktualna='$energia2' WHERE id='$id'"; 
			mysql_query($query); 
        $query = "DELETE FROM `F_lodowka` WHERE `id_kto` = '$id' AND `typTowaru` = '$szama' LIMIT 1";
		mysql_query($query); 
$newsy = $newsy .'<font class=rapy> Zjadles szame.</font><br>';


}
}
}
$query = "SELECT typTowaru FROM F_lodowka WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Lodowka jest pusta.</font>';
		} else {

###  WYSWIETLANIE PRODUKTOW

			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
				$szama=Szama($rekord['typTowaru']);
				$newsy = $newsy .'<td valign=top height=80><a href="main.php?lokacja=lodowka&szama=' .$szama[0] .'"><img src="gfx/ikony/szama/' .$szama[0] .'.jpg" title="' .$szama['nazwa'] .'"><br><font class=rapy><b>[energia +' .$szama['energia'] .']</b></font></a></td>';
			if ($konter == 5) { $newsy = $newsy .'</tr><tr>'; $konter = 0; }

			}
			$newsy = $newsy .'</tr></table>';
		}


	

$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

?>