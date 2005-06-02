<?
include('conf/stats.php');

$query = "SELECT * FROM F_targ WHERE lp='$lp'"; 
$wynik = mysql_query($query); 
	if (mysql_num_rows($wynik) == 0) {

			$przed = $przed .'<div class=przed>ERROR.<br></div>';  #### blokowanie kupowania w sklepie którego nei ma :]

		} else {
$rekord = mysql_fetch_array ($wynik);
$item = Itemy($rekord['co']);
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
if ($item['jednorazowy']==1) { $rare = 'jednorazowy, ' .$rare; }
$przed = '<div class=przed><center><b>KUP PRZEDMIOT OD <a href=?lokacja=o_profil&nr='.$rekord['kto'] .'>' .Ksywka($rekord['kto']) .'</a></b><br/><img src=gfx/ikony/itemy/' .$item['lp'] .'.jpg border=2></center>' .$item['nazwa'] .' - ' .$item['opis'] .'<br><br><center>cena: ' .$rekord['cena'] .'HJS, klasa przedmiotu: <b>' .$rare .'</b><br><br><form method=post action="?lokacja=targ-sell" style="float:right"><input type=submit value=" kup " style=\'padding:2px; background:#006666; border: 1px solid #003333; font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;\'><input type=hidden name=lp value=' .$rekord['lp'] .'></form></center></div>';

}
$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<TD><a href="?lokacja=targ"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );

?> 