<?
include('conf/stats.php');

if (isset($temat) && isset($forum) && !isset($tresc)) {
	$newsy = $newsy .'Wypowiedz na temat: <br><br>';
	$query = "SELECT * FROM F_ForumTematy WHERE nr_tematu = '$temat'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array($wynik);
	$newsy = $newsy .'<b>' .$rekord[temat] .'</b><br><br>';
	$newsy = $newsy .'<TABLE width=100%><TR><TD bgcolor=silver><font class="ziom"><B> ' .Ksywka($rekord[id_kto]) .' [' .$rekord[datatime] .'] napisal:</B></font></TD></TR>'; 
	$newsy = $newsy .'<TR><TD bgcolor=white><font style="color:black"> ' .$rekord[tresc] .'</font></TD></TR></TABLE><br>
<form method="POST" action="main.php?lokacja=forum_dodaj">
<font size=-2>Tresc posta:<br></font>
<textarea rows="8" name="tresc" cols="45"></textarea><br>
<input type=hidden value=' .$forum .' name=forum>
<input type=hidden value=' .$temat .' name=temat>
<input type=submit value="wyslij">
</form>';

} elseif (isset($_POST['tresc'])) {
	$tresc = strip_tags($_POST['tresc']);
	$tresc = addslashes($tresc);
	$datatime =  date("Y-m-d H:i:s");
	$query = "INSERT INTO F_ForumPosty (nr_tematu, tresc, id_kto, datatime) VALUES ('$temat', '$tresc',  '$id', '$datatime')"; 
	mysql_query($query); 
	$query = "UPDATE F_ForumTematy SET ost_temat = '$datatime' WHERE nr_tematu = '$temat'"; 
	mysql_query($query); 
	$newsy = $newsy .'Dziekujemy za udzielenie komentarza.';

}





$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<TD><a href=main.php?lokacja=forum_posty&forum=' .$forum .'&temat=' .$temat .'><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
?>