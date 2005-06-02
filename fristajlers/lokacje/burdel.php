<?
include('conf/stats.php');


if (isset($burdel)) {

		$query1 = "SELECT * FROM F_burdele WHERE burdel_id='$burdel'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

	if (isset($dziwka)) {

			##DILESTART##
		$query = "SELECT cena, ilosc, cena_ekipa FROM F_burdeleStan WHERE burdel_id='$burdel' AND dziwka='$dziwka' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query);

	if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {


		$cena = mysql_fetch_array ($wynik);
$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);
if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $cena['cena']=$cena['cena_ekipa']; }
			if (MaBurdel($id)==$burdel) {
			if ($burdel==0) { } else {
			$cena['cena'] = 0;
			}
			}
		if (Hajs($id)<$cena['cena']) {
		$newsy = $newsy .'<font>Niestety, nie masz wystarczajacej ilosci pieniedzy!<br><br></font>';
		} else {
			$modyf=Dziwka($dziwka);
				$stats = PrzekazStatsyBazowe($id);
				$forma=$stats[10]+$modyf[2];
				$query = "UPDATE F_stats SET forma='$forma' WHERE id='$id'"; 
				mysql_query($query); 

			ZamianaHajsu($id, $rekord1['id_wlasc'], $cena['cena']);
				$ilosc=$cena['ilosc']-1;
			$co = Ksywka($id) .' kupil od Ciebie dziwke za ' .$cena['cena'] .'HJS. Zostalo jeszcze ' .$ilosc .' takich dziwek.';
			PiszWiadomosc(0,  $rekord1['id_wlasc'], $co);
			 Transakcje($burdel, 4);
				$ilosc=$cena['ilosc']-1;
			$query = "UPDATE F_burdeleStan SET ilosc='$ilosc' WHERE burdel_id='$burdel' AND dziwka='$dziwka'"; 
			mysql_query($query); 
			$newsy = $newsy .'<font>Zapraszamy ponownie.</font><br><br>';
		}
		}
			##DILESTOP###

	}



		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || <i>' .Ksywka($rekord1['id_wlasc']) .'</i><br>' .$rekord1['opis'] .'</font><br><br>';
		$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$burdel' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query); 
			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);
		while($rekord = mysql_fetch_array ($wynik)) {
			$konter++;
			$dziwka = Dziwka($rekord[1]);
			if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $rekord[3]=$rekord[4]; }
		$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=burdel&burdel=' .$burdel .'&dziwka=' .$rekord[1] .'><img src="gfx/ikony/dziwki/' .$dziwka[0] .'.jpg" title="' .$dziwka['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$dziwka['opis'] .'</b> [forma +' .$dziwka['forma'] .'] [cena ' .$rekord['3'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';

$przyciski = $przyciski .'<td><a href=main.php?lokacja=burdel><img src=gfx/back.jpg border=0 title="Lista burdeli"></a></TD>';
} else {
	##lista dilerów
		if (!isset($pocz)) { 
			$pocz = 0;
		}
		$query = "SELECT * FROM F_burdele ORDER BY rand LIMIT $pocz, 6"; 
        $wynik = mysql_query($query); 
		$query3 = "SELECT count(*) FROM F_burdele"; 
        $wynik3 = mysql_query($query3);
		$rekord3=mysql_fetch_array ($wynik3);
			#$ilosc_stron=$rekord3[0]/4;
$przyciski = $przyciski .'<td><a href=main.php?lokacja=burdel_start><img src=gfx/burdel.jpg border=0 title="Zarzadzanie burdelem"></a></TD><td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
		$newsy = $newsy .'<b> Dostepne burdele: </b> (dziwki poprawiaja forme)</font><br><br>';
		while($rekord = mysql_fetch_array ($wynik)) {
			$query = "SELECT * FROM F_burdeleStan WHERE `burdel_id`='$rekord[burdel_id]' AND ilosc <> '0'";
			$resp = mysql_query($query);
			if (mysql_num_rows($resp) != 0) {

			$newsy = $newsy .'<a href=main.php?lokacja=burdel&burdel=' .$rekord['burdel_id'] .'><font><b>' .$rekord['nazwa'] .' </b>|| '.Ksywka($rekord['id_wlasc']) .'</a><br>' .substr($rekord['opis'], 0, 50) .'</font><br><br>';
			}
		}
		$newsy = $newsy .'<table width=98%><tr><td>';
		if ($pocz!=0) {
		$pocz2= $pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=burdel&pocz=' .$pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$newsy = $newsy .'</td><td>';
		$ilosc=$rekord3[0]-6;
		if (!($pocz>=$ilosc)) {
		$pocz= $pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=burdel&pocz=' .$pocz .'>' .'[nastepne >>]' .'</a></div></font>';
		}
		$newsy = $newsy .'</td></tr></table>';
}


$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski, 
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>