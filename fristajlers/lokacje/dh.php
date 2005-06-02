<?
include('conf/stats.php');

if (isset($sklep)) {

		$query1 = "SELECT * FROM F_sklepy WHERE sklep_id='$sklep'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

	if (isset($towar)) {
	$query = "SELECT count(*) FROM F_lodowka WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		$lodowka= mysql_fetch_array ($wynik);
		if ($lodowka[0]>11) {
			$newsy = $newsy .'<font>Nie mozesz nic kupic, Twoja lodowka jest pelna! Moze pomiescic maxymalnie 12 produktow</font><br><br>';
		} else {
		$query = "SELECT cena, ilosc, cena_ekipa FROM F_sklepyInwentarz WHERE sklep_id='$sklep' AND typTowaru='$towar' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query);
		
		if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {

		$cena = mysql_fetch_array ($wynik);
$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);
if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $cena['cena']=$cena['cena_ekipa']; }

		if (MaSklep($id)==$sklep) {
			if ($sklep==0) { } else {
			$cena['cena'] = 0;
			}
		}
		if (Hajs($id)<$cena['cena']) {
		$newsy = $newsy .'<font>Niestety, nie masz wystarczajacej ilosci pieniedzy!<br><br></font>';
		} else {
			ZamianaHajsu($id, $rekord1['id_wlasc'], $cena['cena']);
			$ilosc=$cena['ilosc']-1;
			$co = Ksywka($id) .' kupil w Twoim sklepie towar za ' .$cena['cena'] .'HJS. Zostalo jeszcze ' .$ilosc .' takich towarów.';
			$co = pl_win2iso($co);
			PiszWiadomosc(0, $rekord1['id_wlasc'], $co);
			 Transakcje($sklep, 2);
			$kup = "INSERT INTO F_lodowka (id_kto, typTowaru) VALUES ('$id', '$towar')"; 
	        mysql_query($kup);
						$query = "UPDATE F_sklepyInwentarz SET ilosc='$ilosc' WHERE sklep_id='$sklep' AND typTowaru='$towar'"; 
			mysql_query($query); 
			$newsy = $newsy .'<font>Kupiony towar zostal przetransportowany do Twojej lodowki.</font><br><br>';
		}
		}
		}
	}



		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || <i>' .Ksywka($rekord1['id_wlasc']) .'</i><br>' .$rekord1['opis'] .'</font><br><br>';
		$query = "SELECT * FROM F_sklepyInwentarz WHERE sklep_id='$sklep' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query); 

			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;

$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_wlasc']);

		while($rekord = mysql_fetch_array ($wynik)) {
			$konter++;
			$towar = szama($rekord[1]);
			if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $rekord[3]=$rekord[4]; }
		$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=dh&sklep=' .$sklep .'&towar=' .$rekord[1] .'><img src="gfx/ikony/szama/' .$towar[0] .'.jpg" title="' .$towar['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$towar['nazwa'] .'</b> - ' .$towar['opis'] .' [cena ' .$rekord['3'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';

$przyciski = $przyciski .'<td><a href=main.php?lokacja=dh><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
} else {
	##lista sklepów
		if (!isset($sklep_pocz)) { 
			$sklep_pocz = 0;
		}
		$query = "SELECT * FROM F_sklepy WHERE nazwa <> '' ORDER BY rand LIMIT $sklep_pocz, 6"; 
        $wynik = mysql_query($query); 
		$query3 = "SELECT count(*) FROM F_sklepy"; 
        $wynik3 = mysql_query($query3);
		$rekord3=mysql_fetch_array ($wynik3);
			#$ilosc_stron=$rekord3[0]/4;
$przyciski = $przyciski .'<td><a href=main.php?lokacja=dh_start><img src=gfx/sklepy.jpg border=0 title="Zarzadzanie sklepami"></a></TD><td><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
		$newsy = $newsy .'<b> Sklepy w Twojej dzielnicy: </b></font><br><br>';
		while($rekord = mysql_fetch_array ($wynik)) {
			$newsy = $newsy .'<a href=main.php?lokacja=dh&sklep=' .$rekord['sklep_id'] .'><font><b>&nbsp;' .$rekord['nazwa'] .'</b> || <i>' .Ksywka($rekord['id_wlasc']) .'</i></a><br>' .substr($rekord['opis'], 0, 50) .'</font><br><br>';
		}
		$newsy = $newsy .'<table width=98%><tr><td>';
		if ($sklep_pocz!=0) {
		$sklep_pocz2= $sklep_pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=dh&sklep_pocz=' .$sklep_pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$newsy = $newsy .'</td><td>';
		$ilosc=$rekord3[0]-6;
		if (!($sklep_pocz>=$ilosc)) {
		$sklep_pocz= $sklep_pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=dh&sklep_pocz=' .$sklep_pocz .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}
		$newsy = $newsy .'</td></tr></table>';
}



$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>