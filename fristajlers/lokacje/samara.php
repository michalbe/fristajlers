<?
include('conf/stats.php');

if (isset($drag)) {

$query = "SELECT * FROM F_samara WHERE id_kto='$id' AND typTowaru='$drag'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR.<br>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {

$modyf=Drag($drag);
				$stats = PrzekazStatsyBazowe($id);
				$punche = $stats[9]+$modyf[5];
				$int=$stats[2]+$modyf[4];
				$napiecie=$stats[8]-$modyf[3];
				$query = "UPDATE F_stats SET punche='$punche', inteligencja_aktualna='$int', napiecie_aktualne='$napiecie'  WHERE id='$id'"; 
				mysql_query($query);

        $query = "DELETE FROM `F_samara` WHERE `id_kto` = '$id' AND `typTowaru` = '$drag' LIMIT 1";
		mysql_query($query); 
$newsy = $newsy .'<font class=rapy> Drag zarzucony..</font><br>';



}
}
$query = "SELECT typTowaru FROM F_samara WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Nie masz zadnych dragow.</font>';
		} else {
			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
				$szama=Drag($rekord['typTowaru']);
$newsy = $newsy .'<td valign=top height=80><a href="main.php?lokacja=samara&drag=' .$szama[0] .'"><center><img src="gfx/ikony/dragi/' .$szama[0] .'.jpg" title="' .$szama['nazwa'] .'"></center><font class=rapy><b>[N -' .$szama['napiecie'] .', I +' .$szama['inteligencja'] .', P +' .$szama['punche'] .']</b></font></a></td>';
			if ($konter == 5) { $newsy = $newsy .'</tr><tr>'; $konter = 0; }
			}
			$newsy = $newsy .'</tr></table>';
		}


	

$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=szafa"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

?>