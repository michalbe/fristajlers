<?
include('conf/stats.php');

if (isset($diler)) {

		$query1 = "SELECT * FROM F_dilerka WHERE id_kto='$diler'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

	if (isset($drag)) {

			##DILESTART##
$query = "SELECT count(*) FROM F_samara WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		$samara= mysql_fetch_array ($wynik);
		if ($samara[0]>11) {
			$newsy = $newsy .'<font>Nie mozesz nic kupic, mozesz przekitrac maxymalnie 12 dragow.</font><br><br>';
		} else {
		
		$query = "SELECT cena, ilosc, cena_ekipa FROM F_dilerkaInwentarz WHERE id_kto='$diler' AND typDraga='$drag' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query);

	if (mysql_num_rows($wynik) == 0) {

			$newsy = $newsy .'ERROR';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {


		$cena = mysql_fetch_array ($wynik);
$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_kto']);
if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $cena['cena']=$cena['cena_ekipa']; }

			if ($id==$diler) {
			if ($diler==0) { } else {
			$cena['cena'] = 0;
			}
			}
		if (Hajs($id)<$cena['cena']) {
		$newsy = $newsy .'<font>Niestety, nie masz wystarczajacej ilosci pieniedzy!<br><br></font>';
		} else {
		
			ZamianaHajsu($id, $diler, $cena['cena']);
				$ilosc=$cena['ilosc']-1;
			$co = Ksywka($id) .' kupil od Ciebie dragi za ' .$cena['cena'] .'PLN. Zostalo jeszcze ' .$ilosc .' sztuk takich dragów.';
			$co = pl_win2iso($co);
			PiszWiadomosc(0, $diler, $co);
			 Transakcje($diler, 3);
				$kup = "INSERT INTO F_samara (id_kto, typTowaru) VALUES ('$id', '$drag')"; 
	        mysql_query($kup);
			$query = "UPDATE F_dilerkaInwentarz SET ilosc='$ilosc' WHERE id_kto='$diler' AND typDraga='$drag'"; 
			mysql_query($query); 
			$newsy = $newsy .'<font>Zasady jak zwykle. Nie znasz mnie, nigdy nie widziales. Milego "uzywania" :].</font><br><br>';
		}
		}
		}
			##DILESTOP###

	}



		$newsy = $newsy .'<font><b>&nbsp;' .Ksywka($rekord1['id_kto']) .'</b><br>' .substr($rekord1['opis'], 0, 150) .'</font><br><br>';
		$query = "SELECT * FROM F_dilerkaInwentarz WHERE id_kto='$diler' AND ilosc <> '0' ORDER BY cena"; 
        $wynik = mysql_query($query); 

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
$nr_gracza=NrEkipy($id);
$nr_sprzedawcy=NrEkipy($rekord1['id_kto']);

			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$drag = Drag($rekord[1]);
			if (($nr_gracza == $nr_sprzedawcy) && ($nr_gracza!=0)) { $rekord[3]=$rekord[4]; }
$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=o_dilerka&diler=' .$diler .'&drag=' .$rekord[1] .'><img src="gfx/ikony/dragi/' .$drag[0] .'.jpg" title="' .$drag['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$drag['nazwa'] .'</b> - ' .$drag['opis'] .' [cena ' .$rekord['3'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';
	


		$przyciski = '<TD><a href=main.php?lokacja=o_dilerka><img src=gfx/back.jpg border=0 title="Lista dilerow"></a></TD>';
} else {
	##lista dilerów
		if (!isset($dil_pocz)) { 
			$dil_pocz = 0;
		}
		$query = "SELECT * FROM F_dilerka ORDER BY rand LIMIT $dil_pocz, 10"; 
        $wynik = mysql_query($query); 
		$query3 = "SELECT count(*) FROM F_dilerka"; 
        $wynik3 = mysql_query($query3);
		$rekord3=mysql_fetch_array ($wynik3);
			#$ilosc_stron=$rekord3[0]/4;
		$newsy = $newsy .pl_win2iso("<font><b> Dilerzy na osiedlu: </b></font><br><br>");
		while($rekord = mysql_fetch_array ($wynik)) {
			$query = "SELECT * FROM F_dilerkaInwentarz WHERE `id_kto`='$rekord[id_kto]' AND ilosc <> '0'";
			$resp = mysql_query($query);
			if (mysql_num_rows($resp) != 0) {

			$newsy = $newsy .'<a href=main.php?lokacja=o_dilerka&diler=' .$rekord['id_kto'] .'><font><b>&nbsp;+ ' .Ksywka($rekord['id_kto']) .'</b></a><br>' .substr($rekord['opis'], 0, 50) .'</font><br>';
			}
		}
		$newsy = $newsy .'<table width=98%><tr><td>';
		if ($dil_pocz!=0) {
		$dil_pocz2= $dil_pocz-10;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=o_dilerka&dil_pocz=' .$dil_pocz2 .'> [<< poprzednia]</a></div></font>';
		}
		$newsy = $newsy .'</td><td>';
		$ilosc=$rekord3[0]-10;
		if (!($dil_pocz>=$ilosc)) {
		$dil_pocz= $dil_pocz+10;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=o_dilerka&dil_pocz=' .$dil_pocz .'>' .pl_win2iso("[nastepna >>]") .'</a></div></font>';
		}
		$newsy = $newsy .'</td></tr></table>';
$przyciski = '<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/samara.jpg border=0 title="Zarzadzanie Dilerka"></a></TD><TD><a href="?lokacja=osiedle"><img src=gfx/back.jpg border=0 title="Osiedle"></a></TD>';
}


	
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski' => $przyciski, 
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>