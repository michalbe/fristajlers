<?
include('conf/stats.php');

$newsy = $newsy .'<font size=-1> Tutaj znajduja sie kasety z ostatnimi walkami stoczonymi przez Ciebie. </font><br><br>';


		$query = "SELECT * FROM F_archiwum WHERE id_kto='$id' OR id_zkim = '$id' ORDER BY nr_walki DESC LIMIT 0,19"; 
        $wynik = mysql_query($query); 
		if (mysql_num_rows($wynik) == 0) {
			$newsy = $newsy .'<font size=-2>Nie stoczyłeś jeszcze źadnej walki.</font>';
		} else {
		
			while ($rekord = mysql_fetch_array ($wynik)) {
				$newsy = $newsy .'<font size=-2><a href=main.php?lokacja=walka_o&skad=tv&nr=' .$rekord[0] .'> + ' .Ksywka($rekord[1]) .' <b>vs</b> ' .Ksywka($rekord[2]) .' /<i> ' .$rekord[5] .'</i></a></font><br>';
			}
		}



$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );

	
?>