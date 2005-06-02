<?
include('conf/stats.php');


$query = "SELECT * FROM F_ekwipunek WHERE id_kto='$id' AND typTowaru='$item'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$przed = $przed .'<div class=przed>ERROR.<br></div>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
$item = Itemy($item);
switch ($item['rare']) {
	case 1:
		$rare = '<font class=kiepska> pospolity </font>';
	break;
	case 2:
		$rare = '<font class=slaba> niepospolity </font>';
	break;
	case 3:
		$rare = '<font class=neutralna> rzadki </font>';
	break;
	case 4:
		$rare = '<font class=dobra> bardzo rzadki </font>';
	break;
	case 5:
		$rare = '<font class=mistrzowa> niespotykany </font>';
	break;
}
$submit = '<form method=post action="?lokacja=item-uekwip" style="float:right"><input type=submit value=" wyekwipuj " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'><input type=hidden name=item value=' .$item['lp'] .'></form>';

$przed = '<div class=przed><center><b>SZCZEGOLY PRZEDMIOTU</b><br/><img src=gfx/ikony/itemy/' .$item['lp'] .'.jpg border=2></center>' .$item['nazwa'] .' - ' .$item['opis'] .'<br><br><center>klasa przedmiotu: <b>' .$rare .'</b><br><br>' .$submit .'</center></div>';
}	

$dane=array(
	'lokacja'=> TloLokacji('miasto'), 
	'przyciski'=> '<TD><a href="?lokacja=miasto"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 