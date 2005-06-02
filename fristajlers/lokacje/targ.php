<?
include('conf/stats.php');


$query = "SELECT * FROM F_targ"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Brak przedmiotow na targu.</font>';
		} else {

###  WYSWIETLANIE PRODUKTOW

			$newsy = $newsy .'<font class=rapy>Kliknij aby zobaczyc szczegoly przedmiotu</font><table border=0 width=100%><tr>';
			$konter = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
				$konter++;
				$itemy=itemy($rekord['co']);
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

				$newsy = $newsy .'<td valign=top width=25%><a href="?lokacja=targ-szcz&lp=' .$rekord['lp'] .'"><center><img src="gfx/ikony/itemy/' .$itemy[0] .'.jpg" title="Sprzedawca: ' .Ksywka($rekord['kto']) .'"><br><font class=' .$rare .'><b>+</b></font><font class=rapy>' .$itemy['nazwa'] .' [' .$rekord['cena'] .'HJS]</font></a></center></td>';
			if ($konter == 4) { $newsy = $newsy .'</tr><tr>'; $konter = 0; }

			}
			$newsy = $newsy .'</tr></table>';
	}




$dane=array(
	'lokacja'=> TloLokacji('osiedle'), 
	'przyciski'=> '<TD width=80 height=39><center><a href=main.php?lokacja=targ-add><img src=gfx/itemy.jpg border=0 title="Sprzedaj przedmiot" ><TD width=80 height=39><center><a href=main.php?lokacja=osiedle><img src=gfx/back.jpg border=0 title="Wroc" ></a></center></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
	
?>