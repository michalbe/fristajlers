<?
include('conf/stats.php');


$dane=array(
	'lokacja'=> TloLokacji('dom'), 
	'przyciski'=> '<TD><a href="logout.php"><img src=gfx/lozko.jpg border=0 alt="Wyloguj"></a></TD><TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót"></a></TD>',
	'newsy' => '<div class="transp"> Wylogowac??</div>',
	'statsy' => $statsy );
	
?>