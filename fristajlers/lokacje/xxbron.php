<?
include('conf/stats.php');

if (isset($bron)) {

		$query1 = "SELECT * FROM F_bron WHERE bron_id='$bron'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

	if (isset($towar)) {

	$query = "SELECT count(*) FROM F_skrytkaBron WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		$lodowka= mysql_fetch_array ($wynik);
		if ($lodowka[0]>8) {
			$newsy = $newsy .'<font>Nie mozesz nic kupic, Twoja skrytka jest pelna! Moze pomiescic maxymalnie 9 broni!!</font><br><br>';


		} else {
		$query = "SELECT cena, ilosc FROM F_bronInwentarz WHERE bron_id='$bron' AND typTowaru='$towar' ORDER BY cena"; 
        $wynik = mysql_query($query);
		
		if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR';  #### blokowanie kupowania w sklepieie którego nei ma :]

		} else {

		$cena = mysql_fetch_array ($wynik);
		if (MaBron($id)==$bron) {
			if ($bron==0) { } else {
			$cena['cena'] = 0;
			}
		}
		if (Hajs($id)<$cena['cena']) {
		$newsy = $newsy .'<font>Niestety, nie masz wystarczajacej ilosci pieniedzy!<br><br></font>';
		} else {
			ZamianaHajsu($id, $rekord1['id_wlasc'], $cena['cena']);
			$ilosc=$cena['ilosc']-1;
			$co = Ksywka($id) .' kupil w bron za ' .$cena['cena'] .'HJS. Zostalo jeszcze ' .$ilosc .' takich rodzajow broni.';
			$co = pl_win2iso($co);
			PiszWiadomosc(0, $rekord1['id_wlasc'], $co);
			 Transakcje($bron, 2);


			$kup = "INSERT INTO F_skrytkaBron (id_kto, typTowaru) VALUES ('$id', '$towar')"; 
	        mysql_query($kup);
						$query = "UPDATE F_bronInwentarz SET ilosc='$ilosc' WHERE bron_id='$bron' AND typTowaru='$towar'"; 
			mysql_query($query); 
			$newsy = $newsy .'<font>Kupiona bron zostala przetransportowana do Twojego domu.</font><br><br>';
		}
		}
		}
	}



		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || <i>' .Ksywka($rekord1['id_wlasc']) .'</i><br>' .$rekord1['opis'] .'</font><br><br>';
		$query = "SELECT * FROM F_bronInwentarz WHERE bron_id='$bron' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query); 

			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
		while($rekord = mysql_fetch_array ($wynik)) {
			$konter++;
			$towar = Bron($rekord[1]);
		$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=bron&bron=' .$bron .'&towar=' .$rekord[1] .'><img src="gfx/ikony/bron/' .$towar[0] .'.jpg" title="' .$towar['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$towar['nazwa'] .'</b> - ' .$towar['opis'] .' [cena ' .$rekord['cena'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';

$przyciski = $przyciski .'<td><a href=main.php?lokacja=bron><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
} else {
	##lista bronów
		if (!isset($bron_pocz)) { 
			$bron_pocz = 0;
		}
		$query = "SELECT * FROM F_bron WHERE nazwa <> '' ORDER BY rand LIMIT $bron_pocz, 6"; 
        $wynik = mysql_query($query); 
		$query3 = "SELECT count(*) FROM F_bron"; 
        $wynik3 = mysql_query($query3);
		$rekord3=mysql_fetch_array ($wynik3);
			#$ilosc_stron=$rekord3[0]/4;
$przyciski = $przyciski .'<td><a href=main.php?lokacja=bron_start><img src=gfx/bron.jpg border=0 title="Zarzadzanie sklepem z bronia"></a></TD><td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
		$newsy = $newsy .'<b>Handlarze bronia w Twojej dzielnicy: </b></font><br><br>';
		while($rekord = mysql_fetch_array ($wynik)) {
			$newsy = $newsy .'<a href=main.php?lokacja=bron&bron=' .$rekord['bron_id'] .'><font><b>&nbsp;' .$rekord['nazwa'] .'</b> || <i>' .Ksywka($rekord['id_wlasc']) .'</i></a><br>' .substr($rekord['opis'], 0, 50) .'</font><br><br>';
		}
		$newsy = $newsy .'<table width=98%><tr><td>';
		if ($bron_pocz!=0) {
		$bron_pocz2= $bron_pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=bron&bron_pocz=' .$bron_pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$newsy = $newsy .'</td><td>';
		$ilosc=$rekord3[0]-6;
		if (!($bron_pocz>=$ilosc)) {
		$bron_pocz= $bron_pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=bron&bron_pocz=' .$bron_pocz .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}
		$newsy = $newsy .'</td></tr></table>';
}



$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>