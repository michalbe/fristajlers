<?
include('conf/stats.php');


$query = "SELECT typTowaru FROM F_skrytkaItemy WHERE id_kto='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Nie masz przedmiotow na sprzedaz. Jesli chcesz sprzedac przedmiot z ekwipunku, najpierw odnies go do szafy.</font>';
		} else {

###  WYSWIETLANIE PRODUKTOW

			$newsy = $newsy .'<font class=rapy>Kliknij aby zobaczyc szczegoly przedmiotu</font><table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
				$itemy=itemy($rekord['typTowaru']);
switch ($itemy['rare']) {
	case 1:
		$rare = 'kiepska';
	break;
	case 2:
		$rare = 'slaba';
	break;
	case 3:
		$rare = 'neutralna';
	break;
	case 4:
		$rare = 'dobra';
	break;
	case 5:
		$rare = 'mistrzowa';
	break;
}

				$newsy = $newsy .'<td valign=top width=25%><a href="main.php?lokacja=item-add-szcz&item=' .$itemy[0] .'"><center><img src="gfx/ikony/itemy/' .$itemy[0] .'.jpg" title="' .$itemy['opis'] .'"><br><font class=' .$rare .'><b>+</b></font><font class=rapy>' .$itemy['nazwa'] .'</font></a></center></td>';
			if ($konter == 4) { $newsy = $newsy .'</tr><tr>'; $konter = 0; }

			}
			$newsy = $newsy .'</tr></table>';
	}


	

$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<TD><a href="?lokacja=targ"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

?>