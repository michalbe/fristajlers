<?
include('conf/stats.php');

if (!isset($_POST['tak'])) {
	$newsy = $newsy .'<center><br><br><font> Chcesz zrezygnowac z dilowania?</font>
	<table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_koniec">
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=o_dilerka_start">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
} else {

		$queryDel = "DELETE FROM F_dilerka WHERE id_kto='$id'"; 
	    mysql_query($queryDel); 
		
		$queryDel = "DELETE FROM F_dilerkaInwentarz WHERE id_kto='$id'"; 
	    mysql_query($queryDel); 
	$newsy = $newsy .'<center><br><br><font> Nie jestes juz dilerem.</font>';

		}


$przyciski = $przyciski .'<TD><a href="?lokacja=o_dilerka_start"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>';
$dane=array(
	'lokacja'=> TloLokacji('o_dilerka'), 
	'przyciski'=> $przyciski,
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>