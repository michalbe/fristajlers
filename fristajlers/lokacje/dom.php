<?
include('conf/stats.php');


$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=lazienka"><img src=gfx/lazienka.jpg border=0 alt="Lazienka"></a></TD>
				   <TD><a href="?lokacja=kalendarz"><img src=gfx/kalendarz.jpg border=0 alt="Kalendarz"></a></TD>
				   <TD><a href="?lokacja=tv"><img src=gfx/tv.jpg border=0 alt="TV"></a></TD>
				   <TD><a href="?lokacja=lodowka"><img src=gfx/lodowka.jpg border=0 alt="Lodowka"></a></TD>
				   <TD><a href="?lokacja=szafa"><img src=gfx/szafa.jpg border=0 alt="Szafa"></a></TD>
				   <TD><a href="?lokacja=poczta"><img src=gfx/poczta.jpg border=0 alt="Poczta"></a></TD>
				   <TD><a href="?lokacja=lozko"><img src=gfx/lozko.jpg border=0 alt="Lozko"></a></TD>
				   <TD><a href="?lokacja=miasto"><img src=gfx/back.jpg border=0 alt="Powrót do Miasta"></a></TD>',
	'newsy' => '',
	'statsy' => $statsy );
	
?>