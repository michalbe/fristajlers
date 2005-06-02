<?
include('conf/stats.php');

if (MaSklep($id)) {
$sklep_id = MaSklep($id);
if (isset($_POST['tak'])) {
$newsy = $newsy .'<center><br><br><font>Towar zostal usuniety.</font>';
		 		$query = "DELETE FROM F_sklepyInwentarz WHERE sklep_id='$sklep_id' AND typtowaru='$_POST[towar]'"; 
							 mysql_query($query);
} else {

$newsy = $newsy .'<center><br><br><font>Na pewno chcesz pozbyc sie tych towarow? Nie bedziesz mial potem mozliwosci ich odzyskania.</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh_wywal">
	<INPUT TYPE="hidden" name=towar value=' .$towar .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=dh_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';}
}



$dane=array(
	'lokacja'=> TloLokacji('dh'), 
	'przyciski'=> '<td><a href=main.php?lokacja=dh_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>