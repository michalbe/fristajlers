<?
include('conf/stats.php');

if (MaKs($id)) {
$sport_id=MaKs($id);
if ((isset($trening)) && (!isset($zamow))) {
##kupno
				$query = "SELECT * FROM F_sportyZaop WHERE id_zaop='1' AND typTreningu='$trening' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$trenings = Trening($rekord[1]);
				$rekord[2] =  ModyfikatorCen($rekord[2], $id);
		$newsy = $newsy .'<br><br><font><b>' .$trenings[1] .'</b>&nbsp;&nbsp; ' .$rekord[2] .'HJS</a><br>&nbsp;&nbsp;<i>'.$trenings[2] .'</i></font><br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=ks_hurtownia">
	<font>Ile chcesz treningow?</font>	<INPUT size=3 TYPE="text" NAME="ile">
	<INPUT TYPE="hidden" name=trening value=' .$trening .'>
	<INPUT TYPE="submit" value="zamow" name=zamow>
	</FORM></center>';

} elseif (isset($_POST['zamow'])) {
##kupno - operacje na bazie
				$query = "SELECT * FROM F_sportyZaop WHERE id_zaop='1' AND typTreningu='$trening' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$trenings = Trening($rekord[1]);
$ile=$_POST['ile'];

$cenasztuki = ModyfikatorCen($rekord['cena'], $id);

$cena= $ile*$cenasztuki;

		 if (Hajs($id)<$cena) {
			 ## nie ma hajsu
			 $newsy = $newsy .'<center><br><br><font>Niestety, nie masz wystarczajacej ilosci pieniedzy.';
		 } else {
			 ## ma hajs, wszystko smiga
				$query = "SELECT * FROM F_sportyStan WHERE sport_id='$sport_id' AND typTreningu='$trening'"; 
				 $wynik = mysql_query($query); 
				 if (mysql_num_rows($wynik) == 0) {
									$query = "SELECT count(*) FROM F_sportyStan WHERE sport_id='$sport_id'"; 
									$wynik = mysql_query($query); 
									$rekord = mysql_fetch_array ($wynik);
									if ($rekord[0]<5) {
			 					$query = "INSERT INTO F_sportyStan (sport_id, typTreningu, ilosc, cena) VALUES ('$sport_id', '$trening', '$ile', '$cenasztuki')"; 
								mysql_query($query);
								OdejmijHajs($id, $cena);
 								$newsy = $newsy .'<center><br><br><font>Mozesz juz prowadzic dany trening w swoim obiekcie.</font>';
									} else {
								$newsy = $newsy .'<center><br><br><font>Mozesz prowadzic maxymalnie 5 rodzajow treningow!</font>';
									}
				 } else {

				$rekord = mysql_fetch_array ($wynik);
				$ile=$rekord[ilosc]+$ile;
		 		$query = "UPDATE F_sportyStan SET ilosc='$ile' WHERE sport_id='$sport_id' AND typTreningu='$trening'"; 
							 mysql_query($query);
							OdejmijHajs($id, $cena);
$newsy = $newsy .'<center><br><br><font>Mozesz juz prowadzic dany trening w swoim obiekcie.</font>';
				 }
 		 }


} else {
## oferta
if (!isset($pocz)) { 
			$pocz = 0;
		}
		$queryIlosc = "SELECT count(*) FROM F_sportyZaop WHERE id_zaop='1'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
			$newsy = $newsy .'<font><b>Dostepne treningi:</b></font><br><br>';

				$query = "SELECT * FROM F_sportyZaop WHERE id_zaop='1' ORDER BY cena LIMIT $pocz, 6"; 
        $wynik = mysql_query($query); 
		$query1 = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

			$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;	
			while($rekord = mysql_fetch_array ($wynik)) {
			$konter++;
			$rekord[2] =  ModyfikatorCen($rekord[2], $id);
			$trenings = Trening($rekord[1]);
			$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=ks_hurtownia&trening=' .$rekord[1] .'><img src="gfx/ikony/treningi/' .$trenings[0] .'.jpg" title="' .$trenings['nazwa'] .'"></a></td><td valign=left><font class=rapy><b>' .$trenings['nazwa'] .'</b> - ' .$trenings['opis'] .' [cena ' .$rekord['2'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }
		}
			$newsy = $newsy .'</table>';

if ($pocz!=0) {
		$pocz2= $pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=ks_hurtownia&pocz=' .$pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$ilosc=$ilosc[0]-6;
		if (!($pocz>=$ilosc)) {
		$pocz= $pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=ks_hurtownia&pocz=' .$pocz .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}

}
}



$dane=array(
	'lokacja'=> TloLokacji('ks'), 
	'przyciski'=> '<td><a href=main.php?lokacja=ks_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>