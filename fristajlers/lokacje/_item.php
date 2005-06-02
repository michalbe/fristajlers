<?
if((PelneInv($id)==1) && (Znalazl($id)==0)) {
srand(time());
$randomm = rand(0, 6);
if (($randomm!=1) && ($randomm!=2) && ($randomm!=3) && ($randomm!=4)) {
DodajZnalazl($id);
} elseif (($randomm==3) && ($randomm==4))  {
} else {
$item = LosujPrzedmiot($id);
$item = Itemy($item);
DodajZnalazl($id);
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
$przed = '<div class=przed><center><b>ZNALAZLES PRZEDMIOT!</b><br/><img src=gfx/ikony/itemy/' .$item['lp'] .'.jpg border=2></center>' .$item['nazwa'] .' - ' .$item['opis'] .'<br><br><center>klasa przedmiotu: <b>' .$rare .'</b></center><br><font class=rapy>przedmiot zostal przeniesiony do szafy w Twoim domu.</font></div>';
$query = "INSERT INTO F_skrytkaItemy (id_kto, typTowaru) VALUES ('$id', '$item[lp]')"; 
mysql_query($query);
}
}



?>