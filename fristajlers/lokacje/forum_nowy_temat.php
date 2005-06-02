<?
include('conf/stats.php');

if (isset($forum) && !isset($temat)) {

	$newsy = $newsy .'Dodaj nowy temat: <br><br>
<form method="POST" action="main.php?lokacja=forum_nowy_temat">
<font size=-2>Temat:<br></font><INPUT TYPE="text" NAME="temat">
<font size=-2><br>Tresc nowego tematu:<br></font>
<textarea rows="8" name="tresc" cols="45"></textarea><br>
<input type=hidden value='.$forum .' name=forum>
<input type=submit value="wyslij">
</form>';

} elseif (isset($_POST['temat'])) {
	$tresc = strip_tags($_POST['tresc']);
	$tresc = addslashes($tresc);
	$temat = strip_tags($_POST['temat']);
	$temat = addslashes($temat);
	$datatime =  date("Y-m-d H:i:s");
	$query = "INSERT INTO F_ForumTematy (nr_fora, temat, tresc, id_kto, datatime, ost_temat) VALUES ('$forum', '$temat', '$tresc',  '$id', '$datatime', '$datatime')"; 
	mysql_query($query); 

	$newsy = $newsy .pl_win2iso('Dziekujemy za zalozenie nowego tematu.<br><br>');

}


$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<TD><a href=main.php?lokacja=forum_tematy&forum=' .$forum .'><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
?>