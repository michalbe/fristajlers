<?
include('conf/stats.php');
if (!MaKs($id)) {
if (!isset($_POST['tak'])) {

		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

		if (($pkt_stylu<=800) || (Hajs($id)<800)) {
			
			$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc swoj wlasny Obiekt Sportowy?<br> Musisz w tym celu miec ponad <b>800pkt</b> stylu i zaplacic <b>800PLN</b>.</font></center>';
	
		} else {

					if ((CzyDiluje($id)!=0 ) || (MaSklep($id)!=0) || (MaBurdel($id)!=0)) {
	$newsy = $newsy .'<center><br><br><font> Mozesz prowadzic tylko jedna dzialalnosc jednoczesnie!</font>';
					} else {
$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc swoj wlasny Obiekt Sportowy?</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=ks_start">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=ks">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
			}
		}
} else {

###OBIEKT START###
		$query = "INSERT INTO F_sporty (id_wlasc) VALUES ('$id')"; 
        mysql_query($query); 
		OdejmijHajs($id, 800);
	$newsy = $newsy .'<center><br><br><font>Uzyskales pozwolenie na prowadzenie obiektu sportowego. Aby nim zarzadzac udaj sie do <a href=main.php?lokacja=ks_start>[zarzadzania obiektem sportowym]</a></font>';


	}
} else {
###MA OBIEKT######

		$query1 = "SELECT * FROM F_sporty WHERE id_wlasc='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);
		if ($rekord1['nazwa']=='') {$rekord1['nazwa']='brak nazwy'; }
		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || ' .Ksywka($rekord1['id_wlasc']) .'</b><br>' .substr($rekord1['opis'], 0, 150) .'</font><br><br>';

$przyciski = $przyciski .'<td><a href=main.php?lokacja=ks_opis><img src=gfx/mistrz.jpg border=0 title="Zmien nazwe i opis"></a></td><td><a href=main.php?lokacja=ks_koniec><img src=gfx/kosz.jpg border=0 title="Sprzedaj obiekt"></a></td>';

		$query = "SELECT * FROM F_sportyStan WHERE sport_id='$rekord1[sport_id]' ORDER BY ilosc"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
		$newsy = $newsy .'<font>Nie masz narazie nic do zaoferowania.</font><br>';
	
	} else {
$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$trening = Trening($rekord[1]);
$newsy = $newsy .'<td valign=top height=65 width=65><img src="gfx/ikony/treningi/' .$trening[0] .'.jpg" border=2 title="' .$trening['nazwa'] .'"></td><td valign=left><font class=rapy><b>' .$trening['nazwa'] .'</b><br/> cena: <b>' .$rekord[3] .'</b>HJS<a href=main.php?lokacja=ks_cena&trening=' .$rekord[1] .'> [zmien]</a><br>';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'cena dla ekipy: <b>' .$rekord[4] .'</b>HJS<br>'; } $newsy = $newsy .'ilosc: <b>' .$rekord[ilosc] .'</b>&nbsp;&nbsp;<a href=main.php?lokacja=ks_wywal&trening=' .$rekord[1] .'>[wyrzuc]</a></font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';




	}
$przyciski = $przyciski .'<td><a href=main.php?lokacja=ks_hurtownia><img src=gfx/bank.jpg border=0 title="Kup treningi"></a></td>';
}

$dane=array(
	'lokacja'=> TloLokacji('ks'), 
	'przyciski'=> $przyciski .'<td><a href=main.php?lokacja=ks><img src=gfx/back.jpg border=0 title="Powrot"></a></td>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>