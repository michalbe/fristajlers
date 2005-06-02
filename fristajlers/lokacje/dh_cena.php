<?
include('conf/stats.php');
if (MaSklep($id)) {
$sklep_id = MaSklep($id);
if ((isset($towar)) && (!isset($zmien))) {
##
				$query = "SELECT * FROM F_sklepyHurtownie WHERE hurt_id='1' AND typtowaru='$towar' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$towars = Szama($rekord[1]);
			### 3 linijki nizej zbieramy cene zeby wyswietlic w inpucie ####
				$query = "SELECT cena, cena_ekipa FROM F_sklepyInwentarz WHERE typTowaru='$towar' AND sklep_id='$sklep_id'"; 
				 $wynik = mysql_query($query); 
				$cen_akt = mysql_fetch_array ($wynik);
			#################
				$rekord[2] = ModyfikatorCen($rekord[2], $id);
		$newsy = $newsy .'<br><br><font><b>' .$towars[1] .'</b>&nbsp;&nbsp; cena hurtowa: ' .$rekord[2] .'HJS</a><br>&nbsp;&nbsp;<i>'.$towars[2] .'</i></font><br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=dh_cena">
	<font>Podaj nowa cene:</font><INPUT size=3 TYPE="text" NAME="cena"  VALUE="'.$cen_akt['cena'] .'">';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'<br><font>Podaj cene dla ekipy:</font><INPUT size=3 TYPE="text" NAME="cena_ekipa"  VALUE="'.$cen_akt['cena_ekipa'] .'"><br>'; }
$newsy = $newsy .'<INPUT TYPE="hidden" name=towar value=' .$towar .'>
	<INPUT TYPE="submit" value="zmien" name=zmien>
	</FORM></center>';

} elseif (isset($_POST['zmien'])) {
	$cena=addslashes($_POST['cena']);
	
	if (isset($_POST['cena_ekipa'])) {
		$cena_ekipa=addslashes($_POST['cena_ekipa']);
 	} else {
	$cena_ekipa = $cena;
	}
		$query = "UPDATE F_sklepyInwentarz SET cena='$cena', cena_ekipa='$cena_ekipa' WHERE sklep_id='$sklep_id' AND typtowaru='$towar'";  

	mysql_query($query);
	 			 $newsy = $newsy .'<center><br><br><font>Cena towaru zostala zmieniona.</font>';
}
}


$dane=array(
	'lokacja'=> TloLokacji('dh'), 
	'przyciski'=> '<td><a href=main.php?lokacja=dh_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>