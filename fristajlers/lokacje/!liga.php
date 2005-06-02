<?
include('../conf/funkcje.php');
PolaczMysql();

	$query = "SELECT id FROM F_stats WHERE id <> '0' ORDER BY styl + energia + wiedza + inteligencja + flow - napiecie DESC"; 
        $wynik = mysql_query($query); 
		$konter=12;
		$liga = 1;
		while ($rekord = mysql_fetch_array($wynik)) {
		$id = $rekord['id'];
		if ($konter==12) { echo '<br><br>' .$liga .' LIGA<br>'; $liga++; $konter=0;}
		$querya = "SELECT wygrane, przegrane FROM F_walki WHERE id='$id'"; 
        $wynika = mysql_query($querya); 
		$rekorda = mysql_fetch_array ($wynika);
		$rekorda['przegrane'] = $rekorda['przegrane']+$rekorda['wygrane'];
		if ($rekorda['przegrane']>2) {
		echo Ksywka($id) .'(' .$id .')<br>';
				$konter++;		
		} else {

		}
}


?>