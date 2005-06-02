<?
include('conf/stats.php');

if (CzyWEkipie($id)==2) {
if (isset($wyslane)) {


$nr=NrEkipy($id);
$ekipa=Ekipa($nr);




	$query = "UPDATE F_glowneDane SET ekipa='0' WHERE id='$id'"; 
        mysql_query($query); 
	$newsy = $newsy .'<font>Odszedles z ekipy.</font>';


} else {

$nr=NrEkipy($id);
$ekipa=Ekipa($nr);
$newsy = $newsy .'<form method="post" action=main.php?lokacja=o_ekipa_odejdz> <table>
		<tr><td>nazwa ekipy: <br><font size=-2><i>nazwa Twojej ekipy</i></font></td><td><font><b>[ <i>' .$ekipa[1] .'</i> ]</b></font></td></tr>
		<br><table border=0><tr><td><input type="submit" name="wyslane" value="odejdz"></form></td><td>		
</td></tr></table>';

}
}



$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Wiadomosc do wszystkich"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>