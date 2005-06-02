<?
include('conf/stats.php');

if ($_POST['wyrzuc']==1) {
$przed = '<div class=przed><center><b>USUNIECIE PRZEDMIOTU</b><br><br><center>Napewno chcesz wyrzucic przedmiot? Nie bedziesz mogl go potem odzyskac.<br>
<form method=post action="?lokacja=item-szcz" style="float:right">
<input type=submit value=" tak " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'>
<input type=hidden name=wyrzuc value=2><input type=hidden name=item value=' .$_POST['item'] .'></form>
<form method=post action="?lokacja=itemy" style="float:right"><input type=submit value=" nie " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'></form></center></div>';

} elseif ($_POST['wyrzuc']==2) {

$query = "DELETE FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$item' LIMIT 1"; 
$wynik = mysql_query($query); 
$przed = '<div class=przed><center><b>PRZEDMIOT USUNIETY</b></center></div>';
} else {

$query = "SELECT * FROM F_skrytkaItemy WHERE id_kto='$id' AND typTowaru='$item'"; 
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
$submit = '<form method=post action="?lokacja=item-ekwip" style="float:right"><input type=submit value=" ekwipuj " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'><input type=hidden name=jednorazowy value=0><input type=hidden name=item value=' .$item['lp'] .'></form>';
if ($item['jednorazowy']==1) { $rare = 'jednorazowy, ' .$rare; $submit = '<form method=post action="?lokacja=item-ekwip" style="float:right"><input type=submit value=" uzyj " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'><input type=hidden name=jednorazowy value=1><input type=hidden name=item value=' .$item['lp'] .'></form>'; }
$przed = '<div class=przed><center><b>SZCZEGOLY PRZEDMIOTU</b><br/><img src=gfx/ikony/itemy/' .$item['lp'] .'.jpg border=2></center>' .$item['nazwa'] .' - ' .$item['opis'] .'<br><br><center>klasa przedmiotu: <b>' .$rare .'</b><br><br><form method=post action="?lokacja=item-szcz" style="float:right"><input type=submit value=" wyrzuc " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'><input type=hidden name=wyrzuc value=1><input type=hidden name=item value=' .$item['lp'] .'></form>' .$submit .'</center></div>';
}	
}
$dane=array(
	'lokacja'=> TloLokacji('szafa'), 
	'przyciski'=> '<TD><a href="?lokacja=itemy"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 