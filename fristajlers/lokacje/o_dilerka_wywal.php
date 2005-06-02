<?
include('conf/stats.php');

if (isset($_POST['tak'])) {
$newsy = $newsy .'<center><br><br><font>Ok, pozbyles sie dragow.</font>';
		 		$query = "DELETE FROM F_dilerkaInwentarz WHERE id_kto='$id' AND typDraga='$_POST[drags]'"; 
							 mysql_query($query);
} else {

$newsy = $newsy .'<center><br><br><font>Na pewno chcesz wyrzucic te dragi? Nie bedziesz mial mozliwosci ich odzyskania.</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_wywal">
	<INPUT TYPE="hidden" name=drags value=' .$drags .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
}

$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> '<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>