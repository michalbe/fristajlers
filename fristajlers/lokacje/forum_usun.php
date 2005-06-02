<?
include('conf/stats.php');

		$query = "SELECT * FROM F_ForumModerator WHERE id_forum = '$forum' AND id_moderator='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) != 0) { 

if (isset($_POST['tak'])) {

if (isset($temat)) {#
		 		$query = "DELETE FROM F_ForumPosty WHERE nr_tematu='$_POST[temat]'"; 
							 mysql_query($query);
	$query = "DELETE FROM F_ForumTematy WHERE nr_tematu='$_POST[temat]'"; 
							 mysql_query($query);
		$newsy = $newsy .'<center><br><br><font>Temat zostal usuniety.</font>';
}#

if (isset($post)) {#
		 		$query = "DELETE FROM F_ForumPosty WHERE nr_wyp='$_POST[post]'"; 
							 mysql_query($query);

		$newsy = $newsy .'<center><br><br><font>Post zostal usuniety.</font>';
}#

##ZAAKCEPTOWANE WYRZUCENIE
} else {
if (isset($temat)) {
##USUWASZ CALTY TEMAT
$newsy = $newsy .'<center><br><br><font>Na pewno chcesz usunac caly temat?</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=forum_usun">
	<INPUT TYPE="hidden" name=temat value=' .$temat .'>
	<INPUT TYPE="hidden" name=forum value=' .$forum .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=forum_tematy&forum=' .$forum .'">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';

}
if (isset($post)) {
##USUWASZ POST
$newsy = $newsy .'<center><br><br><font>Na pewno chcesz usunac posta?</font><table border=0><tr><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=forum_usun">
	<INPUT TYPE="hidden" name=post value=' .$post .'>
	<INPUT TYPE="hidden" name=forum value=' .$forum .'>
	<INPUT TYPE="submit" value="tak" name=tak>
	</FORM></td><td>
	<FORM METHOD=POST ACTION="main.php?lokacja=forum_tematy&forum=' .$forum .'">
	<INPUT TYPE="submit" value="nie">
	</FORM></td></tr></table></center>';
}
}


$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<td><a href=main.php?lokacja=forum_tematy&forum='.$forum.'><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
}
?>