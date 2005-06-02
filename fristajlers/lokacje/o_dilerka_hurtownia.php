<?
include('conf/stats.php');

if (CzyDiluje($id)) {

if ((isset($drags)) && (!isset($zamow))) {
##kupno
				$query = "SELECT * FROM F_dilerkaHandlarz WHERE id_handlarza='1' AND typDraga='$drags' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$drag = Drag($rekord[1]);
		$newsy = $newsy .'<br><br><img src="gfx/ikony/dragi/' .$drag[0] .'.jpg" title="' .$drag[1] .'" border=2><br><font><b>' .$drag[1] .'</b>&nbsp;&nbsp; ' .ModyfikatorCen($rekord[2], $id) .'HJS</a><br>&nbsp;&nbsp;<i>'.$drag[2] .'</i></font><br>
	<br><center><FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_hurtownia">
	<font>Ile chcesz sztuk?</font>	<INPUT size=3 TYPE="text" NAME="ile">
	<INPUT TYPE="hidden" name=drags value=' .$drags .'>
	<INPUT TYPE="submit" value="zamow" name=zamow>
	</FORM></center>';
			

} elseif (isset($_POST['zamow'])) {
##kupno - operacje na bazie
				$query = "SELECT * FROM F_dilerkaHandlarz WHERE id_handlarza='1' AND typDraga='$drags' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$drag = Drag($rekord[1]);
$ile=$_POST['ile'];

$cenasztuki = ModyfikatorCen($rekord['cena'], $id);
$cena= $ile*$cenasztuki;

		 if (Hajs($id)<$cena) {
			 ## nie ma hajsu
			 $newsy = $newsy .'<center><br><br><font>Niestety, nie masz wystarczajacej iloci pieniedzy.';
		 } else {
			 ## ma hajs, wszystko smiga
				$query = "SELECT * FROM F_dilerkaInwentarz WHERE id_kto='$id' AND typDraga='$drags'"; 
				 $wynik = mysql_query($query); 
				 if (mysql_num_rows($wynik) == 0) {
									$query = "SELECT count(*) FROM F_dilerkaInwentarz WHERE id_kto='$id'"; 
									$wynik = mysql_query($query); 
									$rekord = mysql_fetch_array ($wynik);
									if ($rekord[0]<5) {
			 					$query = "INSERT INTO F_dilerkaInwentarz (id_kto, typDraga, ilosc, cena) VALUES ('$id', '$drags', '$ile', '$cenasztuki')"; 
								mysql_query($query);
								OdejmijHajs($id, $cena);
 								$newsy = $newsy .'<center><br><br><font>Towar zostal dostarczony. Mozesz go juz sprzedawac</font>';
									} else {
								$newsy = $newsy .'<center><br><br><font>Mozesz dilowac maxymalnie 5 rodzajow dragow!<font>';
									}
				 } else {

				$rekord = mysql_fetch_array ($wynik);
				$ile=$rekord[ilosc]+$ile;
		 		$query = "UPDATE F_dilerkaInwentarz SET ilosc='$ile' WHERE id_kto='$id' AND typDraga='$drags'"; 
							 mysql_query($query);
							OdejmijHajs($id, $cena);
 			 $newsy = $newsy .'<center><br><br><font>Towar zostal dostarczony. Mozesz go juz sprzedawac</font>';
				 }
 		 }


} else {
## oferta
if (!isset($drag_pocz)) { 
			$drag_pocz = 0;
		}
			$newsy = $newsy .'<font><b>Dostepne towary:</b></font><br><br>';
			$queryIlosc = "SELECT count(*) FROM F_dilerkaHandlarz WHERE id_handlarza='1'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
				$query = "SELECT * FROM F_dilerkaHandlarz WHERE id_handlarza='1' ORDER BY cena LIMIT $drag_pocz, 6"; 
        $wynik = mysql_query($query); 

$newsy = $newsy .'<table border=0 width=100%><tr>';
			$konter = 0;
		while($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
			$rekord[2] =  ModyfikatorCen($rekord[2], $id);

			$drag = Drag($rekord[1]);

$newsy = $newsy .'<td valign=top height=65 width=65><a href=main.php?lokacja=o_dilerka_hurtownia&drags=' .$rekord[1] .'><img src="gfx/ikony/dragi/' .$drag[0] .'.jpg" title="' .$drag['nazwa'] .'"></td><td valign=left><font class=rapy><b>' .$drag['nazwa'] .'</b> - ' .$drag['opis'] .' [cena ' .$rekord['2'] .'HJS]</font></a></td>';
			if ($konter==2) { $newsy = $newsy .'</tr><tr>';
			$konter=0; }

		}
			$newsy = $newsy .'</table>';

		$newsy = $newsy .'<br>';
if ($drag_pocz!=0) {
		$drag_pocz2= $drag_pocz-6;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=o_dilerka_hurtownia&drag_pocz=' .$drag_pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$ilosc=$ilosc[0]-6;
		if (!($drag_pocz>=$ilosc)) {
		$drag_pocz= $drag_pocz+6;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=o_dilerka_hurtownia&drag_pocz=' .$drag_pocz .'> [nastepne >>]</a></div></font>';
		}
}
}

$przyciski = $przyciski .'<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>';
$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>