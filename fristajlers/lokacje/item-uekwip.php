<?
include('conf/stats.php');

$query = "SELECT * FROM F_ekwipunek WHERE id_kto='$id' AND typTowaru='$item'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$przed = $przed .'<div class=przed>ERROR.<br></div>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
$query = "SELECT count(*) FROM F_skrytkaItemy WHERE id_kto='$id'"; 
$wynik = mysql_query($query); 
$rekord = mysql_fetch_row($wynik);
if ($rekord[0]>11) {
	$przed = $przed .'<div class=przed>ABY WYEKWIPOWAC PRZEDMIOT MUSISZ ZROBIC DLA NIEGO MIEJSCE W SZAFIE!!<br></div>';
} else {

	$query = "INSERT INTO F_skrytkaItemy (id_kto, typTowaru) VALUES ('$id', '$_POST[item]')"; 
	$wynik = mysql_query($query); 
	$query = "DELETE FROM F_ekwipunek WHERE id_kto='$id' AND typTowaru='$_POST[item]' LIMIT 1"; 
	$wynik = mysql_query($query); 
####EDYJA STATSOW
	$item = Itemy($_POST['item']);
	$stats = PrzekazStatsyArray($id);
	
	$energia = $stats['energia']-$item['energia'];
	$inteligencja = $stats['inteligencja']-$item['inteligencja'];
	$wiedza = $stats['wiedza']-$item['wiedza'];
	$flow = $stats['flow']-$item['flow'];
	$styl = $stats['styl']-$item['styl'];
	$kondycja = $stats['kondycja']-$item['kondycja'];
	$napiecie = $stats['napiecie']-$item['napiecie'];
	$forma = $stats['forma']-$item['forma'];
	$punche = $stats['punche']-$item['punche'];

	$query = "UPDATE F_stats SET flow='$flow', energia='$energia', inteligencja='$inteligencja', inteligencja_aktualna='$inteligencja' , wiedza='$wiedza', napiecie='$napiecie', napiecie_aktualne='$napiecie', styl='$styl', kondycja='$kondycja', forma='$forma', punche='$punche' WHERE id='$id'"; 
		$wynik = mysql_query($query); 

	$przed = $przed .'<div class=przed>PRZEDMIOT WYEKWIPOWANY<br></div>'; 
}
}
$dane=array(
	'lokacja'=> TloLokacji('szafa'), 
	'przyciski'=> '<TD><a href="?lokacja=itemy"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 