<?
include('conf/stats.php');




if (!isset($co)) {
$newsy = $newsy .'<form method="POST" action="main.php?lokacja=o_ekipa_pisz">
<font size=-2>Podaj tresc wiadomosci:<br></font>
<textarea rows="8" name="co" cols="45"></textarea><br>
<input type=submit value="wyslij">
</form>';


} elseif (isset($co)) {

	$ekipa=NrEkipy($id);
	$ekipa=Ekipa($ekipa);
	$id_ekipy = $ekipa[0];

					$query2 = "SELECT id FROM F_glowneDane WHERE ekipa='$id_ekipy'"; 
			        $wynik2 = mysql_query($query2); 
	$co = strip_tags($co);
	while ($tabl=mysql_fetch_array($wynik2)) {
	PiszWiadomosc($id, $tabl['id'], $co);
	}
	$newsy = $newsy .'<font size=-1> Wiadomosc wyslana.</font>';

}


$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<td><a href=main.php?lokacja=o_ekipa><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>