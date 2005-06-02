<?
include('conf/stats.php');

$nr=$_POST['nr'];


$zapytanie = "SELECT * FROM F_wyzwania WHERE nr='$nr'"; 
	    $wykonanie = mysql_query($zapytanie); 
		$tablica = mysql_fetch_array ($wykonanie);

if (isset($_POST['submit'])) {

	if ($id==$tablica['id_kto']) {
		$query = "UPDATE F_wyzwania SET punche1='$_POST[punche]', dynamika1='$_POST[dynamika]' WHERE nr='$nr'"; 
	} elseif ($id==$tablica['id_kogo']) {
		$query = "UPDATE F_wyzwania SET punche2='$_POST[punche]', dynamika2='$_POST[dynamika]' WHERE nr='$nr'"; 
	}
	    $wykonanie = mysql_query($query); 
$newsy = $newsy .'Opcje zostaly zapamietane';
    
} else {
		

	if ($id==$tablica['id_kto']) {
		$punche_akt = $tablica['punche1'];
		$dynamika_akt = $tablica['dynamika1'];
	} elseif ($id==$tablica['id_kogo']) {
		$punche_akt = $tablica['punche2'];
		$dynamika_akt = $tablica['dynamika2'];
	}

		$newsy = $newsy .'<br><br><center>Opcje walki ' .Ksywka($tablica[1]) .' <b>vs</b> ' .Ksywka($tablica[2]) .' wyznaczonej na ' .$tablica[3] .'</center>';

$query = "SELECT styl FROM F_stats WHERE id='$id'"; 
        $wynik = mysql_query($query); 
		$rekord = mysql_fetch_array ($wynik);
		$pkt_stylu = $rekord['styl'];
if ((0<$pkt_stylu) && ($pkt_stylu<=2500)) { $ile_mozna = 2; }
if ((2500<$pkt_stylu) && ($pkt_stylu<=5000)) { $ile_mozna = 3; }
if ((5000<$pkt_stylu) && ($pkt_stylu<=10000)) { $ile_mozna = 4; }
if (10000<$pkt_stylu) { $ile_mozna = 6; }

$newsy = $newsy .'<br><br><form method=post action=main.php?lokacja=walka_opcje><font size=-2 class=ziom>Wybierz dynamike&nbsp;</font><select name=dynamika>
		<option value=0'; if ($dynamika_akt==0) { $newsy = $newsy .' selected'; } $newsy = $newsy .'> Wolno spokojnie </option> 
		<option value=1'; if ($dynamika_akt==1) { $newsy = $newsy .' selected'; } $newsy = $newsy .'> Srednioszybko </option> 
		<option value=2'; if ($dynamika_akt==2) { $newsy = $newsy .' selected'; } $newsy = $newsy .'> Plynnie i dynamicznie </option> </select>
<br><br>
<font size=-2 class=ziom>Wybierz ilosc punchy &nbsp;</font><select name=punche>';

		$querya = "SELECT punche FROM F_stats WHERE id='$id' AND punche <> 0"; 
        $wynika = mysql_query($querya); 
		$rekorda = mysql_fetch_array ($wynika);
		$ile_jest = $rekorda['punche'];
if ($ile_mozna>$ile_jest) { $ile_mozna=$ile_jest; }

for ($i=0;$i<=$ile_mozna;$i++) {
	$newsy = $newsy .'<option value=' .$i;  if ($punche_akt==$i) { $newsy = $newsy .' selected'; } $newsy = $newsy .'>' .$i .'</option>'; 	
}


$newsy = $newsy.'</select><br><br><input type=hidden name=nr value=' .$nr .'><input value="akceptuj zmiany" type=submit name=submit style="font-size:10px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif; background:#006666; border: 1px solid #003333;"></form>';
}


$dane=array(
	'lokacja'=> TloLokacji('kalendarz'), 
	'przyciski'=> '<TD><a href="?lokacja=kalendarz"><img src=gfx/back.jpg border=0 title="Powrot"></a></TD>',
	'newsy' => '<div class="transp">' .$newsy .'</div>',
	'statsy' => $statsy );
?>