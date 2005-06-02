<?
include('conf/stats.php');

if (CzyDiluje($id)) {

if ((isset($drags)) && (!isset($zmien))) {
##
				$query = "SELECT * FROM F_dilerkaHandlarz WHERE id_handlarza='1' AND typDraga='$drags' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$drag = Drag($rekord[1]);
		### 3 linijki nizej zbieramy cene zeby wyswietlic w inpucie ####
				$query = "SELECT cena, cena_ekipa FROM F_dilerkaInwentarz WHERE typDraga='$drags' AND id_kto='$id'"; 
				 $wynik = mysql_query($query); 
				$cen_akt = mysql_fetch_array ($wynik);
			#################
		$newsy = $newsy .'<br><br><font><b>' .$drag[1] .'</b>&nbsp;&nbsp; ' .ModyfikatorCen($rekord[2], $id) .'PLN</a><br>&nbsp;&nbsp;<i>'.$drag[2] .'</i></font><br>
	<br><center><FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_cena">
	<font>Podaj nowa cene:</font><INPUT size=3 TYPE="text" NAME="cena" VALUE="'.$cen_akt['cena'] .'">';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'<br><font>Podaj cene dla ekipy:</font><INPUT size=3 TYPE="text" NAME="cena_ekipa"  VALUE="'.$cen_akt['cena_ekipa'] .'"><br>'; }
$newsy = $newsy .'<INPUT TYPE="hidden" name=drags value=' .$drags .'>
	<INPUT TYPE="submit" value="zmien" name=zmien>
	</FORM></center>';			

} elseif (isset($_POST['zmien'])) {
	$cena=$_POST['cena'];

	if (isset($_POST['cena_ekipa'])) {
		$cena_ekipa=addslashes($_POST['cena_ekipa']);
 	} else {
	$cena_ekipa = $cena;
	}

	$query = "UPDATE F_dilerkaInwentarz SET	cena='$cena', cena_ekipa='$cena_ekipa' WHERE id_kto='$id' AND typDraga='$drags'"; 
	mysql_query($query);
	 			 $newsy = $newsy .'<center><br><br><font>Cena draga zostala zmieniona.</font>';
}
}


$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> '<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>