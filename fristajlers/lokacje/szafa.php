<?
include('conf/stats.php');
		$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];

/*	if ((700<$pkt_stylu)){
$przyciski = '	<TD width=80 height=39><center><a href=main.php?lokacja=skrytka_bron><img src=gfx/bron.jpg border=0 title="Skrytka na bron" ></a></center></TD>';
}

*/
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD width=80 height=39><center><a href=main.php?lokacja=samara><img src=gfx/samara.jpg border=0 title="Narko yo." ></a></center></TD><TD width=80 height=39><center><a href=main.php?lokacja=itemy><img src=gfx/itemy.jpg border=0 title="Przedmioty" ></a></center></TD>' .$przyciski .'
	<TD width=80 height=39><center><a href=main.php?lokacja=dom><img src=gfx/back.jpg border=0 title="Wroc do domu" ></a></center></TD>',
	'newsy' => '',
	'statsy' => $statsy );
	
?> 