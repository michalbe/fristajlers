<?
include('conf/stats.php');

if (isset($_GET['trenuj'])) {

$statsWin = PrzekazStatsyBazowe($id);
	
		if ($statsWin[0]<46) {	## niedostateczna ilosc energii do treningu

		
		$newsy = "<font class=ziom>Niestety, jeste¶ za bardzo zmêczony. Wróæ tutaj kiedy trochê odpoczniesz.</font>";
		
		} else {
		$napiecieWin = $statsWin[6]-3;
		srand(time());
		$flowWin = $statsWin[4]+ceil($statsWin[4]*(rand(0, 6)/1000));
		$intWin = $statsWin[1]+ceil($statsWin[1]*(rand(0, 6)/1000));
		$wiedzaWin = $statsWin[3]+ceil($statsWin[3]*(rand(0, 6)/1000));
		$energiaWin = $statsWin[0]-45;
		
	$queryWin = "UPDATE F_stats SET flow='$flowWin', energia_aktualna='$energiaWin', inteligencja='$intWin', inteligencja_aktualna='$intWin' , wiedza='$wiedzaWin', napiecie='$napiecieWin', napiecie_aktualne='$napiecieWin' WHERE id='$id'"; 
			mysql_query($queryWin); 


		
		$newsy = "<font class=ziom> Widaæ, ¿e trening troche Ciê zmêczy³. Pamiêtaj jednak, ze aby zauwazyæ efekty treningu, musisz trenowaæ regularnie.</font>";
		

		}
	
	###  ZWRACA TABLICE $DANE BEZ PRZYCISKU TTRENOWANIA, PONIEWAZ ODBYL SIE TRENING	
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
} else {

		$newsy = "<font> Znasz dwa najbardziej znane na ¶wiecie powiedzenia? <b>\"Trening czyni mistrza\"</b>, oraz <b>\"Wszêdzie dobrze, ale w domu najlepiej\"</b>? Jaki z tego wniosek? Najlepiej trenowaæ w domu, przed w³asnym lustrem we w³asnej ³azience. </font>";
		


###  ZWRACA TABLICE $DANE Z PRZYCISKIEM TTRENOWANIA, PONIEWAZ NIE ODBYL SIE TRENING
$dane=array(
	'lokacja'=> TloLokacji($lokacja), 
	'przyciski'=> '<TD><a href="?lokacja=lazienka&trenuj"><img src=gfx/lazienka.jpg border=0 alt="Trenuj"></a></TD>
				   <TD><a href="?lokacja=dom"><img src=gfx/back.jpg border=0 alt="Powrót do Domu"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
}
	
?>