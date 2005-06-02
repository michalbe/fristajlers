<?
include('conf/stats.php');


$query = "SELECT * FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$_POST[item]'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$przed = $przed .'<div class=przed>ERROR.<br></div>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
	$query = "SELECT count(*) FROM F_targ WHERE kto='$id'"; 
$wynik = mysql_query($query); 
$rekord = mysql_fetch_row($wynik);
if ($rekord[0]>4) {
	$tekst = '<div class=przed>MOZESZ SPRZEDAWAC MAXYMALNIE 5 PRZEDMIOTOW JEDNOCZESNIE!!!!<br></div>';
} else {
	$tekst = '<div class=przed>PRZEDMIOT WYSTAWIONY NA SPRZEDAZ.<br></div>';
		$rare = Itemy($_POST['item']);
		$query = "INSERT INTO F_targ (kto, co, cena, rare) VALUES ('$id', '$_POST[item]', '$_POST[cena]', '$rare[rare]')"; 
		$wynik = mysql_query($query); 
	
	$query = "DELETE FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$_POST[item]' LIMIT 1"; 
	$wynik = mysql_query($query); 
####EDYJA STATSOW
	}
}
	$przed = $przed .$tekst; 
$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<TD><a href="?lokacja=targ-add"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 