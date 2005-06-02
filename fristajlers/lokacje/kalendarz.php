<?
		if (isset($_POST['usun'])) {
		$zapytanie = "SELECT * FROM F_wyzwania WHERE nr='$usun'"; 
	    $wykonanie = mysql_query($zapytanie); 
		$tablica = mysql_fetch_array ($wykonanie);
		$queryDel = "DELETE FROM F_wyzwania WHERE nr='$usun' AND (id_kto='$id' OR id_kogo='$id')"; 
	    mysql_query($queryDel); 
				$tresc = pl_win2iso('Walka ' .Ksywka($tablica[1]) .' <b>vs</b> ' .Ksywka($tablica[2]) .' wyznaczona na ' .$tablica[3] .' zosta³a anulowana');
				PiszWiadomosc(0, $tablica[1], $tresc);
				PiszWiadomosc(0, $tablica[2], $tresc);

}
if (!isset($od)) { 
			$od = 0;
		}
		$queryIlosc = "SELECT count(*) FROM F_wyzwania WHERE id_kto='$id' OR id_kogo = '$id'"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);

		$query = "SELECT * FROM F_wyzwania WHERE id_kto='$id' OR id_kogo = '$id' ORDER BY kiedy, pora LIMIT $od,4"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font>Nie masz zaplanowanej zadnej walki.</font>';
		} else {
			$pierwsza_walka = 0;
			while ($rekord = mysql_fetch_array ($wynik)) {
					if ($rekord[6]=='0'){ $pora="08:00"; $go="8"; } elseif ($rekord[6]=='1') { $pora="16:00"; $go="16"; } else {$pora="24:00"; $go="24";} 
				if($rekord[5]==1) {
					if (($rekord[3]<date("Y-m-d") || (($rekord[3]==date("Y-m-d")) && ($go<date("H"))))) { 
					$stan = 'przeterminowana <center><table width=35% border=0 cellpadding=0 cellspacing=0><tr><td><form method=post action=main.php?lokacja=kalendarz><input type=hidden name=usun value=' .$rekord[0] .'><input type=image src=gfx/usun.png border=0 alt="zrezygnuj z walki" name=Submit> </form></td></tr></table></center>';
				} else { $stan='zaakceptowana';
					if (($pierwsza_walka==0) && ($od==0)) { $stan = $stan .'<center><table width=35% border=0 cellpadding=0 cellspacing=0><tr><td><form method=post action=main.php?lokacja=walka_opcje><input type=hidden name=nr value=' .$rekord[0] .'><input type=image src=gfx/opcje.png border=0 alt="walke" name=Submit></form></td></tr></table></center>'; $pierwsza_walka=1; } }
				} else {
					$stan='niezaakceptowana <center><table width=35% border=0 cellpadding=0 cellspacing=0><tr><td><form method=post action=main.php?lokacja=kalendarz><input type=hidden name=usun value=' .$rekord[0] .'><input type=image src=gfx/usun.png border=0 alt="zrezygnuj z walki" name=Submit> </form></td>';
				if ($rekord[2]==$id) { $stan = $stan .'<td><form method=post action=main.php?lokacja=l_akceptuj><input type=hidden name=id_kto value=' .$rekord[1] .'><input type=hidden name=id_kogo value=' .$rekord[2] .'><input type=hidden name=data value=' .$rekord[3] .'><input type=hidden name=pora value=' .$rekord[6] .'><input type=image src=gfx/akcept.png border=0 alt="zaakceptuj walke" name=Submit></form></td>'; if (($pierwsza_walka==0) && ($od==0))  { $stan = $stan .'<td><form method=post action=main.php?lokacja=walka_opcje><input type=hidden name=nr value=' .$rekord[0] .'><input type=image src=gfx/opcje.png border=0 alt="walke" name=Submit></form></td>'; $pierwsza_walka=1;}  $stan = $stan .'</tr></table></center>'; } else { $stan = $stan .'</td>'; if (($pierwsza_walka==0) && ($od==0))  { $stan=$stan .'<td><form method=post action=main.php?lokacja=walka_opcje><input type=hidden name=nr value=' .$rekord[0] .'><input type=image src=gfx/opcje.png border=0 alt="walke" name=Submit></form></td>'; $pierwsza_walka=1; } $stan=$stan .'</tr></table></center>'; }
				}
if ($rekord['liga']==1) { $liga = ' | <a href=?lokacja=cr>LIGOWA</a>'; } else { $liga=''; }
				$newsy = $newsy .'<font> - <b>' .$rekord[3] .' ' .$pora . $liga .'</b><br><a href=main.php?lokacja=o_profil&nr=' .$rekord[1] .'>' .Ksywka($rekord[1]) .'</a><b> vs</b><a href=main.php?lokacja=o_profil&nr=' .$rekord[2] .'> ' .Ksywka($rekord[2]) .'</a> || ' .$stan .'</font><br>';
			}
if ($od!=0) {
		$od2= $od-4;
	$newsy = $newsy .'<font><div align=left><a href=main.php?lokacja=kalendarz&od=' .$od2 .'> [<< poprzednie]</a></div></font>';
		}
		$ilosc=$ilosc[0]-4;
		if (!($od>=$ilosc)) {
		$od= $od+4;
	$newsy = $newsy .'<font><div align=right><a href=main.php?lokacja=kalendarz&od=' .$od .'>' .pl_win2iso("[nastepne >>]") .'</a></div></font>';
		}
		}





include('conf/stats.php');
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

	
?>