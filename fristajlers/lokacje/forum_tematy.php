<?
include('conf/stats.php');
$newsy = $newsy .pl_win2iso('Dostepne tematy w tym forum:<br><br>');
if (!isset($pocz)) { 
			$pocz = 0;
		}


	$newsy = $newsy .'<TABLE width=90%><TR><TD bgcolor=silver><font class="ziom"><B>Temat</B></font></TD><TD bgcolor=silver><font class="ziom"><B>Autor</B></font></TD><TD bgcolor=silver><font class="ziom"><B>Data zalozenia</B></font></TD><TD bgcolor=silver><font class="ziom"><B>Ilosc postow</B></font></TD></TR>';
		
		
		$query = "SELECT * FROM F_ForumTematy WHERE nr_fora = '$_GET[forum]' ORDER BY ost_temat DESC"; 
        $wynik = mysql_query($query); 
		while($rekord = mysql_fetch_array ($wynik)) {

			$queryIlosc = "SELECT count(*) FROM F_ForumPosty WHERE nr_tematu = '$rekord[nr_tematu]'"; 
			$wynikIlosc = mysql_query($queryIlosc); 
			$ilosc = mysql_fetch_array ($wynikIlosc);
			$newsy = $newsy .'<TR><TD><font><b><a href=main.php?lokacja=forum_posty&temat=' .$rekord[nr_tematu] .'&forum=' .$_GET[forum] .'>' .substr($rekord[temat], 0, 30) .'...</a></b></font></TD><TD><font><b><a href=main.php?lokacja=o_profil&nr=' .$rekord[id_kto] .'>' .Ksywka($rekord[id_kto]) .'</a></b></font></TD><TD><font>' .$rekord[datatime] .'</font></TD><TD><font><center>'. $ilosc[0] .'</center></font></TD></TR>';
		}

	$newsy = $newsy .'</TABLE>';

$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<TD><a href="?lokacja=forum_nowy_temat&forum=' .$forum .'"><img src=gfx/dyskusja.jpg border=0 title="Dodaj temat"></a></TD>
<TD><a href="?lokacja=forum"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
?>