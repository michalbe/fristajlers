<?
include('conf/stats.php');

if (!CzyDiluje($id)) {
if (!isset($_POST['tak'])) {

		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

		if (($pkt_stylu<=520)) {
			$newsy = $newsy .'<font size=-1><br> Musisz w tym celu miec ponad 520pkt stylu.</font></center>';

		} else {

					if ((MaSklep($id)!=0 ) || (MaKS($id)!=0) || (MaBurdel($id)!=0)) {
	$newsy = $newsy .'<center><br><br><font> Mozesz prowadzic tylko jedna dzialalnosc jednoczenie!</font>';
					} else {
	$newsy = $newsy .'<center><br><br><font> Chcesz sprzedawac dla nas prochy, mlody?</font>
	<table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_start">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
					}
			}
} else {

###DIL START###
		$query = "INSERT INTO F_dilerka (id_kto) VALUES ('$id')"; 
        mysql_query($query); 
	$newsy = $newsy .pl_win2iso('<center><br><br><font>Nie ma sprawy.zeby kupic dragi i ustalic ich ceny, przejdz do <a href=main.php?lokacja=o_dilerka_start>[zarzadzania dilerka]</a></font>');


	}
} else {
###DILUJE JUZ######

		$query1 = "SELECT * FROM F_dilerka WHERE id_kto='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);
$przyciski = '<td><a href=main.php?lokacja=o_dilerka_opis><img src="gfx/mistrz.jpg" border=0 title="Zmien Opis"></a></td><td><a href=main.php?lokacja=o_dilerka_koniec><img src="gfx/kosz.jpg" border=0 title="Zrezygnuj"></a></td>';
		$newsy = $newsy .'<font><b>&nbsp;' .Ksywka($rekord1['id_kto']) .'</b><br>' .substr($rekord1['opis'], 0, 150) .'</font><br><br>';
		$query = "SELECT * FROM F_dilerkaInwentarz WHERE id_kto='$id' ORDER BY ilosc"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
		$newsy = $newsy .'<font>Nie masz narazie nic do sprzedania.</font><br>';
	
	} else {

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$drag = Drag($rekord[1]);
$newsy = $newsy .'<td valign=top height=65 width=65><img src="gfx/ikony/dragi/' .$drag[0] .'.jpg" border=2 title="' .$drag['nazwa'] .'"></td><td valign=left><font class=rapy><b>' .$drag['nazwa'] .'</b><br/> cena: <b>' .$rekord[3] .'</b>HJS<a href=main.php?lokacja=o_dilerka_cena&drags=' .$rekord[1] .'> [zmien]</a><br>';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'cena dla ekipy: <b>' .$rekord[4] .'</b>HJS<br>'; } $newsy = $newsy .'ilosc: <b>' .$rekord[ilosc] .'</b>&nbsp;&nbsp;<a href=main.php?lokacja=o_dilerka_wywal&drags=' .$rekord[1] .'>[wyrzuc]</a></font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
	
			}
			$newsy = $newsy .'</table>';
	
	}
$przyciski = $przyciski .'<td><a href=main.php?lokacja=o_dilerka_hurtownia><img src="gfx/bank.jpg" border=0 title="Kup Dragi"></a></td>';
}
$przyciski = $przyciski .'<TD><a href="?lokacja=o_dilerka"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>';


$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>