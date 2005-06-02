<?
include('conf/stats.php');

if (isset($_GET['nr'])) {
$query = "SELECT co, id_kto, data FROM F_poczta WHERE nr_wiad='$nr' AND id_do='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$queryWiad = "UPDATE F_poczta SET czytane='1' WHERE nr_wiad='$nr'"; 
		 mysql_query($queryWiad); 
	if (mysql_num_rows($wynik) != 0) {
					$newsy = $newsy .pl_win2iso('<img src="wyglad/' .Logo($rekord['id_kto']) .'.jpg" width=55 border=2><br><font><b>' .Ksywka($rekord['id_kto']) .' || ' .$rekord['data'] .'</b> napisal:<br><br>' .$rekord['co'] .'</font>');
	}
		

} else {


if (isset($_GET['usun'])) {
		$queryDel = "DELETE FROM F_poczta WHERE nr_wiad='$usun' AND id_do='$id'"; 
	    mysql_query($queryDel); 

}
$newsy = $newsy .'<font size=-1>&nbsp; Tutaj sprawdzasz swoje listy.</font><br><br>';
	if (!isset($pocz)) { 
			$pocz = 0;
		}


		$query = "SELECT * FROM F_poczta WHERE id_do='$id' oRDER BY nr_wiad DESC LIMIT $pocz, 14"; 
        $wynik = mysql_query($query); 

		$queryIlosc = "SELECT count(*) FROM F_poczta WHERE id_do='$id'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);

		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>&nbsp;Nie masz zadnych wiadomosci w skrzynce</font>';
		} else {
			$newsy = $newsy .'<font size=-2>&nbsp;Wiadomosci</font><table border=0 width=240><tr><td>';
		while ($rekord = mysql_fetch_array ($wynik)) {
			if ($rekord[5] ==0) { $newsy = $newsy .'<b>'; }
			$newsy = $newsy .'<font size=-1><a href=main.php?lokacja=poczta&nr=' .$rekord[0] .'> + Od ' .Ksywka($rekord[1]) .'</font><font size=-2> /' .$rekord[3] .'</a></font><br>';
			if ($rekord[5] ==0) { $newsy = $newsy .'</b>'; }
			}
		$newsy = $newsy .'</td></tr></table><br>';

if ($pocz!=0) {
		$pocz2= $pocz-14;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=poczta&pocz=' .$pocz2 .'> [<< poprzednie]</a></div></font>';
		}
		$ilosc=$ilosc[0]-14;
		if (!($pocz>=$ilosc)) {
		$pocz= $pocz+14;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=poczta&pocz=' .$pocz .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}

		}
}


	if (!isset($nr)) {
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD width=80 height=39><a href=main.php?lokacja=poczta_czysc><img src=gfx/kosz.jpg border=0 title="Oproznij skrzynke"></a>
				</TD><TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
		} else {
if ($rekord['id_kto'] != 0) {
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD width=80 height=39><a href=main.php?lokacja=pisz&iddo=' .$rekord['id_kto'] .'><img src=gfx/poczta.jpg border=0 title="Odpowiedz" ></a></TD><TD width=80 height=39><a href=main.php?lokacja=poczta&usun=' .$nr  .'><img src=gfx/kosz.jpg border=0 title="Usun" ></a></TD><TD><a href="?lokacja=poczta"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
			} else {
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD width=80 height=39><a href=main.php?lokacja=poczta&usun=' .$nr  .'><img src=gfx/kosz.jpg border=0 title="Usun" ></a></TD><TD><a href="?lokacja=poczta"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
}
}

?>