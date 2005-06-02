<?
include('conf/stats.php');

if (MaKs($id)) {
$sport_id = MaKs($id);
if (isset($_POST['tak'])) {
$newsy = $newsy .'<center><br><br><font>Trening zostal usuniety.</font>';
		 		$query = "DELETE FROM F_sportyStan WHERE sport_id='$sport_id' AND typTreningu='$_POST[trening]'"; 
							 mysql_query($query);
} else {

$newsy = $newsy .'<center><br><br><font>Na pewno chcesz pozbyc sie tych treningow? Nie bedziesz mial potem mozliwosci ich odzyskania.</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=ks_wywal">
	<INPUT TYPE="hidden" name=trening value=' .$trening .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=ks_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';}
}



$dane=array(
	'lokacja'=> TloLokacji('ks'), 
	'przyciski'=> '<td><a href=main.php?lokacja=ks_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>