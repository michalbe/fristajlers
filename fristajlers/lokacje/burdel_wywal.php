<?
include('conf/stats.php');

if (MaBurdel($id)) {
$burdel_id = MaBurdel($id);
if (isset($_POST['tak'])) {
$newsy = $newsy .'<center><br><br><font>Dziwka wypuszczona.</font>';
		 		$query = "DELETE FROM F_burdeleStan WHERE burdel_id='$burdel_id' AND dziwka='$_POST[towar]'"; 
							 mysql_query($query);
} else {

$newsy = $newsy .'<center><br><br><font>Na pewno chcesz wypuscic dziwki? Nie bedziesz mial potem mozliwosci ich odzyskania.</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_wywal">
	<INPUT TYPE="hidden" name=towar value=' .$towar .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=burdel_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';}
}



$dane=array(
	'lokacja'=> TloLokacji('burdel'), 
	'przyciski'=> '<td><a href=main.php?lokacja=burdel_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>