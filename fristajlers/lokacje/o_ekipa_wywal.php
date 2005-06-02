<?
include('conf/stats.php');

if (CzyWEkipie($id)==1) {
if (isset($wyslane)) {


$nr_wywalonego=NrEkipy($iddo);
$ekipa_wywalonego=Ekipa($nr_wywalonego);

	if ($ekipa_wywalonego['id_szef']==$id){


	$co = strip_tags($co);
	PiszWiadomosc($id, $iddo, $co);

	$query = "UPDATE F_glowneDane SET ekipa='0' WHERE id='$iddo'"; 
        mysql_query($query); 
	$newsy = $newsy .'<font>Fristajlowiec zostal usuniety z ekipy.</font>';
		} else {
		$newsy = $newsy .'ERROR<br>';
		}

} else {

$nr=NrEkipy($id);
$ekipa=Ekipa($nr);
$newsy = $newsy .'<form method="post" action=main.php?lokacja=o_ekipa_wywal> <table>
		<tr><td>nazwa ekipy: <br><font size=-2><i>nazwa Twojej ekipy</i></font></td><td><font><b>[ <i>' .$ekipa[1] .'</i> ]</b></font></td></tr>
		<tr><td>ksywka fristajlowca: <br><font size=-2><i>ktorego chcesz wywalic</i></font></td><td><font><b>[ <i>' .Ksywka($id_wywal) .'</i> ]</b></font></td></tr>
		<tr><td>wiadomosc: <br><font size=-2><i>uzasadnienie decyzji</i></font></td><td><textarea rows="3" name="co" cols="15"></textarea></td></tr>
		<br><table border=0><tr><td><INPUT TYPE="hidden" value=' .$id_wywal .' name=iddo>
		<input type="submit" name="wyslane" value="wywal"></form></td><td>		
</td></tr></table>';

}
}



$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Wiadomosc do wszystkich"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>