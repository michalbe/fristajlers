<?
include('conf/stats.php');

if (isset($_POST['tak'])) {

$id_ekipy=CzyZaproszony($id);
	$query = "UPDATE F_glowneDane SET ekipa='$id_ekipy' WHERE id='$id'"; 
			mysql_query($query); 
$newsy = $newsy .'<center><br><br><font> Gratuluje. Jestes teraz pelnoprawnym czlonkiem nowej ekipy.</font></center>';
		$queryDel = "DELETE FROM F_ekipyDodaj WHERE id_kto='$id'"; 
	    mysql_query($queryDel); 

} elseif (isset($_POST['nie'])) {

		$queryDel = "DELETE FROM F_ekipyDodaj WHERE id_kto='$id'"; 
	    mysql_query($queryDel); 

$newsy = $newsy .'<center><br><br><font> Nie zgodziles sie na dolaczenie do ekipy</font></center>';

}



$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Osiedle"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>