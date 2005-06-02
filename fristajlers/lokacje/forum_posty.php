<?
include('conf/stats.php');

$newsy = $newsy .'Posty w tym temacie:<br><br>';

		$query = "SELECT * FROM F_ForumModerator WHERE id_forum = '$forum' AND id_moderator='$id'"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) != 0) { $moder=1; }

if (!isset($pocz)) { 
			$pocz = 0;
		}

## TEMAT GLOWNY ####

		$query = "SELECT * FROM F_ForumTematy WHERE nr_tematu = '$temat'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array($wynik);
	$newsy = $newsy .pl_win2iso('<b>' .$rekord[temat] .'</b><br><br>');

if ($pocz == 0) { ## WYSWIETLANIE GLOWNEGO TEMATU TYLKO NA 1SZEJ STRONIE
	$newsy = $newsy .'<TABLE width=100%><TR><TD bgcolor=silver>';
	if ($moder==1) { $newsy = $newsy .'<a href=main.php?lokacja=forum_usun&forum=' .$forum .'&temat=' .$temat .'><img src=gfx/usun.png title="skasuj temat" border=0 width=15></a>  '; }
	$newsy = $newsy .'<B><a href=main.php?lokacja=o_profil&nr=' .$rekord[id_kto] .'><font class="ziom">' .Ksywka($rekord[id_kto]) .' </a>[' .$rekord[datatime] .'] napisal:</B></font></TD></TR>'; 
	$newsy = $newsy .'<TR><TD bgcolor=white><font style="color:black"> ' .$rekord[tresc] .'</font></TD></TR></TABLE>';
}

## POSTY DALSZE ####

	

	$query = "SELECT * FROM F_ForumPosty WHERE nr_tematu = '$temat' ORDER BY datatime"; 
        $wynik = mysql_query($query); 
		$newsy = $newsy .'<TABLE width=100%>';
		while($rekord = mysql_fetch_array($wynik)) {
	$newsy = $newsy .'<TR><TD bgcolor=silver>';
if ($moder==1) { $newsy = $newsy .'<a href=main.php?lokacja=forum_usun&forum=' .$forum .'&post=' .$rekord['nr_wyp'] .'><img src=gfx/usun.png title="skasuj post" border=0 width=15></a>  '; }
	$newsy = $newsy .'<B><a href=main.php?lokacja=o_profil&nr=' .$rekord[id_kto] .'><font class="ziom">' .Ksywka($rekord[id_kto]) .'</a> [' .$rekord[datatime] .'] napisal:</B></font></TD></TR>'; 
	$newsy = $newsy .pl_win2iso('<TR><TD bgcolor=white><font style="color:black"> ' .$rekord['tresc'] .'</font></TD></TR>');
		}		
		
	$newsy = $newsy .'</TABLE>';






$dane=array(
	'lokacja'=> TloLokacji('o_szukaj'), 
	'przyciski'=> '<TD><a href=main.php?lokacja=forum_dodaj&forum=' .$forum .'&temat=' .$temat .'><img src=gfx/dyskusja.jpg border=0 title="Dodaj post w tym temacie"></a></TD>
<TD><a href=main.php?lokacja=forum_tematy&forum=' .$forum .'><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp" style="overflow:auto">' .$newsy .'</div>',
	'statsy' => $statsy );
?>