<?
include('conf/stats.php');
if (!isset($_POST['tak'])) {

$queryIlosc = "SELECT rand FROM F_sklepy WHERE id_wlasc='$id'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$kwota = $ilosc['rand'];
	$newsy = $newsy .'<center><br><br><font> Chcesz sprzedac sklep? Moge dac Ci za ten lokal maxymalnie ' .$kwota .'HJS</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh_koniec">
	<INPUT TYPE="hidden" value="' .$kwota .'" name=kwota>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
} else {
		
		$sport_id = MaSklep($id);
		$queryDel = "DELETE FROM F_sklepy WHERE id_wlasc='$id'"; 
	    mysql_query($queryDel); 
		
		$queryDel = "DELETE FROM F_sklepyInwentarz WHERE sport_id='$sport_id'"; 
	    mysql_query($queryDel); 
	$newsy = $newsy .'<center><br><br><font> Sprzedales swoj sklep.</font>';
	DodajHajs($id, $_POST['kwota']);
		}


$dane=array(
	'lokacja'=> TloLokacji('dh'), 
	'przyciski'=> '<td><a href=main.php?lokacja=dh_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>