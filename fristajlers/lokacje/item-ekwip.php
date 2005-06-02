<?
include('conf/stats.php');

$query = "SELECT * FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$item'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$przed = $przed .'<div class=przed>ERROR.<br></div>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
$query = "SELECT count(*) FROM F_ekwipunek WHERE id_kto='$id'"; 
$wynik = mysql_query($query); 
$rekord = mysql_fetch_row($wynik);
if (($rekord[0]>3)&&($_POST['jednorazowy']==0)) {
	$przed = $przed .'<div class=przed>MOZESZ MIEC MAKSYMALNIE 4 PRZEDMIOTY W EKWIPUNKU!!<br></div>';
} else {
	
	$tekst = '<div class=przed>PRZEDMIOT UZYTY<br></div>';
	if ($_POST['jednorazowy']==0) {
		$query = "INSERT INTO F_ekwipunek (id_kto, typTowaru) VALUES ('$id', '$_POST[item]')"; 
		$wynik = mysql_query($query); 
		$tekst = '<div class=przed>PRZEDMIOT DODANY DO EKWIPUNKU<br></div>'; 
	}
	$query = "DELETE FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$_POST[item]' LIMIT 1"; 
	$wynik = mysql_query($query); 
####EDYJA STATSOW
	$item = Itemy($_POST['item']);
	$stats = PrzekazStatsyArray($id);
	
	$energia = $item['energia']+$stats['energia'];
	$inteligencja = $item['inteligencja']+$stats['inteligencja'];
	$wiedza = $item['wiedza']+$stats['wiedza'];
	$flow = $item['flow']+$stats['flow'];
	$styl = $item['styl']+$stats['styl'];
	$kondycja = $item['kondycja']+$stats['kondycja'];
	$napiecie = $item['napiecie']+$stats['napiecie'];
	$forma = $item['forma']+$stats['forma'];
	$punche = $item['punche']+$stats['punche'];

	$query = "UPDATE F_stats SET flow='$flow', energia='$energia', inteligencja='$inteligencja', inteligencja_aktualna='$inteligencja' , wiedza='$wiedza', napiecie='$napiecie', napiecie_aktualne='$napiecie', styl='$styl', kondycja='$kondycja', forma='$forma', punche='$punche' WHERE id='$id'"; 
		$wynik = mysql_query($query); 

	$przed = $przed .$tekst; 
}
}
$dane=array(
	'lokacja'=> TloLokacji('szafa'), 
	'przyciski'=> '<TD><a href="?lokacja=itemy"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 