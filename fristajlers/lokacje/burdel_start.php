<?
include('conf/stats.php');
if (!MaBurdel($id)) {
if (!isset($_POST['tak'])) {

		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

		if (($pkt_stylu<=990) || (Hajs($id)<1250)) {
			$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc burdel synku?</font>
	<font size=-1><br> Musisz w tym celu miec ponad <b>990pkt</b> stylu i <b>1250HJS</b>.</font></center>';
		} else {


					if ((CzyDiluje($id)!=0) || (MaKS($id)!=0) || (MaSklep($id)!=0)) {
	$newsy = $newsy .'<center><br><br><font> Mozesz prowadzic tylko jedna dzialalnosc jednoczenie!';
					} else {
	$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc burdel synku?</font>
	<table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_start">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
			
					}
			}
} else {

###START###
		$query = "INSERT INTO F_burdele (id_wlasc) VALUES ('$id')"; 
        mysql_query($query); 
		OdejmijHajs($id, 1250);
	$newsy = $newsy .'<center><br><br><font>Uzyskales pozwolenie na prowadzenie burdelu. Aby nim zarzadzac udaj sie do <a href=main.php?lokacja=burdel_start>[zarzadzania burdelem]</a></font>';


	}
} else {
###MA BURDEL######

		$query1 = "SELECT * FROM F_burdele WHERE id_wlasc='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);
		if ($rekord1['nazwa']=='') {$rekord1['nazwa']='brak nazwy'; }
$przyciski = $przyciski .'<td><a href=main.php?lokacja=burdel_opis><img src=gfx/mistrz.jpg border=0 title="Zmien opis"></a></TD><td><a href=main.php?lokacja=burdel_koniec><img src=gfx/kosz.jpg border=0 title="Sprzedaj burdel"></a></TD><td><a href=main.php?lokacja=burdel_zaopatrzenie><img src=gfx/bank.jpg border=0 title="Zlap nowe dziwki"></a></TD>';

		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || ' .Ksywka($rekord1['id_wlasc']) .'</b><br>' .substr($rekord1['opis'], 0, 80) .'</font><br><br>';
		$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$rekord1[burdel_id]' ORDER BY ilosc"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
		$newsy = $newsy .'<font>Nie masz narazie nic do zaoferowania.</font><br>';
	
	} else {

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$drag = Dziwka($rekord[1]);
$newsy = $newsy .'<td valign=top height=65 width=65><img src="gfx/ikony/dziwki/' .$drag[0] .'.jpg" border=2 title="' .$drag['opis'] .'"></td><td valign=left><font class=rapy><b>' .$drag['opis'] .'</b><br/> cena: <b>' .$rekord[3] .'</b>HJS<a href=main.php?lokacja=burdel_cena&towar=' .$rekord[1] .'> [zmien]</a><br>';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'cena dla ekipy: <b>' .$rekord[4] .'</b>HJS<br>'; } $newsy = $newsy .'ilosc: <b>' .$rekord[ilosc] .'</b>&nbsp;&nbsp;<a href=main.php?lokacja=burdel_wywal&towar=' .$rekord[1] .'>[wypusc]</a></font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';

	}
}


$dane=array(
	'lokacja'=> TloLokacji('burdel'), 
	'przyciski'=> $przyciski .'<td><a href=main.php?lokacja=burdel><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>