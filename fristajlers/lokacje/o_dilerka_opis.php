<?
include('conf/stats.php');

if (isset($_POST['wyslij'])) {
$co = strip_tags($_POST['co']);
	$query = "UPDATE F_dilerka SET opis='$co' WHERE id_kto='$id'"; 
        mysql_query($query); 
	$newsy = $newsy .pl_win2iso('<center><br><br><font>Opis zmieniony</font>');

} else {
		$query1 = "SELECT opis FROM F_dilerka WHERE id_kto='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);
$newsy = $newsy .'<form method="POST" action="main.php?lokacja=o_dilerka_opis">
<font size=-2>Wprowadz swoj opis:<br></font>
<textarea rows="8" name="co" cols="45">' .$rekord1['opis'] .'</textarea><br>
<input type=submit value="wyslij" name=wyslij>
</form>';
}


$przyciski = $przyciski .'<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>';
$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>