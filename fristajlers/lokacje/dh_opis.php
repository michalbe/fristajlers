<?
include('conf/stats.php');

if (MaSklep($id)) {
if (isset($_POST['wyslij'])) {
$co = strip_tags($_POST['co']);
$conazwa = strip_tags($_POST['conazwa']);
$conazwa = substr($conazwa, 0, 25);
	$query = "UPDATE F_sklepy SET opis='$co', nazwa='$conazwa' WHERE id_wlasc='$id'"; 
        mysql_query($query); 
	$newsy = $newsy .'<center><br><br><font>Twoj opis zostal zaakceptowany.</font>';

} else {

		$query1 = "SELECT opis, nazwa FROM F_sklepy WHERE id_wlasc='$id'"; 
        $wynik1 = mysql_query($query1); 
		$rekord1 = mysql_fetch_array ($wynik1);

$newsy = $newsy .'<form method="POST" action="main.php?lokacja=dh_opis">
<font size=-2>Wprowadz swoj opis:<br></font>
<textarea rows="8" name="co" cols="45">' .$rekord1['opis'] .'</textarea><br>
<font size=-2>Wprowadz nazwe:<br></font>
<INPUT TYPE="text" NAME="conazwa" value="' .$rekord1['nazwa'] .'"><br>
<input type=submit value="wyslij" name=wyslij>
</form>';
}
}




$dane=array(
	'lokacja'=> TloLokacji('dh'), 
	'przyciski'=> '<td><a href=main.php?lokacja=dh_start><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>