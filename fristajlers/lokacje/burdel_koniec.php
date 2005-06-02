<?
include('conf/stats.php');


if (!isset($_POST['tak'])) {

$queryIlosc = "SELECT rand FROM F_burdele WHERE id_wlasc='$id'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$kwota = $ilosc['rand'];
	$newsy = $newsy .'<center><br><br><font> Chcesz sprzedac burdel? Moge dac Ci za ten lokal maxymalnie ' .$kwota .'HJS</font>
	<table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_koniec">
	<INPUT TYPE="hidden" value="' .$kwota .'" name=kwota>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
} else {
		
		$sklep_id = MaBurdel($id);
		$queryDel = "DELETE FROM F_burdele WHERE id_wlasc='$id'"; 
	    mysql_query($queryDel); 
		
		$queryDel = "DELETE FROM F_burdeleStan WHERE burdel_id='$burdel_id'"; 
	    mysql_query($queryDel); 
	$newsy = $newsy .'<center><br><br><font> Burdel zostal sprzedany. </font>';
	DodajHajs($id, $_POST['kwota']);
		}


$dane=array(
	'lokacja'=> TloLokacji('burdel'), 
	'przyciski'=> '<td><a href=main.php?lokacja=burdel_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>