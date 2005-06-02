<?
include('conf/stats.php');

$query = "SELECT count(*) FROM F_skrytkaItemy WHERE id_kto='$id'"; 
$wynik = mysql_query($query); 
$rekord = mysql_fetch_row($wynik);
if ($rekord[0]>11) {
	$przed = $przed .'<div class=przed>ABY KUPIC PRZEDMIOT MUSISZ MIEC MIEJSCE W SZAFIE!<br></div>';
} else {
	
	
$query = "SELECT co, cena, kto FROM F_targ WHERE lp='$lp'"; 
$wynik = mysql_query($query); 
$rekord = mysql_fetch_assoc($wynik);
		if ($id==$rekord['kto']) {
			$rekord['cena'] = 0;
		}
		if (Hajs($id)<$rekord['cena']) {
		$przed = $przed .'<div class=przed>NIE MASZ TYLE PIENIEDZY!!!<br></div>';
		} else {
$item = itemy($rekord['co']);
$tekst = '<div class=przed>PRZEDMIOT KUPIONY<br></div>';
		$query = "INSERT INTO F_skrytkaItemy (id_kto, typTowaru) VALUES ('$id', '$item[lp]')"; 
		$wynik = mysql_query($query); 
	
	$query = "DELETE FROM F_targ WHERE lp='$lp'"; 
	$wynik = mysql_query($query); 

ZamianaHajsu($id, $rekord['kto'], $rekord['cena']);
			$co = Ksywka($id) .' kupil od Ciebie przedmiot za ' .$rekord['cena'] .'HJS.';
			PiszWiadomosc(0, $rekord['kto'], $co);
	$przed = $przed .$tekst; 
}
}
$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<TD><a href="?lokacja=targ"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 