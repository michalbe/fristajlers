<?
include('conf/stats.php');

if (MaBurdel($id)) {
$burdel_id = MaBurdel($id);
if ((isset($towar)) && (!isset($zmien))) {
##
				$query = "SELECT * FROM F_burdeleStan WHERE burdel_id='$burdel_id' AND dziwka='$towar' ORDER BY cena"; 
				 $wynik = mysql_query($query); 
				$rekord = mysql_fetch_array ($wynik);
				$Dziwka = Dziwka($rekord[1]);
			### 3 linijki nizej zbieramy cene zeby wyswietlic w inpucie ####
				$query = "SELECT cena, cena_ekipa FROM F_burdeleStan WHERE dziwka='$towar' AND burdel_id='$burdel_id'"; 
				 $wynik = mysql_query($query); 
				$cen_akt = mysql_fetch_array ($wynik);
			#################
		$newsy = $newsy .'<br><br><font><b>' .$Dziwka[1] .'</b>&nbsp;&nbsp; aktualna cena ' .$rekord[3] .'HJS</a><br>&nbsp;&nbsp;</font><br><br><center><FORM METHOD=POST ACTION="main.php?lokacja=burdel_cena">
	<font>Podaj nowa cene:</font><INPUT size=3 TYPE="text" NAME="cena"  VALUE="'.$cen_akt['cena'] .'">';
if (CzyWEkipie($id)!=0) { $newsy = $newsy .'<br><font>Podaj cene dla ekipy:</font><INPUT size=3 TYPE="text" NAME="cena_ekipa"  VALUE="'.$cen_akt['cena_ekipa'] .'"><br>'; }
$newsy = $newsy .'<INPUT TYPE="hidden" name=towar value=' .$towar .'>
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

	$query = "UPDATE F_burdeleStan SET	cena='$cena', cena_ekipa='$cena_ekipa' WHERE burdel_id='$burdel_id' AND dziwka='$towar'"; 
	mysql_query($query);
	 			 $newsy = $newsy .'<center><br><br><font>Cena dziwki zostala zmieniona.</font>';
}
}


$dane=array(
	'lokacja'=> TloLokacji('burdel'), 
	'przyciski'=> '<td><a href=main.php?lokacja=burdel_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>