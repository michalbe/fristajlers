<?
include('conf/stats.php');
if (MaKs($id)) {
$sport_id = MaKs($id);
if ((isset($trening)) && (!isset($zmien))) {
##
				$query = "SELECT * FROM F_sportyZaop WHERE id_zaop='1' AND typTreningu='$trening' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$trenings = trening($rekord[1]);
### 3 linijki nizej zbieramy cene zeby wyswietlic w inpucie ####
				$query = "SELECT cena, cena_ekipa FROM F_sportyStan WHERE typTreningu='$trening' AND sport_id='$sport_id'"; 
				 $wynik = mysql_query($query); 
				$cen_akt = mysql_fetch_array ($wynik);
			#################
				$rekord[2] = ModyfikatorCen($rekord[2], $id);
		$newsy = $newsy .'<br><br><font><b>' .$trenings[1] .'</b>&nbsp;&nbsp; ' .$rekord[2] .'PLN</a><br>&nbsp;&nbsp;<i>'.$trenings[2] .'</i></font><br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=ks_cena">
	<font>Podaj nowa cene:</font><INPUT size=3 TYPE="text" NAME="cena" VALUE="'.$cen_akt['cena'] .'">';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'<br><font>Podaj cene dla ekipy:</font><INPUT size=3 TYPE="text" NAME="cena_ekipa"  VALUE="'.$cen_akt['cena_ekipa'] .'"><br>'; }
$newsy = $newsy .'<INPUT TYPE="hidden" name=trening value=' .$trening .'>
	<INPUT TYPE="submit" value="zmien" name=zmien>
	</FORM></center>';

} elseif (isset($_POST['zmien'])) {
	$cena=$_POST['cena'];
	addslashes($cena);
if (isset($_POST['cena_ekipa'])) {
		$cena_ekipa=addslashes($_POST['cena_ekipa']);
 	} else {
	$cena_ekipa = $cena;
	}
	$query = "UPDATE F_sportyStan SET cena='$cena', cena_ekipa='$cena_ekipa' WHERE sport_id='$sport_id' AND typTreningu='$trening'"; 
	mysql_query($query);
	 			 $newsy = $newsy .'<center><br><br><font>Cena treningu zostala zmieniona.</font>';
}
}


$dane=array(
	'lokacja'=> TloLokacji('ks'), 
	'przyciski'=> '<td><a href=main.php?lokacja=ks_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>