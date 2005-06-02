<?
include('conf/stats.php');

if (isset($iddo) && !isset($co)) {
$newsy = $newsy .'<center><form method="POST" action="main.php?lokacja=pisz">
<font size=-2>Podaj tresc wiadomosci<br></font>
<textarea rows="8" name="co" cols="45"></textarea><br>
<input type=hidden value=' .$iddo .' name=iddo>
<input type=submit value="wyslij">
</form></center>';
} elseif (isset($co)) {
	$co = strip_tags($co);
	PiszWiadomosc($id, $iddo, $co);
	$newsy = $newsy .'<center><font size=-1> Wiadomosc wyslana.</font></center>';

}


$dane=array(
	'lokacja'=> TloLokacji('poczta'), 
	'przyciski'=> '<TD><a href="?lokacja=o_profil&nr=' .$iddo .'"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>