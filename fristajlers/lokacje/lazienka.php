<?
include('conf/stats.php');

if (isset($_GET['trenuj'])) {

$statsWin = PrzekazStatsyBazowe($id);
	
		if ($statsWin[0]<46) {	## niedostateczna ilosc energii do treningu

		
		$newsy = "<font class=ziom>Niestety, jeste� za bardzo zm�czony. Wr�� tutaj kiedy troch� odpoczniesz.</font>";
		
		} else {
		$napiecieWin = $statsWin[6]-3;
		srand(time());
		$flowWin = $statsWin[4]+ceil($statsWin[4]*(rand(0, 6)/1000));
		$intWin = $statsWin[1]+ceil($statsWin[1]*(rand(0, 6)/1000));
		$wiedzaWin = $statsWin[3]+ceil($statsWin[3]*(rand(0, 6)/1000));
		$energiaWin = $statsWin[0]-45;
		
	$queryWin = "UPDATE F_stats SET flow='$flowWin', energia_aktualna='$energiaWin', inteligencja='$intWin', inteligencja_aktualna='$intWin' , wiedza='$wiedzaWin', napiecie='$napiecieWin', napiecie_aktualne='$napiecieWin' WHERE id='$id'"; 
			mysql_query($queryWin); 


		
		$newsy = "<font class=ziom> Wida�, �e trening troche Ci� zm�czy�. Pami�taj jednak, ze aby zauwazy� efekty treningu, musisz trenowa� regularnie.</font>";
		

		}
	
	###  ZWRACA TABLICE $DANE BEZ PRZYCISKU TTRENOWANIA, PONIEWAZ ODBYL SIE TRENING	
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powr�t do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
} else {

		$newsy = "<font> Znasz dwa najbardziej znane na �wiecie powiedzenia? <b>\"Trening czyni mistrza\"</b>, oraz <b>\"Wsz�dzie dobrze, ale w domu najlepiej\"</b>? Jaki z tego wniosek? Najlepiej trenowa� w domu, przed w�asnym lustrem we w�asnej �azience. </font>";
		


###  ZWRACA TABLICE $DANE Z PRZYCISKIEM TTRENOWANIA, PONIEWAZ NIE ODBYL SIE TRENING
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=lazienka&trenuj"><img src=gfx/lazienka.jpg border=0 alt="Trenuj"></a></TD>
				   <TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powr�t do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
}
	
?>