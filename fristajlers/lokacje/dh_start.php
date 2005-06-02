<?
include('conf/stats.php');

if (!MaSklep($id)) {
if (!isset($_POST['tak'])) {

		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

		if (($pkt_stylu<=650) || (Hajs($id)<750)) {
			$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc sklep?</font>
	<font size=-1><br> Musisz w tym celu mieæ ponad <b>650pkt</b> stylu i zaplacic <b>750HJS</b>.</font></center>';
		} else {


					if ((CzyDiluje($id)!=0) || (MaKS($id)!=0)  || (MaBurdel($id)!=0)) {
	$newsy = $newsy .'<center><br><br><font> Mozesz prowadzic tylko jedna dzialalnosc jednoczesnie!</font>';
					} else {
	$newsy = $newsy .'<center><br><br><font> Chcesz zalozyc sklep?</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh_start">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';		
					}
			}
} else {

###SKLEP START###
		$query = "INSERT INTO F_sklepy (id_wlasc) VALUES ('$id')"; 
        mysql_query($query); 
		OdejmijHajs($id, 750);
	$newsy = $newsy .'<center><br><br><font>Uzyskales pozwolenie na prowadzenie sklepu. Aby zarzadzac swoim sklepem udaj sie do <a href=main.php?lokacja=dh_start>[zarzadzania sklepem]</a></font>';


	}
$przyciski = $przyciski .'<td><a href=main.php?lokacja=dh><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';
} else {
###MA SKLEP######

		$query1 = "SELECT * FROM F_sklepy WHERE id_wlasc='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);
		if ($rekord1['nazwa']=='') {$rekord1['nazwa']='brak nazwy'; }
$przyciski = $przyciski .'<td><a href=main.php?lokacja=dh_opis><img src=gfx/mistrz.jpg border=0 title="Zmien opis"></a></TD><td><a href=main.php?lokacja=dh_koniec><img src=gfx/kosz.jpg border=0 title="Sprzedaj sklep"></a></TD><td><a href=main.php?lokacja=dh_hurtownia><img src=gfx/bank.jpg border=0 title="Kup towary"></a></TD><td><a href=main.php?lokacja=dh><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>';

		$newsy = $newsy .'<font><b>&nbsp;' .$rekord1['nazwa'] .'</b> || ' .Ksywka($rekord1['id_wlasc']) .'</b><br>' .substr($rekord1['opis'], 0, 150) .'</font><br><br>';
		$query = "SELECT * FROM F_sklepyInwentarz WHERE sklep_id='$rekord1[sklep_id]' ORDER BY ilosc"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
		$newsy = $newsy .'<font>Nie masz narazie nic do sprzedania.</font><br>';
	
	} else {

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$drag = Szama($rekord[1]);
$newsy = $newsy .'<td valign=top height=65 width=65><img src="gfx/ikony/szama/' .$drag[0] .'.jpg" border=2 title="' .$drag['nazwa'] .'"></td><td valign=left><font class=rapy><b>' .$drag['nazwa'] .'</b><br/> cena: <b>' .$rekord[3] .'</b>HJS<a href=main.php?lokacja=dh_cena&towar=' .$rekord[1] .'> [zmien]</a><br/>'; 
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'cena dla ekipy: <b>' .$rekord[4] .'</b>HJS<br>'; } $newsy = $newsy .'ilosc: <b>' .$rekord[ilosc] .'</b>&nbsp;&nbsp;<a href=main.php?lokacja=dh_wywal&towar=' .$rekord[1] .'>[wyrzuc]</a></font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';

	}
}




$dane=array(
	'lokacja'=> TloLokacji('dh'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>