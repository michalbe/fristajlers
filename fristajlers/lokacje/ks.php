<?
include('conf/stats.php');


if (isset($sport)) {

		$query1 = "SELECT * FROM F_sporty WHERE sport_id='$sport'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

	if (isset($trening)) {

			##TRENINGSTART##
		$query = "SELECT cena, cena_ekipa, ilosc FROM F_sportyStan WHERE sport_id='$sport' AND typTreningu='$trening' AND ilosc <> '0'"; 
        $wynik = mysql_query($query);

			if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {

		$cena = mysql_fetch_array ($wynik);

$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);
if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $cena['cena']=$cena['cena_ekipa']; }
		if (MaKs($id)==$sport) {
			if ($sport==0) { } else {
			$cena['cena'] = 0;
			}
		}
		if (Hajs($id)<$cena['cena']) {
		$newsy = $newsy .'<font>Niestety, nie masz wystarczajacej ilosci pieniedzy!<br><br></font>';
		} else {
			$modyf=Trening($trening);
				$stats = PrzekazStatsyBazowe($id);
				if ($stats[0]<$modyf[3]) {
			$newsy = $newsy .'<font>Jestes za bardzo zmeczony. Wybierz inny typ treningu, albo odpocznij.</font><br><br>';
				} else {
				$energia_akt = $stats[0]-$modyf[3];
				$napiecie=$stats[6]-$modyf[5];
				$energia=$stats[7]+$modyf[4];
				$query = "UPDATE F_stats SET energia_aktualna='$energia_akt', napiecie='$napiecie', napiecie_aktualne='$napiecie', energia='$energia'  WHERE id='$id'"; 
				mysql_query($query); 

			ZamianaHajsu($id, $rekord1['id_wlasc'], $cena['cena']);
			$ilosc=$cena['ilosc']-1;
			$co = Ksywka($id) .' kupil w Twojej silowni trening za ' .$cena['cena'] .'HJS. Zostalo jeszcze ' .$ilosc .' takich treningów.';
			$co = pl_win2iso($co);
			PiszWiadomosc(0, $rekord1['id_wlasc'], $co);
			 Transakcje($sport, 1);
				
			$query = "UPDATE F_sportyStan SET ilosc='$ilosc' WHERE sport_id='$sport' AND typTreningu='$trening'"; 
			mysql_query($query); 
			$newsy = $newsy .'<font>Pamietaj, aby zobaczyc efekty musisz trenowac regularnie.</font><br><br>';
		}
		}
		}

			##TRENINGSTOP###

	}


		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || <i>' .Ksywka($rekord1['id_wlasc']) .'</i><br>' .substr($rekord1['opis'], 0, 80) .'</font><br><br>';
		$query = "SELECT * FROM F_sportyStan WHERE sport_id = '$sport' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query); 

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
		while($rekord = mysql_fetch_array ($wynik)) {
			$konter++;
			$trening = Trening($rekord[1]);
	$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);
if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $rekord[3]=$rekord[4]; }
$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=ks&sport=' .$sport .'&trening=' .$rekord[1] .'><img src="gfx/ikony/treningi/' .$trening[0] .'.jpg" title="' .$trening['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$trening['nazwa'] .'</b> - ' .$trening['opis'] .' [cena ' .$rekord['3'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }

		}
			$newsy = $newsy .'</table>';


		$przyciski = $przyciski .'<td><a href=main.php?lokacja=ks><img src=gfx/back.jpg border=0 title="Lista obiektow sportowych"></a></td>';
} else {
	## lista obiektow sportowych
	if (!isset($pocz)) { 
			$pocz = 0;
		}
		$queryIlosc = "SELECT count(*) FROM F_sporty"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);

	$przyciski = $przyciski .'<td><a href=main.php?lokacja=ks_start><img src=gfx/sporty.jpg border=0 title="Zarzadzanie obiektem sportowym"></a></td><td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></td>';
	$newsy = $newsy .'<b><font> Dostepne obiekty sportowe: </b>(treningi podnosza energie)</font><br><br>';
		$query = "SELECT * FROM F_sporty WHERE nazwa <> '' ORDER BY rand LIMIT $pocz, 6"; 
        $wynik = mysql_query($query); 
		while($rekord = mysql_fetch_array ($wynik)) {
		$newsy = $newsy .'<a href=main.php?lokacja=ks&sport=' .$rekord['sport_id'] .'><font><b>&nbsp;' .$rekord['nazwa'] .'</b> || <i>' .Ksywka($rekord['id_wlasc']) .'</i></a><br>' .substr($rekord['opis'], 0, 80) .'</font><br><br>';
		}
if ($pocz!=0) {
		$pocz2= $pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=ks&pocz=' .$pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$ilosc=$ilosc[0]-6;
		if (!($pocz>=$ilosc)) {
		$pocz= $pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=ks&pocz=' .$pocz .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}
}





$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>