<?
include('conf/stats.php');
		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

	if ((700<$pkt_stylu)){
$przyciski = '	<TD width=80 height=39><center><a href=main.php?lokacja=o_mistrz><img src=gfx/mistrz.jpg border=0 title="Mistrz stylu" ></a></center></TD>';
}

include('_item.php');

$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD width=80 height=39><center><a href=main.php?lokacja=o_dilerka><img src=gfx/samara.jpg border=0 title="Narko yo." ></a></center></TD>
	<TD width=80 height=39><center><a href=main.php?lokacja=o_ekipa><img src=gfx/ekipa.jpg border=0 title="Stworz ekipe lub zarzadzaj istniejaca" ></a></center></TD>
	<TD width=80 height=39><center><a href=main.php?lokacja=forum><img src=gfx/dyskusja.jpg border=0 title="Podyskutuj z innymi" ></a></center></TD>
	<TD width=80 height=39><center><a href=main.php?lokacja=targ><img src=gfx/itemy.jpg border=0 title="Kup lub sprzedaj przedmioty" ></a></center></TD>	<TD width=80 height=39><center><a href=main.php?lokacja=o_szukaj><img src=gfx/o_szukaj.jpg border=0 title="Szukaj fristajlowca" ></a></center></TD>' .$przyciski .'
	<TD width=80 height=39><center><a href=main.php?lokacja=miasto><img src=gfx/back.jpg border=0 title="Wroc do miasta" ></a></center></TD>',
	'newsy' => $przed,
	'statsy' => $statsy );
	
?>