<?
include('conf/stats.php');

		$query = "SELECT id_moderator, id_forum FROM F_ForumModerator"; 
        $wynik = mysql_query($query); 
		while ($rekord = mysql_fetch_array ($wynik)) {
			switch ($rekord['id_forum']) {
				case 1:
				$moderatorzy1 = $moderatorzy1 .Ksywka($rekord['id_moderator']) .', ';
				break;
				case 2:
				$moderatorzy2 = $moderatorzy2 .Ksywka($rekord['id_moderator']) .', ';
				break;
				case 3:
				$moderatorzy3 = $moderatorzy3 .Ksywka($rekord['id_moderator']) .', ';
				break;
				case 4:
				$moderatorzy4 = $moderatorzy4 .Ksywka($rekord['id_moderator']) .', ';
				break;
				case 5:
				$moderatorzy5 = $moderatorzy5 .Ksywka($rekord['id_moderator']) .', ';
				break;
			}
		}


$newsy = $newsy .'Dostepne tematy dyskusji:';
		$queryIlosc = "SELECT count(*) FROM F_ForumTematy WHERE nr_fora=1"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$ilosc1 = $ilosc[0];
				$queryIlosc = "SELECT count(*) FROM F_ForumTematy WHERE nr_fora=2"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$ilosc2 = $ilosc[0];
				$queryIlosc = "SELECT count(*) FROM F_ForumTematy WHERE nr_fora=3"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$ilosc3 = $ilosc[0];
				$queryIlosc = "SELECT count(*) FROM F_ForumTematy WHERE nr_fora=4"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$ilosc4 = $ilosc[0];
				$queryIlosc = "SELECT count(*) FROM F_ForumTematy WHERE nr_fora=5"; 
        $wynikIlosc = mysql_query($queryIlosc); 
		$ilosc = mysql_fetch_array ($wynikIlosc);
		$ilosc5 = $ilosc[0];


$newsy = $newsy .'<br><br><br>
<TABLE width=100%>
<TR>
	<TD><font><b><a href=main.php?lokacja=forum_tematy&forum=1>Walki</a></b> - <i> wszystko na temat walk. Umow sie na walke, skomentuj jakas, ktora zrobila na Tobie wrazenie, itp. </i> [tematow: <b>' .$ilosc1 .'</b>]<div align=right>Moderatorzy: <b>' .$moderatorzy1 .'</b></div></font><br></TD>
</TR>
<TR>
	<TD><font><b><a href=main.php?lokacja=forum_tematy&forum=2>Problemy</a></b> - <i> z gra. Wszystko, o co chcielibyscie zapytac. </i> [tematow: <b>' .$ilosc2 .'</b>]<div align=right>Moderatorzy: <b>' .$moderatorzy2 .'</b></div></font><br></TD>
</TR>
<TR>
	<TD><font><b><a href=main.php?lokacja=forum_tematy&forum=3>Bledy</a></b> - <i> znalezione przez Was bledy w systemie </i> [tematow: <b>' .$ilosc3 .'</b>]<div align=right>Moderatorzy: <b>' .$moderatorzy3 .'</b></div></font><br></TD>
</TR>
<TR>
	<TD><font><b><a href=main.php?lokacja=forum_tematy&forum=4>Propozycje</a></b> - <i> rozwoju gry. Masz jaki dobry pomysl? Uderzaj tutaj.</i> [tematow: <b>' .$ilosc4 .'</b>]<div align=right>Moderatorzy: <b>' .$moderatorzy4 .'</b></div></font><br></TD>
</TR>
<TR>
	<TD><font><b><a href=main.php?lokacja=forum_tematy&forum=5>DupaSra</a></b> - <i> taki nasz maly Hydepark, czyli wszystko o wszystkim. </i> [tematow: <b>' .$ilosc5 .'</b>]<div align=right>Moderatorzy: <b>' .$moderatorzy5 .'</b></div></font><br></TD>
</TR>
</TABLE>';


$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<TD><a href="?lokacja=osiedle"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
?>